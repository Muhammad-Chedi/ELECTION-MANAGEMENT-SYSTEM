<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);



include 'database.php';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all LGAs in Delta State
$lgaQuery = "SELECT lga_id, lga_name FROM lga WHERE state_id = 25 ORDER BY lga_name";
$lgaResult = $conn->query($lgaQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LGA Election Results</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h3>Summed Polling Unit Results by LGA</h3>
</div>

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-8">

<select name="lga" class="form-select" required>

<option value="">Select Local Government</option>

<?php
while($row = $lgaResult->fetch_assoc())
{
?>

<option
value="<?php echo $row['lga_id']; ?>"
<?php
if(isset($_GET['lga']) && $_GET['lga']==$row['lga_id'])
echo "selected";
?>
>

<?php echo $row['lga_name']; ?>

</option>

<?php
}
?>

</select>

</div>

<div class="col-md-4">

<button class="btn btn-success w-100">

View Result

</button>

</div>

</div>

</form>

<hr>

<?php

if(isset($_GET['lga']) && !empty($_GET['lga']))
{

$lga = intval($_GET['lga']);

$sql = "

SELECT

p.partyname,

SUM(a.party_score) AS total_score

FROM announced_pu_results a

INNER JOIN polling_unit pu
ON a.polling_unit_uniqueid = pu.uniqueid

INNER JOIN party p
ON a.party_abbreviation = p.partyid

WHERE pu.lga_id = ?

GROUP BY a.party_abbreviation

ORDER BY total_score DESC

";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i",$lga);

$stmt->execute();

$result = $stmt->get_result();

?>

<h4 class="mb-3">Election Result</h4>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>S/N</th>

<th>Party</th>

<th>Total Votes</th>

</tr>

</thead>

<tbody>

<?php

$count = 1;
$totalVotes = 0;

while($row = $result->fetch_assoc())
{

$totalVotes += $row['total_score'];

?>

<tr>

<td><?php echo $count++; ?></td>

<td><?php echo $row['partyname']; ?></td>

<td><?php echo number_format($row['total_score']); ?></td>

</tr>

<?php

}

?>

<tr class="table-primary">

<th colspan="2">

Grand Total Votes

</th>

<th>

<?php echo number_format($totalVotes); ?>

</th>

</tr>

</tbody>

</table>

<?php

}

?>

</div>

</div>

</div>

</body>
</html>
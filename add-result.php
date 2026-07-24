<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'database.php';

/*
|--------------------------------------------------------------------------
| Save Result
|--------------------------------------------------------------------------
*/

$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $pollingUnit = $_POST['polling_unit'];
    $enteredBy = trim($_POST['entered_by']);
    $dateEntered = date("Y-m-d H:i:s");
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    $conn->begin_transaction();

    try {

        foreach ($_POST['score'] as $party => $score) {

            $stmt = $conn->prepare("
                INSERT INTO announced_pu_results
                (
                    polling_unit_uniqueid,
                    party_abbreviation,
                    party_score,
                    entered_by_user,
                    date_entered,
                    user_ip_address
                )

                VALUES
                (
                    ?, ?, ?, ?, ?, ?
                )
            ");

            $stmt->bind_param(
                "ssisss",
                $pollingUnit,
                $party,
                $score,
                $enteredBy,
                $dateEntered,
                $ipAddress
            );

            $stmt->execute();
        }

        $conn->commit();

        $message = "
        <div class='alert alert-success'>
            Results Saved Successfully
        </div>
        ";

    } catch(Exception $e){

        $conn->rollback();

        $message = "
        <div class='alert alert-danger'>
            ".$e->getMessage()."
        </div>";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Polling Unit Result</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        function loadWards() {
            var lga = document.getElementById("lga").value;

            fetch("get_locations.php?type=ward&lga=" + lga)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("ward").innerHTML = data;
                    document.getElementById("polling_unit").innerHTML =
                        "<option value=''>Select Polling Unit</option>";
                });
        }

        function loadPollingUnits() {
            var ward = document.getElementById("ward").value;

            fetch("get_locations.php?type=polling&ward=" + ward)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("polling_unit").innerHTML = data;
                });
        }
    </script>

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">
<h3>Add New Polling Unit Result</h3>
</div>

<div class="card-body">

<?= $message ?>

<form method="POST">

<div class="row">

<div class="col-md-4">

<label class="form-label">Local Government</label>

<select
name="lga"
id="lga"
class="form-select"
onchange="loadWards()"
required>

<option value="">Select LGA</option>

<?php

$lga = $conn->query("
SELECT lga_id,lga_name
FROM lga
WHERE state_id=25
ORDER BY lga_name
");

while($row=$lga->fetch_assoc())
{
?>

<option value="<?= $row['lga_id'] ?>">

<?= $row['lga_name'] ?>

</option>

<?php } ?>

</select>

</div>


<div class="col-md-4">

<label class="form-label">

Ward

</label>

<select
name="ward"
id="ward"
class="form-select"
onchange="loadPollingUnits()"
required>

<option>

Select Ward

</option>

</select>

</div>


<div class="col-md-4">

<label class="form-label">

Polling Unit

</label>

<select
name="polling_unit"
id="polling_unit"
class="form-select"
required>

<option>

Select Polling Unit

</option>

</select>

</div>

</div>

<hr>

<div class="mb-3">

<label>

Entered By

</label>

<input
type="text"
name="entered_by"
class="form-control"
required>

</div>

<h4 class="mb-3">

Party Scores

</h4>

<div class="row">

<?php

$party = $conn->query("SELECT * FROM party ORDER BY partyname");

while($p = $party->fetch_assoc())
{

?>

<div class="col-md-4 mb-3">

<label>

<?= $p['partyname'] ?>

</label>

<input
type="number"
name="score[<?= $p['partyid'] ?>]"
class="form-control"
value="0"
min="0"
required>

</div>

<?php } ?>

</div>

<button class="btn btn-success">

Save Results

</button>

</form>

</div>

</div>

</div>

</body>
</html>
<?php
include 'database.php';
// Build an array of stored LGA results
$storedResults = [];

$stmt = $conn->prepare("
    SELECT party_abbreviation, party_score
    FROM announced_lga_results
    WHERE lga_name = ?
");

$stmt->bind_param("i", $lga);
$stmt->execute();

$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $storedResults[$row['party_abbreviation']] = $row['party_score'];
}
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Party</th>
            <th>Calculated Total</th>
            <th>Stored LGA Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>

<?php
while ($row = $result->fetch_assoc()) {

    $stored = $storedResults[$row['party_abbreviation']] ?? 0;
    $status = ($stored == $row['calculated_total']) ? "✅ Match" : "❌ Different";
?>
<tr>
    <td><?= $row['partyname']; ?></td>
    <td><?= number_format($row['calculated_total']); ?></td>
    <td><?= number_format($stored); ?></td>
    <td><?= $status; ?></td>
</tr>
<?php } ?>

    </tbody>
</table>
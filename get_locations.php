<?php

include 'config/database.php';

if (!isset($_GET['type'])) {
    exit();
}

$type = $_GET['type'];

// | LOAD WARDS


if ($type == "ward") {

    $lga = intval($_GET['lga']);

    $sql = "SELECT ward_id, ward_name
            FROM ward
            WHERE lga_id = ?
            ORDER BY ward_name";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lga);
    $stmt->execute();

    $result = $stmt->get_result();

    echo "<option value=''>Select Ward</option>";

    while ($row = $result->fetch_assoc()) {

        echo "<option value='".$row['ward_id']."'>".$row['ward_name']."</option>";

    }

}



if ($type == "polling") {

    $ward = intval($_GET['ward']);

    $sql = "SELECT uniqueid, polling_unit_name
            FROM polling_unit
            WHERE ward_id = ?
            ORDER BY polling_unit_name";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ward);
    $stmt->execute();

    $result = $stmt->get_result();

    echo "<option value=''>Select Polling Unit</option>";

    while ($row = $result->fetch_assoc()) {

        echo "<option value='".$row['uniqueid']."'>".$row['polling_unit_name']."</option>";

    }

}
<?php
include 'database.php';

// Total LGAs
$lga = $conn->query("SELECT COUNT(*) AS total FROM lga WHERE state_id=25");
$totalLGA = $lga->fetch_assoc()['total'];

// Total Wards
$ward = $conn->query("SELECT COUNT(*) AS total FROM ward");
$totalWard = $ward->fetch_assoc()['total'];

// Total Polling Units
$pu = $conn->query("SELECT COUNT(*) AS total FROM polling_unit");
$totalPU = $pu->fetch_assoc()['total'];

// Total Parties
$party = $conn->query("SELECT COUNT(*) AS total FROM party");
$totalParty = $party->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Bincom Election Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f7fa;
}

.card{
    border:none;
    border-radius:15px;
}

.card h2{
    font-weight:bold;
}

.navbar-brand{
    font-weight:bold;
}

</style>

</head>

<body>

<nav class="navbar navbar-dark bg-primary">

<div class="container">

<a class="navbar-brand">

BINCOM ELECTION MANAGEMENT SYSTEM

</a>

</div>

</nav>


<div class="container mt-5">

<div class="row">

<div class="col-md-3">

<div class="card bg-primary text-white shadow">

<div class="card-body text-center">

<h2><?= $totalLGA ?></h2>

<p>Total LGAs</p>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card bg-success text-white shadow">

<div class="card-body text-center">

<h2><?= $totalWard ?></h2>

<p>Total Wards</p>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card bg-warning text-dark shadow">

<div class="card-body text-center">

<h2><?= $totalPU ?></h2>

<p>Total Polling Units</p>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card bg-danger text-white shadow">

<div class="card-body text-center">

<h2><?= $totalParty ?></h2>

<p>Political Parties</p>

</div>

</div>

</div>

</div>

<hr class="my-5">


<div class="row">

<div class="col-md-6">

<div class="card shadow">

<div class="card-header bg-dark text-white">

Question 2

</div>

<div class="card-body">

<h5>Summed Result By Local Government</h5>

<p>
Display the total result of all polling units under a selected Local Government.
</p>

<a href="lga-result.php" class="btn btn-primary">

Open Page

</a>

</div>

</div>

</div>


<div class="col-md-6">

<div class="card shadow">

<div class="card-header bg-dark text-white">

Question 3

</div>

<div class="card-body">

<h5>Add New Polling Unit Result</h5>

<p>

Enter election results for all political parties in a polling unit.

</p>

<a href="add-result.php" class="btn btn-success">

Open Page

</a>

</div>

</div>

</div>

</div>


<hr class="my-5">

<div class="card shadow">

<div class="card-header bg-secondary text-white">

About Project

</div>

<div class="card-body">

</div>

</div>

</div>

</body>

</html>
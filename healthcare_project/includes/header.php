<?php
if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit;
}

$base_url = "http://localhost/healthcare_project/";
?>

<!DOCTYPE html>

<html>

<head>

<title>Healthcare System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">

<div class="container">

<a class="navbar-brand"
href="<?= $base_url ?>dashboard.php">

Healthcare Management       

</a>

<div>

<a href="<?= $base_url ?>patients/list.php"
class="btn btn-light btn-sm">
Patients
</a>

<a href="<?= $base_url ?>visits/list.php"
class="btn btn-light btn-sm">
Visits
</a>

<a href="<?= $base_url ?>reports/summary.php"
class="btn btn-light btn-sm">
Summary
</a>

<a href="<?= $base_url ?>reports/followups.php"
class="btn btn-light btn-sm">
Followups
</a>

<a href="<?= $base_url ?>reports/monthly.php"
class="btn btn-light btn-sm">
Monthly
</a>

<a href="<?= $base_url ?>reports/birthdays.php"
class="btn btn-light btn-sm">
Birthdays
</a>

<a href="<?= $base_url ?>reports/inactive_patients.php"
class="btn btn-light btn-sm">
Inactive
</a>

<a href="<?= $base_url ?>reports/no_visits.php"
class="btn btn-light btn-sm">
No Visits
</a>

<a href="<?= $base_url ?>reports/specific_age.php"
class="btn btn-light btn-sm">
Special Age
</a>

<a href="<?= $base_url ?>reports/chart.php"
class="btn btn-light btn-sm">
Charts
</a>

<a href="<?= $base_url ?>logout.php"
class="btn btn-danger btn-sm">
Logout
</a>

</div>
</div>

</nav>

<div class="container mt-4">
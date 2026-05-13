<?php
include("config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit;
}

include("includes/header.php");

$sql1 = "SELECT COUNT(*) AS total_patients
         FROM patients";

$result1 = mysqli_query($conn,$sql1);

$totalPatients = mysqli_fetch_assoc($result1);

$sql2 = "SELECT COUNT(*) AS total_visits
         FROM visits";

$result2 = mysqli_query($conn,$sql2);

$totalVisits = mysqli_fetch_assoc($result2);

$sql3 = "SELECT COUNT(*) AS upcoming_followups

         FROM visits

         WHERE follow_up_due
         BETWEEN CURDATE()
         AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";

$result3 = mysqli_query($conn,$sql3);

$followups = mysqli_fetch_assoc($result3);

$sql4 = "SELECT COUNT(*) AS overdue_followups

         FROM visits

         WHERE follow_up_due < CURDATE()";

$result4 = mysqli_query($conn,$sql4);

$overdue = mysqli_fetch_assoc($result4);
?>

<div class="row">

<div class="col-md-3 mb-4">

<div class="dashboard-card bg-blue text-center">

<i class="bi bi-people-fill fs-1 mb-3"></i>

<h5>Total Patients</h5>

<h1>
<?= $totalPatients['total_patients'] ?>
</h1>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="dashboard-card bg-green text-center">

<i class="bi bi-calendar2-check-fill fs-1 mb-3"></i>

<h5>Total Visits</h5>

<h1>
<?= $totalVisits['total_visits'] ?>
</h1>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="dashboard-card bg-orange text-center">

<i class="bi bi-bell-fill fs-1 mb-3"></i>

<h5>Upcoming Followups</h5>

<h1>
<?= $followups['upcoming_followups'] ?>
</h1>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="dashboard-card bg-red text-center">

<i class="bi bi-exclamation-triangle-fill fs-1 mb-3"></i>

<h5>Overdue Followups</h5>

<h1>
<?= $overdue['overdue_followups'] ?>
</h1>

</div>

</div>

</div>

<div class="card p-4">

<h3 class="mb-3">
Welcome,
<?= htmlspecialchars($_SESSION['username']) ?>
</h3>

<p>
Healthcare Patient Visit &
Follow-Up Manager.
</p>

<div class="mt-3">

<a href="patients/add.php"
class="btn btn-primary">
<i class="bi bi-person-plus-fill"></i>
Add Patient
</a>

<a href="patients/list.php"
class="btn btn-success">
<i class="bi bi-eye-fill"></i>
View Patients
</a>

<a href="visits/add.php"
class="btn btn-warning">
<i class="bi bi-plus-circle-fill"></i>
Add Visit
</a>

<a href="reports/summary.php"
class="btn btn-dark">
<i class="bi bi-file-earmark-bar-graph-fill"></i>
Reports
</a> 

</div>

</div>

<?php include("includes/footer.php"); ?>
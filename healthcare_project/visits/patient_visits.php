<?php
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit;
}

if(!isset($_POST['patient_id'])){
    header("Location: list.php");
    exit;
}

$id = $_POST['patient_id'];

include("../includes/header.php");

$sql1 = "SELECT *
         FROM patients
         WHERE patient_id = ?";

$stmt1 = mysqli_prepare($conn,$sql1);

mysqli_stmt_bind_param($stmt1,"i",$id);

mysqli_stmt_execute($stmt1);

$result1 = mysqli_stmt_get_result($stmt1);

$patient = mysqli_fetch_assoc($result1);

$sql2 = "SELECT

         v.*,

         DATEDIFF(
            CURDATE(),
            v.visit_date
         ) AS days_since_visit,

         CASE
            WHEN v.follow_up_due < CURDATE()
            THEN 'Overdue'
            ELSE 'Upcoming'
         END AS followup_status

         FROM visits v

         WHERE v.patient_id = ?

         ORDER BY v.visit_date DESC";

$stmt2 = mysqli_prepare($conn,$sql2);

mysqli_stmt_bind_param($stmt2,"i",$id);

mysqli_stmt_execute($stmt2);

$visits = mysqli_stmt_get_result($stmt2);

$sql3 = "SELECT

         COUNT(visit_id) AS total_visits,

         MIN(visit_date) AS first_visit,

         MAX(visit_date) AS last_visit,

         DATEDIFF(
            MAX(visit_date),
            MIN(visit_date)
         ) AS total_days_between

         FROM visits

         WHERE patient_id = ?";

$stmt3 = mysqli_prepare($conn,$sql3);

mysqli_stmt_bind_param($stmt3,"i",$id);

mysqli_stmt_execute($stmt3);

$result3 = mysqli_stmt_get_result($stmt3);

$summary = mysqli_fetch_assoc($result3);
?>

<div class="card p-4 mb-4">

<h3>Patient Visit History</h3>

<hr>

<p>
<strong>Patient:</strong>
<?= htmlspecialchars($patient['name']) ?>
</p>

<p>
<strong>Total Visits:</strong>
<?= $summary['total_visits'] ?>
</p>

<p>
<strong>First Visit:</strong>
<?= $summary['first_visit'] ?>
</p>

<p>
<strong>Last Visit:</strong>
<?= $summary['last_visit'] ?>
</p>

<p>
<strong>Days Between First & Last Visit:</strong>
<?= $summary['total_days_between'] ?>
</p>

</div>

<div class="card p-4">

<h4 class="mb-3">Visit Records</h4>

<table class="table table-bordered table-hover">

<tr>
<th>Visit ID</th>
<th>Visit Date</th>
<th>Consultation Fee</th>
<th>Lab Fee</th>
<th>Follow-Up Due</th>
<th>Days Since Visit</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($visits)){ ?>

<tr>

<td><?= $row['visit_id'] ?></td>

<td><?= $row['visit_date'] ?></td>

<td>₹<?= $row['consultation_fee'] ?></td>

<td>₹<?= $row['lab_fee'] ?></td>

<td><?= $row['follow_up_due'] ?></td>

<td><?= $row['days_since_visit'] ?></td>

<td>

<?php if($row['followup_status'] == 'Overdue'){ ?>

<span class="badge bg-danger">
<?= $row['followup_status'] ?>
</span>

<?php }else{ ?>

<span class="badge bg-success">
<?= $row['followup_status'] ?>
</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

<?php include("../includes/footer.php"); ?>
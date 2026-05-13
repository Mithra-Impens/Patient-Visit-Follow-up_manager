<?php
include("../config/db.php");
include("../includes/header.php");


$sql1 = "SELECT

         DATE_FORMAT(visit_date,'%Y-%m') AS month_name,
         COUNT(*) AS total_visits

         FROM visits

         WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)

         GROUP BY DATE_FORMAT(visit_date,'%Y-%m')

         ORDER BY month_name";

$result1 = mysqli_query($conn,$sql1);

?>

<table class="table table-bordered">
<tr>
<th>Month</th>
<th>Total Visits</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result1)){ ?>
<tr>
<td><?= $row['month_name'] ?></td>
<td><?= $row['total_visits'] ?></td>
</tr>
<?php } ?>

</table>
</div>

<div class="card p-4">
<h3>Patients Joined Per Month</h3>

<?php
$sql2 = "SELECT

         DATE_FORMAT(join_date,'%Y-%m') AS join_month,
         COUNT(*) AS total_patients

         FROM patients

         GROUP BY DATE_FORMAT(join_date,'%Y-%m')

         ORDER BY join_month";

$result2 = mysqli_query($conn,$sql2);
?>

<table class="table table-bordered">
<tr>
<th>Join Month</th>
<th>Total Patients</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result2)){ ?>
<tr>
<td><?= $row['join_month'] ?></td>
<td><?= $row['total_patients'] ?></td>
</tr>
<?php } ?>

</table>
</div>

<div class="card p-4">

<h3>Visits Based On Patient Join Month</h3>
<?php
$sql3 = "SELECT

DATE_FORMAT(p.join_date,'%Y-%m') AS join_month,

COUNT(v.visit_id) AS total_visits

FROM patients p

LEFT JOIN visits v
ON p.patient_id = v.patient_id

GROUP BY DATE_FORMAT(p.join_date,'%Y-%m')

ORDER BY join_month";

$result3 = mysqli_query($conn,$sql3);
?>

<table class="table table-bordered">

<tr>
<th>Join Month</th>
<th>Total Visits</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result3)){ ?>

<tr>

<td><?= $row['join_month'] ?></td>

<td><?= $row['total_visits'] ?></td>

</tr>

<?php } ?>

</table>

</div>
<?php include("../includes/footer.php"); ?>
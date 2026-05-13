<?php
include("../config/db.php");
include("../includes/header.php");

$sql = "SELECT

        p.name,

        TIMESTAMPDIFF(
            YEAR,
            p.dob,
            CURDATE()
        ) AS age,

        COUNT(v.visit_id) AS total_visits,

        MAX(v.visit_date) AS last_visit,

        DATEDIFF(
            CURDATE(),
            MAX(v.visit_date)
        ) AS days_since_last_visit,

        MAX(v.follow_up_due) AS next_followup

        FROM patients p

        LEFT JOIN visits v
        ON p.patient_id = v.patient_id

        GROUP BY p.patient_id";

$result = mysqli_query($conn,$sql);
?>

<div class="card p-4">

<h3 class="page-title">

<i class="bi bi-bar-chart-fill"></i>

Full Summary Report

</h3>

<table class="table table-bordered table-hover">

<tr>
<th>Name</th>
<th>Age</th>
<th>Total Visits</th>
<th>Last Visit</th>
<th>Days Since Last Visit</th>
<th>Next Follow-Up</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= $row['age'] ?></td>
<td><?= $row['total_visits'] ?></td>
<td><?= $row['last_visit'] ?></td>
<td><?= $row['days_since_last_visit'] ?></td>
<td><?= $row['next_followup'] ?></td>

</tr>

<?php } ?>

</table>

</div>

<?php include("../includes/footer.php"); ?>
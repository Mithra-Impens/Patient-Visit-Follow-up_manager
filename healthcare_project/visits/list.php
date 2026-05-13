<?php
include("../config/db.php");
include("../includes/header.php");

$sql = "SELECT

        v.*,
        p.name,

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

        INNER JOIN patients p
        ON v.patient_id = p.patient_id

        ORDER BY v.visit_date DESC";

$result = mysqli_query($conn,$sql);
?>

<div class="card p-4">

<h3 class="page-title">

<i class="bi bi-clipboard2-pulse-fill"></i>

Visit List

</h3>

<table class="table table-bordered">

<tr>
<th>Patient</th>
<th>Visit Date</th>
<th>Days Since Visit</th>
<th>Follow-Up</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= $row['visit_date'] ?></td>
<td><?= $row['days_since_visit'] ?></td>
<td><?= $row['follow_up_due'] ?></td>
<td><?= $row['followup_status'] ?></td>

</tr>

<?php } ?>

</table>

</div>

<?php include("../includes/footer.php"); ?>
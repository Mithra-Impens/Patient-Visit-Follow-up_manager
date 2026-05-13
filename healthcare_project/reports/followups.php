<?php
include("../config/db.php");
include("../includes/header.php");

$sql = "SELECT

p.name,
v.visit_date,
v.follow_up_due,

CASE

WHEN v.follow_up_due < CURDATE()
AND NOT EXISTS(

SELECT 1
FROM visits v2

WHERE v2.patient_id = v.patient_id
AND v2.visit_date > v.follow_up_due

)

THEN 'Missed'

WHEN v.follow_up_due < CURDATE()

THEN 'Overdue'

ELSE 'Upcoming'

END AS status

FROM visits v

INNER JOIN patients p
ON v.patient_id = p.patient_id

ORDER BY v.follow_up_due ASC";

$result = mysqli_query($conn,$sql);
?>

<div class="card p-4">

<h3>Follow-Up Report</h3>

<table class="table table-bordered">

<tr>
<th>Patient</th>
<th>Follow-Up Date</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= $row['follow_up_due'] ?></td>
<td><?= $row['status'] ?></td>

</tr>

<?php } ?>

</table>

</div>

<?php include("../includes/footer.php"); ?>
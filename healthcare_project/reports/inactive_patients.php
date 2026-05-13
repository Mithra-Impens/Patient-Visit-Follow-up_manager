<?php
include("../config/db.php");
include("../includes/header.php");

$sql = "SELECT
        p.name,
        MAX(v.visit_date) AS last_visit,

        DATEDIFF(
            CURDATE(),
            MAX(v.visit_date)
        ) AS inactive_days

        FROM patients p

        LEFT JOIN visits v
        ON p.patient_id = v.patient_id

        GROUP BY p.patient_id

        HAVING inactive_days >= 180";

$result = mysqli_query($conn,$sql);
?>

<div class="card p-4">
<h3>Inactive Patients</h3>

<table class="table table-bordered">
<tr>
<th>Name</th>
<th>Last Visit</th>
<th>Inactive Days</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= $row['last_visit'] ?></td>
<td><?= $row['inactive_days'] ?></td>
</tr>
<?php } ?>

</table>
</div>

<?php include("../includes/footer.php"); ?>
<?php
include("../config/db.php");
include("../includes/header.php");

$sql = "SELECT
        p.name,
        p.phone

        FROM patients p

        LEFT JOIN visits v
        ON p.patient_id = v.patient_id

        WHERE v.visit_id IS NULL";

$result = mysqli_query($conn,$sql);
?>

<div class="card p-4">
<h3>Patients With No Visits</h3>

<table class="table table-bordered">
<tr>
<th>Name</th>
<th>Phone</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= $row['phone'] ?></td>
</tr>
<?php } ?>

</table>
</div>

<?php include("../includes/footer.php"); ?>
<?php
include("../config/db.php");
include("../includes/header.php");

$sql = "SELECT
        name,
        dob,

        TIMESTAMPDIFF(
            YEAR,
            dob,
            CURDATE()
        ) + 1 AS turning_age

        FROM patients

        WHERE TIMESTAMPDIFF(
            YEAR,
            dob,
            CURDATE()
        ) + 1 IN (40,50,60)";

$result = mysqli_query($conn,$sql);
?>

<div class="card p-4">
<h3>Patients Turning 40 / 50 / 60</h3>

<table class="table table-bordered">
<tr>
<th>Name</th>
<th>DOB</th>
<th>Turning Age</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= $row['dob'] ?></td>
<td><?= $row['turning_age'] ?></td>
</tr>
<?php } ?>

</table>
</div>

<?php include("../includes/footer.php"); ?>
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

WHERE

DATE_FORMAT(dob,'%m-%d')

BETWEEN DATE_FORMAT(CURDATE(),'%m-%d')

AND DATE_FORMAT(
DATE_ADD(CURDATE(),INTERVAL 30 DAY),
'%m-%d')

OR

DATE_FORMAT(CURDATE(),'%m-%d')
>
DATE_FORMAT(
DATE_ADD(CURDATE(),INTERVAL 30 DAY),
'%m-%d'
)

AND

(
DATE_FORMAT(dob,'%m-%d')
>= DATE_FORMAT(CURDATE(),'%m-%d')

OR

DATE_FORMAT(dob,'%m-%d')
<= DATE_FORMAT(
DATE_ADD(CURDATE(),INTERVAL 30 DAY),
'%m-%d'
)
)";

$result = mysqli_query($conn,$sql);
?>

<div class="card p-4">

<h3>Upcoming Birthdays</h3>

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
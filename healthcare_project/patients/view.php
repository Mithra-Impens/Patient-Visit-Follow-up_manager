<?php
include("../config/db.php");
include("../includes/header.php");

if(!isset($_POST['patient_id'])){
    header("Location: list.php");
    exit;
}

$id = $_POST['patient_id'];

$sql = "SELECT

        p.name,

        TIMESTAMPDIFF(YEAR,p.dob,CURDATE()) AS age,

        DATEDIFF(
            CURDATE(),
            MAX(v.visit_date)
        ) AS days_since_last_visit,

        MAX(v.follow_up_due) AS next_followup,

        CASE
            WHEN MAX(v.follow_up_due) < CURDATE()
            THEN 'Overdue'
            ELSE 'Upcoming'
        END AS followup_status

        FROM patients p

        LEFT JOIN visits v
        ON p.patient_id = v.patient_id

        WHERE p.patient_id = ?

        GROUP BY p.patient_id";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);
?>

<div class="card p-4">

<h3>Patient Details</h3>

<p><strong>Name:</strong> <?= $row['name'] ?></p>
<p><strong>Age:</strong> <?= $row['age'] ?></p>
<p><strong>Days Since Last Visit:</strong> <?= $row['days_since_last_visit'] ?></p>
<p><strong>Next Follow-Up:</strong> <?= $row['next_followup'] ?></p>
<p><strong>Status:</strong> <?= $row['followup_status'] ?></p>

</div>

<?php include("../includes/footer.php"); ?>
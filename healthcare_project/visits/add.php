<?php
include("../config/db.php");
include("../includes/header.php");
$visit_details = null;
$success = "";

if(isset($_POST['add_visit'])){

    $patient_id = $_POST['patient_id'];
    $visit_date = $_POST['visit_date'];
    $consultation_fee = $_POST['consultation_fee'];
    $lab_fee = $_POST['lab_fee'];

    $sql = "INSERT INTO visits
            (
                patient_id,
                visit_date,
                consultation_fee,
                lab_fee,
                follow_up_due
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                DATE_ADD(?, INTERVAL 7 DAY)
            )";

    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param(
        $stmt,
        "isdds",
        $patient_id,
        $visit_date,
        $consultation_fee,
        $lab_fee,
        $visit_date
    );

    if(mysqli_stmt_execute($stmt)){

    $success = "Visit Added Successfully";

    $last_id = mysqli_insert_id($conn);

    $detail_sql = "SELECT

                   v.visit_date,
                   v.consultation_fee,
                   v.lab_fee,
                   v.follow_up_due,
                   p.name

                   FROM visits v

                   INNER JOIN patients p
                   ON v.patient_id = p.patient_id

                   WHERE v.visit_id = ?";

    $detail_stmt = mysqli_prepare($conn,$detail_sql);

    mysqli_stmt_bind_param($detail_stmt,"i",$last_id);

    mysqli_stmt_execute($detail_stmt);

    $detail_result = mysqli_stmt_get_result($detail_stmt);

    $visit_details = mysqli_fetch_assoc($detail_result);
}
}

$patients = mysqli_query($conn,"SELECT * FROM patients");
?>

<div class="card p-4">

<h3>Add Visit</h3>

<?php if($success){ ?>
<div class="alert alert-success"><?= $success ?></div>
<?php } ?>



<form method="POST">

<label class="form-label">
Patient Name
</label>

<select
name="patient_id"
class="form-control mb-3"
required>

<option value="">
Select Patient
</option>

<?php while($p = mysqli_fetch_assoc($patients)){ ?>

<option value="<?= $p['patient_id'] ?>">

<?= htmlspecialchars($p['name']) ?>

</option>

<?php } ?>

</select>

<label class="form-label">
Visit Date
</label>

<input
type="date"
name="visit_date"
class="form-control mb-3"
required>

<label class="form-label">
Consultation Fee
</label>

<input
type="number"
step="0.01"
name="consultation_fee"
class="form-control mb-3"
placeholder="Enter Consultation Fee"
required>

<label class="form-label">
Lab Fee
</label>

<input
type="number"
step="0.01"
name="lab_fee"
class="form-control mb-3"
placeholder="Enter Lab Fee"
required>

<button
class="btn btn-primary"
name="add_visit">

Add Visit

</button>

</form>

</div>

<?php include("../includes/footer.php"); ?>
<?php
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit;
}

if(!isset($_POST['patient_id'])){
    header("Location: list.php");
    exit;
}

$id = $_POST['patient_id'];

$error = "";
$success = "";

$sql = "SELECT * FROM patients
        WHERE patient_id = ?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) == 0){
    header("Location: list.php");
    exit;
}

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update_patient'])){

    $name = trim($_POST['name']);
    $dob = $_POST['dob'];
    $join_date = $_POST['join_date'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if(empty($name) || empty($dob) || empty($join_date)){

        $error = "All fields are required";

    }elseif(strtotime($dob) > time()){

        $error = "DOB cannot be future date";

    }else{

        $update = "UPDATE patients

                   SET
                   name = ?,
                   dob = ?,
                   join_date = ?,
                   phone = ?,
                   address = ?

                   WHERE patient_id = ?";

        $stmt2 = mysqli_prepare($conn,$update);

        mysqli_stmt_bind_param(
            $stmt2,
            "sssssi",
            $name,
            $dob,
            $join_date,
            $phone,
            $address,
            $id
        );

        if(mysqli_stmt_execute($stmt2)){

            $_SESSION['success'] = "Patient Updated Successfully";

            header("Location: list.php");
            exit;

        }else{
            $error = "Update Failed";
        }
    }
}

include("../includes/header.php");
?>

<div class="card p-4">

<h3 class="mb-4">Edit Patient</h3>

<?php if($error){ ?>

<div class="alert alert-danger">
<?= $error ?>
</div>

<?php } ?>

<form method="POST">
<input type="hidden"
name="patient_id"
value="<?= $id ?>">

<label>Name</label>

<input type="text"
name="name"
class="form-control mb-3"
value="<?= htmlspecialchars($row['name']) ?>"
required>

<label>DOB</label>

<input type="date"
name="dob"
class="form-control mb-3"
value="<?= $row['dob'] ?>"
required>

<label>Join Date</label>

<input type="date"
name="join_date"
class="form-control mb-3"
value="<?= $row['join_date'] ?>"
required>

<label>Phone</label>

<input type="text"
name="phone"
class="form-control mb-3"
value="<?= htmlspecialchars($row['phone']) ?>"
required>

<label>Address</label>

<textarea
name="address"
class="form-control mb-3"
required><?= htmlspecialchars($row['address']) ?></textarea>

<button
type="submit"
name="update_patient"
class="btn btn-primary">
Update Patient
</button>

<a href="list.php"
class="btn btn-secondary">
Back
</a>

</form>

</div>

<?php include("../includes/footer.php"); ?>
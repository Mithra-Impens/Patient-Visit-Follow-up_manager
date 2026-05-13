<?php
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit;
}

$success = "";
$error = "";

if(isset($_POST['add_patient'])){

    $name = trim($_POST['name']);
    $dob = $_POST['dob'];
    $join_date = $_POST['join_date'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if(strtotime($dob) > time()){

        $error = "DOB cannot be future date";

    }else{

        $sql = "INSERT INTO patients
                (name,dob,join_date,phone,address)
                VALUES(?,?,?,?,?)";

        $stmt = mysqli_prepare($conn,$sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $name,
            $dob,
            $join_date,
            $phone,
            $address
        );

        if(mysqli_stmt_execute($stmt)){
            $success = "Patient Added Successfully";
        }
    }
}

include("../includes/header.php");
?>

<div class="card p-4">

<h3>Add Patient</h3>

<?php if($success){ ?>
<div class="alert alert-success"><?= $success ?></div>
<?php } ?>

<?php if($error){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="POST">

<label class="form-label">
Patient Name
</label>

<input type="text"
name="name"
class="form-control mb-3"
placeholder="Enter Patient Name"
required>

<label class="form-label">
Date of Birth
</label>

<input type="date"
name="dob"
class="form-control mb-3"
required>

<label class="form-label">
Join Date
</label>

<input type="date"
name="join_date"
class="form-control mb-3"
required>

<label class="form-label">
Phone Number
</label>

<input type="text"
name="phone"
class="form-control mb-3"
placeholder="Enter Phone Number"
required>

<label class="form-label">
Address
</label>

<textarea
name="address"
class="form-control mb-3"
placeholder="Enter Address"
required></textarea>

<button class="btn btn-primary"
name="add_patient">
Add Patient
</button>

</form>

</div>

<?php include("../includes/footer.php"); ?>
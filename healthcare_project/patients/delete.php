<?php
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    die("Access Denied");
}

if(!isset($_POST['patient_id'])){
    header("Location: list.php");
    exit;
}

$id = $_POST['patient_id'];

$sql = "DELETE FROM patients
        WHERE patient_id = ?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$_SESSION['success'] = "Patient Deleted Successfully";

header("Location: list.php");
exit;
?>
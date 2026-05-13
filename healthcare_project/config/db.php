<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "healthcare_db";

$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);

if(!$conn){
    die("Database Connection Failed");
}

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

date_default_timezone_set("Asia/Kolkata");
?>
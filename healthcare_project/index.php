<?php
include("config/db.php");

$error = "";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = hash('sha256', $_POST['password']);

    $sql = "SELECT * FROM users
            WHERE username = ?
            AND password = ?";

    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param($stmt,"ss",$username,$password);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1){

        $row = mysqli_fetch_assoc($result);

        session_regenerate_id(true);

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        header("Location: dashboard.php");
        exit;

    }else{
        $error = "Invalid Login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-4">

<div class="card p-4">

<h3 class="text-center mb-3">Login</h3>

<?php if($error){ ?>
<div class="alert alert-danger">
<?= $error ?>
</div>
<?php } ?>

<form method="POST">

<input type="text"
name="username"
class="form-control mb-3"
placeholder="Username"
required>

<input type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button class="btn btn-primary w-100"
name="login">
Login
</button>

</form>

</div>

</div>

</div>

</div>

</body>
</html>
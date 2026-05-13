<?php
include("../config/db.php");
include("../includes/header.php");

$search = "";

if(isset($_POST['search_patient'])){
    $search = trim($_POST['search']);
}

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$start = ($page - 1) * $limit;

$count_sql = "SELECT COUNT(*) AS total FROM patients";
$count_result = mysqli_query($conn,$count_sql);
$count_row = mysqli_fetch_assoc($count_result);

$total_records = $count_row['total'];

$total_pages = ceil($total_records / $limit);

if(!empty($search)){

    $sql = "SELECT 
            p.*,
            YEAR(p.join_date) AS join_year,
MONTH(p.join_date) AS join_month,
DAY(p.join_date) AS join_day,

            TIMESTAMPDIFF(YEAR,p.dob,CURDATE()) AS age,

            CONCAT(
                TIMESTAMPDIFF(YEAR,p.dob,CURDATE()),
                ' Years ',
                TIMESTAMPDIFF(MONTH,p.dob,CURDATE()) % 12,
                ' Months'
            ) AS full_age,

            COUNT(v.visit_id) AS total_visits

            FROM patients p

            LEFT JOIN visits v
            ON p.patient_id = v.patient_id

            WHERE p.name LIKE ?

            GROUP BY p.patient_id

            LIMIT ?, ?";

    $stmt = mysqli_prepare($conn,$sql);

    $search_param = "%$search%";

    mysqli_stmt_bind_param(
        $stmt,
        "sii",
        $search_param,
        $start,
        $limit
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

}else{

    $sql = "SELECT 
            p.*,
            YEAR(p.join_date) AS join_year,

MONTH(p.join_date) AS join_month,

DAY(p.join_date) AS join_day,

            

            TIMESTAMPDIFF(YEAR,p.dob,CURDATE()) AS age,

            CONCAT(
                TIMESTAMPDIFF(YEAR,p.dob,CURDATE()),
                ' Years ',
                TIMESTAMPDIFF(MONTH,p.dob,CURDATE()) % 12,
                ' Months'
            ) AS full_age,

            COUNT(v.visit_id) AS total_visits

            FROM patients p

            LEFT JOIN visits v
            ON p.patient_id = v.patient_id

            GROUP BY p.patient_id

            LIMIT $start, $limit";

    $result = mysqli_query($conn,$sql);
}
?>

<div class="card p-4">

<h3 class="page-title">

Patient List

</h3>

<form method="POST" class="mb-4">

<div class="row">

<div class="col-md-6">

<input type="text"
name="search"
class="form-control"
placeholder="Search Patient Name"
value="<?= htmlspecialchars($search) ?>">

</div>

<div class="col-md-3">

<button
type="submit"
name="search_patient"
class="btn btn-primary w-100">

Search

</button>

</div>

<div class="col-md-3">

<a href="list.php"
class="btn btn-secondary w-100">

Reset

</a>

</div>

</div>

</form>

<table class="table table-bordered table-hover">

<thead>

<tr>
<th>ID</th>
<th>Name</th>
<th>Age</th>
<th>Full Age</th>
<th>Total Visits</th>
<th>Join Year</th>
<th>Join Month</th>
<th>Join Day</th>
<th>Actions</th>
</tr>

</thead>

<tbody>

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['patient_id'] ?></td>

<td><?= htmlspecialchars($row['name']) ?></td>

<td><?= $row['age'] ?></td>

<td><?= $row['full_age'] ?></td>

<td><?= $row['total_visits'] ?></td>
<td><?= $row['join_year'] ?></td>
<td><?= $row['join_month'] ?></td>
<td><?= $row['join_day'] ?></td>

<td>

<form action="view.php" method="POST" class="d-inline">

<input type="hidden"
name="patient_id"
value="<?= $row['patient_id'] ?>">

<button class="btn btn-info btn-sm">

View

</button>

</form>

<form action="edit.php" method="POST" class="d-inline">

<input type="hidden"
name="patient_id"
value="<?= $row['patient_id'] ?>">

<button class="btn btn-warning btn-sm">

Edit

</button>

</form>

<form action="../visits/patient_visits.php"
method="POST"
class="d-inline">

<input type="hidden"
name="patient_id"
value="<?= $row['patient_id'] ?>">

<button class="btn btn-dark btn-sm">

Visits

</button>

</form>

<?php if($_SESSION['role'] == 'admin'){ ?>

<form action="delete.php"
method="POST"
class="d-inline"
onSubmit="return confirm('Delete Patient?')">

<input type="hidden"
name="patient_id"
value="<?= $row['patient_id'] ?>">

<button class="btn btn-danger btn-sm">

Delete

</button>

</form>

<?php } ?>

</td>

</tr>

<?php } ?>

<?php }else{ ?>

<tr>

<td colspan="6" class="text-center text-danger">

No Patients Found

</td>

</tr>

<?php } ?>

</tbody>

</table>

<nav>

<ul class="pagination">

<?php for($i = 1; $i <= $total_pages; $i++){ ?>

<li class="page-item">

<a class="page-link"
href="?page=<?= $i ?>">

<?= $i ?>

</a>

</li>

<?php } ?>

</ul>

</nav>

</div>

<?php include("../includes/footer.php"); ?>
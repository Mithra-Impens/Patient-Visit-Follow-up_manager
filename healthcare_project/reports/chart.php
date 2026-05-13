<?php
include("../config/db.php");
include("../includes/header.php");

$sql = "SELECT
        DATE_FORMAT(visit_date,'%Y-%m') AS month_name,
        COUNT(*) AS total_visits
        FROM visits
        GROUP BY DATE_FORMAT(visit_date,'%Y-%m')";

$result = mysqli_query($conn,$sql);

$months = [];
$visits = [];

while($row = mysqli_fetch_assoc($result)){
    $months[] = $row['month_name'];
    $visits[] = $row['total_visits'];
}
?>

<div class="card p-4">
<h3>Visits Chart</h3>

<canvas id="visitChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('visitChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
            label: 'Visits',
            data: <?= json_encode($visits) ?>,
            borderWidth: 1
        }]
    }
});
</script>

<?php include("../includes/footer.php"); ?>
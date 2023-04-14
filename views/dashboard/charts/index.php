<section class="chartSection">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="chart"><canvas id="myChart" width="400" height="400"></canvas></div>

    <?php
$handler = new MYSQLHandler();
$sql = "SELECT g.gname, COUNT(u.gid) as num_users 
        FROM groups g 
        LEFT JOIN users u ON u.gid = g.gid 
        GROUP BY g.gname";
        
$results = $handler->get_results($sql);
$labels = array();
$data = array();

foreach ($results as $row) {
    $labels[] = $row['gname'];
    $data[] = $row['num_users'];
}

$data = array(
    'labels' => $labels,
    'datasets' => array(
        array(
            'label' => 'Number of Users in each group',
            'data' => $data,
            'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
            'borderColor' => 'rgba(255, 99, 132, 1)',
            'borderWidth' => 1.5
        )
    )
);?>
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: <?php echo json_encode($data); ?>,
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>

</section>
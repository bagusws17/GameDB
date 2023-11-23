<?php
include "connection.php";

// Fetch platform data
$platform_name = mysqli_query($conn, "SELECT platform_name FROM platform order by id_platform asc");
$platform = mysqli_query($conn, "SELECT COUNT(app_detail.id_app) AS app_count FROM platform LEFT JOIN app_platform ON platform.id_platform = app_platform.id_platform LEFT JOIN app_detail ON app_platform.id_app = app_detail.id_app GROUP BY platform.platform_name;");
?>

<html>
    <head>
        <title>Belajarphp.net - ChartJS</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>

        <style type="text/css">
            .container {
                width: 25%;
                margin: 15px auto;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <canvas id="myChart" width="100" height="100"></canvas>
        </div>
        <script>
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [<?php while ($b = mysqli_fetch_array($platform_name)) { echo '"' . $b['platform_name'] . '",';}?>],
                    datasets: [{
                            label: '# of Votes',
                            data: [<?php while ($p = mysqli_fetch_array($platform)) { echo '"' . $p['app_count'] . '",';}?>],
                            backgroundColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                            ],
                            borderWidth: 1
                        }]
                },
            });
        </script>
    </body>
</html>

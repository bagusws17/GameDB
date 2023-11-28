<?php
include "connection.php";

// Fetch game statistics by genre
$genre_data_result = mysqli_query($conn, "SELECT genre, COUNT(id_app) AS game_count FROM app_detail GROUP BY genre ORDER BY game_count DESC");

// Fetch data into an array
$genre_data = array();
while ($row = mysqli_fetch_assoc($genre_data_result)) {
    $genre_data[] = $row;
}
?>

<html>
    <head>
        <title>Belajarphp.net - ChartJS</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>

        <style type="text/css">
            .container-chart {
                width: 25%;
                margin: 15px auto;
            }
        </style>
    </head>
    <body>
        <div class="container-chart">
            <canvas id="myChart2" width="100" height="100"></canvas>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                setTimeout(function () {
                    var ctx = document.getElementById("myChart2");
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: [<?php foreach ($genre_data as $g) { echo '"' . $g['genre'] . '",'; } ?>],
                            datasets: [{
                                data: [<?php foreach ($genre_data as $g) { echo '"' . $g['game_count'] . '",'; } ?>],
                                backgroundColor: [
                                    'rgba(176, 64, 64, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(52, 152, 219, 1)',
                                    'rgba(255, 236, 0, 1)',
                                ],
                                borderColor: [
                                    'rgba(176, 64, 64, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(52, 152, 219, 1)',
                                    'rgba(255, 236, 0, 1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                    });
                }, 1000);
            });
        </script>
    </body>
</html>

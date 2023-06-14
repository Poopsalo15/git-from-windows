<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$hostname = 'localhost';
$username = 'lishin';
$password = '12qwaszx';
$dbname = 'palindromes';

// 建立資料庫連線
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// 檢查連線是否成功
if (mysqli_connect_errno()) {
    die("無法連線到MySQL資料庫: " . mysqli_connect_error());
}

$value=$_POST["value"];
$query = "SELECT $value as V ,COUNT($value) AS C
      FROM draw group by V order by C DESC;";
    
    $result = mysqli_query($conn, $query);
    // 檢查查詢結果
    if (!$result) {
        die("查詢錯誤: " . mysqli_error($conn));
    }

    $data = array(array($value, '數量'));
    while ($row = mysqli_fetch_assoc($result)) {
        $object = $row['V'];
        $count = (int) $row['C'];
        $data[] = array($object, $count);
    }
    $jsonData = json_encode($data);
    mysqli_free_result($result);



?>
<!DOCTYPE html>
<html>
<head>
    <title>長條圖示例</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var jsonData = <?php echo $jsonData; ?>;

            var data = google.visualization.arrayToDataTable(jsonData);

            var options = {
                title: '長條圖',
                legend: { position: 'none' },
                chartArea: { width: '80%', height: '80%' },
                hAxis: { title: 'object' },
                vAxis: { title: '數量' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="chart_div" style="width: 100%; height: 400px;"></div>
</body>
</html>

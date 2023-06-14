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

$query2 = "SELECT M,COUNT(M) AS C FROM(SELECT SUBSTRING(Date, 1, 2) AS M FROM time)as A group by M;";

$result2 = mysqli_query($conn, $query2);
    // 檢查查詢結果
    if (!$result2) {
        die("查詢錯誤: " . mysqli_error($conn));
    }
    
$data2 = array(array('month', '數量'));
    while ($row2 = mysqli_fetch_assoc($result2)) {
    $month = $row2['M'];
    $count2 = (int) $row2['C'];
    $data2[] = array($month, $count2);
}
$jsonData2 = json_encode($data2);
    // 釋放結果集
mysqli_free_result($result2);


    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Final Project</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
    </script>
     <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
        }

        .header-text {
            font-size: 18px;
            font-weight: bold;
        }

        .header-image {
            width: 100px;
            height: 100px;
        }

        /* 其他样式 */

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        #chart_div,
        #chart_div2 {
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-text">
            Team 18 Final Report
        </div>
        <img class="header-image" src="linux.png" alt="photo">
    </div>
    
    


    <div class="header">
        <div class="header-text">
            Search
        </div>
    </div>
    <form method="POST" action="search.php">
    	<select name="value">
    	<option value="ID"selected>ID</option>
    	<option value="Case_Number" >Case_Number</option>
    	<option value="Date">Date</option>
    	<option value="Location_Description">Location_Description</option>
        <option value="Community_Areas">Community_Areas</option>
        
	</select>
        <label for="number">number:</label>
        <input type="text" id="number" name="number" required>
        <br>
        <input type="submit" value="提交">
    </form>
    <div class="header">
        <div class="header-text">
            Insert
        </div>
    </div>
    <form method="POST" action="insert.php">
        <label for="Password">Password</label>
        <input type="text" id="Password" name="Password" required>
        <label for="ID">ID</label>
        <input type="text" id="ID" name="ID" required>
        <label for="Primary_Type">Primary_Type</label>
        <input type="text" id="Primary_Type" name="Primary_Type" required>
        <label for="Community_Areas">Community_Areas</label>
        <input type="text" id="Community_Areas" name="Community_Areas" required>
        <label for="Case_number">Case_number</label>
        <input type="text" id="Case_number" name="Case_number" required>
        <label for="Date">Date</label>
        <input type="text" id="Date" name="Date" >
        <label for="Year">Year</label>
        <input type="text" id="Year" name="Year" >
        <label for="Location_Description">Location_Description</label>
        <input type="text" id="Location_Description" name="Location_Description" >
        <br>
        
        <input type="submit" value="提交">


    </form>
    <div class="header">
        <div class="header-text">
            Update
        </div>
    </div>
    <form method="POST" action="update.php">
        <label for="Password">Password</label>
        <input type="text" id="Password" name="Password" required>
        <label for="ID">ID</label>
        <input type="text" id="ID" name="ID" required>
        <label for="Primary_Type">Primary_Type</label>
        <input type="text" id="Primary_Type" name="Primary_Type" required>
        <label for="Community_Areas">Community_Areas</label>
        <input type="text" id="Community_Areas" name="Community_Areas" required>
        <label for="Case_number">Case_number</label>
        <input type="text" id="Case_number" name="Case_number" required>
        <label for="Date">Date</label>
        <input type="text" id="Date" name="Date" >
        <label for="Year">Year</label>
        <input type="text" id="Year" name="Year" >
        <label for="Location_Description">Location_Description</label>
        <input type="text" id="Location_Description" name="Location_Description" >
        <br>
        <input type="submit" value="提交">

    </form>
    <div class="header">
        <div class="header-text">
            Delete
        </div>
    </div>
    <form method="POST" action="delete.php">
    <label for="Password">Password</label>
        <input type="text" id="Password" name="Password" required>
        <br>
    <select name="value">
    	<option value="ID"selected>ID</option>
    	<option value="Case_Number" >Case_Number</option>
	</select>
        <label for="number">number:</label>
        <input type="text" id="number" name="number" required>
        <br>
        <input type="submit" value="提交">
    </form>

    <div class="header">
        <div class="header-text">
            Distinct
        </div>
    </div>
    <form method="POST" action="distinct.php">
    	<select name="value">
    	<option value="Primary_Type"selected>Primary_Type</option>
    	<option value="Location_Description" >Location_Description</option>
    	<option value="Community_Areas">Community_Areas</option>
        <option value="Year">Year</option>
	</select>
        <input type="submit" value="提交">
    </form>
    <div id="chart_div2"></div>
    
    <script type="text/javascript">
        // JavaScript 代码
    </script>
    
    <div id="chart_div2" style="width: 100%; height: 400px;"></div>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        
        google.charts.setOnLoadCallback(drawChart2);
        function drawChart2() {
            var data2 = google.visualization.arrayToDataTable(<?php echo $jsonData2; ?>);

            var options2 = {
                title: 'month數量長條圖',
                legend: { position: 'none' },
                chartArea: { width: '80%', height: '80%' },
                hAxis: { title: 'month' },
                vAxis: { title: '數量' }
            };

            var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));

            chart2.draw(data2, options2);
        }
        
    </script>
</body>

</html>




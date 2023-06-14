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

// 檢查是否有提交搜尋關鍵字
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST["number"];
    $value=$_POST["value"];
    echo "You want to find ".$number." from ".$value."<br>";

    // 執行 MySQL 查詢
    if($value=="Case_Number"||$value=="ID"){
        $table="draw";
    }else if($value=="Date"){
        $table="time";
    }else if($value=="Location_Description"||$value=="Community_Areas"){
        $table="place";
    }
    
    $stmt = mysqli_prepare($conn, "SELECT * FROM $table WHERE $value LIKE CONCAT('%', ?, '%')");
    
    // 綁定參數
    mysqli_stmt_bind_param($stmt, "s", $number);
    
    // 執行預備語句
    mysqli_stmt_execute($stmt);

    // 獲取結果集
    $result = mysqli_stmt_get_result($stmt);

    // 檢查查詢結果
    if (!$result) {
        die("查詢錯誤: " . mysqli_error($conn));
    }
    // 顯示搜尋結果
    
// 儲存結果的二維陣列
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
if(!empty($data)){
    echo '<table>';

    // 生成表頭
    echo '<tr>';
    foreach ($data[0] as $key => $value) {
        echo '<th>' . $key . '</th>';
    }
    echo '</tr>';

    // 生成資料行
    foreach ($data as $row) {
        echo '<tr>';
        foreach ($row as $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '沒有找到任何資料！'."<br>";
}
// 生成二維表格

;


    mysqli_stmt_close($stmt);
    mysqli_free_result($result);
}

// 關閉資料庫連線
mysqli_close($conn);

?>


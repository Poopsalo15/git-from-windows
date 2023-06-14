<?php
$hostname = 'localhost';
$username = 'lishin';
$password = '12qwaszx';
$dbname = 'palindromes';

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("無法連線到MySQL資料庫: " . mysqli_connect_error());
}
$password = $_POST["Password"];
if($password=="123") {
    $number = $_POST["number"];
    $value=$_POST["value"];
    echo $value." and ".$number."<br>";

    $stmt = mysqli_prepare($conn, "SELECT * FROM draw WHERE $value LIKE CONCAT('%', ?, '%')");
    
    // 綁定參數
    mysqli_stmt_bind_param($stmt, "s", $number);
    
    // 執行預備語句
    mysqli_stmt_execute($stmt);

    // 獲取結果集
    $result = mysqli_stmt_get_result($stmt);
    $data = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $id=$row["ID"];
        $data[] = $row;
    }
if(!empty($data)){

    $query2 = "DELETE FROM draw WHERE $value = $id";

    $result2 = mysqli_query($conn, $query2);
    

    // 检查查询结果
    if (!$result2) {
        die("删除错误: " . mysqli_error($conn));
    } else {
        echo "数据已成功删除!";
    }
    
    $query3 = "DELETE FROM time WHERE ID = $id";

    $result3 = mysqli_query($conn, $query3);

    // 检查查询结果
    if (!$result3) {
        die("删除错误: " . mysqli_error($conn));
    } else {
        echo "数据已成功删除!";
    }
    $query4 = "DELETE FROM place WHERE ID = $id";

    $result4 = mysqli_query($conn, $query2);

    // 检查查询结果
    if (!$result4) {
        die("删除错误: " . mysqli_error($conn));
    } else {
        echo "数据已成功删除!";
    }
    $query5 = "DELETE FROM bad WHERE ID = $id";

    $result5 = mysqli_query($conn, $query2);

    // 检查查询结果
    if (!$result5) {
        die("删除错误: " . mysqli_error($conn));
    } else {
        echo "数据已成功删除!";
    }

} else {
    echo '沒有找到任何資料！'."<br>";
}

    mysqli_stmt_close($stmt);
    mysqli_free_result($result);

}else{
    echo "Wrong Password";
}

?>
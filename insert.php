<?php
$hostname = 'localhost';
$username = 'lishin';
$password = '12qwaszx';
$dbname = 'palindromes';

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("無法連線到MySQL資料庫: " . mysqli_connect_error());
}
 // 数据库表名
$Password=$_POST["Password"];
if($Password=="123") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $number = $_POST["ID"];
        $value=$_POST["Case_number"];
        $query = "SELECT * FROM draw WHERE ID =$number";
        
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            die("查詢錯誤: " . mysqli_error($conn));
        }
        $data = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
        }

        $query2 = "SELECT * FROM draw WHERE Case_Number =$value";
        
        $result2 = mysqli_query($conn, $query2);
        if (!$result2) {
            die("查詢錯誤: " . mysqli_error($conn));
        }
        $data2 = array();
        while ($row = mysqli_fetch_assoc($result2)) {
            $data2[] = $row;
        }
    
    if(!empty($data)||!empty($data2)){
        echo "Has already exist";
    } else {
        $Case_number = $_POST["Case_number"];
        $ID = $_POST["ID"];
        $Date = $_POST["Date"];
        $Location_Description=$_POST["Location_Description"];
        $Primary_Type=$_POST["Primary_Type"];
        $Community_Areas=$_POST["Community_Areas"];
        $Year=$_POST["Year"];
        echo $ID." and ".$Case_number. " and ".$Date ." and ".$Community_Areas." and ".$Primary_Type."<br>";

        $query5 = "INSERT INTO draw (ID, Case_number, Location_Description,Primary_Type,Community_Areas,Year) 
            VALUES (?, ?, ?,?,?,?)";
        // 准备预处理语句
        $stmt5 = mysqli_prepare($conn, $query5);
        // 绑定参数
        
        mysqli_stmt_bind_param($stmt5, "issssi", $ID, $Case_number, $Location_Description,$Primary_Type,$Community_Areas,$Year);
        // 执行预处理语句
        mysqli_stmt_execute($stmt5);

        $query6 = "INSERT INTO time (ID, Date,Year) 
            VALUES (?, ?, ?)";
        // 准备预处理语句
        $stmt6= mysqli_prepare($conn, $query6);
        // 绑定参数
        mysqli_stmt_bind_param($stmt6, "isi", $ID, $Date,$Year);

        mysqli_stmt_execute($stmt6);

        $query3 = "INSERT INTO place (ID, Location_Description) 
            VALUES (?, ?)";
        // 准备预处理语句
        $stmt3 = mysqli_prepare($conn, $query3);
        // 绑定参数
        mysqli_stmt_bind_param($stmt3, "is", $ID, $Location_Description);

        mysqli_stmt_execute($stmt3);        

        $query4 = "INSERT INTO bad (ID, Case_number,Primary_Type) 
            VALUES (?, ?,?)";
        // 准备预处理语句
        $stmt4 = mysqli_prepare($conn, $query4);
        // 绑定参数
        mysqli_stmt_bind_param($stmt4, "iss", $ID, $Case_number,$Primary_Type);

        mysqli_stmt_execute($stmt4);

        
        mysqli_stmt_close($stmt);
        mysqli_free_result($result);
        mysqli_stmt_close($stmt2);
        mysqli_free_result($result2);
        mysqli_stmt_close($stmt3);
        mysqli_free_result($result3);
        mysqli_stmt_close($stmt4);
        mysqli_free_result($result4);
        mysqli_stmt_close($stmt5);
        mysqli_free_result($result5);
        mysqli_stmt_close($stmt6);
        mysqli_free_result($result6);


    }
    
       
    
    }
    

    // 关闭数据库连接
    mysqli_close($conn);

}else{
    echo "Wrong Password";
}



?>
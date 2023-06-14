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

    mysqli_free_result($result);
    mysqli_free_result($result2);
    if(!empty($data)||!empty($data2)){
        
        $Case_number = $_POST["Case_number"];
        $ID = $_POST["ID"];
        $Date = $_POST["Date"];
        $Location_Description=$_POST["Location_Description"];
        $Primary_Type=$_POST["Primary_Type"];
        $Community_Areas=$_POST["Community_Areas"];
        $Year=$_POST["Year"];
        echo "You want to change Case Number to ".$Case_number. " and Date to ".$Date .
                    " and Community Areas to ".$Community_Areas.
                    " and Primary Type to ".$Primary_Type."<br>";

        $query5 = "UPDATE draw set 
                    Case_number='$Case_number', 
                    Location_Description='$Location_Description',
                    Primary_Type='$Primary_Type',
                    Community_Areas=$Community_Areas,
                    Year=$Year WHERE ID=$ID;"; 
            
        $result5 = mysqli_query($conn, $query5);

        $query6 = "UPDATE time set  
                            Date='$Date',
                            Year=$Year WHERE ID=$ID ;";
        
        $result6 = mysqli_query($conn, $query6);

        $query3 = "UPDATE place set 
                            Location_Description='$Location_Description' WHERE ID=$ID;";
        
        $result3 = mysqli_query($conn, $query3);       

        $query4 = "UPDATE bad set 
                            Case_number ='$Case_number',
                            Primary_Type='$Primary_Type' WHERE ID=$ID;"; 
           
        $result4 = mysqli_query($conn, $query4); 
        echo "Successful Update"."<br>";
        mysqli_free_result($result3);
        mysqli_free_result($result4);
        mysqli_free_result($result5);
        mysqli_free_result($result6);
    }else{
        echo "not exist the data";
    }
    
        
    

}else{
    echo "Wrong password";
}
?>
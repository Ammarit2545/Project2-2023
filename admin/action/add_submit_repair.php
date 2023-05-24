<?php
session_start();
include('../../database/condb.php');

$id_c = $_GET['id'];

$e_id = $_SESSION["id"];

$sql_p = "SELECT * FROM `repair_status` 
LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
WHERE repair_status.get_r_id = '$id_c' AND repair_status.status_id='2'AND repair_status.del_flg = '0';"; // เผื่อกรณีใช้ Value Code
$result = mysqli_query($conn, $sql_p);
$row = mysqli_fetch_array($result);

if ($row > 0) {
    header('Location: ../detail_repair.php?id=' . $id_c);
    $_SESSION["add_data_alert"] = 1;
} else {
    $sql = "INSERT INTO repair_status (get_r_id, status_id, rs_detail, rs_date_time, e_id) 
    VALUES ('$id_c', '2', 'พนักงานได้รับข้อมูลของท่านและกำลังตรวจเช็ครายละเอียดการซ่อมของคุณอยู่ในขณะนี้', NOW(), '$e_id')";
    $result = mysqli_query($conn, $sql);


    if ($result) {
        header('Location: ../detail_repair.php?id=' . $id_c);
        $_SESSION["add_data_alert"] = 0;
    } else {
        header('Location: ../detail_repair.php?id=' . $id_c);
        $_SESSION["add_data_alert"] = 1;
    }
}
// $sql = "UPDATE company SET del_flg = '1' WHERE com_id = '$id_c'";
// $result = mysqli_query($conn, $sql);

// if($result){
//     echo "Company deleted successfully";
//     header('Location:../listview_company.php');
// } else {
//     echo "Company deleting ";
// }
// 

<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$get_r_id = $_GET['id'];

echo $id;

$sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND status_id = '3' AND del_flg = 0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
if ($row[0] > 0) {
    $_SESSION['add_data_alert'] = 1;
    header("location:../detail_status.php?id=$get_r_id");
} else {
    $sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND status_id = '3' AND del_flg = 0";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE repair_status SET rs_conf = 1 , rs_conf_date = NOW() WHERE status_id = '24' AND del_flg = 0";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $sql = "INSERT INTO repair_status (get_r_id,rs_date_time,rs_detail,status_id) VALUES ('$get_r_id' ,NOW(),'คุณได้ทำการตรวจเช็คและทำการยืนยันเสร็จสิ้นการซ่อมเรียบร้อยแล้ว','3')";
        $result = mysqli_query($conn, $sql);

        $_SESSION['add_data_alert'] = 0;
        header("location:../detail_status.php?id=$get_r_id");
    } else {
        $_SESSION['add_data_alert'] = 1;
        header("location:../detail_status.php?id=$get_r_id");
    }
}

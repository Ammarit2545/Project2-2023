<?php
session_start();
include('../../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$get_r_id  = $_GET['id'];

echo $get_r_id;

$sql = "SELECT * FROM repair_status WHERE status_id = 5 AND get_r_id = '$get_r_id'";
$result = mysqli_query($conn, $sql);
$row_c = mysqli_fetch_array($result);

if ($row_c[0] > 0) {
    $_SESSION["add_data_alert"] = 1;
    header("Location: ../../detail_repair.php?id=$get_r_id");
} else {

    $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
         VALUES ('$get_r_id', NOW(), 'กรุณาทำการส่งเครื่องเสียงและอุปกรณ์ต่อพ่วงที่ต้องการซ่อมมาให้ทางร้านทำการซ่อม','5')";
    $result3 = mysqli_query($conn, $sql3);

    if ($result3) {
        $_SESSION["add_data_alert"] = 0;
        header("Location: ../../detail_repair.php?id=$get_r_id");
    }
}

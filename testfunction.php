<?php
session_start();
include('database/condb.php');

$get_r_id = 164; // Remove single quotes for integer value

$sql_insert = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id) VALUES ('$get_r_id', NOW(), 'ทางร้านต้องขอแจ้งให้ทราบว่าคุณไม่ได้ชำระเงินตามระยะเวลาที่กำหนด (ระยะเวลาเก็บอุปกรณ์ของท่านคือ 1 ปี) ดังนั้นเราขอทำการเก็บอุปกณ์ของท่านเป็นทรัพย์สินของทางร้าน โปรดทราบว่าเราจะไม่มีการดำเนินการคืนเงินหรือรับผิดชอบแต่อย่างใดต่อของท่านในกรณีนี้', 14)";
$result_insert = mysqli_query($conn, $sql_insert);

if ($result_insert) {
    $response[] = ['get_r_id' => $get_r_id];
    echo 'True';
} else {
    echo 'Not';
}
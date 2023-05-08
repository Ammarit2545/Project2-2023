<?php
session_start();
include('database/condb.php');

// $sql1 = "UPDATE status_type SET status_name = 'รายละเอียด' WHERE status_id = 4;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ยืนยันการซ่อม' WHERE status_id = 5;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ดำเนินการซ่อม' WHERE status_id = 6;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ดำเนินการตรวจเช็ค' WHERE status_id = 7;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ซ่อมเสร็จสิ้น รอการชำระเงิน' WHERE status_id = 8;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ชำระเงินเรียบร้อย' WHERE status_id = 9;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ดำเนินกาส่งเครื่องเสียง' WHERE status_id = 10;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ปฏิเสธการซ่อม' WHERE status_id = 11;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ยกเลิกการซ่อม' WHERE status_id = 12;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'เกิดปัญหาระหว่างซ่อม' WHERE status_id = 13;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

$sql1 = "UPDATE status_type SET status_name = 'เกินเวลาชำระเงินตามที่กำหนด' WHERE status_id = 14;";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);

// $folderName = "uploads/4"; // the name of the new folder
//         if (!file_exists($folderName)) { // check if the folder already exists
//             mkdir($folderName); // create the new folder
//             echo "Folder created successfully";
//         } else {
//             echo "Folder already exists";
//         }

?>

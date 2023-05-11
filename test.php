<?php
session_start();
include('database/condb.php');

$sToken = "T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3";
// T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3

$dateString = date('Y-m-d');
$date = DateTime::createFromFormat('Y-m-d', $dateString);
$formattedDate = $date->format('d F Y');

$sMessage = "\nวันที่ : " . $formattedDate . "\n";
$sMessage .= "\nมีการแจ้งซ่อมใหม่เข้ามา : " . "\n";
$sMessage .= "เลขที่ใบส่งซ่อม : " . $id_r_g;
$sMessage .= "\nชื่อ : " . $row_m['m_fname'] . " " . $row_m['m_lname'] . "\n";
$sMessage .= "เบอร์โทรติดต่อ : " . $_SESSION["tel"] . "\n";

$chOne = curl_init();
curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($chOne, CURLOPT_POST, 1);
curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
$headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($chOne);

//Result error 
if (curl_error($chOne)) {
    echo 'error:' . curl_error($chOne);
} else {
    $result_ = json_decode($result, true);
    echo "status : " . $result_['status'];
    echo "message : " . $result_['message'];
}
curl_close($chOne);

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

// $sql1 = "UPDATE status_type SET status_name = 'เกินเวลาชำระเงินตามที่กำหนด' WHERE status_id = 14;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $folderName = "uploads/4"; // the name of the new folder
//         if (!file_exists($folderName)) { // check if the folder already exists
//             mkdir($folderName); // create the new folder
//             echo "Folder created successfully";
//         } else {
//             echo "Folder already exists";
//         }

?>

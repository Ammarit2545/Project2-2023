<?php
session_start();
include('../database/condb.php');
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$tel = mysqli_real_escape_string($conn, $_POST['tel']);
$address = mysqli_real_escape_string($conn, $_POST['address']);

$id = $_SESSION["id"];

$sql = "UPDATE `member` SET m_fname = '$fname', m_lname = '$lname', m_tel = '$tel', m_add = '$address' WHERE m_id = '$id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('บันทึกข้อมูลเสร็จสิ้น');</script>";
    echo "<script>window.location='../home.php';</script>";
} else {
    echo "<script>alert('บันทึกข้อมูลไม่สำเร็จ');</script>";
    echo "<script>window.location='../edit_user.php';</script>";
}

// echo ($address);
?>

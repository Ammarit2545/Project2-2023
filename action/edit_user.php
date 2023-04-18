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

$sql1 = "SELECT * FROM member WHERE m_id = '$id '";
$result1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_array($result1);


if ($result) {
    $_SESSION["email"] = $row['m_email'];
    $_SESSION["id"] = $row['m_id'];
    $_SESSION["tel"] = $row['m_tel'];
    $_SESSION["fname"] = $row['m_fname'];
    $_SESSION["lname"] = $row['m_lname'];
    $_SESSION["address"] = $row['m_add'];

    echo "<script>alert('บันทึกข้อมูลเสร็จสิ้น');</script>";
    echo "<script>window.location='../home.php';</script>";
} else {
    echo "<script>alert('บันทึกข้อมูลไม่สำเร็จ');</script>";
    echo "<script>window.location='../edit_user.php';</script>";
}

// echo ($address);
?>

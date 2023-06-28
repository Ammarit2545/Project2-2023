<?php
session_start();
include('../database/condb.php');
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$tel = mysqli_real_escape_string($conn, $_POST['tel']);

$id = $_SESSION["id"];

$address_json;
if (isset($_POST['Ref_prov_id']) && isset($_POST['Ref_dist_id']) && isset($_POST['Ref_subdist_id']) && isset($_POST['zip_code']) && isset($_POST['description'])) {

    $address = array("province" => $_POST['Ref_prov_id'], "district" => $_POST['Ref_dist_id'], "sub_district" => $_POST['Ref_subdist_id'], "zip_code" => $_POST['zip_code'], "description" => $_POST['description']);
    $address_json = json_encode($address);
} else {
    $address_json = $row['m_add'];
}

$sql = "UPDATE `member` SET m_fname = '$fname', m_lname = '$lname', m_tel = '$tel', m_add = '$address_json', m_date_in = NOW() WHERE m_id = '$id'";
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

    // echo "<script>alert('บันทึกข้อมูลเสร็จสิ้น');</script>";
    $_SESSION['add_data_alert'] = 6;
    header("location:../index.php");
    // echo "<script>window.location='../index.php';</script>";
} else {
    // echo "<script>alert('บันทึกข้อมูลไม่สำเร็จ');</script>";
    $_SESSION['add_data_alert'] = 6;
    header("location:../index.php");
    // echo "<script>window.location='../edit_user.php';</script>";
}
?>

<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$name_brand = $_POST['name_brand'];
$serial_number = $_POST['serial_number'];
$name_model = $_POST['name_model'];
$number_model = $_POST['number_model'];
$company = $_POST['company'];
$guarantee = $_POST['guarantee'];
$m_id = $_POST['m_id'];

$id = $_SESSION["id"];

if ($m_id != NULL) {
    $sql_member = "SELECT * FROM member WHERE m_id = $m_id  AND del_flg = 0";
    $result_member = mysqli_query($conn, $sql_member);
    $row_member = mysqli_fetch_array($result_member);

    // check serial number before insert
    $sql_serial = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$m_id' AND del_flg = 0";
} else {
    $sql_serial = "SELECT * FROM repair WHERE r_serial_number = '$serial_number'";
}

$result__serial = mysqli_query($conn, $sql_serial);
$row_serial = mysqli_fetch_array($result__serial);
if ($row_serial[0] > 0) {
    $_SESSION["add_data_alert"] = 1;
    header("Location: ../add_new_equipment.php?");
    exit();
} else {
    $sql = "INSERT INTO repair (m_id, r_brand, r_model, r_number_model, r_serial_number, com_id, r_guarantee, r_date_buy)
    VALUES ('$m_id', '$name_brand', '$name_model', '$number_model', '$serial_number', '$company', '$guarantee', NOW())";
     $result = mysqli_query($conn, $sql);


    $sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '0'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    // $_SESSION["e_id"] = $row_log['e_id'];

    $sToken = "T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3";
    // T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3

    $dateString = date('Y-m-d');
    $date = DateTime::createFromFormat('Y-m-d', $dateString);
    $formattedDate = $date->format('d F Y');

    $sMessage = "\nวันที่ : " . $formattedDate . "\n";
    $sMessage .= "\nมีการแจ้งซ่อมใหม่เข้ามา : " . "\n";
    $sMessage .= "Brand : " . $name_brand;
    $sMessage .= "\nModel : " . $name_model;
    $sMessage .= "\nSerial Number : " . $serial_number;
    if($company > 0){
        $sMessage .= "\nCompany : " . $company;
    }
    $sMessage .= "\nระยะประกัน : " . $guarantee . " ปี";
    $sMessage .= "\n\nเพิ่มโดย :";
    $sMessage .= "\nID : " . $_SESSION["id"];
    $sMessage .= "\nName : " . $_SESSION["fname"];
    

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

    unset($_SESSION["id_repair"]);
    unset($_SESSION["name_brand"]);
    unset($_SESSION["serial_number"]);
    unset($_SESSION["name_model"]);
    unset($_SESSION["number_model"]);
    unset($_SESSION["tel"]);
    $_SESSION["add_data_alert"] = 0;
    header("Location: ../add_new_equipment.php?id=" . $insertedId_get);
    exit();
}

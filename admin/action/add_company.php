<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$com_name = $_POST['com_name'];
$com_tel = $_POST['com_tel'];
$com_fax = $_POST['com_fax'];
$com_add = $_POST['com_add'];

$sql_p = "SELECT * FROM company WHERE com_name = '$com_name' ";
$result = mysqli_query($conn, $sql_p);
$row = mysqli_fetch_array($result);

if ($row['com_id'] > 0) {
    header('Location:../listview_company.php');
} else {

    $sql_p = "INSERT INTO company (com_name, com_tel ,com_fax ,com_add ,del_flg) 
    VALUES ('$com_name','$com_tel','$com_fax','$com_add' ,'0')";
    $result = mysqli_query($conn, $sql_p);

    if ($result) {
        header('Location:../listview_company.php');
    }
}

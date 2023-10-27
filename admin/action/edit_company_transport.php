<?php
session_start();
include('../../database/condb.php');

foreach ($_POST as $key => $value) {
    echo $key . ": " . $value . "<br>";
}

$com_id = $_POST['com_id'];
$com_name = $_POST['com_name'];
$com_tel = $_POST['com_tel'];
$com_fax = $_POST['com_fax'];
$com_add = $_POST['com_add'];

$sql = "UPDATE company_transport 
        SET com_t_name = '$com_name'
        WHERE com_t_id = '$com_id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['add_data_com_transport'] = 1;
    header('Location:../listview_company_transpost.php');
} else {
    $_SESSION['add_data_com_transport'] = 0;
    header('Location:../edit_company_transport.php?id=' . urlencode($com_id));
}

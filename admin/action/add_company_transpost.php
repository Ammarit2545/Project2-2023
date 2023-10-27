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

$sql_p = "SELECT * FROM company_transport WHERE com_t_name = '$com_name' ";
$result = mysqli_query($conn, $sql_p);
$row = mysqli_fetch_array($result);

if ($row['com_t_id'] > 0) {
    header('Location:../listview_company_transpost.php');
    
} else {

    $sql_p = "INSERT INTO company_transport (com_t_name, del_flg) 
    VALUES ('$com_name' ,'0')";
    $result = mysqli_query($conn, $sql_p);

    if ($result) {
        $_SESSION['add_data_com_transport'] = 1;
        header('Location:../listview_company_transpost.php');
    }else{
        $_SESSION['add_data_com_transport'] = 0;
        header('Location:../listview_company_transpost.php');
    }
}

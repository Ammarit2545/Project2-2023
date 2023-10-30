<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$com_name = $_POST['com_name'];

$sql_p = "SELECT * FROM company_parts WHERE com_p_name = '$com_name' ";
$result = mysqli_query($conn, $sql_p);
$row = mysqli_fetch_array($result);

if ($row['com_t_id'] > 0) {
    header('Location:../listview_company_parts.php');
} else {

    $sql_p = "INSERT INTO company_parts (com_p_name, del_flg) 
    VALUES ('$com_name' ,'0')";
    $result = mysqli_query($conn, $sql_p);

    if ($result) {
        $_SESSION['add_data_com_transport'] = 1;
        header('Location:../listview_company_parts.php');
    } else {
        $_SESSION['add_data_com_transport'] = 0;
        header('Location:../listview_company_parts.php');
    }
}

<?php
session_start();
include('../../database/condb.php');

$id_c = $_GET['id'];

$sql = "UPDATE company_transport SET del_flg = '1' WHERE com_t_id = '$id_c'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['add_data_com_transport'] = 2;
    echo "Company deleted successfully";
    header('Location:../listview_company_transpost.php');
} else {
    echo "Company deleting ";
}

<?php
session_start();
include('../../database/condb.php');
$status_id = $_GET['status_id'];

echo $status_id;

$sql = "UPDATE status_type SET del_flg = '1' WHERE status_id = '$status_id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    header('Location:../listview_status.php');
    $_SESSION["add_data_alert"] = 2;
}else{
    header('Location:../listview_status.php');
    $_SESSION["add_data_alert"] = 1;
}

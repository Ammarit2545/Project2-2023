<?php
session_start();
include('../database/condb.php');
$id = $_GET['deli'];
$get_r_id = $_GET['id'];
$sql_update = "UPDATE get_repair SET get_send = '$id' ,get_add_price = NULL WHERE get_r_id = '$get_r_id'";
$result = mysqli_query($conn, $sql_update);
if($result){
    $_SESSION['add_data_alert'] = 3;
    header("location:../detail_status.php?id=$get_r_id");
}

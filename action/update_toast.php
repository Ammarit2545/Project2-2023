<?php
session_start();
include('../database/condb.php');
$id = $_GET['id'];
$sql_update = "UPDATE repair_status SET rs_watch = 1 WHERE get_r_id = '$id'";
$result = mysqli_query($conn, $sql_update);

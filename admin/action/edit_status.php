<?php
session_start();
include('../../database/condb.php');

foreach($_POST as $key => $value) {
    echo $key . ": " . $value . "<br>";
}

$status_id = $_POST['status_id'];
$status_name = $_POST['status_name'];
$status_color = $_POST['status_color'];
$value_code = $_POST['value_code'];

$sql = "UPDATE status_type SET status_name = '$status_name' , status_color = '$status_color' ,value_code = '$value_code' WHERE status_id = '$status_id'";
$result = mysqli_query($conn, $sql);

if($result){
    echo "<script>alert('Update success');</script>";
    header('Location:../listview_status.php');
    $_SESSION["add_data_alert"] = 0 ;
}else{
    echo "<script>alert('Update unsuccess');</script>";
    header('Location:../listview_status.php');
    $_SESSION["add_data_alert"] = 1 ;
}
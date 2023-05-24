<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$status_name = $_POST['status_name'];
$status_color = $_POST['status_color'];
$value_code = $_POST['value_code'];

$sql_p = "SELECT * FROM status_type WHERE status_name = '$status_name' AND value_code = '$value_code'";
$result = mysqli_query($conn, $sql_p);
$row = mysqli_fetch_array($result);

if ($row['status_id'] > 0) {
    header('Location:../listview_status.php');
    $_SESSION["add_data_alert"] = 1 ;
} else {
    $sql_p = "INSERT INTO status_type (status_name, status_color ,value_code) 
    VALUES ('$status_name', '$status_color','$value_code')";
    $result = mysqli_query($conn, $sql_p);
    $_SESSION["add_data_alert"] = 0 ;

    if ($result) {
        header('Location:../listview_status.php');
    }
}

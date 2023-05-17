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

$sql_p = "SELECT * FROM status_type WHERE status_name = '$status_name' ";
$result = mysqli_query($conn, $sql_p);
$row = mysqli_fetch_array($result);

if ($row['status_id'] > 0) {
    header('Location:../listview_status.php');
} else {
    $sql_p = "INSERT INTO status_type (status_name, status_color) 
    VALUES ('$status_name', '$status_color')";
    $result = mysqli_query($conn, $sql_p);

    if ($result) {
        header('Location:../listview_status.php');
    }
}

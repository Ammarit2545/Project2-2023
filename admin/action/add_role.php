<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$role_name = $_POST['role_name'];

$sql_p = "SELECT * FROM role WHERE role_name = '$role_name' ";
$result = mysqli_query($conn, $sql_p);
$row = mysqli_fetch_array($result);

if ($row['role_id'] > 0) {
    header('Location:../add_em_type.php');
} else {
    $sql_p = "INSERT INTO role (role_name) 
    VALUES ('$role_name')";
    $result = mysqli_query($conn, $sql_p);

    if ($result) {
        header('Location:../add_em_type.php');
    }
}

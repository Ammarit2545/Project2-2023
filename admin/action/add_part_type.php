<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$p_type_name = $_POST['p_type_name'];

$sql_p = "SELECT * FROM parts_type WHERE p_type_name = '$p_type_name' ";
$result = mysqli_query($conn, $sql_p);
$row = mysqli_fetch_array($result);

if ($row['e_id'] > 0) {
    header('Location:../add_parts_type.php');
} else {

    $sql_p = "INSERT INTO parts_type (p_type_name, p_type_date_in) 
    VALUES ('$p_type_name',NOW())";
    $result = mysqli_query($conn, $sql_p);

    if ($result) {
        header('Location:../add_parts_type.php');
    }
}

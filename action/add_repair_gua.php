<?php
    session_start();
    include('../database/condb.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST as $key => $value) {
            echo $key . ': ' . $value . '<br>';
        }
    }

    $name_brand = $_POST['name_brand'];
    $serial_number = $_POST['serial_number'];
    $name_model = $_POST['name_model'];
    $number_model = $_POST['number_model'];
    $tel = $_POST['tel'];
    $description = $_POST['description'];

    $_SESSION["name_brand"] = $_POST['name_brand'];
    $_SESSION["serial_number"] = $_POST['serial_number'];
    $_SESSION["name_model"] = $_POST['name_model'];
    $_SESSION["number_model"] = $_POST['number_model'];
    $_SESSION["tel"] = $_POST['tel'];
    $_SESSION["description"] = $_POST['description'];
    $_SESSION["company"] = $_POST['company'];

    $id = $_SESSION["id"];

    $sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if($row == NULL){
        // $sql = "INSERT INTO repair (m_id, r_brand, r_model, r_number_model, r_serial_number)
        // VALUES ('$id', '$name_brand', '$name_model', '$number_model', '$serial_number');";
        // $result = mysqli_query($conn, $sql);

        header("location:../repair_check.php");
    }else{
        echo ("ever"); 
        $id = $row[0];
        header("location:../repair_ever.php?id=$id");
    }

?>
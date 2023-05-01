<?php
    session_start();
    include('../database/condb.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST as $key => $value) {
            echo $key . ': ' . $value . '<br>';
        }
    }
    $id_r = $_POST['id_repair'];
    $name_brand = $_POST['name_brand'];
    $serial_number = $_POST['serial_number'];
    $name_model = $_POST['name_model'];
    $number_model = $_POST['number_model'];
    $tel = $_POST['tel'];
    $description = $_POST['description'];

    $_SESSION["id_repair"] = $_POST['id_repair'];
    $_SESSION["name_brand"] = $_POST['name_brand'];
    $_SESSION["serial_number"] = $_POST['serial_number'];
    $_SESSION["name_model"] = $_POST['name_model'];
    $_SESSION["number_model"] = $_POST['number_model'];
    $_SESSION["tel"] = $_POST['tel'];
    $_SESSION["description"] = $_POST['description'];

    $id = $_SESSION["id"];

    if($row == NULL){
        header("location:../repair_check_ever.php");
    }else{
        echo ("ever"); 
        $id = $row[0];
        header("location:../repair_check_ever.php?id=$id");
    }

?>
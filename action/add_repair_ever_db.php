<?php
    session_start();
    include('../database/condb.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST as $key => $value) {
            echo $key . ': ' . $value . '<br>';
        }
    }

    $id_repair = $_SESSION["id_repair"];
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

    $id = $_SESSION["id"];

    $sql = "SELECT COUNT(*) FROM get_repair WHERE r_id = '$id_repair'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo $row[0];

    $round_repair = $row[0] + 1;

    echo $round_repair;

    if($row != 0){

        $sql2 = "INSERT INTO get_repair ( r_id, get_r_record, get_r_date_in, get_r_detail)
        VALUES ( '$id_repair', '$round_repair', NOW(), '$description')";
        $result2 = mysqli_query($conn, $sql2);
        
        $sql4 = "SELECT * FROM get_repair WHERE r_id = '$id_repair' ORDER BY get_r_id DESC;";
        $result4 = mysqli_query($conn, $sql4);
        $row4 = mysqli_fetch_array($result4);
        $id_r_g = $row4['get_r_id'];

        $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
         VALUES ('$id_r_g', NOW(), 'ยื่นเรื่องซ่อม ครั้งที่ $round_repair','1')";
        $result3 = mysqli_query($conn, $sql3);

        header("location:../repair_wait.php");
    }else{
        echo ("ever"); 
        header("location:../repair_wait.php");
        // header("location:../repair_ever.php");
    }
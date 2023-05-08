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
    $image1 = $_POST['image1'];
    $image2 = $_POST['image2'];
    $image3 = $_POST['image3'];
    $image4 = $_POST['image4'];

    $_SESSION["name_brand"] = $_POST['name_brand'];
    $_SESSION["serial_number"] = $_POST['serial_number'];
    $_SESSION["name_model"] = $_POST['name_model'];
    $_SESSION["number_model"] = $_POST['number_model'];
    $_SESSION["tel"] = $_POST['tel'];
    $_SESSION["description"] = $_POST['description'];
    $_SESSION["company"] = NULL;

    $_SESSION["image1"] = $_POST['image1'];
    $_SESSION["image2"] = $_POST['image2'];
    $_SESSION["image3"] = $_POST['image3'];
    $_SESSION["image4"] = $_POST['image4'];

    for ($i = 1; $i <= 4; $i++) {
        $image_name = "image".$i;
        if (isset($_FILES[$image_name])) {
            $target_dir ="../uploads/$id/";
            $target_file = $target_dir . basename($_FILES[$image_name]["name"]);

            $_SESSION["$image_name"] = basename($_FILES[$image_name]["name"]);

            // $uploadOk = 1;
            // $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        }
    }

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
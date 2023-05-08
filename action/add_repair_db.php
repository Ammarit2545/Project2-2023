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
    $company = $_SESSION['company'];

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
    $_SESSION["image1"] = $_POST['image1'];
    $_SESSION["image2"] = $_POST['image2'];
    $_SESSION["image3"] = $_POST['image3'];
    $_SESSION["image4"] = $_POST['image4'];

    $id = $_SESSION["id"];

    $sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if($row == NULL){
        $sql = "INSERT INTO repair (m_id, r_brand, r_model, r_number_model, r_serial_number ,com_id)
        VALUES ('$id', '$name_brand', '$name_model', '$number_model', '$serial_number' ,'$company')";
        $result = mysqli_query($conn, $sql);

        $sql1 = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$id'";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_array($result1);
        $id_r = $row1['r_id'];

        $sql2 = "INSERT INTO get_repair ( r_id, get_r_record, get_r_date_in, get_r_detail ,get_tel)
        VALUES ( '$id_r', '1', NOW(), '$description','$tel')";
        $result2 = mysqli_query($conn, $sql2);
        
        $sql4 = "SELECT * FROM get_repair WHERE r_id = '$id_r' ORDER BY get_r_id DESC;";
        $result4 = mysqli_query($conn, $sql4);
        $row4 = mysqli_fetch_array($result4);
        $id_r_g = $row4['get_r_id'];

        $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
         VALUES ('$id_r_g', NOW(), 'ยื่นเรื่องซ่อม','1')";
        $result3 = mysqli_query($conn, $sql3);

        $folderName = "../uploads/$id/$id_r_g/"; // the name of the new folder
        if (!file_exists($folderName)) { // check if the folder already exists
            mkdir($folderName); // create the new folder
            echo "Folder created successfully";
        } else {
            echo "Folder already exists";
        }

        // Loop over the four images
        for ($i = 1; $i <= 4; $i++) {

            $image_name = "image".$i;
            if (isset($_FILES[$image_name])) {
                $target_dir = $folderName;
                $target_file = $target_dir . basename($_FILES[$image_name]["name"]);

                $target_file_db = "/uploads/$id/$id_r_g/" . basename($_FILES[$image_name]["name"]);

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
                // Check if image file is a actual image or fake image
                // $check = getimagesize($_FILES[$image_name]["tmp_name"]);
                // if($check === false) {
                //     echo "File is not an image.";
                //     $uploadOk = 0;
                // }
            
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
            
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "mp4" && $imageFileType != "mov" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                        echo "The file ". htmlspecialchars( basename($_FILES[$image_name]["name"])). " has been uploaded.";

                        // Insert To  DATABASE 
                        $sql_p = "INSERT INTO repair_pic ( r_get_id, rp_pic, rp_date)
                        VALUES ('$id_r_g', '$target_file_db', NOW())";
                        $result_p = mysqli_query($conn, $sql_p);
                        
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }

            }
        }

        header("location:../repair_wait.php");
    }else{
        echo ("ever"); 
        header("location:../repair_wait.php");
        // header("location:../repair_ever.php");
    }
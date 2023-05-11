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

    
function deleteDirectory($dir)
{
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}

// Usage:
$folderName = "../uploads/$id/Holder/"; // the name of the folder to be deleted
deleteDirectory($folderName);

$folderName = "../uploads/$id/Holder/"; // the name of the new folder
if (!file_exists($folderName)) { // check if the folder already exists
    mkdir($folderName); // create the new folder
    echo "Folder created successfully";
} else {
    echo "Folder already exists";
}

// Loop over the four images
for ($i = 1; $i <= 4; $i++) {

    $image_name = "image" . $i;
    if (isset($_FILES[$image_name])) {
        $target_dir = $folderName;
        $target_file = $target_dir . basename($_FILES[$image_name]["name"]);

        $target_file_db = "/uploads/$id/Holder/" . basename($_FILES[$image_name]["name"]);

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
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != "mp4" && $imageFileType != "mov"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES[$image_name]["name"])) . " has been uploaded.";

                // Insert To  DATABASE 
                // $sql_p = "INSERT INTO repair_pic ( r_get_id, rp_pic, rp_date)
                //     VALUES ('$id_r_g', '$target_file_db', NOW())";
                // $result_p = mysqli_query($conn, $sql_p);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

$target_dir = "../uploads/$id/"; // Change this to the desired location
$target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file);


    $sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    for ($i = 1; $i <= 4; $i++) {
        $image_name = "image" . $i;
        if (isset($_FILES[$image_name])) {
            $target_dir = "../uploads/$id/";
            $target_file = $target_dir . basename($_FILES[$image_name]["name"]);
    
            $_SESSION["$image_name"] = basename($_FILES[$image_name]["name"]);
    
            // $uploadOk = 1;
            // $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        }
    }

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

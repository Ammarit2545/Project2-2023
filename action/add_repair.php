<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}
$id = $_SESSION["id"];

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



$i = 1;
while (isset($_SESSION['r_id_' . $i])) {
    $i++;
}

// Delete Folder Holder:
$folderName = "../uploads/$id/Holder/$i/"; // the name of the folder to be deleted
deleteDirectory($folderName);

$folderName = "../uploads/$id/Holder/"; // the name of the new folder
if (!file_exists($folderName)) { // check if the folder already exists
    mkdir($folderName); // create the new folder
    echo "Folder created successfully";
} else {
    echo "Folder already exists";
}

$folderName = "../uploads/$id/Holder/$i/"; // the name of the new folder
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
        $file_extension = strtolower(pathinfo($_FILES[$image_name]["name"], PATHINFO_EXTENSION));
        $filename = $i . "_" . $serial_number . "." . $file_extension; // New filename
        $target_file = $target_dir . $filename;

        $target_file_db = "/uploads/$id/Holder/$i/" . $filename;

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_extensions = ["jpg", "jpeg", "png", "gif", "mp4", "mov", "jfif"];
        if (!in_array($file_extension, $allowed_extensions)) {
            echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, and MOV files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES[$image_name]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

$target_dir = "../uploads/$id/"; // Change this to the desired location
$target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file);

$_SESSION["name_brand"] = $_POST['name_brand'];
$_SESSION["serial_number"] = $_POST['serial_number'];
$_SESSION["name_model"] = $_POST['name_model'];
$_SESSION["number_model"] = $_POST['number_model'];
$_SESSION["tel"] = $_POST['tel'];
$_SESSION["description"] = $_POST['description'];
if (isset($_POST['id_repair_ever'])) {
    $_SESSION['id_repair_ever'] = 1;
}

if ($_POST['id_repair'] != NULL) {
    $_SESSION["id_repair"] = $_POST['id_repair'];
} else {
    $_SESSION["id_repair"] = NULL;
}

if ($_POST['flexRadioDefault'] == 'have_gua') {
    $_SESSION["company"] = $_POST['company'];
} else {
    $_SESSION["company"] = NULL;
}


$_SESSION["image1"] = $_POST['image1'];
$_SESSION["image2"] = $_POST['image2'];
$_SESSION["image3"] = $_POST['image3'];
$_SESSION["image4"] = $_POST['image4'];


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

$id = $_SESSION["id"];

$sql = " SELECT repair.r_id,get_detail.`get_d_id`,get_detail.`get_r_id` FROM repair 
        LEFT JOIN get_detail ON get_detail.r_id = repair.r_id
        LEFT JOIN get_repair ON get_detail.get_r_id = get_repair.get_r_id
        LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
        WHERE repair.r_serial_number = '$serial_number' 
        AND repair.del_flg = 0 AND get_repair.del_flg = 0 AND get_detail.del_flg = 0
        AND repair_status.status_id = 3 AND repair.m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($row == NULL || isset($_POST['id_repair_ever']) || isset($_SESSION["id_repair_ever"])) {

    $sql = "SELECT repair.r_id, get_detail.get_d_id, get_detail.get_r_id
            FROM repair_status
            LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
            LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
            LEFT JOIN repair ON get_detail.r_id = repair.r_id
            WHERE repair.r_serial_number = '$serial_number' 
            AND get_repair.del_flg = '0' 
            AND repair.del_flg = '0' 
            AND get_detail.del_flg = '0'
            AND repair_status.status_id != '3'
            AND repair.m_id = '$id';
            ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_array($result);
        // ever repair
        $id = $row['r_id'];
        $get_r_id = $row['get_r_id'];
        $_SESSION['sn_check_success'] = 1;
        header("location:../repair_ever.php?id=$id&get_r_id=$get_r_id");
    } else {
        // never repair
        unset($_SESSION['sn_check_success']);
        header("location:../repair_check.php");
    }
} else {
    unset($_SESSION['sn_check_success']);
    // ever repair
    $id = $row[0];
    header("location:../repair_ever.php?id=$id");
}

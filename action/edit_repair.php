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

$session_number = $_POST['session_number'];
$i = $session_number;


$r_id = 'r_id_' . $i;

if (isset($_SESSION[$r_id])) {

    $name_brand = 'name_brand_' . $i;
    $_SESSION[$name_brand] = $_POST['name_brand'];

    $serial_number = 'serial_number_' . $i;
    $_SESSION[$serial_number] = $_POST['serial_number'];

    $name_model = 'name_model_' . $i;
    $_SESSION[$name_model] = $_POST['name_model'];

    $number_model = 'number_model_' . $i;
    $_SESSION[$number_model] = $_POST['number_model'];

    $tel = 'tel_' . $i;
    $_SESSION[$tel] = $_POST['tel'];

    $description = 'description_' . $i;
    $_SESSION[$description] = $_POST['description'];

    if ($_POST['flexRadioDefault'] == 'have_gua') {
        $company = 'company_' . $i;
        $_SESSION[$company] = $_POST["company"];
    } else {
        $company = 'company_' . $i;
        $_SESSION[$company] = NULL;
    }


    $image1 = 'image1_' . $i;
    $_SESSION[$image1] = $_POST['image1'];

    $image2 = 'image2_' . $i;
    $_SESSION[$image2] = $_POST['image2'];

    $image3 = 'image3_' . $i;
    $_SESSION[$image3] = $_POST['image3'];

    $image4 = 'image4_' . $i;
    $_SESSION[$image4] = $_POST['image4'];
}

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
        if ($_FILES[$image_name] != NULL) {
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
            $allowed_extensions = ["jpg", "jpeg", "png", "gif", "mp4", "mov", "jiff"];
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
}

$target_dir = "../uploads/$id/"; // Change this to the desired location
$target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file);




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

$sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

unset($_SESSION["id_repair"]);
unset($_SESSION["name_brand"]);
unset($_SESSION["serial_number"]);
unset($_SESSION["name_model"]);
unset($_SESSION["number_model"]);
unset($_SESSION["tel"]);
unset($_SESSION["description"]);
unset($_SESSION["company"]);
unset($_SESSION["image1"]);
unset($_SESSION["image2"]);
unset($_SESSION["image3"]);
unset($_SESSION["image4"]);

if ($row == NULL) {
    // header("location:../repair_check.php");
    header("location:../listview_repair.php");
} else {
    echo ("ever");
    $id = $row[0];
    header("location:../listview_repair.php?id=$id");
}

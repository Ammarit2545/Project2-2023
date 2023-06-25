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
        // Your existing code for file upload...

        // After file upload, resize the image
        $resized_target_file = $target_dir . "resized_" . $filename;
        $max_width = 800; // Maximum width for the resized image
        $max_height = 600; // Maximum height for the resized image

        list($original_width, $original_height) = getimagesize($target_file);
        $aspect_ratio = $original_width / $original_height;

        if ($original_width > $max_width || $original_height > $max_height) {
            if ($max_width / $max_height > $aspect_ratio) {
                $max_width = $max_height * $aspect_ratio;
            } else {
                $max_height = $max_width / $aspect_ratio;
            }

            $resized_image = imagecreatetruecolor($max_width, $max_height);

            // Load the original image
            switch ($imageFileType) {
                case "jpg":
                case "jpeg":
                    $source_image = imagecreatefromjpeg($target_file);
                    break;
                case "png":
                    $source_image = imagecreatefrompng($target_file);
                    break;
                case "gif":
                    $source_image = imagecreatefromgif($target_file);
                    break;
                    // Add support for other image formats if needed
                default:
                    // Unsupported image format
                    $source_image = null;
            }

            if ($source_image) {
                // Resize the image
                imagecopyresampled(
                    $resized_image,
                    $source_image,
                    0,
                    0,
                    0,
                    0,
                    $max_width,
                    $max_height,
                    $original_width,
                    $original_height
                );

                // Save the resized image
                switch ($imageFileType) {
                    case "jpg":
                    case "jpeg":
                        imagejpeg($resized_image, $resized_target_file);
                        break;
                    case "png":
                        imagepng($resized_image, $resized_target_file);
                        break;
                    case "gif":
                        imagegif($resized_image, $resized_target_file);
                        break;
                        // Add support for other image formats if needed
                }

                imagedestroy($source_image);
                imagedestroy($resized_image);

                // Output success message
                echo "The file has been uploaded and resized.";
            } else {
                echo "Sorry, there was an error resizing the image.";
            }
        } else {
            // No need to resize, simply move the uploaded file to the target directory
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

$sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($row == NULL) {
    // header("location:../repair_check.php");
    header("location:../repair_check.php");
} else {
    echo ("ever");
    $id = $row[0];
    header("location:../repair_ever.php?id=$id");
}

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

$i = 1;
while (isset($_SESSION['r_id_' . $i])) {
    $i++;
}

$directory = "../uploads/$id/Holder/$i/"; // Directory path where your files will be located

if (!is_dir($directory)) {
    mkdir($directory, 0777, true); // Create the directory if it doesn't exist
}

$count = 1;
while (isset($_FILES['image' . $count])) {
    if ($_FILES['image' . $count]['name'] != '') {
        echo '<br>' . $_FILES['image' . $count]['name'];

        $files = glob($directory . $count . "_*"); // Get all files that start with the specified index

        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $image_name = "image" . $count;
        if (isset($_FILES[$image_name])) {
            $target_dir = $directory;
            $file_extension = strtolower(pathinfo($_FILES[$image_name]["name"], PATHINFO_EXTENSION));
            $filename = $count . "_" . $serial_number . "." . $file_extension; // New filename
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
    } else {
        echo '<br>' . 'is_null_' . $count;
    }
    $count++;
}

// Store the uploaded file names in session variables
for ($i = 1; $i <= 4; $i++) {
    $image_name = "image" . $i;
    if (isset($_FILES[$image_name])) {
        $_SESSION[$image_name] = $_FILES[$image_name]["name"];
    }
}

// Store other form data in session variables
$_SESSION["name_brand"] = $name_brand;
$_SESSION["serial_number"] = $serial_number;
$_SESSION["name_model"] = $name_model;
$_SESSION["number_model"] = $number_model;
$_SESSION["tel"] = $tel;
$_SESSION["description"] = $description;
if ($_POST['flexRadioDefault'] == 'have_gua') {
    $_SESSION["company"] = $_POST['company'];
} else {
    $_SESSION["company"] = NULL;
}

// Redirect to the appropriate page
$sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($row == NULL) {
    header("location:../repair_check.php");
} else {
    $id = $row[0];
    header("location:../repair_ever.php?id=$id");
}

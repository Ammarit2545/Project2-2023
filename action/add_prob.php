<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }

    $id = $_SESSION["id"];
    $get_r_id = $_GET['id'];
    $comments = $_POST['comments'];
    $comments = str_replace("'", "/'", $comments);

    $sql3 = "UPDATE repair_status SET rs_conf = '1', rs_conf_date = NOW(), rs_cancel_detail = '$comments' WHERE status_id = '24' AND get_r_id = '$get_r_id'";
    $result3 = mysqli_query($conn, $sql3);

    if ($result3) {
        $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
                VALUES ('$get_r_id', NOW(), '$comments', '20')";
        $result3 = mysqli_query($conn, $sql3);
        $insertedId = mysqli_insert_id($conn);
        $folderName = "../uploads/$id/$get_r_id/$insertedId/"; // the name of the new folder

        if (!file_exists($folderName)) {
            mkdir($folderName, 0777, true); // create the new folder recursively
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

                $target_file_db = "uploads/$id/$get_r_id/$insertedId/" . basename($_FILES[$image_name]["name"]);

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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
                } else {
                    if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                        echo "The file " . htmlspecialchars(basename($_FILES[$image_name]["name"])) . " has been uploaded.";
                        // Insert to database
                        $sql_p = "INSERT INTO repair_pic (rs_id, rp_pic, rp_date)
                        VALUES ('$insertedId', '$target_file_db', NOW())";
                        $result_p = mysqli_query($conn, $sql_p);
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }

        header('Location: ../detail_status.php?id=' . $get_r_id);
        exit; // Important to stop the script after redirection
    }
}

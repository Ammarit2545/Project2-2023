<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}
$get_r_id = $_POST['get_r_id'];
$id = $_SESSION["id"];
// echo $id;

$sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND status_id = '8' AND rs_conf = '1'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($row[0] > 0) {
    $_SESSION['add_data_alert'] = 1;
    header("location:../status_detail.php?id=$get_r_id");
} else {
    if (isset($_POST['Ref_prov_id']) && isset($_POST['Ref_dist_id']) && isset($_POST['Ref_subdist_id']) && isset($_POST['zip_code']) && isset($_POST['description'])) {

        $address = array("province" => $_POST['Ref_prov_id'], "district" => $_POST['Ref_dist_id'], "sub_district" => $_POST['Ref_subdist_id'], "zip_code" => $_POST['zip_code'], "description" => $_POST['description']);
        $address_json = json_encode($address);

        $sql = "SELECT * FROM get_repair WHERE get_r_id = '$get_r_id' AND get_add = '$address_json' AND del_flg =0";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if ($row[0] == NULL) {
            $sql = "UPDATE get_repair SET get_add = '$address_json' WHERE get_r_id = '$get_r_id'";
            $result = mysqli_query($conn, $sql);
            echo "update complete";

            $sql = "UPDATE repair_status SET rs_conf = '1' ,rs_conf_date = NOW() WHERE get_r_id = '$get_r_id' AND status_id = '8'";
            $result1 = mysqli_query($conn, $sql);

            if ($result1) {
                $sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND status_id ='8'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                if ($row[0] > 0) {
                    $rs_id = $row['rs_id'];

                    $folderName = "../uploads/$id/$get_r_id/payment_evidence/"; // the name of the new folder

                    if (!file_exists($folderName)) {
                        mkdir($folderName, 0777, true); // create the new folder recursively
                        echo "Folder created successfully";
                    } else {
                        echo "Folder already exists";
                    }

                    // Loop over the four images
                    $image_name = "conf_img";

                    if (isset($_FILES[$image_name])) {
                        $target_dir = $folderName;
                        $target_file = $target_dir . '/' . basename($_FILES[$image_name]["name"]);

                        $target_file_db = "/uploads/$id/$get_r_id/payment_evidence/" . basename($_FILES[$image_name]["name"]);

                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        // Check if file already exists
                        if (file_exists($target_file)) {
                            echo "Sorry, file already exists.";
                            $uploadOk = 0;
                        }

                        // Allow certain file formats
                        $allowedFormats = ["jpg", "jpeg", "png", "gif", "mp4", "mov"];
                        if (!in_array($imageFileType, $allowedFormats)) {
                            echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, and MOV files are allowed.";
                            $uploadOk = 0;
                        }

                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            echo "Sorry, your file was not uploaded.";
                        } else {
                            if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                                echo "The file " . htmlspecialchars(basename($_FILES[$image_name]["name"])) . " has been uploaded.";

                                $sql = "INSERT INTO repair_pic (rs_id, rp_date, rp_pic) 
                    VALUES ('$rs_id', NOW(), '$target_file_db')";
                                $result1 = mysqli_query($conn, $sql);

                                if ($result1) {
                                    echo "Database record inserted successfully.";
                                } else {
                                    echo "Error inserting record: " . mysqli_error($conn);
                                }
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    }

                    $_SESSION['add_data_alert'] = 0;
                    header("location:../status_detail.php?id=$get_r_id");
                } else {
                    $_SESSION['add_data_alert'] = 1;
                    header("location:../status_detail.php?id=$get_r_id");
                }
            }
        } else {
            $_SESSION['add_data_alert'] = 1;
            header("location:../status_detail.php?id=$get_r_id");
        }


        if ($result) {
            $_SESSION['add_data_alert'] = 1;
            header("location:../status_detail.php?id=$get_r_id");
        }


        echo $address_json;
    } else {
        $sql = "UPDATE get_repair SET get_add_price = NULL, get_add = NULL WHERE get_r_id = '$get_r_id'";
        $result = mysqli_query($conn, $sql);
        // echo "update complete";

        $sql = "UPDATE repair_status SET rs_conf = '1' ,rs_conf_date = NOW() WHERE get_r_id = '$get_r_id' AND status_id = '8'";
        $result1 = mysqli_query($conn, $sql);

        if ($result1) {
            $sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND status_id ='8'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            if ($row[0] > 0) {
                $rs_id = $row['rs_id'];

                $folderName = "../uploads/$id/$get_r_id/payment_evidence/"; // the name of the new folder

                if (!file_exists($folderName)) {
                    mkdir($folderName, 0777, true); // create the new folder recursively
                    echo "Folder created successfully";
                } else {
                    echo "Folder already exists";
                }

                // Loop over the four images
                $image_name = "conf_img";

                if (isset($_FILES[$image_name])) {
                    $target_dir = $folderName;
                    $target_file = $target_dir . '/' . basename($_FILES[$image_name]["name"]);

                    $target_file_db = "uploads/$id/$get_r_id/payment_evidence/" . basename($_FILES[$image_name]["name"]);

                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    $allowedFormats = ["jpg", "jpeg", "png", "gif", "mp4", "mov"];
                    if (!in_array($imageFileType, $allowedFormats)) {
                        echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, and MOV files are allowed.";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    } else {
                        if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                            echo "The file " . htmlspecialchars(basename($_FILES[$image_name]["name"])) . " has been uploaded.";

                            $sql = "INSERT INTO repair_pic (rs_id, rp_date, rp_pic) 
                                        VALUES ('$rs_id', NOW(), '$target_file_db')";
                            $result1 = mysqli_query($conn, $sql);

                            if ($result1) {
                                echo "Database record inserted successfully.";
                            } else {
                                echo "Error inserting record: " . mysqli_error($conn);
                            }
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                }

                $_SESSION['add_data_alert'] = 0;
                header("location:../status_detail.php?id=$get_r_id");
            } else {
                $_SESSION['add_data_alert'] = 1;
                header("location:../status_detail.php?id=$get_r_id");
            }
        }

        echo $address_json;
    }
}

<?php
session_start();
include('../../database/condb.php');

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

$id = $_SESSION["id"];

    $sql = "INSERT INTO repair (m_id, r_brand, r_model, r_number_model, r_serial_number ,com_id)
        VALUES ('0', '$name_brand', '$name_model', '$number_model', '$serial_number' ,'$company')";
    $result = mysqli_query($conn, $sql);

    $sql1 = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '0'";
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

    $sql5 = "SELECT * FROM repair_status WHERE get_r_id = $id_r_g AND status_id = 1";
    $result5 = mysqli_query($conn, $sql5);
    $row5 = mysqli_fetch_array($result5);
    $rs_id = $row5['rs_id'];

    $folderName = "../../uploads/admin/$id_r_g/"; // the name of the new folder
    if (!file_exists($folderName)) { // check if the folder already exists
        mkdir($folderName); // create the new folder
        echo "Folder created successfully";
    } else {
        echo "Folder already exists";
    }

    $target_dir = "../../uploads/admin/$id/$id_r_g/"; // Change this to the desired location
    $target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
    move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file);

    $sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '0'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    for ($i = 1; $i <= 4; $i++) {
        $image_name = "image" . $i;
        if (isset($_FILES[$image_name])) {
            $target_dir = "../../uploads/admin/$id_r_g/";
            $target_file = $target_dir . basename($_FILES[$image_name]["name"]);

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($_FILES[$image_name]["tmp_name"]);
            if ($check !== false) {
                // File is an image
                $uploadOk = 1;
            } else {
                // File is not an image
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                // File already exists
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES[$image_name]["size"] > 5000000) {
                // File size is too large (5MB limit)
                $uploadOk = 0;
            }

            // Allow only specific file formats (e.g., JPEG, PNG)
            $allowedFormats = array("jpg", "jpeg", "png");
            if (!in_array($imageFileType, $allowedFormats)) {
                // Invalid file format
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                    // File uploaded successfully
                    $_SESSION["$image_name"] = basename($_FILES[$image_name]["name"]);
                    echo "File " . $image_name . " uploaded successfully<br>";
                } else {
                    // Error uploading file
                    echo "Error uploading file " . $image_name . "<br>";
                }
            } else {
                // File validation error
                echo "Invalid file " . $image_name . "<br>";
            }
        }
    }

    $sToken = "T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3";
    // T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3

    $dateString = date('Y-m-d');
    $date = DateTime::createFromFormat('Y-m-d', $dateString);
    $formattedDate = $date->format('d F Y');

    $sMessage = "\nวันที่ : " . $formattedDate . "\n";
    $sMessage .= "\nมีการแจ้งซ่อมใหม่เข้ามา : " . "\n";
    $sMessage .= "เลขที่ใบส่งซ่อม : " . $id_r_g;
    $sMessage .= "\nทำการเพิ่มข้อมูลด้วยตัวเอง\n";

    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chOne, CURLOPT_POST, 1);
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($chOne);

    //Result error 
    if (curl_error($chOne)) {
        echo 'error:' . curl_error($chOne);
    } else {
        $result_ = json_decode($result, true);
        echo "status : " . $result_['status'];
        echo "message : " . $result_['message'];
    }
    curl_close($chOne);

    unset($_SESSION["id_repair"]);
    unset($_SESSION["name_brand"]);
    unset($_SESSION["serial_number"]);
    unset($_SESSION["name_model"]);
    unset($_SESSION["number_model"]);
    unset($_SESSION["tel"]);
    unset($_SESSION["description"]);
    unset($_SESSION["image1"]);
    unset($_SESSION["image2"]);
    unset($_SESSION["image3"]);
    unset($_SESSION["image4"]);

    header("location:../add_self_record.php");

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

if ($row == NULL) {
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

    $sql5 = "SELECT * FROM repair_status WHERE get_r_id = $id_r_g AND status_id = 1";
    $result5 = mysqli_query($conn, $sql5);
    $row5 = mysqli_fetch_array($result5);
    $rs_id = $row5['rs_id'];

    $folderName = "../uploads/$id/$id_r_g/"; // the name of the new folder
    if (!file_exists($folderName)) { // check if the folder already exists
        mkdir($folderName); // create the new folder
        echo "Folder created successfully";
    } else {
        echo "Folder already exists";
    }

    $source_dir = "../uploads/$id/Holder/"; // Replace with the actual path to the directory you want to move the files from
    $destination_dir = "../uploads/$id/$id_r_g/"; // Replace with the actual path to the directory you want to move the files to

    if (!is_dir($destination_dir)) { // Check if the destination directory exists
        mkdir($destination_dir, 0777, true); // Create the destination directory if it doesn't exist
    }

    foreach (new DirectoryIterator($source_dir) as $file) {
        if ($file->isFile()) {
            $file_name = $file->getFilename();
            $destination_file = $destination_dir . $file_name;
            if (rename($file->getPathname(), $destination_file)) {
                echo "File " . $file_name . " moved successfully<br>";
                $path_file_pic = "uploads/$id/$id_r_g/$file_name";
                $sql_p = "INSERT INTO repair_pic (rp_pic, rp_date ,rs_id)
                       VALUES ( '$path_file_pic', NOW(),'$rs_id')";
                $result_p = mysqli_query($conn, $sql_p);
            } else {
                echo "Error moving file " . $file_name . "<br>";
            }
        }
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

    // Usage:
    $folderName = "../uploads/$id/Holder/"; // the name of the folder to be deleted
    deleteDirectory($folderName);

    $sql_m = "SELECT * FROM member WHERE m_id = '$id'";
    $result_m = mysqli_query($conn, $sql_m);
    $row_m = mysqli_fetch_array($result_m);

    $sToken = "T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3";
    // T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3

    $dateString = date('Y-m-d');
    $date = DateTime::createFromFormat('Y-m-d', $dateString);
    $formattedDate = $date->format('d F Y');

    $sMessage = "\nวันที่ : " . $formattedDate . "\n";
    $sMessage .= "\nมีการแจ้งซ่อมใหม่เข้ามา : " . "\n";
    $sMessage .= "เลขที่ใบส่งซ่อม : " . $id_r_g;
    $sMessage .= "\nชื่อ : " . $row_m['m_fname'] . " " . $row_m['m_lname'] . "\n";
    $sMessage .= "เบอร์โทรติดต่อ : " . $_SESSION["tel"] . "\n";

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

    header("location:../repair_wait.php");
} else {
    echo ("ever");
    header("location:../repair_wait.php");
    // header("location:../repair_ever.php");
}

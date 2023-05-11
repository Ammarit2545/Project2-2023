<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$id_repair = $_SESSION["id_repair"];
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

$id = $_SESSION["id"];

$sql = "SELECT COUNT(*) FROM get_repair WHERE r_id = '$id_repair'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

echo $row[0];

$round_repair = $row[0] + 1;

echo $round_repair;

if ($row != 0) {

    $sql2 = "INSERT INTO get_repair ( r_id, get_r_record, get_r_date_in, get_r_detail ,get_tel)
        VALUES ( '$id_repair', '$round_repair', NOW(), '$description' ,'$tel')";
    $result2 = mysqli_query($conn, $sql2);

    $sql4 = "SELECT * FROM get_repair WHERE r_id = '$id_repair' ORDER BY get_r_id DESC;";
    $result4 = mysqli_query($conn, $sql4);
    $row4 = mysqli_fetch_array($result4);
    $id_r_g = $row4['get_r_id'];

    $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
         VALUES ('$id_r_g', NOW(), 'ยื่นเรื่องซ่อม ครั้งที่ $round_repair','1')";
    $result3 = mysqli_query($conn, $sql3);


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
                $sql_p = "INSERT INTO repair_pic (r_get_id, rp_pic, rp_date)
                       VALUES ('$id_r_g', '$path_file_pic', NOW(),'1')";
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

    $sql_m = "SELECT * FROM member WHERE m_id = '$id'";
    $result_m = mysqli_query($conn, $sql_m);
    $row_m = mysqli_fetch_array($result_m);

    // Usage:
    $folderName = "../uploads/$id/Holder/"; // the name of the folder to be deleted
    deleteDirectory($folderName);

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

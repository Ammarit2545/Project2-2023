<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$p_id = $_POST['p_id'];
$p_type_id = $_POST['p_type_id'];
$p_brand = $_POST['p_brand'];
$p_model = $_POST['p_model'];
$p_name = $_POST['p_name'];
$p_detail = $_POST['p_description'];
$p_stock = $_POST['p_stock'];
$p_price = $_POST['p_price'];
$p_pic = $_FILES['p_pic']['name'];
$id = $_SESSION['id'];
$filename;

$sql_p = "SELECT * FROM parts WHERE p_brand = '$p_brand'  
AND p_model = '$p_model' 
AND p_name = '$p_name' 
AND p_type_id = '$p_type_id'";

$result_p = mysqli_query($conn, $sql_p);
$row_p = mysqli_fetch_array($result_p);


$folderName = "../../parts/$p_type_id";
if (!file_exists($folderName)) {
    mkdir($folderName);
    echo "Folder created successfully";
} else {
    echo "Folder already exists";
}

$target_dir = $folderName . "/";
$file_extension = strtolower(pathinfo($_FILES["p_pic"]["name"], PATHINFO_EXTENSION));
$filename = $p_brand . "_" . $p_model . "." . $file_extension; // New filename
$target_file = $target_dir . $filename;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["p_pic"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (isset($_FILES["p_pic"]) && $_FILES["p_pic"] != NULL) {
        if (move_uploaded_file($_FILES["p_pic"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["p_pic"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$sql = "SELECT * FROM parts WHERE del_flg = '0' AND p_id = $p_id";
$result = mysqli_query($conn, $sql);
$row_c = mysqli_fetch_array($result);

if ($p_pic) {
    $pic_path = "parts/$p_type_id/$filename ";

    $sql = "UPDATE parts SET `p_date_update` = NOW(), `p_type_id` = '$p_type_id', `p_brand` = '$p_brand', `p_model` = '$p_model', `p_name` = '$p_name', `p_detail` ='$p_detail', `p_price`= '$p_price', `p_pic`= '$pic_path'  WHERE p_id = $p_id";
} else {
    $sql = "UPDATE parts SET `p_date_update` = NOW(), `p_type_id` = '$p_type_id', `p_brand` = '$p_brand', `p_model` = '$p_model', `p_name` = '$p_name', `p_detail` ='$p_detail', `p_price`= '$p_price' WHERE p_id = $p_id";
}

$result = mysqli_query($conn, $sql);

// if ($result) {
//     if ($row_c['p_stock'] < $p_stock) {
//         $p_stock_c = $p_stock - $row_c['p_stock'];
//         $sql = "INSERT INTO `parts_log` (`p_id`, `pl_value`, `pl_date`, `e_id`, `st_id`) VALUES ('$p_id', '$p_stock_c', NOW(), '$id', 'plus')";
//         $result = mysqli_query($conn, $sql);
//     } elseif ($row_c['p_stock'] > $p_stock) {
//         $p_stock_c = $row_c['p_stock'] -  $p_stock;
//         $sql = "INSERT INTO `parts_log` (`p_id`, `pl_value`, `pl_date`, `e_id`, `st_id`) VALUES ('$p_id', '$p_stock_c', NOW(), '$id', 'minus')";
//         $result = mysqli_query($conn, $sql);
//     }
// }

if ($result) {
    $_SESSION['add_data_alert'] = 0;
    // header('Location:../listview_parts.php');
    header('Location:../listview_parts.php');

    // display an alert message
    // echo "<script>alert('Success!');</script>";
} else {
    $_SESSION['add_data_alert'] = 1;
    // header('Location:../listview_parts.php');
    header('Location:../listview_parts.php');
}

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
$description = $_POST['description'];
$company = $_SESSION['company'];
$status_id = $_POST['status_id'];
$m_id = $_POST['m_id'];

$image1 = $_POST['image1'];
$image2 = $_POST['image2'];
$image3 = $_POST['image3'];
$image4 = $_POST['image4'];

$id = $_SESSION["id"];

// // Retrieve the parts data Old
// $parts = array();
// $cardCount = $_POST['cardCount']; // Assuming you're passing the card count as a hidden input field
// for ($i = 1; $i <= $cardCount; $i++) {
//     $partId = $_POST['p_id' . $i];
//     $quantity = $_POST['value_p' . $i];
//     $parts[] = array(
//         'partId' => $partId,
//         'quantity' => $quantity
//     );
// }

$parts = array();

for ($i = 1; $i <= 20; $i++) {
    if (isset($_POST['check_' . $i])) {
        $get_d = $_POST['get_d_id' . $i];
        $partIds = $_POST['p_id_' . $i];
        $quantities = $_POST['value_p_' . $i];

        foreach ($partIds as $count_for => $partId) {
            $quantity = $quantities[$count_for];
            $parts[] = array(
                'get_d_id' => $get_d,
                'partId' => $partId,
                'quantity' => $quantity
            );

            // Assuming $_POST['value_p' . $i] is an array, you can access its elements like this:
            echo $quantity;
        }
    }
}

print_r($parts);

if ($m_id != NULL) {
    $sql_member = "SELECT * FROM member WHERE m_id = $m_id  AND del_flg = 0";
    $result_member = mysqli_query($conn, $sql_member);
    $row_member = mysqli_fetch_array($result_member);

    $tel = $$row_member['m_tel'];
    // check serial number before insert
    $sql_serial = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$m_id' AND del_flg = 0";
} else {
    $sql_serial = "SELECT * FROM repair WHERE r_serial_number = '$serial_number'";
}

$result__serial = mysqli_query($conn, $sql_serial);
$row_serial = mysqli_fetch_array($result__serial);
if ($row_serial[0] > 0) {
    $_SESSION["add_data_alert"] = 1;
    header("Location: ../add_self_record.php?");
    exit();
} else {
    $sql = "INSERT INTO repair (m_id, r_brand, r_model, r_number_model, r_serial_number ,com_id )
    VALUES ('$m_id', '$name_brand', '$name_model', '$number_model', '$serial_number' ,'$company')";
    $result = mysqli_query($conn, $sql);

    $insertedId = mysqli_insert_id($conn);
    $id_r = $insertedId;

    $sql2 = "INSERT INTO get_repair ( r_id, get_r_record, get_r_date_in, get_r_detail ,get_tel ,e_id)
        VALUES ( '$id_r', '1', NOW(), '$description','$tel','$id')";
    $result2 = mysqli_query($conn, $sql2);

    $insertedId_get = mysqli_insert_id($conn);

    $id_r_g = $insertedId_get;

    if ($status_id == 3) {
        $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
                VALUES ('$id_r_g', NOW(), 'ทางร้านได้ดำเนินการเพิ่มข้อมูลด้วยตัวเอง','$status_id')";
        $result3 = mysqli_query($conn, $sql3);
        $insertedId_2 = mysqli_insert_id($conn);
        $rs_id = $insertedId_2;
    } elseif ($status_id == 4) {
        $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
                VALUES ('$id_r_g', NOW(), 'รายละเอียดอะไหล่ของท่านมีดังนี้','$status_id')";
        $result3 = mysqli_query($conn, $sql3);
        $insertedId_2 = mysqli_insert_id($conn);
        $rs_id = $insertedId_2;
    } elseif ($status_id == 5) {
        $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id ,rs_conf ,rs_conf_date)
        VALUES ('$id_r_g', NOW(), 'ยืนยันการซ่อมจากพนักงานแล้ว','$status_id',1,NOW())";
        $result3 = mysqli_query($conn, $sql3);
        $insertedId_2 = mysqli_insert_id($conn);
        $rs_id = $insertedId_2;
    }

    $sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '0'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if ($result3) {
        // Process parts data
        foreach ($parts as $part) {
            $get_d_id = $part['get_d_id'];
            $partId = $part['partId'];
            $quantity = $part['quantity'];

            // Insert data into repair_detail table
            $sql_s = "SELECT * FROM parts WHERE del_flg = '0' AND p_id = '$partId'";
            $result_s = mysqli_query($conn, $sql_s);

            if ($result_s && mysqli_num_rows($result_s) > 0) {
                $row_s = mysqli_fetch_array($result_s);
                $p_stock = $row_s['p_stock'] - $quantity;
                $total_s = $row_s['p_price'] * $quantity;

                $sql3 = "INSERT INTO repair_detail (`p_id`, `rd_value_parts`, `rd_parts_price`, `rs_id`, `rd_date_in`)
                VALUES ('$partId', '$quantity', '$total_s', '$rs_id', NOW())";
                $result3 = mysqli_query($conn, $sql3);

                if ($result3) {
                    // Update parts stock in the parts table
                    $sql_u = "UPDATE `parts` SET `p_stock` = `p_stock` - '$quantity', `p_date_update` = NOW() WHERE `p_id` = '$partId'";
                    $result_u = mysqli_query($conn, $sql_u);

                    if (!$result_u) {
                        // Handle the case when the update query fails
                        // ...
                    }
                } else {
                    // Handle the case when the insert query into repair_detail table fails
                    // ...
                }
            } else {
                // Handle the case when the select query for parts data fails or no rows are found
                // ...
            }
        }
    }

    $folderName = "../../uploads/$m_id/$id_r_g/"; // the name of the new folder
    if (!file_exists($folderName)) { // check if the folder already exists
        mkdir($folderName); // create the new folder
        echo "Folder created successfully";
    } else {
        echo "Folder already exists";
    }

    // Define the target directory for uploaded files
    $folderName = "../../uploads/$m_id/$id_r_g/$rs_id/"; // the name of the new folder
    if (!file_exists($folderName)) { // check if the folder already exists
        mkdir($folderName); // create the new folder
        echo "Folder created successfully";
    } else {
        echo "Folder already exists";
    }

    $target_dir = $folderName; // Change this to the desired location
    $target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
    move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file);

    // Loop over the four images
    for ($i = 1; $i <= 4; $i++) {
        $image_name = "image" . $i;
        if (isset($_FILES[$image_name])) {
            $target_dir =  $folderName;
            $target_file = $target_dir . basename($_FILES[$image_name]["name"]);
            $target_file_db = "uploads/$m_id/$id_r_g/$rs_id/" . basename($_FILES[$image_name]["name"]);

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


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
                    // Insert To DATABASE
                    $sql_p = "INSERT INTO repair_pic (rp_pic, rp_date, rs_id)
                              VALUES ('$target_file_db', NOW(), '$rs_id')";
                    $result_p = mysqli_query($conn, $sql_p);
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
    $_SESSION["add_data_alert"] = 0;
    header("Location: ../detail_repair.php?id=" . $insertedId_get);
    exit();
}

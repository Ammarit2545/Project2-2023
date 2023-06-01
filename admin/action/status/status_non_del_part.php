<!--

เพิ่มสถานะ รูปภาพ อะไหล่ ลบอะไหล่เก่า

เอาของคืนคลังและทำการยกเลิกหรือปฏิเสธ

-->

<?php
session_start();
include('../../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$get_r_id = $_POST['get_r_id'];
$rs_detail = $_POST['rs_detail'];
$status_id = $_POST['status_id'];
$e_id = $_SESSION["id"];

$sql = "SELECT * FROM repair_status 
        LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
        WHERE repair_status.get_r_id = '$get_r_id' AND repair_status.rs_detail = '$rs_detail' AND repair_status.status_id = '$status_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($row[0] > 0) {
    // if it already has data
    echo $row[0];
    $_SESSION["add_data_alert"] = 1;
    header("Location: ../../detail_repair.php?id=$get_r_id");
} else {

    // เอาคืน Stock ทั้งหมดจากคำสั่งซื้อ

    $sql_check_p = "SELECT *
                    FROM repair_detail
                    LEFT JOIN get_repair ON get_repair.get_r_id = repair_detail.get_r_id
                    LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                    WHERE repair_status.get_r_id = '$get_r_id' AND repair_detail.del_flg = '0';";
    $result_check_p = mysqli_query($conn, $sql_check_p);

    while ($row_check_part = mysqli_fetch_array($result_check_p)) {
        // echo $row_check_part['p_id']."  ".$row_check_part['rd_value_parts'];
        $rd_id = $row_check_part['rd_id'];
        $p_id = $row_check_part['p_id'];
        $value_parts = $row_check_part['rd_value_parts'];

        // $sql_update_part = "UPDATE parts SET p_stock = p_stock + $value_parts WHERE p_id = '$p_id'";
        // $result_update_part = mysqli_query($conn, $sql_update_part);


        $sql_update_detail = "UPDATE repair_detail SET del_flg = '0' WHERE rd_id = '$rd_id'";
        $result_update_detail = mysqli_query($conn, $sql_update_detail);
    }

    // เอาคืน Stock

    // if it does not already have data
    $sql_e = "INSERT INTO repair_status (get_r_id, rs_detail, rs_date_time, status_id, e_id)
              VALUES ('$get_r_id', '$rs_detail', NOW(), '$status_id ', '$e_id')";
    $result_e = mysqli_query($conn, $sql_e);

    $rs_id = mysqli_insert_id($conn);

    if ($rs_id > 0) {
        $sql_m = "SELECT repair.m_id FROM repair 
                  LEFT JOIN get_repair ON get_repair.r_id = repair.r_id
                  WHERE get_repair.get_r_id = '$get_r_id' AND get_repair.del_flg = '0'";
        $result_m = mysqli_query($conn, $sql_m);
        $row_m = mysqli_fetch_array($result_m);
        $m_id = $row_m['m_id'];

        $folderName = "../../../uploads/$m_id/$get_r_id/$rs_id"; // the name of the new folder
        if (!file_exists($folderName)) { // check if the folder already exists
            mkdir($folderName, 0777, true); // create the new folder with permissions
            echo "Folder created successfully";
        } else {
            echo "Folder already exists";
        }

        // Loop over the four images
        for ($i = 1; $i <= 4; $i++) {
            $image_name = "file" . $i;
            if (isset($_FILES[$image_name])) {
                $target_dir = $folderName;
                $target_file = $target_dir . '/' . basename($_FILES[$image_name]["name"]);

                $target_file_db = "uploads/$m_id/$get_r_id/$rs_id/" . basename($_FILES[$image_name]["name"]);

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
                    echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, and MOV files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                } else {
                    if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                        echo "The file " . htmlspecialchars(basename($_FILES[$image_name]["name"])) . " has been uploaded.";

                        // Insert To DATABASE
                        $sql_p = "INSERT INTO repair_pic (rp_pic, rp_date, rs_id)
                                  VALUES ('$target_file_db', NOW(), '$rs_id')";
                        $result_p = mysqli_query($conn, $sql_p);
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }
        $_SESSION["add_data_alert"] = 0;
        header("Location: ../../detail_repair.php?id=$get_r_id");
    }
}

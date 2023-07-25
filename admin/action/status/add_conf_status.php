<?php
session_start();
include('../../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        // Escape the values to prevent SQL injection
        $escaped_value = mysqli_real_escape_string($conn, $value);
        echo $key . ': ' . $escaped_value . '<br>';
    }
}

$get_r_id  = $_GET['id'];
$status_id  = $_GET['status_id'];

echo $get_r_id;

// ... (Your existing code for updating parts and parts_use tables)

$sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
         VALUES ('$get_r_id', NOW(), 'กรุณาทำการส่งเครื่องเสียงและอุปกรณ์ต่อพ่วงที่ต้องการซ่อมมาให้ทางร้านทำการซ่อม','$status_id')";
$result3 = mysqli_query($conn, $sql3);
$rs_id = mysqli_insert_id($conn);

if ($rs_id != NULL) {

    //    ตัดของออกจาก Stock หลังจากยืนยัน
    $sql_check_p = "SELECT *
                    FROM repair_detail
                    LEFT JOIN get_repair ON get_repair.get_r_id = repair_detail.get_r_id
                    LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                    WHERE repair_status.get_r_id = '$get_r_id' AND repair_detail.del_flg = '0';";
    $result_check_p = mysqli_query($conn, $sql_check_p);

    while ($row_check_part = mysqli_fetch_array($result_check_p)) {
        $rd_id = $row_check_part['rd_id'];
        $p_id = $row_check_part['p_id'];
        $value_parts = $row_check_part['rd_value_parts'];

        // Escape the values to prevent SQL injection
        $escaped_p_id = mysqli_real_escape_string($conn, $p_id);
        $escaped_value_parts = mysqli_real_escape_string($conn, $value_parts);

        $sql_update_part = "UPDATE parts SET p_stock = p_stock - $escaped_value_parts WHERE p_id = '$escaped_p_id'";
        $result_update_part = mysqli_query($conn, $sql_update_part);

        if ($result_update_part) {

            // Update the repair_detail table to indicate that the part has been used
            $sql_u_rd = "UPDATE `repair_detail` SET `del_flg` = '0' WHERE `rd_id` = '$rd_id'";
            $result_u_rd = mysqli_query($conn, $sql_u_rd);

            if ($result_u_rd) {
                // Check if parts_use entry already exists for this repair
                $sql_check_pu = "SELECT * FROM parts_use WHERE rs_id = '$rs_id'";
                $result_check_pu = mysqli_query($conn, $sql_check_pu);
                if (mysqli_num_rows($result_check_pu) == 0) {
                    // If it does not already have data, insert into parts_use table
                    // Replace $e_id with the appropriate value for 'e_id'
                    $e_id = 1; // Assuming '1' is the default value for 'e_id'
                    $sql_e = "INSERT INTO parts_use (rs_id, pu_date, st_id, e_id) VALUES ('$rs_id', NOW(),'3','$e_id')";
                    $result_e = mysqli_query($conn, $sql_e);
                    $pu_id = mysqli_insert_id($conn);
                } else {
                    $row_pu = mysqli_fetch_array($result_check_pu);
                    $pu_id = $row_pu['pu_id'];
                }

                // Insert data into parts_use_detail table
                $sql_e = "INSERT INTO parts_use_detail (pu_id, p_id, pu_value, pu_date) VALUES ('$pu_id', '$escaped_p_id', '$escaped_value_parts', NOW())";
                $result_e = mysqli_query($conn, $sql_e);
            }
        }
    }
    //    ตัดของออกจาก Stock 

    $sql_update_detail = "UPDATE get_detail SET del_flg = 1 WHERE get_r_id = '$get_r_id' AND get_d_conf = 1";
    $result_update_detail = mysqli_query($conn, $sql_update_detail);

    if ($result_update_detail) {
        $_SESSION["add_data_alert"] = 0;
        header("Location: ../../detail_repair.php?id=$get_r_id");
        exit(); // Add exit() to prevent further execution of the script after redirection
    } else {
        $_SESSION["add_data_alert"] = 1;
        header("Location: ../../detail_repair.php?id=$get_r_id");
        exit(); // Add exit() to prevent further execution of the script after redirection
    }
} else {
    $_SESSION["add_data_alert"] = 1;
    header("Location: ../../detail_repair.php?id=$get_r_id");
    exit(); // Add exit() to prevent further execution of the script after redirection
}

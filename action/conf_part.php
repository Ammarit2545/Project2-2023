<?php
session_start();
include('../database/condb.php');

$get_r_id = $_GET['id'];
$status_id = $_GET['status_id'];
echo $get_r_id . ' ' . $status_id;

// คอนเฟิร์มสถานะ 17 และ 4 ว่าใช้อะไหล่
if ($status_id == 17 || $status_id == 4) {
    $sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '$status_id' ORDER BY rs_date_time DESC";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo ' 1';

    $rs_id = $row['rs_id'];
    if ($rs_id  > 0) {
        $sql = "UPDATE repair_status SET rs_conf = '1' , rs_conf_date = NOW() WHERE rs_id = '$rs_id '";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['add_data_alert'] = 0;
            header("location:../detail_status.php?id=$get_r_id");
            exit;
        }
    }
}

if ($status_id == 4 || $status_id == 17 || $row['rs_id'] > 0) {
    $sql_c = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '$status_id' AND rs_conf = '1' ORDER BY rs_date_time ASC";
    $result_c = mysqli_query($conn, $sql_c);
    $row_c = mysqli_fetch_array($result_c);

    if ($row_c['rs_id'] > 0) {
        $sql_c = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '19' ORDER BY rs_id DESC LIMIT 1";
        $result_c = mysqli_query($conn, $sql_c);
        $row_c = mysqli_fetch_array($result_c);

        if ($row_c['rs_id'] > 0) {

            if ($result) {

                // เอาคืนสต๊อก เอาค่าจาก $get_r_id
                $sql_c = "SELECT * FROM repair_detail 
                            LEFT JOIN get_detail ON get_detail.get_d_id = repair_detail.get_d_id
                            LEFT JOIN get_repair ON get_repair.get_r_id = get_detail.get_r_id
                            WHERE get_detail.get_r_id = '$get_r_id' AND repair_detail.del_flg = '0' AND get_repair.del_flg = '0';";
                $result_c = mysqli_query($conn, $sql_c);
                while ($row_c = mysqli_fetch_array($result_c)) {
                    $p_id = $row_c['p_id'];
                    $rd_value_parts = $row_c['rd_value_parts'];

                    // Update parts stock in the parts table
                    $sql_u = "UPDATE `parts` SET `p_stock` = `p_stock` - '$rd_value_parts', `p_date_update` = NOW() WHERE `p_id` = '$p_id'";
                    $result_u = mysqli_query($conn, $sql_u);
                    //    status_record_001

                }

                $_SESSION['add_data_alert'] = 0;
                header("location:../detail_status.php?id=$get_r_id");
            }
            echo ' 4';
        } else {
            $_SESSION['add_data_alert'] = 1;
            header("location:../detail_status.php?id=$get_r_id");
        }
    } else {
        $rs_id = $row['rs_id'];
        $sql = "UPDATE repair_status SET rs_conf = '1' , rs_conf_date = NOW() WHERE rs_id = '$rs_id '";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['add_data_alert'] = 0;
            header("location:../detail_status.php?id=$get_r_id");
        }
        echo ' 4';
    }
} else {
    $_SESSION['add_data_alert'] = 1;
    header("location:../detail_status.php?id=$get_r_id");
}

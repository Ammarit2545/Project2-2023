<?php
// ลบสถานะเก่าเพิ่มสถานะใหม่
// สถานะเดิมแต่อัพใหม่ เหมือนอัพเดตวันที่เฉยๆ
// ทำการตัดของจากสต๊อก

session_start();
include('../database/condb.php');

$get_r_id = $_GET['id'];
$status_id = $_GET['status_id'];
echo $get_r_id . ' ' . $status_id;

if ($status_id == 19) {
    $sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '$status_id' ORDER BY rs_date_time DESC";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo ' 1';
}

if ($row['rs_id'] > 0) {
    $sql_c = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' 
    AND del_flg = '0' 
    AND status_id = '$status_id' ORDER BY rs_date_time ASC";
    $result_c = mysqli_query($conn, $sql_c);
    $row_c = mysqli_fetch_array($result_c);

    if ($row_c['rs_id'] > 0) {
        $sql_c = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '19' ";
        $result_c = mysqli_query($conn, $sql_c);
        $row_c = mysqli_fetch_array($result_c);
        echo ' 11';
        if ($row_c['rs_id'] > 0) {
            $rs_id = $row['rs_id'];
            $sql = "UPDATE repair_status SET del_flg = '0', rs_conf_date = NOW() WHERE rs_id = '$rs_id '";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $sql = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
                    VALUES ('$get_r_id', NOW(), 'ยื่นเรื่องซ่อม','$status_id')";
                $result = mysqli_query($conn, $sql);
                echo ' 5';
                if ($result) {
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
                        $_SESSION['add_data_alert'] = 0;
                        header("location:../detail_status.php?id=$get_r_id");
                    }
                }
            }
            // echo ' 4';
        } else {
            $_SESSION['add_data_alert'] = 1;
            header("location:../detail_status.php?id=$get_r_id");
        }
    } else {

        $_SESSION['add_data_alert'] = 0;
        header("location:../detail_status.php?id=$get_r_id");
    }
} else {
    $_SESSION['add_data_alert'] = 1;
    header("location:../detail_status.php?id=$get_r_id");
}

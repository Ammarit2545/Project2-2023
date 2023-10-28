<?php
session_start();
include('../database/condb.php');

$get_r_id = $_GET['id'];
$status_id = $_GET['status_id'];
echo $get_r_id . ' ' . $status_id;

$sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '$status_id' ORDER BY rs_date_time DESC";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_array($result);
    if ($row['rs_id'] > 0) {

        $sql_c = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '$status_id' ";
        $result_c = mysqli_query($conn, $sql_c);

        if (mysqli_num_rows($result)) {
            $rs_id = $row['rs_id'];
            $sql = "UPDATE repair_status SET rs_conf = '1' , rs_conf_date = NOW() WHERE rs_id = '$rs_id'";
            $result1 = mysqli_query($conn, $sql);
            if ($result1) {
                // เอาคืนสต๊อก เอาค่าจาก $get_r_id
                $sql_c = "	SELECT repair_detail.rd_id FROM repair_detail 
                                LEFT JOIN get_detail ON get_detail.get_d_id = repair_detail.get_d_id
                                LEFT JOIN get_repair ON get_repair.get_r_id = get_detail.get_r_id
                                LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id
                                WHERE repair_status.get_r_id = '$get_r_id' 
                                AND repair_detail.del_flg = '0' 
                                AND get_repair.del_flg = '0' 
                                AND repair_status.status_id = '$status_id'  ";
                $result_c = mysqli_query($conn, $sql_c);
                // while ($row_c = mysqli_fetch_array($result_c)) {

                //     $sql_check = "SELECT * FROM repair_detail AS rd 
                //     LEFT JOIN repair_status AS rs ON rs.rs_id =  rd.rs_id
                //     WHERE rs.get_r_id = '$get_r_id'  AND rs.status_id = '17' AND rd.del_flg = '0'";
                //     $result_check = mysqli_query($conn, $sql_check);
                //     while ($row_check = mysqli_fetch_array($result_check)) {
                //         $rs_id = $row_check['rs_id'];
                //         $sql_update = "UPDATE repair_detail SET del_flg = '1' WHERE rs_id = '$rs_id'";
                //         $result_update = mysqli_query($conn, $sql_update);

                //         if ($result_update) {
                //             $sql_update = "UPDATE part_use SET del_flg = '1' WHERE rs_id = '$rs_id'"; //แค่ครั้งเดียว
                //             $result_update = mysqli_query($conn, $sql_update);
                //         }
                //     }
                // }

                // $sql_insert = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
                // VALUES ('$get_r_id', NOW(), 'ดำเนินการซ่อมหลังจากท่านได้ยืนยันแล้ว','6')"; //แค่ครั้งเดียว
                // $result_insert = mysqli_query($conn, $sql_insert);
                // if ($result_insert) {
                $_SESSION['add_data_alert'] = 0;
                header("location:../detail_status.php?id=$get_r_id");
                // }
            }
            echo ' 4';
        } else {
            $_SESSION['add_data_alert'] = 1;
            header("location:../detail_status.php?id=$get_r_id");
        }
    } else {
        $row_c = mysqli_fetch_array($result_c);
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

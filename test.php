<?php

session_start();
include('database/condb.php');

$sql_count = 0;
$status_select = 2;

$sql_status_get1 = "SELECT repair_status.get_r_id FROM repair_status
                    WHERE repair_status.status_id = '$status_select'
                    AND repair_status.del_flg = '0'";
$result_status_get1 = mysqli_query($conn, $sql_status_get1);

if ($result_status_get1) {
    while ($row_status_get1 = mysqli_fetch_array($result_status_get1)) {
        $get_r_id = $row_status_get1['get_r_id'];

        $sql_count_status = "SELECT repair_status.status_id, repair_status.get_r_id FROM get_repair 
                            LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                            LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
                            WHERE get_repair.get_r_id = '$get_r_id' 
                            AND repair_status.del_flg = '0'
                            AND get_repair.del_flg = '0' 
                            AND get_detail.del_flg = '0' 
                            ORDER BY repair_status.rs_id DESC LIMIT 1";

        $result_count_status = mysqli_query($conn, $sql_count_status);

        if (mysqli_num_rows($result_count_status)) {
            $row_count_status = mysqli_fetch_array($result_count_status);
            if ($row_count_status['status_id'] == $status_select) {
                $sql_count += 1;
            }
        }
    }
}

echo $sql_count;

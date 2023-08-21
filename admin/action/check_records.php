<?php
session_start();
include('../../database/condb.php');

$sql_get = "SELECT rs_id, get_r_id, rs_date_time, rs_conf
            FROM repair_status
            WHERE repair_status.status_id = 8 AND del_flg = 0 AND rs_conf IS NULL";

$result_get = mysqli_query($conn, $sql_get);

$response = [];

if ($result_get) {
    $current_date = strtotime(date('Y-m-d')); // Get the current date in UNIX timestamp format

    while ($row_get = mysqli_fetch_assoc($result_get)) {
        echo $row_get['get_r_id'] . ' ';
        $rs_date_time = strtotime($row_get['rs_date_time']);
        $years_diff = floor(($rs_date_time - $current_date) / (365 * 24 * 60 * 60));
        echo $years_diff . ' ';
        if ($years_diff == -2) {
            $get_r_id = $row_get['get_r_id'];
            $rs_id = $row_get['rs_id']; // Define rs_id

            // Use prepared statements to prevent SQL injection
            $sql_member = "SELECT member.m_fname, member.m_lname
                            FROM get_repair
                            RIGHT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id
                            RIGHT JOIN repair ON get_detail.r_id = repair.r_id
                            RIGHT JOIN member ON member.m_id = repair.m_id
                            WHERE get_repair.get_r_id = ? AND get_repair.del_flg = 0 LIMIT 1";

            $stmt_member = mysqli_prepare($conn, $sql_member);
            mysqli_stmt_bind_param($stmt_member, "i", $get_r_id);
            mysqli_stmt_execute($stmt_member);
            $result_member = mysqli_stmt_get_result($stmt_member);
            $row_member = mysqli_fetch_assoc($result_member);

            if ($row_member) {
                $m_fname = $row_member['m_fname'];
                $m_lname = $row_member['m_lname'];

                // Update rs_conf to 0
                $sql_update = "UPDATE repair_status SET rs_conf = 2 WHERE rs_id = ?";
                $stmt_update = mysqli_prepare($conn, $sql_update);
                mysqli_stmt_bind_param($stmt_update, "i", $rs_id);
                $result_update = mysqli_stmt_execute($stmt_update);

                // Insert a new record with appropriate values
                $sql_insert = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id) VALUES ('$get_r_id', NOW(), 'ทางร้านต้องขอแจ้งให้ทราบว่าคุณไม่ได้ชำระเงินตามระยะเวลาที่กำหนด (ระยะเวลาเก็บอุปกรณ์ของท่านคือ 1 ปี) ดังนั้นเราขอทำการเก็บอุปกณ์ของท่านเป็นทรัพย์สินของทางร้าน โปรดทราบว่าเราจะไม่มีการดำเนินการคืนเงินหรือรับผิดชอบแต่อย่างใดต่อของท่านในกรณีนี้', 14)";
                $result_insert = mysqli_query($conn, $sql_insert);

                if ($result_insert) {
                    $response[] = ['get_r_id' => $get_r_id];
                }
            }

            $response[] = ['get_r_id' => $get_r_id];
        }
    }
}

// Output the data as JSON
echo json_encode($response);

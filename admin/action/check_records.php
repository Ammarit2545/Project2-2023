<?php
session_start();
include('../../database/condb.php');


$_SESSION['ajax_check'] += 1;

// วันเวลาปัจจุบันของไทย
date_default_timezone_set('Asia/Bangkok'); // Set the timezone to Thailand
$current_time = date('Y-m-d H:i:s'); // Get the current date and time in the format 'Y-m-d H:i:s' with the Thailand timezone

$sql_get = "SELECT rs_id, get_r_id, rs_date_time, rs_conf
            FROM repair_status
            WHERE repair_status.status_id = 8 AND del_flg = 0 AND rs_conf IS NULL";

$result_get = mysqli_query($conn, $sql_get);

$response = [];

if ($result_get) {
    $current_date = strtotime(date('Y-m-d')); // Get the current date in UNIX timestamp format

    while ($row_get = mysqli_fetch_assoc($result_get)) {
        $sql_repair = "SELECT repair_status.rs_id,repair_status.status_id
        FROM get_repair
        LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id
        LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id
        WHERE get_repair.get_r_id = ? AND get_repair.del_flg = 0 AND repair_status.rs_conf != 2 AND repair_status.rs_conf != 2 AND repair_status.status_id != 9 ORDER BY repair_status.rs_id LIMIT 1";

        $stmt_repair = mysqli_prepare($conn, $sql_repair);
        mysqli_stmt_bind_param($stmt_repair, "i", $get_r_id);
        mysqli_stmt_execute($stmt_repair);
        $result_repair = mysqli_stmt_get_result($stmt_repair);
        $row_repair = mysqli_fetch_assoc($result_repair);

        if ($row_repair['status_id'] == 8) {

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
}

$rs_idCSK = 0;
$sql_check_send_ok = "SELECT get_r_id FROM repair_status WHERE del_flg = 0 AND status_id = 24 GROUP BY rs_id ORDER BY rs_id DESC";
$re_check_send_ok = mysqli_query($conn, $sql_check_send_ok);

if (mysqli_num_rows($re_check_send_ok)) {
    while ($rowCSK = mysqli_fetch_array($re_check_send_ok)) {
        $get_r_idCSK = $rowCSK['get_r_id'];

        $sqlCSK = "SELECT rs_id,status_id, rs_date_time FROM repair_status WHERE del_flg = 0 AND get_r_id = '$get_r_idCSK' GROUP BY rs_id ORDER BY rs_id DESC LIMIT 1";
        $reCSK = mysqli_query($conn, $sqlCSK);
        $rCSK = mysqli_fetch_array($reCSK);

        if ($rCSK['status_id'] == 24) {
            $rs_id = $rCSK['rs_id'];
            $rs_date_time = $rCSK['rs_date_time'];
            echo '<br>' . $rs_date_time . ' - AND - ' . $current_time;

            // Set the timezone to Thailand
            date_default_timezone_set('Asia/Bangkok');

            // Your current time and $rs_date_time (assuming they are in the format 'Y-m-d H:i:s')
            $current_time = date('Y-m-d H:i:s');

            // Convert date strings to timestamps
            $current_timestamp = strtotime($current_time);
            $rs_timestamp = strtotime($rs_date_time);

            // Calculate the difference in seconds
            $time_difference = $current_timestamp - $rs_timestamp;

            // Calculate the number of days in the time difference
            $days_difference = floor($time_difference / (60 * 60 * 24));

            if ($days_difference >= 7) {
                echo 'It ' . $get_r_idCSK . ' has been more than 5 days.';
                $sql_update = "UPDATE repair_status SET rs_conf = 1 WHERE rs_id =  '$rs_id' ";
                $result_update = mysqli_query($conn, $sql_update);
                // Insert a new record with appropriate values

                if ($result_update) {
                    echo 'Upload 3 OK';
                    $sqlCSK = "SELECT rs_id,status_id, rs_date_time FROM repair_status WHERE del_flg = 0 AND get_r_id = '$get_r_idCSK' GROUP BY rs_id ORDER BY rs_id DESC LIMIT 1";
                    $reCSK = mysqli_query($conn, $sqlCSK);
                    $rCSK = mysqli_fetch_array($reCSK);
                    if ($rCSK['status_id'] != 3) {
                        $sql_insert1 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id) VALUES ('$get_r_idCSK', NOW(), 'ยืนยันรับอุปกรณ์แล้ว (ระบบตัดอัตโนมัติ)', 3)";
                        $result_insert1 = mysqli_query($conn, $sql_insert1);
                    } else {
                        continue;
                    }
                }
            } else {
                echo 'It has been less than 5 days.';
                continue;
            }
        }
    }
}

// Output the data as JSON
echo json_encode($response);

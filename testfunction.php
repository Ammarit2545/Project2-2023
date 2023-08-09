<?php
session_start();

include('database/condb.php');

$status_req = 0;

$sql_get = "SELECT get_repair.get_r_id
FROM get_repair
RIGHT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
WHERE get_repair.del_flg = 0
GROUP BY get_repair.get_r_id;
";
$result_get = mysqli_query($conn, $sql_get);

if ($result_get) {
    $stmt_found = $conn->prepare("SELECT status_id FROM repair_status WHERE del_flg = 0 AND get_r_id = ? ORDER BY rs_date_time DESC LIMIT 1");

    while ($row_get = mysqli_fetch_array($result_get)) {
        $get_r_id = $row_get['get_r_id'];

        // ซ่อนตัวแปรไว้ข้างใน
        $stmt_found->bind_param("i", $get_r_id);
        $stmt_found->execute();

        $result_found = $stmt_found->get_result();
        $row_found = mysqli_fetch_array($result_found);

        if ($row_found && $row_found['status_id'] == 2) {
            $status_req = $status_req + 1;
        }
    }

    // เอาตัวแปรออก
    $stmt_found->close();
}

echo $status_req;

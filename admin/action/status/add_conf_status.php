<?php
session_start();
include('../../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$get_r_id  = $_GET['id'];

echo $get_r_id;

// $sql = "SELECT * FROM repair_status WHERE status_id = 5 AND get_r_id = '$get_r_id'";
// $result = mysqli_query($conn, $sql);
// $row_c = mysqli_fetch_array($result);

// if ($row_c[0] > 0) {
//     $_SESSION["add_data_alert"] = 1;
//     header("Location: ../../detail_repair.php?id=$get_r_id");
// } else {


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

        $sql_update_part = "UPDATE parts SET p_stock = p_stock - $value_parts WHERE p_id = '$p_id'";
        $result_update_part = mysqli_query($conn, $sql_update_part);
        
    }
    //    ตัดของออกจาก Stock 


    $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id)
         VALUES ('$get_r_id', NOW(), 'กรุณาทำการส่งเครื่องเสียงและอุปกรณ์ต่อพ่วงที่ต้องการซ่อมมาให้ทางร้านทำการซ่อม','5')";
    $result3 = mysqli_query($conn, $sql3);

    if($result3){
        $sql_update_detail = "UPDATE get_detail SET del_flg = 1 WHERE get_r_id = '$get_r_id' AND get_d_conf = 1";
        $result_update_detail = mysqli_query($conn, $sql_update_detail);
    }

    if ($result3) {
        $_SESSION["add_data_alert"] = 0;
        header("Location: ../../detail_repair.php?id=$get_r_id");
    }
// }

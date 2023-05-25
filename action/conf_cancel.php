<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }

    $rs_detail = ''; // Initialize the $rs_detail variable

    for ($i = 0; $i <= 10; $i++) {
        $checkbox_name = "checkbox" . $i;

        // Check if the checkbox is selected
        if (isset($_POST[$checkbox_name])) {
            if ($_POST[$checkbox_name] == "on") {
                $rs_detail = $_POST['detail_cancel']; // Use the value from the textarea
                break; // Exit the loop if a checkbox is selected
            } else {
                $rs_detail = $_POST[$checkbox_name]; // Use the value from the textarea
                break; // Exit the loop if a checkbox is selected
            }
        }
    }

    echo $rs_detail;
}
$get_r_id = $_POST['get_r_id'];
echo $get_r_id;

$sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '4' ORDER BY rs_date_time DESC";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($row['rs_id'] > 0) {
    $sql_c = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '4' AND rs_conf = '1' ORDER BY rs_date_time DESC";
    $result_c = mysqli_query($conn, $sql_c);
    $row_c = mysqli_fetch_array($result_c);

    if ($row_c['rs_id'] > 0) {
        $_SESSION['add_data_alert'] = 1;
        header("location:../status_detail.php?id=$get_r_id");
    } else {
        $rs_id = $row['rs_id'];
        $sql = "UPDATE repair_status SET rs_conf = '0',rs_cancel_detail = '$rs_detail' , rs_conf_date = NOW() WHERE rs_id = '$rs_id '";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['add_data_alert'] = 2;
            header("location:../status_detail.php?id=$get_r_id");
        }
    }
} else {
    $_SESSION['add_data_alert'] = 1;
    header("location:../status_detail.php?id=$get_r_id");
}

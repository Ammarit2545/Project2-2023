<?php
// Make get_repair, get_detail, repair_status, repair_pic, repair_pic

session_start();
include('../../database/condb.php');
$get_r_id = $_GET['get_r_id'];

// Update repair_detail table
$sql4 = "SELECT get_d_id FROM get_detail WHERE get_r_id = '$get_r_id' AND del_flg = 0";
$result4 = mysqli_query($conn, $sql4);
if (mysqli_num_rows($result4) > 0) {
    while ($row = mysqli_fetch_array($result4)) {
        $get_d_id = $row['get_d_id'];

        $sql5 = "UPDATE repair_detail SET del_flg = '1' WHERE get_d_id = '$get_d_id'";
        $result5 = mysqli_query($conn, $sql5);

        // Update repair_pic table
        $sql5 = "UPDATE repair_pic SET del_flg = '1' WHERE get_d_id = '$get_d_id'";
        $result5 = mysqli_query($conn, $sql5);
    }
} else {
    $_SESSION['add_data_detail'] = 4; // Error
    header('Location: ../listview_repair.php');
    exit();
}

// Update get_repair table
$sql1 = "UPDATE get_repair SET del_flg = '1' WHERE get_r_id = '$get_r_id'";
$result1 = mysqli_query($conn, $sql1);

// Update get_detail table
$sql2 = "UPDATE get_detail SET del_flg = '1' WHERE get_r_id = '$get_r_id'";
$result2 = mysqli_query($conn, $sql2);

// Update repair_status table
$sql3 = "UPDATE repair_status SET del_flg = '1' WHERE get_r_id = '$get_r_id'";
$result3 = mysqli_query($conn, $sql3);

// Check the results of the queries
if ($result1 && $result2 && $result3 && $result4 && $result5) {
    $_SESSION['add_data_detail'] = 3; // Success
} else {
    $_SESSION['add_data_detail'] = 4; // Error
}

header('Location: ../listview_repair.php');
exit();

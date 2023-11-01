<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$get_r_id = $_GET['id'];

if (isset($_POST['get_d_id_1'])) {

    $i = 1;
    while (isset($_POST['get_d_id_' . $i])) {
        $get_d_id = $_POST['get_d_id_' . $i];
        $tracking_number = $_POST['tracking_number_' . $i];
        $com_t_id = $_POST['com_t_id_' . $i];
        // Use prepared statements and parameter binding to prevent SQL injection
        $sql = "SELECT t_id FROM tracking WHERE t_parcel = ? AND t_c_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $tracking_number, $com_t_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {

            // The record does not exist, insert a new one
            $sql = "INSERT INTO tracking (t_parcel, t_c_id, t_date_in, del_flg) VALUES (?, ?, NOW(), ?)";
            $stmt = mysqli_prepare($conn, $sql);
            $del_flg = 0; // Assuming del_flg is an integer
            mysqli_stmt_bind_param($stmt, "sii", $tracking_number, $com_t_id, $del_flg);
            $result = mysqli_stmt_execute($stmt);


            // mysqli_stmt_bind_param($stmt, "si", $tracking_number, $com_t_id);
            // $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $insertedId = mysqli_insert_id($conn);
                $sql = "UPDATE get_detail SET get_t_id = ? WHERE get_d_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $insertedId, $get_d_id);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    $sql_update = "UPDATE get_repair SET get_send = '1' ,get_add_price = NULL WHERE get_r_id = '$get_r_id'";
                    $resultUpdate = mysqli_query($conn, $sql_update);
                    if ($resultUpdate) {
                        echo "The record was inserted successfully with ID: " . $insertedId;
                    }
                } else {
                    $_SESSION['add_data_alert'] = 1;
                    header("location:../detail_status.php?id=$get_r_id");
                }
            } else {
                $_SESSION['add_data_alert'] = 1;
                header("location:../detail_status.php?id=$get_r_id");
            }
        } else {

            // The record already exists, update it
            $t_id = $row['t_id'];
            $sql = "UPDATE get_detail SET get_t_id = ? WHERE get_d_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $t_id, $get_d_id);
            $result = mysqli_stmt_execute($stmt);
        }
        $i++;
    }

    $_SESSION['add_data_alert'] = 0;
    header("location:../detail_status.php?id=$get_r_id");
}

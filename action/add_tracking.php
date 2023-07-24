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
    while ($_POST['get_d_id_' . $i]) {
        $get_d_id = $_POST['get_d_id_' . $i];
        $tracking_number = $_POST['tracking_number_' . $i];
        $com_t_id = $_POST['com_t_id_' . $i];

        $sql = "SELECT * FROM tracking WHERE t_parcel = '$tracking_number' AND t_c_id = '$com_t_id' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if ($row[0] == NULL) {
            $sql = "INSERT INTO `tracking`(`t_parcel`, `t_c_id`, `t_date_in`) VALUES ('$tracking_number','$com_t_id',NOW())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $insertedId = mysqli_insert_id($conn);
                $sql = "UPDATE get_detail SET get_t_id = '$insertedId' WHERE get_d_id = '$get_d_id'";
                $result = mysqli_query($conn, $sql);

                echo "The record was inserted successfully with ID: " . $insertedId;
            } else {
                $_SESSION['add_data_alert'] = 1;
                header("location:../detail_status.php?id=$get_r_id");
            }
        }else{
            $t_id =  $row['t_id'];
            $sql = "UPDATE get_detail SET get_t_id = '$t_id' WHERE get_d_id = '$get_d_id'";
                $result = mysqli_query($conn, $sql);
        }
        $i++;
    }
    $i -= 1;

    echo $i;
    $_SESSION['add_data_alert'] = 0;
    header("location:../detail_status.php?id=$get_r_id");
}

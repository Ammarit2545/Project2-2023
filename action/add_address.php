<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}
$get_r_id = $_POST['get_r_id'];
$id = $_SESSION["id"];
// echo $id;

$sql = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND status_id = '8' AND rs_conf = '1'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($row[0] > 0) {
    $_SESSION['add_data_alert'] = 1;
    header("location:../detail_status.php?id=$get_r_id");
} else {
    if (isset($_POST['Ref_prov_id']) && isset($_POST['Ref_dist_id']) && isset($_POST['Ref_subdist_id']) && isset($_POST['zip_code']) && isset($_POST['description'])) {

        $address = array("province" => $_POST['Ref_prov_id'], "district" => $_POST['Ref_dist_id'], "sub_district" => $_POST['Ref_subdist_id'], "zip_code" => $_POST['zip_code'], "description" => $_POST['description']);
        $address_json = json_encode($address);

        $sql = "SELECT * FROM get_repair WHERE get_r_id = '$get_r_id' AND get_add = '$address_json' AND del_flg =0";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if ($row[0] == NULL) {
            $sql = "UPDATE get_repair SET get_add = '$address_json' WHERE get_r_id = '$get_r_id'";
            $result = mysqli_query($conn, $sql);
            echo "update complete";

            $sql = "UPDATE repair_status SET rs_conf = '4' ,rs_conf_date = NOW() WHERE get_r_id = '$get_r_id' AND status_id = '8'";
            $result1 = mysqli_query($conn, $sql);

            $_SESSION['add_data_alert'] = 0;
            header("location:../detail_status.php?id=$get_r_id");
        } else {
            $_SESSION['add_data_alert'] = 1;
            header("location:../detail_status.php?id=$get_r_id");
        }

        echo $address_json;
    } else {

        $_SESSION['add_data_alert'] = 1;
        header("location:../detail_status.php?id=$get_r_id");
    }
}

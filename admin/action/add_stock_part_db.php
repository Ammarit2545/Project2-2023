<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$id = $_SESSION['id'];
$stock_type = $_SESSION['stock_type'];
$pl_bill_number = $_SESSION['pl_bill_number'];
$pl_tax_number = $_SESSION['pl_tax_number'];
$pl_date_in = $_SESSION['pl_date_in'];
$pl_detail = $_SESSION['pl_detail'];
$com_p_id = $_SESSION['com_p_id'];

if ($stock_type != NULL) {
    $sql = "SELECT * FROM stock_type WHERE st_id = '$stock_type' AND del_flg = '0'";
    $result = mysqli_query($conn, $sql);
    $row_check = mysqli_fetch_array($result);
    if ($row_check['st_type'] == 2) {
        $sql = "SELECT * FROM parts_log WHERE pl_bill_number = '$pl_bill_number' OR pl_tax_number = '$pl_tax_number'";  // make del flg = 0
        $result = mysqli_query($conn, $sql);
        $row_check_bill = mysqli_fetch_array($result);

        if ($row_check_bill[0] > 0) {
            $_SESSION["add_data_alert"] = 3;
            header("Location: ../edit_stock.php");
            exit();
        } else {
            $sql = "INSERT INTO `parts_log` (`pl_date`, `e_id`, `st_id`, `pl_bill_number`, `pl_tax_number`, `pl_date_in`, `pl_detail`, `com_p_id`)
                    VALUES (NOW(), '$id', '$stock_type', '$pl_bill_number', '$pl_tax_number', '$pl_date_in', '$pl_detail', '$com_p_id')";
            $result = mysqli_query($conn, $sql);
        }
    } else {
        $sql = "INSERT INTO `parts_log` (`pl_date`, `e_id`, `st_id`)
                VALUES (NOW(), '$id', '$stock_type')";
        $result = mysqli_query($conn, $sql);
    }
}

if ($result) {

    unset($_SESSION['pl_bill_number']);
    unset($_SESSION['pl_tax_number']);
    unset($_SESSION['pl_date_in']);
    unset($_SESSION['pl_detail']);
    unset($_SESSION['com_p_id']);
    unset($_SESSION['stock_type']);

    $pl_id = mysqli_insert_id($conn); // Retrieve the inserted ID
    if (isset($_SESSION['part_p_id_1'])) {
        $i = 1;
        while (isset($_SESSION['part_p_id_' . $i])) {
            echo $_SESSION['part_p_id_' . $i];
            $p_id = $_SESSION['part_p_id_' . $i];
            $p_stock = $_SESSION['part_p_stock_' . $i]; // Fixed variable name

            $sql = "UPDATE parts SET p_stock = p_stock + $p_stock WHERE p_id = '$p_id' AND del_flg = '0'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Update successful, you can add any additional logic here if needed
                $sql_p = "INSERT INTO `parts_log_detail` (`p_id`, `pl_d_value`, `pl_id`) VALUES ('$p_id', '$p_stock', '$pl_id')";
                $result = mysqli_query($conn, $sql_p);
            } else {
                $_SESSION['add_data_error_alert' . $i] = 1;
            }
            unset($_SESSION['part_p_id_' . $i]);
            unset($_SESSION['part_p_stock_' . $i]);
            $i++;
        }
        $_SESSION["add_data_alert"] = 0;
        header("Location: ../edit_stock.php");
        exit();
    } else {
        $_SESSION["add_data_alert"] = 1;
        header("Location: ../edit_stock.php");
        exit();
    }
} else {
    $_SESSION["add_data_alert"] = 1;
    header("Location: ../edit_stock.php");
    exit();
}

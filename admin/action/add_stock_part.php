<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

if (isset($_POST['p_id']) && isset($_POST['unit']) && $_POST['unit'] > 0 && $_POST['unit'] != NULL && $_POST['p_id'] != NULL) {

    // Bill And Tax Number Check 
    $_SESSION['stock_type'] = $_POST['st_id'];
    $_SESSION['pl_bill_number'] = $_POST['pl_bill_number'];
    $_SESSION['pl_tax_number'] = $_POST['pl_tax_number'];
    $_SESSION['pl_date_in'] = $_POST['pl_date_in'];
    $_SESSION['pl_detail'] = $_POST['pl_detail'];
    $_SESSION['com_p_id'] = $_POST['com_p_id'];

    if (!isset($_SESSION['part_p_id_1'])) {
        $_SESSION['part_p_id_1'] = $_POST['p_id'];
        $_SESSION['part_p_stock_1'] = $_POST['unit'];

        $_SESSION["add_data_alert"] = 0;
        header("Location: ../edit_stock.php");
        exit();
    } else {
        $i = 1;
        while (isset($_SESSION['part_p_id_' . $i])) {
            if ($_SESSION['part_p_id_' . $i] == $_POST['p_id']) {

                $_SESSION['part_p_stock_' . $i] += $_POST['unit'];

                $_SESSION["add_data_alert"] = 0;
                header("Location: ../edit_stock.php");
                exit();
            }
            $i++;
        }

        $_SESSION['part_p_id_' . $i] = $_POST['p_id'];
        $_SESSION['part_p_stock_' . $i] = $_POST['unit'];

        $_SESSION["add_data_alert"] = 0;
        header("Location: ../edit_stock.php");
        exit();
    }
} else {
    $_SESSION["add_data_alert"] = 1;
    header("Location: ../edit_stock.php");
    exit();
}

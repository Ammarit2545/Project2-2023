<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

if (isset($_POST['p_id']) && isset($_POST['unit']) && $_POST['unit'] > 0 && $_POST['unit'] != NULL && $_POST['p_id'] != NULL) {

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

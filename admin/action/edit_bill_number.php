<?php
session_start();
include('../../database/condb.php');
$type = $_GET['type'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($type == 1) {
        // Update the session value with the new unit value
        $_SESSION['pl_bill_number'] = $_POST['data'];

        // Redirect to the desired page after updating the session value
        header("Location: ../edit_stock.php");
        exit();
    } elseif ($type == 2) {
        // Update the session value with the new unit value
        $_SESSION['pl_tax_number'] = $_POST['data'];

        // Redirect to the desired page after updating the session value
        header("Location: ../edit_stock.php");
        exit();
    } elseif ($type == 3) {
        // Update the session value with the new unit value
        $_SESSION['pl_date_in'] = $_POST['data'];

        // Redirect to the desired page after updating the session value
        header("Location: ../edit_stock.php");
        exit();
    }elseif ($type == 4) {
        // Update the session value with the new unit value
        $_SESSION['pl_detail'] = $_POST['data'];

        // Redirect to the desired page after updating the session value
        header("Location: ../edit_stock.php");
        exit();
    }elseif ($type == 5) {
        // Update the session value with the new unit value
        $_SESSION['com_p_id'] = $_POST['data'];

        // Redirect to the desired page after updating the session value
        header("Location: ../edit_stock.php");
        exit();
    }
}

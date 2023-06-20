<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update the session value with the new unit value
    $_SESSION['part_p_stock_' . $_POST['session_value']] = $_POST['unit'];
    
    // Redirect to the desired page after updating the session value
    header("Location: ../edit_stock.php");
    exit();
}
?>

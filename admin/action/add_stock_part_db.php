<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$id = $_SESSION['id'];

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
            $sql = "INSERT INTO `parts_log` (`p_id`, `pl_value`, `pl_date`, `e_id`, `pl_type`) VALUES ('$p_id', '$p_stock', NOW(), '$id', 'plus')";
            $result = mysqli_query($conn, $sql);
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

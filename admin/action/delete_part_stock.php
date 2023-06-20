<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

if (isset($_GET['delete']) && $_GET['delete'] == 1) {
    echo "Gay";

    $count = 1;
    while (isset($_SESSION['part_p_id_' . $count])) {
        unset($_SESSION['part_p_id_' .$count]);
        $count++;
    }
    $count -= 1;

    $_SESSION["add_data_alert"] = 0;
    header("Location: ../edit_stock.php");
    exit();
} else {
    $session_id = $_GET['id'];

    echo $session_id;

    $count = 1;
    while (isset($_SESSION['part_p_id_' . $count])) {
        $count++;
    }
    $count -= 1;

    for ($i = $session_id; $i <= $count; $i++) {
        echo $i;
        if ($i == $session_id) {
            echo 'Delete';
            unset($_SESSION['part_p_id_' . $i]);
        } else {
            echo 'minus 1';
            $_SESSION['part_p_id_' . $i - 1] = $_SESSION['part_p_id_' . $i];
            unset($_SESSION['part_p_id_' . $i]);
        }
    }


    $_SESSION["add_data_alert"] = 0;
    header("Location: ../edit_stock.php");
    exit();
}

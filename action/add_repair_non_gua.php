<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST as $key => $value) {
            echo $key . ': ' . $value . '<br>';
        }
    }

    $name_brand = $_POST['name_brand'];
    $serial_number = $_POST['serial_number'];
    $name_model = $_POST['name_model'];
    $number_model = $_POST['number_model'];
    $tel = $_POST['tel'];
    $description = $_POST['description'];

?>
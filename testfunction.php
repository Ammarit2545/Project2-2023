<?php
session_start();

// Assuming you have the values of 'id_repair_ever_1', 'id_repair_ever_2', 'id_repair_ever_3', and 'id_repair_ever_4' stored somewhere, for example:
// $_SESSION['id_repair_ever_1'] = 123;
// $_SESSION['id_repair_ever_2'] = 456;
// $_SESSION['id_repair_ever_3'] = 789;
// $_SESSION['id_repair_ever_4'] = 101112;

$i = 1;
while (isset($_SESSION['id_repair_ever_' . $i])) {
    echo 'Have $_SESSION[\'id_repair_ever_' . $i . '\']';
    $i++;
}

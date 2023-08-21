<?php
session_start();

// Assuming you have the values of 'id_repair_ever_1', 'id_repair_ever_2', 'id_repair_ever_3', and 'id_repair_ever_4' stored somewhere, for example:
    // เครื่องที่1  
    $_SESSION['id_repair_parts_1_1'] = 1;
    $_SESSION['id_repair_value_1_1'] = 2;
    $_SESSION['id_repair_r_id_1_1'] = 60;


    $_SESSION['id_repair_parts_1_2'] = 2;
    $_SESSION['id_repair_value_1_2'] = 2;
    $_SESSION['id_repair_r_id_1_2'] = 60;

    $_SESSION['id_repair_parts_1_3'] = 3;
    $_SESSION['id_repair_value_1_3'] = 3;
    $_SESSION['id_repair_r_id_1_3'] = 60;
    
    // เครื่องที่2
    $_SESSION['id_repair_parts_2_1'] = 1;
    $_SESSION['id_repair_value_2_1'] = 1;
    $_SESSION['id_repair_r_id_2_1'] = 61;

    // $_SESSION['id_repair_parts_2_2'] = 1;
    // $_SESSION['id_repair_value_2_2'] = 1;
    // $_SESSION['id_repair_r_id_2_2'] = 61;
    
    // $_SESSION['id_repair_ever_3_1'] = 101112;
    // $_SESSION['id_repair_ever_3_2'] = 101112;

    // $_SESSION['id_repair_ever_4_1'] = 101112;
    // $_SESSION['id_repair_ever_4_2'] = 101112;
    


$i = 1;

while (isset($_SESSION['id_repair_parts_' . $i . '_1'])) {
    $counter = 1;
    echo '<br>';
    while (isset($_SESSION['id_repair_parts_' . $i . '_' . $counter])) {
        echo "Have \$_SESSION['id_repair_parts_" . $i . '_' . $counter . "'] ";

        echo $_SESSION['id_repair_parts_'.$i.'_'.$counter];
        echo '<br>';
        echo $_SESSION['id_repair_value_'.$i.'_'.$counter];

        echo '<br>';
        unset($_SESSION['id_repair_parts_' . $i . '_' . $counter]);
        $counter++;
    }

    $i++;
}
?>


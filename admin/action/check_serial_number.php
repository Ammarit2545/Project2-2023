<?php
include('../../database/condb.php');

$serial = $_GET['serial'];
$sql_m = "SELECT * FROM repair WHERE r_serial_number = '$serial' AND del_flg = 0 ORDER BY r_id DESC LIMIT 1";
$result_m = mysqli_query($conn, $sql_m);
$row = mysqli_fetch_array($result_m);

$dateString = date('Y-m-d', strtotime($row['r_date_buy']));

// Extract the year from the date string
$year = date('Y', strtotime($dateString));

// Add the guarantee period to the extracted year
$yearPlusGuarantee = $year + $row['r_guarantee'];

// Update the date string with the new year
$newDateString = str_replace($year, $yearPlusGuarantee, $dateString);

$currentDate = date('Y-m-d');

// echo $newDateString ." - AND -" .$currentDate;

if ($newDateString > $currentDate) {
    
} elseif ($row['r_id'] > 0) {
    if ($row['r_guarantee'] == NULL || $row['r_date_buy'] == NULL) {
        echo 'exists-have';
    } else{
        echo 'exists';
    }
}else if($row['r_id'] == NULL){
        echo 'exists-ok';
}
 else {
    echo 'exists';
}

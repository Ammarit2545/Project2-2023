<?php
session_start();
$session_repair = $_POST['session_repair'];
$parts_name = $_POST['parts_name'];
$value_parts = $_POST['value_parts'];
$extracted_number;
$text = $parts_name;
$pattern = '/^\d+/';

if (preg_match($pattern, $text, $matches)) {
    $extracted_number = $matches[0];
    echo $extracted_number;
} else {
    echo "No number found.";
}


if(isset($_POST['parts_name']) && isset($_POST['value_parts'])){
    $count=1;
    while(isset($_SESSION[$session_repair.'_'.$count])){
        $count++;
    }
    $count -= 1;
    if($count == 0){
        $_SESSION[$session_repair.'_1'] = $extracted_number;
        $_SESSION[$session_repair.'_'.'vale_1'] = $value_parts;
    }
    
}

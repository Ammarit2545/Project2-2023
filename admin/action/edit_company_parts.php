<?php
session_start();
include('../../database/condb.php');

foreach ($_POST as $key => $value) {
    echo $key . ": " . $value . "<br>";
}

$com_id = $_POST['com_id'];
$com_name = $_POST['com_name'];
$com_tel = $_POST['com_tel'];

$sql = "UPDATE company_parts
        SET com_p_name = '$com_name' ,com_p_tel = '$com_tel'
        WHERE com_p_id = '$com_id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['add_data_com_transport'] = 1;
    header('Location:../listview_company_parts.php');
} else {
    $_SESSION['add_data_com_transport'] = 0;
    header('Location:../edit_company_parts.php?id=' . urlencode($com_id));
}

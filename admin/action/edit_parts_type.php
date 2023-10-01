<?php
include('../../database/condb.php');

foreach($_POST as $key => $value) {
    echo $key . ": " . $value . "<br>";
}

$p_type_id = $_POST['p_type_id'];
$p_type_name = $_POST['p_type_name'];

$sql = "UPDATE parts_type SET p_type_name = '$p_type_name', p_type_update = NOW() WHERE p_type_id = '$p_type_id'";
$result = mysqli_query($conn, $sql);

if($result){
    echo "<script>alert('Update success');</script>";
    header('Location:../add_parts_type.php');
}else{
    echo "<script>alert('Update unsuccess');</script>";
    header('Location:../add_parts_type.php');
}

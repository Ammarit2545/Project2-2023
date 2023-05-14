<?php
include('../../database/condb.php');

foreach($_POST as $key => $value) {
    echo $key . ": " . $value . "<br>";
}

$role_id = $_POST['role_id'];
$role_name = $_POST['role_name'];

$sql = "UPDATE role SET role_name = '$role_name' WHERE role_id = '$role_id'";
$result = mysqli_query($conn, $sql);

if($result){
    echo "<script>alert('Update success');</script>";
    header('Location:../add_em_type.php');
}else{
    echo "<script>alert('Update unsuccess');</script>";
    header('Location:../add_em_type.php');
}

<?php
include('../../database/condb.php');
$role_id = $_GET['id'];

echo $id_part;

$sql = "UPDATE role SET del_flg = '1' WHERE role_id = '$role_id'";
$result = mysqli_query($conn, $sql);

if($result){
    header('Location:../add_em_type.php');
}

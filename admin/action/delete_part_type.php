<?php
include('../../database/condb.php');
$id_part = $_GET['id'];

echo $id_part;

$sql = "UPDATE parts_type SET del_flg = '1', pt_update = NOW() WHERE p_type_id = '$id_part'";
$result = mysqli_query($conn, $sql);

if($result){
    header('Location:../add_parts_type.php');
}

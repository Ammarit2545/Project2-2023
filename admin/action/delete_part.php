<?php
include('../../database/condb.php');
$id_part = $_GET['id'];

echo $id_part;

$sql = "UPDATE parts SET del_flg = '1' WHERE p_id = '$id_part'";
$result = mysqli_query($conn, $sql);

if($result){
    header('Location:../listview_parts.php');
}

<?php
include('../../database/condb.php');
$get_r_id = $_GET['get_r_id'];

echo $id_part;

$sql = "UPDATE get_repair SET del_flg = '1' WHERE get_r_id = '$get_r_id'";
$result = mysqli_query($conn, $sql);

if($result){
    header('Location:../listview_repair.php');
}

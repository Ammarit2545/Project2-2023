<?php
include('../../database/condb.php');
$id_e = $_GET['id'];

$sql = "UPDATE employee SET del_flg = '1' WHERE e_id = '$id_e'";
$result = mysqli_query($conn, $sql);

if($result){
    echo "<script>alert('Update success');</script>";
    header('Location:../employee_listview.php');
}
?>

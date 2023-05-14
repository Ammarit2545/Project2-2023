<?php
include('../../database/condb.php');

$id_c = $_GET['id'];

$sql = "UPDATE company SET del_flg = '1' WHERE com_id = '$id_c'";
$result = mysqli_query($conn, $sql);

if($result){
    echo "Company deleted successfully";
    header('Location:../listview_company.php');
} else {
    echo "Company deleting ";
}
?>
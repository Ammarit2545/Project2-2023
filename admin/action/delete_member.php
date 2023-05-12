<?php
include('../../database/condb.php');

$id_m = $_GET['id'];

$sql = "UPDATE member SET del_flg = '1' WHERE m_id = '$id_m'";
$result = mysqli_query($conn, $sql);

if($result){
    echo "Member deleted successfully";
    header('Location:../listview_member.php');
} else {
    echo "Member deleting employee";
}
?>
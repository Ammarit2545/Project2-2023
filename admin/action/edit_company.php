<?php
include('../../database/condb.php');

foreach($_POST as $key => $value) {
    echo $key . ": " . $value . "<br>";
}

$com_id = $_POST['com_id'];
$com_name = $_POST['com_name'];
$com_tel = $_POST['com_tel'];
$com_fax = $_POST['com_fax'];
$com_add = $_POST['com_add'];

$sql = "UPDATE company 
        SET com_name = '$com_name', com_name = '$com_name', com_tel = '$com_tel', com_fax = '$com_fax' 
        WHERE com_id = '$com_id'";
$result = mysqli_query($conn, $sql);

if($result){
    echo "<script>alert('Update success');</script>";
    header('Location:../listview_company.php');
}else{
    echo "<script>alert('Update unsuccess');</script>";
    header('Location:../edit_company.php?id=' . urlencode($com_id));
}

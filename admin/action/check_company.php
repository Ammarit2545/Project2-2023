<?php
include('../../database/condb.php');
$com_name = $_GET['com_name'];
$sql_e = "SELECT * FROM company WHERE com_name LIKE '%$com_name%'";
$result_e = mysqli_query($conn, $sql_e);
if (mysqli_num_rows($result_e) > 0) {
  echo 'exists';
}
?>

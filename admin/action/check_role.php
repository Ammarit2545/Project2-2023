<?php
include('../../database/condb.php');
$role_name = $_GET['role_name'];
$sql_e = "SELECT * FROM role WHERE role_name LIKE '%$role_name%'";
$result_e = mysqli_query($conn, $sql_e);
if (mysqli_num_rows($result_e) > 0) {
  echo 'exists';
}
?>

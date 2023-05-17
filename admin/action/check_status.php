<?php
include('../../database/condb.php');
$status_name = $_GET['status_name'];
$sql_e = "SELECT * FROM status_type WHERE status_name LIKE '%$status_name%'";
$result_e = mysqli_query($conn, $sql_e);
if (mysqli_num_rows($result_e) > 0) {
  echo 'exists';
}
?>

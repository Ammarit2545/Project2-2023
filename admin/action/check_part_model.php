<?php
include('../../database/condb.php');
$p_name = $_GET['p_name'];
$sql_e = "SELECT * FROM parts WHERE p_name LIKE '%$p_name%'";
$result_e = mysqli_query($conn, $sql_e);
if (mysqli_num_rows($result_e) > 0) {
  echo 'exists';
}
?>

<?php
include('../../database/condb.php');
$p_type = $_GET['p_type'];
$sql_e = "SELECT * FROM parts_type WHERE p_type_name LIKE '%$p_type%'";
$result_e = mysqli_query($conn, $sql_e);
if (mysqli_num_rows($result_e) > 0) {
  echo 'exists';
}
?>

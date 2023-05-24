<?php
include('../../database/condb.php');
$value_code = $_GET['value_code'];
$sql_e = "SELECT * FROM status_type WHERE value_code = '$value_code'";
$result_e = mysqli_query($conn, $sql_e);
if (mysqli_num_rows($result_e) > 0) {
  echo 'exists';
}
?>

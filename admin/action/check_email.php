<?php
include('../../database/condb.php');
$email = $_GET['email'];
$sql_e = "SELECT * FROM employee WHERE e_email = '$email'";
$result_e = mysqli_query($conn, $sql_e);
if (mysqli_num_rows($result_e) > 0) {
  echo 'exists';
}
?>

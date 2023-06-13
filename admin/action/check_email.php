<?php
include('../../database/condb.php');

$email = $_GET['email'];

$sql_m = "SELECT * FROM member WHERE m_email = '$email'";
$result_m = mysqli_query($conn, $sql_m);

$sql_e = "SELECT * FROM employee WHERE e_email = '$email'";
$result_e = mysqli_query($conn, $sql_e);

if (mysqli_num_rows($result_e) > 0 || mysqli_num_rows($result_m) > 0) {
  echo 'exists';
}

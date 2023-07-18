<?php
include('../../database/condb.php');

$billNumber = $_GET["bill_number"];

$sql = "SELECT * FROM parts_log WHERE pl_bill_number = '$billNumber'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo 'exists';
}
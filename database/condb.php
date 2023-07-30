<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "ane_electronic";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>  

<!-- CLose E_NOTICE -->

<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
?>

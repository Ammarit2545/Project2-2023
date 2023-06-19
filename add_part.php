<?php
// Establish database connection (replace with your credentials)
$host = "localhost";
$username = "root";
$password = "123456";
$dbname = "ane_electronic";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve data from the form
    $partName = $_POST['partName'];
    $partType = $_POST['partType'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO your_table_name (p_name, p_type_id) VALUES (:partName, :partType)");
    $stmt->bindParam(':partName', $partName);
    $stmt->bindParam(':partType', $partType);
    $stmt->execute();

    echo "Stock part added successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>

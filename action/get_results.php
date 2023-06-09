<?php
session_start();
include('../database/condb.php');
// Get the search value from the URL parameter
$searchValue = $_GET['search'];

// Query the database based on the search value
$sql = "SELECT * FROM get_detail
        LEFT JOIN repair ON  get_detail.r_id = repair.r_id
        WHERE repair.r_serial_number LIKE '%$searchValue%' OR repair.r_brand LIKE '%$searchValue%' OR repair.r_model LIKE '%$searchValue%' OR repair.r_number_model LIKE '%$searchValue%'";
$result = $conn->query($sql);

// Generate the dropdown list of search results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<p>' . $row['r_serial_number'] . ' - ' . $row['r_brand'] . ' - ' . $row['r_model'] . ' - ' . $row['r_number_model'] . '</p>';
    }
} else {
    echo '<p>No results found.</p>';
}

// Close the database connection
$conn->close();

<?php
// Include your database connection here (e.g., using mysqli or PDO)

// Check if a search query is provided
if (isset($_POST['query'])) {
include('../../database/condb.php');

    // Query to fetch parts based on the search query
    $sql = "SELECT parts.p_id, parts.p_brand, parts.p_model, parts_type.p_type_name
            FROM parts
            LEFT JOIN parts_type ON parts.p_type_id = parts_type.p_type_id
            WHERE parts.del_flg = 0
            AND (parts.p_brand LIKE '%$searchQuery%' OR parts.p_model LIKE '%$searchQuery%' OR parts_type.p_type_name LIKE '%$searchQuery%')";

    $result = $conn->query($sql);

    // Initialize an array to store the search results
    $searchResults = [];

    // Fetch and store results in the array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }

    // Close the database connection
    $conn->close();

    // Send the search results as JSON response
    header('Content-Type: application/json');
    echo json_encode($searchResults);
} else {
    // No search query provided
    echo json_encode([]);
}
?>

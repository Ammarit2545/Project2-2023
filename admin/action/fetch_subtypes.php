<?php
// Assuming you have a database connection established
include('../../database/condb.php'); // Include your database connection script

// Check if p_type_id is set and is a valid integer
if (isset($_GET['p_type_id']) && is_numeric($_GET['p_type_id'])) {
    $p_type_id = intval($_GET['p_type_id']);

    // Prepare and execute a query to fetch subtypes based on the selected p_type_id
    $sql = "SELECT * FROM parts_subtype WHERE del_flg = '0' AND p_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $p_type_id);
    $stmt->execute();

    // Fetch the results
    $result = $stmt->get_result();
    
    // Create an array to store the subtypes
    $subtypes = array();

    while ($row = $result->fetch_assoc()) {
        $subtypes[] = array(
            'p_subt_id' => $row['p_subt_id'],
            'p_subt_name' => $row['p_subt_name']
        );
    }

    // Close the database connection
    $stmt->close();

    // Return subtypes as JSON
    echo json_encode($subtypes);
} else {
    // Invalid or missing p_type_id parameter
    echo json_encode(array()); // Return an empty JSON array
}

// Don't forget to close the database connection in a real-world scenario
$conn->close();
?>

<?php
session_start();

// Get the product ID, value, and delivery ID from the request
$parts_id = $_GET['p_id'];
$parts_value = $_GET['value_p'];
$get_d_id = $_GET['get_d_id'];

// Initialize or update the session data for the specified product
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

$found = false;

foreach ($_SESSION['products'] as &$product) {
    if ($product['get_d_id'] === $get_d_id && $product['partsid'] === $parts_id) {
        // If the "get_d_id" and "partsid" match, add "value" to the existing entry
        $product['value'] += $parts_value;
        $found = true;
        break;
    }
}

if (!$found) {
    // If no matching entry was found, create a new entry
    $count_session = count($_SESSION['products']) + 1;

    $_SESSION['products'][$count_session] = [
        'get_d_id' => $get_d_id,
        'partsid' => $parts_id,
        'value' => $parts_value,
    ];
}

// Return a JSON response with the updated session data
echo json_encode($_SESSION['products']);
?>

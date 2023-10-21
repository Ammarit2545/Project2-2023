<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $value = $_POST['value'];

    // Update the session variable with the received name and value
    $_SESSION[$name] = $value;

    // Respond with a success message
    echo json_encode(['message' => 'Session updated successfully']);
} else {
    // Handle invalid requests
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid request']);
}
?>

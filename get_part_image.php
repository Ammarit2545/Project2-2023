<?php
include('database/condb.php');

if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];

    // Query the database to fetch the image URL based on the selected part ID
    $sql = "SELECT p_pic FROM parts WHERE del_flg = 0 AND p_id = '$p_id'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($result)) {
        $image_url = $row['p_pic'];
    } else {
        $image_url = 'default_image.jpg'; // Use a default image if no match is found
    }

    // Return the image URL as JSON
    echo json_encode(['image_url' => $image_url]);
} else {
    echo json_encode(['image_url' => 'default_image.jpg']); // Default image if no part ID is provided
}
?>

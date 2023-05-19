<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$picture_1 = $_FILES['picture_1']['name'];
echo "<br>".$picture_1;
$picture_2 = $_FILES['picture_2']['name'];
echo "<br>".$picture_2;
$picture_3 = $_FILES['picture_3']['name'];
echo "<br>".$picture_3;
$picture_4 = $_FILES['picture_4']['name'];
echo "<br>".$picture_4;


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $rs_detail = $_POST['rs_detail'];
    $status_id = $_POST['status_id'];
    // Retrieve the parts data
    $parts = array();
    $cardCount = $_POST['cardCount']; // Assuming you're passing the card count as a hidden input field
    for ($i = 1; $i <= $cardCount; $i++) {
        $partId = $_POST['p_id' . $i];
        $quantity = $_POST['value_p' . $i];
        $parts[] = array(
            'partId' => $partId,
            'quantity' => $quantity
        );
    }
    // Retrieve the uploaded images
    $uploadedImages = array();
    if (isset($_FILES['upload'])) {
        $totalFiles = count($_FILES['upload']['name']);
        for ($i = 0; $i < $totalFiles; $i++) {
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
            if ($tmpFilePath != "") {
                // You can process the uploaded file here, such as moving it to a specific directory
                // and storing the file path in the $uploadedImages array
                $uploadedImages[] = $_FILES['upload']['name'][$i];
            }
        }
    }
    // Retrieve other form data
    $p_price_sum = $_POST['p_price_sum'];
    $rate = $_POST['rate'];
    $total = $_POST['total'];

    for ($i = 0; $i < count($parts); $i++) {
        $partId = $parts[$i]['partId'];
        $quantity = $parts[$i]['quantity'];
        echo "<br><br>Part ID_$i: " . $partId . "<br>";
        echo "Quantity_$i: " . $quantity . "<br>";
        echo "<br>";
    }

    // Perform the necessary operations with the retrieved data
    // ...
    // Here you can perform database operations, data processing, or any other necessary actions based on the received form data

    // // ...
    // $sql = "INSERT INTO your_table (rs_detail, status_id, p_price_sum, rate, total) VALUES ('$rs_detail', '$status_id', '$p_price_sum', '$rate', '$total')";
    // $result = mysqli_query($conn, $sql);

    // // Return a response or redirect the user to another page
    // // ...
    // // For example, you can redirect the user to a success page
    // header("Location: success.php");
    // exit();
}

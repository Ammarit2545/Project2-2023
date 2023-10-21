<!-- 
    
    แก้ไขข้อมูล จำนวนอะไหล่ 

-->

<?php
session_start();
include('../../database/condb.php');

foreach ($_POST as $key => $value) {
    echo $key . ": " . $value . "<br>";
}

$get_r_id = $_GET['id'];
$rs_id = $_POST['repair_status'];

echo $rs_id;

// // Retrieve the parts data Old
// $parts = array();
// $cardCount = $_POST['cardCount']; // Assuming you're passing the card count as a hidden input field
// for ($i = 1; $i <= $cardCount; $i++) {
//     $partId = $_POST['p_id' . $i];
//     $quantity = $_POST['value_p' . $i];
//     $parts[] = array(
//         'partId' => $partId,
//         'quantity' => $quantity
//     );
// }

$parts = array();

for ($i = 1; $i <= 20; $i++) {
    if (isset($_POST['check_' . $i])) {
        $get_d = $_POST['get_d_id' . $i];
        $partIds = $_POST['p_id_' . $i];
        $quantities = $_POST['value_p_' . $i];

        foreach ($partIds as $count_for => $partId) {
            $quantity = $quantities[$count_for];
            $parts[] = array(
                'get_d_id' => $get_d,
                'partId' => $partId,
                'quantity' => $quantity
            );

            // Assuming $_POST['value_p' . $i] is an array, you can access its elements like this:
            echo $quantity;
        }
    }
}

print_r($parts);

// echo $partId[7];

foreach ($parts as $part) {
    $get_d_id = $part['get_d_id'];
            $partId = $part['partId'];
            $quantity = $part['quantity'];

    // Check if the part exists and has sufficient stock
    $sql_s = "SELECT * FROM parts WHERE del_flg = '0' AND p_id = '$partId'";
    $result_s = mysqli_query($conn, $sql_s);

    if ($result_s && mysqli_num_rows($result_s) > 0) {
        $row_s = mysqli_fetch_array($result_s);
        $p_stock = $row_s['p_stock'];

        // Check if the part exists and has sufficient stock
        $sql_s = "SELECT * FROM repair_detail WHERE del_flg = '0' AND p_id = '$partId' AND rs_id = $rs_id";
        $result_before = mysqli_query($conn, $sql_s);
        $row_before = mysqli_fetch_array($result_before);

        // Check if there is sufficient stock for the requested quantity
        if ($p_stock >= $quantity) {

            if ($quantity > $row_before['rd_value_parts']) {
                $total_s = $row_s['p_price'] * $quantity;
                $p_stock = ($quantity - $row_before['rd_value_parts']);

                // Update the stock in the parts table
                $sql_update_stock = "UPDATE parts SET p_stock = p_stock - $p_stock WHERE p_id = '$partId'";
                mysqli_query($conn, $sql_update_stock);

                // echo $partId . " - " . $quantity;

                // Insert data into repair_detail table
                $sql_insert = "UPDATE repair_detail 
                                SET `p_id` = '$partId', `rd_value_parts` = '$quantity', `rd_parts_price` = '$total_s', `rd_date_in` = NOW() 
                                WHERE `rs_id` = '$rs_id'";
                mysqli_query($conn, $sql_insert);
            } else {
                $total_s = $row_s['p_price'] * $quantity;
                $p_stock =  $row_before['rd_value_parts'] - $quantity;

                // Update the stock in the parts table
                $sql_update_stock = "UPDATE parts SET p_stock = p_stock + $p_stock WHERE p_id = '$partId'";
                mysqli_query($conn, $sql_update_stock);

                // echo $partId . " - " . $quantity;

                // Insert data into repair_detail table
                $sql_insert = "UPDATE repair_detail 
                                SET `p_id` = '$partId', `rd_value_parts` = '$quantity', `rd_parts_price` = '$total_s', `rd_date_in` = NOW() 
                                WHERE `rs_id` = '$rs_id'";
                mysqli_query($conn, $sql_insert);
            }
        } else {
        }
    } else {
        // Part does not exist or has been deleted
        $_SESSION["add_data_alert"] = 1;
        header("Location: ../mini_part_detail.php?id=$get_r_id");
        exit();
    }
}

// All parts added successfully
$_SESSION["add_data_alert"] = 0;
header("Location: ../mini_part_detail.php?id=$get_r_id");
exit();

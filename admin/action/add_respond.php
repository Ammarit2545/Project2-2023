<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$picture_1 = $_FILES['picture_1']['name'];
echo "<br>" . $picture_1;
$picture_2 = $_FILES['picture_2']['name'];
echo "<br>" . $picture_2;
$picture_3 = $_FILES['picture_3']['name'];
echo "<br>" . $picture_3;
$picture_4 = $_FILES['picture_4']['name'];
echo "<br>" . $picture_4;

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

    $get_r_id = $_POST['get_r_id'];
    $get_wages = $_POST['get_wages'];

    $sqll_c = "SELECT * FROM `repair`
        LEFT JOIN get_repair ON repair.r_id = get_repair.r_id
        WHERE get_repair.del_flg = '0' AND get_repair.get_r_id = '$get_r_id'";
    $resultt_c = mysqli_query($conn, $sqll_c);
    $roww_e = mysqli_fetch_array($resultt_c);

    $m_id = $roww_e['m_id'];

    // Usage:
    // $folderName = "../uploads/$m_id/$get_r_id/2"; // the name of the folder to be deleted
    // deleteDirectory($folderName);

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

    // Perform necessary operations with the retrieved data
    // ...

    $e_id = $_SESSION["id"];

    $sql3 = "SELECT * FROM repair_status ORDER BY rs_date_time DESC LIMIT 1";
    $result4 = mysqli_query($conn, $sql3);
    $row_re = mysqli_fetch_array($result4);

    $rs_id_c = $row_re['rs_id'];

    $sql3 = "SELECT * FROM repair_status 
            WHERE rs_id = '$rs_id_c' AND status_id = '$status_id' AND rs_detail = '$rs_detail' ";
    $result4 = mysqli_query($conn, $sql3);
    $row_re_c = mysqli_fetch_array($result4);

    if ($row_re_c['rs_id'] > 0) {
        // header("Location: ../detail_repair.php?id=$get_r_id");
    } else {
        // Insert data into repair_status table
        $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id ,e_id)
                VALUES ('$get_r_id', NOW(), '$rs_detail','$status_id',$e_id )";
        $result3 = mysqli_query($conn, $sql3);
        $rs_id = mysqli_insert_id($conn);

        $sql3 = "UPDATE get_repair SET get_wages = '$get_wages' WHERE get_r_id = '$get_r_id' AND del_flg = '0'";
        $result3 = mysqli_query($conn, $sql3);



        $folderName = "../../uploads/$m_id/$get_r_id/$rs_id"; // the name of the new folder
        if (!file_exists($folderName)) { // check if the folder already exists
            mkdir($folderName, 0777, true); // create the new folder with permissions
            echo "Folder created successfully";
        } else {
            echo "Folder already exists";
        }

        // Loop over the four images
        for ($i = 1; $i <= 4; $i++) {
            $image_name = "picture_" . $i;
            if (isset($_FILES[$image_name])) {
                $target_dir = $folderName;
                $target_file = $target_dir . '/' . basename($_FILES[$image_name]["name"]);

                $target_file_db = "uploads/$m_id/$get_r_id/$rs_id/" . basename($_FILES[$image_name]["name"]);

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if (
                    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" && $imageFileType != "mp4" && $imageFileType != "mov"
                ) {
                    echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, and MOV files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                        echo "The file " . htmlspecialchars(basename($_FILES[$image_name]["name"])) . " has been uploaded.";

                        // Insert To DATABASE
                        $sql_p = "INSERT INTO repair_pic (rp_pic, rp_date, rs_id)
                    VALUES ('$target_file_db', NOW(), '$rs_id')";
                        $result_p = mysqli_query($conn, $sql_p);
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }

        if ($result3) {
            // Process parts data
            foreach ($parts as $part) {
                $partId = $part['partId'];
                $quantity = $part['quantity'];

                // Insert data into repair_detail table
                $sql_s = "SELECT * FROM parts WHERE del_flg = '0' AND p_id = '$partId'";
                $result_s = mysqli_query($conn, $sql_s);

                if ($result_s && mysqli_num_rows($result_s) > 0) {
                    $row_s = mysqli_fetch_array($result_s);
                    $p_stock = $row_s['p_stock'] - $quantity;
                    $total_s = $row_s['p_price'] * $quantity;

                    $sql3 = "INSERT INTO repair_detail (`p_id`, `rd_value_parts`, `rd_parts_price`, `rs_id`, `rd_date_in`)
                VALUES ('$partId', '$quantity', '$total_s', '$rs_id', NOW())";
                    $result3 = mysqli_query($conn, $sql3);

                    if ($result3) {
                        // Update parts stock in the parts table
                        $sql_u = "UPDATE `parts` SET `p_stock` = `p_stock` - '$quantity', `p_date_update` = NOW() WHERE `p_id` = '$partId'";
                        $result_u = mysqli_query($conn, $sql_u);

                        if (!$result_u) {
                            // Handle the case when the update query fails
                            // ...
                        }
                    } else {
                        // Handle the case when the insert query into repair_detail table fails
                        // ...
                    }
                } else {
                    // Handle the case when the select query for parts data fails or no rows are found
                    // ...
                }
            }
            // Redirect the user to a success page
            header("Location: ../detail_repair.php?id=$get_r_id");
            exit();
        } else {
            // Handle the case when the insert query into repair_status table fails
            // ...
            // header("Location: ../detail_repair.php?id=$get_r_id");
        }
    }
}
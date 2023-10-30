<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$p_type_id = $_POST['p_type_id'];
$p_brand = $_POST['p_brand'];
$p_model = $_POST['p_model'];
$p_name = $_POST['p_name'];
$p_detail = $_POST['p_description'];
$p_stock = $_POST['p_stock'];
$p_price = $_POST['p_price'];
$p_cost_price = $_POST['p_cost_price'];
$p_pic = $_FILES['p_pic']['name'];

$sql_p = "SELECT * FROM parts WHERE p_brand = '$p_brand'  
AND p_model = '$p_model' 
AND p_name = '$p_name' 
AND p_type_id = '$p_type_id'";

$result_p = mysqli_query($conn, $sql_p);
$row_p = mysqli_fetch_array($result_p);


if ($row_p[0] == NULL) {
    if ($p_type_id == -1) {
        $p_type_name = $_POST['p_type_name'];

        echo $p_type_name;

        $sqlp = "SELECT * FROM parts_type WHERE p_type_name = '$p_type_name'  ";
        $resultp = mysqli_query($conn, $sqlp);
        $rowp = mysqli_fetch_array($resultp);

        if ($rowp[0] == NULL) {
            echo $p_type_name;

            $sql = "INSERT INTO `parts_type`(`p_type_name`, `p_type_date_in`, `del_flg`) 
            VALUES ('$p_type_name',NOW(),'0')";
            $result = mysqli_query($conn, $sql);

            $sql_p_c = "SELECT * FROM parts_type WHERE p_type_name = '$p_type_name' ORDER BY p_type_date_in DESC";
            $result_p_c = mysqli_query($conn, $sql_p_c);
            $row_p_c = mysqli_fetch_array($result_p_c);

            $p_type_id = $row_p_c[0];
        } else {
            $p_type_id = $rowp[0];
        }
    }
    echo "This : " . $p_type_id;

    $folderName = "../../parts/$p_type_id";
    if (!file_exists($folderName)) {
        mkdir($folderName);
        echo "Folder created successfully";
    } else {
        echo "Folder already exists";
    }

    $target_dir = $folderName . "/";
    $file_extension = strtolower(pathinfo($_FILES["p_pic"]["name"], PATHINFO_EXTENSION));
    $filename = $p_brand . "_" . $p_model . "." . $file_extension; // New filename
    $target_file = $target_dir . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["p_pic"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["p_pic"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["p_pic"]["tmp_name"])) . " has been uploaded.";

            // Resize the uploaded image
            if (($file_extension == "jpg" || $file_extension == "jpeg" || $file_extension == "png" || $file_extension == "gif") && function_exists('imagecreatefromjpeg')) {
                $uploaded_image = imagecreatefromjpeg($target_file); // or imagecreatefrompng, imagecreatefromgif
                $new_width = imagesx($uploaded_image); // Original width
                $new_height = imagesy($uploaded_image); // Original height

                // Set the desired image quality (0-100, 100 being the highest quality)
                $image_quality = 80; // You can adjust this value as needed

                // Create a new image with the same resolution
                $resized_image = imagecreatetruecolor($new_width, $new_height);

                // Copy the original image to the new image (no resizing)
                imagecopyresampled($resized_image, $uploaded_image, 0, 0, 0, 0, $new_width, $new_height, $new_width, $new_height);

                // Save the resized image with the specified quality
                imagejpeg($resized_image, $target_file, $image_quality); // Save the resized image

                // Clean up
                imagedestroy($uploaded_image);
                imagedestroy($resized_image);
            } elseif (($file_extension == "mp4" || $file_extension == "mov") && function_exists('shell_exec')) {
                // If it's a video file, you can use shell_exec to compress it (requires external tool like FFmpeg)

                // Specify the path to the FFmpeg executable (if not in system PATH)
                $ffmpeg_path = "../ffmpeg/ffmpeg-6.0/"; // Specify the path to your FFmpeg executable

                // Make sure the input and output file paths are properly escaped
                $input_file = escapeshellarg($target_file);
                $output_file = escapeshellarg($target_file . ".compressed." . $file_extension);

                // Build the FFmpeg command
                $command = "$ffmpeg_path -i $input_file -vf scale=800:600 $output_file";

                // Execute the FFmpeg command
                shell_exec($command);

                // Optionally, you can replace the original with the compressed version
                rename($output_file, $target_file);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $pic_path = "parts/$p_type_id/$filename ";

    $sql = "INSERT INTO parts (p_date_in, p_type_id, p_brand, p_model, p_name, p_detail, p_stock, p_price, p_cost_price, p_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "siisssddss", $p_date_in, $p_type_id, $p_brand, $p_model, $p_name, $p_detail, $p_stock, $p_price, $p_cost_price, $pic_path);
        $p_date_in = date('Y-m-d H:i:s'); // Assuming p_date_in is a datetime field
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in preparing the SQL statement: " . mysqli_error($conn);
    }
    
    echo 'asdsad';
    $_SESSION["add_data_alert"] = 0;
    // header('Location:../listview_parts.php');
    header('Location:../listview_parts.php');

    // display an alert message
    echo "<script>alert('Success!');</script>";
} else {
    $_SESSION["add_data_alert"] = 1;
    // redirect to a new page
    header('Location:../add_part.php');

    // display an alert message
    echo "<script>alert('Error!');</script>";
}

<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$id = $_SESSION["id"];
$r_id = $_GET['id'];
$tel  = $_POST['get_tel'];
$id_r = 0;

$sql = "SELECT * FROM member WHERE m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

// Count All Of Card
$sum = 1;
while (isset($_SESSION['r_id_' . $sum])) {
    echo  $sum;
    $sum++;
}
$sum -= 1;

$address_json;
if (isset($_POST['Ref_prov_id']) && isset($_POST['Ref_dist_id']) && isset($_POST['Ref_subdist_id']) && isset($_POST['zip_code']) && isset($_POST['description'])) {

    $address = array("province" => $_POST['Ref_prov_id'], "district" => $_POST['Ref_dist_id'], "sub_district" => $_POST['Ref_subdist_id'], "zip_code" => $_POST['zip_code'], "description" => $_POST['description']);
    $address_json = json_encode($address);
} else {
    $address_json = $row['m_add'];
}
$radiocheck = $_POST['flexRadioDefault'];

if (isset($_SESSION['r_id_1'])) {
    $sql2 = "INSERT INTO get_repair (get_r_date_in, get_tel, get_add, get_deli) VALUES (NOW(), ?, ?, ?)";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "sss", $tel, $address_json, $radiocheck);
    $result2 = mysqli_stmt_execute($stmt2);
} else {
    header("location:../listview_repair.php");
}

if ($result2) {
    $insertedId = mysqli_insert_id($conn);
    $id_r_g = $insertedId;

    $sql3 = "INSERT INTO repair_status (get_r_id, rs_date_time, rs_detail, status_id) VALUES (?, NOW(), 'ยื่นเรื่องซ่อม','1')";
    $stmt3 = mysqli_prepare($conn, $sql3);
    mysqli_stmt_bind_param($stmt3, "i", $id_r_g);
    $result3 = mysqli_stmt_execute($stmt3);
    $insertedId_st = mysqli_insert_id($conn);

    // Loop in Sum
    for ($i = 1; $i <= $sum; $i++) {
        $r_id = 'r_id_' . $i;

        if (isset($_SESSION[$r_id])) {
            $r_id = 'r_id_' . $i;

            $_SESSION[$r_id] = $i;

            $name_brand = 'name_brand_' . $i;

            $serial_number = 'serial_number_' . $i;

            $name_model = 'name_model_' . $i;

            $number_model = 'number_model_' . $i;

            // $tel = 'tel_' . $i;

            $description = 'description_' . $i;

            $company = 'company_' . $i;

            $image1 = 'image1_' . $i;

            $image2 = 'image2_' . $i;

            $image3 = 'image3_' . $i;

            $image4 = 'image4_' . $i;

            $id_repair_ever = 'id_repair_ever_' . $i;

            $id_repair_round = 'id_repair_round_' . $i;

            // echo  $i;
            $sql = "SELECT * FROM repair WHERE r_serial_number = '$serial_number' AND m_id = '$id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            if ($row > 0) {
                // การกระทำอื่น
                $name_brand_data = $_SESSION[$name_brand];

                $serial_number_data = $_SESSION[$serial_number];

                $name_model_data = $_SESSION[$name_model];

                $number_model_data = $_SESSION[$number_model];

                // $tel = 'tel_' . $i;

                $description_data = $_SESSION[$description];

                $company_data = $_SESSION[$company];

                $image1_data = $_SESSION[$image1];

                $image2_data = $_SESSION[$image2];

                $image3_data = $_SESSION[$image3];

                $image4_data = $_SESSION[$image4];

                if (isset($_SESSION[$id_repair_ever])) {
                    $id_repair_round_data = $_SESSION[$id_repair_round];
                } else {
                    $id_repair_round_data = 1;
                }

                $id_r = $row['r_id'];

                // Assuming you have already initialized the variables used in the query

                // Prepare the first statement to count occurrences of r_id
                $stmt = mysqli_prepare($conn, "SELECT COUNT(r_id) FROM get_detail WHERE r_id = ?");
                mysqli_stmt_bind_param($stmt, "s", $id_r);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $r_id_count);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                // Prepare the second statement to insert a new record
                $stmt = mysqli_prepare($conn, "INSERT INTO get_detail (get_r_id, get_d_record, r_id, get_d_record, get_d_detail) VALUES (?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sssis", $insertedId, $id_repair_round_data, $id_r, $r_id_count, $description_data);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $insertedId_get_detail = mysqli_insert_id($conn);

                // Here, you would need to replace 'make stm ?? to blind value' with the actual code to set the value of $rs_id.
                // Depending on your application logic, it might be another database operation or some other value assignment.

                // For example, if you want to set $rs_id to the auto-generated ID from the second INSERT operation:
                $rs_id = $insertedId_get_detail;

                $folderName_insert_get = "../uploads/$id/$id_r_g/"; // the name of the new folder
                if (!file_exists($folderName_insert_get)) { // check if the folder already exists
                    mkdir($folderName_insert_get); // create the new folder
                    echo "Folder created successfully";
                } else {
                    echo "Folder already exists";
                }

                $folderName = "../uploads/$id/$id_r_g/$insertedId_get_detail/"; // the name of the new folder
                if (!file_exists($folderName)) { // check if the folder already exists
                    mkdir($folderName); // create the new folder
                    echo "Folder created successfully";
                } else {
                    echo "Folder already exists";
                }

                $source_dir = "../uploads/$id/Holder/$i/"; // Replace with the actual path to the directory you want to move the files from
                $destination_dir = "../uploads/$id/$id_r_g/$insertedId_get_detail/"; // Replace with the actual path to the directory you want to move the files to

                if (!is_dir($destination_dir)) { // Check if the destination directory exists
                    mkdir($destination_dir, 0777, true); // Create the destination directory if it doesn't exist
                }

                foreach (new DirectoryIterator($source_dir) as $file) {
                    if ($file->isFile()) {
                        $file_name = $file->getFilename();
                        $destination_file = $destination_dir . $file_name;
                        if (rename($file->getPathname(), $destination_file)) {
                            echo "File " . $file_name . " moved successfully<br>";
                            $path_file_pic = "uploads/$id/$id_r_g/$insertedId_get_detail/$file_name";
                            $sql_p = "INSERT INTO repair_pic (rp_pic, rp_date ,get_d_id)
                       VALUES ( '$path_file_pic', NOW(),'$insertedId_get_detail')";
                            $result_p = mysqli_query($conn, $sql_p);
                        } else {
                            echo "Error moving file " . $file_name . "<br>";
                        }
                    }
                }
            } else {

                $name_brand_data = $_SESSION[$name_brand];

                $serial_number_data = $_SESSION[$serial_number];

                $name_model_data = $_SESSION[$name_model];

                $number_model_data = $_SESSION[$number_model];

                // $tel = 'tel_' . $i;

                $description_data = $_SESSION[$description];

                $company_data = $_SESSION[$company];

                $image1_data = $_SESSION[$image1];

                $image2_data = $_SESSION[$image2];

                $image3_data = $_SESSION[$image3];

                $image4_data = $_SESSION[$image4];

                $id_repair_ever = 'id_repair_ever_' . $i;

                $id_repair_round = 'id_repair_round_' . $i;


                if (isset($_SESSION[$id_repair_ever])) {
                    $id_repair_round_data = $_SESSION[$id_repair_round];

                    $sql_r_id = "SELECT r_id FROM repair WHERE r_serial_number = '$serial_number_data' AND m_id = '$id'";
                    $result_r_id = mysqli_query($conn, $sql_r_id);
                    $row_r_id = mysqli_fetch_array($result_r_id);

                    $id_r = $row_r_id['r_id'];
                } else {
                    $id_repair_round_data = 1;
                    echo 'the number : ' . $i . '<br>';
                    $sql = "INSERT INTO repair (m_id, r_brand, r_model, r_number_model, r_serial_number ,com_id)
                            VALUES ('$id', '$name_brand_data', '$name_model_data', '$number_model_data', '$serial_number_data' ,'$company_data')";
                    $result = mysqli_query($conn, $sql);
                    $insertedId_r = mysqli_insert_id($conn);
                    $id_r = $insertedId_r;
                }

                $sql = "INSERT INTO get_detail (get_r_id, r_id, get_d_record, get_d_detail)
                    VALUES ('$insertedId', '$id_r', '$id_repair_round_data', '$description_data')";
                $result = mysqli_query($conn, $sql);
                $insertedId_get_detail = mysqli_insert_id($conn);
                $rs_id = $insertedId_st;

                $folderName_insert_get = "../uploads/$id/$id_r_g/"; // the name of the new folder
                if (!file_exists($folderName_insert_get)) { // check if the folder already exists
                    mkdir($folderName_insert_get); // create the new folder
                    echo "Folder created successfully";
                } else {
                    echo "Folder already exists";
                }

                $folderName = "../uploads/$id/$id_r_g/$insertedId_get_detail/"; // the name of the new folder
                if (!file_exists($folderName)) { // check if the folder already exists
                    mkdir($folderName); // create the new folder
                    echo "Folder created successfully";
                } else {
                    echo "Folder already exists";
                }

                $source_dir = "../uploads/$id/Holder/$i/"; // Replace with the actual path to the directory you want to move the files from
                $destination_dir = "../uploads/$id/$id_r_g/$insertedId_get_detail/"; // Replace with the actual path to the directory you want to move the files to

                if (!is_dir($destination_dir)) { // Check if the destination directory exists
                    mkdir($destination_dir, 0777, true); // Create the destination directory if it doesn't exist
                }

                foreach (new DirectoryIterator($source_dir) as $file) {
                    if ($file->isFile()) {
                        $file_name = $file->getFilename();
                        $destination_file = $destination_dir . $file_name;
                        if (rename($file->getPathname(), $destination_file)) {
                            echo "File " . $file_name . " moved successfully<br>";
                            $path_file_pic = "uploads/$id/$id_r_g/$insertedId_get_detail/$file_name";
                            $sql_p = "INSERT INTO repair_pic (rp_pic, rp_date ,get_d_id)
                       VALUES ( '$path_file_pic', NOW(),'$insertedId_get_detail')";
                            $result_p = mysqli_query($conn, $sql_p);
                        } else {
                            echo "Error moving file " . $file_name . "<br>";
                        }
                    }
                }
            }

            $sql_m = "SELECT * FROM member WHERE m_id = '$id'";
            $result_m = mysqli_query($conn, $sql_m);
            $row_m = mysqli_fetch_array($result_m);

            $sToken = "T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3";
            // T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3

            $dateString = date('Y-m-d');
            $date = DateTime::createFromFormat('Y-m-d', $dateString);
            $formattedDate = $date->format('d F Y');

            $sMessage = "\nวันที่ : " . $formattedDate . "\n";
            $sMessage .= "\nมีการแจ้งซ่อมใหม่เข้ามา : " . "\n";
            $sMessage .= "เลขที่ใบส่งซ่อม : " . $id_r_g;
            $sMessage .= "\nชื่อ : " . $row_m['m_fname'] . " " . $row_m['m_lname'] . "\n";
            $sMessage .= "เบอร์โทรติดต่อ : " . $tel . "\n";

            $chOne = curl_init();
            curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($chOne, CURLOPT_POST, 1);
            curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
            $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($chOne);

            //Result error 
            if (curl_error($chOne)) {
                echo 'error:' . curl_error($chOne);
            } else {
                $result_ = json_decode($result, true);
                echo "status : " . $result_['status'];
                echo "message : " . $result_['message'];
            }
            curl_close($chOne);

            unset($_SESSION["id_repair"]);
            unset($_SESSION["name_brand"]);
            unset($_SESSION["serial_number"]);
            unset($_SESSION["name_model"]);
            unset($_SESSION["number_model"]);
            unset($_SESSION["tel"]);
            unset($_SESSION["description"]);
            unset($_SESSION["image1"]);
            unset($_SESSION["image2"]);
            unset($_SESSION["image3"]);
            unset($_SESSION["image4"]);

            unset($_SESSION['id_repair_ever']);
            unset($_SESSION['id_repair_round']);
        }
    }

    $count = 1;
    while (isset($_SESSION['r_id_' . $count])) {
        unset($_SESSION['r_id_' . $count]);
        unset($_SESSION['name_brand_' . $count]);
        unset($_SESSION['serial_number_' . $count]);
        unset($_SESSION['name_model_' . $count]);
        unset($_SESSION['number_model_' . $count]);
        unset($_SESSION['tel_' . $count]);
        unset($_SESSION['description_' . $count]);
        unset($_SESSION['company_' . $count]);

        unset($_SESSION['image1_' . $count]);
        unset($_SESSION['image2_' . $count]);
        unset($_SESSION['image3_' . $count]);
        unset($_SESSION['image4_' . $count]);

        unset($_SESSION['id_repair_ever_' . $count]);
        unset($_SESSION['id_repair_round_' . $count]);
        $count++;
    }

    // Usage:
    $folderName = "../uploads/$id/Holder/"; // the name of the folder to be deleted

    function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $filePath = $dir . DIRECTORY_SEPARATOR . $file;

            if (is_dir($filePath)) {
                deleteDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }

        return rmdir($dir);
    }
    deleteDirectory($folderName);



    header("location:../repair_wait.php");
} else {
    header("location:../listview_repair.php");
    echo "Error: " . mysqli_error($conn);
}

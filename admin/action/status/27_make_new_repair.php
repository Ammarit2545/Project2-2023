<?php
session_start();
include('../../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$get_r_id = isset($_GET['get_r_id']) ? $_GET['get_r_id'] : (isset($_POST['get_r_id']) ? $_POST['get_r_id'] : null);
$get_wages = isset($_GET['get_wages']) ? $_GET['get_wages'] : (isset($_POST['get_wages']) ? $_POST['get_wages'] : null);
$get_add_price = isset($_GET['get_add_price']) ? $_GET['get_add_price'] : (isset($_POST['get_add_price']) ? $_POST['get_add_price'] : null);
$get_date_conf = isset($_GET['get_date_conf']) ? $_GET['get_date_conf'] : (isset($_POST['get_date_conf']) ? $_POST['get_date_conf'] : null);
$rs_detail = isset($_GET['rs_detail']) ? $_GET['rs_detail'] : (isset($_POST['rs_detail']) ? $_POST['rs_detail'] : null);
$status_id = isset($_GET['status_id']) ? $_GET['status_id'] : (isset($_POST['status_id']) ? $_POST['status_id'] : null);
$e_id = $_SESSION["id"];
$last_inserted_id = 0;

$sql_check = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg='0' AND status_id = '27'";
$result_check = mysqli_query($conn, $sql_check);

$count_c = 1;
$count_check = 0;

while (isset($_POST['get_d_id' . $count_c])) {
    if (isset($_POST['check_' . $count_c])) {
        echo 'have' . $count_c;
        $count_check++;
    }
    $count_c++;
}

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

if (mysqli_num_rows($result_check)) {
    $row_check = mysqli_fetch_array($result_check);

    $sql_see = "SELECT * FROM get_detail
                LEFT JOIN get_repair ON get_detail.get_r_id = get_repair.get_r_id
                LEFT JOIN repair ON get_detail.r_id = repair.r_id
                WHERE get_repair.get_r_id = '$get_r_id' AND get_repair.del_flg='0' AND get_detail.del_flg='0'";
    $result_see = mysqli_query($conn, $sql_see);

    if (mysqli_num_rows($result_see)) {
        $row_see = mysqli_fetch_array($result_see);

        $get_tel = isset($row_see['get_tel']) ? $row_see['get_tel'] : null;
        $get_add = isset($row_see['get_add']) ? $row_see['get_add'] : null;
            $sql_insert_repair = "UPDATE get_repair SET get_config = '$last_inserted_id' WHERE get_r_id = '$get_r_id'";
            $result_insert_repair = mysqli_query($conn, $sql_insert_repair);

            if ($result_insert_repair) {
                $sql_insert_repair = "INSERT INTO get_repair (get_r_date_in ,e_id ,get_tel ,get_add ,get_wages ,get_add_price ,get_date_conf,get_config) 
                VALUES (NOW(),'$e_id','$get_tel','$get_add','$get_wages','$get_add_price','$get_date_conf','$get_r_id')";
                $result_insert_repair = mysqli_query($conn, $sql_insert_repair);

                if ($result_insert_repair) {
                    $last_inserted_id = mysqli_insert_id($conn);
                    $select_c = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND del_flg = '0' AND status_id = '20'";
                    $result_ce = mysqli_query($conn, $select_c);
                    $row_ce = mysqli_fetch_array($result_ce);
                    $rs_detail = $row_ce['rs_detail'];

                    $sql_see = "SELECT * FROM get_detail
                                LEFT JOIN get_repair ON get_detail.get_r_id = get_repair.get_r_id
                                LEFT JOIN repair ON get_detail.r_id = repair.r_id
                                WHERE get_repair.get_r_id = '$get_r_id' AND get_repair.del_flg='0' AND get_detail.del_flg='0'";
                    $result_see = mysqli_query($conn, $sql_see);

                    $count_t = 0;

                    while ($row_while = mysqli_fetch_array($result_see)) {
                        $get_d_record = 0;
                        $get_d_record = $row_while['get_d_record'] + 1;
                        $r_id = $row_while['r_id'];
                        $sql_insert_repair = "INSERT INTO get_detail (get_r_id,r_id,get_d_record,get_d_detail) 
                        VALUES ('$last_inserted_id','$r_id','$get_d_record','$rs_detail')";
                        $result_insert_repair = mysqli_query($conn, $sql_insert_repair);

                        if ($result_insert_repair) {
                            $count_t++;
                            echo $count_t;
                        } else {
                            // Redirect the user to a success page
                            $_SESSION["add_data_alert"] = 1;
                            header("Location: ../../detail_repair.php?id=$get_r_id");
                        }
                    }

                    // if it does not already have data
                    $sql_e = "INSERT INTO repair_status (get_r_id, rs_detail, rs_date_time, status_id, e_id)
                            VALUES ('$last_inserted_id', '$rs_detail', NOW(), '4', '$e_id')";
                    $result_e = mysqli_query($conn, $sql_e);
                    $rs_id = mysqli_insert_id($conn);

                    // Loop over the four images
                    for ($i = 1; $i <= 4; $i++) {
                        $image_name = "file" . $i;
                        if (isset($_FILES[$image_name])) {
                            $target_dir = $folderName; // You need to define $folderName
                            $target_file = $target_dir . '/' . basename($_FILES[$image_name]["name"]);

                            $target_file_db = "uploads/$m_id/$last_inserted_id/$rs_id/" . basename($_FILES[$image_name]["name"]);

                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                            // Check if file already exists
                            if (file_exists($target_file)) {
                                echo "<br>Sorry, file already exists.";
                                $uploadOk = 0;
                            }

                            // Allow certain file formats
                            if (
                                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                && $imageFileType != "gif" && $imageFileType != "mp4" && $imageFileType != "mov"
                            ) {
                                echo "<br>Sorry, only JPG, JPEG, PNG, GIF, MP4, and MOV files are allowed.";
                                $uploadOk = 0;
                            }

                            // Check if $uploadOk is set to 0 by an error
                            if ($uploadOk == 0) {
                                echo "<br>Sorry, your file was not uploaded.";
                            } else {
                                if (move_uploaded_file($_FILES[$image_name]["tmp_name"], $target_file)) {
                                    echo "<br>The file " . htmlspecialchars(basename($_FILES[$image_name]["name"])) . " has been uploaded.";

                                    // Insert To DATABASE
                                    $sql_p = "INSERT INTO repair_pic (rp_pic, rp_date, rs_id)
                            VALUES ('$target_file_db', NOW(), '$rs_id')";
                                    $result_p = mysqli_query($conn, $sql_p);
                                } else {
                                    echo "<br>Sorry, there was an error uploading your file.";
                                }
                            }
                        }
                    }

                    if ($result_e) {
                        // Process parts data
                        $i = 1;
                        $get_d_id_parts = 0;

                        foreach ($parts as $part) {
                            $get_d_id = $part['get_d_id'];
                            $partId = $part['partId'];
                            $quantity = $part['quantity'];

                            // Insert data into repair_detail table
                            $sql_s = "SELECT * FROM parts WHERE del_flg = '0' AND p_id = '$partId'";
                            $result_s = mysqli_query($conn, $sql_s);

                            if ($result_s && mysqli_num_rows($result_s) > 0) {
                                $row_s = mysqli_fetch_array($result_s);

                                $p_stock = $row_s['p_stock'] - $quantity;
                                $total_s = $row_s['p_price'] * $quantity;

                                $sql3 = "INSERT INTO repair_detail (`p_id`, `rd_value_parts`, `rd_parts_price`, `rs_id`, `rd_date_in`, `get_d_id`)
                                    VALUES ('$partId', '$quantity', '$total_s', '$rs_id', NOW(), '$get_d_id')";
                                $result3 = mysqli_query($conn, $sql3);

                                if ($result3) {
                                    // Check if parts_use entry already exists for this repair
                                    $sql_check_pu = "SELECT * FROM parts_use WHERE rs_id = '$rs_id'";
                                    $result_check_pu = mysqli_query($conn, $sql_check_pu);
                                    if (mysqli_num_rows($result_check_pu) == 0) {
                                        // If it does not already have data, insert into parts_use table
                                        $sql_e = "INSERT INTO parts_use (rs_id, pu_date,st_id,e_id) VALUES ('$rs_id', NOW(),'3','$e_id')";
                                        $result_e = mysqli_query($conn, $sql_e);
                                        $pu_id = mysqli_insert_id($conn);
                                    } else {
                                        $row_pu = mysqli_fetch_array($result_check_pu);
                                        $pu_id = $row_pu['pu_id'];
                                    }
                                    // Insert data into parts_use table
                                    $sql_e = "INSERT INTO parts_use_detail (pu_id, p_id, pu_value, pu_date) VALUES ('$pu_id', '$partId', '$quantity', NOW())";
                                    $result_e = mysqli_query($conn, $sql_e);
                                }
                                $i++;
                            }
                        }
                        // Redirect the user to a success page
                        $_SESSION["add_data_alert"] = 0;
                        header("Location: ../../detail_repair.php?id=$last_inserted_id");
                    } else {
                        // Redirect the user to a success page
                        $_SESSION["add_data_alert"] = 1;
                        header("Location: ../../detail_repair.php?id=$get_r_id");
                    }
                } else {
                    // Redirect the user to a success page
                    $_SESSION["add_data_alert"] = 1;
                    header("Location: ../../detail_repair.php?id=$get_r_id");
                }
            } else {
                // Redirect the user to a success page
                $_SESSION["add_data_alert"] = 1;
                header("Location: ../../detail_repair.php?id=$get_r_id");
            }
            $rs_id = mysqli_insert_id($conn);
        
    } else {
        // Redirect the user to a success page
        $_SESSION["add_data_alert"] = 1;
        header("Location: ../../detail_repair.php?id=$get_r_id");
    }
} else {
    // Redirect the user to a success page
    $_SESSION["add_data_alert"] = 1;
    header("Location: ../../detail_repair.php?id=$get_r_id");
}
?>

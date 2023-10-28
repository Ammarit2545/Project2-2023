<?php
session_start();
include('../../../database/condb.php');


$get_r_id = isset($_GET['get_r_id']) ? $_GET['get_r_id'] : (isset($_POST['get_r_id']) ? $_POST['get_r_id'] : null);
$rs_detail = isset($_GET['rs_detail']) ? $_GET['rs_detail'] : (isset($_POST['rs_detail']) ? $_POST['rs_detail'] : null);
$status_id = isset($_GET['status_id']) ? $_GET['status_id'] : (isset($_POST['status_id']) ? $_POST['status_id'] : null);
$e_id = $_SESSION["id"];
echo '------------------'.$rs_detail.'------------------' ;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

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



// // Old Retrieve the parts data
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

if ($status_id == 17) {
    echo '<br>status = 17';
    $sql_c = "SELECT * FROM repair_status 
                LEFT JOIN get_repair ON get_repair.get_r_id = repair_status.get_r_id
                WHERE get_repair.get_r_id = '$get_r_id' AND repair_status.del_flg = '0' AND repair_status.status_id = '5' AND get_repair.del_flg = '0';";
    $result_c = mysqli_query($conn, $sql_c);
    $row_c_status = mysqli_fetch_array($result_c);

    if ($row_c_status[0] < 0) {
        // เอาคืนสต๊อก เอาค่าจาก $get_r_id
        $sql_c = "SELECT * FROM repair_detail 
                LEFT JOIN get_detail ON get_detail.get_d_id = repair_detail.get_d_id
                LEFT JOIN get_repair ON get_repair.get_r_id = get_detail.get_r_id
                WHERE get_detail.get_r_id = '$get_r_id' AND repair_detail.del_flg = '0' AND get_repair.del_flg = '0';";
        $result_c = mysqli_query($conn, $sql_c);
        while ($row_c = mysqli_fetch_array($result_c)) {
            $p_id = $row_c['p_id'];
            $rd_value_parts = $row_c['rd_value_parts'];

            // Update parts stock in the parts table
            $sql_u = "UPDATE `parts` SET `p_stock` = `p_stock` + '$rd_value_parts', `p_date_update` = NOW() WHERE `p_id` = '$p_id'";
            $result_u = mysqli_query($conn, $sql_u);


            if ($result_u) {
                // Check if parts_use entry already exists for this repair
                $sql_check_pu = "SELECT * FROM parts_use WHERE rs_id = '$rs_id'";
                $result_check_pu = mysqli_query($conn, $sql_check_pu);
                if (mysqli_num_rows($result_check_pu) == 0) {
                    // If it does not already have data, insert into parts_use table
                    $sql_e = "INSERT INTO parts_use (rs_id, pu_date,st_id,e_id) VALUES ('$rs_id', NOW(),'4','$e_id')";
                    $result_e = mysqli_query($conn, $sql_e);
                    $pu_id = mysqli_insert_id($conn);
                } else {
                    $row_pu = mysqli_fetch_array($result_check_pu);
                    $pu_id = $row_pu['pu_id'];
                }

                // Insert data into parts_use table
                $sql_e = "INSERT INTO parts_use_detail (pu_id, p_id, pu_value, pu_date) VALUES ('$pu_id', '$p_id', '$rd_value_parts', NOW())";
                $result_e = mysqli_query($conn, $sql_e);
            }
        }
    }

    $sql_c = "SELECT * FROM repair_status 
            LEFT JOIN get_repair ON get_repair.get_r_id = repair_status.get_r_id
            WHERE get_repair.get_r_id = '$get_r_id' AND repair_status.del_flg = '0' AND repair_status.status_id = '19' AND get_repair.del_flg = '0';";
    $result_c = mysqli_query($conn, $sql_c);
    $row_c_status = mysqli_fetch_array($result_c);

    if ($row_c_status[0] < 0) {
        // เอาคืนสต๊อก เอาค่าจาก $get_r_id
        $sql_c = "SELECT * FROM repair_detail 
                LEFT JOIN get_detail ON get_detail.get_d_id = repair_detail.get_d_id
                LEFT JOIN get_repair ON get_repair.get_r_id = get_detail.get_r_id
                WHERE get_detail.get_r_id = '$get_r_id' AND repair_detail.del_flg = '0' AND get_repair.del_flg = '0';";
        $result_c = mysqli_query($conn, $sql_c);
        while ($row_c = mysqli_fetch_array($result_c)) {
            $rs_id = $row_c['rs_id'];
            $p_id = $row_c['p_id'];
            $rd_value_parts = $row_c['rd_value_parts'];

            // Update parts stock in the parts table
            $sql_u = "UPDATE `parts` SET `p_stock` = `p_stock` + '$rd_value_parts', `p_date_update` = NOW() WHERE `p_id` = '$p_id'";
            $result_u = mysqli_query($conn, $sql_u);

            if ($result_u) {
                // Update the repair_detail table to indicate that the part has been used
                $sql_u_rd = "UPDATE `repair_detail` SET `del_flg` = '1' WHERE `rd_id` = '$rd_id'";
                $result_u_rd = mysqli_query($conn, $sql_u_rd);

                if ($result_u_rd) {
                    // Check if parts_use entry already exists for this repair
                    $sql_check_pu = "SELECT * FROM parts_use WHERE rs_id = '$rs_id'";
                    $result_check_pu = mysqli_query($conn, $sql_check_pu);
                    if (mysqli_num_rows($result_check_pu) == 0) {
                        // If it does not already have data, insert into parts_use table
                        $sql_e = "INSERT INTO parts_use (rs_id, pu_date,st_id,e_id) VALUES ('$rs_id', NOW(),'4','$e_id')";
                        $result_e = mysqli_query($conn, $sql_e);
                        $pu_id = mysqli_insert_id($conn);
                    } else {
                        $row_pu = mysqli_fetch_array($result_check_pu);
                        $pu_id = $row_pu['pu_id'];
                    }

                    // Insert data into parts_use table
                    $sql_e = "INSERT INTO parts_use_detail (pu_id, p_id, pu_value, pu_date) VALUES ('$pu_id', '$p_id', '$rd_value_parts', NOW())";
                    $result_e = mysqli_query($conn, $sql_e);
                }
            }
        }
    }



    //    ตัดของออกจาก Stock หลังจากยืนยัน
    $sql_check_p = "SELECT *
                    FROM repair_detail
                    LEFT JOIN get_repair ON get_repair.get_r_id = repair_detail.get_r_id
                    LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                    WHERE repair_status.get_r_id = '$get_r_id' AND repair_detail.del_flg = '0';";
    $result_check_p = mysqli_query($conn, $sql_check_p);

    while ($row_check_part = mysqli_fetch_array($result_check_p)) {

        $rd_id = $row_check_part['rd_id'];
        $p_id = $row_check_part['p_id'];
        $value_parts = $row_check_part['rd_value_parts'];

        $sql_update_detail = "UPDATE repair_detail SET del_flg = '1' , rd_update = NOW() WHERE rd_id = '$rd_id'";
        $result_update_detail = mysqli_query($conn, $sql_update_detail);
        if ($result_update_detail) {
            echo $row_check_part['rd_id'];
        }
    }
    //    ตัดของออกจาก Stock 


}


$sql_1 = "SELECT * FROM get_detail  WHERE get_r_id = '$get_r_id' AND del_flg = 0";

$result_1 = mysqli_query($conn, $sql_1);

// while ($row = mysqli_fetch_array($result_1)) {
//     $get_d_id = $row['get_d_id'];
//     if (isset($_POST['check_' . $get_d_id])) {
//         $sql = "UPDATE `get_detail` SET `get_d_conf`='0' WHERE get_d_id = '$get_d_id'";
//         $result = mysqli_query($conn, $sql);
//         echo "<br>the : " . $get_d_id . "update 000 success";
//     } else {
//         $sql = "UPDATE `get_detail` SET `get_d_conf`='1' WHERE get_d_id = '$get_d_id'";
//         $result = mysqli_query($conn, $sql);
//         echo "<br>the : " . $get_d_id . "update 111 success";
//     }
// }

$count_c = 1;
while (isset($_POST['get_d_id' . $count_c])) {
    $get_d_id =  $_POST['get_d_id' . $count_c];
    if (isset($_POST['check_' . $count_c])) {
        echo 'have' . $count_c;
        $count_check++;
        $sql = "UPDATE `get_detail` SET `get_d_conf`='0' WHERE get_d_id = '$get_d_id'";
        $result = mysqli_query($conn, $sql);
        echo "<br>the : " . $get_d_id . "update 000 success";
    } else {
        $sql = "UPDATE `get_detail` SET `get_d_conf`='1' WHERE get_d_id = '$get_d_id'";
        $result = mysqli_query($conn, $sql);
        echo "<br>the : " . $get_d_id . "update 111 success";
    }
    $count_c++;
}


// อัพวันที่คาดการณ์จะเสร็จ get_date_conf
if (isset($_POST['get_date_conf'])) {
    echo '<br>get_date_conf';
    $get_date_conf = $_POST['get_date_conf'];
    $sql = "UPDATE `get_repair` SET `get_date_conf`=' $get_date_conf' WHERE get_r_id = '$get_r_id'";
    $result = mysqli_query($conn, $sql);
    echo "<br>the : " . $get_r_id . "update -" . $get_date_conf . "- date";
}

// ราคาค่าส่งกับราคาค่าแรง get_add_price ,get_wages
if (isset($_POST['get_add_price']) || isset($_POST['get_wages'])) {
    echo '<br>get_add_price ,get_wages';
    $get_add_price = $_POST['get_add_price'];
    $get_wages = $_POST['get_wages'];

    echo '<br>' . $get_add_price . ' ' . $get_wages;

    //ถ้ามีราคาค่าส่ง
    if (isset($_POST['get_add_price'])) {
        $sql = "UPDATE `get_repair` SET `get_add_price`='$get_add_price' WHERE get_r_id = '$get_r_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<br>get_add_price - Successfully';
        } else {
            echo '<br>get_add_price - Un Successfully';
        }
    }

    //ถ้ามีราคาค่าแรง
    if (isset($_POST['get_wages'])) {
        $sql = "UPDATE `get_repair` SET `get_wages`='$get_wages' WHERE get_r_id = '$get_r_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<br>get_wages - Successfully';
        } else {
            echo '<br>get_wages - Un Successfully';
        }
    }
}

if ($status_id != 17 && $status_id != 5) {
    echo '<br>status_id = 17 , 5';
    $sql = "SELECT * FROM repair_status 
        LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
        WHERE repair_status.get_r_id = '$get_r_id' AND repair_status.rs_detail = '$rs_detail' AND repair_status.status_id = '$status_id'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
}

// if ($row[0] > 0) {
//     // if it already has data
//     echo $row[0];
//     $_SESSION["add_data_alert"] = 1;
//     header("Location: ../../detail_repair.php?id=$get_r_id");
// } else {


// if it does not already have data
$sql_e = "INSERT INTO repair_status (get_r_id, rs_detail, rs_date_time, status_id, e_id)
              VALUES ('$get_r_id', '$rs_detail', NOW(), '$status_id', '$e_id')";
$result_e = mysqli_query($conn, $sql_e);

$rs_id = mysqli_insert_id($conn);

if ($rs_id > 0) {
    $sql_m = "SELECT repair.m_id FROM repair 
                LEFT JOIN get_detail ON get_detail.r_id = repair.r_id
                  LEFT JOIN get_repair ON get_repair.get_r_id = get_detail.get_r_id
                  WHERE get_repair.get_r_id = '$get_r_id' AND get_repair.del_flg = '0'";
    $result_m = mysqli_query($conn, $sql_m);
    $row_m = mysqli_fetch_array($result_m);
    $m_id = $row_m['m_id'];

    $folderName = "../../../uploads/$m_id/$get_r_id/$rs_id"; // the name of the new folder
    if (!file_exists($folderName)) { // check if the folder already exists
        mkdir($folderName, 0777, true); // create the new folder with permissions
        echo "<br>Folder created successfully";
    } else {
        echo "<br>Folder already exists";
    }


    if (isset($_FILES["p_picture"])) {
        // Loop over the uploaded files
        foreach ($_FILES["p_picture"]["name"] as $key => $filename) {
            $target_file = $folderName . '/' . basename($filename);
            $target_file_db = "uploads/$m_id/$get_r_id/$rs_id/" . basename($filename);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "<br>Sorry, file '$filename' already exists.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            $allowedFormats = ["jpg", "jpeg", "png", "gif", "mp4", "mov"];
            if (!in_array($imageFileType, $allowedFormats)) {
                echo "<br>Sorry, file format '$imageFileType' is not allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<br>Sorry, your file '$filename' was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["p_picture"]["tmp_name"][$key], $target_file)) {
                    echo "<br>The file '$filename' has been uploaded.";

                    // Insert into DATABASE (you should use prepared statements to prevent SQL injection)
                    $sql_p = "INSERT INTO repair_pic (rp_pic, rp_date, rs_id) VALUES ('$target_file_db', NOW(), '$rs_id')";
                    $result_p = mysqli_query($conn, $sql_p);

                    if (!$result_p) {
                        echo "<br>Error inserting data into the database: " . mysqli_error($conn);
                    }
                } else {
                    echo "<br>Sorry, there was an error uploading your file '$filename'.";
                }
            }
        }
    } else {
        // Loop over the four images
        for ($i = 1; $i <= 4; $i++) {
            $image_name = "file" . $i;
            if (isset($_FILES[$image_name])) {
                $target_dir = $folderName;
                $target_file = $target_dir . '/' . basename($_FILES[$image_name]["name"]);

                $target_file_db = "uploads/$m_id/$get_r_id/$rs_id/" . basename($_FILES[$image_name]["name"]);

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

                    if (!$result_u) {
                        // Handle the case when the update query fails
                        // ...
                    }
                } else {
                    // Handle the case when the insert query into repair_detail table fails
                    // ...
                }
                $i++;
            } else {
                // Handle the case when the select query for parts data fails or no rows are found
                // ...
            }
        }
        // Redirect the user to a success page
        $_SESSION["add_data_alert"] = 0;
        header("Location: ../../detail_repair.php?id=$get_r_id");
    } else {
        // Handle the case when the insert query into repair_status table fails
        $_SESSION["add_data_alert"] = 1;
        header("Location: ../../detail_repair.php?id=$get_r_id");
    }
}

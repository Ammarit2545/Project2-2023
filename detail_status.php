<?php
session_start();
include('database/condb.php');
$id = $_SESSION['id'];
$status_id = 0;


$sql1 = "SELECT * FROM member WHERE m_id = '$id'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);
if ($id == NULL) {
    header('Location: home.php');
}

$count_carry_out = 0;
$check_order = 0;

// $id_g = $_GET['id'];
// $sql1 = "SELECT * FROM get_repair 
// LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
// LEFT JOIN repair ON repair.r_id = get_repair.r_id
// WHERE repair.m_id = '$id' AND get_repair.get_r_id = '$id_g'";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);
// if ($row1[0] == NULL) {
//     header('Location: status.php?search=ERROR 405');
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/status_ok_problem_ok.css">
    <link rel="stylesheet" href="css/all_page.css">
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Status - ANE</title>

    <!-- Example CDNs, use appropriate versions and sources -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: sans-serif;
        }

        .file-upload {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .file-upload-btn {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #0090C6;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #0090C6;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .file-upload-btn:hover {
            background: #0090C6;
            transition: all .2s ease;
            cursor: pointer;
        }

        .file-upload-btn:active {
            border: 0;
            transition: all .2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 4px dashed #0090C6;
            position: relative;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            background-color: #0090C6;
        }

        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .drag-text {
            text-align: center;
        }

        .drag-text h3 {
            font-weight: 100;
            text-transform: uppercase;
            color: gray;
            padding: 60px 0;
        }

        .file-upload-image {
            max-height: 200px;
            max-width: 200px;
            margin: auto;
            padding: 20px;
        }

        .remove-image {
            width: 200px;
            margin: 0;
            color: #fff;
            background: #cd4535;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #b02818;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .remove-image:hover {
            background: #c13b2a;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            /* Dim black background */
        }

        .modal-content {
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 100%;
            max-height: 100%;
            background-color: black;
            /* Set the background color to black */
        }

        #modal-image {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: auto;
            /* Center the image horizontally */
        }


        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .iframe-container {
            display: none;
        }

        .check_icon {
            margin-left: 10px;
        }

        #drop-shadow {
            border-radius: 5%;
            box-shadow: 0 2px 4px rgba(0, 0.2, 0.2, 0.2);
            /* Adjust the shadow properties as needed */
        }

        a {
            color: gray;
            transition: transform 0.3s ease;
        }

        a:hover {
            color: blue;
            transform: scale(1.2);
        }


        #bounce-item {
            /* box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); */
            /* Add a gray shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Add transition for transform and box-shadow */
        }

        #bounce-item:hover {
            transform: scale(1.1);
            /* Increase size on hover */
            /* box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); */
            /* Increase shadow size and intensity on hover */

        }
    </style>
</head>

<body>
    <!-- navbar-->
    <?php
    $part_check = 0;
    if ($row1 > 0) {
        include('bar/topbar_user.php');
    }

    $id_get_r = $_GET['id'];
    $sql = "SELECT * FROM get_repair
        LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id 
        LEFT JOIN status_type ON repair_status.status_id  = status_type.status_id 
        WHERE get_repair.get_r_id = $id_get_r AND repair_status.del_flg = '0' ORDER BY repair_status.rs_date_time DESC;";
    $result = mysqli_query($conn, $sql);

    $sql2 = "SELECT * FROM get_repair
        LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id 
        LEFT JOIN status_type ON repair_status.status_id  = status_type.status_id 
        WHERE get_repair.get_r_id = $id_get_r AND repair_status.del_flg = '0' ORDER BY repair_status.rs_date_time DESC;";
    $result2 = mysqli_query($conn, $sql2);
    $row_2 = mysqli_fetch_array($result2);

    $sql_c = "SELECT * FROM get_detail
    LEFT JOIN get_repair ON get_detail.get_r_id = get_repair.get_r_id 
    LEFT JOIN repair ON repair.r_id = get_detail.r_id WHERE get_repair.get_r_id = '$id_get_r' AND repair.del_flg = '0'";
    $result_c = mysqli_query($conn, $sql_c);
    $row_c = mysqli_fetch_array($result_c);

    $get_add_price = $row_c['get_add_price'];
    ?>

    <!-- end navbar-->

    <!-- <div class="background"></div> -->
    <br><br>
    <div class="px-5 pt-5 repair">
        <div class="container">
            <div class="row">
                <div class="col-6 text-left" style="background-color: #F1F1F1;">
                    <!-- <h3 class="pt-5"><button class="btn btn-primary">ยี่ห้อ : <?= $row_c['r_brand'] ?> , รุ่น : <?= $row_c['r_model'] ?></button></h3> -->
                    <h4 class="pt-5"><button class="btn btn-primary">เลขที่ส่งซ่อมที่ : <?= $id_get_r ?></button></h4>
                    <!-- <h3 class="pt-2">เลข Serial Number : <?= $row_c['r_serial_number'] ?></h3> -->
                    <h4 class="pb-5">เลขที่ส่งซ่อมที่ : <?= $id_get_r ?></h4>
                </div>
                <div class="col-6" style="background-color: #F1F1F1;">
                </div>
                <br>
            </div>
        </div>
        <div class="container">
            <!-- <iframe src="pay_qr.php?id=<?= $id_get_r ?>" frameborder="0" width="100%" style="height: 1000px;"></iframe> -->
        </div>
        <br>
        <div class="container" height="1000px" style="background-color: #F1F1F1; ">
            <div class="row p-3">
                <div class="col-5 text-left" id="bounce-item">
                    <center>
                        <h4><a style="text-decoration: none;">ดูรายละเอียดอุปกรณ์ของท่าน</a></h4>

                    </center>
                </div>
                <div class="col-2 ">
                    <center>
                        <h3>|</h3>
                    </center>
                </div>
                <div class="col-5" id="bounce-item">
                    <center>
                        <h4><a style="text-decoration: none; " onclick="openModalPart('quantitypart')">ดูยอดอะไหล่ของท่าน</a></h4>
                    </center>
                </div>
                <br>
            </div>
        </div>

        <div class="container my-5 p-4" style="background-color: #F1F1F1; border-radius : 1%;">
            <?php if ($row_2['status_id'] == 3) { ?>
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-check-square"></i> ดำเนินการซ่อมเสร็จสิ้น
                </div>
            <?php } ?>

            <div class="row">
                <div class="col">
                    <br>
                    <h2 style="margin-left: 1.2rem;">ติดตามสถานะ (Status)</h2>
                    <br>
                    <ul class="timeline-3">
                        <?php
                        while ($row1 = mysqli_fetch_array($result)) {
                            $i = $i + 1;
                            $id_r = $row1[0];
                            $sql_c = "SELECT * FROM get_detail WHERE r_id = '$id_r' AND del_flg = '0' ORDER BY get_r_id DESC LIMIT 1";
                            $result_c = mysqli_query($conn, $sql_c);
                            $row_c = mysqli_fetch_array($result_c);

                            // Check if data is found
                            if ($row_c) {
                                $found_data = true;
                                // Display data
                            }

                            $dateString = date('d-m-Y', strtotime($row1['rs_date_time']));
                            $date = DateTime::createFromFormat('d-m-Y', $dateString);
                            $formattedDate = $date->format('d F Y');

                            $status_id = $row1['status_id'];

                            $sql_c = "SELECT * FROM repair_status WHERE get_r_id = '$id_get_r' AND del_flg = 0 ORDER BY rs_id DESC";
                            $result_c = mysqli_query($conn, $sql_c);
                            $row_p = mysqli_fetch_array($result_c);
                        ?>
                            <hr style="border: 5px solid black;">
                            <li>
                                <h5 style="display:inline"><button class="btn btn-outline-secondary" style="color : white; background-color : <?= $row1['status_color'] ?>; border : 2px solid <?= $row1['status_color'] ?>;"><?= $row1['status_name'] ?>
                                        <?php
                                        if ($row1['status_id'] == 6) {

                                            $carry_out_id = $row['status_id'];
                                            $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = 155 AND status_id = 6 ORDER BY rs_date_time DESC;";
                                            $result_carry_out = mysqli_query($conn, $sql_cary_out);
                                            $row_carry_out = mysqli_fetch_array($result_carry_out);

                                            if ($row_carry_out[0] > 1) {
                                        ?>
                                                #ครั้งที่<?= $row_carry_out[0] - $count_carry_out ?>

                                        <?php
                                            }
                                            $count_carry_out += 1;
                                        } ?></button></h5>
                                <h6 style="display:inline;"><i class="uil uil-book"></i>&nbsp;<?= $formattedDate ?></h6>
                                <p style="display:inline-block;color : gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row1['rs_date_time'])); ?></p>
                                <?php
                                $rs_id = $row1['rs_id'];
                                $sql_check_p = "SELECT * FROM repair_detail WHERE rs_id = '$rs_id' AND del_flg = '0'";
                                $result_check_p = mysqli_query($conn, $sql_check_p);
                                $row = mysqli_fetch_array($result_check_p);

                                $sql_check_p = "SELECT rd_id
                                FROM repair_detail
                                LEFT JOIN get_repair ON get_repair.get_r_id = repair_detail.get_r_id
                                LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                                WHERE repair_status.get_r_id = '$id_get_r' AND repair_detail.del_flg = '0';";
                                $result_check_p = mysqli_query($conn, $sql_check_p);
                                $row_check_part = mysqli_fetch_array($result_check_p);

                                if ($row_p['rs_id'] == $row1['rs_id'] && $row_check_part['rd_id'] != NULL) {
                                    if ($row1['status_id'] != 8) {
                                        if ($row1['status_id'] == 9 || $row1['status_id'] == 10) {
                                ?>
                                            <a class="btn btn-outline-danger" style="margin-left: 20px" href="#" onclick="openModalPart('quantitypart')">จำนวนอะไหล่</a>
                                        <?php
                                        } else {
                                        ?>
                                            <a class="btn btn-outline-danger" style="margin-left: 20px" href="#" onclick="openModalPart('quantitypart')">ดูจำนวนอะไหล่ที่ต้องใช้</a>
                                        <?php }
                                    } else {
                                        ?>
                                <?php
                                    }
                                }

                                ?>
                                <?php if ($row1['status_id'] == 8 && $row1['rs_conf'] == NULL) {

                                ?>
                                    <a href="form_pay.php?id=<?= $id_get_r ?>" class="btn btn-primary">ทำการชำระเงิน</a>
                                <?php
                                } ?>
                                <?php if ($row1['get_track'] != NULL && $row1['status_id'] == 24) {
                                ?>
                                    <hr>
                                    <h5 class="btn btn-outline-primary">หมายเลข Tracking ของท่าน</h5>
                                    <!-- HTML -->
                                    <div id="copyText" style="cursor: pointer;">
                                        <p style="margin-left: 30px; display : inline;">Click to copy: </p>
                                        <p class="mt-2" style="display : inline;color : green;"><?= $row1['get_track'] ?></p>
                                        <br>
                                        <span id="copyMessage" class="btn btn-success" style="display: none; color:white; margin-left: 30px;"></span>
                                    </div>

                                    <script>
                                        document.getElementById("copyText").addEventListener("click", function() {
                                            var textToCopy = "<?= $row1['get_track'] ?>";

                                            // Create a temporary input element
                                            var tempInput = document.createElement("input");
                                            tempInput.type = "text";
                                            tempInput.value = textToCopy;
                                            document.body.appendChild(tempInput);

                                            // Copy the text from the input element
                                            tempInput.select();
                                            document.execCommand("copy");

                                            // Remove the temporary input element
                                            document.body.removeChild(tempInput);

                                            // Display the copy message
                                            var copyMessage = document.getElementById("copyMessage");
                                            copyMessage.textContent = "Text copied: " + textToCopy;
                                            copyMessage.style.display = "inline";

                                            // Hide the copy message after 1 second
                                            setTimeout(function() {
                                                copyMessage.style.display = "none";
                                            }, 2000);
                                        });
                                    </script>

                                <?php
                                } ?>

                                <?php if ($row1['status_id'] == 4 || $row1['status_id'] == 17 && $row1['rs_conf'] == NULL || $row1['rs_conf'] == 1) {

                                ?>

                                    <div>

                                        <?php if ($check_order  == 0) { ?>
                                            <hr>
                                            <p class="btn btn-outline-primary">รายการที่สามารถซ่อมได้</p>
                                            <?php
                                            $count_conf = 0;

                                            $sql_get_c = "SELECT * FROM get_detail 
                                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                        WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.del_flg = 0";
                                            $result_get_c = mysqli_query($conn, $sql_get_c);

                                            while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                                                $count_conf++;
                                            ?>
                                                <div class="alert alert-<?php if ($row_get_c['get_d_conf'] == 0) { ?>primary<?php } elseif ($row_get_c['get_d_conf'] == 1) { ?>danger<?php } ?>" role="alert">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" <?php if ($row_get_c['get_d_conf'] == 0) { ?>checked disabled<?php } elseif ($row_get_c['get_d_conf'] == 1) { ?>disabled<?php } ?>>
                                                        <label class="form-check-label" for="inlineCheckbox1"><?= $count_conf ?></label>
                                                    </div>
                                                    <?= $row_get_c['r_brand'] . " " . $row_get_c['r_model'] . " - Model : " . $row_get_c['r_number_model'] . " - Serial Number : " . $row_get_c['r_serial_number']  ?>
                                                </div>
                                        <?php

                                            }
                                        }

                                        ?>
                                    </div>
                                <?php
                                } ?>

                                <hr>
                                <h5 class="btn btn-outline-primary">รายละเอียด</h5>
                                <p class="mt-2" style="margin-left: 30px;"><?= $row1['rs_detail'] ?></p>
                                <hr>
                                <h5 class="btn btn-outline-primary">เลือกวิธีการจัดส่งอุปกรณ์มาที่ร้าน</h5>
                                <!-- <p class="mt-2" style="margin-left: 30px;"><?= $row1['rs_detail'] ?></p> -->
                                <center>
                                    <button id="bounce-item" class="btn btn-primary">ส่งที่หน้าร้าน</button>
                                    <button id="bounce-item" class="btn btn-warning">จัดส่งผ่านไปรษณีย์</button>
                                </center>
                                

                                <?php if ($row1['status_id'] == 4 || $row1['status_id'] == 17 && $row1['rs_conf'] == NULL || $row1['rs_conf'] == 1) {
                                    $total =  $row1['get_wages'] + $row1['get_add_price'];
                                ?><?php if ($check_order  == 0) { ?>
                                <hr>
                                <?php if ($row1['get_date_conf'] != NULL) {  ?>
                                    <p class="mt-2" style="margin-left: 30px;"> - ระยะเวลาซ่อม <?= number_format($row1['get_date_conf']) ?> วัน <span style="color:red">( นับจากวันที่รับอุปกรณ์ )</span></p>
                                <?php }  ?>
                                <?php if ($row1['get_wages'] != NULL) {  ?>
                                    <p class="mt-2" style="margin-left: 30px;"> - ค่าแรงช่าง <?= number_format($row1['get_wages']) ?> บาท</span></p>
                                <?php }  ?>
                                <?php if ($row1['get_add_price'] != NULL) {  ?>
                                    <p class="mt-2" style="margin-left: 30px;"> - ค่าจัดส่ง <?= number_format($row1['get_add_price']) ?> บาท</span></p>
                                <?php }
                                        $total_part = 0;
                                        $sql_c = "SELECT
                                     repair_detail.p_id,
                                     COUNT(repair_detail.p_id) AS count,
                                     parts.p_brand,
                                     parts.p_model,
                                     parts.p_price,
                                     parts_type.p_type_name,
                                     repair_status.rs_id,
                                     parts.p_pic
                                   FROM
                                     `repair_detail`
                                        LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                                        LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
                                        JOIN parts ON parts.p_id = repair_detail.p_id
                                        LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id
                                   WHERE
                                     get_repair.del_flg = 0 AND repair_detail.del_flg = 0
                                     AND get_repair.get_r_id = '$id_get_r'
                                   GROUP BY
                                     p_id;
                                     ";
                                        $result_c = mysqli_query($conn, $sql_c);
                                        while ($row_c = mysqli_fetch_array($result_c)) {
                                            $total_part += $row_c['p_price'];
                                        }

                                ?>
                                <?php if ($total_part > 0) {  ?>
                                    <p class="mt-2" style="margin-left: 30px;display:inline"> - ค่าอะไหล่ <?= $total_part ?> บาท</span></p> <a onclick="openModalPart('quantitypart')" style="display:inline; color:red">ดูอะไหล่ที่ต้องใช้</a>
                                <?php }  ?>
                                <h5 class="alert alert-primary" style="margin-left: 30px;">รวมราคา <?= number_format($total + $total_part) ?> บาท</span></h3>
                            <?php
                                    }
                                    $check_order = 1;
                                } ?>


                            <?php if ($row1['rs_cancel_detail'] != NULL) {
                            ?>
                                <hr>
                                <h5 class="btn btn-outline-danger">เหตุผลการไม่ยืนยัน</h5>
                                <p class="mt-2"><?= $row1['rs_cancel_detail'] ?></p>
                            <?php

                            }

                            ?>
                            <div class="col text-left" style="background-color: #F1F1F1;">
                                <?php
                                $sql_pic = "SELECT * FROM repair_pic WHERE rs_id = $rs_id AND del_flg = 0 ";
                                $result_pic = mysqli_query($conn, $sql_pic);
                                $row_pic_check = mysqli_fetch_array($result_pic);

                                if ($row_pic_check[0] > 0) {
                                ?>
                                    <hr>
                                    <h6 class="btn btn-outline-secondary">รูปภาพประกอบ</h6>
                                    <br><br>
                                <?php
                                }
                                ?>
                                <?php
                                $status_id = $row1['status_id'];

                                $sql_s = "SELECT * FROM repair_status WHERE status_id = '$status_id' AND del_flg = '0' AND get_r_id = $id_get_r ORDER BY rs_date_time DESC LIMIT 1";
                                $result_s = mysqli_query($conn, $sql_s);
                                $row_s = mysqli_fetch_array($result_s);
                                $rs_id = $row_s['rs_id'];

                                $sql_pic = "SELECT * FROM repair_pic WHERE rs_id = $rs_id AND del_flg = 0 ";
                                $result_pic = mysqli_query($conn, $sql_pic);

                                while ($row_pic = mysqli_fetch_array($result_pic)) {
                                ?>
                                    <?php
                                    $rp_pic = $row_pic['rp_pic'];
                                    $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                    ?>

                                    <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                        <a href="#">
                                            <img src="<?= $rp_pic ?>" width="100px" id="drop-shadow" class="picture_modal" alt="" onclick="openModalIMG(this)">
                                        </a>
                                    <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                        <a href="#">
                                            <video width="100px" id="drop-shadow" autoplay muted onclick="openModalVideo(this)" src="<?= $rp_pic ?>">
                                                <source src="<?= $rp_pic ?>" type="video/mp4">
                                                <source src="<?= $rp_pic ?>" type="video/ogg">
                                                Your browser does not support the video tag.
                                            </video>
                                        </a>
                                    <?php endif; ?>


                                    <!-- Modal -->
                                    <div id="modal" class="modal">
                                        <span class="close" onclick="closeModal()">&times;</span>
                                        <video id="modal-video" controls class="modal-video"></video>
                                    </div>

                                    <script>
                                        function openModalVideo(element) {
                                            var modal = document.getElementById('modal');
                                            var modalVideo = document.getElementById('modal-video');

                                            modal.style.display = 'block';
                                            modal.classList.add('show');

                                            modalVideo.src = element.src;
                                            modalVideo.style.height = '90%';
                                            modalVideo.style.borderRadius = '2%';
                                            modalVideo.style.display = 'block';
                                            modalVideo.style.margin = '0 auto';
                                        }


                                        function closeModal() {
                                            var modal = document.getElementById('modal');
                                            var modalVideo = document.getElementById('modal-video');
                                            modalVideo.pause();
                                            modalVideo.currentTime = 0;
                                            modalVideo.src = ""; // Reset the video source
                                            modal.style.display = 'none';
                                        }

                                        window.addEventListener('click', function(event) {
                                            var modal = document.getElementById('modal');
                                            if (event.target === modal) {
                                                closeModal();
                                            }
                                        });
                                    </script>
                                <?php
                                } ?>
                            </div>

                            <!--  Part modal -->
                            <div id="quantitypartModal" class="modal">
                                <div class="modal-content">
                                    <h2>จำนวนอะไหล่ทั้งหมด</h2>
                                    <button class="close-button btn btn-primary" onclick="closeModalStatus('quantitypart')" width="200px">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <!--  content for Part modal -->
                                    <iframe src="mini_part_detail.php?id=<?= $id_get_r ?>" style="width: 100%; height: 1000px;" class="no-scrollbar"></iframe>
                                </div>
                            </div>


                            <script>
                                function readURL(input) {
                                    if (input.files && input.files[0]) {

                                        var reader = new FileReader();

                                        reader.onload = function(e) {
                                            $('.image-upload-wrap').hide();

                                            $('.file-upload-image').attr('src', e.target.result);
                                            $('.file-upload-content').show();

                                            $('.image-title').html(input.files[0].name);
                                        };

                                        reader.readAsDataURL(input.files[0]);

                                    } else {
                                        removeUpload();
                                    }
                                }

                                function removeUpload() {
                                    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
                                    $('.file-upload-content').hide();
                                    $('.image-upload-wrap').show();
                                }
                                $('.image-upload-wrap').bind('dragover', function() {
                                    $('.image-upload-wrap').addClass('image-dropping');
                                });
                                $('.image-upload-wrap').bind('dragleave', function() {
                                    $('.image-upload-wrap').removeClass('image-dropping');
                                });

                                function openModalPart(modalName) {
                                    var modal = document.getElementById(modalName + "Modal");
                                    modal.style.display = "block";
                                    modal.classList.add("show");
                                }

                                function closeModalPart(modalName) {
                                    var modal = document.getElementById(modalName + "Modal");
                                    modal.style.display = "none";
                                    modal.classList.remove("show");
                                }
                                // ////////////////////////////////////////////////////////////
                                function openModalPay(modalName) {
                                    var modal = document.getElementById(modalName + "Modal");
                                    modal.style.display = "block";
                                    modal.classList.add("show");
                                }

                                function closeModalPay(modalName) {
                                    var modal = document.getElementById(modalName + "Modal");
                                    modal.style.display = "none";
                                    modal.classList.remove("show");
                                }
                                // ////////////////////////////////////////////////////////////

                                function openModalStatus(modalName) {
                                    var modal = document.getElementById(modalName + "Modal");
                                    modal.style.display = "block";
                                    modal.classList.add("show");
                                }

                                function closeModalStatus(modalName) {
                                    var modal = document.getElementById(modalName + "Modal");
                                    modal.style.display = "none";
                                    modal.classList.remove("show");
                                }

                                function closeModalPay(modalName) {
                                    var modal = document.getElementById(modalName + "Modal");
                                    modal.style.display = "none";
                                    modal.classList.remove("show");
                                }
                            </script>

                            <div id="modalimg" class="modal">
                                <span class="close" onclick="closeModalIMG()">&times;</span>
                                <img id="modal-image" src="" alt="Modal Photo">
                            </div>
                            <script src="script.js"></script>
                            <script>
                                function openModalIMG(img) {
                                    var modal = document.getElementById("modalimg");
                                    var modalImg = document.getElementById("modal-image");
                                    modal.style.display = "block";
                                    modalImg.src = img.src;
                                    modalImg.style.width = "60%"; // Set the width to 1000 pixels
                                    modalImg.style.borderRadius = "2%"; // Set the border radius to 20%
                                    modal.classList.add("show");
                                }

                                function closeModalIMG() {
                                    var modal = document.getElementById("modalimg");
                                    modal.style.display = "none";
                                }
                            </script>
                            </li>
                            <br>
                            <?php if ($row1['status_id'] == 24 && $row1['rs_conf'] == NULL) { ?>

                                <hr>
                                <p style="margin-left: 2%; color:red">*** ตรวจเช็คความปกติของอุปกรณ์ของท่านว่าใช้ได้หรือไม่ก่อนทำการยืนยันเสร็จสิ้นการซ่อม ***</p>
                                <a class="btn btn-danger" style="margin-left: 2%" href="send_config.php?id=<?= $id_get_r ?>">แจ้งเจ้าหน้าที่กรณีมีปัญหา</a>
                                <a class="btn btn-success" style="margin-left: 2%" onclick="showConfirmation()">ยืนยัน</a>


                                <script>
                                    function showConfirmation() {
                                        Swal.fire({
                                            title: 'เสร็จสิ้น',
                                            text: 'หากท่านตรวจเช็คเสร็จสิ้นแล้ว ให้ทำการยืนยัน?',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'ยืนยัน',
                                            cancelButtonText: 'ยกเลิก'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // User confirmed, navigate to the desired page
                                                window.location.href = 'action/add_only_status.php?id=<?= $id_get_r ?>';
                                            }
                                        });
                                    }
                                </script>

                                <br>
                            <?php
                            }
                            ?>

                            <?php
                            if ($row[0] > 0) {
                                if ($row1['rs_conf'] == NULL) { ?>
                                    <hr>
                                    <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p>
                                    <a class="btn btn-danger" style="margin-left: 2%" onclick="showDiv()">ไม่ทำการยืนยัน</a>

                                    <!-- Add your button href="action/conf_part.php?id=<?= $id_get_r ?>" -->
                                    <!-- <a  class="btn btn-success" id="confirmButtonSuccess">ยืนยัน</a> -->
                                    <!-- <button class="btn btn-success" id="confirmButtonSuccess">ยืนยัน</button> -->
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var id_get_r = <?php echo json_encode($id_get_r); ?>; // Pass PHP variable to JavaScript
                                            var status_id = <?php echo json_encode($status_id); ?>; // Pass PHP variable to JavaScript

                                            document.getElementById('confirmButtonSuccess').addEventListener('click', function() {
                                                Swal.fire({
                                                    icon: 'question',
                                                    title: 'ยืนยันดำเนินการส่งซ่อม',
                                                    text: 'การ "ยืนยัน" จะไม่สามารถกลับมาแก้ไขข้อมูลได้?',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'ยืนยัน',
                                                    cancelButtonText: 'ยกเลิก'
                                                }).then((willConfirm) => {
                                                    if (willConfirm.isConfirmed) {
                                                        window.location.href = "action/conf_part.php?id=" + id_get_r + "&status_id=" + status_id; // Redirect with the passed value
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                    <!-- Update the anchor tag to include PHP code for the dynamic link -->
                                    <a class="btn btn-success" id="confirmButtonSuccess" style="display:inline-block">ยืนยันการส่งซ่อม</a>
                                    <br>

                                    <div id="myDiv" style="display: none; margin: 20px 30px;">
                                        <form id="canf_cancel" action="action/conf_cancel.php" method="POST">
                                            <hr>
                                            <h4 style="color: red">โปรดระบุเหตุผลที่ยกเลิก</h4>
                                            <input type="text" name="get_r_id" value="<?= $id_get_r ?>" hidden>
                                            <input type="text" name="status_id" value="<?= $status_id ?>" hidden>
                                            <label>
                                                <input class="form-check-input" type="checkbox" name="checkbox1" value="ต้องการยกเลิกคำสั่งซ่อม" onclick="uncheckOtherCheckboxes('checkbox1')">
                                                ต้องการยกเลิกคำสั่งซ่อม
                                            </label><br>

                                            <label>
                                                <input class="form-check-input" type="checkbox" name="checkbox2" value="ไม่อยากใช้อะไหล่ข้างต้น" onclick="uncheckOtherCheckboxes('checkbox2')">
                                                ไม่อยากใช้อะไหล่ข้างต้น
                                            </label><br>

                                            <label>
                                                <input class="form-check-input" type="checkbox" name="checkbox3" value="อยากได้อะไหล่ที่ถูกกว่านี้" onclick="uncheckOtherCheckboxes('checkbox3')">
                                                อยากได้อะไหล่ที่ถูกกว่านี้
                                            </label><br>

                                            <label>
                                                <input class="form-check-input" type="checkbox" name="checkbox4" onclick="showTextarea(); uncheckOtherCheckboxes('checkbox4')">
                                                อื่นๆ (หรือยื่นข้อเสนอ)
                                            </label><br>

                                            <textarea id="myTextarea" name="detail_cancel" style="display: none;" placeholder="โปรดระบุสาเหตุ"></textarea>

                                            <br>
                                            <a class="btn btn-danger" onclick="hideDiv()">ยกเลิก</a>
                                            <a class="btn btn-success" id="confirmButtoncancel">ยืนยัน</a>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var id_get_r = <?php echo json_encode($id_get_r); ?>; // Pass PHP variable to JavaScript
                                                    var dialogShown = false; // Flag variable to track if the dialog is already displayed

                                                    document.getElementById('confirmButtoncancel').addEventListener('click', function() {
                                                        if (dialogShown) {
                                                            return; // Exit if the dialog is already shown
                                                        }

                                                        dialogShown = true; // Set the flag to true to indicate that the dialog is displayed

                                                        Swal.fire({
                                                            icon: 'warning',
                                                            title: 'ยืนยันดำเนินการส่งซ่อม',
                                                            text: 'การ "ยืนยันเพื่อยกเลิก" จะไม่สามารถกลับมาแก้ไขข้อมูลได้?',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'ยืนยัน',
                                                            cancelButtonText: 'ยกเลิก'
                                                        }).then((willConfirm) => {
                                                            if (willConfirm.isConfirmed) {
                                                                var form = document.getElementById('canf_cancel');
                                                                form.submit(); // Submit the form
                                                            }

                                                            dialogShown = false; // Reset the flag when the dialog is closed
                                                        });
                                                    });
                                                });
                                            </script>

                                        </form>
                                    </div>

                                    <script>
                                        function uncheckOtherCheckboxes(currentCheckboxName) {
                                            var checkboxes = document.querySelectorAll('input[type="checkbox"]');

                                            checkboxes.forEach(function(checkbox) {
                                                if (checkbox.name !== currentCheckboxName) {
                                                    checkbox.checked = false;
                                                }
                                            });
                                        }

                                        function showTextarea() {
                                            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                                            var lastCheckbox = checkboxes[checkboxes.length - 1];
                                            var textarea = document.getElementById("myTextarea");

                                            if (lastCheckbox.checked) {
                                                textarea.style.display = "block";
                                            } else {
                                                textarea.style.display = "none";
                                            }
                                        }

                                        function showDiv() {
                                            var div = document.getElementById("myDiv");
                                            var conf = document.getElementById("confirmButtonSuccess");
                                            div.style.display = "block";
                                            conf.style.display = "none";
                                        }

                                        function hideDiv() {
                                            var div = document.getElementById("myDiv");
                                            var conf = document.getElementById("confirmButtonSuccess");
                                            div.style.display = "none";
                                            conf.style.display = "inline-block";
                                        }
                                    </script>

                                    <br><br>
                                <?php
                                }
                            }
                            if ($status_id == 8) {
                                ?>

                                <!--  Part modal -->
                                <div id="payModal" class="modal">
                                    <div class="modal-content">
                                        <h2>จำนวนอะไหล่ทั้งหมด</h2>
                                        <button class="close-button btn btn-primary" onclick="closeModalPay('pay')" width="200px">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <!-- content for Part modal -->
                                        <iframe src="pay_qr.php?id=<?php echo $id_get_r; ?>" style="width: 100%; height: 1000px;"></iframe>
                                    </div>
                                </div>

                                <div id="payaddModal" class="modal">
                                    <div class="modal-content">
                                        <h2>จำนวนอะไหล่ทั้งหมด</h2>
                                        <button class="close-button btn btn-primary" onclick="closeModalPay('payadd')" width="200px">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <!--  content for Part modal -->
                                        <iframe src="pay_qr.php?id=<?php echo $id_get_r; ?>&get_add=<?= $get_add_price ?>" style="width: 100%; height: 1000px;" class="no-scrollbar"></iframe>

                                    </div>
                                </div>
                            <?php
                            }
                            if ($row1['rs_conf'] == 1 && $row1['status_id'] == 8) {  ?>

                                <div class="alert alert-success" role="alert" style="margin-left : 10px">
                                    คุณได้ทำการยืนยันการชำระเงินแล้ว "โปรดรอการตอบกลับ"
                                </div>
                                <span class="check_icon"><i class="fa fa-check"></i> ส่งวันที่ : <?= $row1['rs_conf_date'] ?></span>
                                <!-- <button class="btn btn-success" style="margin-left : 10px"> คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ" </button> -->
                            <?php } else if ($row1['rs_conf'] == 4 && $row1['status_id'] == 8) {  ?>
                                <div class="alert alert-primary" role="alert" style="margin-left : 10px">
                                    คุณได้ทำการส่งที่อยู่ไปให้พนักงานแล้ว "โปรดรอการตอบกลับการชำระเงินอีกครั้ง"
                                </div>
                                <span class="check_icon"><i class="fa fa-check"></i> ส่งวันที่ : <?= $row1['rs_conf_date'] ?></span>
                                <!-- <button class="btn btn-success" style="margin-left : 10px"> คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ" </button> -->
                            <?php } else if ($row1['rs_conf'] == 1 && $row1['status_id'] == 24) {  ?>
                                <div class="alert alert-success" role="alert" style="margin-left : 10px">
                                    คุณได้ทำการตรวจสอบและยอมรับแล้ว
                                </div>
                                <span class="check_icon"><i class="fa fa-check"></i> ส่งวันที่ : <?= $row1['rs_conf_date'] ?></span>
                                <!-- <button class="btn btn-success" style="margin-left : 10px"> คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ" </button> -->
                            <?php } else if ($row1['rs_conf'] == 1) {  ?>

                                <div class="alert alert-success" role="alert" style="margin-left : 10px">
                                    คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ"
                                </div>
                                <span class="check_icon"><i class="fa fa-check"></i> ส่งวันที่ : <?= $row1['rs_conf_date'] ?></span>
                                <!-- <button class="btn btn-success" style="margin-left : 10px"> คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ" </button> -->
                            <?php } else if ($row1['rs_conf'] == 0 && $row1['rs_conf'] != NULL) {
                            ?>
                                <div class="alert alert-success" role="alert" style="margin-left : 10px">
                                    คุณได้ทำการยืนยันการยกเลิกแล้ว "โปรดรอการตอบกลับ"
                                </div>
                                <span class="check_icon"><i class="fa fa-check"></i> ส่งวันที่ : <?= $row1['rs_conf_date'] ?></span>
                            <?php
                            }  ?>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Sweet Alert Show Start -->
    <?php
    if (isset($_SESSION['add_data_alert'])) {
        if ($_SESSION['add_data_alert'] == 0) {
    ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'ทำการยืนยันการส่งซ่อมเสร็จสิ้น',
                    html: 'ระบบได้ทำการส่งข้อมูลการยืนยันไปที่พนักงานแล้ว<br>กด Accept เพื่อออก',
                    confirmButtonText: 'Accept'
                });
            </script>
        <?php
            unset($_SESSION['add_data_alert']);
        } else if ($_SESSION['add_data_alert'] == 1) {
        ?>
            <script>
                Swal.fire({
                    title: 'การยืนยันการส่งซ่อมไม่เสร็จสิ้น',
                    text: 'กด Accept เพื่อออก',
                    icon: 'error',
                    confirmButtonText: 'Accept'
                });
            </script>

        <?php
            unset($_SESSION['add_data_alert']);
        } else if ($_SESSION['add_data_alert'] == 2) {
        ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'ดำเนินการส่งคำร้องเสร็จสิ้น',
                    html: 'ระบบได้ทำการส่งคำร้องไปที่พนักงานแล้ว<br>กด Accept เพื่อออก',
                    confirmButtonText: 'Accept'
                });
            </script>

    <?php
            unset($_SESSION['add_data_alert']);
        }
    }
    ?>
    <!-- Sweet Alert Show End -->
    <br><br>
    <!-- Place this in the <head> section of your HTML document -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Place this before the closing </body> tag -->


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
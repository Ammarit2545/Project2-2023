<?php
session_start();
include('database/condb.php');
$id = $_SESSION['id'];
$status_id = 0;

$get_id = $_GET['id'];
$get_r_id = $id_get_r = $_GET['id'];
$sql1 = "SELECT m_fname,m_lname FROM member WHERE m_id = '$id'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);
if ($id == NULL) {
    header('Location: home.php');
}

// อัพเดตสถานะว่าดูหมายเลขนี้แล้ว
$sql_update = "UPDATE repair_status SET rs_watch = 1 WHERE get_r_id = '$get_r_id'";
$result = mysqli_query($conn, $sql_update);

$count_carry_out = 0;
$check_order = 0;
$part_check = 0;

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
    <!-- <link rel="stylesheet" href="css/detail_status.css"> -->
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Status - ANE</title>

    <!-- Example CDNs, use appropriate versions and sources -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <!-- Place this in the <head> section of your HTML document -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Place this in the <head> section of your HTML document -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Place this before the closing </body> tag -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        <?php include('css/all_page.css'); ?>
    </style>
    <style>
        body {
            font-family: sans-serif;
        }



        .file-upload {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        #button-status {
            margin-left: 2%;
            color: black;
        }

        #button-status:hover {
            color: green;
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


        #bounce-item {
            /* box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); */
            /* Add a gray shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Add transition for transform and box-shadow */
        }

        #bounce-item:hover #totalprice {
            transform: scale(1.02);
            /* Increase size on hover */
            /* box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); */
            /* Increase shadow size and intensity on hover */
            /* border: 2px solid gray; */

        }

        #bounce-item:hover {
            transform: scale(1.02);
            /* Increase size on hover */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            /* Increase shadow size and intensity on hover */
            /* border: 2px solid gray; */

        }

        .inline {
            display: inline;
        }

        #tooltip {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 8px;
            border-radius: 4px;
            font-size: 14px;
            white-space: nowrap;
            transition: opacity 0.3s, transform 0.3s;
        }

        #bounce-item:hover #tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-10px);
            animation: tooltipFadeIn 0.3s, tooltipBounce 0.6s;
        }



        #totalprice:hover #tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-10px);
            animation: tooltipFadeIn 0.3s, tooltipBounce 0.6s;
        }

        #process-status:hover #tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-10px);
            animation: tooltipFadeIn 0.3s, tooltipBounce 0.6s;
        }

        @keyframes tooltipFadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes tooltipBounce {

            0%,
            100% {
                transform: translateX(-50%) translateY(-10px);
            }

            50% {
                transform: translateX(-50%) translateY(0);
            }
        }

        .card {
            z-index: 0;
            background-color: #ECEFF1;
            padding-bottom: 20px;
            border-radius: 10px;
        }

        .top {
            padding-top: 40px;
            padding-left: 13% !important;
            padding-right: 13% !important;
        }

        /*Icon progressbar*/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: #455A64;
            padding-left: 0px;
            margin-top: 30px;
        }

        #progressbar li {
            list-style-type: none;
            font-size: 13px;
            width: 12.5%;
            float: left;
            position: relative;
            font-weight: 400;
        }

        #progressbar .step0:before {
            font-family: FontAwesome;
            content: "\f10c";
            color: #fff;
        }

        #progressbar li:before {
            width: 40px;
            height: 40px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            background: #C5CAE9;
            border-radius: 50%;
            margin: auto;
            padding: 0px;
            position: relative;
            z-index: 1;
        }

        /*ProgressBar connectors*/
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 12px;
            background: #C5CAE9;
            position: absolute;
            left: -50%;
            top: 16px;
            z-index: -1;
        }

        #progressbar li:first-child:after {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            position: absolute;
            left: 0;
        }

        #progressbar li:last-child:after {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        /*Color number of the step and the connector before it*/
        #progressbar li.active:before,
        #progressbar li.active:after {
            background: green;
        }

        #progressbar li.active:before {
            font-family: FontAwesome;
            content: "\f00c";
        }

        .icon {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }

        .icon-content {
            padding-bottom: 20px;
        }

        #font-status {
            font-style: oblique;
            font-weight: 100;
        }

        #progressbar li:first-child:after {
            content: none;
        }


        @media screen and (max-width: 992px) {
            .icon-content {
                width: 50%;
            }
        }


        .process-line {
            display: block;
        }

        .only-now-process {
            display: none;
        }

        @media screen and (max-width: 767px) {
            .process-line {
                display: none;
            }

            .only-now-process {
                display: block;
            }
        }
    </style>
</head>

<body>
    <?php
    if ($row1 > 0) {
        include('bar/topbar_user.php');
    }
    ?>
    <!-- Modal -->
    <div class="modal fade " id="staticBackdropss" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>รายการซ่อมในหมายเลขแจ้งซ่อม <?= $id_get_r  ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #E7E7E7;">
                    <br>
                    <div class="container">

                        <?php
                        $count_get_no = 0;
                        $repair_count = 0;
                        $sql_get_c2 = "SELECT *
                                            FROM get_detail
                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                            WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.del_flg = 0 AND (get_d_conf != 1 OR get_d_conf IS NULL);
                                            ";
                        $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 0 AND get_d_conf = 0";
                        $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                        $result_get = mysqli_query($conn, $sql_get_c2);
                        $row_get_count_track = mysqli_fetch_array($result_get_count_track);

                        $sql_get_c = "SELECT * FROM get_detail
                                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 0";
                        $result_get_c = mysqli_query($conn, $sql_get_c);
                        while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                            $repair_count++;
                        }
                        if ($repair_count > 0) {
                        ?>
                            <h2>มีรายการซ่อมทั้งหมด <span class="badge bg-primary"><?= $repair_count ?></span> รายการ</h2>
                            <hr>
                            <br>
                        <?php
                        }

                        while ($row_get = mysqli_fetch_array($result_get)) {
                            $count_get_no++;
                        ?>
                            <div class="row alert alert-light shadow">
                                <h1 style="text-align:start; color:blue" id="body_text">
                                    <span>รายการที่ <?= $count_get_no ?></span> :
                                    <span class="f-black-5">
                                        <?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?>

                                    </span>
                                </h1>
                                <hr>
                                <div style=" color:#2c2f34" class="my-4">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md alert alert-light shadow ml-1 bg-gray-1">
                                                <h5 class="f-black-5">ข้อมูลอุปกรณ์</h5>
                                                <hr>
                                                <p class=" f-gray-5">
                                                    <?php if ($row_get['com_id'] != NULL) { ?><br>
                                                        <span class="badge bg-success">
                                                            ประกัน :
                                                            <span>
                                                                <?php
                                                                $com_id = $row_get['com_id'];
                                                                $sql_com = "SELECT com_name FROM company WHERE com_id ='$com_id' AND del_flg = 0";
                                                                $result_com = mysqli_query($conn, $sql_com);
                                                                $row_com = mysqli_fetch_array($result_com);
                                                                echo $row_com['com_name'];
                                                                $row_get['r_id']
                                                                ?>
                                                            </span>
                                                        </span>
                                                    <?php } ?>
                                                    <?php if ($row_get['r_guarantee'] != NULL) { ?><br>ระยะประกัน :
                                                        <span class="f-black-5"><?= $row_get['r_guarantee'] ?> ปี</span><?php } ?>
                                                    <?php if ($row_get['r_id'] != NULL) { ?><br>รหัสอุปกรณ์ในระบบ :
                                                        <span class="f-black-5"><?= $row_get['r_id'] ?></span>
                                                        <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item">
                                                            <i class="fa fa-question-circle"></i>
                                                            <span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($row_get['r_brand'] != NULL) { ?><br>ยี่ห้อ/แบรนด์ :
                                                        <span class="f-black-5"><?= $row_get['r_brand'] ?></span><?php } ?>
                                                    <?php if ($row_get['r_model'] != NULL) { ?><br>รุ่น :
                                                        <span class="f-black-5"><?= $row_get['r_model'] ?></span><?php } ?>
                                                    <?php if ($row_get['r_number_model'] != NULL) { ?><br>หมายเลขรุ่น :
                                                        <span class="f-black-5"><?= $row_get['r_number_model'] ?></span><?php } ?>
                                                    <?php if ($row_get['r_serial_number'] != NULL) { ?><br>หมายเลขประจำเครื่อง/Serial Number :
                                                        <span class="f-black-5"><?= $row_get['r_serial_number'] ?></span><?php } ?>
                                                    <?php if ($row_get['get_t_id'] != NULL) { ?><br>หมายเลขพัสดุ :
                                                        <span class="f-black-5"><?= $row_get['t_parcel'] ?></span>
                                                    <?php } ?>
                                                </p>
                                                <br>
                                                <h5 class="mb-3" style="color:black">รายละเอียดอาการ</h5>
                                                <hr>
                                                <p><?= $row_get['get_d_detail'] ?></p>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <?php
                                            $check_have_pic_c = 0;
                                            $get_d_id = $row_get['get_d_id'];
                                            $sql_pic = "SELECT * FROM repair_pic
                                                       LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                                       WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.del_flg = 0 AND repair_pic.del_flg = 0;";
                                            $result_pic = mysqli_query($conn, $sql_pic);
                                            if (mysqli_num_rows($result_pic)) {
                                                while ($row_pic = mysqli_fetch_array($result_pic)) {
                                                    if ($row_pic[0] != NULL) {
                                                        $rp_pic = $row_pic['rp_pic'];
                                                        $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                        if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp', 'svg', 'jiff'])) {
                                                            $check_have_pic_c++;
                                                        } elseif (in_array($file_extension, ['mp4', 'ogg'])) {
                                                            $check_have_pic_c++;
                                                        }
                                                    }
                                                }
                                            }

                                            $check_have_pic = 0;
                                            $sql_pic = "SELECT * FROM repair_pic
                                                                            LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                                                            WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.get_d_id = '$get_d_id' AND get_detail.del_flg = 0 AND repair_pic.del_flg = 0;";
                                            $result_pic = mysqli_query($conn, $sql_pic);
                                            if (mysqli_num_rows($result_pic) &&  $check_have_pic_c > 0) {
                                                $check_have_pic++;
                                            ?>
                                                <div class="col-md-5 alert alert-light shadow bg-gray-1">
                                                    <h5 style="color:black" class="mb-3">รูปภาพ</h5>
                                                    <hr>
                                                    <br>
                                                    <?php
                                                    while ($row_pic = mysqli_fetch_array($result_pic)) {
                                                        if ($row_pic[0] != NULL) {
                                                    ?>
                                                            <?php
                                                            $rp_pic = $row_pic['rp_pic'];
                                                            $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                            ?>
                                                            <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                                <a href="#" id="bounce-item"><img src="<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                            <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                                <a href="#">
                                                                    <video width="100px" autoplay muted onclick="openModalVideo(this)" src="<?= $row_pic['rp_pic'] ?>">
                                                                        <source src="<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                                        <source src="<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </a>
                                                            <?php endif; ?>
                                                    <?php
                                                        }
                                                    }
                                                }
                                                if ($check_have_pic > 0) { ?>
                                                </div>
                                            <?php  } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        $count_get_no = 0;
                        $sql_get_c3 = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 0 AND get_d_conf = 1";
                        $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 0 AND get_d_conf = 1";
                        $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                        $result_get_c3 = mysqli_query($conn, $sql_get_c3);
                        $row_get_count_track = mysqli_fetch_array($result_get_count_track);
                        if (mysqli_num_rows($result_get_c3)) {

                        ?><h1><span class="badge bg-warning">รายการที่ไม่สามารถซ่อมได้ (อยู่ในช่วงยื่นข้อเสนอ)</span></h1><?php
                                                                                                                        }

                                                                                                                        while ($row_get = mysqli_fetch_array($result_get)) {
                                                                                                                            $count_get_no++;
                                                                                                                            ?>
                            <div class="row alert alert-warning shadow">
                                <h1 style="text-align:start; color:blue" id="body_text">
                                    <span>รายการที่ <?= $count_get_no ?></span> :
                                    <span class="f-black-5">
                                        <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" class="un-scroll f-black-5" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item"><?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?><span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                        </a>
                                    </span>
                                </h1>
                                <hr>
                                <div style=" color:#2c2f34" class="my-4">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md alert alert-light shadow ml-1 bg-gray-1">
                                                <h5 class="f-black-5">ข้อมูลอุปกรณ์</h5>
                                                <hr>
                                                <p class=" f-gray-5">
                                                    <?php if ($row_get['com_id'] != NULL) { ?><br>
                                                        <span class="badge bg-success">
                                                            ประกัน :
                                                            <span>
                                                                <?php
                                                                                                                                $com_id = $row_get['com_id'];
                                                                                                                                $sql_com = "SELECT com_name FROM company WHERE com_id ='$com_id' AND del_flg = 0";
                                                                                                                                $result_com = mysqli_query($conn, $sql_com);
                                                                                                                                $row_com = mysqli_fetch_array($result_com);
                                                                                                                                echo $row_com['com_name'];
                                                                                                                                $row_get['r_id']
                                                                ?>
                                                            </span>
                                                        </span>
                                                    <?php } ?>
                                                    <?php if ($row_get['r_guarantee'] != NULL) { ?><br>ระยะประกัน :
                                                        <span class="f-black-5"><?= $row_get['r_guarantee'] ?> ปี</span><?php } ?>
                                                    <?php if ($row_get['r_id'] != NULL) { ?><br>รหัสอุปกรณ์ในระบบ :
                                                        <span class="f-black-5"><?= $row_get['r_id'] ?></span>
                                                        <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item">
                                                            <i class="fa fa-question-circle"></i>
                                                            <span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($row_get['r_brand'] != NULL) { ?><br>ยี่ห้อ/แบรนด์ :
                                                        <span class="f-black-5"><?= $row_get['r_brand'] ?></span><?php } ?>
                                                    <?php if ($row_get['r_model'] != NULL) { ?><br>รุ่น :
                                                        <span class="f-black-5"><?= $row_get['r_model'] ?></span><?php } ?>
                                                    <?php if ($row_get['r_number_model'] != NULL) { ?><br>หมายเลขรุ่น :
                                                        <span class="f-black-5"><?= $row_get['r_number_model'] ?></span><?php } ?>
                                                    <?php if ($row_get['r_serial_number'] != NULL) { ?><br>หมายเลขประจำเครื่อง/Serial Number :
                                                        <span class="f-black-5"><?= $row_get['r_serial_number'] ?></span><?php } ?>
                                                    <?php if ($row_get['get_t_id'] != NULL) { ?><br>หมายเลขพัสดุ :
                                                        <span class="f-black-5"><?= $row_get['t_parcel'] ?></span>
                                                    <?php } ?>
                                                </p>
                                                <br>
                                                <h5 class="mb-3" style="color:black">รายละเอียดอาการ</h5>
                                                <hr>
                                                <p><?= $row_get['get_d_detail'] ?></p>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <?php
                                                                                                                            $check_have_pic = 0;
                                                                                                                            $get_d_id = $row_get['get_d_id'];
                                                                                                                            $sql_pic = "SELECT * FROM repair_pic
                                        LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                        WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.get_d_id = '$get_d_id' AND get_detail.del_flg = 0;";
                                                                                                                            $result_pic = mysqli_query($conn, $sql_pic);
                                                                                                                            if (mysqli_num_rows($result_pic)) {
                                                                                                                                $check_have_pic++;
                                            ?>
                                                <div class="col-md-5 alert alert-light shadow bg-gray-1">
                                                    <h5 style="color:black" class="mb-3">รูปภาพ</h5>
                                                    <hr>
                                                    <br>
                                                    <?php }
                                                                                                                            while ($row_pic = mysqli_fetch_array($result_pic)) {
                                                                                                                                if ($row_pic[0] != NULL) {
                                                    ?>
                                                        <?php
                                                                                                                                    $rp_pic = $row_pic['rp_pic'];
                                                                                                                                    $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                        ?>
                                                        <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                            <a href="#" id="bounce-item"><img src="<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                        <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                            <a href="#">
                                                                <video width="100px" autoplay muted onclick="openModalVideo(this)" src="<?= $row_pic['rp_pic'] ?>">
                                                                    <source src="<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                                    <source src="<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php
                                                                                                                                }
                                                                                                                            }
                                                                                                                            if ($check_have_pic > 0) { ?>
                                                </div>
                                            <?php  } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        $count_get_no = 0;


                        $sql_get = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 1";
                        $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 1";
                        $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                        $result_get = mysqli_query($conn, $sql_get);
                        $row_get_count_track = mysqli_fetch_array($result_get_count_track);
                        if (mysqli_num_rows($result_get)) {

                        ?><h1><span class="badge bg-danger">รายการที่ไม่สามารถซ่อมได้</span></h1><?php
                                                                                                }

                                                                                                while ($row_get = mysqli_fetch_array($result_get)) {
                                                                                                    $count_get_no++;
                                                                                                    ?>
                            <div class="row alert alert-danger shadow">
                                <h1 style="text-align:start; color:blue" id="body_text">
                                    <span>รายการที่ <?= $count_get_no ?></span> :
                                    <span class="f-black-5">
                                        <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" class="un-scroll f-black-5" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item"><?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?><span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                        </a>
                                    </span>
                                </h1>
                                <hr>
                                <div style=" color:#2c2f34" class="my-4">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md alert alert-light shadow ml-1 bg-gray-1">
                                                <h5 class="f-black-5">ข้อมูลอุปกรณ์</h5>
                                                <hr>
                                                <p class=" f-gray-5">
                                                    <?php if ($row_get['com_id'] != NULL) { ?><br>
                                                        <span class="badge bg-success">
                                                            ประกัน :
                                                            <span>
                                                                <?php
                                                                                                        $com_id = $row_get['com_id'];
                                                                                                        $sql_com = "SELECT com_name FROM company WHERE com_id ='$com_id' AND del_flg = 0";
                                                                                                        $result_com = mysqli_query($conn, $sql_com);
                                                                                                        $row_com = mysqli_fetch_array($result_com);
                                                                                                        echo $row_com['com_name'];
                                                                                                        $row_get['r_id']
                                                                ?>
                                                            </span>
                                                        </span>
                                                    <?php } ?>
                                                    <?php if ($row_get['r_guarantee'] != NULL) { ?><br>ระยะประกัน :
                                                        <span class="f-black-5"><?= $row_get['r_guarantee'] ?> ปี</span><?php } ?>
                                                    <?php if ($row_get['r_id'] != NULL) { ?><br>รหัสอุปกรณ์ในระบบ :
                                                        <span class="f-black-5"><?= $row_get['r_id'] ?></span>
                                                        <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item">
                                                            <i class="fa fa-question-circle"></i>
                                                            <span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($row_get['r_brand'] != NULL) { ?><br>ยี่ห้อ/แบรนด์ :
                                                        <span class="f-black-5"><?= $row_get['r_brand'] ?></span><?php } ?>
                                                    <?php if ($row_get['r_model'] != NULL) { ?><br>รุ่น :
                                                        <span class="f-black-5"><?= $row_get['r_model'] ?></span><?php } ?>
                                                    <?php if ($row_get['r_number_model'] != NULL) { ?><br>หมายเลขรุ่น :
                                                        <span class="f-black-5"><?= $row_get['r_number_model'] ?></span><?php } ?>
                                                    <?php if ($row_get['r_serial_number'] != NULL) { ?><br>หมายเลขประจำเครื่อง/Serial Number :
                                                        <span class="f-black-5"><?= $row_get['r_serial_number'] ?></span><?php } ?>
                                                    <?php if ($row_get['get_t_id'] != NULL) { ?><br>หมายเลขพัสดุ :
                                                        <span class="f-black-5"><?= $row_get['t_parcel'] ?></span>
                                                    <?php } ?>
                                                </p>
                                                <br>
                                                <h5 class="mb-3" style="color:black">รายละเอียดอาการ</h5>
                                                <hr>
                                                <p><?= $row_get['get_d_detail'] ?></p>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <?php
                                                                                                    $check_have_pic = 0;
                                                                                                    $get_d_id = $row_get['get_d_id'];
                                                                                                    $sql_pic = "SELECT * FROM repair_pic
                                        LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                        WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.get_d_id = '$get_d_id' AND get_detail.del_flg = 0;";
                                                                                                    $result_pic = mysqli_query($conn, $sql_pic);
                                                                                                    if (mysqli_num_rows($result_pic)) {
                                                                                                        $check_have_pic++;
                                            ?>
                                                <div class="col-md-5 alert alert-light shadow bg-gray-1">
                                                    <h5 style="color:black" class="mb-3">รูปภาพ</h5>
                                                    <hr>
                                                    <br>
                                                    <?php }
                                                                                                    while ($row_pic = mysqli_fetch_array($result_pic)) {
                                                                                                        if ($row_pic[0] != NULL) {
                                                    ?>
                                                        <?php
                                                                                                            $rp_pic = $row_pic['rp_pic'];
                                                                                                            $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                        ?>
                                                        <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                            <a href="#" id="bounce-item"><img src="<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                        <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                            <a href="#">
                                                                <video width="100px" autoplay muted onclick="openModalVideo(this)" src="<?= $row_pic['rp_pic'] ?>">
                                                                    <source src="<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                                    <source src="<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php
                                                                                                        }
                                                                                                    }
                                                                                                    if ($check_have_pic > 0) { ?>
                                                </div>
                                            <?php  } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom1" aria-labelledby="offcanvasBottomLabel1">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel1">รายการซ่อมในหมายเลขแจ้งซ่อม <?= $get_r_id  ?></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small">
            <br>
            <div class="container">
                <?php
                $count_get_no = 0;
                $repair_count = 0;
                $sql_get_c2 = "SELECT *
                                            FROM get_detail
                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                            WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.del_flg = 0 AND (get_d_conf != 1 OR get_d_conf IS NULL);
                                            ";
                $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 0 AND get_d_conf = 0";
                $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                $result_get = mysqli_query($conn, $sql_get_c2);
                $row_get_count_track = mysqli_fetch_array($result_get_count_track);

                $sql_get_c = "SELECT * FROM get_detail
                                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 0";
                $result_get_c = mysqli_query($conn, $sql_get_c);
                while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                    $repair_count++;
                }
                if ($repair_count > 0) {
                ?>
                    <h2>มีรายการซ่อมทั้งหมด <span class="badge bg-primary"><?= $repair_count ?></span> รายการ</h2>
                    <hr>
                    <br>
                <?php
                }

                while ($row_get = mysqli_fetch_array($result_get)) {
                    $count_get_no++;
                ?>
                    <div class="row alert alert-light shadow">
                        <h1 style="text-align:start; color:blue" id="body_text">
                            <span>รายการที่ <?= $count_get_no ?></span> :
                            <span class="f-black-5">
                                <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" class="un-scroll f-black-5" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item"><?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?><span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                </a>
                            </span>
                        </h1>
                        <hr>
                        <div style=" color:#2c2f34" class="my-4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md alert alert-light shadow ml-1 bg-gray-1">
                                        <h5 class="f-black-5">ข้อมูลอุปกรณ์</h5>
                                        <hr>
                                        <p class=" f-gray-5">
                                            <?php if ($row_get['com_id'] != NULL) { ?><br>
                                                <span class="badge bg-success">
                                                    ประกัน :
                                                    <span>
                                                        <?php
                                                        $com_id = $row_get['com_id'];
                                                        $sql_com = "SELECT com_name FROM company WHERE com_id ='$com_id' AND del_flg = 0";
                                                        $result_com = mysqli_query($conn, $sql_com);
                                                        $row_com = mysqli_fetch_array($result_com);
                                                        echo $row_com['com_name'];
                                                        $row_get['r_id']
                                                        ?>
                                                    </span>
                                                </span>
                                            <?php } ?>
                                            <?php if ($row_get['r_guarantee'] != NULL) { ?><br>ระยะประกัน :
                                                <span class="f-black-5"><?= $row_get['r_guarantee'] ?> ปี</span><?php } ?>
                                            <?php if ($row_get['r_id'] != NULL) { ?><br>รหัสอุปกรณ์ในระบบ :
                                                <span class="f-black-5"><?= $row_get['r_id'] ?></span>
                                                <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item">
                                                    <i class="fa fa-question-circle"></i>
                                                    <span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                </a>
                                            <?php } ?>
                                            <?php if ($row_get['r_brand'] != NULL) { ?><br>ยี่ห้อ/แบรนด์ :
                                                <span class="f-black-5"><?= $row_get['r_brand'] ?></span><?php } ?>
                                            <?php if ($row_get['r_model'] != NULL) { ?><br>รุ่น :
                                                <span class="f-black-5"><?= $row_get['r_model'] ?></span><?php } ?>
                                            <?php if ($row_get['r_number_model'] != NULL) { ?><br>หมายเลขรุ่น :
                                                <span class="f-black-5"><?= $row_get['r_number_model'] ?></span><?php } ?>
                                            <?php if ($row_get['r_serial_number'] != NULL) { ?><br>หมายเลขประจำเครื่อง/Serial Number :
                                                <span class="f-black-5"><?= $row_get['r_serial_number'] ?></span><?php } ?>
                                            <?php if ($row_get['get_t_id'] != NULL) { ?><br>หมายเลขพัสดุ :
                                                <span class="f-black-5"><?= $row_get['t_parcel'] ?></span>
                                            <?php } ?>
                                        </p>
                                        <br>
                                        <h5 class="mb-3" style="color:black">รายละเอียดอาการ</h5>
                                        <hr>
                                        <p><?= $row_get['get_d_detail'] ?></p>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <?php
                                    $check_have_pic = 0;
                                    $get_d_id = $row_get['get_d_id'];
                                    $sql_pic = "SELECT * FROM repair_pic
                                                                            LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                                                            WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.get_d_id = '$get_d_id' AND get_detail.del_flg = 0;";
                                    $result_pic = mysqli_query($conn, $sql_pic);
                                    if (mysqli_num_rows($result_pic)) {
                                        $check_have_pic++;
                                    ?>
                                        <div class="col-md-5 alert alert-light shadow bg-gray-1">
                                            <h5 style="color:black" class="mb-3">รูปภาพ</h5>
                                            <hr>
                                            <br>
                                            <?php }
                                        while ($row_pic = mysqli_fetch_array($result_pic)) {
                                            if ($row_pic[0] != NULL) {
                                            ?>
                                                <?php
                                                $rp_pic = $row_pic['rp_pic'];
                                                $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                ?>
                                                <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                    <a href="#" id="bounce-item"><img src="<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                    <a href="#">
                                                        <video width="100px" autoplay muted onclick="openModalVideo(this)" src="<?= $row_pic['rp_pic'] ?>">
                                                            <source src="<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                            <source src="<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </a>
                                                <?php endif; ?>
                                            <?php
                                            }
                                        }
                                        if ($check_have_pic > 0) { ?>
                                        </div>
                                    <?php  } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php
                $count_get_no = 0;
                $sql_get_c3 = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 0 AND get_d_conf = 1";
                $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 0 AND get_d_conf = 1";
                $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                $result_get_c3 = mysqli_query($conn, $sql_get_c3);
                $row_get_count_track = mysqli_fetch_array($result_get_count_track);
                if (mysqli_num_rows($result_get_c3)) {

                ?><h1><span class="badge bg-warning">รายการที่ไม่สามารถซ่อมได้ (อยู่ในช่วงยื่นข้อเสนอ)</span></h1><?php
                                                                                                                }

                                                                                                                while ($row_get = mysqli_fetch_array($result_get)) {
                                                                                                                    $count_get_no++;
                                                                                                                    ?>
                    <div class="row alert alert-warning shadow">
                        <h1 style="text-align:start; color:blue" id="body_text">
                            <span>รายการที่ <?= $count_get_no ?></span> :
                            <span class="f-black-5">
                                <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" class="un-scroll f-black-5" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item"><?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?><span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                </a>
                            </span>
                        </h1>
                        <hr>
                        <div style=" color:#2c2f34" class="my-4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md alert alert-light shadow ml-1 bg-gray-1">
                                        <h5 class="f-black-5">ข้อมูลอุปกรณ์</h5>
                                        <hr>
                                        <p class=" f-gray-5">
                                            <?php if ($row_get['com_id'] != NULL) { ?><br>
                                                <span class="badge bg-success">
                                                    ประกัน :
                                                    <span>
                                                        <?php
                                                                                                                        $com_id = $row_get['com_id'];
                                                                                                                        $sql_com = "SELECT com_name FROM company WHERE com_id ='$com_id' AND del_flg = 0";
                                                                                                                        $result_com = mysqli_query($conn, $sql_com);
                                                                                                                        $row_com = mysqli_fetch_array($result_com);
                                                                                                                        echo $row_com['com_name'];
                                                                                                                        $row_get['r_id']
                                                        ?>
                                                    </span>
                                                </span>
                                            <?php } ?>
                                            <?php if ($row_get['r_guarantee'] != NULL) { ?><br>ระยะประกัน :
                                                <span class="f-black-5"><?= $row_get['r_guarantee'] ?> ปี</span><?php } ?>
                                            <?php if ($row_get['r_id'] != NULL) { ?><br>รหัสอุปกรณ์ในระบบ :
                                                <span class="f-black-5"><?= $row_get['r_id'] ?></span>
                                                <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item">
                                                    <i class="fa fa-question-circle"></i>
                                                    <span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                </a>
                                            <?php } ?>
                                            <?php if ($row_get['r_brand'] != NULL) { ?><br>ยี่ห้อ/แบรนด์ :
                                                <span class="f-black-5"><?= $row_get['r_brand'] ?></span><?php } ?>
                                            <?php if ($row_get['r_model'] != NULL) { ?><br>รุ่น :
                                                <span class="f-black-5"><?= $row_get['r_model'] ?></span><?php } ?>
                                            <?php if ($row_get['r_number_model'] != NULL) { ?><br>หมายเลขรุ่น :
                                                <span class="f-black-5"><?= $row_get['r_number_model'] ?></span><?php } ?>
                                            <?php if ($row_get['r_serial_number'] != NULL) { ?><br>หมายเลขประจำเครื่อง/Serial Number :
                                                <span class="f-black-5"><?= $row_get['r_serial_number'] ?></span><?php } ?>
                                            <?php if ($row_get['get_t_id'] != NULL) { ?><br>หมายเลขพัสดุ :
                                                <span class="f-black-5"><?= $row_get['t_parcel'] ?></span>
                                            <?php } ?>
                                        </p>
                                        <br>
                                        <h5 class="mb-3" style="color:black">รายละเอียดอาการ</h5>
                                        <hr>
                                        <p><?= $row_get['get_d_detail'] ?></p>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <?php
                                                                                                                    $check_have_pic = 0;
                                                                                                                    $get_d_id = $row_get['get_d_id'];
                                                                                                                    $sql_pic = "SELECT * FROM repair_pic
                                        LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                        WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.get_d_id = '$get_d_id' AND get_detail.del_flg = 0;";
                                                                                                                    $result_pic = mysqli_query($conn, $sql_pic);
                                                                                                                    if (mysqli_num_rows($result_pic)) {
                                                                                                                        $check_have_pic++;
                                    ?>
                                        <div class="col-md-5 alert alert-light shadow bg-gray-1">
                                            <h5 style="color:black" class="mb-3">รูปภาพ</h5>
                                            <hr>
                                            <br>
                                            <?php }
                                                                                                                    while ($row_pic = mysqli_fetch_array($result_pic)) {
                                                                                                                        if ($row_pic[0] != NULL) {
                                            ?>
                                                <?php
                                                                                                                            $rp_pic = $row_pic['rp_pic'];
                                                                                                                            $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                ?>
                                                <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                    <a href="#" id="bounce-item"><img src="<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                    <a href="#">
                                                        <video width="100px" autoplay muted onclick="openModalVideo(this)" src="<?= $row_pic['rp_pic'] ?>">
                                                            <source src="<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                            <source src="<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </a>
                                                <?php endif; ?>
                                            <?php
                                                                                                                        }
                                                                                                                    }
                                                                                                                    if ($check_have_pic > 0) { ?>
                                        </div>
                                    <?php  } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php
                $count_get_no = 0;


                $sql_get = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 1";
                $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 1";
                $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                $result_get = mysqli_query($conn, $sql_get);
                $row_get_count_track = mysqli_fetch_array($result_get_count_track);
                if (mysqli_num_rows($result_get)) {

                ?><h1><span class="badge bg-danger">รายการที่ไม่สามารถซ่อมได้</span></h1><?php
                                                                                        }

                                                                                        while ($row_get = mysqli_fetch_array($result_get)) {
                                                                                            $count_get_no++;
                                                                                            ?>
                    <div class="row alert alert-danger shadow">
                        <h1 style="text-align:start; color:blue" id="body_text">
                            <span>รายการที่ <?= $count_get_no ?></span> :
                            <span class="f-black-5">
                                <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" class="un-scroll f-black-5" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item"><?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?><span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                </a>
                            </span>
                        </h1>
                        <hr>
                        <div style=" color:#2c2f34" class="my-4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md alert alert-light shadow ml-1 bg-gray-1">
                                        <h5 class="f-black-5">ข้อมูลอุปกรณ์</h5>
                                        <hr>
                                        <p class=" f-gray-5">
                                            <?php if ($row_get['com_id'] != NULL) { ?><br>
                                                <span class="badge bg-success">
                                                    ประกัน :
                                                    <span>
                                                        <?php
                                                                                                $com_id = $row_get['com_id'];
                                                                                                $sql_com = "SELECT com_name FROM company WHERE com_id ='$com_id' AND del_flg = 0";
                                                                                                $result_com = mysqli_query($conn, $sql_com);
                                                                                                $row_com = mysqli_fetch_array($result_com);
                                                                                                echo $row_com['com_name'];
                                                                                                $row_get['r_id']
                                                        ?>
                                                    </span>
                                                </span>
                                            <?php } ?>
                                            <?php if ($row_get['r_guarantee'] != NULL) { ?><br>ระยะประกัน :
                                                <span class="f-black-5"><?= $row_get['r_guarantee'] ?> ปี</span><?php } ?>
                                            <?php if ($row_get['r_id'] != NULL) { ?><br>รหัสอุปกรณ์ในระบบ :
                                                <span class="f-black-5"><?= $row_get['r_id'] ?></span>
                                                <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item">
                                                    <i class="fa fa-question-circle"></i>
                                                    <span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                </a>
                                            <?php } ?>
                                            <?php if ($row_get['r_brand'] != NULL) { ?><br>ยี่ห้อ/แบรนด์ :
                                                <span class="f-black-5"><?= $row_get['r_brand'] ?></span><?php } ?>
                                            <?php if ($row_get['r_model'] != NULL) { ?><br>รุ่น :
                                                <span class="f-black-5"><?= $row_get['r_model'] ?></span><?php } ?>
                                            <?php if ($row_get['r_number_model'] != NULL) { ?><br>หมายเลขรุ่น :
                                                <span class="f-black-5"><?= $row_get['r_number_model'] ?></span><?php } ?>
                                            <?php if ($row_get['r_serial_number'] != NULL) { ?><br>หมายเลขประจำเครื่อง/Serial Number :
                                                <span class="f-black-5"><?= $row_get['r_serial_number'] ?></span><?php } ?>
                                            <?php if ($row_get['get_t_id'] != NULL) { ?><br>หมายเลขพัสดุ :
                                                <span class="f-black-5"><?= $row_get['t_parcel'] ?></span>
                                            <?php } ?>
                                        </p>
                                        <br>
                                        <h5 class="mb-3" style="color:black">รายละเอียดอาการ</h5>
                                        <hr>
                                        <p><?= $row_get['get_d_detail'] ?></p>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <?php
                                                                                            $check_have_pic = 0;
                                                                                            $get_d_id = $row_get['get_d_id'];
                                                                                            $sql_pic = "SELECT * FROM repair_pic
                                        LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                        WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.get_d_id = '$get_d_id' AND get_detail.del_flg = 0;";
                                                                                            $result_pic = mysqli_query($conn, $sql_pic);
                                                                                            if (mysqli_num_rows($result_pic)) {
                                                                                                $check_have_pic++;
                                    ?>
                                        <div class="col-md-5 alert alert-light shadow bg-gray-1">
                                            <h5 style="color:black" class="mb-3">รูปภาพ</h5>
                                            <hr>
                                            <br>
                                            <?php }
                                                                                            while ($row_pic = mysqli_fetch_array($result_pic)) {
                                                                                                if ($row_pic[0] != NULL) {
                                            ?>
                                                <?php
                                                                                                    $rp_pic = $row_pic['rp_pic'];
                                                                                                    $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                ?>
                                                <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                    <a href="#" id="bounce-item"><img src="<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                    <a href="#">
                                                        <video width="100px" autoplay muted onclick="openModalVideo(this)" src="<?= $row_pic['rp_pic'] ?>">
                                                            <source src="<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                            <source src="<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </a>
                                                <?php endif; ?>
                                            <?php
                                                                                                }
                                                                                            }
                                                                                            if ($check_have_pic > 0) { ?>
                                        </div>
                                    <?php  } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php


    $id_get_r = $_GET['id'];
    // Assuming $id_get_r is your parameterized value
    $sql_status = "SELECT rs.rs_id,
            rs.status_id,
            st.status_name,
            st.status_color,
            rs.rs_conf,
            rs.rs_date_time,
            rs.rs_detail,
            rs.rs_conf_date,
            gr.get_tel,
            gr.get_add,
            gr.get_wages,
            gr.get_add_price,
            gr.get_add_price
            FROM get_repair gr
            LEFT JOIN repair_status rs ON gr.get_r_id = rs.get_r_id 
            LEFT JOIN status_type st ON rs.status_id = st.status_id 
            WHERE gr.get_r_id = ? AND rs.del_flg = '0' 
            ORDER BY rs.rs_date_time DESC 
       ";

    // Use prepared statements
    $stmt = mysqli_prepare($conn, $sql_status);

    if ($stmt) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $id_get_r);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        $result_status = mysqli_stmt_get_result($stmt);
        $row_status = mysqli_fetch_array($result_status);

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle the error
        echo "Error: " . mysqli_error($conn);
    } ?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalUnique" tabindex="-1" aria-labelledby="exampleModalLabelUnique" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <span style="color:white">
                        <h4 style="color: red">โปรดระบุเหตุผล</h4>

                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <br>
                    <form id="canf_cancel_offer" action="action/conf_cancel.php" method="POST">

                        <input type="text" name="get_r_id" value="<?= $id_get_r ?>" hidden>
                        <input type="text" name="status_id" value="<?= $row_status['status_id'] ?>" hidden>
                        <span>
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
                                <input class="form-check-input" type="checkbox" id="checkbox4" name="checkbox4" onclick="showTextarea();">
                                อื่นๆ (หรือยื่นข้อเสนอ)
                            </label><br>



                            <textarea class="form-control auto-expand mt-4" id="TextareaShow" name="detail_cancel" style="display: none;" placeholder="โปรดระบุสาเหตุ"></textarea>
                            <script>
                                function showTextarea() {
                                    var checkbox = document.getElementById("checkbox4"); // Get the checkbox element
                                    var textarea = document.getElementById("TextareaShow");

                                    if (checkbox.checked) {
                                        textarea.style.display = "block";
                                    } else {
                                        textarea.style.display = "none";
                                    }
                                }

                                document.getElementById("checkbox4").addEventListener("change", function() {
                                    var textarea = document.getElementById("TextareaShow");
                                    textarea.style.display = this.checked ? "block" : "none";
                                });


                                function uncheckOtherCheckboxes(currentCheckboxId) {
                                    // If you want to uncheck other checkboxes when this checkbox is checked
                                    var checkboxes = document.getElementsByName(currentCheckboxId);
                                    for (var i = 0; i < checkboxes.length; i++) {
                                        if (checkboxes[i].id !== currentCheckboxId) {
                                            checkboxes[i].checked = false;
                                        }
                                    }
                                }
                            </script>
                        </span>
                        <br>
                        <!-- <a class="btn btn-danger" onclick="hideDiv()">ยกเลิก</a>
                                                                                        <a class="btn btn-success" id="confirmButtoncancel">ยืนยัน</a> -->

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var id_get_r = <?php echo json_encode($id_get_r); ?>; // Pass PHP variable to JavaScript
                                var dialogShown = false; // Flag variable to track if the dialog is already displayed

                                document.getElementById('confirmButtoncancelOffer').addEventListener('click', function() {
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
                                            var form = document.getElementById('canf_cancel_offer');
                                            form.submit(); // Submit the form
                                        }

                                        dialogShown = false; // Reset the flag when the dialog is closed
                                    });
                                });
                            });
                        </script>


                        <br><br>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success" data-bs-dismiss="modal" id="confirmButtoncancelOffer">ยืนยัน</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal 1 -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Modal 1 title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Modal 1 content...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel" style="height: 60%;">
        <div class="offcanvas-header">
            <!-- <h5 id="offcanvasTopLabel">Offcanvas top</h5> -->
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvasone" aria-label="Close"></button>
        </div>
        <div class="offcanvasone-body" style="height: 1000px;">
            <br>
            <!-- Page Wrapper -->
            <div id="wrapper">
                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content">

                        <!-- Begin Page Content -->
                        <div class="container-fluid">

                            <!-- Page Heading -->
                            <br>
                            <h1 class="h3 mb-2 text-gray-800" style="display:inline-block">ข้อมูลอะไหล่ของคุณ</h1>
                            <!-- <a href="add_parts.php" style="display:inline-block; margin-left: 10px; position :relative">คุณต้องการเพิ่มอะไหล่หรือไม่?</a> -->
                            <br>
                            <br>

                            <div class="row">
                                <!-- DataTales Example -->
                                <?php
                                $sql_lastest = "SELECT * FROM `repair_status` WHERE del_flg = '0' AND get_r_id = '$id_get_r' ORDER BY rs_date_time DESC LIMIT 1";
                                $result_lastest = mysqli_query($conn, $sql_lastest);
                                $row_lastest = mysqli_fetch_array($result_lastest);
                                $status_id_last = $row_lastest['status_id'];
                                $have_17 = 0;
                                if ($row_lastest['status_id'] == 17) {
                                    $sql_lastest = "SELECT * FROM `repair_status` WHERE del_flg = '0' AND get_r_id = '$id_get_r' AND (status_id = '13' OR status_id = '17') ORDER BY rs_date_time DESC LIMIT 1";
                                    $result_lastest = mysqli_query($conn, $sql_lastest);

                                    if (mysqli_num_rows($result_lastest)) {
                                        $have_17 = 17;   // มีสถานะ 17

                                        $sql_lastest1 = "SELECT rs_id FROM `repair_status` WHERE del_flg = '0' AND get_r_id = '$id_get_r' AND status_id = '13' OR status_id = '17' ORDER BY rs_date_time DESC LIMIT 1 OFFSET 1";
                                        $result_lastest1 = mysqli_query($conn, $sql_lastest1);

                                        $row_lastest1 = mysqli_fetch_array($result_lastest1);
                                        $rs_id_update_17 = $row_lastest1['rs_id'];

                                        // $sql_lastest_up = "UPDATE repair_detail SET del_flg = 0 WHERE rs_id = '$rs_id_update_17'";
                                        // $result_lastest_up = mysqli_query($conn, $sql_lastest_up);
                                    }
                                }

                                if ($status_id_last == 13 && $row_lastest['rs_conf'] == NULL || $have_17 == 17) {
                                ?>
                                    <div class="col-md-6 <?php if ($status_id_last == 13 || $have_17 == 17) { ?> alert alert-primary  <?php  } ?>">
                                        <div class="card shadow mb-4 ">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">ข้อมูลอะไหล่ใหม่ของอุปกรณ์</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>ลำดับ</th>
                                                                <th>หมายเลขอะไหล่</th>
                                                                <th>รหัสการซ่อม</th>
                                                                <th>ชื่อ</th>
                                                                <th>Brand</th>
                                                                <th>Model</th>
                                                                <th>ประเภท</th>
                                                                <th>ราคา</th>
                                                                <th>จำนวน</th>
                                                                <th>ราคารวม</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $totalPartPrice = 0;
                                                            $sqlParts = "SELECT
                                                                        repair_detail.p_id,
                                                                        MAX(repair_detail.p_id) AS rBrand,
                                                                        MAX(repair_detail.p_id) AS rModel,
                                                                        MAX(repair_detail.p_id) AS pId,
                                                                        MAX(repair_detail.rd_value_parts) AS rdValueParts,
                                                                        MAX(repair_detail.get_d_id) AS getDId,
                                                                        MAX(parts.p_brand) AS pBrand,
                                                                        MAX(parts.p_model) AS pModel,
                                                                        MAX(parts.p_price) AS pPrice,
                                                                        MAX(parts_type.p_type_name) AS pTypeName,
                                                                        MAX(repair_status.rs_id) AS rsId,
                                                                        MAX(parts.p_pic) AS pPic,
                                                                        MAX(repair.r_brand) AS rBrand,
                                                                        MAX(repair.r_model) AS rModel,
                                                                        MAX(repair.r_serial_number) AS rSerialNumber
                                                                    FROM
                                                                        `repair_detail`
                                                                        LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                                                                        LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
                                                                        LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                                                                        LEFT JOIN repair ON get_detail.r_id = repair.r_id
                                                                        JOIN parts ON parts.p_id = repair_detail.p_id
                                                                        LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id
                                                                    WHERE
                                                                        get_repair.del_flg = 0 AND repair_detail.del_flg = 0
                                                                        AND get_repair.get_r_id = '$get_id'  ";

                                                            if ($status_id_last == 13) {
                                                                $sqlCheckOffer = "SELECT * FROM repair_status WHERE get_r_id = '$get_id' AND status_id = 13 AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1";
                                                                $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                                if (mysqli_num_rows($resultOffer)) {
                                                                    $rowOffer = mysqli_fetch_array($resultOffer);
                                                                    $Offer_rs =  $rowOffer['rs_id'];
                                                                    $sqlParts .=   " AND repair_status.rs_id = $Offer_rs ";
                                                                } else {
                                                                    $sqlParts .=   " AND repair_status.status_id != 13 ";
                                                                }
                                                            }


                                                            if ($status_id_last == 17) {
                                                                $sqlCheckOffer = "SELECT * FROM repair_status WHERE get_r_id = '$get_id' AND status_id = 17 AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1";
                                                                $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                                if (mysqli_num_rows($resultOffer)) {
                                                                    $rowOffer = mysqli_fetch_array($resultOffer);
                                                                    $Offer_rs =  $rowOffer['rs_id'];
                                                                    $sqlParts .=   " AND repair_status.rs_id = $Offer_rs ";
                                                                } else {
                                                                    $sqlParts .=   " AND repair_status.status_id != 17 ";
                                                                }
                                                            }


                                                            $sqlParts .= "GROUP BY repair_detail.rd_id;";

                                                            $resultParts = mysqli_query($conn, $sqlParts);
                                                            $partCount = 0;
                                                            while ($rowParts = mysqli_fetch_array($resultParts)) {
                                                                $partCount++;
                                                                $pId = $rowParts['pId'];
                                                                $rsId = $rowParts['rsId'];
                                                            ?>
                                                                <?php
                                                                $sqlCount = "SELECT * FROM repair_detail WHERE rs_id = '$rsId' AND p_id = '$pId'";
                                                                $resultCount = mysqli_query($conn, $sqlCount);
                                                                $rowCount = mysqli_fetch_array($resultCount);
                                                                $getDId1 = $rowCount['get_d_id'];
                                                                $sqlRepair = "SELECT * FROM repair 
                                LEFT JOIN get_detail ON get_detail.r_id = repair.r_id
                                WHERE get_detail.get_d_id = '$getDId1'";
                                                                $resultRepair = mysqli_query($conn, $sqlRepair);
                                                                $rowGetD = mysqli_fetch_array($resultRepair);
                                                                ?>
                                                                <tr>
                                                                    <td><?php
                                                                        if ($partCount == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                            echo $partCount;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php
                                                                        if ($rowParts['pId'] == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                            echo $rowParts['pId'];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php
                                                                        if ($rowParts['getDId'] == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                            echo $rowParts['getDId'] . ' ' . $rowParts['rBrand'] . ' ' . $rowParts['rModel'] ?><h5><?= ' S/N :' . $rowParts['rSerialNumber'] ?></h5><?php
                                                                                                                                                                                                                }
                                                                                                                                                                                                                    ?>
                                                                    </td>
                                                                    <td><?php
                                                                        if ($rowParts['pPic'] == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                        ?>
                                                                            <img src="<?= $rowParts['pPic'] ?>" width="50px" alt="Not Found">
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php
                                                                        if ($rowParts['pBrand'] == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                            echo $rowParts['pBrand'];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php
                                                                        if ($rowParts['pModel'] == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                            echo $rowParts['pModel'];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php
                                                                        if ($rowParts['pTypeName'] == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                            echo $rowParts['pTypeName'];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php
                                                                        if ($rowParts['pPrice'] == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                            echo $rowParts['pPrice'];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php
                                                                        if ($rowParts['rdValueParts'] == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                            echo $rowParts['rdValueParts'];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ($rowParts['pPrice'] == NULL) {
                                                                            echo "-";
                                                                        } else {
                                                                            echo number_format($rowParts['rdValueParts'] * $rowParts['pPrice']);
                                                                            $totalPartPrice += $rowParts['rdValueParts'] * $rowParts['pPrice'];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="7">ยอดอะไหล่ทั้งหมด</td>
                                                                <td colspan="2">ราคารวม</td>
                                                                <td><?php $totalPartPrice = $totalPartPrice; ?><?= number_format($totalPartPrice) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <?php
                                                                $sqlWages = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                                $resultWages = mysqli_query($conn, $sqlWages);
                                                                $rowWages = mysqli_fetch_array($resultWages);
                                                                ?>
                                                                <td colspan="7">ค่าแรงช่าง</td>
                                                                <td colspan="2">ค่าแรง</td>
                                                                <td><?= number_format($rowWages['get_wages']) ?></td>
                                                            </tr>
                                                            <?php
                                                            $sqlPrice = "SELECT get_deli , get_add_price FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                            $resultPrice = mysqli_query($conn, $sqlPrice);
                                                            $rowPrice = mysqli_fetch_array($resultPrice);

                                                            if ($rowPrice['get_deli'] == 1) {
                                                                $totalPartPrice += $rowPrice['get_add_price'];
                                                            ?>
                                                                <tr>
                                                                    <td colspan="7">ค่าจัดส่ง</td>
                                                                    <td colspan="2">ราคาจัดส่ง</td>
                                                                    <td><?= number_format($rowPrice['get_add_price']) ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>

                                                            <tr>
                                                                <td colspan="7"></td>
                                                                <td colspan="2">ราคารวมทั้งหมด</td>
                                                                <td>
                                                                    <h5><?= number_format($totalPartPrice + $rowWages['get_wages']) ?> </h5>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                <?php
                                } ?>
                                <div class="col-md 
                                <?php if ($status_id_last == 13 || $have_17 == 17 && $row_lastest['rs_conf'] == NULL) { ?> alert alert-danger  <?php  } ?> ">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <?php
                                            // สถานะเกิดปัญหา
                                            if ($status_id_last == 13 || $have_17 == 17 && $row_lastest['rs_conf'] == NULL) {
                                            ?> <h6 class="m-0 font-weight-bold text-danger">ข้อมูลอะไหล่เก่าของอุปกรณ์</h6>
                                            <?php
                                            } else {
                                            ?> <h6 class="m-0 font-weight-bold text-primary">ข้อมูลอะไหล่อุปกรณ์ของคุณ</h6>
                                            <?php
                                            } ?>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>ลำดับ</th>
                                                            <th>หมายเลขอะไหล่</th>
                                                            <th>รหัสการซ่อม</th>
                                                            <th>ชื่อ</th>
                                                            <th>Brand</th>
                                                            <th>Model</th>
                                                            <!-- <th>Name</th> -->
                                                            <th>ประเภท</th>
                                                            <!-- <th>รายละเอียด</th> -->
                                                            <th>ราคา</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคารวม</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_part_price = 0;
                                                        $sql_op = "SELECT
                                                                        repair_detail.p_id,
                                                                        MAX(repair_detail.p_id) AS r_brand,
                                                                        MAX(repair_detail.p_id) AS r_model,
                                                                        MAX(repair_detail.p_id) AS p_id,
                                                                        MAX(repair_detail.rd_value_parts) AS rd_value_parts,
                                                                        MAX(repair_detail.get_d_id) AS get_d_id,
                                                                        MAX(parts.p_brand) AS p_brand,
                                                                        MAX(parts.p_model) AS p_model,
                                                                        MAX(parts.p_price) AS p_price,
                                                                        MAX(parts_type.p_type_name) AS p_type_name,
                                                                        MAX(repair_status.rs_id) AS rs_id,
                                                                        MAX(parts.p_pic) AS p_pic,
                                                                        MAX(repair.r_brand) AS r_brand,
                                                                        MAX(repair.r_model) AS r_model
                                                                    FROM
                                                                        `repair_detail`
                                                                        LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                                                                        LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
                                                                        LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                                                                        LEFT JOIN repair ON get_detail.r_id = repair.r_id
                                                                        JOIN parts ON parts.p_id = repair_detail.p_id
                                                                        LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id
                                                                    WHERE
                                                                        get_repair.del_flg = 0 AND repair_detail.del_flg = 0
                                                                        AND get_repair.get_r_id = '$get_id' ";
                                                        if ($status_id_last == 13) {
                                                            $sqlCheckOffer = "SELECT * FROM repair_status WHERE get_r_id = '$get_id' AND status_id = 13 OR status_id = 17 AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1 OFFSET 1";
                                                            $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                            if (mysqli_num_rows($resultOffer)) {
                                                                $rowOffer = mysqli_fetch_array($resultOffer);
                                                                $Offer_rs =  $rowOffer['rs_id'];
                                                                $sql_op .=   " AND repair_status.rs_id = '$Offer_rs' ";
                                                            } else {
                                                                $sql_op .=   " AND repair_status.status_id != 13 ";
                                                            }
                                                        } elseif ($have_17 == 17) {
                                                            $sqlCheckOffer = "SELECT *
                                                            FROM repair_status
                                                            LEFT JOIN repair_detail ON repair_detail.rs_id = repair_status.rs_id
                                                            WHERE repair_status.get_r_id = '$get_id'
                                                            AND (repair_status.status_id = 17 OR repair_status.status_id = 13)
                                                            AND repair_status.del_flg = 0
                                                            AND repair_detail.del_flg = 0
                                                            ORDER BY repair_status.rs_id DESC
                                                            LIMIT 1 OFFSET 1;
                                                            ";
                                                            $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                            if (mysqli_num_rows($resultOffer)) {
                                                                $rowOffer = mysqli_fetch_array($resultOffer);
                                                                $Offer_rs =  $rowOffer['rs_id'];
                                                                $sql_op .=   " AND repair_status.rs_id = $Offer_rs ";
                                                            } else {
                                                                $sql_op .=   " AND repair_status.status_id != 13 ";
                                                            }
                                                        }
                                                        $sql_op .= "GROUP BY repair_detail.rd_id;";
                                                        $result_op = mysqli_query($conn, $sql_op);
                                                        $count_part = 0;
                                                        while ($row_op = mysqli_fetch_array($result_op)) {

                                                            $count_part++;
                                                            $p_id = $row_op['p_id'];
                                                            $rs_id = $row_op['rs_id'];
                                                        ?>
                                                            <?php

                                                            $sql_count = "SELECT * FROM repair_detail WHERE rs_id = '$rs_id' AND p_id = '$p_id'";
                                                            $result_count = mysqli_query($conn, $sql_count);
                                                            $row_count = mysqli_fetch_array($result_count);

                                                            $get_d_id1 = $row_count['get_d_id'];

                                                            $sql_repair = "SELECT * FROM repair 
                                                                        LEFT JOIN get_detail ON get_detail.r_id = repair.r_id
                                                                        WHERE get_detail.get_d_id = '$get_d_id1'";
                                                            $result_repair = mysqli_query($conn, $sql_repair);
                                                            $row_get_d = mysqli_fetch_array($result_repair);
                                                            ?>
                                                            <tr>
                                                                <td><?php
                                                                    if ($count_part == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo $count_part . '  ' . $Offer_rs;
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php
                                                                    if ($row_op['p_id'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo $row_op['p_id'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php
                                                                    if ($row_op['get_d_id'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo $row_op['get_d_id'] . ' '  . $row_get_d['r_brand'] . ' ' . $row_get_d['r_model'] ?><h5><?= ' S/N :' . $row_get_d['r_serial_number'] ?></h5><?php
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                        ?>
                                                                </td>

                                                                <td><?php
                                                                    if ($row_op['p_pic'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                    ?>
                                                                        <img src="<?= $row_op['p_pic'] ?>" width="50px" alt="Not Found">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>


                                                                <!-- <td><?php
                                                                            if ($row_op['p_name'] == NULL) {
                                                                                echo "-";
                                                                            } else {
                                                                                echo $row_op['p_name'];
                                                                            }
                                                                            ?>
                                        </td> -->
                                                                <td><?php
                                                                    if ($row_op['p_brand'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo $row_op['p_brand'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php
                                                                    if ($row_op['p_model'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo $row_op['p_model'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php
                                                                    if ($row_op['p_type_name'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo $row_op['p_type_name'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php
                                                                    if ($row_op['p_price'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo $row_op['p_price'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php
                                                                    if ($row_op['rd_value_parts'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo $row_op['rd_value_parts'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if ($row_op['p_price'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo number_format($row_op['rd_value_parts'] * $row_op['p_price']);
                                                                        $total +=  $row_op['rd_value_parts'] * $row_op['p_price'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td colspan="7">ยอดอะไหล่ทั้งหมด</td>
                                                            <td colspan="2">ราคารวม</td>
                                                            <td><?php $total_part_price = $total; ?><?= number_format($total) ?></td>
                                                            <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                        </tr>
                                                        <tr>
                                                            <?php
                                                            $sql_w = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                            $result_w = mysqli_query($conn, $sql_w);
                                                            $row_w = mysqli_fetch_array($result_w);
                                                            ?>
                                                            <td colspan="7">ค่าแรงช่าง</td>
                                                            <td colspan="2">ค่าแรง</td>
                                                            <td><?= number_format($row_w['get_wages']) ?></td>
                                                            <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                        </tr>
                                                        <?php
                                                        $sql_p = "SELECT get_deli , get_add_price FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                        $result_p = mysqli_query($conn, $sql_p);
                                                        $row_p = mysqli_fetch_array($result_p);

                                                        if ($row_p['get_deli'] == 1) {
                                                            $total += $row_p['get_add_price'];
                                                        ?>
                                                            <tr>
                                                                <td colspan="7">ค่าจัดส่ง</td>
                                                                <td colspan="2">ราคาจัดส่ง</td>
                                                                <td><?= number_format($row_p['get_add_price']) ?></td>
                                                                <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>


                                                        <tr>
                                                            <td colspan="7"></td>
                                                            <td colspan="2">ราคารวมทั้งหมด</td>
                                                            <td>
                                                                <h5><?= number_format($total + $row_w['get_wages']) ?> </h5>
                                                            </td>
                                                            <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <center>
                            </center>

                            <!-- Place this before the closing </body> tag -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('confirmButton').addEventListener('click', function() {
                                        Swal.fire({
                                            icon: 'question',
                                            title: 'ยืนยันการดำเนินการ',
                                            text: 'การ "ยืนยัน" จะไม่สามารถกลับมาแก้ไขข้อมูลได้?',
                                            showCancelButton: true,
                                            confirmButtonText: 'ยืนยัน',
                                            cancelButtonText: 'ยกเลิก'
                                        }).then((willConfirm) => {
                                            if (willConfirm.isConfirmed) {
                                                window.location.href = "action/conf_part.php?id=<?= $get_id ?>"; // Redirect to home.php
                                            }
                                        });
                                    });
                                });
                            </script>


                        </div>
                        <!-- End of Main Content -->

                    </div>
                    <!-- End of Content Wrapper -->

                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop_unique" aria-labelledby="offcanvasTopLabel" style="height: 70%">
        <div class="offcanvas-header">
        </div>
        <div class="offcanvas-body">
            <a type="button" class="btn-close text-reset d-flex justify-content-end ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></a>
            <h2>หมายเลขพัสดุจากท่าน</h2>
            <br>
            <?php
            $id_get_r = $_GET['id'];
            $sql_com_m = "  SELECT * FROM get_detail
                            LEFT JOIN get_repair ON get_detail.get_r_id = get_repair.get_r_id 
                            LEFT JOIN tracking ON get_detail.get_t_id = tracking.t_id 
                            LEFT JOIN repair ON repair.r_id = get_detail.r_id WHERE get_repair.get_r_id = '$id_get_r' AND repair.del_flg = '0' AND get_detail.get_d_conf = '0'";
            $result_com_m = mysqli_query($conn, $sql_com_m);

            $count_com = 0;
            while ($row_com_m = mysqli_fetch_array($result_com_m)) {
                if ($row_com_m['t_parcel'] != NULL) {
                    $count_com += 1;
            ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $row_com_m['r_serial_number'] ?>">
                        <div class="alert alert-secondary">
                            <p>
                                <span class="badge bg-secondary"><?= $count_com ?> </span> :
                                <span class="inline"><?= $row_com_m['r_brand'] . ' ' . $row_com_m['r_model'] . ' - ' . $row_com_m['t_parcel'] ?></span>
                                <!-- <span id="tooltip"><?= $row_com_m['r_serial_number'] ?></span> -->
                            </p>
                        </div>
                    </a>
                <?php
                }
            }
            if ($count_com == 0) {
                ?> <center>
                    <hr><br>
                    <h5 class="f-red-5">*** ไม่มีข้อมูล ***</h5>
                </center> <?php
                        }
                            ?>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <!-- <h5 id="offcanvasRightLabel">Offcanvas right</h5> -->
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <br>
            <!-- <h3><span class="badge bg-secondary">หมายเลขอุปกรณ์ของท่าน</span></h3> -->
            <div class="container">
                <h3>หมายเลขอุปกรณ์ของท่าน</h3>
                <br>
                <!-- <p>Click the button below to copy the Bootstrap code:</p> -->


                <?php
                $count_my_parcel = 0;
                $id_get_r = $_GET['id'];
                $sql_track = "SELECT * FROM `get_detail` 
                                                                        LEFT JOIN tracking ON tracking.t_id = get_detail.t_id
                                                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                                        WHERE get_detail.get_r_id = '$id_get_r';";
                $result_track = mysqli_query($conn, $sql_track);
                while ($row_track = mysqli_fetch_array($result_track)) {
                    if ($row_track['t_parcel'] != NULL) {
                        $count_my_parcel++;


                ?>
                        <div class="row">
                            <h5><?= $row_track['r_brand'] . ' ' . $row_track['r_model'] ?></h5>
                        </div>
                        <!-- <div class="row"> -->
                        <div class="row">
                            <!-- <div class="row"> -->
                            <p style="font-size: 14px;">SN : <?= $row_track['r_serial_number'] ?></p>
                            <!-- </div> -->
                            <!-- <div class="row">
                                                                <h6><?= $row_track['r_serial_number']  ?></h6>
                                                            </div> -->
                        </div>
                        <div class="row">
                            <div class="row">
                                <p style="display: none;" id="bootstrapCode"><?= $row_track['t_parcel'] ?></p>
                                <div class="col-12">
                                    หมายเลขพัสดุ : <button class="btn btn-primary" id="copyButton" onclick="copyToClipboard()" data-bs-toggle="tooltip" data-bs-placement="top" title="คลิ๊กเพื่อคัดลอก"><?= $row_track['t_parcel'] ?></button>

                                </div>
                            </div>

                        </div>
                        <!-- </div> -->
                        <hr>
                        <br>
                    <?php }
                }
                if ($count_my_parcel == 0) {
                    ?> <center>
                        <hr><br>
                        <h5 class="f-red-5">*** ไม่มีข้อมูล ***</h5>
                    </center> <?php
                            }
                                ?>
                <script>
                    function copyToClipboard() {
                        var copyText = document.getElementById("bootstrapCode");
                        var textarea = document.createElement("textarea");
                        textarea.value = copyText.textContent;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand("copy");
                        document.body.removeChild(textarea);
                        alert("Copied to clipboard: " + copyText.textContent);
                    }
                </script>

            </div>

        </div>
    </div>
    <!-- navbar-->
    <?php


    $id_get_r = $_GET['id'];
    // Assuming $id_get_r is your parameterized value
    $sql = "SELECT rs.rs_id,
    rs.status_id,
    st.status_name,
    st.status_color,
    rs.rs_conf,
    rs.rs_date_time,
    rs.rs_detail,
    rs.rs_conf_date,
    rs.rs_cancel_detail,
    gr.get_date_conf,
    gr.get_tel,
    gr.get_add,
    gr.get_wages,
    gr.get_add_price,
    gr.get_add_price
FROM get_repair gr
LEFT JOIN repair_status rs ON gr.get_r_id = rs.get_r_id 
LEFT JOIN status_type st ON rs.status_id = st.status_id 
WHERE gr.get_r_id = ? AND rs.del_flg = '0' 
ORDER BY rs.rs_date_time DESC 
           ";

    // Use prepared statements
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $id_get_r);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle the error
        echo "Error: " . mysqli_error($conn);
    }
    $sql2 = "SELECT rs.rs_id, rs.status_id, st.status_color, rs.rs_conf, rs.rs_date_time, rs.rs_detail,
                    gr.get_tel, gr.get_add, gr.get_wages, gr.get_add_price, gr.get_add_price, gr.get_config
                FROM get_repair gr
                LEFT JOIN repair_status rs ON gr.get_r_id = rs.get_r_id 
                LEFT JOIN status_type st ON rs.status_id = st.status_id 
                WHERE gr.get_r_id = ? AND rs.del_flg = '0' 
                ORDER BY rs.rs_date_time DESC
                LIMIT 1;";

    // Use prepared statements
    $stmt2 = mysqli_prepare($conn, $sql2);

    if ($stmt2) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt2, "s", $id_get_r);

        // Execute the statement
        mysqli_stmt_execute($stmt2);

        // Get the result
        $result2 = mysqli_stmt_get_result($stmt2);

        // Fetch data as needed
        $row_2 = mysqli_fetch_assoc($result2);

        // Close the statement
        mysqli_stmt_close($stmt2);
    } else {
        // Handle the error
        echo "Error: " . mysqli_error($conn);
    }
    // Assuming $id_get_r is your parameterized value
    $sql2 = "SELECT rs.rs_id, rs.status_id, st.status_color, rs.rs_conf, rs.rs_date_time, rs.rs_detail,st.status_name,
                    gr.get_tel, gr.get_add, gr.get_wages, gr.get_add_price, gr.get_add_price
                FROM get_repair gr
                LEFT JOIN repair_status rs ON gr.get_r_id = rs.get_r_id 
                LEFT JOIN status_type st ON rs.status_id = st.status_id 
                WHERE gr.get_r_id = ? AND rs.del_flg = '0' 
                ORDER BY rs.rs_date_time DESC
                LIMIT 1;";

    // Use prepared statements
    $stmt2 = mysqli_prepare($conn, $sql2);

    if ($stmt2) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt2, "s", $id_get_r);

        // Execute the statement
        mysqli_stmt_execute($stmt2);

        // Get the result
        $result2 = mysqli_stmt_get_result($stmt2);

        // Fetch data as needed
        $row_2 = mysqli_fetch_assoc($result2);

        // Close the statement
        mysqli_stmt_close($stmt2);
    } else {
        // Handle the error
        echo "Error: " . mysqli_error($conn);
    }
    $id_get_r = $_GET['id'];

    $rs_lastest_id = $row_2['rs_id'];

    // นับครั้งที่ซ่อม สถานะ 6 ดำเนินการซ่อม
    $carry_out_id = $row['status_id'];
    $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = ? AND status_id = 6 AND del_flg = 0 ORDER BY rs_date_time DESC;";
    $stmt = $conn->prepare($sql_cary_out);
    $stmt->bind_param("s", $id_get_r);
    $stmt->execute();
    $result_carry_out = $stmt->get_result();
    $row_carry_out = mysqli_fetch_array($result_carry_out);

    // นับครั้งที่เสนอ ยื่นข้อเสนอ
    $sql_offer_c = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = ? AND status_id = 17 AND del_flg = 0 ORDER BY rs_date_time DESC;";
    $stmt = $conn->prepare($sql_offer_c);
    $stmt->bind_param("s", $id_get_r);
    $stmt->execute();
    $result_offer_c = $stmt->get_result();
    $row_offer_c = mysqli_fetch_array($result_offer_c);

    // $result_carry_out = mysqli_query($conn, $sql_cary_out);
    // $row_carry_out = mysqli_fetch_array($result_carry_out);

    // check parts of Get_r_id
    // Assuming $id_get_r is your parameterized value
    // $sql_c_part = "SELECT
    // MAX(repair_detail.p_id) AS p_id,
    // MAX(repair_detail.rd_value_parts) AS rd_value_parts,
    // MAX(repair_detail.get_d_id) AS get_d_id,
    // MAX(parts.p_brand) AS p_brand,
    // MAX(parts.p_model) AS p_model,
    // MAX(parts.p_price) AS p_price,
    // MAX(parts_type.p_type_name) AS p_type_name,
    // MAX(repair_status.rs_id) AS rs_id,
    // MAX(parts.p_pic) AS p_pic,
    // MAX(repair.r_brand) AS r_brand,
    // MAX(repair.r_model) AS r_model
    // FROM
    // `repair_detail`
    // LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
    // LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
    // LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
    // LEFT JOIN repair ON get_detail.r_id = repair.r_id
    // JOIN parts ON parts.p_id = repair_detail.p_id
    // LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id
    // WHERE
    // get_repair.del_flg = 0 AND repair_detail.del_flg = 0
    // AND get_repair.get_r_id = ?
    // GROUP BY
    // repair_detail.rd_id";

    // // Use prepared statements
    // $stmt_c_part = mysqli_prepare($conn, $sql_c_part);

    // if ($stmt_c_part) {
    //     // Bind the parameter
    //     mysqli_stmt_bind_param($stmt_c_part, "s", $id_get_r);

    //     // Execute the statement
    //     mysqli_stmt_execute($stmt_c_part);

    //     // Get the result
    //     $result_c_part = mysqli_stmt_get_result($stmt_c_part);

    //     // Initialize a total part price variable
    //     $total_part_price = 0;

    //     // Fetch data as needed
    //     while ($row_c_part = mysqli_fetch_assoc($result_c_part)) {
    //         // Calculate the total part price based on your selected columns
    //         $total_part_price += $row_c_part['p_price']; // Adjust based on your requirements
    //     }

    //     // Close the statement
    //     mysqli_stmt_close($stmt_c_part);
    // } else {
    //     // Handle the error
    //     echo "Error: " . mysqli_error($conn);
    // }

    // Use $total_part_price as needed in your code


    // check status Process Bar
    $process_dot = 0;
    $allowedStatusIds1 = [1, 2];
    $allowedStatusIds2 = [4, 5, 17];
    $allowedStatusIds3 = [19];
    $allowedStatusIds4 = [6, 13];
    $allowedStatusIds5 = [7, 8, 26];
    $allowedStatusIds6 = [9, 10, 25];
    $allowedStatusIds7 = [24];
    $allowedStatusIds8 = [3];
    if (in_array($row_2['status_id'], $allowedStatusIds1)) {
        $process_dot = 1;
    } elseif (in_array($row_2['status_id'], $allowedStatusIds2)) {
        $process_dot = 2;
    } elseif (in_array($row_2['status_id'], $allowedStatusIds3)) {
        $process_dot = 3;
    } elseif (in_array($row_2['status_id'], $allowedStatusIds4)) {
        $process_dot = 4;
    } elseif (in_array($row_2['status_id'], $allowedStatusIds5)) {
        $process_dot = 5;
    } elseif (in_array($row_2['status_id'], $allowedStatusIds6)) {
        $process_dot = 6;
    } elseif (in_array($row_2['status_id'], $allowedStatusIds7)) {
        $process_dot = 7;
    } elseif (in_array($row_2['status_id'], $allowedStatusIds8)) {
        $process_dot = 8;
    }

    $last_status_name = $row_2['status_name'];

    // Assuming $id_get_r is your parameterized value
    $sql = "SELECT get_repair.get_add_price, get_detail.get_t_id 
        FROM get_detail
        LEFT JOIN get_repair ON get_detail.get_r_id = get_repair.get_r_id 
        LEFT JOIN repair ON repair.r_id = get_detail.r_id 
        WHERE get_repair.get_r_id = ? AND repair.del_flg = '0'";

    // Assuming you have a mysqli connection called $conn
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_get_r); // Assuming $id_get_r is a string, use "i" for integers
    $stmt->execute();
    $result_c = $stmt->get_result();
    $row_c = $result_c->fetch_assoc();
    $stmt->close();



    $get_add_price = $row_c['get_add_price']; ?>
    <div style="background-color: <?= $row_2['status_color'] ?>;height:200px;padding:7%;color:white;" class="auto-font">
        <?php if ($row_2['status_id'] == 1) { ?>
            <h3><i class="fa fa-check-square-o"></i> คุณได้ทำการส่งเรื่องแล้ว</h3>
            <p>โปรดรอการตอบกลับ พนักงานจะทำการตอบกลับภายใน 2 วันทำการ<br>หากคุณต้องการยกเลิกคำสั่งซ่อมสามารถทำการ <span style="color:white">"ยกเลิก"</span> ได้</p>

        <?php  } ?>
        <?php if ($row_2['status_id'] == 14) { ?>
            <h3><i class="fa fa-ban"></i> เกินระยะเวลาชำระเงิน (ตั้งแต่วันที่ <?php
                                                                                // Assuming $row_2['rs_date_time'] is in the format 'Y-m-d H:i:s'
                                                                                $dateToSubtract = strtotime('-1 year', strtotime($row_2['rs_date_time']));
                                                                                $newDate = date('d-m-Y', $dateToSubtract);

                                                                                echo $newDate;
                                                                                ?>)</h3>
            <p>ทางร้านต้องขอแจ้งให้ทราบว่าคุณไม่ได้ชำระเงินตามระยะเวลาที่กำหนด (ระยะเวลาเก็บอุปกรณ์ของท่านคือ 1 ปี) ดังนั้นเราจึงทำการเก็บอุปกณ์ของท่านเป็นทรัพย์สินของทางร้าน โปรดทราบว่าเราจะไม่มีการดำเนินการคืนเงินหรือรับผิดชอบแต่อย่างใดต่อของท่านในกรณีนี้</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 10) { ?>
            <h3><i class="fa fa-paper-plane-o"></i> กำลังดำเนินการส่งอุปกรณ์ให้คุณ</h3>
            <p>โปรดรอการตอบกลับจากพนักงาน</p>

        <?php  } ?>
        <?php if ($row_2['status_id'] == 20) { ?>
            <h3><i class="fa fa-paper-plane-o"></i> พนักงานกำลังตรวจสอบคำร้องของคุณ</h3>
            <p>โปรดรอการตอบกลับจากพนักงาน</p>

        <?php  } ?>
        <?php if ($row_2['status_id'] == 13) { ?>
            <h3><i class="fa fa-paper-plane-o"></i> พนักงานต้องการเปลี่ยนแปลงข้อมูลการซ่อม</h3>
            <p>โปรดตรวจสอบข้อมูลของท่านก่อนทำการยืนยัน ท่านสามารถปฏิเสธและเสนอได้</p>

        <?php  } ?>
        <?php if ($row_2['status_id'] == 24) { ?>
            <h3><i class="fa fa-paper-plane-o"></i> พนักงานดำเนินการส่งอุปกรณ์ให้คุณแล้ว</h3>
            <p>ตรวจสอบได้จากหมายเลขพัสดุของท่านได้ที่ <u>Tracking Number</u> </p>

        <?php  } ?>
        <?php if ($row_2['status_id'] == 26) { ?>
            <h3><i class="fa fa-minus-square"></i> โปรดส่งหลักฐานการชำระเงินใหม่อีกครั้ง</h3>
            <p>พนักงานได้ตรวจสอบกาชำระเงินของท่านเสร็จสิ้นและขอให้คุณส่งหลักฐานการชำระเงินใหม่อีกครั้ง<br>อ่านรายละเอียดเพิ่มเติมได้ที่ <u>ติดตามสถานะ</u> <span style="color:white">"ยกเลิก"</span> ได้</p>

        <?php  } ?>

        <?php if ($row_2['status_id'] == 3) { ?>
            <h3><i class="fa fa-check-square-o"></i> เสร็จสิ้น</h3>
            <p>ดำเนินการซ่อมเสร็จสิ้น<br>หากมีปัญหาโปรดส่งคำร้องไปที่พนักงาน</p>

        <?php  } ?>
        <?php if ($row_2['status_id'] == 19) { ?>
            <h3><i class="fa fa-check-square-o"></i> พนักงานได้รับอุปกรณ์ของคุณแล้ว</h3>
            <p>โปรดรอการตรวจเช็คจากพนักงานภายใน 1-2 วัน</p>
        <?php  }
        if ($row_2['status_id'] == 27) { ?>
            <h3><i class="fa fa-check-square-o"></i> พนักงานได้คำร้องของคุณแล้ว</h3>
            <p>โปรดรอการตอบกลับจากพนักงานภายใน 1-2 วัน</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 6) { ?>
            <h3><i class="fa fa-check-square-o"></i> พนักงานได้ทำการซ่อมอุปกรณ์ให้คุณแล้วในขณะนี้</h3>
            <?php
            $sql_date = "SELECT repair_status.rs_date_time,get_repair.get_date_conf FROM `repair_status` 
            LEFT JOIN get_repair ON get_repair.get_r_id = repair_status.get_r_id
            WHERE repair_status.get_r_id = ? AND status_id = 6 ORDER BY rs_date_time ASC;";
            $stmt = $conn->prepare($sql_date);
            $stmt->bind_param("s", $id_get_r);
            $stmt->execute();
            $result_date = $stmt->get_result();;
            $row_date = $result_date->fetch_assoc();
            $stmt->close();
            ?>
            <p>กำหนดแล้วเสร็จวันที่ <u><?=
                                        // $date = $row_date['rs_date_time'];
                                        $modifiedDate = date('d-m-Y ', strtotime($row_date['rs_date_time'] . ' + ' . $row_date['get_date_conf'] . ' days'));

                                        // echo $modifiedDate;

                                        ?></u> โดยประมาณ (นับจากวันที่ดำเนินการซ่อม)</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 2) { ?>
            <h3><i class="fa fa-check-square-o"></i> พนักงานได้รับเรื่องแล้ว</h3>
            <p>โปรดรอการตอบกลับจากพนักงานภายใน 1-2 วัน</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 8) { ?>
            <h3><i class="fa fa-check-square-o"></i> รอการชำระเงิน</h3>
            <p>กรุณาชำระเงินและแนบสลิปการโอนเพื่อให้พนักงานได้ตรวจสอบข้อมูลของท่านอย่างรวดเร็ว</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 9) { ?>
            <h3><i class="fa fa-check-square-o"></i> ท่านได้ทำการชำระเงินเสร็จสิ้น</h3>
            <?php
            if ($row_2['get_deli'] == 0) {
                echo 'กรุณามารับอุปกรณ์ที่ร้านได้ในวันเวลาทำการปกติ (ยกเว้นวันหยุดเทศกาล)';
            } else {
                echo 'พนักงานกำลังทำการจัดส่งอุปกรณ์ไปให้ท่านในขณะนี้';
            }
            ?>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 25) { ?>
            <h3><i class="fa fa-check-square-o"></i> คุณได้ทำการชำระเงินเรียบร้อยแล้ว</h3>
            <p>โปรดรอการตรวจสอบจากพนักงานภายใน 1 วันทำการ</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 7) { ?>
            <h3><i class="fa fa-check-square-o"></i> ช่างกำลังดำเนินการตรวจเช็ค</h3>
            <p>ช่างกำลังดำเนินการตรวจเช็คและทดสอบอุปกรณ์ของท่านอยู่ในขณะนี้</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 12) { ?>
            <h3><i class="fa fa-check-square-o"></i> ทำการยกเลิกคำสั่งซ่อมแล้ว</h3>
            <p>การยกเลิกสำเร็จเสร็จสิ้น</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 4) { ?>
            <h3> <i class="fa fa-commenting"></i> โปรดตรวจสอบข้อเสนอจากพนักงาน</h3>
            <p>หากไม่เป็นไปตามที่ต้องการสามารถ "ยื่นข้อเสนอ" ใหม่เพื่อให้พนักงานส่งข้อเสนอที่ตรงกับคุณได้</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 17) {
            if ($row_2['rs_conf'] == NULL) { ?>
                <h3> <i class="fa fa-commenting"></i> โปรดตรวจสอบข้อเสนอจากพนักงาน</h3>
                <p>หากไม่เป็นไปตามที่ต้องการสามารถ "ยื่นข้อเสนอ" ใหม่เพื่อให้พนักงานส่งข้อเสนอที่ตรงกับคุณได้</p>
            <?php  } elseif ($row_2['rs_conf'] == 0) {  ?>
                <h3> <i class="fa fa-commenting"></i> ข้อเสนอของคุณได้ถูกบันทึกแล้ว</h3>
                <p>โปรดรอการตอบกลับจากพนักงานภายใน 1-2 วัน</p>
            <?php } elseif ($row_2['rs_conf'] == 1) {  ?>
                <h3> <i class="fa fa-commenting"></i> คุณได้ทำการยืนยันการส่งซ่อมแล้ว</h3>
                <p>โปรดรอการตอบกลับจากพนักงานภายใน 1-2 วัน</p>
        <?php
            }
        } ?>
        <?php if ($row_2['status_id'] == 5 && $row_c['get_t_id'] != NULL) { ?>
            <h3> <i class="fa fa-check-square-o"></i> คุณได้ทำการส่งหมายเลขพัสดุแล้ว</h3>
            <p>กรุณารอให้พนักงานได้รับอุปกรณ์และทำการ <u>ตรวจเช็ค</u> ระยะเวลาส่งขึ้นอยู่กับผู้ให้บริการขนส่งเมื่อถึงแล้วช่างจะใช้เวลาตรวจสอบเป็นระยะเวลา 1-2 วัน</p>
        <?php  } elseif ($row_2['status_id'] == 5) { ?>
            <h3> <i class="fa fa-check-square-o"></i> ได้รับการยืนยันแล้ว</h3>
            <p>ขอให้ท่านดำเนินการส่งอุปกรณ์ไปที่ร้านด้วย <u>ตนเอง</u> หรือ <u>ทำการส่งหมายเลข "Tracking Number"</u> หากท่านส่งด้วยผู้ให้บริการขนส่ง เพื่อให้พนักงานสามารถตรวจสอบข้อมูลของท่านอย่างรวดเร็ว</p>
        <?php  } ?>
    </div>

    <?php
    $sql_v = "SELECT get_r_id FROM get_repair WHERE get_config = '$get_r_id' AND del_flg = 0 ";
    $result_v = mysqli_query($conn, $sql_v);
    $row_v = mysqli_fetch_array($result_v);

    if ($row_v['get_r_id'] > 0) {
    ?>
        <div class="container">
            <div class="row mt-4 p-4">
                <br>
                <div class="alert alert-primary">
                    <a href="detail_status.php?id=<?= $row_v['get_r_id'] ?>">
                        <h4><i class="fa fa-paper-plane"></i> คำร้องนี้กำลังอยู่ระหว่างดำเนินการในหมายเลขซ่อม : <?= $row_v['get_r_id'] ?></h4>
                    </a>
                </div>
            </div>
        </div>
    <?php
    } ?>
    <div class="px-5 pt-5 repair auto-font">
        <div class="container" style="display: none;">
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
        <br>
        <div class="container auto-font">
            <div id="MiniDetailStatusSuc" style="display: block;">
                <?php if ($row_2['status_id'] == 9) { ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-square"></i> ท่านได้ทำการชำระเงินเสร็จสิ้น
                    </div>
                <?php } ?>
                <?php if ($row_2['status_id'] == 3) { ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-square"></i> ดำเนินการซ่อมเสร็จสิ้น
                    </div>
                <?php } ?>
                <?php if ($row_2['status_id'] == 4 || $row_2['status_id'] == 17 || $row_2['status_id'] == 13) {
                    if ($row_2['rs_conf'] == NULL) {  ?>
                        <div class="alert alert-warning" role="alert">
                            <p>
                                <i class="fa fa-exclamation-triangle"></i>
                                ตรวจสอบรายละเอียดให้ครบถ้วนเพื่อผลประโยชน์ของท่านเอง
                                <u style="color:blue">
                                    <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop" <u>ดูอะไหล่ที่ต้องใช้</u>
                                </a>
                                </u>
                            </p>
                        </div>
                    <?php } else {  ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-square-o"></i>
                            ข้อเสนอของคุณได้ถูกบันทึกแล้ว โปรดรอการตอบกลับจากพนักงาน
                        </div>
                    <?php  }
                }

                if ($row_2['status_id'] == 5 && $row_c['get_t_id'] == NULL) {
                    ?>
                    <div class="alert alert-secondary">
                        <div class="alert alert-warning" role="alert">
                            <i class="fa fa-paper-plane"></i> กรุณาเลือกวิธีการส่งอุปกรณ์ไปยังที่ร้าน
                        </div>
                        <br>
                        <p>
                            <center>
                                <a class="btn btn-primary">
                                    <i class="fa fa-user-circle"></i> จัดส่งด้วยตัวเอง
                                </a>
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fa fa-paper-plane"></i> จัดส่งด้วยผู้ให้ขนส่ง
                                </button>
                            </center>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <form action="action/add_tracking.php?id=<?= $id_get_r ?>" method="POST" id="trackingForm">
                                    <?php
                                    $count_com = 0;
                                    $sql_count_repair = "SELECT gd.get_d_id, rp.r_serial_number, rp.r_model, rp.r_brand 
                                                        FROM get_detail gd
                                                        LEFT JOIN repair rp ON gd.r_id = rp.r_id
                                                        WHERE gd.get_r_id = ? AND gd.del_flg = 0;";
                                    $stmt = $conn->prepare($sql_count_repair);
                                    $stmt->bind_param("s", $id_get_r);
                                    $stmt->execute();
                                    $result_count_repair = $stmt->get_result();

                                    while ($row_count_repair = $result_count_repair->fetch_assoc()) {
                                        $count_com++;
                                    ?>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <h5><span class="badge bg-secondary"><?= $count_com ?></span><?= ' ' . $row_count_repair['r_brand'] . ' ' . $row_count_repair['r_model'] . ' ' ?><span class="badge bg-primary"><?= ' ' . $row_count_repair['r_serial_number'] ?></span></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="formGroupExampleInput" class="form-label">กรุณาเลือกผู้ให้บริการ</label>
                                                <select class="form-select" aria-label="Default select example" name="com_t_id_<?= $count_com ?>" required>
                                                    <option value="" disabled selected>เลือกบริษัทขนส่ง</option>
                                                    <?php
                                                    $sql_com = "SELECT * FROM company_transport WHERE del_flg = 0";
                                                    $result_com = mysqli_query($conn, $sql_com);
                                                    while ($row_com = mysqli_fetch_array($result_com)) {
                                                    ?>
                                                        <option value="<?= $row_com['com_t_id'] ?>"><?= $row_com['com_t_name'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="formGroupExampleInput" class="form-label">จัดส่งด้วยผู้ให้บริการ</label>
                                                <input type="text" class="form-control" id="formGroupExampleInput" name="tracking_number_<?= $count_com ?>" placeholder="กรุณาใส่เลข Tracking Number" required>
                                                <input type="text" name="get_d_id_<?= $count_com ?>" value="<?= $row_count_repair['get_d_id'] ?>" hidden>
                                            </div>
                                        </div>
                                        <hr>
                                    <?php
                                    }
                                    $stmt->close();
                                    ?>

                                    <center>
                                        <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">ยกเลิก</button>
                                        <button type="button" class="btn btn-success" onclick="showConfirmationTracking()">ยืนยัน</button>
                                    </center>
                                </form>

                                <script>
                                    function showConfirmationTracking() {
                                        Swal.fire({
                                            title: 'ยืนยันการส่งข้อมูล',
                                            text: 'คุณต้องการยืนยันการส่งข้อมูลหรือไม่?',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonText: 'ยืนยัน',
                                            cancelButtonText: 'ยกเลิก'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('trackingForm').submit(); // Submit the form
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                <?php
                }
                if ($row_2['status_id'] == 25) { ?>
                    <div class="alert alert-info" role="alert">
                        <i class="	fa fa-spinner"></i> โปรดรอการตรวจสอบจากพนักงาน ภายใน 1 วันทำการ
                    </div>
                <?php }
                if ($row_2['status_id'] == 8 || $row_2['status_id'] == 26) {

                ?>

                    <div class="alert alert-warning">
                        <div class="alert alert-secondary" role="alert">
                            <h5> <i class="fa fa-credit-card"></i> กรุณาทำการชำระเงิน
                                <?php
                                $sql = "SELECT rs.rs_id,
                                          rs.status_id,
                                          st.status_name,
                                          st.status_color,
                                          rs.rs_conf,
                                          rs.rs_date_time,
                                          rs.rs_detail,
                                          rs.rs_conf_date,
                                          gr.get_tel,
                                          gr.get_add,
                                          gr.get_wages,
                                          gr.get_add_price,
                                          gr.get_add_price
                                          FROM get_repair gr
                                          LEFT JOIN repair_status rs ON gr.get_r_id = rs.get_r_id 
                                          LEFT JOIN status_type st ON rs.status_id = st.status_id 
                                          WHERE gr.get_r_id = ? AND rs.del_flg = '0' 
                                          ORDER BY rs.rs_date_time DESC LIMIT 1
                                  ";

                                // Use prepared statements
                                $stmt = mysqli_prepare($conn, $sql);

                                if ($stmt) {
                                    // Bind the parameter
                                    mysqli_stmt_bind_param($stmt, "s", $get_id);

                                    // Execute the statement
                                    mysqli_stmt_execute($stmt);

                                    // Get the result
                                    $result_pay = mysqli_stmt_get_result($stmt);
                                    $row1_pay = mysqli_fetch_array($result_pay);
                                }
                                if ($row1_pay['status_id'] == 8 || $row1_pay['status_id'] == 26  && $row1_pay['rs_conf'] == NULL) {
                                    if ($row1_pay['status_id'] == 26) {
                                ?>
                                        <a href="form_pay.php?id=<?= $get_id  ?>" class="btn btn-primary">ส่งหลักฐานการชำระเงิน<span class="tooltip">กดเพื่อชำระเงิน</span></a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="form_pay.php?id=<?= $get_id  ?>" class="btn btn-primary">ทำการชำระเงิน<span class="tooltip">กดเพื่อชำระเงิน</span></a>
                                <?php
                                    }
                                }
                                ?>

                            </h5>
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <form action="action/add_tracking.php?id=<?= $id_get_r ?>" method="POST" id="trackingForm">
                                    <?php
                                    $count_com = 0;
                                    $sql_count_repair = "SELECT gd.get_d_id, rp.r_serial_number, rp.r_model, rp.r_brand 
                                                        FROM get_detail gd
                                                        LEFT JOIN repair rp ON gd.r_id = rp.r_id
                                                        WHERE gd.get_r_id = ? AND gd.del_flg = 0;";
                                    $stmt = $conn->prepare($sql_count_repair);
                                    $stmt->bind_param("s", $id_get_r);
                                    $stmt->execute();
                                    $result_count_repair = $stmt->get_result();

                                    while ($row_count_repair = $result_count_repair->fetch_assoc()) {
                                        $count_com++;
                                    ?>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <h5><span class="badge bg-secondary"><?= $count_com ?></span><?= ' ' . $row_count_repair['r_brand'] . ' ' . $row_count_repair['r_model'] . ' ' ?><span class="badge bg-primary"><?= ' ' . $row_count_repair['r_serial_number'] ?></span></h5>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-4 mb-3">
                                                <label for="formGroupExampleInput" class="form-label">กรุณาเลือกผู้ให้บริการ</label>
                                                <select class="form-select" aria-label="Default select example" name="com_t_id_<?= $count_com ?>" required>
                                                    <option value="" disabled selected>เลือกบริษัทขนส่ง</option>
                                                    <?php
                                                    $sql_com = "SELECT * FROM company_transport WHERE del_flg = 0";
                                                    $result_com = mysqli_query($conn, $sql_com);
                                                    while ($row_com = mysqli_fetch_array($result_com)) {
                                                    ?>
                                                        <option value="<?= $row_com['com_t_id'] ?>"><?= $row_com['com_t_name'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="formGroupExampleInput" class="form-label">จัดส่งด้วยผู้ให้บริการ</label>
                                                <input type="text" class="form-control" id="formGroupExampleInput" name="tracking_number_<?= $count_com ?>" placeholder="กรุณาใส่เลข Tracking Number" required>
                                                <input type="text" name="get_d_id_<?= $count_com ?>" value="<?= $row_count_repair['get_d_id'] ?>" hidden>
                                            </div>
                                        </div>
                                        <hr>
                                    <?php
                                    }
                                    $stmt->close();
                                    ?>

                                    <center>

                                        <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">ยกเลิก</button>
                                        <button type="button" class="btn btn-success" onclick="showConfirmationTracking()">ยืนยัน</button>
                                    </center>
                                </form>


                                <script>
                                    function showConfirmationTracking() {
                                        Swal.fire({
                                            title: 'ยืนยันการส่งข้อมูล',
                                            text: 'คุณต้องการยืนยันการส่งข้อมูลหรือไม่?',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonText: 'ยืนยัน',
                                            cancelButtonText: 'ยกเลิก'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('trackingForm').submit(); // Submit the form
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                <?php  } ?>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="container px-md-4 py-5 mx-auto">
                        <div class="card" id="process-status">

                            <div class="row p-4">
                                <?php
                                $repair_count = 0;
                                $sql_get_c1 = "SELECT * FROM get_detail
                                                        LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                        WHERE get_detail.get_r_id =  '$id_get_r' AND get_detail.del_flg = 0";
                                $result_get_c1 = mysqli_query($conn, $sql_get_c1);
                                while ($row_get_c1 = mysqli_fetch_array($result_get_c1)) {
                                    $repair_count++;
                                } ?>
                                <?php
                                $sql_2 = "SELECT gr.get_config
                                        FROM get_repair gr
                                        WHERE gr.get_r_id = '$get_r_id' AND gr.del_flg = 0";
                                $result_2 = mysqli_query($conn, $sql_2);
                                $row2 = mysqli_fetch_array($result_2);
                                $row2['get_config'];
                                if ($row2['get_config'] > 0) {  ?>
                                    <div class="row">
                                        <a href="detail_status.php?id=<?= $row2['get_config'] ?>">
                                            <div class="alert alert-primary" role="alert">
                                                <h5><i class="fa fa-paper-plane"></i> ต่อเนื่องมาจากหมายเลขซ่อมสั่งซ่อมที่ : <?= $row2['get_config'] ?></h5>
                                            </div>
                                        </a>
                                    </div>
                                <?php  }  ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>หมายเลขส่งซ่อมที่ <span class="text-primary font-weight-bold ln">#<?= $id_get_r ?></span></h5>
                                    </div>
                                    <div class="col-md-6 text-end process-line">
                                        <p class="ln" style="width: 100%; text-align: right;"> <!-- Add text-align: right; here -->
                                        <h5>
                                            <a id="bounce-item" class="text-primary" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdropss">
                                                รายละเอียดอุปกรณ์ (มี <?= $repair_count ?> อุปกรณ์)
                                            </a>
                                        </h5>
                                        </p>
                                    </div>
                                    <div class="col-md-6 text-end only-now-process">
                                        <p class="ln" style="width: 100%; text-align: center;"> <!-- Add text-align: right; here -->
                                            <center>
                                                <h5>
                                                    <a id="bounce-item" class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdropss">
                                                        รายละเอียดอุปกรณ์
                                                    </a>
                                                </h5>
                                            </center>
                                        </p>
                                    </div>
                                </div>

                                <div class="d-flex flex-column text-sm-right">
                                    <?php

                                    // เอาค่า get_r_id ออกมาหาค่าวัน
                                    $sql_start_day = "SELECT * FROM `get_repair` WHERE get_r_id = '$id_get_r' AND del_flg = '0';";
                                    $result_start_day = mysqli_query($conn, $sql_start_day);
                                    $row_start_day = mysqli_fetch_array($result_start_day);

                                    // เช็คว่ามีเลขไปรษณีย์จากทางร้านหรือไม่
                                    $sql_tracking = "SELECT t_id FROM get_repair
                                    LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id 
                                    WHERE get_repair.get_r_id = '$id_get_r' AND get_repair.del_flg = '0' ;";
                                    $result_tracking = mysqli_query($conn, $sql_tracking);
                                    $row_tracking = mysqli_fetch_array($result_tracking);
                                    $row_trackin = 0;
                                    if ($row_tracking['t_id'] != NULL) {
                                        $row_trackin++;
                                    }
                                    ?>
                                    <p style="color: gray" class="mb-0"><i class="	fa fa-calendar"></i> วันที่ยื่นเรื่อง : <?= date('d F Y', strtotime($row_start_day['get_r_date_in'])) . ' ' ?><span style="display:inline-block; color: gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row_start_day['get_r_date_in'])); ?></span>
                                        <?php if ($row_2['status_id'] == 24 || $row_2['status_id'] == 3 &&  $row_trackin > 0) { ?>
                                            <!-- <a href="">หมายเลขอุปกรณ์ของท่าน</a> -->
                                            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">หมายเลขพัสดุจากทางร้าน</button>
                                            <?php }
                                        $sql_start_repair_date = "SELECT * FROM repair_status 
                                WHERE get_r_id = '$id_get_r' AND status_id = 19 OR status_id = 17 AND del_flg = 0 ORDER BY rs_date_time DESC LIMIT 1;";
                                        $result_start_repair_date  = mysqli_query($conn, $sql_start_repair_date);
                                        $row_start_repair_date = mysqli_fetch_array($result_start_repair_date);
                                        if ($row_start_repair_date['rs_date_time']) {
                                            $startRepairDate_C = $row_start_repair_date['rs_date_time'];
                                            if ($row_start_day['get_date_conf']) {
                                                $daysToAdd_C = $row_start_day['get_date_conf'];

                                                $startDate_C = new DateTime($startRepairDate_C);
                                                $endDate_C = clone $startDate_C;
                                                $endDate_C->add(new DateInterval('P' . $daysToAdd_C . 'D'));

                                                $formattedEndDate_conf_C = $endDate_C->format('d F Y H:i:s');
                                                // echo $formattedEndDate_conf;


                                            ?>
                                    <p style="color: gray" class="mb-0"><i class="fa fa-calendar-check-o"></i> กำหนดแล้วเสร็จวันที่ : <?= date('d F Y', strtotime($formattedEndDate_conf_C)) . ' ' ?><span style="display:inline-block; color: gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($formattedEndDate_conf_C)); ?> <u style="color: #B90000;">(<?= $row_start_day['get_date_conf'] ?> วัน)</u></span>
                                        <!-- <span style="color:red">*** นับจากวันที่รับอุปกรณ์</span> -->
                                    </p>
                            <?php }
                                        } ?>
                            <?php if ($row_2['status_id'] == 9 || $row_2['status_id'] == 3) {
                                // success_pay_status
                            ?>
                                <!-- <div class="alert alert-success"> -->
                                <p style="color: gray"> พิมพ์บิลใบเสร็จ : <a href="#" style="color: blue">บิลใบเสร็จ <span class="tooltip">กดเพื่อดูใบเสร็จในหมายเลขซ่อมนี้</span></a></p>
                                <!-- </div> -->
                            <?php } ?>
                                </div>
                            </div>
                            <?php
                            // Assuming $id_get_r is your parameterized value
                            $sql_offer = "SELECT rs.rs_id,
                                        rs.status_id,
                                        st.status_name,
                                        st.status_color,
                                        rs.rs_conf,
                                        rs.rs_date_time,
                                        rs.rs_detail,
                                        rs.rs_conf_date,
                                        rs.rs_cancel_detail,
                                        gr.get_tel,
                                        gr.get_add,
                                        gr.get_wages,
                                        gr.get_add_price,
                                        gr.get_add_price
                                    FROM get_repair gr
                                    LEFT JOIN repair_status rs ON gr.get_r_id = rs.get_r_id 
                                    LEFT JOIN status_type st ON rs.status_id = st.status_id 
                                    WHERE gr.get_r_id = ? AND rs.del_flg = '0' 
                                    ORDER BY rs.rs_date_time DESC 
                                            ";

                            // Use prepared statements
                            $stmt = mysqli_prepare($conn, $sql_offer);

                            if ($stmt) {
                                // Bind the parameter
                                mysqli_stmt_bind_param($stmt, "s", $id_get_r);

                                // Execute the statement
                                mysqli_stmt_execute($stmt);

                                // Get the result
                                $result_offer = mysqli_stmt_get_result($stmt);

                                // Close the statement
                                mysqli_stmt_close($stmt);
                            } else {
                                // Handle the error
                                echo "Error: " . mysqli_error($conn);
                            }
                            $row2 = mysqli_fetch_array($result_offer);
                            if ($row2['rs_cancel_detail'] != NULL) {
                            ?>
                                <div class="col text-left alert alert-danger">
                                    <!-- <hr> -->
                                    <h5 class="f-red-5">เหตุผลไม่ยืนยันการซ่อม</h5>
                                    <p style="margin-left: 30px;"><?= $row2['rs_cancel_detail'] ?></p>
                                </div>
                            <?php
                            } ?>
                            <?php if ($row_2['status_id'] != 12 && $row_2['status_id'] != 20 && $row_2['status_id'] != 27) { ?>
                                <!-- Add class 'active' to progress -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-12">
                                        <ul id="progressbar" class="text-center process-line">
                                            <li class="<?php
                                                        if ($process_dot >= 1) {
                                                            echo 'active';
                                                        }
                                                        ?> step0">
                                                <br>
                                                <p id="font-status">ส่งเรื่อง</p>
                                            </li>
                                            <li class="<?php
                                                        if ($process_dot >= 2) {
                                                            echo 'active';
                                                        }
                                                        ?> step0">
                                                <br>
                                                <p id="font-status">ยื่นข้อเสนอ</p>
                                            </li>
                                            <li class="<?php
                                                        if ($process_dot >= 3) {
                                                            echo 'active';
                                                        }
                                                        ?> step0">
                                                <br>
                                                <p id="font-status">รอการส่งอุปกรณ์จากคุณ</p>
                                            </li>
                                            <li class="<?php
                                                        if ($process_dot >= 4) {
                                                            echo 'active';
                                                        }
                                                        ?> step0">
                                                <br>
                                                <p id="font-status">ดำเนินการซ่อม</p>
                                            </li>
                                            <li class="<?php
                                                        if ($process_dot >= 5) {
                                                            echo 'active';
                                                        }
                                                        ?> step0">
                                                <br>
                                                <p id="font-status">ดำเนินการตรวจเช็ค</p>
                                            </li>
                                            <li class="<?php
                                                        if ($process_dot >= 6) {
                                                            echo 'active';
                                                        }
                                                        ?> step0">
                                                <br>
                                                <p id="font-status">ชำระเงิน</p>
                                            </li>
                                            <li class="<?php
                                                        if ($process_dot >= 7) {
                                                            echo 'active';
                                                        }
                                                        ?> step0">
                                                <br>
                                                <p id="font-status">ส่งคืนอุปกรณ์</p>
                                            </li>
                                            <li class="<?php
                                                        if ($process_dot >= 8) {
                                                            echo 'active';
                                                        }
                                                        ?> step0">
                                                <br>
                                                <p id="font-status">เสร็จสิ้น</p>
                                            </li>
                                        </ul>

                                        <center>
                                            <div class="alert alert-light m-4 shadow only-now-process" style="background-color: <?= $row_2['status_color'] ?>;border:1px solid #<?= $row_2['status_color'] ?>">
                                                <h5 style="color:white"> สถานะล่าสุด : <?= $last_status_name  ?></h5>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width:<?= ($process_dot / 8) * 100 ?>%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                        </center>

                                    </div>

                                </div>
                                <!-- <div class="row d-flex justify-content-center">
                                    <div class="col-12">
                                        <br>
                                        <hr><br>
                                        <h5 style="color: red;margin-left:4%" class="mb-0"> กำหนดแล้วเสร็จวันที่ : <?= date('d F Y', strtotime($row_2['rs_date_time'])) . ' ' ?>
                                    </div>
                                </div> -->
                            <?php } elseif ($row_2['status_id'] == 12) { ?>
                                <div class="row d-flex justify-content-center p-4">

                                    <?php if ($row_2['rs_detail'] != NULL) {  ?>
                                        <h2 style="color:red"><i class="fa fa-check"></i> เหตุผลการยกเลิก</h2>
                                        <br>
                                        <p style="margin-left:8%;color: gray">เหตุผล : <?= $row_2['rs_detail'] ?></p>
                                        <p style="margin-left:8%;color: gray">ยกเลิกเมื่อ<span>วันที่ : <?= date('d F Y', strtotime($row_2['rs_date_time'])); ?> <span style="display:inline-block;color : gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row_2['rs_date_time'])); ?></span> </span>
                                        <?php
                                    } else {
                                        ?>
                                        <h2 style="color:red"><i class="fa fa-check"></i>ไม่มีเหตุผลการยกเลิก</h2>
                                        <br>
                                        <p style="margin-left:8%;color: gray">คุณได้ทำการยกเลิกคำสั่งซ่อมนี้เมื่อ<span>วันที่ : <?= date('d F Y', strtotime($row_2['rs_date_time'])); ?> <span style="display:inline-block;color : gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row_2['rs_date_time'])); ?></span> </span>
                                        </p>
                                    <?php
                                    } ?>

                                </div>
                            <?php
                            } elseif ($row_2['status_id'] == 20 || $row_2['status_id'] == 27) { ?>
                                <div class="row d-flex justify-content-center p-4">

                                    <?php if ($row_2['rs_detail'] != NULL) {  ?>
                                        <h2 style="color:red"><i class="fa fa-envelope"></i> คำร้องของคุณ</h2>
                                        <br>
                                        <div class="container p-4" style="margin-left:8%;">
                                            <div class="row">
                                                <p style="color: gray">เหตุผล : <?= $row_2['rs_detail'] ?></p>
                                            </div>
                                        </div>
                                        <p style="margin-left:8%;color: gray">ส่งคำร้องเมื่อ<span>วันที่ : <?= date('d F Y', strtotime($row_2['rs_date_time'])); ?> <span style="display:inline-block;color : gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row_2['rs_date_time'])); ?></span> </span>
                                        <?php
                                    } else {
                                        ?>
                                        <h2 style="color:red"><i class="fa fa-check"></i>ไม่มีเหตุผลในคำร้องของคุณ</h2>
                                        <br>
                                        <p style="margin-left:8%;color: gray">ส่งคำร้องนี้เมื่อ<span>วันที่ : <?= date('d F Y', strtotime($row_2['rs_date_time'])); ?> <span style="display:inline-block;color : gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row_2['rs_date_time'])); ?></span> </span>
                                        </p>
                                    <?php
                                    } ?>

                                </div>
                            <?php
                            } ?>




                            <!-- <div class="d-flex justify-content-end p-4" style="display:none">
                            <a href="" id="button-status">ดูอะไหล่ที่ต้องใช้</a>
                            <a onclick="openModalPart('quantitypart')" id="button-status">ดูอะไหล่ที่ต้องใช้</a>
                            <a class="btn btn-outline-danger" style="margin-left: 20px" href="#" onclick="openModalPart('quantitypart')">ดูจำนวนอะไหล่ที่ต้องใช้</a>
                            <a href="" id="button-status">รายละเอียด</a>
                        </div> -->
                            <!-- <div class="d-flex justify-content-end p-4">


                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">ดูอะไหล่ที่ต้องใช้</a></li>
                                        <li class="breadcrumb-item"><a href="#">รายละเอียด</a></li>
                                    </ol>
                                </nav>
                            </div> -->
                            <span id="tooltip">ข้อมูลการซ่อมของคุณ</span>
                            <br><br>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container px-md-4 py-5 mx-auto">
                        <div class="card" style="height: 100%;width:100%;">
                            <div class="card-body">
                                <font>
                                    <h5 style="font-style : i">
                                        <i class="fa fa-map-marker" style="margin-right:1%"></i> ที่อยู่ของคุณ

                                    </h5>
                                    <div style="margin-left : 5%; color : gray">
                                        <p>
                                            <?= $row1['m_fname'] . ' ' . $row1['m_lname'] ?>
                                            (+66)<?= $row_2['get_tel'] ?>
                                        </p>
                                        <p>
                                            <?php

                                            $jsonobj = $row_2['get_add'];

                                            $obj = json_decode($jsonobj);

                                            $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
                                                    FROM provinces
                                                    LEFT JOIN amphures ON provinces.id = amphures.province_id
                                                    LEFT JOIN districts ON amphures.id = districts.amphure_id
                                                    WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
                                            $result_p = mysqli_query($conn, $sql_p);
                                            $row_p = mysqli_fetch_array($result_p);
                                            ?>
                                            <?= $obj->description ?>
                                            ตำบล<?= $row_p[2] ?> อำเภอ<?= $row_p[1] ?> จังหวัด<?= $row_p[0] ?>

                                        </p>
                                        <?php if ($row_c['get_t_id'] != NULL) { ?>
                                            <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop_unique" aria-controls="offcanvasTop_unique"><u>หมายเลขพัสดุจากคุณ</u></a>



                                        <?php } ?>
                                    </div>
                                </font>
                                <hr>
                                <font class="auto-font">
                                    <h5><i class="fa fa-shield"></i> วิธีการรับอุปกรณ์</h5>
                                </font>
                                <p style="margin-left : 5%;color : gray" class="auto-font">
                                    <?php
                                    if ($row_2['get_deli'] == 0) {
                                        echo 'รับอุปกรณ์ที่ร้าน';
                                    } else {
                                        echo 'จัดส่งอุปกรณ์ผ่านขนส่ง';
                                    }
                                    ?>
                                </p>
                                <?php if ($total_part_price != NULL) {  ?>
                                    <hr>
                                    <div class="accordion accordion-flush auto-font" id="accordionFlushExample" style="background-color: #F1F1F1;">
                                        <div class="accordion-item" id="totalprice" style="background-color:#F1F1F1">
                                            <div>
                                                <h5 class="accordion-header" id="flush-headingTwo" style="background-color: #F1F1F1;">
                                                    <br>
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo" style="background-color: #F1F1F1;">
                                                        <h5 class="auto-font-head">
                                                            รวมการสั่งซ่อม <?= number_format($total_part_price + $row_2['get_wages'] + $row_2['get_add_price']) ?> บาท
                                                        </h5>
                                                    </button>
                                                </h5>
                                            </div>

                                            <span id="tooltip">กดเพื่อดูรายละเอียดเพิ่มเติม</span>

                                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body" style="margin-left : 0%;color : gray">
                                                    <br>
                                                    <?php

                                                    // Assuming $id_get_r is your parameterized value
                                                    $sql_offer = "SELECT rs.rs_id,
                                                     rs.status_id,
                                                     st.status_name,
                                                     st.status_color,
                                                     rs.rs_conf,
                                                     rs.rs_date_time,
                                                     rs.rs_detail,
                                                     rs.rs_conf_date,
                                                     rs.rs_cancel_detail,
                                                     gr.get_date_conf,
                                                     gr.get_tel,
                                                     gr.get_add,
                                                     gr.get_wages,
                                                     gr.get_add_price,
                                                     gr.get_add_price
                                                 FROM get_repair gr
                                                 LEFT JOIN repair_status rs ON gr.get_r_id = rs.get_r_id 
                                                 LEFT JOIN status_type st ON rs.status_id = st.status_id 
                                                 WHERE gr.get_r_id = ? AND rs.del_flg = '0' 
                                                 ORDER BY rs.rs_date_time DESC 
                                                            ";

                                                    // Use prepared statements
                                                    $stmt = mysqli_prepare($conn, $sql_offer);

                                                    if ($stmt) {
                                                        // Bind the parameter
                                                        mysqli_stmt_bind_param($stmt, "s", $id_get_r);

                                                        // Execute the statement
                                                        mysqli_stmt_execute($stmt);

                                                        // Get the result
                                                        $result_offer = mysqli_stmt_get_result($stmt);
                                                        $row_f = mysqli_fetch_array($result_offer);
                                                        // Close the statement
                                                        mysqli_stmt_close($stmt);
                                                    } else {
                                                        // Handle the error
                                                        echo "Error: " . mysqli_error($conn);
                                                    }
                                                    if ($row_f['get_date_conf'] != NULL) {
                                                    ?>
                                                        <div class="row">
                                                            <div class="col-md d-flex  justify-content-center">
                                                                <p>ระยะเวลาดำเนินการ <u class="f-black-5"><?= $row_f['get_date_conf'] ?></u> วัน</p>
                                                            </div>

                                                        </div>
                                                    <?php
                                                    }
                                                    ?>

                                                    <div class="row">
                                                        <div class="col-md-6 d-flex  justify-content-start">
                                                            ค่าอะไหล่
                                                        </div>
                                                        <div class="col-md-6 d-flex  justify-content-end">
                                                            <?= number_format($total_part_price) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 d-flex  justify-content-start">
                                                            ค่าแรง
                                                        </div>
                                                        <div class="col-md-6 d-flex  justify-content-end">
                                                            ฿ <?php
                                                                if ($row_2['get_wages'] != NULL) {
                                                                    echo number_format($row_2['get_wages']);
                                                                } else {
                                                                    echo '0';
                                                                }
                                                                ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 d-flex  justify-content-start">
                                                            ค่าจัดส่ง
                                                        </div>
                                                        <div class="col-md-6 d-flex  justify-content-end">
                                                            ฿ <?php
                                                                if ($row_2['get_add_price'] != NULL) {
                                                                    echo number_format($row_2['get_add_price']);
                                                                } else {
                                                                    echo '0';
                                                                }
                                                                ?>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <!-- <div class="d-flex justify-content-center p-4">


                                                        <nav aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                <li class="breadcrumb-item"><a href="#">ดูรายการอะไหล่</a></li>
                                                            </ol>
                                                        </nav>
                                                    </div> -->

                                                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">ดูรายการอะไหล่</button>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                <?php
                                } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="accordion accordion" id="accordionFlushExample" style="background-color: #F1F1F1;">
                            <div class="accordion-item" style="background-color: #f1f1f1;">
                                <div id="bounce-item" style="background-color: #f1f1f1;">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="background-color: #f1f1f1;border:1px solid #CACACA" aria-expanded="false" aria-controls="flush-collapseOne" onclick="return MiniStatus()">
                                            <font>
                                                <br>
                                                <h2 style="margin-left: 1.2rem;" class="auto-font-head">ติดตามสถานะ (Status)</h2>
                                                <div id="ShowMiniOfStatus" style="display: none;">
                                                    <span id="tooltip">ย่อรายละเอียดสถานะ</span>
                                                </div>
                                                <div id="MiniDetailStatus" style="display: block;">
                                                    <span id="tooltip">กดเพื่อดูสถานะทั้งหมด</span>
                                                    <hr width="100%">
                                                    <?php
                                                    $sql_lastest = "SELECT * FROM `repair_status` WHERE del_flg = '0' AND get_r_id = ' $id_get_r' ORDER BY rs_date_time DESC LIMIT 1";
                                                    $result_lastest = mysqli_query($conn, $sql_lastest);
                                                    $row_lastest = mysqli_fetch_array($result_lastest);
                                                    $status_id_last = $row_lastest['status_id'];

                                                    $sql_lastest_status = "SELECT * FROM `status_type` WHERE del_flg = '0' AND status_id = '$status_id_last'";
                                                    $result_lastest_status = mysqli_query($conn, $sql_lastest_status);
                                                    $row_lastest_status = mysqli_fetch_array($result_lastest_status);


                                                    ?>
                                                    <p>สถานะล่าสุด : <span style="background-color:<?= $row_lastest_status['status_color']  ?>;color:white" class="btn btn-light"><?= $row_lastest_status['status_name'] . ' ' ?>
                                                            <?php if ($row_lastest_status['status_id'] == 6) {
                                                                echo '#ครั้งที่ ' . $row_carry_out[0];
                                                            } ?>
                                                        </span></p>
                                                    <span>วันที่ : <?= date('d F Y', strtotime($row_lastest['rs_date_time'])); ?> <span style="display:inline-block;color : gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row_lastest['rs_date_time'])); ?></span> </span>
                                                    <span>
                                                    </span>
                                                    <p>
                                                        <br>
                                                        <a href="#" style="color:gray;">ดูรายละเอียดเพิ่มเติม ...</a>
                                                    </p>
                                                </div>
                                            </font>
                                        </button>
                                    </h2>
                                </div>
                                <script>
                                    var i = 0;

                                    function MiniStatus() {
                                        i += 1;
                                        if ((i % 2) == 0) {
                                            ShowStatus()
                                        } else {
                                            ShowMiniStatus()
                                        }
                                    }

                                    function ShowStatus() {
                                        var miniDetailStatus = document.getElementById("MiniDetailStatus");
                                        var showMiniOfStatus = document.getElementById("ShowMiniOfStatus");

                                        miniDetailStatus.style.opacity = "0"; // Set initial opacity to 0 for fade-in effect
                                        miniDetailStatus.style.display = "block"; // Show the element
                                        document.getElementById("MiniDetailStatusSuc").style.display = "block";

                                        // Triggering reflow to apply initial styles before the animation
                                        void miniDetailStatus.offsetWidth;

                                        miniDetailStatus.style.transition = "opacity 0.5s";
                                        miniDetailStatus.style.opacity = "1"; // Fade-in effect

                                        showMiniOfStatus.style.transition = "opacity 0.5s";
                                        showMiniOfStatus.style.opacity = "0"; // Fade-out effect after 0.5 seconds

                                        setTimeout(function() {
                                            showMiniOfStatus.style.display = "none"; // Hide the element after fade-out
                                        }, 500); // 0.5 seconds (the same duration as the fade-out transition)
                                    }

                                    function ShowMiniStatus() {
                                        var miniDetailStatus = document.getElementById("MiniDetailStatus");
                                        var showMiniOfStatus = document.getElementById("ShowMiniOfStatus");

                                        showMiniOfStatus.style.opacity = "0"; // Set initial opacity to 0 for fade-in effect
                                        showMiniOfStatus.style.display = "block"; // Show the element
                                        document.getElementById("MiniDetailStatusSuc").style.display = "none";

                                        // Triggering reflow to apply initial styles before the animation
                                        void showMiniOfStatus.offsetWidth;

                                        showMiniOfStatus.style.transition = "opacity 0.5s";
                                        showMiniOfStatus.style.opacity = "1"; // Fade-in effect

                                        miniDetailStatus.style.transition = "opacity 0.5s";
                                        miniDetailStatus.style.opacity = "0"; // Fade-out effect after 0.5 seconds

                                        setTimeout(function() {
                                            miniDetailStatus.style.display = "none"; // Hide the element after fade-out
                                        }, 500); // 0.5 seconds (the same duration as the fade-out transition)
                                    }
                                </script>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <div class="container my-5 p-4" style="background-color: #F1F1F1; border-radius : 1%;">
                                            <?php if ($row_2['status_id'] == 3) { ?>
                                                <div class="alert alert-success" role="alert">
                                                    <i class="fa fa-check-square"></i> ดำเนินการซ่อมเสร็จสิ้น
                                                </div>
                                            <?php }  ?>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="timeline-3">
                                                        <?php
                                                        $i = 0;
                                                        $count_carry_out = $row_carry_out[0]; // ครั้งทีซ่อมทั้งหมด
                                                        $count_offer =  $row_offer_c[0]; // ครั้งทีเสนอราคาทั้งหมด
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

                                                            if ($status_id = 13) {
                                                                $cancel_id = 13;
                                                            }

                                                            $sql_c = "SELECT * FROM repair_status WHERE get_r_id = '$id_get_r' AND del_flg = 0 ORDER BY rs_id DESC";
                                                            $result_c = mysqli_query($conn, $sql_c);
                                                            $row_p = mysqli_fetch_array($result_c);
                                                        ?>
                                                            <li class="shadow" <?php if ($i == 1) {
                                                                                ?> style="background-color: #FFFF;margin-left:20px" <?php
                                                                                                                                } else {
                                                                                                                                    ?>style="margin-left:20px" <?php
                                                                                                                                                            } ?>>
                                                                <div>
                                                                    <!-- <hr style="border: 3px solid black;"> -->
                                                                    <br>
                                                                    <h4 style="display:inline">
                                                                        <h4 style="color : <?= $row1['status_color'] ?>;"><?= $row1['status_name'] ?>

                                                                            <?php if ($row1['status_id'] == 6 && $count_carry_out > 0) {
                                                                            ?><u style="color:gray"><?= '#ครั้งที่ ' . $count_carry_out ?></u><?php
                                                                                                                                                $count_carry_out--;
                                                                                                                                            }
                                                                                                                                            if ($row1['status_id'] == 17 && $count_offer > 0) {
                                                                                                                                                ?><u style="color:gray"><?= '#ครั้งที่ ' . $count_offer ?></u><?php
                                                                                                                                                                                                                $count_offer--;
                                                                                                                                                                                                            }

                                                                                                                                                                                                                ?>
                                                                            <?php if ($row1['status_id'] == 6) {

                                                                                // $carry_out_id = $row['status_id'];
                                                                                // $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = 155 AND status_id = 6 ORDER BY rs_date_time DESC;";
                                                                                // $result_carry_out = mysqli_query($conn, $sql_cary_out);
                                                                                // $row_carry_out = mysqli_fetch_array($result_carry_out);

                                                                                if ($row_carry_out[0] > 1) { ?>
                                                                                    <!-- #ครั้งที่<?= $row_carry_out[0] - $count_carry_out ?> -->
                                                                            <?php }
                                                                                $count_carry_out += 1;
                                                                            } ?>
                                                                        </h4>
                                                                    </h4>

                                                                    <h6 style="display:inline;"><i class="uil uil-book"></i>&nbsp;<?= $formattedDate ?></h6>
                                                                    <p style="display:inline-block;color : gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row1['rs_date_time'])); ?></p>
                                                                    <br>
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
                                                                            if ($row1['status_id'] == 9 || $row1['status_id'] == 10) {  ?>
                                                                                <a class="btn btn-outline-danger" style="margin-left: 20px" href="#" onclick="openModalPart('quantitypart')">จำนวนอะไหล่</a>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <!-- <a class="btn btn-outline-danger" style="margin-left: 20px" href="#" onclick="openModalPart('quantitypart')">ดูจำนวนอะไหล่ที่ต้องใช้</a> -->
                                                                            <?php }
                                                                        }
                                                                    }
                                                                    if ($row1['status_id'] == 8 || $row1['status_id'] == 26  && $row1['rs_conf'] == NULL) {

                                                                        $sql_check_pay = "SELECT * FROM repair_status WHERE del_flg = 0 AND get_r_id = $id_get_r  ORDER BY rs_id DESC LIMIT 1";
                                                                        $result_check_pay = mysqli_query($conn, $sql_check_pay);
                                                                        $row_check_pay = mysqli_fetch_array($result_check_pay);

                                                                        if ($row1['status_id'] == 26) {
                                                                            ?>
                                                                            <a href="form_pay.php?id=<?= $id_get_r ?>" class="btn btn-primary">ส่งหลักฐานการชำระเงิน</a>
                                                                        <?php
                                                                        } elseif ($row_check_pay['status_id'] == 8) {
                                                                        ?>
                                                                            <a href="form_pay.php?id=<?= $id_get_r ?>" class="btn btn-primary">ทำการชำระเงิน</a>
                                                                        <?php
                                                                        }
                                                                    }
                                                                    if ($row1['get_track'] != NULL && $row1['status_id'] == 24) { ?>
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
                                                                    }
                                                                    if ($row1['status_id'] == 4 || $row1['status_id'] == 17 && $row1['rs_conf'] == NULL || $row1['rs_conf'] == 1) { ?>
                                                                        <div>
                                                                            <?php if ($row1['rs_cancel_detail'] != NULL) {
                                                                            ?>
                                                                                <div class="col text-left alert alert-danger">
                                                                                    <!-- <hr> -->
                                                                                    <h5 class="f-red-5">เหตุผลไม่ยืนยันการซ่อม</h5>
                                                                                    <p style="margin-left: 30px;"><?= $row1['rs_cancel_detail'] ?></p>
                                                                                </div>
                                                                            <?php
                                                                            } ?>
                                                                            <?php if ($check_order  == 0) { ?>
                                                                                <hr>
                                                                                <h6 class="text-primary">รายการที่สามารถซ่อมได้</h6>
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
                                                                    <h5 class="f-gray-5">รายละเอียด</h5>
                                                                    <p class="mt-2" style="margin-left: 30px;"><?= $row1['rs_detail'] ?></p>
                                                                    <?php
                                                                    if ($row1['status_id'] == 5  && $row1['rs_conf'] == NULL) {
                                                                    }
                                                                    if ($row1['status_id'] == 4 || $row1['status_id'] == 17 && $row1['rs_conf'] == NULL || $row1['rs_conf'] == 1) {
                                                                        $total =  $row1['get_wages'] + $row1['get_add_price'];
                                                                    ?><?php if ($check_order  == 0) { ?>

                                                                    <?php if ($row1['get_date_conf'] != NULL) {  ?>
                                                                        <p class="mt-2" style="margin-left: 30px;"> - ระยะเวลาซ่อม <?= number_format($row1['get_date_conf']) ?> วัน <span style="color:red">( นับจากวันที่รับอุปกรณ์ )</span></p>
                                                                    <?php }  ?>
                                                                    <?php if ($row1['get_wages'] != NULL) {  ?>
                                                                        <p class="mt-2" style="margin-left: 30px;"> - ค่าแรงช่าง <?= number_format($row1['get_wages']) ?> บาท
                                                                            </span></p>
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
                                                                        repair_detail.p_id,
                                                                        parts.p_brand,
                                                                        parts.p_model,
                                                                        parts.p_price,
                                                                        parts_type.p_type_name,
                                                                        parts.p_pic;
                                                                    
                                                                                ";
                                                                            $result_c = mysqli_query($conn, $sql_c);
                                                                            while ($row_c = mysqli_fetch_array($result_c)) {
                                                                                $total_part += $row_c['p_price'];
                                                                            }
                                                                            if ($total_part > 0) {  ?>
                                                                        <p class="mt-2" style="margin-left: 30px;display:inline"> - ค่าอะไหล่ <?= $total_part ?> บาท</span></p> <a onclick="openModalPart('quantitypart')" style="display:inline; color:red"><u>ดูอะไหล่ที่ต้องใช้</u></a>
                                                                    <?php }  ?>
                                                                    <h5 class="alert alert-primary" style="margin-left: 30px;">รวมราคา <?= number_format($total + $total_part) ?> บาท</span></h3>
                                                                <?php
                                                                        }
                                                                        $check_order = 1;
                                                                    }
                                                                    // if ($row1['rs_cancel_detail'] != NULL) {  
                                                                ?>
                                                                <!-- <h5 class="btn btn-outline-danger">เหตุผลการไม่ยืนยัน</h5>
                                                                <p class="mt-2"><?= $row1['rs_cancel_detail'] ?></p> -->
                                                                <?php
                                                                //  } 
                                                                ?>
                                                                <div class="col text-left" style="background-color: #F1F1F1;">
                                                                    <?php
                                                                    $sql_pic = "SELECT * FROM repair_pic WHERE rs_id = $rs_id AND del_flg = 0 ";
                                                                    $result_pic = mysqli_query($conn, $sql_pic);
                                                                    $row_pic_check = mysqli_fetch_array($result_pic);

                                                                    if ($row_pic_check[0] > 0) { ?>
                                                                        <hr>
                                                                        <h5 class="f-gray-5">รูปภาพประกอบ</h5>
                                                                        <br>
                                                                    <?php
                                                                    }
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
                                                                </span>
                                                                <!-- <?php if ($i == 1) {
                                                                        ?>
                                                                    <br><br><br>
                                                                <?php
                                                                        } ?> -->
                                                                <br>
                                                                <?php
                                                                if ($row1['status_id'] == 13 && $row1['rs_conf'] == NULL && $row1['rs_cancel_detail'] == NULL) {
                                                                    $sql_null = "SELECT * FROM repair_status WHERE get_r_id ='$get_r_id' AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1";
                                                                    $result_null = mysqli_query($conn, $sql_null);
                                                                    $row_null = mysqli_fetch_array($result_null);
                                                                    if ($row_null['rs_conf'] == NULL) {
                                                                        $sql_null1 = "SELECT * FROM repair_status WHERE get_r_id ='$get_r_id' AND del_flg = 0  ORDER BY rs_id DESC LIMIT 1";
                                                                        $result_null1 = mysqli_query($conn, $sql_null1);
                                                                        $row_null1 = mysqli_fetch_array($result_null1);
                                                                        if ($row_null1['status_id'] == 13) {
                                                                ?>
                                                                            <!-- 13 in -->
                                                                            <hr>
                                                                            <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p>

                                                                            <a style="margin-left: 2%" id="UnconfirmButtonConfAfterDoingInStatus" class="btn btn-danger">ไม่ทำการยืนยัน</a>
                                                                            <a class="btn btn-success" id="confirmButtonConfAfterDoingInStatus" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม</a>
                                                                            <br><br>
                                                                <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($row1['status_id'] == 17 && $row1['rs_conf'] == NULL && $row1['rs_cancel_detail'] == NULL) {
                                                                    $sql_null = "SELECT * FROM repair_status WHERE get_r_id ='$get_r_id' AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1";
                                                                    $result_null = mysqli_query($conn, $sql_null);
                                                                    $row_null = mysqli_fetch_array($result_null);
                                                                    if ($row_null['rs_conf'] == NULL) {
                                                                ?>
                                                                        <!-- 13 in -->
                                                                        <hr>
                                                                        <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p>
                                                                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalUnique">
                                                                            ไม่ทำการยืนยัน/ยื่นข้อเสนอ
                                                                        </a>
                                                                        <!-- <a class="btn btn-danger" style="margin-left: 2%" onclick="showDiv()">ไม่ทำการยืนยัน/ยื่นข้อเสนอ</a> -->
                                                                        <!-- <a class="btn btn-success" id="confirmButtonSuccess" style="display:inline-block">ยืนยันการส่งซ่อม</a> -->
                                                                        <a class="btn btn-success" id="confirmButtonSuccess0" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม</a>
                                                                        <br><br>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
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
                                                                if ($row1['status_id'] == 13 && $row1['rs_conf'] != 1 && $row1['rs_conf'] != 0) {
                                                                    $sql_null = "SELECT * FROM repair_status WHERE get_r_id ='$get_r_id' AND del_flg = 0  AND status_id = 13 ORDER BY rs_id DESC LIMIT 1";
                                                                    $result_null = mysqli_query($conn, $sql_null);
                                                                    $row_null = mysqli_fetch_array($result_null);
                                                                    if ($row_null['rs_conf'] == NULL) {
                                                                    ?>
                                                                        <hr>
                                                                        <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p>

                                                                        <a style="margin-left: 2%" onclick="showDiv(); return MiniStatus()" class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">ไม่ทำการยืนยัน</a>
                                                                        <a class="btn btn-success" id="confirmButtonSuccess1" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม</a>

                                                                        <br><br>
                                                                    <?php

                                                                    }
                                                                }
                                                                $sql_c_offer = "SELECT * FROM repair_status WHERE status_id = '19' AND del_flg = '0' AND get_r_id = $id_get_r ORDER BY rs_date_time DESC LIMIT 1";
                                                                $result_c_offer = mysqli_query($conn, $sql_c_offer);
                                                                $row_c_offer = mysqli_fetch_array($result_c_offer);

                                                                $sql_conf = "SELECT * FROM repair_status WHERE del_flg = '0' AND get_r_id = $id_get_r ORDER BY rs_date_time DESC LIMIT 1";
                                                                $result_conf = mysqli_query($conn, $sql_conf);
                                                                $row_conf = mysqli_fetch_array($result_conf);
                                                                if ($row[0] > 0 || $status_id == 1) {
                                                                    if ($row1['rs_conf'] == NULL) { ?>
                                                                        <?php if ($status_id == 1 && !isset($cancel_id)) {
                                                                        ?>
                                                                            <p style="margin-left: 2%; color:red">*** หากต้องการยกเลิกคำส่งซ่อม ***</p>
                                                                            <a class="btn btn-danger" style="margin-left: 2%" onclick="showDivCancel()">ยกเลิก</a>
                                                                            <?php
                                                                        } else if ($status_id != 1 && isset($cancel_id) && $row_2['status_id'] != 14 && $status_id_last == 4 && $status_id_last == 17) {
                                                                            if ($row_conf['rs_conf'] == NULL) {
                                                                            ?>
                                                                                <hr>
                                                                                <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p>
                                                                                <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalUnique">
                                                                                    ไม่ทำการยืนยัน/ยื่นข้อเสนอ
                                                                                </a>
                                                                                <!-- <a class="btn btn-danger" style="margin-left: 2%" onclick="showDiv()">ไม่ทำการยืนยัน/ยื่นข้อเสนอ</a> -->
                                                                                <!-- <a class="btn btn-success" id="confirmButtonSuccess" style="display:inline-block">ยืนยันการส่งซ่อม</a> -->
                                                                                <a class="btn btn-success" id="confirmButtonSuccess0" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม</a>
                                                                                <br><br>
                                                                        <?php
                                                                            }
                                                                        } ?>
                                                                        <!-- Add your button href="action/conf_part.php?id=<?= $id_get_r ?>" -->
                                                                        <!-- <a  class="btn btn-success" id="confirmButtonSuccess">ยืนยัน</a> -->
                                                                        <!-- <button class="btn btn-success" id="confirmButtonSuccess">ยืนยัน</button> -->
                                                                        <!-- <script>
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
                                                                    </script> -->
                                                                        <div id="myDiv" style="display: none; margin: 20px 30px;">

                                                                        </div>

                                                                        <div id="cancel_status_1" style="display: none; margin: 20px 30px;">
                                                                            <form id="canf_cancel_1" action="action/status_non_del_part.php" method="POST">
                                                                                <hr>

                                                                                <h4 style="color: red">โปรดระบุเหตุผลที่ยกเลิกของคุณ</h4>
                                                                                <input type="text" name="get_r_id" value="<?= $id_get_r ?>" hidden>
                                                                                <input type="text" name="status_id" value="12" hidden>
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

                                                                                <textarea class="auto-expand" id="myTextarea" name="detail_cancel" style="display: none;" placeholder="โปรดระบุสาเหตุ"></textarea>

                                                                                <br>
                                                                                <a class="btn btn-danger" onclick="Cancel_Start()">ยกเลิก</a>
                                                                                <a class="btn btn-success" id="confirmButtoncancel1">ยืนยัน</a>

                                                                                <script>
                                                                                    document.addEventListener('DOMContentLoaded', function() {
                                                                                        var id_get_r = <?php echo json_encode($id_get_r); ?>; // Pass PHP variable to JavaScript
                                                                                        var dialogShown = false; // Flag variable to track if the dialog is already displayed

                                                                                        document.getElementById('confirmButtoncancel1').addEventListener('click', function() {
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
                                                                                                    var form = document.getElementById('canf_cancel_1');
                                                                                                    form.submit(); // Submit the form
                                                                                                }

                                                                                                dialogShown = false; // Reset the flag when the dialog is closed
                                                                                            });
                                                                                        });
                                                                                    });
                                                                                </script>

                                                                            </form>
                                                                            <br><br>
                                                                        </div>
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
                                                                    <br><br>
                                                                    <!-- <button class="btn btn-success" style="margin-left : 10px"> คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ" </button> -->
                                                                <?php } else if ($row1['rs_conf'] == 4 && $row1['status_id'] == 8) {  ?>
                                                                    <div class="alert alert-primary" role="alert" style="margin-left : 10px">
                                                                        คุณได้ทำการส่งที่อยู่ไปให้พนักงานแล้ว "โปรดรอการตอบกลับการชำระเงินอีกครั้ง"
                                                                    </div>
                                                                    <span class="check_icon"><i class="fa fa-check"></i> ส่งวันที่ : <?= $row1['rs_conf_date'] ?></span>
                                                                    <br><br>
                                                                    <!-- <button class="btn btn-success" style="margin-left : 10px"> คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ" </button> -->
                                                                <?php } else if ($row1['rs_conf'] == 1 && $row1['status_id'] == 24) {  ?>
                                                                    <div class="alert alert-success" role="alert" style="margin-left : 10px">
                                                                        คุณได้ทำการตรวจสอบและยอมรับแล้ว
                                                                    </div>
                                                                    <span class="check_icon"><i class="fa fa-check"></i> ส่งวันที่ : <?= $row1['rs_conf_date'] ?></span>
                                                                    <br><br>
                                                                    <!-- <button class="btn btn-success" style="margin-left : 10px"> คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ" </button> -->
                                                                <?php } else if ($row1['rs_conf'] == 1) {  ?>

                                                                    <div class="alert alert-success" role="alert" style="margin-left : 10px">
                                                                        คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ"
                                                                    </div>
                                                                    <span class="check_icon"><i class="fa fa-check"></i> ส่งวันที่ : <?= $row1['rs_conf_date'] ?></span>
                                                                    <br><br>
                                                                    <!-- <button class="btn btn-success" style="margin-left : 10px"> คุณได้ทำการยืนยันการส่งซ่อมแล้ว "โปรดรอการตอบกลับ" </button> -->
                                                                <?php } else if ($row1['rs_conf'] == 0 && $row1['rs_conf'] != NULL) {
                                                                ?>
                                                                    <div class="alert alert-success" role="alert" style="margin-left : 10px">
                                                                        คุณได้ทำการยืนยันการยกเลิกแล้ว "โปรดรอการตอบกลับ"
                                                                    </div>
                                                                    <span class="check_icon"><i class="fa fa-check"></i> ส่งวันที่ : <?= $row1['rs_conf_date'] ?></span>
                                                                    <br><br>
                                                            <?php
                                                                }
                                                            } ?>
                                                            </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <!-- <hr> -->
                        <!-- ปุ่มทำการยกเลิก -->
                        <?php if ($status_id_last  == 1 || $status_id_last  == 2) { ?>
                            <div class="d-flex justify-content-center">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header " id="flush-headingThree">
                                            <button style="background-color:#B90000;color:white;" class="accordion-button collapsed btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                ยกเลิกคำสั่งซ่อม
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" style="background-color:#f1f1f1;" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body" style="width:700px;">
                                                <form action="action/status_non_del_part.php" method="POST" id="cancel">
                                                    <label for="exampleFormControlInput1" class="form-label">กรุณากรอกรายละเอียดการยกเลิก</label>
                                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="***ไม่จำเป็น" name="rs_detail">
                                                    <input type="text" name="get_r_id" value="<?= $id_get_r ?>" hidden>
                                                    <input type="text" name="status_id" value="12" hidden>
                                                    <br>
                                                    <center>
                                                        <a class="btn btn-success" style="margin: 1%;" onclick="showConfirmationDialog()">ยืนยันการยกเลิก</a>
                                                    </center>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php


                        } elseif ($status_id_last  == 4) {
                            $sql_null = "SELECT * FROM repair_status WHERE get_r_id ='$get_r_id' AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1";
                            $result_null = mysqli_query($conn, $sql_null);
                            $row_null = mysqli_fetch_array($result_null);
                            if ($row_null['rs_conf'] == NULL) {
                            ?>
                                <!-- <hr> -->
                                <!-- <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p> -->
                                <center>
                                    <hr>
                                    <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p>

                                    <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalUnique">
                                        ไม่ทำการยืนยัน/ยื่นข้อเสนอ
                                    </a>
                                    <a class="btn btn-success" id="confirmButtonSuccess1" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม</a>
                                </center>
                            <?php
                            }
                        } elseif ($status_id_last  == 13) {
                            $sql_null = "SELECT * FROM repair_status WHERE get_r_id ='$get_r_id' AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1";
                            $result_null = mysqli_query($conn, $sql_null);
                            $row_null = mysqli_fetch_array($result_null);
                            if ($row_null['rs_conf'] == NULL) {
                            ?>
                                <center>
                                    <hr>
                                    <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p>

                                    <a style="margin-left: 2%" id="UnconfirmButtonConfAfterDoing" class="btn btn-danger">ไม่ทำการยืนยัน</a>
                                    <a class="btn btn-success" id="confirmButtonConfAfterDoing" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม</a>
                                </center>
                            <?php
                            }
                        } elseif ($status_id_last  == 24) { ?>
                            <!-- <hr> -->
                            <center>
                                <p style="margin-left: 2%; color:red">*** ตรวจเช็คความปกติของอุปกรณ์ของท่านว่าใช้ได้หรือไม่ก่อนทำการยืนยันเสร็จสิ้นการซ่อม ***</p>
                                <a class="btn btn-danger" style="margin-left: 2%" href="send_config.php?id=<?= $id_get_r ?>">แจ้งเจ้าหน้าที่กรณีมีปัญหาฟหกฟห</a>
                                <a class="btn btn-success" style="margin-left: 2%" onclick="showConfirmation()">ยืนยัน</a>
                            </center>
                        <?php
                        } elseif ($status_id_last  == 17  && $row_2['rs_conf'] == NULL) { ?>
                            <!-- <hr> -->
                            <!-- <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p> -->
                            <?php
                            $sql_c_offer = "SELECT * FROM repair_status WHERE status_id = '19' AND del_flg = '0' AND get_r_id = $id_get_r ORDER BY rs_date_time DESC LIMIT 1";
                            $result_c_offer = mysqli_query($conn, $sql_c_offer);
                            $row_c_offer = mysqli_fetch_array($result_c_offer);

                            $sql_conf = "SELECT * FROM repair_status WHERE del_flg = '0' AND get_r_id = $id_get_r ORDER BY rs_date_time DESC LIMIT 1";
                            $result_conf = mysqli_query($conn, $sql_conf);
                            $row_conf = mysqli_fetch_array($result_conf);

                            if ($row_c_offer[0] > 0 && $row_conf['rs_conf'] == NULL) {

                            ?>
                                <center>
                                    <a style="margin-left: 2%" class="btn btn-danger mr-4" data-bs-toggle="modal" data-bs-target="#exampleModalUnique">
                                        ไม่ทำการยืนยัน/ยื่นข้อเสนอ
                                    </a>
                                    <a class="btn btn-success" id="confirmButtonSuccess1" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม</a>

                                </center>
                                <?php
                            } else {
                                if ($row_conf['rs_conf'] == NULL) {
                                ?> <center>
                                        <a style="margin-left: 2%" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalUnique">
                                            ไม่ทำการยืนยัน/ยื่นข้อเสนอ
                                        </a> <a class="btn btn-success" id="confirmButtonSuccess1" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม5</a>

                                    </center>
                            <?php }
                            }
                        } elseif ($status_id_last  == 9) {
                            ?>
                            <center>
                                <a style="margin-left: 2%" href="send_config.php?id=<?= $get_id ?>" class="btn btn-danger">ส่งคำร้อง</a>
                                <button class="btn btn-success" href="action/add_only_status.php?id=<?= $id_get_r ?>&status_id=3" style="display:inline-block" onclick="showConfirmation()">ยืนยันและตรวจสอบอุปกรณ์แล้ว</button>



                                <script>
                                    function showConfirmation() {
                                        Swal.fire({
                                            title: 'ยืนยันและตรวจสอบอุปกรณ์แล้ว?',
                                            text: 'คุณต้องการยืนยันและตรวจสอบอุปกรณ์แล้วหรือไม่?',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#28a745', // Green color
                                            cancelButtonColor: '#6c757d', // Gray color
                                            confirmButtonText: 'ยืนยัน',
                                            cancelButtonText: 'ยกเลิก'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // If confirmed, proceed with the link redirection
                                                window.location.href = "action/add_only_status.php?id=<?= $id_get_r ?>&status_id=3";
                                            }
                                        });
                                    }
                                </script>

                            </center>
                        <?php
                        } elseif ($status_id_last  == 20) {
                        ?>
                            <center>
                                <p style="margin-left: 2%; color:red">*** หากท่านต้องการยกเลิกคำร้องกด "ยืนยัน" ***</p>
                                <a class="btn btn-success" style="margin-left: 2%" onclick="showConfirmationOff()">ยืนยัน / ยกเลิกคำร้อง</a>
                                <script>
                                    function showConfirmationOff() {
                                        Swal.fire({
                                            title: 'ต้องการยกเลิกคำร้องหรือไม่',
                                            text: 'หากคุณกดยืนยัน สถานะจะเปลี่ยนเป็น "สำเร็จ" และคำร้องของท่านจะเป็นโมฆะ',
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
                            </center>
                        <?php
                        } elseif ($status_id_last  == 4 && $row_2['rs_conf'] != NULL) { ?>
                            <div class="d-flex justify-content-center">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header " id="flush-headingThree">
                                            <button style="background-color:#B90000;color:white;" class="accordion-button collapsed btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                ยกเลิกคำสั่งซ่อม
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" style="background-color:#f1f1f1;" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body" style="width:700px;">
                                                <form action="action/status_non_del_part.php" method="POST" id="cancel">
                                                    <label for="exampleFormControlInput1" class="form-label">กรุณากรอกรายละเอียดการยกเลิก</label>
                                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="***ไม่จำเป็น" name="rs_detail">
                                                    <input type="text" name="get_r_id" value="<?= $id_get_r ?>" hidden>
                                                    <input type="text" name="status_id" value="12" hidden>
                                                    <br>
                                                    <center>
                                                        <a class="btn btn-success" style="margin: 1%;" onclick="showConfirmationDialog()">ยืนยันการยกเลิก</a>
                                                    </center>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } elseif ($status_id_last  == 4 || $status_id_last  == 17 && $row_2['rs_conf'] != NULL) { ?>
                            <div class="d-flex justify-content-center">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingThree">
                                            <button style="background-color:#B90000;color:white;" class="accordion-button collapsed btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                ยกเลิกคำสั่งซ่อม
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" style="background-color:#f1f1f1;" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body" style="width:700px;">
                                                <form action="action/status_non_del_part.php" method="POST" id="cancel">
                                                    <label for="exampleFormControlInput1" class="form-label">กรุณากรอกรายละเอียดการยกเลิก</label>
                                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="***ไม่จำเป็น" name="rs_detail">
                                                    <input type="text" name="get_r_id" value="<?= $id_get_r ?>" hidden>
                                                    <input type="text" name="status_id" value="12" hidden>
                                                    <br>

                                                    <script>
                                                        function showConfirmationDialog() {
                                                            // Display a SweetAlert confirmation dialog
                                                            Swal.fire({
                                                                title: "คุณแน่ใจหรือไม่ว่าต้องการยกเลิก?",
                                                                text: "การทำรายการนี้จะไม่สามารถย้อนกลับได้",
                                                                icon: "warning",
                                                                showCancelButton: true,
                                                                confirmButtonColor: "#3085d6",
                                                                cancelButtonColor: "#d33",
                                                                confirmButtonText: "ยืนยัน",
                                                                cancelButtonText: "ยกเลิก"
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    // User clicked "ยืนยัน," you can proceed with the cancellation action
                                                                    // You can submit the form using JavaScript here
                                                                    document.getElementById("cancel").submit();
                                                                } else {
                                                                    // User clicked "ยกเลิก," do nothing or handle as needed
                                                                }
                                                            });
                                                        }
                                                    </script>

                                                    <center>
                                                        <button type="button" class="btn btn-success" style="margin: 1%;" onclick="showConfirmationDialog()">ยืนยันการยกเลิก</button>
                                                    </center>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <script>
                                function showConfirmationDialog() {
                                    swal({
                                        title: "ยืนยันการยกเลิก",
                                        text: "คุณต้องการยกเลิกหรือไม่?",
                                        icon: "warning",
                                        buttons: ["ยกเลิก", "ยืนยัน"],
                                        dangerMode: true,
                                    }).then((willCancel) => {
                                        if (willCancel) {
                                            // The user confirmed the cancellation, you can proceed with the cancellation logic here
                                            document.getElementById("cancel").submit(); // Submit the form with the id "cancel"
                                        } else {
                                            // The user clicked "Cancel," do nothing
                                        }
                                    });
                                }
                            </script> -->



                        <?php   } ?>



                        <!-- <button class="btn btn-danger" style="margin: 1%;">ยกเลิกคำสั่งซ่อม</button> -->

                    </div>
                </div>
            </div>
            <br>
            <br>

            <!-- Main Status Data  -->
            <div class="container my-5 p-4" style="background-color: #F1F1F1; border-radius : 1%;display:none">
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

                                if ($status_id = 13) {
                                    $cancel_id = 13;
                                }

                                $sql_c = "SELECT * FROM repair_status WHERE get_r_id = '$id_get_r' AND del_flg = 0 ORDER BY rs_id DESC";
                                $result_c = mysqli_query($conn, $sql_c);
                                $row_p = mysqli_fetch_array($result_c);
                            ?>
                                <li>
                                    <hr style="border: 5px solid black;">
                                    <h4 style="display:inline">
                                        <h4 style="color : <?= $row1['status_color'] ?>;"><?= $row1['status_name'] ?>
                                            <?php if ($row1['status_id'] == 6) {

                                                // $carry_out_id = $row['status_id'];
                                                // $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = 155 AND status_id = 6 ORDER BY rs_date_time DESC;";
                                                // $result_carry_out = mysqli_query($conn, $sql_cary_out);
                                                // $row_carry_out = mysqli_fetch_array($result_carry_out);

                                                if ($row_carry_out[0] > 1) { ?>
                                                    #ครั้งที่<?= $row_carry_out[0] - $count_carry_out ?>
                                            <?php }
                                                $count_carry_out += 1;
                                            } ?></h4>
                                    </h4>

                                    <h6 style="display:inline;"><i class="uil uil-book"></i>&nbsp;<?= $formattedDate ?></h6>
                                    <p style="display:inline-block;color : gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row1['rs_date_time'])); ?></p>
                                    <br><?php
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
                                                if ($row1['status_id'] == 9 || $row1['status_id'] == 10) {  ?>
                                                <a class="btn btn-outline-danger" style="margin-left: 20px" href="#" onclick="openModalPart('quantitypart')">จำนวนอะไหล่</a>
                                            <?php
                                                } else {
                                            ?>
                                                <a class="btn btn-outline-danger" style="margin-left: 20px" href="#" onclick="openModalPart('quantitypart')">ดูจำนวนอะไหล่ที่ต้องใช้</a>
                                        <?php }
                                            }
                                        }
                                        if ($row1['status_id'] == 8 && $row1['rs_conf'] == NULL) { ?>
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
                                    <?php }
                                    if ($row1['status_id'] == 4 || $row1['status_id'] == 17 && $row1['rs_conf'] == NULL || $row1['rs_conf'] == 1) {

                                    ?> <div>

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
                                            <?php }
                                            }  ?>
                                        </div>
                                    <?php  } ?>
                                    <hr>
                                    <h5 class="f-gray-5">รูปภาพประกอบ</h5>
                                    <p class="mt-2" style="margin-left: 30px;"><?= $row1['rs_detail'] ?></p>
                                    <?php
                                    if ($row1['status_id'] == 5  && $row1['rs_conf'] == NULL) {
                                    }
                                    if ($row1['status_id'] == 4 || $row1['status_id'] == 17 && $row1['rs_conf'] == NULL || $row1['rs_conf'] == 1) {
                                        $total =  $row1['get_wages'] + $row1['get_add_price'];
                                        if ($check_order  == 0) { ?>

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
                                            if ($total_part > 0) {  ?>
                                                <p class="mt-2" style="margin-left: 30px;display:inline"> - ค่าอะไหล่ <?= $total_part ?> บาท</span></p> <a onclick="openModalPart('quantitypart')" style="display:inline; color:red"><u>ดูอะไหล่ที่ต้องใช้</u></a>
                                            <?php }  ?>
                                            <h5 class="alert alert-primary" style="margin-left: 30px;">รวมราคา <?= number_format($total + $total_part) ?> บาท</span></h3>
                                            <?php
                                        }
                                        $check_order = 1;
                                    }
                                    if ($row1['rs_cancel_detail'] != NULL) {  ?>
                                            <h5 class="btn btn-outline-danger">เหตุผลการไม่ยืนยัน</h5>
                                            <p class="mt-2"><?= $row1['rs_cancel_detail'] ?></p>
                                        <?php  } ?>
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

                                    <br>
                                    <?php
                                }
                                if ($row[0] > 0 || $status_id == 1) {
                                    if ($row1['rs_conf'] == NULL) { ?>
                                        <?php if ($status_id == 1 && !isset($cancel_id)) {
                                        ?>
                                            <p style="margin-left: 2%; color:red">*** หากต้องการยกเลิกคำส่งซ่อม ***</p>
                                            <a class="btn btn-danger" style="margin-left: 2%" onclick="showDivCancel()">ยกเลิก</a>
                                        <?php
                                        } else if ($status_id != 1 && isset($cancel_id)) {
                                        ?>
                                            <hr>
                                            <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p>
                                            <!-- Button trigger modal -->
                                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalUnique">
                                                ไม่ทำการยืนยัน/ยื่นข้อเสนอ
                                            </a>
                                            <!-- <a class="btn btn-danger" style="margin-left: 2%" onclick="showDiv()">ไม่ทำการยืนยัน/ยื่นข้อเสนอ</a> -->
                                            <a class="btn btn-success" id="confirmButtonSuccess" style="display:inline-block">ยืนยันการส่งซ่อม</a>
                                        <?php
                                        } ?>

                                        <div id="myDiv" style="display: none; margin: 20px 30px;">
                                            <br>
                                            <form id="canf_cancel" action="action/conf_cancel.php" method="POST">
                                                <hr>

                                                <h4 style="color: red">โปรดระบุเหตุผล</h4>
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

                                                <textarea class="auto-expand" id="myTextarea" name="detail_cancel" style="display: none;" placeholder="โปรดระบุสาเหตุ"></textarea>

                                                <br>

                                                <a class="btn btn-success" id="confirmButtoncancel">ยืนยัน</a>
                                                <a class="btn btn-danger" onclick="hideDiv()">ยกเลิก</a>

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
                                                                    var form = document.getElementById('canf_cancel_offer');
                                                                    form.submit(); // Submit the form
                                                                }

                                                                dialogShown = false; // Reset the flag when the dialog is closed
                                                            });
                                                        });
                                                    });
                                                </script>

                                            </form>
                                            <br><br>
                                        </div>

                                        <div id="cancel_status_1" style="display: none; margin: 20px 30px;">
                                            <form id="canf_cancel_1" action="action/status_non_del_part.php" method="POST">
                                                <hr>

                                                <h4 style="color: red">โปรดระบุเหตุผลที่ยกเลิกของคุณ</h4>
                                                <input type="text" name="get_r_id" value="<?= $id_get_r ?>" hidden>
                                                <input type="text" name="status_id" value="12" hidden>
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

                                                <textarea class="auto-expand" id="myTextarea" name="detail_cancel" style="display: none;" placeholder="โปรดระบุสาเหตุ"></textarea>

                                                <br>
                                                <a class="btn btn-danger" onclick="Cancel_Start()">ยกเลิก</a>
                                                <a class="btn btn-success" id="confirmButtoncancel1">ยืนยัน</a>

                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        var id_get_r = <?php echo json_encode($id_get_r); ?>; // Pass PHP variable to JavaScript
                                                        var dialogShown = false; // Flag variable to track if the dialog is already displayed

                                                        document.getElementById('confirmButtoncancel1').addEventListener('click', function() {
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
                                                                    var form = document.getElementById('canf_cancel_1');
                                                                    form.submit(); // Submit the form
                                                                }

                                                                dialogShown = false; // Reset the flag when the dialog is closed
                                                            });
                                                        });
                                                    });
                                                </script>

                                            </form>
                                            <br><br>
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

                                            function showDivCancel() {
                                                var div = document.getElementById("cancel_status_1");
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

                                            function Cancel_Start() {
                                                var div = document.getElementById("cancel_status_1");
                                                var conf = document.getElementById("confirmButtonSuccess");
                                                div.style.display = "none";
                                                conf.style.display = "inline-block";
                                            }
                                        </script>


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
        <?php include('footer/footer.php'); ?>
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
        <script>
            var status_id = 0;

            function sendValue(value) {
                // Do something with the value
                status_id = value; // Update the global status_id variable
            }

            document.addEventListener('DOMContentLoaded', function() {
                var id_get_r = <?= $id_get_r ?>; // Pass PHP variable to JavaScript

                document.getElementById('confirmButtonSuccess1').addEventListener('click', function() {
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

            document.addEventListener('DOMContentLoaded', function() {
                var id_get_r = <?= $id_get_r ?>; // Pass PHP variable to JavaScript

                document.getElementById('confirmButtonConfAfterDoing').addEventListener('click', function() {
                    Swal.fire({
                        icon: 'question',
                        title: 'ยืนยันดำเนินการส่งซ่อม',
                        text: 'การ "ยืนยัน" จะไม่สามารถกลับมาแก้ไขข้อมูลได้?',
                        showCancelButton: true,
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((willConfirm) => {
                        if (willConfirm.isConfirmed) {
                            window.location.href = "action/conf_after_doing.php?id=" + id_get_r + "&status_id=" + status_id; // Redirect with the passed value
                        }
                    });
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                var id_get_r = <?= $id_get_r ?>; // Pass PHP variable to JavaScript

                document.getElementById('confirmButtonConfAfterDoingInStatus').addEventListener('click', function() {
                    Swal.fire({
                        icon: 'question',
                        title: 'ยืนยันดำเนินการส่งซ่อม',
                        text: 'การ "ยืนยัน" จะไม่สามารถกลับมาแก้ไขข้อมูลได้?',
                        showCancelButton: true,
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((willConfirm) => {
                        if (willConfirm.isConfirmed) {
                            window.location.href = "action/conf_after_doing.php?id=" + id_get_r + "&status_id=" + status_id; // Redirect with the passed value
                        }
                    });
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                var id_get_r = <?= $id_get_r ?>; // Pass PHP variable to JavaScript

                // Get both elements by their IDs
                var button1 = document.getElementById('UnconfirmButtonConfAfterDoing');
                var button2 = document.getElementById('UnconfirmButtonConfAfterDoingInStatus');

                // Add the click event listener to either of the buttons
                button1.addEventListener('click', handleButtonClick);
                button2.addEventListener('click', handleButtonClick);

                function handleButtonClick() {
                    Swal.fire({
                        title: 'เพิ่มเหตุผลการปฏิเสธของคุณ',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'ส่งข้อมูลของคุณ',
                        showLoaderOnConfirm: true,
                        cancelButtonText: 'ยกเลิก',
                        cancelButtonColor: '#CE3500',
                        preConfirm: (login) => {
                            // Construct the URL with the parameters you want to send
                            const status_id = '13'; // Replace with the actual value
                            const url = `action/conf_after_doing.php?id=${id_get_r}&status_id=${status_id}&cancel=${login}`;

                            // Navigate to the constructed URL
                            window.location.href = url;
                        },
                    });
                }
            });



            document.addEventListener('DOMContentLoaded', function() {
                var id_get_r = <?= $id_get_r ?>; // Pass PHP variable to JavaScript

                document.getElementById('confirmButtonSuccess0').addEventListener('click', function() {
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

            document.addEventListener('DOMContentLoaded', function() {
                var id_get_r = <?= $id_get_r ?>; // Pass PHP variable to JavaScript

                document.getElementById('confirmButtonSuccess1').addEventListener('click', function() {
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
        <script>
            var status_id = 0;

            function sendValuetoArrived(value) {
                // Do something with the value
                status_id = value; // Update the global status_id variable
            }

            document.addEventListener('DOMContentLoaded', function() {
                var id_get_r = <?= $id_get_r ?>; // Pass PHP variable to JavaScript

                document.getElementById('confirmButtonCheck').addEventListener('click', function() {
                    Swal.fire({
                        icon: 'question',
                        title: 'ยืนยันดำเนินการส่งซ่อม',
                        text: 'การ "ยืนยัน" จะไม่สามารถกลับมาแก้ไขข้อมูลได้?',
                        showCancelButton: true,
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((willConfirm) => {
                        if (willConfirm.isConfirmed) {
                            window.location.href = "action/conf_part_arrived.php?id=" + id_get_r + "&status_id=19"; // Redirect with the passed value
                        }
                    });
                });
            });
        </script>

        </script>



        <!-- Cancel Button -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var id_get_r = <?php echo json_encode($id_get_r); ?>; // Pass PHP variable to JavaScript
                var status_id = 17; // Pass PHP variable to JavaScript

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

            function showDivCancel() {
                var div = document.getElementById("cancel_status_1");
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

            function Cancel_Start() {
                var div = document.getElementById("cancel_status_1");
                var conf = document.getElementById("confirmButtonSuccess");
                div.style.display = "none";
                conf.style.display = "inline-block";
            }
        </script>
</body>

</html>
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

$id_g = $_GET['id'];
$sql1 = "SELECT * FROM get_repair 
LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
LEFT JOIN repair ON repair.r_id = get_detail.r_id
WHERE repair.m_id = '$id' AND get_repair.get_r_id = '$id_g' 
GROUP BY get_repair.get_r_id
ORDER BY get_r_date_in DESC;";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);

$sql2 = "SELECT * FROM repair_status 
WHERE repair_status.get_r_id = '$id_g' AND status_id = 8
ORDER BY repair_status.rs_date_time DESC LIMIT 1;";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2);

$get_add_price = $row1['get_add_price'];

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
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?= $get_add_price ?>Status - ANE</title>

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
    </style>
</head>

<body>

    <!--  Part modal -->
    <div id="payModal" class="modal">
        <div class="modal-content">
            <h2>จำนวนอะไหล่ทั้งหมด</h2>
            <button class="close-button btn btn-primary" onclick="closeModalPay('pay')" width="200px">
                <i class="fa fa-times"></i>
            </button>
            <!-- content for Part modal -->
            <iframe src="pay_qr.php?id=<?php echo $id_g; ?>" style="width: 100%; height: 1000px;"></iframe>
        </div>
    </div>

    <div id="payaddModal" class="modal">
        <div class="modal-content">
            <h2>จำนวนอะไหล่ทั้งหมด</h2>
            <button class="close-button btn btn-primary" onclick="closeModalPay('payadd')" width="200px">
                <i class="fa fa-times"></i>
            </button>
            <!--  content for Part modal -->
            <iframe src="pay_qr.php?id=<?php echo $id_g; ?>&get_add=<?= $get_add_price ?>" style="width: 100%; height: 1000px;" class="no-scrollbar"></iframe>

        </div>
    </div>
    <script src="script.js"></script>

    <?php
    $part_check = 0;
    if ($row1 > 0) {
        include('bar/topbar_user.php');
    } ?>
    <form id="payment_data" action="action/add_payment.php" method="POST" enctype="multipart/form-data">
        <!-- <form id="payment_data" action="action/add_payment.php" method="POST" enctype="multipart/form-data" style="display: none;"> -->

        <div class="card" style="width: 100%;">
            <div class="card-body">
                <br>
                <br>
                <br>
                <br>
                <!-- <h1 class="alert alert-primary" role="alert">กรุณากรอกข้อมูลการชำระเงินและการจัดส่ง</h1> -->

                <div id="card_style">
                    <div class="container">
                        <h1 class="alert alert-primary" role="alert">ชำระเงิน หมายเลขส่งซ่อมที่ : <?= $id_g ?></h1>
                        <br>
                        <br>
                        <div style="display:none">
                            <h3 class="alert alert-secondary"><a class="btn btn-primary">ขั้นตอนที่ 1</a> : ดูข้อมูลส่วนตัวของท่านให้ครบถ้วน <span style="color:red; font-size:18px">*** หากไม่ถูกต้องกรุณาทำการแก้ไขที่ "หน้าแก้ไขข้อมูล" ***</span></h3>
                            <br>
                            <div class="row alert alert-light" style="background-color: white; padding : 10px;">


                                <div class="col-4">
                                    <!-- First Name Here  -->
                                    <label for="basic-url" class="form-label">ชื่อจริง</label>
                                    <div class="input-group mb-3">
                                        <!-- <span class="input-group-text" id="basic-addon3">ชื่อจริง</span> -->
                                        <input type="text" name="fname" class="form-control" id="basic-url" aria-describedby="basic-addon3" value="<?= $_SESSION['fname'] ?>" required readonly>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <!-- Last Name Here  -->
                                    <label for="basic-url" class="form-label">นามสกุล</label>
                                    <div class="input-group mb-3">
                                        <!-- <span class="input-group-text" id="basic-addon3">นามสกุล</span> -->
                                        <input type="text" name="lname" class="form-control" id="basic-url" aria-describedby="basic-addon3" value="<?= $_SESSION['lname'] ?>" required readonly>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <!-- Last Name Here  -->
                                    <label for="basic-url" class="form-label">เบอร์โทรศัพท์</label>
                                    <div class="input-group mb-3">
                                        <!-- <span class="input-group-text" id="basic-addon3">นามสกุล</span> -->
                                        <input type="text" class="form-control" name="tel" id="basic-url" aria-describedby="basic-addon3" value="<?= $_SESSION['tel'] ?>" required readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <h3 class="alert alert-secondary"><a class="btn btn-success">ขั้นตอนที่ 1</a> : เลือกวิธีการจัดส่งและชำระค่าบริการ</h3>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <center>
                                    <!-- <h5>เลือกวิธีการจัดส่งที่ท่านต้องการ</h5> -->
                                </center>
                                <br>
                            </div>
                            <?php 
                            $sql_c = "SELECT * FROM get_repair WHERE get_r_id = '$id_g' AND del_flg = '0'";
                            $result_c = mysqli_query($conn ,$sql_c);
                            $row_c = mysqli_fetch_array($result_c);
                            
                            if ($row_c['get_deli'] == 0) { ?>
                                <div class="col-6 d-flex justify-content-start">
                                    <a class="btn btn-success" onclick="showAddress()" id="add_button_pay">ดูรายละเอียดของท่าน</a>
                                    <a class="btn btn-danger" id="cancel_pay_button" style="display:none" onclick="showPayClose()">ยกเลิก</a>
                                </div> <?php
                                    } else { ?>
                                <div class="col-6 d-flex justify-content-end">
                                    <a class="btn btn-primary" id="non_add_button" onclick="showPay()">ดูรายละเอียดของท่าน</a>
                                    <a class="btn btn-danger" id="cancel_add_button" style="display:none" onclick="showAddressClose()">ยกเลิก</a>
                                </div>
                            <?php
                                    } ?>
                            <!-- <div class="col-6 d-flex justify-content-end">
                                <a class="btn btn-primary" id="non_add_button" onclick="showPay()">มารับที่ร้าน</a>
                                <a class="btn btn-danger" id="cancel_add_button" style="display:none" onclick="showAddressClose()">ยกเลิก</a>
                            </div>
                            <div class="col-6 d-flex justify-content-start">
                                <a class="btn btn-success" onclick="showAddress()" id="add_button_pay">จัดส่งผ่านไปรษณีย์</a>
                                <a class="btn btn-danger" id="cancel_pay_button" style="display:none" onclick="showPayClose()">ยกเลิก</a>
                            </div> -->
                        </div>

                        <br>
                        <hr>
                        <div class="row">
                            <div class="mb-3" style="display: none" id="show_pay">
                                <div class="alert alert-primary" role="alert">
                                    <h5>มารับอุปกรณ์ที่ร้านด้วยตัวเอง</h5>
                                </div>
                                <br>
                                <label for="exampleFormControlTextarea1" class="form-label">
                                    <h6>กรุณาดูรายละเอียดการชำระเงินของท่าน : </h6>
                                </label>

                                <a class="btn btn-primary" style="margin-left: 20px" href="#" onclick="openModalPay('pay')">ดูบิลใบเสร็จเพื่อชำระค่าบริการ</a>
                                <br>
                                <center>
                                    <!-- <a class="btn btn-primary" style="margin-left: 20px" href="#" onclick="openModalPay('pay')">ชำระค่าบริการ</a> -->
                                </center>
                                <br>
                                <hr>
                                <br>
                                <h3 class="alert alert-secondary"><a class="btn btn-danger">ขั้นตอนที่ 2</a> : แนบสลิปหรือหลักฐานการโอนเงิน</h3>
                                <br>
                                <div class="row">
                                    <div class="col-2"> </div>
                                    <div class="col-8">
                                        <center>
                                            <h4 class="alert alert-primary">เมื่อ ชำระค่าบริการ เสร็จสิ้นให้ท่านแนบสลิป</h4>
                                        </center>
                                    </div>
                                    <div class="col-2"> </div>
                                </div>

                                <div class="row">
                                    <!-- Image Here -->

                                    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                                    <div class="file-upload">
                                        <!-- <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">แนบหลักฐานการชำระเงิน</button> -->

                                        <div class="image-upload-wrap">
                                            <input class="file-upload-input" type='file' name="conf_img" onchange="readURL(this);" accept="image/*" />
                                            <div class="drag-text">
                                                <h3>Drag and drop a file or select add Image</h3>
                                            </div>
                                        </div>
                                        <div class="file-upload-content">
                                            <img class="file-upload-image" src="#" alt="your image" onclick="openModal(this)" />
                                            <div class="image-title-wrap">
                                                <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                                            </div>
                                        </div>
                                        <br><br>
                                        <center>
                                            <input type="text" name="action" value="0" id="action-to-form" required hidden>
                                            <input type="text" name="get_r_id" value="<?= $id_g ?>" required hidden>
                                            <!-- <a class="btn btn-success" onclick="confirmPayment_Add()">ชำระเงินแล้ว</a> -->
                                            <a class="btn btn-danger" onclick="confirmPayment()">ชำระเงินแล้ว</a>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </form>
    <br>
    <div class="container">
        <div class="row">
            <!-- Address Here -->
            <div class="mb-3" style="display: none" id="show_address">
                <div class="alert alert-success" role="alert">
                    <h5>ต้องการให้จัดส่งอุปกรณ์ของท่าน</h5>
                </div>
                <br>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
                <?php

                mysqli_query($conn, "SET NAMES 'utf8' ");
                error_reporting(error_reporting() & ~E_NOTICE);
                date_default_timezone_set('Asia/Bangkok');

                $sql_provinces = "SELECT * FROM provinces";
                $query = mysqli_query($conn, $sql_provinces);

                ?>
                <form id="addressForm" action="action/add_address.php" method="POST">
                    <div class="form-group" style="display:none">
                        <label for="sel1">จังหวัด:</label>
                        <select class="form-control" name="Ref_prov_id" id="provinces">
                            <option value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
                            <?php foreach ($query as $value) { ?>
                                <option value="<?= $value['id'] ?>"><?= $value['name_th'] ?></option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="sel1">อำเภอ:</label>
                        <select class="form-control" name="Ref_dist_id" id="amphures" required>
                        </select>
                        <br>

                        <label for="sel1">ตำบล:</label>
                        <select class="form-control" name="Ref_subdist_id" id="districts" required>
                        </select>
                        <br>

                        <label for="sel1">รหัสไปรษณีย์:</label>
                        <input type="text" name="zip_code" id="zip_code" class="form-control" required>
                        <br>
                        <input type="text" name="get_r_id" value="<?= $id_g ?>" required hidden>
                        <br>
                        <label for="exampleFormControlTextarea1" class="form-label">กรุณากรอกที่อยู่ที่ต้องการจัดส่ง</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" required><?= $_SESSION['address'] ?></textarea>
                    </div>

                    <?php include('script.php'); ?>
                    <br>
                    <center>
                        <!-- <h5 style="color:red">*** เมื่อใส่รายละเอียดที่อยู่แล้ว ทางร้านจะทำการประเมินราคาค่าจัดส่งมาให้อักครั้งภายใน 1-2 วัน ***</h5> -->
                        <br>
                        <a class="btn btn-primary" style="margin-left: 20px" type="submi" onclick="openModalPay('payadd')">ดูบิลใบเสร็จเพื่อชำระค่าบริการ</a>
                        <!-- <a onclick="confirmPayment_Add()" class="btn btn-success" type="submit" style="margin-left: 20px;">ยืนยัน</a> -->
                    </center>

                </form>
                <div class="row">
                    <div class="mb-3" id="show_pay" style="display:block">
                        <br>
                        <hr>
                        <br>
                        <h3 class="alert alert-secondary"><a class="btn btn-danger">ขั้นตอนที่ 3</a> : แนบสลิปหรือหลักฐานการโอนเงิน</h3>
                        <br>
                        <div class="row">
                            <div class="col-2"> </div>
                            <div class="col-8">
                                <center>
                                    <h4 class="alert alert-primary">เมื่อ ชำระค่าบริการ เสร็จสิ้นให้ท่านแนบสลิป</h4>
                                </center>
                            </div>
                            <div class="col-2"> </div>
                        </div>
                        <div class="row">
                            <!-- Image Here -->
                            <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                            <form id="deli_add" action="action/add_payment.php" method="POST" enctype="multipart/form-data">
                                <div class="file-upload">
                                    <!-- <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">แนบหลักฐานการชำระเงิน</button> -->
                                    <div class="image-upload-wrap">
                                        <input class="file-upload-input" type='file' name="conf_img" onchange="readURL(this);" accept="image/*" />
                                        <div class="drag-text">
                                            <h3>Drag and drop a file or select add Image</h3>
                                        </div>
                                    </div>
                                    <div class="file-upload-content">
                                        <img class="file-upload-image" src="#" alt="your image" onclick="openModal(this)" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                                        </div>
                                    </div>
                                    <br><br>
                                    <center>
                                        <input type="text" name="action" value="0" id="action-to-form" required hidden>
                                        <input type="text" name="get_r_id" value="<?= $id_g ?>" required hidden>
                                        <!-- <a class="btn btn-success" onclick="confirmPayment_Add()">ชำระเงินแล้ว</a> -->
                                        <a class="btn btn-success" onclick="confirmPayment_deli_add()">ชำระเงินแล้ว</a>
                                    </center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
            </div>
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
    </script>

    <!-- Your other HTML content -->

    <script>
        function confirmPayment() {
            Swal.fire({
                title: 'ยืนยันการชำระเงิน',
                // text: 'คุณแน่ใจหรือไม่ที่ต้องการที่จะทำการชำระเงินแล้ว?',
                text: 'โปรดตรวจสอบข้อมูลทั้งหมดของคุณว่าถูกต้องแล้ว1?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ชำระเงินแล้ว',
                cancelButtonText: 'ไม่, ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form
                    document.getElementById('payment_data').submit();
                }
            });
        }

        function confirmPayment_deli_add() {
            Swal.fire({
                title: 'ยืนยันการชำระเงิน',
                // text: 'คุณแน่ใจหรือไม่ที่ต้องการที่จะทำการชำระเงินแล้ว?',
                text: 'โปรดตรวจสอบข้อมูลทั้งหมดของคุณว่าถูกต้องแล้ว1?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ชำระเงินแล้ว',
                cancelButtonText: 'ไม่, ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form
                    document.getElementById('deli_add').submit();
                }
            });
        }

        function confirmPayment_Add() {
            Swal.fire({
                title: 'ยืนยันที่อยู่ในการจัดส่งของคุณ',
                // text: 'คุณแน่ใจหรือไม่ที่ต้องการที่จะทำการชำระเงินแล้ว?',
                text: 'พนักงานจะทำการคำนวณค่าจัดส่ง และจะตอบกลับท่านภายใน 1-2 วัน?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ชำระเงินแล้ว',
                cancelButtonText: 'ไม่, ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form
                    document.getElementById('addressForm').submit();
                }
            });
        }

        function confirmPayment_Address() {
            Swal.fire({
                title: 'ยืนยันที่อยู่ในการจัดส่งของคุณ',
                // text: 'คุณแน่ใจหรือไม่ที่ต้องการที่จะทำการชำระเงินแล้ว?',
                text: 'พนักงานจะทำการคำนวณค่าจัดส่ง และจะตอบกลับท่านภายใน 1-2 วัน?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ส่งข้อมูล',
                cancelButtonText: 'ไม่, ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form
                    document.getElementById('addressFormAdd').submit();
                }
            });
        }
    </script>
    <script>
        function openModal(img) {
            var modal = document.getElementById("modal");
            var modalImg = document.getElementById("modal-image");
            modal.style.display = "block";
            modalImg.src = img.src;
            modalImg.style.width = "60%"; // Set the width to 1000 pixels
            modalImg.style.borderRadius = "2%"; // Set the border radius to 20%
            modal.classList.add("show");
        }

        function closeModal() {
            var modal = document.getElementById("modal");
            modal.style.display = "none";
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

        function showPay() {
            document.getElementById('show_pay').style.display = 'block';
            document.getElementById('add_button_pay').style.display = 'none';
            document.getElementById('cancel_pay_button').style.display = 'block';
            document.getElementById('button_pay_non_add').style.display = 'block';
            document.getElementById('pay_not_add').style.display = 'block';
        }

        function showPayClose() {
            document.getElementById('show_pay').style.display = 'none';
            document.getElementById('add_button_pay').style.display = 'block';
            document.getElementById('cancel_pay_button').style.display = 'none';
            document.getElementById('button_pay_non_add').style.display = 'none';
            document.getElementById('pay_not_add').style.display = 'none';

        }

        function showAddress() {
            document.getElementById('show_address').style.display = 'block';
            document.getElementById('non_add_button').style.display = 'none';
            document.getElementById('cancel_add_button').style.display = 'block';
            document.getElementById('button_pay_add').style.display = 'block';
            document.getElementById('pay_not_add').style.display = 'none';
            // document.getElementById('detail_value_code').style.display = 'none';
        }

        function showAddressClose() {
            document.getElementById('show_address').style.display = 'none';
            document.getElementById('non_add_button').style.display = 'block';
            document.getElementById('cancel_add_button').style.display = 'none';
            document.getElementById('button_pay_add').style.display = 'none';
            document.getElementById('pay_not_add').style.display = 'none';
        }
    </script>
</body>

</html>
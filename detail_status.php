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
    <link rel="stylesheet" href="css/detail_status.css">
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Status - ANE</title>

    <!-- Example CDNs, use appropriate versions and sources -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

    // check status Process Bar
    $process_dot = 0;
    $allowedStatusIds1 = [1, 2];
    $allowedStatusIds2 = [5];
    $allowedStatusIds3 = [4, 17, 19];
    $allowedStatusIds4 = [6, 13];
    $allowedStatusIds5 = [7, 8];
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

    $sql_c = "SELECT * FROM get_detail
    LEFT JOIN get_repair ON get_detail.get_r_id = get_repair.get_r_id 
    LEFT JOIN repair ON repair.r_id = get_detail.r_id WHERE get_repair.get_r_id = '$id_get_r' AND repair.del_flg = '0'";
    $result_c = mysqli_query($conn, $sql_c);
    $row_c = mysqli_fetch_array($result_c);

    $get_add_price = $row_c['get_add_price']; ?>
    <br><br>
    <div class="px-5 pt-5 repair">
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
        <div class="container">
            <div id="MiniDetailStatusSuc" style="display: block;">
                <?php if ($row_2['status_id'] == 3) { ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-square"></i> ดำเนินการซ่อมเสร็จสิ้น
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md">
                    <div class="container px-md-4 py-5 mx-auto">
                        <div class="card" id="process-status">
                            <div class="row p-4">
                                <div class="d-flex">
                                    <h5>หมายเลขส่งซ่อมที่ <span class="text-primary font-weight-bold">#<?= $id_get_r ?></span></h5>
                                </div>
                                <div class="d-flex flex-column text-sm-right">
                                    <p class="mb-0">วันที่ยื่นเรื่อง : <?= date('d F Y', strtotime($row_2['rs_date_time'])); ?><span style="display:inline-block; color: gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row_2['rs_date_time'])); ?></span></p>
                                </div>
                            </div>

                            <!-- Add class 'active' to progress -->
                            <div class="row d-flex justify-content-center">
                                <div class="col-12">
                                    <ul id="progressbar" class="text-center">
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

                                </div>

                            </div>
                            <!-- <div class="d-flex justify-content-end p-4" style="display:none">
                            <a href="" id="button-status">ดูอะไหล่ที่ต้องใช้</a>
                            <a onclick="openModalPart('quantitypart')" id="button-status">ดูอะไหล่ที่ต้องใช้</a>
                            <a class="btn btn-outline-danger" style="margin-left: 20px" href="#" onclick="openModalPart('quantitypart')">ดูจำนวนอะไหล่ที่ต้องใช้</a>
                            <a href="" id="button-status">รายละเอียด</a>
                        </div> -->
                            <div class="d-flex justify-content-end p-4">


                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">ดูอะไหล่ที่ต้องใช้</a></li>
                                        <li class="breadcrumb-item"><a href="#">รายละเอียด</a></li>
                                        <!-- <li class="breadcrumb-item active" aria-current="page">Data</li> -->
                                    </ol>
                                </nav>
                            </div>
                            <span id="tooltip">ข้อมูลการซ่อมของคุณ</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container px-md-4 py-5 mx-auto">
                        <div class="card" style="height: 100%;width:100%;">
                            <div class="card-body">
                                <font>
                                    <h5 style="font-style : i">
                                        <i class="fa fa-map-marker" style="margin-right:1%"></i> ที่อยู่ในการจัดส่ง
                                    </h5>
                                    <div style="margin-left : 5%; color : gray">
                                        <p>
                                            <?= $row1['m_fname'] . ' ' . $row1['m_lname'] ?>

                                            (+66)<?= $row_2['get_tel'] ?>
                                            <!-- <?= $row_2['get_add'] ?> -->
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
                                    </div>
                                </font>
                                <hr>
                                <font>
                                    <h5><i class="fa fa-shield"></i> วิธีการรับอุปกรณ์</h5>
                                </font>
                                <p style="margin-left : 5%;color : gray">
                                    <?php
                                    if ($row_2['get_deli'] == 0) {
                                        echo 'รับอุปกรณ์ที่ร้าน';
                                    } else {
                                        echo 'จัดส่งอุปกรณ์ผ่านขนส่ง';
                                    }
                                    ?>
                                </p>
                                <hr>
                                <div class="accordion-item" id="totalprice">
                                    <div>
                                        <h5 class="accordion-header" id="flush-headingTwo">
                                            <br>
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                <h5>
                                                    รวมการสั่งซ่อม 150 บาท
                                                </h5>
                                            </button>
                                        </h5>
                                    </div>

                                    <span id="tooltip">กดเพื่อดูรายละเอียดเพิ่มเติม</span>

                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body" style="margin-left : 0%;color : gray">
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6 d-flex  justify-content-start">
                                                    ค่าอะไหล่
                                                </div>
                                                <div class="col-md-6 d-flex  justify-content-end">
                                                    ฿150
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 d-flex  justify-content-start">
                                                    ค่าแรง
                                                </div>
                                                <div class="col-md-6 d-flex  justify-content-end">
                                                    ฿150
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 d-flex  justify-content-start">
                                                    ค่าจัดส่ง
                                                </div>
                                                <div class="col-md-6 d-flex  justify-content-end">
                                                    ฿150
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <hr>
            <a href="">ascasc</a>
            <a href="">asdasd</a>
            <hr> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion accordion" id="accordionFlushExample" style="background-color: #F1F1F1;">
                        <div class="accordion-item">
                            <div id="bounce-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" style="background-color: #f1f1f1;;" aria-expanded="false" aria-controls="flush-collapseOne" onclick="return MiniStatus()">
                                        <font>
                                            <br>
                                            <h2 style="margin-left: 1.2rem;">ติดตามสถานะ (Status)</h2>
                                            <div id="ShowMiniOfStatus" style="display: none;">
                                                <span id="tooltip">ย่อรายละเอียดสถานะ</span>
                                            </div>
                                            <div id="MiniDetailStatus" style="display: block;">
                                                <span id="tooltip">กดเพื่อดูสถานะทั้งหมด</span>
                                                <hr>
                                                <?php
                                                $sql_lastest = "SELECT * FROM `repair_status` WHERE del_flg = '0' AND get_r_id = ' $id_get_r' ORDER BY rs_date_time DESC LIMIT 1";
                                                $result_lastest = mysqli_query($conn, $sql_lastest);
                                                $row_lastest = mysqli_fetch_array($result_lastest);
                                                $status_id_last = $row_lastest['status_id'];

                                                $sql_lastest_status = "SELECT * FROM `status_type` WHERE del_flg = '0' AND status_id = '$status_id_last'";
                                                $result_lastest_status = mysqli_query($conn, $sql_lastest_status);
                                                $row_lastest_status = mysqli_fetch_array($result_lastest_status);
                                                ?>
                                                <p>สถานะล่าสุด : <span style="background-color:<?= $row_lastest_status['status_color']  ?>;color:white" class="btn btn-light"><?= $row_lastest_status['status_name'] ?></span></p>
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
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col">
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
                                                            <hr style="border: 3px solid black;">
                                                            <h5 style="display:inline"><button class="btn btn-outline-secondary" style="color : white; background-color : <?= $row1['status_color'] ?>; border : 2px solid <?= $row1['status_color'] ?>;"><?= $row1['status_name'] ?>
                                                                    <?php if ($row1['status_id'] == 6) {

                                                                        $carry_out_id = $row['status_id'];
                                                                        $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = 155 AND status_id = 6 ORDER BY rs_date_time DESC;";
                                                                        $result_carry_out = mysqli_query($conn, $sql_cary_out);
                                                                        $row_carry_out = mysqli_fetch_array($result_carry_out);

                                                                        if ($row_carry_out[0] > 1) { ?>
                                                                            #ครั้งที่<?= $row_carry_out[0] - $count_carry_out ?>
                                                                    <?php }
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
                                                                <p class="mt-2" style="margin-left: 30px;display:inline"> - ค่าอะไหล่ <?= $total_part ?> บาท</span></p> <a onclick="openModalPart('quantitypart')" style="display:inline; color:red">ดูอะไหล่ที่ต้องใช้</a>
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

                                                            if ($row_pic_check[0] > 0) { ?>
                                                                <hr>
                                                                <h6 class="btn btn-outline-secondary">รูปภาพประกอบ</h6>
                                                                <br><br>
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
                                                                    <a class="btn btn-danger" style="margin-left: 2%" onclick="showDiv()">ไม่ทำการยืนยัน</a>
                                                                    <a class="btn btn-success" id="confirmButtonSuccess" style="display:inline-block">ยืนยันการส่งซ่อม</a>
                                                                <?php
                                                                } ?>


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




                                                                <div id="myDiv" style="display: none; margin: 20px 30px;">
                                                                    <br>
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

                                                                        <textarea id="myTextarea" name="detail_cancel" style="display: none;" placeholder="โปรดระบุสาเหตุ"></textarea>

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
                                                        }
                                                    } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
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
                                <h5 style="display:inline"><button class="btn btn-outline-secondary" style="color : white; background-color : <?= $row1['status_color'] ?>; border : 2px solid <?= $row1['status_color'] ?>;"><?= $row1['status_name'] ?>
                                        <?php
                                        if ($row1['status_id'] == 6) {

                                            $carry_out_id = $row['status_id'];
                                            $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = 155 AND status_id = 6 ORDER BY rs_date_time DESC;";
                                            $result_carry_out = mysqli_query($conn, $sql_cary_out);
                                            $row_carry_out = mysqli_fetch_array($result_carry_out);

                                            if ($row_carry_out[0] > 1) {
                                        ?> #ครั้งที่<?= $row_carry_out[0] - $count_carry_out ?>
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

                                ?> <div> <?php if ($check_order  == 0) { ?>
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
                                <h5 class="btn btn-outline-primary">รายละเอียด</h5>
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
                                            <p class="mt-2" style="margin-left: 30px;display:inline"> - ค่าอะไหล่ <?= $total_part ?> บาท</span></p> <a onclick="openModalPart('quantitypart')" style="display:inline; color:red">ดูอะไหล่ที่ต้องใช้</a>
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
                                        <a class="btn btn-danger" style="margin-left: 2%" onclick="showDiv()">ไม่ทำการยืนยัน</a>
                                        <a class="btn btn-success" id="confirmButtonSuccess" style="display:inline-block">ยืนยันการส่งซ่อม</a>
                                    <?php
                                    } ?>
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
                                    <div id="myDiv" style="display: none; margin: 20px 30px;">
                                        <br>
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

                                            <textarea id="myTextarea" name="detail_cancel" style="display: none;" placeholder="โปรดระบุสาเหตุ"></textarea>

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
        <?php include('footer/footer.php'); ?>
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
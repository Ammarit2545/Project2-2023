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

    $rs_lastest_id = $row_2['rs_id'];

    $carry_out_id = $row['status_id'];
    $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = '$id_get_r' AND status_id = 6 AND del_flg = 0 ORDER BY rs_date_time DESC;";
    $result_carry_out = mysqli_query($conn, $sql_cary_out);
    $row_carry_out = mysqli_fetch_array($result_carry_out);

    // check parts of Get_r_id
    $sql_c_part = "SELECT *
    FROM `repair_detail`
    LEFT JOIN get_detail ON repair_detail.get_d_id = get_detail.get_d_id
    LEFT JOIN get_repair ON get_repair.get_r_id = get_detail.get_r_id
    LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id
    WHERE get_repair.get_r_id = '$id_get_r' AND repair_detail.del_flg = '0'
    GROUP BY repair_detail.p_id; ";
    $result_c_part = mysqli_query($conn, $sql_c_part);
    while ($row_c_part = mysqli_fetch_array($result_c_part)) {
        $total_part_price +=  $row_c_part['rd_parts_price'];
    }

    // check status Process Bar
    $process_dot = 0;
    $allowedStatusIds1 = [1, 2];
    $allowedStatusIds2 = [4, 5, 17];
    $allowedStatusIds3 = [19];
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
    <div style="background-color: <?= $row_2['status_color'] ?>;height:200px;padding:7%;color:white">
        <?php if ($row_2['status_id'] == 1) { ?>
            <h3><i class="fa fa-check-square-o"></i> คุณได้ทำการส่งเรื่องแล้ว</h3>
            <p>โปรดรอการตอบกลับจากพนักงาน<br>หากคุณต้องการยกเลิกคำสั่งซ่อมสามารถทำการ <span style="color:white">"ยกเลิก"</span> ได้</p>

        <?php  } ?>
        <?php if ($row_2['status_id'] == 19) { ?>
            <h3><i class="fa fa-check-square-o"></i> พนักงานได้รับอุปกรณ์ของคุณแล้ว</h3>
            <p>โปรดรอการตรวจเช็คจากพนักงานภายใน 1-2 วัน</p>
        <?php  } ?>
        <?php if ($row_2['status_id'] == 6) { ?>
            <h3><i class="fa fa-check-square-o"></i> พนักงานได้ทำการซ่อมอุปกรณ์ให้คุณแล้วในขณะนี้</h3>
            <?php
            $sql_date = "SELECT rs_date_time,get_date_conf FROM `repair_status` 
            LEFT JOIN get_repair ON get_repair.get_r_id = repair_status.get_r_id
            WHERE repair_status.get_r_id = '$id_get_r' AND status_id = 6 ORDER BY rs_date_time ASC;";
            $result_date = mysqli_query($conn, $sql_date);
            $row_date = mysqli_fetch_array($result_date);
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
                <?php if ($row_2['status_id'] == 4 || $row_2['status_id'] == 17) {
                    if ($row_2['rs_conf'] == NULL) {  ?>
                        <div class="alert alert-warning" role="alert">
                            <p>
                                <i class="fa fa-exclamation-triangle"></i>
                                ตรวจสอบรายละเอียดให้ครบถ้วนเพื่อผลประโยชน์ของท่านเอง
                                <a type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    <u>ดูอะไหล่ที่ต้องใช้</u>
                                </a>
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
                                    $sql_count_repair = "SELECT * FROM get_detail 
                                                        LEFT JOIN repair ON get_detail.r_id = repair.r_id
                                                        WHERE get_detail.get_r_id = '$id_get_r' AND get_detail.del_flg = 0;";
                                    $result_count_repair  = mysqli_query($conn, $sql_count_repair);
                                    while ($row_count_repair = mysqli_fetch_array($result_count_repair)) {
                                        $count_com += 1;
                                    ?>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <h5><span class="badge bg-secondary"><?= $count_com ?></span><?= ' ' . $row_count_repair['r_brand'] . ' ' . $row_count_repair['r_model'] . ' ' ?><span class="badge bg-primary"><?= ' ' . $row_count_repair['r_serial_number'] ?></h5></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="formGroupExampleInput" class="form-label">กรุณาเลือกผู้ให้บริการ</label>
                                                <select class="form-select" aria-label="Default select example" name="com_t_id_<?= $count_com ?>" required>
                                                    <option value="" disabled selected>เลือกบริษัทขนส่ง</option>
                                                    <?php
                                                    $sql_com = "SELECT * FROM company_transport 
                                                                WHERE del_flg = 0";
                                                    $result_com  = mysqli_query($conn, $sql_com);
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
                                    } ?>
                                    <center>
                                        <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">ยกเลิก</button>
                                        <button type="button" class="btn btn-success" onclick="showConfirmationTracking()">ยืนยัน</button>
                                    </center>
                                </form>

                                <!-- Include SweetAlert library -->
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                } ?>
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
                                    <p style="color: gray" class="mb-0">วันที่ยื่นเรื่อง : <?= date('d F Y', strtotime($row_2['rs_date_time'])) . ' ' ?><span style="display:inline-block; color: gray"> | <i class="uil uil-clock"></i> เวลา <?= date('H:i:s', strtotime($row_2['rs_date_time'])); ?></span></p>
                                </div>
                            </div>

                            <?php if ($row_2['status_id'] != 12) { ?>
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
                            <?php } elseif ($row_2['status_id'] == 12) { ?>
                                <div class="row d-flex justify-content-center p-4">

                                    <?php if ($row_2['rs_detail'] != NULL) {  ?>
                                        <h2 style="color:red"><i class="fa fa-check"></i>เหตุผลการยกเลิก</h2>
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

                                            <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop_unique" aria-labelledby="offcanvasTopLabel" style="height: 70%">
                                                <div class="offcanvas-header">
                                                    <h5 id="offcanvasTopLabel">Offcanvas top</h5>
                                                    <br>
                                                    <br>
                                                    <a type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></a>
                                                </div>
                                                <div class="offcanvas-body">
                                                    <a type="button" class="btn-close text-reset d-flex justify-content-end ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></a>
                                                    <h2><span class="badge bg-secondary">หมายเลขพัสดุของท่าน</span></h2>
                                                    <br>
                                                    <?php
                                                    $sql_com_m = "SELECT * FROM get_detail
            LEFT JOIN get_repair ON get_detail.get_r_id = get_repair.get_r_id 
            LEFT JOIN tracking ON get_detail.get_t_id = tracking.t_id 
            LEFT JOIN repair ON repair.r_id = get_detail.r_id WHERE get_repair.get_r_id = '$id_get_r' AND repair.del_flg = '0'";
                                                    $result_com_m = mysqli_query($conn, $sql_com_m);

                                                    $count_com = 0;
                                                    while ($row_com_m = mysqli_fetch_array($result_com_m)) {
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
                                                    ?>
                                                </div>
                                            </div>

                                        <?php } ?>
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
                                <?php if ($total_part_price != NULL) {  ?>
                                    <hr>
                                    <div class="accordion accordion-flush" id="accordionFlushExample" style="background-color: #F1F1F1;">
                                        <div class="accordion-item" id="totalprice" style="background-color:#F1F1F1">
                                            <div>
                                                <h5 class="accordion-header" id="flush-headingTwo" style="background-color: #F1F1F1;">
                                                    <br>
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo" style="background-color: #F1F1F1;">
                                                        <h5>
                                                            รวมการสั่งซ่อม <?= number_format($total_part_price + $row_2['get_wages'] + $row_2['get_add_price']) ?> บาท
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

                                                        <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel" style="height: 60%;">
                                                            <div class="offcanvas-header">
                                                                <h5 id="offcanvasTopLabel">Offcanvas top</h5>
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

                                                                                <!-- DataTales Example -->
                                                                                <div class="card shadow mb-4">
                                                                                    <div class="card-header py-3">
                                                                                        <h6 class="m-0 font-weight-bold text-primary">ข้อมูลอะไหล่เครื่องเสียง</h6>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>ลำดับ</th>
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
                                                                                                    $get_id = $id_get_r;
                                                                                                    $sql_op = "SELECT
                                                                                                        repair_detail.p_id,
                                                                                                        repair_detail.rd_value_parts,
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
                                                                                                        AND get_repair.get_r_id = '$get_id'
                                                                                                    GROUP BY
                                                                                                        p_id;
                                                                                                        ";
                                                                                                    $result_op = mysqli_query($conn, $sql_op);
                                                                                                    while ($row_op = mysqli_fetch_array($result_op)) {
                                                                                                        $p_id = $row['p_id'];
                                                                                                        $rs_id = $row['rs_id'];

                                                                                                        $sql_count = "SELECT * FROM repair_detail WHERE rs_id = '$rs_id' AND p_id = '$p_id'";
                                                                                                        $result_count = mysqli_query($conn, $sql_count);
                                                                                                        $row_count = mysqli_fetch_array($result_count);

                                                                                                    ?>
                                                                                                        <tr>
                                                                                                            <td><?php
                                                                                                                if ($row_op['p_id'] == NULL) {
                                                                                                                    echo "-";
                                                                                                                } else {
                                                                                                                    echo $row_op['p_id'];
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
                                                                                                        <td colspan="5">ยอดอะไหล่ทั้งหมด</td>
                                                                                                        <td colspan="2">ราคารวม</td>
                                                                                                        <td><?= number_format($total) ?></td>
                                                                                                        <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <?php
                                                                                                        $sql_w = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                                                                        $result_w = mysqli_query($conn, $sql_w);
                                                                                                        $row_w = mysqli_fetch_array($result_w);
                                                                                                        ?>
                                                                                                        <td colspan="5">ค่าแรงช่าง</td>
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
                                                                                                            <td colspan="5">ค่าจัดส่ง</td>
                                                                                                            <td colspan="2">ราคาจัดส่ง</td>
                                                                                                            <td><?= number_format($row_p['get_add_price']) ?></td>
                                                                                                            <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                                                                        </tr>
                                                                                                    <?php
                                                                                                    } ?>


                                                                                                    <tr>
                                                                                                        <td colspan="5"></td>
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

                                                                                <center>
                                                                                </center>
                                                                                <!-- Place this in the <head> section of your HTML document -->
                                                                                <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
                                                <h2 style="margin-left: 1.2rem;">ติดตามสถานะ (Status)</h2>
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
                                                                echo '#ครั้งที่ '.$row_carry_out[0];
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

                                                                            // $carry_out_id = $row['status_id'];
                                                                            // $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = 155 AND status_id = 6 ORDER BY rs_date_time DESC;";
                                                                            // $result_carry_out = mysqli_query($conn, $sql_cary_out);
                                                                            // $row_carry_out = mysqli_fetch_array($result_carry_out);




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
                                                                        <a class="btn btn-danger" style="margin-left: 2%" onclick="showDiv()">ไม่ทำการยืนยัน/ยื่นข้อเสนอ</a>
                                                                        <a class="btn btn-success" id="confirmButtonSuccess" style="display:inline-block">ยืนยันการส่งซ่อม</a>
                                                                    <?php
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
                        <br>
                        <br>
                        <!-- <hr> -->
                        <!-- ปุ่มทำการยกเลิก -->
                        <?php if ($status_id_last  == 1 || $status_id_last  == 2 || $status_id_last  == 14) { ?>
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

                        <?php } elseif ($status_id_last  == 4 && $row_2['rs_conf'] == NULL) { ?>
                            <!-- <hr> -->
                            <!-- <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p> -->
                            <center>
                                <a style="margin-left: 2%" onclick="showDiv(); return MiniStatus()" class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">ไม่ทำการยืนยัน</a>
                                <a class="btn btn-success" id="confirmButtonSuccess1" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม</a>
                            </center>
                        <?php } elseif ($status_id_last  == 17  && $row_2['rs_conf'] == NULL) { ?>
                            <!-- <hr> -->
                            <!-- <p style="margin-left: 2%; color:red">*** ตรวจเช็คข้อมูลรายละเอียดการซ่อมให้ครบถ้วนก่อนทำรายการ ***</p> -->
                            <?php
                            $sql_c_offer = "SELECT * FROM repair_status WHERE status_id = '19' AND del_flg = '0' AND get_r_id = $id_get_r ORDER BY rs_date_time DESC LIMIT 1";
                            $result_c_offer = mysqli_query($conn, $sql_c_offer);
                            $row_c_offer = mysqli_fetch_array($result_c_offer);

                            if ($row_c_offer[0] > 0) {

                            ?>
                                <center>
                                    <a style="margin-left: 2%" onclick="showDiv(); return MiniStatus()" class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">ไม่ทำการยืนยัน</a>
                                    <a class="btn btn-success" id="confirmButtonCheck" style="display:inline-block" onclick="sendValuetoArrived(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม6</a>

                                </center>
                            <?php
                            } else {
                            ?> <center>
                                    <a style="margin-left: 2%" onclick="showDiv(); return MiniStatus()" class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">ไม่ทำการยืนยัน</a>
                                    <a class="btn btn-success" id="confirmButtonSuccess1" style="display:inline-block" onclick="sendValue(<?= $status_id_last ?>)">ยืนยันการส่งซ่อม5</a>

                                </center>
                            <?php }
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

        </div>
        <?php include('footer/footer.php'); ?>
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

        <script>
            function showConfirmationDialog() {
                swal({
                        title: "ยืนยันการยกเลิก",
                        text: "คุณต้องการยกเลิกหรือไม่?",
                        icon: "warning",
                        buttons: ["ยกเลิก", "ยืนยัน"],
                        dangerMode: true,
                    })
                    .then((willCancel) => {
                        if (willCancel) {
                            // The user confirmed the cancellation, you can proceed with the cancellation logic here
                            document.getElementById("cancel").submit(); // Submit the form
                        } else {
                            // The user clicked "Cancel", do nothing
                        }
                    });
            }
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

        <!-- Sweet Alert Show End -->
        <!-- Place this in the <head> section of your HTML document -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!-- Place this before the closing </body> tag -->

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
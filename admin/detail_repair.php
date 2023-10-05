<?php
session_start();
include('../database/condb.php');

if (!isset($_SESSION['role_id'])) {
    header('Location:../home.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Repair Information - Anan Electronic</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<style>
    /* Your existing CSS classes */
    .picture_modal {
        margin-right: 20px;
        border-radius: 10%;
    }

    .image-container {
        position: relative;
        display: inline-block;
        margin: 8px;
    }

    .preview-image {
        display: block;
        width: 200px;
        height: auto;
    }

    .delete-button {
        position: absolute;
        top: 0;
        right: 0;
        background-color: none;
        border: none;
        color: black;
        font-weight: bold;
        font-size: 24px;
        cursor: pointer;
        outline: none;
    }

    .gallery {
        display: flex;
        flex-wrap: wrap;
    }

    .gallery img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
        margin: 10px;
    }

    .modal_ed {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.8);
        opacity: 0;
        transition: opacity 0.3s ease-in;
    }

    .modal_ed.show {
        opacity: 1;
    }

    .modal-image {
        display: block;
        margin: 0 auto;
        max-width: 80%;
        max-height: 80%;
        text-align: center;
    }

    .close {
        color: #fff;
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #ccc;
        text-decoration: none;
        cursor: pointer;
    }

    .part_pic_show {
        border-radius: 20%;
    }

    .color_text {
        color: white;
    }

    .file-input-container {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .file-input-container label {
        margin-right: 10px;
        text-align: start;
    }

    .file-input-container .col-4 {
        flex: 0 0 25%;
        max-width: 25%;
        padding: 0 5px;
    }

    .no-scrollbar {
        overflow: hidden;
    }

    .grid {
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        grid-gap: 2rem;
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
<style>
    /* Style the search input */
    #search-box {
        width: 300px;
        padding: 10px;
    }

    /* Style the autocomplete container */
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    /* Style the autocomplete list */
    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        max-height: 150px;
        overflow-y: auto;
        z-index: 99;
    }

    /* Style each autocomplete item */
    .autocomplete-item {
        padding: 10px;
        cursor: pointer;
    }

    /* Highlight the selected autocomplete item */
    .autocomplete-item:hover {
        background-color: #e9e9e9;
    }

    <?php
    // $get_r_id = $_GET['id'];
    $parts_ar = array();
    $sql_get_co = "SELECT p_id,p_brand, p_model FROM parts  WHERE parts.del_flg = 0";

    $result_get_co = mysqli_query($conn, $sql_get_co);

    while ($row_get_co = mysqli_fetch_array($result_get_co)) {
        $brand = $row_get_co['p_brand'];
        $model = $row_get_co['p_model'];
        $p_id = $row_get_co['p_id'];
        $part_str = "\"$brand $model\"";
        $parts_ar[$p_id] = $part_str;
    }

    // Now $parts_ar contains an array of strings with brand and model enclosed in double quotes
    ?>
</style>

<body id="page-top">


    <!-- Modal -->
    <!-- Your HTML content -->


    <!-- Page Wrapper -->
    <div id="wrapper">


        <!-- Sidebar -->
        <?php
        include('bar/sidebar.php');
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">


            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php
                include('bar/topbar_admin.php');
                ?>
                <!-- End of Topbar -->



                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    $get_r_id = $_GET['id'];

                    $sql_get_count = "SELECT COUNT(get_r_id) FROM get_detail 
                    WHERE get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                    $result_get_count = mysqli_query($conn, $sql_get_count);
                    $row_get_count = mysqli_fetch_array($result_get_count);

                    $sql = "SELECT * FROM get_repair
                    LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id 
                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id 
                                        LEFT JOIN member ON member.m_id = repair.m_id
                                        LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id
                                        LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
                                        WHERE get_repair.del_flg = '0' AND repair_status.del_flg = '0' AND get_repair.get_r_id = '$get_r_id' ORDER BY rs_date_time DESC;";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);

                    $dateString = date('d-m-Y', strtotime($row['get_r_date_in']));
                    $date = DateTime::createFromFormat('d-m-Y', $dateString);
                    $formattedDate = $date->format('F / d / Y');
                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <h1 class="m-0 font-weight-bold text-primary mb-2">หมายเลขแจ้งซ่อม : <?= $row['get_r_id'] ?></h1>
                            <?php
                            if ($row_get_count[0] == 1) {
                            ?>
                                <h1 class="m-0 font-weight-bold text-success mb-2">Serial Number : <?= $row['r_serial_number'] ?></h1>
                            <?php
                            } else {
                            ?>
                                <h1 class="m-0 font-weight-bold text-success mb-2">คำส่งซ่อมนี้มี <?= $row_get_count[0] ?> รายการ</h1>
                            <?php
                            }
                            ?>
                            <h2>สถานะล่าสุด : <button id="bounce-item" onclick="openModalStatus('quantitystatus')" style="background-color: <?= $row['status_color'] ?>; color : white;" class="btn btn"> <?= $row['status_name'] ?>
                                    <?php
                                    if ($row['status_id'] == 6) {
                                        $get_r_id = $row['get_r_id'];
                                        $carry_out_id = $row['status_id'];
                                        $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = '$get_r_id' AND status_id = 6 AND del_flg = 0 ORDER BY rs_date_time DESC;";
                                        $result_carry_out = mysqli_query($conn, $sql_cary_out);
                                        $row_carry_out = mysqli_fetch_array($result_carry_out);

                                        if ($row_carry_out[0] > 1) {
                                    ?>
                                            #ครั้งที่ <?= $row_carry_out[0] ?>

                                    <?php
                                        }
                                    }
                                    ?></h2></button>


                            <h6><?= $formattedDate ?></h6>
                        </div>
                        <br>
                        <div class="container">
                            <div class="row">
                                <div class="col" id="bounce-item">
                                    <center>
                                        <!-- <h4><a href="#" onclick="openModalPart('status')">ติดตามสถานะ <i class="fa fa-chevron-right" style="color: gray; font-size: 17px;"></i></a></h4> -->
                                        <h4><a href="#" onclick="openModalStatus('quantitystatus')">ติดตามสถานะ <i class="fa fa-chevron-right" style="color: gray; font-size: 17px;"></i></a></h4>
                                    </center>
                                </div>
                                <div class="col">
                                    <center>
                                        <h3>|</h3>
                                    </center>
                                </div>
                                <div class="col" id="bounce-item">
                                    <center>
                                        <h4><a href="#" onclick="openModalPart('quantitypart')">จำนวนอะไหล่ <i class="fa fa-chevron-right" style="color: gray; font-size: 17px;"></i></a></h4>
                                    </center>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="accordion-item" style="border: 1px solid #ffff; padding:15px;   ">
                            <h2 class="accordion-header" style="margin-bottom: 0px;" id="headingOne">
                                <a id="bounce-item" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="true" aria-controls="collapseOne">
                                    <h5 style="margin-bottom: 0px;"> ดูรายการส่งซ่อมทั้งหมด </h5>
                                </a>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">

                                <hr style="border:2px solid gray" class="my-4">
                                <?php
                                $count_get_no = 0;

                                $sql_get = "SELECT * FROM get_detail 
                                LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                        WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                                $sql_get_count_track = "SELECT * FROM get_detail 
                                                         LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                                                 LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                                                 WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                                $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                                $result_get = mysqli_query($conn, $sql_get);
                                $row_get_count_track = mysqli_fetch_array($result_get_count_track);
                                while ($row_get = mysqli_fetch_array($result_get)) {
                                    $count_get_no++;
                                ?>

                                    <h4 style="text-align:start; color:#2c2f34" id="body_text"> <span class="btn btn-primary">รายการที่ <?= $count_get_no ?></span> : <?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?> | Model : <?= $row_get['r_number_model'] ?> | Serial Number : <?= $row_get['r_serial_number'] ?> </h4>
                                    <hr>
                                    <div style="margin-left: 40px; color:#2c2f34" class="my-4">
                                        <?php if ($row_get['get_t_id'] != NULL) { ?><button class="btn btn-outline-primary mb-3">หมายเลขพัสดุ</button>
                                            <br>
                                            <?= $row_get['t_parcel'] ?>
                                            <br>
                                            <hr><?php  }
                                                ?>
                                        <button class="btn btn-outline-primary mb-3">รายละเอียด</button>
                                        <!-- <h5 class="fw-bold">รายละเอียด</h5> -->
                                        <br>
                                        <?= $row_get['get_d_detail'] ?>
                                        <br>
                                        <hr>
                                        <!-- <h5 class="fw-bold">รูปภาพ</h5> -->
                                        <button class="btn btn-outline-primary mb-3">รูปภาพ</button>
                                        <br>
                                        <?php

                                        $get_d_id = $row_get['get_d_id'];
                                        // $sql_pic = "SELECT * FROM `repair_pic` WHERE get_r_id = '$get_r_id'";
                                        // $result_pic = mysqli_query($conn, $sql_pic);
                                        $sql_pic = "SELECT * FROM repair_pic 
                                                                LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                                                WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.get_d_id = '$get_d_id' AND get_detail.del_flg = 0;";
                                        $result_pic = mysqli_query($conn, $sql_pic);
                                        while ($row_pic = mysqli_fetch_array($result_pic)) {
                                            if ($row_pic[0] != NULL) { ?>
                                                <?php

                                                $rp_pic = $row_pic['rp_pic'];
                                                $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                ?> <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                    <a href="#" id="bounce-item"><img src="../<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                    <a href="#">
                                                        <video width="100px" autoplay muted onclick="openModalVideo(this)" src="../<?= $row_pic['rp_pic'] ?>">
                                                            <source src="../<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                            <source src="../<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </a>
                                                <?php endif; ?>
                                                <!-- Modal -->
                                                <div id="modal_ed" class="modal_ed">
                                                    <span class="close" onclick="closeModal()">&times;</span>
                                                    <video id="modal-video" controls class="modal-video"></video>
                                                </div>



                                                <!-- <h2><?= $row_pic['rp_pic'] ?></h2> -->
                                        <?php
                                            }
                                        } ?>




                                    </div>
                                    <hr style="border:2px solid gray" class="my-4">
                                <?php } ?>
                            </div>
                        </div>


                        <!--  Part modal -->
                        <div id="quantitypartModal" class="modal_ed">
                            <!-- <div class="modal-content">
                                <h2>จำนวนอะไหล่ทั้งหมด</h2>
                                <button class="close-button btn btn-primary" onclick="closeModalStatus('quantitypart')" width="200px">
                                    <i class="fa fa-times"></i>
                                </button>
                                <iframe src="mini_part_detail.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px;" class="no-scrollbar"></iframe>
                            </div> -->

                            <div class="modal-content" style="height: 100%">
                                <div class="modal-header">
                                    <h2 class="mx-auto" style="margin-bottom: 0px;">จำนวนอะไหล่ทั้งหมด</h2>
                                    <button type="button" class="btn my-auto" onclick="closeModalStatus('quantitypart')">
                                        <i class="fa fa-times fa-lg"></i></button>
                                </div>
                                <iframe src="mini_part_detail.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px; border:none;" class="no-scrollbar"></iframe>
                            </div>
                        </div>

                        <!--  Status modal -->
                        <div id="quantitystatusModal" class="modal_ed" style="overflow: hidden;">
                            <div class="modal-content" style="height: 100%">
                                <div class="modal-header">
                                    <h1 class="mx-auto" style="margin-bottom: 0px;">สถานะ</h1>
                                    <button type="button" class="btn my-auto" onclick="closeModalStatus('quantitystatus')">
                                        <i class="fa fa-times fa-lg"></i></button>
                                </div>
                                <iframe src="mini_status.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px; border:none;" class="no-scrollbar"></iframe>
                            </div>
                            <!-- <div class="modal-content">
                                <h1>สถานะ</h1>
                                <button class="close-button btn btn-primary" onclick="closeModalStatus('quantitystatus')" width="200px">
                                    <i class="fa fa-times"></i>
                                </button>
                                 content for Status modal
                                <iframe src="mini_status.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px;" class="no-scrollbar"></iframe>
                            </div> -->
                        </div>


                        <script>
                            function openModalPart(modalName) {
                                var modal_ed = document.getElementById(modalName + "Modal");
                                modal_ed.style.display = "block";
                                modal_ed.classList.add("show");
                            }

                            function closeModalPart(modalName) {
                                var modal_ed = document.getElementById(modalName + "Modal");
                                modal_ed.style.display = "none";
                                modal_ed.classList.remove("show");
                            }
                            // ////////////////////////////////////////////////////////////

                            function openModalStatus(modalName) {
                                var modal_ed = document.getElementById(modalName + "Modal");
                                modal_ed.style.display = "block";
                                modal_ed.classList.add("show");
                            }

                            function closeModalStatus(modalName) {
                                var modal_ed = document.getElementById(modalName + "Modal");
                                modal_ed.style.display = "none";
                                modal_ed.classList.remove("show");
                            }
                        </script>
                        <!-- <hr> -->
                        <script>
                            // Number of status dots
                            var numStatus = 5;

                            // Get the progress bar container
                            var progressBar = document.getElementById('progress-bar');

                            // Generate status dots dynamically
                            for (var i = 0; i < numStatus; i++) {
                                var dot = document.createElement('div');
                                dot.classList.add('dot');
                                dot.classList.add('info-color');
                                dot.style.left = (i / (numStatus - 1)) * 100 + '%';
                                progressBar.appendChild(dot);
                            }
                        </script>
                        <div class="card-body">
                            <?php
                            if ($row['rs_conf'] == 1 && $row['status_id'] != 8 && $row['status_id'] != 24) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ได้รับการยืนยันการซ่อมแล้ว</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะ "ดำเนินการ" ไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php } else if ($row['rs_conf'] != NULL && $row['rs_conf'] == 0 && $row['status_id'] == 17) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>ะเงินแล้ว
                                <br>
                            <?php
                            } else if ($row['rs_conf'] != NULL && $row['rs_conf'] == 0 && $row['status_id'] == 4) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>ะเงินแล้ว
                                <br>
                            <?php
                            } else if (isset($row_s['rs_cancel_detail']) != NULL) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>ะเงินแล้ว
                                <br>
                            <?php
                            } else if ($row['status_id'] == 3) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">เสร็จสิ้นคำสั่งซ่อมนี้แล้ว</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** การซ่อมดำเนินการเสร็จสิ้นแล้ว ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['status_id'] == 24) {
                            ?>
                                <div class="alert alert-primary" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">รอสมาชิกตอบกลับการซ่อม</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจรอสมาชิกตรวจสอบและตอบกลับมายังพนักงาน ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['status_id'] == 25) {
                            ?>
                                <div class="alert alert-primary" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">สมาชิกต้องทำการชำระเงินเรียบร้อยแล้ว</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] != NULL && $row['rs_conf'] == 4 && $row['status_id'] == 8) {
                            ?>
                                <div class="alert alert-primary" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">สมาชิกต้องการจัดส่งแบบไปรษณีย์ โปรดระบุค่าจัดส่ง</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == 1 && $row['status_id'] == 24) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == 1 && $row['status_id'] == 8) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ได้รับยืนยันการชำระเงินจากสมาชิกแล้ว</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลการยืนยันการชำระเงินและที่อยู่ให้ครบถ้วน ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == NULL && $row['status_id'] == 13) {
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">รอการตอบกลับจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดรอการตอบกลับการยืนยันจากสมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == NULL && $row['status_id'] == 8) {
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">รอการตอบกลับจากสมาชิก</h4>
                                    </center>
                                </div>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == 0 && $row['status_id'] == 13) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == 0 && $row['rs_conf'] == 9) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['status_id'] == 4 || $row['status_id'] == 17 && $row['rs_conf'] == NULL) {
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">รอการตอบกลับจากสมาชิก</h4>
                                    </center>
                                </div>
                                <br>

                            <?php
                            }

                            $jsonobj = $row['get_add'];

                            $obj = json_decode($jsonobj);

                            // echo 'จังหวัด' . $row_p[0];
                            // echo ' อำเภอ' . $row_p[1];
                            // echo ' ตำบล' . $row_p[2];
                            // echo  $obj->zip_code;
                            // echo ' รายละเอียด ' . $obj->description;

                            // $sql_p = "SELECT provinces.name_th, amphures.name_th, districts.name_th
                            $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
                                    FROM provinces
                                    LEFT JOIN amphures ON provinces.id = amphures.province_id
                                    LEFT JOIN districts ON amphures.id = districts.amphure_id
                                    WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
                            $result_p = mysqli_query($conn, $sql_p);
                            $row_p = mysqli_fetch_array($result_p);
                            ?>
                            <button type="button" class="btn btn-outline-primary mb-3" style="display: inline-block;">ข้อมูลการติดต่อ</button>
                            <p style="display: inline;">
                                <?php if ($row['get_deli'] == 0) { ?>
                                    <span class="btn btn-info  mb-3 ml-4">#รับที่ร้าน</span>
                                <?php } else { ?>
                                    <span class="btn btn-info mb-3 ml-4">#จัดส่งโดยบริษัทขนส่ง</span>
                                <?php } ?>
                                <?php if ($row_get_count_track['get_t_id'] != NULL) { ?>
                                    <a id="bounce-item" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="true" aria-controls="collapseOne">
                                        <span class="btn btn-warning mb-3 ml-4"><i class="fa fa-check"></i>สมาชิกทำการส่งหมายเลขพัสดุ</span><?php  }
                                                                                                                                            ?></a>
                            </p>


                            <div class="row">
                                <h6 for="staticEmail" class="col-1 col-form-label" style="margin-bottom: 0px;">ชื่อ : </h6>
                                <div class="col">
                                    <p class="col-form-label" style="color: #2c2f34"><?= $row['m_fname']  ?> <?= $row['m_lname']  ?></p>
                                </div>
                            </div>
                            <?php
                            if ($row_get_count[0] == 1) {
                            ?>
                                <div class="row">
                                    <h6 for="inputPassword" class="col-1 col-form-label" style="margin-bottom: 0px;">Brand :</h6>
                                    <div class="col">
                                        <p class="col-form-label" style="color: #2c2f34"><?= $row['r_brand']  ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <h6 for="inputPassword" class="col-1 col-form-label" style="margin-bottom: 0px;">Model :</h6>
                                    <div class="col">
                                        <p class="col-form-label" style="color: #2c2f34"><?= $row['r_model']  ?></p>
                                    </div>
                                </div>
                            <?php
                            } else {
                            ?>

                            <?php
                            }
                            ?>

                            <div class="row">
                                <h6 for="inputPassword" class="col-1 col-form-label" style="margin-bottom: 0px;">เบอร์โทรศัพท์ : </h6>
                                <div class="col">
                                    <p class="col-form-label" style="color: #2c2f34"><?= $row['get_tel']  ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <h6 for="inputPassword" class="col-1 col-form-label" style="margin-bottom: 0px;">บริษัท : </h6>
                                <div class="col">
                                    <p class="col-form-label" style="color: #2c2f34"><?php
                                                                                        if ($row['com_id'] == NULL) {
                                                                                            echo "ไม่มีข้อมูล";
                                                                                        } else {
                                                                                            $com_id = $row['com_id'];
                                                                                            $sql_com = "SELECT * FROM company WHERE com_id = '$com_id'";
                                                                                            $result_com = mysqli_query($conn, $sql_com);
                                                                                            $row_com = mysqli_fetch_array($result_com);

                                                                                            echo $row_com['com_name'];
                                                                                        }
                                                                                        ?></p>
                                </div>
                            </div>

                            <hr>

                            <div class="">
                                <label for="exampleFormControlTextarea1" class="btn btn-outline-primary">ที่อยู่</label>
                                <?php if ($row['get_add'] != NULL) {
                                ?>
                                    <div class="row">
                                        <label for="exampleFormControlTextarea1" class="col-sm-1 col-form-label">จังหวัด :</label>
                                        <div class="col">
                                            <!-- <input type="text" class="form-control" value="<?= $row_p[0] ?>" readonly> -->
                                            <p class="col-form-label" style="color: #2c2f34"><?= $row_p[0] ?></p>
                                        </div>
                                        <label for="exampleFormControlTextarea1" class="col-sm-1 col-form-label">อำเภอ :</label>
                                        <div class="col">
                                            <!-- <input type="text" class="form-control" value="<?= $row_p[1] ?>" readonly> -->
                                            <p class="col-form-label" style="color: #2c2f34"><?= $row_p[1] ?></p>
                                        </div>
                                        <label for="exampleFormControlTextarea1" class="col-sm-1 col-form-label">ตำบล :</label>
                                        <div class="col">
                                            <!-- <input type="text" class="form-control" value="<?= $row_p[2] ?>" readonly> -->
                                            <p class="col-form-label" style="color: #2c2f34"><?= $row_p[2] ?></p>
                                        </div>
                                        <label for="exampleFormControlTextarea1" class="col-sm-1 col-form-label">รหัสไปรษณีย์ :</label>
                                        <div class="col">
                                            <!-- <input type="text" class="form-control" value="<?= $row_p[2] ?>" readonly> -->
                                            <p class="col-form-label" style="color: #2c2f34"><?= $row_p[3] ?></p>
                                        </div>
                                    </div>
                                    <!-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?php
                                                                                                                                        if ($row['get_add'] == NULL) {
                                                                                                                                            echo "ไม่มีข้อมูล";
                                                                                                                                        } else {

                                                                                                                                            echo $obj->description;
                                                                                                                                        }
                                                                                                                                        ?>
                                </textarea> -->
                                    <div class="row">
                                        <label for="exampleFormControlTextarea1" class="col-1 col-form-label">รายละเอียด :</label>
                                        <div class="col">
                                            <p class="col-form-label" style="color: #2c2f34"><?php
                                                                                                if ($row['get_add'] == NULL) {
                                                                                                    echo "ไม่มีข้อมูล";
                                                                                                } else {

                                                                                                    echo $obj->description;
                                                                                                }
                                                                                                ?></p>
                                        <?php
                                    } else {
                                        ?>
                                            <center>
                                                <h5>ไม่มีข้อมูลที่อยู่</h5>
                                            </center>
                                        <?php
                                    }
                                        ?>
                                        </div>
                                    </div>
                            </div>
                            <hr>

                            <?php
                            // $get_r_id = $row['get_r_id'];
                            $status_id = $row['status_id'];
                            // $get_r_id = $_GET['id'];

                            $sql_s = "SELECT * FROM repair_status 
                            WHERE del_flg = '0' AND get_r_id = '$get_r_id'
                            ORDER BY rs_date_time DESC LIMIT 1";
                            $result_s = mysqli_query($conn, $sql_s);
                            $row_s = mysqli_fetch_array($result_s);
                            $rs_id = $row_s['rs_id'];
                            ?>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="btn btn-outline-primary">รายละเอียด</label>
                                <!-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?= $row_s['rs_detail']  ?></textarea> -->
                                <p class="col-form-label" style="color: #2c2f34"><?= $row_s['rs_detail']  ?></p>
                            </div>

                            <?php
                            if ($row_s['rs_cancel_detail'] != NULL) {
                            ?>
                                <hr>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="col-form-label btn btn-danger">เหตุผลไม่ยืนยันการซ่อม</label>
                                    <br><br>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?= $row_s['rs_cancel_detail']  ?></textarea>
                                </div>
                            <?php
                            }
                            ?>
                            <hr>
                            <div class="mb-3">
                                <?php
                                $sql_pic3 = "SELECT * FROM repair_pic WHERE rs_id = '$rs_id' AND del_flg = 0 ";
                                $result_pic3 = mysqli_query($conn, $sql_pic3);
                                $roe_c =  mysqli_fetch_array($result_pic3);
                                if (isset($roe_c[0]) == NULL) {
                                ?>
                                    <label for="exampleFormControlTextarea1" class="btn btn-outline-primary" style="display:none">รูปภาพประกอบ:</label>
                                <?php
                                } else {
                                ?>
                                    <label for="exampleFormControlTextarea1" class="btn btn-outline-primary">รูปภาพประกอบ </label>
                                <?php
                                }
                                ?>
                                <!-- <label for="exampleFormControlTextarea1" class="col-form-label">รูปภาพประกอบ <?= $get_r_id ?>:</label> -->
                                <div class="row">
                                    <?php


                                    $sql_pic = "SELECT * FROM repair_pic WHERE rs_id = '$rs_id' AND del_flg = 0 ";
                                    $result_pic = mysqli_query($conn, $sql_pic);


                                    // $sql_pic = "SELECT * FROM `repair_pic` WHERE get_r_id = '$get_r_id'";
                                    // $result_pic = mysqli_query($conn, $sql_pic);
                                    while ($row_pic = mysqli_fetch_array($result_pic)) {

                                        if ($row_pic[0] != NULL) { ?>
                                            <?php
                                            $rp_pic = $row_pic['rp_pic'];
                                            $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                            ?> <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                <a href="#" style="margin-left: 20px;" id="bounce-item"><img src="../<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                            <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                <a href="#" style="margin-left: 20px;">
                                                    <video width="100px" autoplay muted onclick="openModalVideo(this)" src="../<?= $row_pic['rp_pic'] ?>">
                                                        <source src="../<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                        <source src="../<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </a>
                                            <?php endif; ?>
                                            <!-- Modal -->
                                            <div id="modal_ed" class="modal_ed">
                                                <span class="close" onclick="closeModal()">&times;</span>
                                                <video id="modal-video" controls class="modal-video"></video>
                                            </div>
                                            <!-- <h2><?= $row_pic['rp_pic'] ?></h2> -->
                                        <?php
                                        } else { ?> <h2>ไม่มีข้อมูล</h2> <?php
                                                                        }
                                                                    } ?>
                                    <div id="modalimg" class="modal_ed">
                                        <span class="close" onclick="closeModalIMG()">&times;</span>
                                        <img id="modal-image" src="" alt="Modal Photo">
                                    </div>

                                    <script src="script.js"></script>
                                    <script>
                                        function openModalIMG(img) {
                                            var modal_ed = document.getElementById("modalimg");
                                            var modalImg = document.getElementById("modal-image");
                                            modal_ed.style.display = "block";
                                            modalImg.src = img.src;
                                            modalImg.style.width = "60%"; // Set the width to 1000 pixels
                                            modalImg.style.borderRadius = "2%"; // Set the border radius to 20%
                                            modal_ed.classList.add("show");
                                        }

                                        function closeModalIMG() {
                                            var modal_ed = document.getElementById("modalimg");
                                            modal_ed.style.display = "none";
                                        }
                                    </script>
                                    <script>
                                        function openModalVideo(element) {
                                            var modal_ed = document.getElementById('modal_ed');
                                            var modalVideo = document.getElementById('modal-video');
                                            modal_ed.style.display = 'block';
                                            modalVideo.src = element.src;
                                            modalVideo.style.height = '90%';
                                            modalVideo.style.borderRadius = '2%';
                                            modal_ed.classList.add('show');
                                        }

                                        function closeModal() {
                                            var modal_ed = document.getElementById('modal_ed');
                                            var modalVideo = document.getElementById('modal-video');
                                            modalVideo.pause();
                                            modalVideo.currentTime = 0;
                                            modalVideo.src = ""; // Reset the video source
                                            modal_ed.style.display = 'none';
                                        }

                                        window.addEventListener('click', function(event) {
                                            var modal_ed = document.getElementById('modal_ed');
                                            if (event.target === modal_ed) {
                                                closeModal();
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                            <!-- สถานะ "ส่งเรื่องแล้ว" -->
                            <?php if ($row['value_code'] == "submit") {
                            ?>

                                <center>
                                    <a class="btn btn-success" href="action/add_submit_repair.php?id=<?= $get_r_id ?>" onclick="confirmChangeStatus_received(event)">เปลี่ยนสถานะเป็น 'รับเรื่องแล้ว'</a>
                                </center>

                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                                <script>
                                    function confirmChangeStatus_received(event) {
                                        event.preventDefault(); // Prevent the default link action

                                        Swal.fire({
                                            title: "คุณต้องการเปลี่ยนสถานะเป็น 'รับเรื่องแล้ว' ใช่หรือไม่?",
                                            text: "การเปลี่ยนสถานะจะไม่สามารถย้อนกลับได้",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "ยืนยัน",
                                            cancelButtonText: "ยกเลิก",
                                        }).then(function(result) {
                                            if (result.isConfirmed) {
                                                // Proceed with the link action
                                                window.location.href = event.target.href;
                                            }
                                        });
                                    }
                                </script>

                                <!-- สถานะ "รับเรื่องแล้ว" -->
                            <?php
                            } ?>
                            <?php if ($row['value_code'] == "received") { ?>
                                <center>
                                    <button class="btn btn-danger" onclick="showCancelValue()">ปฏิเสธการซ่อม</button>
                                    <button class="btn btn-success" onclick="showDetailValue()">เปลี่ยนสถานะเป็น 'รายละเอียด'</button>
                                </center>

                                <div id="cancel_value_code" style="display: none;">
                                    <hr>
                                    <br>
                                    <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ </h1>
                                    <br>
                                    <form id="cancel_status_id" action="action/status/status_non_del_part.php" method="POST" enctype="multipart/form-data">
                                        <label for="cancelFormControlTextarea" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการ <p style="display:inline; color : red"> ปฏิเสธการซ่อม</p> :</label>
                                        <textarea class="form-control" name="rs_detail" id="cancelFormControlTextarea" rows="3" required placeholder="กรอกรายละเอียดในการปฏิเสธการซ่อม"></textarea>
                                        <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
                                        <input type="text" name="status_id" value="11" hidden>
                                        <br>
                                        <p style="color:red">*** โปรดกรอกรายละเอียดข้างต้นก่อนทำการเพิ่มรูปภาพ ***</p>
                                        <hr>
                                        <label for="cancelFormControlTextarea" class="form-label">เพิ่มรูปภาพหรือวิดีโอ *ไม่จำเป็น (สูงสุด 4 ไฟล์):</label>
                                        <a class="btn btn-primary" onclick="showInput()">เพิ่มรูปภาพหรือวิดีโอ</a>
                                        <br>
                                        <div id="inputContainer"></div>

                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                                        <script>
                                            var clickCount = 0;

                                            function showInput() {
                                                var textarea = document.getElementById('cancelFormControlTextarea');
                                                var textValue = textarea.value.trim();
                                                if (textValue === '') {
                                                    return false; // Prevent form submission if there is no text input
                                                }

                                                clickCount++;

                                                if (clickCount <= 4) {
                                                    var inputElement = document.createElement('div');
                                                    inputElement.classList.add('input-group', 'mb-3');

                                                    var fileInput = document.createElement('input');
                                                    fileInput.type = 'file';
                                                    fileInput.name = 'file' + clickCount;
                                                    fileInput.classList.add('form-control');
                                                    fileInput.addEventListener('change', function(event) {
                                                        showPreview(event.target);
                                                    });

                                                    var inputGroupText = document.createElement('span');
                                                    inputGroupText.classList.add('input-group-text');
                                                    inputGroupText.textContent = 'File ' + clickCount;

                                                    var deleteButton = document.createElement('button');
                                                    deleteButton.type = 'button';
                                                    deleteButton.classList.add('btn', 'btn-danger');
                                                    deleteButton.textContent = 'Delete';
                                                    deleteButton.addEventListener('click', function() {
                                                        inputElement.remove();
                                                        removeFileInputValue(fileInput.name); // Remove corresponding value
                                                    });

                                                    var previewElement = document.createElement('div');
                                                    previewElement.classList.add('preview');
                                                    previewElement.style.marginTop = '10px';

                                                    inputElement.appendChild(inputGroupText);
                                                    inputElement.appendChild(fileInput);
                                                    inputElement.appendChild(deleteButton);

                                                    var inputContainer = document.getElementById('inputContainer');
                                                    inputContainer.appendChild(inputElement);
                                                    inputContainer.appendChild(previewElement);
                                                }

                                                return false; // Prevent form submission
                                            }

                                            function showPreview(input) {
                                                var preview = input.parentNode.nextSibling; // Get the next sibling (preview element)
                                                preview.innerHTML = '';

                                                if (input.files && input.files[0]) {
                                                    var file = input.files[0];
                                                    var fileType = file.type;
                                                    var validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                                                    var validVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];

                                                    if (validImageTypes.includes(fileType)) {
                                                        var img = document.createElement('img');
                                                        img.src = URL.createObjectURL(file);
                                                        img.style.maxWidth = '200px';
                                                        preview.appendChild(img);
                                                    } else if (validVideoTypes.includes(fileType)) {
                                                        var video = document.createElement('video');
                                                        video.src = URL.createObjectURL(file);
                                                        video.style.maxWidth = '200px';
                                                        video.autoplay = true;
                                                        video.loop = true;
                                                        video.muted = true;
                                                        preview.appendChild(video);
                                                    }
                                                }
                                            }

                                            function removeFileInputValue(inputName) {
                                                var fileInput = document.querySelector('input[name="' + inputName + '"]');
                                                if (fileInput) {
                                                    fileInput.value = ''; // Clear the file input value
                                                }
                                            }

                                            function confirm_cen(event) {
                                                event.preventDefault(); // Prevent the form from being submitted

                                                Swal.fire({
                                                    title: 'คุณแน่ใจหรือไม่?',
                                                    text: 'คุณต้องการส่งข้อมูลนี้หรือไม่',
                                                    icon: 'question',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'ใช่',
                                                    cancelButtonText: 'ไม่'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        // User confirmed, submit the form
                                                        document.getElementById('cancel_status_id').submit();
                                                    }
                                                });
                                            }
                                        </script>
                                        <center>
                                            <br>
                                            <button class="btn btn-success" onclick="confirm_cen(event)">ยืนยัน</button>
                                        </center>
                                    </form>
                                </div>

                                <!-- ------------------------------------------------------------------ -->

                                <div id="detail_value_code" style="display: none;">
                                    <hr>
                                    <br>
                                    <h1 class="m-0 font-weight-bold text-secondary">รายละเอียด </h1>
                                    <br>
                                    <form id="detail_status_id" action="action/status/insert_new_part_non_del.php" method="POST" enctype="multipart/form-data">
                                        <div>
                                            <br>
                                            <label for="basic-url" class="form-label">กรุณาเลือกอุปกรณ์ที่ต้องการทำการซ่อม</label>
                                            <?php
                                            $count_conf = 0;
                                            $sql_get_c = "SELECT * FROM get_detail 
                                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                        WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                                            $result_get_c = mysqli_query($conn, $sql_get_c);
                                            while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                                                $count_conf++;
                                            ?>

                                                <div class="alert alert-primary" role="alert">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="check_<?= $row_get_c['get_d_id'] ?>" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                                        <label class="form-check-label" for="inlineCheckbox1"><?= $count_conf ?></label>
                                                    </div>
                                                    <?= $row_get_c['r_brand'] . " " . $row_get_c['r_model'] . " - Model : " . $row_get_c['r_number_model'] . " - Serial Number : " . $row_get_c['r_serial_number']  ?>
                                                </div>
                                                <div class="col-4">
                                                    <!-- <label for="basic-url" class="form-label">รหัสสมาชิก</label>
                                                    <input type="text" name="m_id" class="form-control" id="myInput" onclick="openModal()" placeholder="ค้นหาข้อมูลสมาชิก">
                                                    <div id="myModal" class="modal">
                                                        <div class="modal-overlay" id="myModal">
                                                            <div class="modal-content">
                                                                <button class="close-button" onclick="closeModal()">&times;</button>
                                                                <label for="tel">รายชื่อสมาชิก <p style="color: red; display: inline;">*ส่งค่าเป็นรหัส ID สมาชิก</p></label>
                                                                <input type="text" id="searchInput" oninput="searchFunction()" placeholder="Search...">
                                                                <ul id="myList"></ul>
                                                            </div>
                                                        </div>


                                                    </div> -->
                                                    <?php
                                                    $sql1 = "SELECT * FROM member WHERE del_flg = 0";
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    $data = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                                                    ?>

                                                    <script>
                                                        var input = document.getElementById("myInput");
                                                        var modal_ed = document.getElementById("myModal");
                                                        var searchInput = document.getElementById("searchInput");
                                                        var myList = document.getElementById("myList");
                                                        var data = <?php echo json_encode($data); ?>;

                                                        function openModal() {
                                                            modal_ed.style.display = "block";
                                                            searchInput.value = "";
                                                            populateList(data);
                                                            searchInput.focus();
                                                        }

                                                        function closeModal() {
                                                            modal_ed.style.display = "none";
                                                        }

                                                        function selectItem(event) {
                                                            var selectedValue = event.target.textContent;
                                                            var option = document.createElement("option");
                                                            option.value = selectedValue.split(" - ")[0]; // Extract m_id from the selected value
                                                            option.textContent = selectedValue;
                                                            option.selected = true;
                                                            input.appendChild(option);
                                                            closeModal();
                                                        }


                                                        function populateList(items) {
                                                            myList.innerHTML = "";

                                                            // Create the default option element
                                                            var defaultOption = document.createElement("option");
                                                            defaultOption.value = "0";
                                                            defaultOption.textContent = " 0 - ไม่มี";
                                                            defaultOption.selected = true;
                                                            myList.appendChild(defaultOption);

                                                            for (var i = 0; i < items.length; i++) {
                                                                var li = document.createElement("li");
                                                                li.textContent = items[i].m_id + " - " + items[i].m_fname + " " + items[i].m_lname; // Display m_id, first name, and last name
                                                                li.addEventListener("click", selectItem);
                                                                myList.appendChild(li);
                                                            }
                                                        }


                                                        function searchFunction() {
                                                            var searchTerm = searchInput.value.toLowerCase();
                                                            var filteredData = data.filter(function(item) {
                                                                var fullName = item.m_fname.toLowerCase() + " " + item.m_lname.toLowerCase(); // Concatenate first name and last name
                                                                return (
                                                                    item.m_id.toString().includes(searchTerm) || // Check if m_id includes the search term
                                                                    fullName.includes(searchTerm) // Check if the full name includes the search term
                                                                );
                                                            });
                                                            populateList(filteredData);
                                                        }

                                                        function selectItem(event) {
                                                            var selectedValue = event.target.textContent;
                                                            var m_id = selectedValue.split(" - ")[0]; // Extract m_id from the selected value
                                                            input.value = m_id;
                                                            closeModal();
                                                        }
                                                    </script>

                                                </div>
                                            <?php
                                            }
                                            $parts_ar = array();
                                            $sql_get_co = "SELECT parts.p_id,parts.p_brand, parts.p_model,parts_type.p_type_name FROM parts 
                                            LEFT JOIN parts_type ON parts.p_type_id = parts_type.p_type_id
                                            WHERE parts.del_flg = 0";

                                            $result_get_co = mysqli_query($conn, $sql_get_co);

                                            while ($row_get_co = mysqli_fetch_array($result_get_co)) {
                                                $p_id = $row_get_co['p_id'];
                                                $brand = $row_get_co['p_brand'];
                                                $model = $row_get_co['p_model'];
                                                $type = $row_get_co['p_type_name'];
                                                $part_str = "$p_id  - $brand $model : type - $type";
                                                $parts_ar[] = $part_str;
                                            }
                                            ?>

                                        </div>

                                        <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
                                        <input type="text" name="status_id" value="4" hidden>
                                        <input type="hidden" name="cardCount" id="cardCountInput" value="0">
                                        <br>
                                        <div class="row">
                                            <div class="col-md">
                                                <label for="basic-url" class="form-label">ค่าแรงช่าง *แยกกับราคาอะไหล่</label>
                                                <div class="input-group mb-3">

                                                    <span class="input-group-text" id="basic-addon3">ค่าแรงช่าง</span>
                                                    <input name="get_wages" type="text" value="<?= $row['get_wages'] ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณากรอกค่าแรงช่าง" required>
                                                    <span class="input-group-text">฿</span>
                                                </div>
                                            </div>

                                            <?php
                                            if ($row['get_deli'] == 1) { ?>
                                                <div class="col-md">
                                                    <label for="basic-url" class="form-label">ค่าจัดส่ง *แยกกับราคาอะไหล่</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon3">ค่าจัดส่ง</span>
                                                        <input name="get_add_price" type="text" value="<?= $row['get_add_price'] ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณากรอกค่าส่งอุปกรณ์" required>
                                                        <span class="input-group-text">฿</span>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="col-md">
                                                <label for="basic-url" class="form-label">ระยะเวลาซ่อม</label>
                                                <div class="input-group mb-3">

                                                    <input name="get_date_conf" type="text" value="<?= $row['get_date_conf'] ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณากรอกระยะเวลาซ่อม" required>
                                                    <span class="input-group-text">วัน</span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <label for="DetailFormControlTextarea" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการส่ง <p style="display:inline; color : gray"> รายละเอียด</p> :</label>
                                        <textarea class="form-control" name="rs_detail" id="DetailFormControlTextarea" rows="3" required placeholder="กรอกรายละเอียดในการรายละเอียดการซ่อม">อะไหล่ที่ต้องใช้มีดังนี้</textarea>



                                        <br>
                                        <div class="mb-3">
                                            <h6>อะไหล่</h6>
                                            <div id="cardContainer" style="display: none;">
                                                <table class="table" id="cardSection"></table>
                                            </div>
                                            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Parts">
                                                เพิ่มอะไหล่
                                            </button> -->
                                            <div class="accordion" id="accordionExample">
                                                <?php


                                                $count = 0;
                                                $get_r_id = $_GET['id'];
                                                $sql_get_c = "SELECT * FROM get_detail 
                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                        WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                                                $result_get_c = mysqli_query($conn, $sql_get_c);

                                                while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                                                    $count++;
                                                ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne<?= $row_get_c['r_id'] ?>">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?= $row_get_c['r_id'] ?>" aria-expanded="false" aria-controls="collapseOne<?= $row_get_c['r_id'] ?>">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="check_<?= $count ?>" type="checkbox" value="" id="flexCheckDefault<?= $row_get_c['r_id'] ?>">
                                                                </div>
                                                                <?= 'Brand : ' . $row_get_c['r_brand'] . ' - Model :' . $row_get_c['r_model'] . ' - Number' . $row_get_c['r_model_number'] ?>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne<?= $row_get_c['r_id'] ?>" class="accordion-collapse collapse" aria-labelledby="headingOne<?= $row_get_c['r_id'] ?>" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="autocomplete">
                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Parts<?= $row_get_c['r_id'] ?>">
                                                                        เพิ่มอะไหล่ให้กับอุปกรณ์นี้
                                                                    </button>
                                                                    <div class="modal fade" id="Parts<?= $row_get_c['r_id'] ?>" tabindex="-1" aria-labelledby="Parts<?= $row_get_c['r_id'] ?>" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-scrollable modal-xl">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="Parts<?= $row_get_c['r_id'] ?>">จัดการอะไหล่ </h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">

                                                                                        <form id="partsForm<?= $row_get_c['r_id'] ?>" action="action/add_parts_repair.php" method="POST">
                                                                                            <div class="col-md-3">
                                                                                                <input type="text" name="session_repair" value="<?= $row_get_c['r_id'] ?>">
                                                                                                <select class="form-select" aria-label="Default select example" id="partType<?= $row_get_c['r_id'] ?>">
                                                                                                    <option selected>กรุณาเลือกประเภทของอะไหล่</option>
                                                                                                    <?php
                                                                                                    $sql_pt = "SELECT p_type_id, p_type_name FROM parts_type WHERE del_flg = 0";
                                                                                                    $result_pt = mysqli_query($conn, $sql_pt);
                                                                                                    while ($row_pt = mysqli_fetch_array($result_pt)) {
                                                                                                        echo '<option value="' . $row_pt['p_type_id'] . '">' . $row_pt['p_type_name'] . '</option>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md mb-4">
                                                                                                <input id="search-box<?= $row_get_c['r_id'] ?>" name="parts_name" class="form-control" type="text" onkeyup="searchFunction<?= $row_get_c['r_id'] ?>()" placeholder="ค้นหา...">
                                                                                                <!-- <input  class="form-control" type="text" onkeyup="searchFunction<?= $row_get_c['r_id'] ?>()" value="" placeholder="Search..."> -->
                                                                                                <div class="autocomplete-items" id="search-results<?= $row_get_c['r_id'] ?>"></div>


                                                                                            </div>
                                                                                            <div class="col-md-2 mb-4">
                                                                                                <input class="form-control" type="number" name="value_parts" placeholder="จำนวน...">
                                                                                            </div>


                                                                                            <script>
                                                                                                // Simulated data for demonstration purposes
                                                                                                const data<?= $row_get_c['r_id'] ?> = <?= json_encode($parts_ar) ?>;

                                                                                                function searchFunction<?= $row_get_c['r_id'] ?>() {
                                                                                                    const input = document.getElementById('search-box<?= $row_get_c['r_id'] ?>');
                                                                                                    const resultsContainer = document.getElementById('search-results<?= $row_get_c['r_id'] ?>');
                                                                                                    const inputValue = input.value.toLowerCase();

                                                                                                    // Clear previous results
                                                                                                    resultsContainer.innerHTML = '';

                                                                                                    // Get the selected part type from the dropdown
                                                                                                    const partTypeSelect = document.getElementById('partType<?= $row_get_c['r_id'] ?>');
                                                                                                    const selectedPartType = partTypeSelect.value.toLowerCase();

                                                                                                    // Filter data based on input and selected part type
                                                                                                    const filteredData = data<?= $row_get_c['r_id'] ?>.filter(item => {
                                                                                                        const itemLower = item.toLowerCase();
                                                                                                        return itemLower.includes(inputValue) && itemLower.includes(selectedPartType);
                                                                                                    });

                                                                                                    // Display matching results
                                                                                                    filteredData.forEach(item => {
                                                                                                        const resultItem = document.createElement('div');
                                                                                                        resultItem.className = 'autocomplete-item';
                                                                                                        resultItem.textContent = item;

                                                                                                        // Handle item click event
                                                                                                        resultItem.addEventListener('click', function() {
                                                                                                            input.value = item;
                                                                                                            resultsContainer.innerHTML = ''; // Clear results

                                                                                                            // Set the session key
                                                                                                            const sessionKey = '<?= $row_get_c['r_id'] ?>_' + <?= $count_order ?> + '_' + filteredData.indexOf(item);
                                                                                                            sessionStorage.setItem(sessionKey, item);
                                                                                                        });

                                                                                                        resultItem.addEventListener('mouseenter', function() {
                                                                                                            // Highlight the selected item on hover
                                                                                                            resultItem.classList.add('hovered');
                                                                                                        });

                                                                                                        resultItem.addEventListener('mouseleave', function() {
                                                                                                            // Remove the highlight when the mouse leaves
                                                                                                            resultItem.classList.remove('hovered');
                                                                                                        });

                                                                                                        resultsContainer.appendChild(resultItem);
                                                                                                    });
                                                                                                }
                                                                                            </script>

                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                <button type="button" class="btn btn-primary" onclick="submitForm<?= $row_get_c['r_id'] ?>()">Save changes</button>
                                                                                            </div>

                                                                                            <script>
                                                                                                function submitForm<?= $row_get_c['r_id'] ?>() {
                                                                                                    const form = document.getElementById('partsForm<?= $row_get_c['r_id'] ?>');
                                                                                                    const formData = new FormData(form);

                                                                                                    // Perform an AJAX request to submit the form
                                                                                                    $.ajax({
                                                                                                        url: form.action,
                                                                                                        type: form.method,
                                                                                                        data: formData,
                                                                                                        processData: false,
                                                                                                        contentType: false,
                                                                                                        success: function(response) {
                                                                                                            // Handle the response here (e.g., show a success message)
                                                                                                            console.log('Form submitted successfully', response);

                                                                                                            // Close the modal programmatically (adjust selector as needed)
                                                                                                            $('#myModal').modal('hide');
                                                                                                        },
                                                                                                        error: function(xhr, status, error) {
                                                                                                            // Handle errors here (e.g., display an error message)
                                                                                                            console.error('Form submission failed', error);
                                                                                                        }
                                                                                                    });
                                                                                                }
                                                                                            </script>
                                                                                        </form>
                                                                                    </div>


                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <script>
                                                                        // Simulated data for demonstration purposes
                                                                        const data<?= $row_get_c['r_id'] ?> = <?= json_encode($parts_ar) ?>;

                                                                        function searchFunction<?= $row_get_c['r_id'] ?>() {
                                                                            const input = document.getElementById('search-box<?= $row_get_c['r_id'] ?>');
                                                                            const resultsContainer = document.getElementById('search-results<?= $row_get_c['r_id'] ?>');
                                                                            const inputValue = input.value.toLowerCase();

                                                                            // Clear previous results
                                                                            resultsContainer.innerHTML = '';

                                                                            // Filter data based on input
                                                                            const filteredData = data<?= $row_get_c['r_id'] ?>.filter(item => item.toLowerCase().includes(inputValue));

                                                                            // Display matching results
                                                                            filteredData.forEach(item => {
                                                                                const resultItem = document.createElement('div');
                                                                                resultItem.className = 'autocomplete-item';
                                                                                resultItem.textContent = item;

                                                                                // Handle item click event
                                                                                resultItem.addEventListener('click', function() {
                                                                                    input.value = item;
                                                                                    resultsContainer.innerHTML = ''; // Clear results

                                                                                    // Set the session key
                                                                                    const sessionKey = '<?= $row_get_c['r_id'] ?>_' + <?= $count_order ?> + '_' + filteredData.indexOf(item);
                                                                                    sessionStorage.setItem(sessionKey, item);
                                                                                });

                                                                                resultItem.addEventListener('mouseenter', function() {
                                                                                    // Highlight the selected item on hover
                                                                                    resultItem.classList.add('hovered');
                                                                                });

                                                                                resultItem.addEventListener('mouseleave', function() {
                                                                                    // Remove the highlight when the mouse leaves
                                                                                    resultItem.classList.remove('hovered');
                                                                                });

                                                                                resultsContainer.appendChild(resultItem);
                                                                            });
                                                                        }
                                                                    </script>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    </div>
                                            </div>

                                            <br>
                                            <p style="color:red">*** โปรดกรอกรายละเอียดข้างต้นก่อนทำการเพิ่มรูปภาพ ***</p>
                                            <hr>
                                            <label for="DetailFormControlTextarea" class="form-label">เพิ่มรูปภาพหรือวิดีโอ *ไม่จำเป็น (สูงสุด 4 ไฟล์):</label>
                                            <a class="btn btn-primary" onclick="showInputDetail()">เพิ่มรูปภาพหรือวิดีโอ</a>
                                            <br>
                                            <div id="inputContainerDetail"></div>

                                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                                            <script>
                                                var clickCount = 0;

                                                function showInputDetail() {
                                                    var textarea = document.getElementById('DetailFormControlTextarea');
                                                    var textValue = textarea.value.trim();
                                                    if (textValue === '') {
                                                        return false; // Prevent form submission if there is no text input
                                                    }

                                                    clickCount++;

                                                    if (clickCount <= 4) {
                                                        var inputElement = document.createElement('div');
                                                        inputElement.classList.add('input-group', 'mb-3');

                                                        var fileInput = document.createElement('input');
                                                        fileInput.type = 'file';
                                                        fileInput.name = 'file' + clickCount;
                                                        fileInput.classList.add('form-control');
                                                        fileInput.addEventListener('change', function(event) {
                                                            showPreviewDetail(event.target);
                                                        });

                                                        var inputGroupText = document.createElement('span');
                                                        inputGroupText.classList.add('input-group-text');
                                                        inputGroupText.textContent = 'File ' + clickCount;

                                                        var deleteButton = document.createElement('button');
                                                        deleteButton.type = 'button';
                                                        deleteButton.classList.add('btn', 'btn-danger');
                                                        deleteButton.textContent = 'Delete';
                                                        deleteButton.addEventListener('click', function() {
                                                            inputElement.remove();
                                                            removeFileInputValue(fileInput.name); // Remove corresponding value
                                                        });

                                                        var previewElement = document.createElement('div');
                                                        previewElement.classList.add('preview');
                                                        previewElement.style.marginTop = '10px';

                                                        inputElement.appendChild(inputGroupText);
                                                        inputElement.appendChild(fileInput);
                                                        inputElement.appendChild(deleteButton);

                                                        var inputContainer = document.getElementById('inputContainerDetail');
                                                        inputContainer.appendChild(inputElement);
                                                        inputContainer.appendChild(previewElement);
                                                    }

                                                    return false; // Prevent form submission
                                                }

                                                function showPreviewDetail(input) {
                                                    var preview = input.parentNode.nextSibling; // Get the next sibling (preview element)
                                                    preview.innerHTML = '';

                                                    if (input.files && input.files[0]) {
                                                        var file = input.files[0];
                                                        var fileType = file.type;
                                                        var validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                                                        var validVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];

                                                        if (validImageTypes.includes(fileType)) {
                                                            var img = document.createElement('img');
                                                            img.src = URL.createObjectURL(file);
                                                            img.style.maxWidth = '200px';
                                                            preview.appendChild(img);
                                                        } else if (validVideoTypes.includes(fileType)) {
                                                            var video = document.createElement('video');
                                                            video.src = URL.createObjectURL(file);
                                                            video.style.maxWidth = '200px';
                                                            video.autoplay = true;
                                                            video.loop = true;
                                                            video.muted = true;
                                                            preview.appendChild(video);
                                                        }
                                                    }
                                                }

                                                function removeFileInputValue(inputName) {
                                                    var fileInput = document.querySelector('input[name="' + inputName + '"]');
                                                    if (fileInput) {
                                                        fileInput.value = ''; // Clear the file input value
                                                    }
                                                }

                                                function confirm_cen(event) {
                                                    event.preventDefault(); // Prevent the form from being submitted

                                                    Swal.fire({
                                                        title: 'คุณแน่ใจหรือไม่?',
                                                        text: 'คุณต้องการส่งข้อมูลนี้หรือไม่',
                                                        icon: 'question',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'ใช่',
                                                        cancelButtonText: 'ไม่'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // User confirmed, submit the form
                                                            document.getElementById('detail_status_id').submit();
                                                        }
                                                    });
                                                }
                                            </script>
                                            <!-- <input type="file" name="p_picture[]" id="p_pic" multiple accept="image/*,video/*" max="4">
                                        <h6>เพิ่มไฟล์</h6>
                                        <label for="p_pic" style="display: block; color: blue;">Choose file</label>
                                        <div id="media-container"></div> -->

                                            <script>
                                                function displayMedia(input) {
                                                    var container = document.getElementById("media-container");
                                                    container.innerHTML = ""; // Clear the container

                                                    // Loop through each selected file
                                                    for (var i = 0; i < input.files.length; i++) {
                                                        var file = input.files[i];

                                                        // Create a new media element for the file
                                                        var media;
                                                        if (file.type.startsWith("image/")) {
                                                            media = document.createElement("img");
                                                        } else if (file.type.startsWith("video/")) {
                                                            media = document.createElement("video");
                                                            media.controls = true; // Add video controls
                                                        } else {
                                                            continue; // Skip unsupported file types
                                                        }

                                                        media.style.maxWidth = "100%";
                                                        media.style.maxHeight = "200px";

                                                        // Use FileReader to read the contents of the file as a data URL
                                                        var reader = new FileReader();
                                                        reader.onload = function(event) {
                                                            // Set the src attribute of the media element to the data URL
                                                            media.src = event.target.result;
                                                        };
                                                        reader.readAsDataURL(file);

                                                        // Append the media element to the container
                                                        container.appendChild(media);
                                                    }
                                                }

                                                // Add an event listener to the file input to trigger the displayMedia function
                                                var fileInput = document.getElementById("p_pic");
                                                fileInput.addEventListener("change", function() {
                                                    displayMedia(this);
                                                });
                                            </script>


                                            <center>
                                                <br>
                                                <button class="btn btn-success" onclick="confirm_cen(event)">ยืนยัน</button>
                                            </center>
                                    </form>
                                </div>

                                <script>
                                    function showCancelValue() {
                                        document.getElementById('cancel_value_code').style.display = 'block';
                                        document.getElementById('detail_value_code').style.display = 'none';
                                    }

                                    function showDetailValue() {
                                        document.getElementById('cancel_value_code').style.display = 'none';
                                        document.getElementById('detail_value_code').style.display = 'block';
                                    }
                                </script>

                            <?php
                            } ?>

                            <?php
                            $get_r_id;
                            $sql_check_send = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' And del_flg = '0' And status_id = '19'";
                            $result_check_send = mysqli_query($conn, $sql_check_send);
                            $row_check_send = mysqli_fetch_array($result_check_send);

                            $statusIds = array("4", "17", "5", "19", "6", "7", "8", "9", "13", "10", "24", "20", "25", "21");

                            if (in_array($row['status_id'], $statusIds)) {
                                if ($row['rs_conf'] == NULL && !in_array($row['status_id'], ['5', '19', '6', '7', '8', '9', '13', '24', '10', '20', '25'])) {
                                    include('status_option/wait_respond.php');
                                } elseif ($row['status_id'] == '25') {
                                    include('status_option/pay_check.php');
                                } elseif ($row['status_id'] == '17' && $row_check_send[0] > 0) {
                                    $sql_c_conf_send = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' And del_flg = '0' And status_id = '17' And rs_id = '$rs_id' And rs_conf = '1'";
                                    $result_c_conf_send = mysqli_query($conn, $sql_c_conf_send);
                                    $row_c_conf_send = mysqli_fetch_array($result_c_conf_send);
                                    if ($row_c_conf_send) {
                                        include('status_option/send_back_conf.php');
                                    } else {
                                        include('status_option/send_back.php');
                                        // echo $rs_id;
                                    }
                                } elseif ($row['status_id'] == '20') {
                                    include('status_option/refuse_member.php');
                                } elseif ($row['status_id'] == '13') {
                                    include('status_option/config_cancel_option.php');
                                } elseif ($row['status_id'] == '10') {
                                    include('status_option/after_send.php');
                                } elseif ($row['rs_conf'] == '0' && $row['status_id'] != '5') {
                                    include('status_option/cancel_conf.php');
                                } elseif ($row['status_id'] == '8') {
                                    if ($row['rs_conf'] == 4) {
                                        include('status_option/pay_address.php');
                                    } else {
                                        include('status_option/pay_status.php');
                                    }
                                } elseif ($row['status_id'] == '9') {
                                    include('status_option/send_equipment.php');
                                } elseif ($row['rs_conf'] == '1' && $row['status_id'] != '5') {
                                    include('status_option/conf_status.php');
                                } elseif ($row['status_id'] == '5') {
                                    include('status_option/next_conf.php');
                                } elseif ($row['status_id'] == '19') {
                                    include('status_option/doing_status.php');
                                } elseif ($row['status_id'] == '6') {
                                    include('status_option/after_doing.php');
                                } elseif ($row['status_id'] == '7') {
                                    include('status_option/check_status.php');
                                }
                            }
                            ?>


                            <?php
                            if ($row['value_code'] == "succ" || $row['value_code'] == "cancel" || $row['value_code'] == "submit" || $row['value_code'] == "received" || $row['status_id'] == "11" || $row['status_id'] == "4" || $row1['status_id'] != "3" || $row1['status_id'] != '17' || $row1['status_id'] != '5') {
                            ?>
                                <form action="action/add_respond.php" method="POST" enctype="multipart/form-data" style="display:none">
                                <?php
                            } else {
                                ?>
                                    <form action="action/add_respond.php" method="POST" enctype="multipart/form-data" style="display:block">
                                    <?php
                                }
                                    ?>
                                    <!-- <form action="action/add_respond.php" method="POST" enctype="multipart/form-data" style="display:block"> -->
                                    <!-- <form action="action/add_respond.php" method="POST" enctype="multipart/form-data" style="display:block"> -->
                                    <div class="card-footer">
                                        <!-- Other form elements... -->
                                        <br>
                                        <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ </h1>
                                        <br>
                                        <div class="card-footer">

                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด :</label>
                                                <textarea class="form-control" name="rs_detail" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">สถานะ</label>&nbsp;&nbsp;
                                                <select class="form-select" name="status_id" aria-label="Default select example" onchange="toggleEx1Textarea()">
                                                    <option selected>เลือกสถานะ</option>
                                                    <?php
                                                    $sql_s = "SELECT * FROM status_type WHERE del_flg = '0' ORDER BY status_name ASC";
                                                    $result_s = mysqli_query($conn, $sql_s);
                                                    while ($row_s = mysqli_fetch_array($result_s)) {
                                                    ?><option value="<?= $row_s['status_id'] ?>"><?= $row_s['status_name'] ?></option><?php
                                                                                                                                    }
                                                                                                                                        ?>
                                                </select>
                                            </div>

                                            <div class="mb-3" id="ex1Textarea" style="display: none;">
                                                <label for="exampleFormControlTextarea1" class="form-label">ex1 :</label>
                                                <textarea class="form-control" name="ex1" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3" id="ex2Textarea" style="display: none;">
                                                <label for="exampleFormControlTextarea1" class="form-label">ex2 :</label>
                                                <textarea class="form-control" name="ex2" id="exampleFormControlTextarea2" rows="3" required></textarea>
                                            </div>

                                            <script>
                                                function toggleEx1Textarea() {
                                                    var statusSelect = document.querySelector('select[name="status_id"]');
                                                    var ex1Textarea = document.getElementById('ex1Textarea');
                                                    var ex2Textarea = document.getElementById('ex2Textarea');
                                                    var ex3Textarea = document.getElementById('ex3Textarea');
                                                    var ex4Textarea = document.getElementById('ex4Textarea');
                                                    if (statusSelect.value == 2) {
                                                        ex1Textarea.style.display = 'block';
                                                        document.getElementById('exampleFormControlTextarea1').required = true;
                                                        ex2Textarea.style.display = 'block';
                                                        document.getElementById('exampleFormControlTextarea2').required = true;
                                                    } else if (statusSelect.value == 3) {
                                                        ex1Textarea.style.display = 'block';
                                                        document.getElementById('exampleFormControlTextarea1').required = true;
                                                        ex2Textarea.style.display = 'none';
                                                        document.getElementById('exampleFormControlTextarea2').required = false;
                                                    } else {
                                                        ex1Textarea.style.display = 'none';
                                                        document.getElementById('exampleFormControlTextarea1').required = false;
                                                        ex2Textarea.style.display = 'none';
                                                        document.getElementById('exampleFormControlTextarea2').required = false;
                                                    }
                                                }
                                            </script>

                                            <div class="mb-3">
                                                <h6>อะไหล่</h6>
                                                <div id="cardContainer" style="display: none;">
                                                    <table class="table" id="cardSection"></table>
                                                </div>
                                                <button type="button" class="btn btn-primary" onclick="showNextCard()">Show Card</button>
                                            </div>

                                            <?php
                                            $sql_p = "SELECT * FROM parts WHERE del_flg = '0'";
                                            $result_p = mysqli_query($conn, $sql_p);
                                            $optionsHTML = "";
                                            while ($row_p = mysqli_fetch_array($result_p)) {
                                                $optionsHTML .= '<option value="' . $row_p['p_id'] . '" data-pic="../' . $row_p['p_pic'] . '" data-price="' . $row_p['p_price'] . '" data-name="' . $row_p['p_name'] . '">' . $row_p['p_name'] . '</option>';
                                            }

                                            // $sql_d = "SELECT * FROM get_detail 
                                            // LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                            // WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0'";
                                            // $result_d = mysqli_query($conn, $sql_d);
                                            // $optionsHTMLDetail = "";
                                            // while ($row_d = mysqli_fetch_array($result_d)) {
                                            //     $optionsHTMLDetail .= '<option value="' . $row_get_c['get_d_id'] . '"r_brand="../' . $row_get_c['r_brand'] . '" r_model"' . $row_get_c['r_model'] . '"r_number_model="' . $row_get_c['r_number_model'] . '">' .  $row_get_c['r_serial_number'] . '</option>';
                                            // }
                                            ?>

                                            <script>
                                                var partsOptions = '<?php echo $optionsHTML; ?>';
                                                var partsData = <?php echo json_encode($partsData); ?>;

                                                // var partsOptionsDetail = '<?php echo $optionsHTMLDetail; ?>';


                                                function showNextCard() {
                                                    cardCount++;
                                                    var cardContainer = document.getElementById("cardContainer");
                                                    var cardSection = document.getElementById("cardSection");
                                                    cardSection.innerHTML = ""; // Clear existing cards

                                                    for (var i = 1; i <= cardCount; i++) {
                                                        var cardId = "card" + i; // Unique ID for each card
                                                        cardValues[cardId] = cardValues[cardId] || 0; // Initialize card value to 0 if not set

                                                        var tableRow = document.createElement("tr");
                                                        tableRow.innerHTML = `
                                                                <td><img id="cardImg${i}" alt="Card image cap" style="max-width: 150px;"></td>
                                                                <td id="cardTitle${i}"></td>
                                                                <td>
                                                                    <select name="get_d_id_${i}" class="custom-select" id="inputGroupSelectGet${i}" onchange="showSelectedOptionGet_D(${i})">
                                                                        <option selected>กรุณาเลือกรายการซ่อมที่ต้องการ...</option>
                                                                        <?php
                                                                        $count_conf = 0;
                                                                        $sql_get_c = "SELECT * FROM get_detail 
                                                                                    LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                                                    WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                                                                        $result_get_c = mysqli_query($conn, $sql_get_c);
                                                                        while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                                                                            $count_conf++;
                                                                        ?>
                                                                             <option value="<?= $row_get_c['get_d_id'] ?>"> <?= $row_get_c['r_brand'] . " " . $row_get_c['r_model'] . " - Model : " . $row_get_c['r_number_model'] . " - Serial Number : " . $row_get_c['r_serial_number']  ?></option>
                                                                            <?php
                                                                        }
                                                                            ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="p_id${i}" class="custom-select" id="inputGroupSelect${i}" onchange="showSelectedOption(${i})">
                                                                        <option selected>Choose...</option>
                                                                        ${partsOptions}
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <div class="col-6 px-0">
                                                                            <input type="number" name="value_p${i}" id="${cardId}" value="1" class="form-control" onchange="calculateTotalPrice(${i})">
                                                                        </div>
                                                                        <div class="col-6 px-0">
                                                                            <div class="input-group-prepend">
                                                                                <button type="button" class="btn btn-primary" onclick="increment('${cardId}')">+</button>
                                                                                <button type="button" class="btn btn-danger" onclick="decrement('${cardId}')">-</button>
                                                                                <button type="button" class="btn btn-secondary" onclick="deleteCard('${cardId}')">Delete</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                               
                                                                <td>
                                                                    <input type="text" name="p_price_total${i}" id="cardPrice${i}" class="form-control" readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="p_price_total${i}" id="cardTotalPrice${i}" class="form-control" readonly value="0">
                                                                </td>
                                                            `;

                                                        cardSection.appendChild(tableRow); // Add new card row
                                                    }

                                                    cardContainer.style.display = "block"; // Show the card section

                                                    // Update the hidden input field value with the cardCount
                                                    document.getElementById("cardCountInput").value = cardCount;
                                                }

                                                function showSelectedOption(cardIndex) {
                                                    var selectElement = document.getElementById(`inputGroupSelect${cardIndex}`);
                                                    var selectedOption = selectElement.options[selectElement.selectedIndex];
                                                    var cardImg = document.getElementById(`cardImg${cardIndex}`);
                                                    var cardTitle = document.getElementById(`cardTitle${cardIndex}`);
                                                    var cardPrice = document.getElementById(`cardPrice${cardIndex}`);

                                                    // Retrieve the data attributes from the selected option
                                                    var pic = selectedOption.getAttribute("data-pic");
                                                    var name = selectedOption.getAttribute("data-name");
                                                    var p_price = selectedOption.getAttribute("data-price");
                                                    var partId = selectedOption.value;

                                                    // Update the card image and title with the selected option's data
                                                    cardImg.src = pic;
                                                    cardTitle.textContent = name;

                                                    // Assign the price value directly as a string
                                                    cardPrice.value = p_price;

                                                    // Find the selected part in the partsData array
                                                    var selectedPart = partsData.find(function(part) {
                                                        return part.p_id === partId;
                                                    });

                                                    if (selectedPart) {
                                                        // Update the input field value with the price from the database
                                                        var price = parseFloat(selectedPart.p_price);
                                                        cardPrice.value = parseInt(price).toString();
                                                    }

                                                    // Hide the selected option in the next select dropdown
                                                    selectedOption.style.display = "none";

                                                    // Disable the selected option to prevent selection
                                                    selectedOption.disabled = true;

                                                    // Calculate the total price when the option is selected
                                                    calculateTotalPrice(cardIndex);
                                                }

                                                function showSelectedOptionGet_D(cardIndex) {
                                                    var selectElement = document.getElementById(`inputGroupSelectGet${cardIndex}`);
                                                    var selectedOption = selectElement.options[selectElement.selectedIndex];
                                                    // var cardImg = document.getElementById(`cardImg${cardIndex}`);
                                                    // var cardTitle = document.getElementById(`cardTitle${cardIndex}`);
                                                    // var cardPrice = document.getElementById(`cardPrice${cardIndex}`);

                                                    // Retrieve the data attributes from the selected option
                                                    var pic = selectedOption.getAttribute("data-pic");
                                                    var name = selectedOption.getAttribute("data-name");
                                                    var p_price = selectedOption.getAttribute("data-price");
                                                    var partId = selectedOption.value;

                                                    // Update the card image and title with the selected option's data
                                                    cardImg.src = pic;
                                                    cardTitle.textContent = name;

                                                    // Assign the price value directly as a string
                                                    cardPrice.value = p_price;

                                                    // Find the selected part in the partsData array
                                                    var selectedPart = partsData.find(function(part) {
                                                        return part.p_id === partId;
                                                    });

                                                    if (selectedPart) {
                                                        // Update the input field value with the price from the database
                                                        var price = parseFloat(selectedPart.p_price);
                                                        cardPrice.value = parseInt(price).toString();
                                                    }

                                                    // Hide the selected option in the next select dropdown
                                                    selectedOption.style.display = "none";

                                                    // Disable the selected option to prevent selection
                                                    selectedOption.disabled = true;
                                                }


                                                function calculateTotalPrice(cardIndex) {
                                                    var quantityInput = document.getElementById(`card${cardIndex}`);
                                                    var priceInput = document.getElementById(`cardPrice${cardIndex}`);
                                                    var totalPriceInput = document.getElementById(`cardTotalPrice${cardIndex}`);

                                                    var quantity = parseFloat(quantityInput.value);
                                                    var price = parseInt(priceInput.value);
                                                    var totalPrice = quantity * price;

                                                    totalPriceInput.value = totalPrice.toFixed(3);
                                                }

                                                var cardCount = 0;
                                                var cardValues = {}; // Object to store card values

                                                function increment(inputId) {
                                                    var input = document.getElementById(inputId);
                                                    var value = parseInt(input.value);
                                                    input.value = value + 1;
                                                    cardValues[inputId] = value + 1; // Update card value in the object
                                                    calculateTotalPrice(inputId.slice(4)); // Calculate total price when incremented
                                                }

                                                function decrement(inputId) {
                                                    var input = document.getElementById(inputId);
                                                    var value = parseInt(input.value);
                                                    if (value > 0) {
                                                        input.value = value - 1;
                                                        cardValues[inputId] = value - 1; // Update card value in the object
                                                        calculateTotalPrice(inputId.slice(4)); // Calculate total price when decremented
                                                    }
                                                }

                                                function deleteCard(cardId) {
                                                    var cardContainer = document.getElementById("cardContainer");
                                                    var cardSection = document.getElementById("cardSection");

                                                    if (cardId in cardValues) {
                                                        delete cardValues[cardId]; // Remove card value from the object
                                                    }

                                                    var cardElement = document.getElementById(cardId);
                                                    if (cardElement) {
                                                        cardElement.closest("tr").remove(); // Remove the card row from the DOM
                                                    }

                                                    cardCount--; // Decrease the card count

                                                    if (cardCount === 0) {
                                                        cardContainer.style.display = "none"; // Hide the card section if there are no cards
                                                    }
                                                }
                                            </script>
                                            <br>
                                            <div class="mb-3">
                                                <!-- <input type="file" id="upload" hidden multiple>
                                            <h6>เพิ่มรูป</h6>
                                            <label for="upload" style="display: block; color: blue;">Choose file</label>
                                            <div id="image-container"></div> -->
                                                <div class="row file-input-container">
                                                    <div class="col-4">
                                                        <label for="picture_1">Select a file:</label>
                                                        <input type="file" id="picture_1" name="picture_1">
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="picture_2">Select a file:</label>
                                                        <input type="file" id="picture_2" name="picture_2">
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="picture_3">Select a file:</label>
                                                        <input type="file" id="picture_3" name="picture_3">
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="picture_4">Select a file:</label>
                                                        <input type="file" id="picture_4" name="picture_4">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <!-- <div class="mb-3 ">
                                            <label for="exampleFormControlInput1" class="form-label">รวมราคาอะไหร่</label>
                                            <input name="p_price_sum" type="text" class="form-control col-1" id="exampleFormControlInput1" required>
                                        </div> -->
                                            <div class="mb-3 ">
                                                <label for="exampleFormControlInput1" class="form-label">ค่าแรงช่าง</label>
                                                <?php
                                                if ($row['get_wages'] > 0) {
                                                ?>
                                                    <input name="get_wages" type="text" class="form-control col-1" id="exampleFormControlInput1" required value="<?= $row['get_wages'] ?>" placeholder="กรุณากรอกค่าแรงช่าง">
                                                <?php
                                                } else {
                                                ?>
                                                    <input name="get_wages" type="text" class="form-control col-1" id="exampleFormControlInput1" required placeholder="กรุณากรอกค่าแรงช่าง">
                                                <?php
                                                }
                                                ?>

                                            </div>
                                            <!-- <div class="mb-3 ">
                                            <label for="exampleFormControlInput1" class="form-label">ราคารวม</label>
                                            <input name="total" type="text" class="form-control col-1" id="exampleFormControlInput1" required>
                                            
                                            
                                        </div> -->
                                            <input type="hidden" name="cardCount" id="cardCountInput" value="0">
                                        </div>
                                        <div class="text-center pt-4">
                                            <input type="text" name="get_r_id" value="<?= $row['get_r_id'] ?>" hidden>
                                            <button type="submit" class="btn btn-success">ตอบกลับ</button>
                                        </div>
                                    </div>
                                    </form>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <?php
                include('bar/admin_footer.php')
                ?>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>



        <!-- Sweet Alert Show Start -->
        <?php
        if (isset($_SESSION['add_data_alert'])) {
            if ($_SESSION['add_data_alert'] == 0) {
                $id = 123; // Replace 123 with the actual ID you want to pass to the deletion action
        ?>
                <script>
                    Swal.fire({
                        title: 'ข้อมูลของคุณได้ถูกบันทึกแล้ว',
                        text: 'กด Accept เพื่อออก',
                        icon: 'success',
                        confirmButtonText: 'Accept'
                    });
                </script>
            <?php
                unset($_SESSION['add_data_alert']);
            } else if ($_SESSION['add_data_alert'] == 1) {
            ?>
                <script>
                    Swal.fire({
                        title: 'ข้อมูลของคุณไม่ได้ถูกบันทึก',
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
                        title: 'ข้อมูลของคุณได้ถูกลบแล้ว',
                        text: 'กด Accept เพื่อออก',
                        icon: 'success',
                        confirmButtonText: 'Accept'
                    });
                </script>
        <?php unset($_SESSION['add_data_alert']);
            }
        }
        ?>
        <!-- Sweet Alert Show End -->

        <script>
            const input = document.querySelector('#upload');
            const container = document.querySelector('#image-container');

            input.addEventListener('change', () => {
                const files = input.files;
                if (files) {
                    for (let i = 0; i < files.length; i++) {
                        const url = URL.createObjectURL(files[i]);
                        const imageContainer = document.createElement('div');
                        imageContainer.classList.add('image-container');

                        const image = document.createElement('img');
                        image.classList.add('preview-image');
                        image.setAttribute('src', url);

                        const deleteBtn = document.createElement('button');
                        deleteBtn.classList.add('delete-button');
                        deleteBtn.innerHTML = '&times;';

                        deleteBtn.addEventListener('click', () => {
                            imageContainer.remove();
                        });

                        imageContainer.appendChild(image);
                        imageContainer.appendChild(deleteBtn);
                        container.appendChild(imageContainer);
                    }
                }
            });
        </script>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
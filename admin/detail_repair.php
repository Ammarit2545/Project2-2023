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

    .modal {
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

    .modal.show {
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
</style>

<body id="page-top">


    <!-- Page Wrapper -->
    <div id="wrapper">


        <!-- Sidebar -->
        <?php
        include('bar/sidebar.php');
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Topbar -->
            <?php
            include('bar/topbar_admin.php');
            ?>
            <!-- End of Topbar -->

            <!-- Main Content -->
            <div id="content">



                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    $get_r_id = $_GET['id'];

                    $sql = "SELECT * FROM get_repair
                    LEFT JOIN repair ON repair.r_id = get_repair.r_id 
                    LEFT JOIN member ON member.m_id = repair.m_id
                    LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id
                    LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
                    WHERE get_repair.del_flg = '0' AND repair_status.del_flg = '0' AND get_repair.get_r_id = '$get_r_id' ORDER BY rs_date_time DESC";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);

                    $dateString = date('d-m-Y', strtotime($row['get_r_date_in']));
                    $date = DateTime::createFromFormat('d-m-Y', $dateString);
                    $formattedDate = $date->format('F / d / Y');
                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="m-0 font-weight-bold text-primary">หมายเลขแจ้งซ่อม : <?= $row['get_r_id'] ?></h1>
                            <h1 class="m-0 font-weight-bold text-success">Serial Number : <?= $row['r_serial_number'] ?></h1>
                            <h2>สถานะล่าสุด : <button style="background-color: <?= $row['status_color'] ?>; color : white;" class="btn btn"> <?= $row['status_name'] ?></h2></button>

                            <h6><?= $formattedDate ?></h6>
                        </div>
                        <br>
                        <div class="container">
                            <div class="row">
                                <div class="col">
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
                                <div class="col">
                                    <center>
                                        <h4><a href="#" onclick="openModalPart('quantitypart')">จำนวนอะไหล่ <i class="fa fa-chevron-right" style="color: gray; font-size: 17px;"></i></a></h4>
                                    </center>
                                </div>
                            </div>
                        </div>

                        <!--  Part modal -->
                        <div id="quantitypartModal" class="modal">
                            <div class="modal-content">
                                <h2>จำนวนอะไหล่ทั้งหมด</h2>
                                <button class="close-button btn btn-primary" onclick="closeModalStatus('quantitypart')" width="200px">
                                    <i class="fa fa-times"></i>
                                </button>
                                <!--  content for Part modal -->
                                <iframe src="mini_part_detail.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px;" class="no-scrollbar"></iframe>
                            </div>
                        </div>

                        <!--  Status modal -->
                        <div id="quantitystatusModal" class="modal">
                            <div class="modal-content">
                                <h1>สถานะ</h1>
                                <button class="close-button btn btn-primary" onclick="closeModalStatus('quantitystatus')" width="200px">
                                    <i class="fa fa-times"></i>
                                </button>
                                <!--  content for Status modal -->
                                <iframe src="mini_status.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px;" class="no-scrollbar"></iframe>
                            </div>
                        </div>


                        <script>
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
                        </script>
                        <hr>
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
                                        <h4>ได้รับการยืนยันการซ่อมแล้ว</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะ "ดำเนินการ" ไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php } else if ($row['rs_conf'] != NULL && $row['rs_conf'] == 0 && $row['status_id'] == 4) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4>ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
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
                                        <h4>ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
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
                                        <h4>ได้รับยืนยันการชำระเงินจากสมาชิกแล้ว</h4>
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
                                        <h4>รอการตอบกลับจากสมาชิก</h4>
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
                                        <h4>รอการตอบกลับจากสมาชิก</h4>
                                    </center>
                                </div>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == 0 && $row['status_id'] == 13) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4>ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
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
                                        <h4>ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
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
                                        <h4>รอการตอบกลับจากสมาชิก</h4>
                                    </center>
                                </div>
                                <br>
                            <?php
                            }
                            ?>
                            <div class="mb-3 row">
                                <h6 for="staticEmail" class="col-sm-1 col-form-label">ชื่อ</h6>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="staticEmail" value="<?= $row['m_fname']  ?>" placeholder="สวย" disabled>
                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">นามสกุล</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" value="<?= $row['m_lname']  ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-1 col-form-label">Brand :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" value="<?= $row['r_brand']  ?>" placeholder="Yamaha" disabled="disabled">
                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">Model :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" value="<?= $row['r_model']  ?>" placeholder="NPX8859" disabled="disabled">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-1 col-form-label">เบอร์โทรศัพท์</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" placeholder="000000000" value="<?= $row['get_tel']  ?>" disabled="disabled">
                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">บริษัท</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" placeholder="ไทยคมนาคม" value="<?php
                                                                                                                                if ($row['com_id'] == NULL) {
                                                                                                                                    echo "ไม่มีข้อมูล";
                                                                                                                                } else {
                                                                                                                                    $com_id = $row['com_id'];
                                                                                                                                    $sql_com = "SELECT * FROM company WHERE com_id = '$com_id'";
                                                                                                                                    $result_com = mysqli_query($conn, $sql_com);
                                                                                                                                    $row_com = mysqli_fetch_array($result_com);

                                                                                                                                    echo $row_com['com_name'];
                                                                                                                                }
                                                                                                                                ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="col-form-label">ที่อยู่ :</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?php
                                                                                                                                if ($row['get_add'] == NULL) {
                                                                                                                                    echo "ไม่มีข้อมูล";
                                                                                                                                } else {
                                                                                                                                    echo ($row['get_add']);
                                                                                                                                }
                                                                                                                                ?></textarea>
                            </div>
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
                                <label for="exampleFormControlTextarea1" class="col-form-label">รายละเอียด :</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?= $row_s['rs_detail']  ?></textarea>
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

                            <div class="mb-3">
                                <?php
                                $sql_pic3 = "SELECT * FROM repair_pic WHERE rs_id = '$rs_id' AND del_flg = 0 ";
                                $result_pic3 = mysqli_query($conn, $sql_pic3);
                                $roe_c =  mysqli_fetch_array($result_pic3);
                                if ($roe_c[0] == NULL) {
                                ?>
                                    <label for="exampleFormControlTextarea1" class="col-form-label" style="display:none">รูปภาพประกอบ <?= $get_r_id ?>:</label>
                                <?php
                                } else {
                                ?>
                                    <label for="exampleFormControlTextarea1" class="col-form-label">รูปภาพประกอบ <?= $get_r_id ?>:</label>
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
                                                <a href="#" style="margin-left: 20px;"><img src="../<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
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
                                            <div id="modal" class="modal">
                                                <span class="close" onclick="closeModal()">&times;</span>
                                                <video id="modal-video" controls class="modal-video"></video>
                                            </div>



                                            <!-- <h2><?= $row_pic['rp_pic'] ?></h2> -->
                                        <?php
                                        } else { ?> <h2>ไม่มีข้อมูล</h2> <?php
                                                                        }
                                                                    } ?>
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
                                    <script>
                                        function openModalVideo(element) {
                                            var modal = document.getElementById('modal');
                                            var modalVideo = document.getElementById('modal-video');
                                            modal.style.display = 'block';
                                            modalVideo.src = element.src;
                                            modalVideo.style.height = '90%';
                                            modalVideo.style.borderRadius = '2%';
                                            modal.classList.add('show');
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
                                    <form id="cancel_status_id" action="action/status/add_cencel_status.php" method="POST" enctype="multipart/form-data">
                                        <label for="cancelFormControlTextarea" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการ <p style="display:inline; color : red"> ปฏิเสธการซ่อม</p> :</label>
                                        <textarea class="form-control" name="rs_detail" id="cancelFormControlTextarea" rows="3" required placeholder="กรอกรายละเอียดในการปฏิเสธการซ่อม"></textarea>
                                        <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
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
                                    <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ </h1>
                                    <br>
                                    <form id="detail_status_id" action="action/status/add_detail_status.php" method="POST" enctype="multipart/form-data">
                                        <label for="DetailFormControlTextarea" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการส่ง <p style="display:inline; color : green"> รายละเอียด</p> :</label>
                                        <textarea class="form-control" name="rs_detail" id="DetailFormControlTextarea" rows="3" required placeholder="กรอกรายละเอียดในการรายละเอียดการซ่อม"></textarea>
                                        <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
                                        <input type="hidden" name="cardCount" id="cardCountInput" value="0">
                                        <br>
                                        <label for="basic-url" class="form-label">ค่าแรงช่าง *แยกกับราคาอะไหล่</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon3">ค่าแรงช่าง</span>
                                            <input name="get_wages" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" required>
                                        </div>
                                        <br>
                                        <div class="mb-3">
                                            <h6>อะไหล่</h6>
                                            <div id="cardContainer" style="display: none;">
                                                <table class="table" id="cardSection"></table>
                                            </div>
                                            <button type="button" class="btn btn-primary" onclick="showNextCard()">เพิ่มอะไหล่</button>
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

                            <?php $statusIds = array("4", "17", "5", "19", "6", "7", "8", "9", "13", "10", "24", "20");
                            if (in_array($row['status_id'], $statusIds)) {
                                if ($row['rs_conf'] == NULL && $row['status_id'] != '5' && $row['status_id'] != '19' && $row['status_id'] != '6' && $row['status_id'] != '7' && $row['status_id'] != '8' && $row['status_id'] != '9' && $row['status_id'] != '13' && $row['status_id'] != '24' && $row['status_id'] != '10' && $row['status_id'] != '20') {
                                    include('status_option/wait_respond.php');
                                } elseif ($row['status_id'] == '20') {
                                    // ถูกปฏิเสธจากลูกค้า
                                    include('status_option/refuse_member.php');
                                } elseif ($row['status_id'] == '13') {
                                    include('status_option/config_cancel_option.php');
                                } elseif ($row['status_id'] == '10') {
                                    // ส่งเครื่องเสียงเสร็จสิ้น ***รอให้ลูกค้าตรวจสอบการซ่อม
                                    include('status_option/after_send.php');
                                } else if ($row['rs_conf'] == '0' && $row['status_id'] != '5') {
                                    include('status_option/cancel_conf.php');
                                } else if ($row['status_id'] == '8') {
                                    include('status_option/pay_status.php');
                                } else if ($row['status_id'] == '9') {
                                    // สถานะชำระเงินเสร็จสิ้น ไป สถานะส่งเครื่องเสียง
                                    include('status_option/send_equipment.php');
                                } else if ($row['rs_conf'] == '1' && $row['status_id'] != '5') {
                                    include('status_option/conf_status.php');
                                } elseif ($row['status_id'] == '5') {
                                    include('status_option/next_conf.php');
                                } elseif ($row['status_id'] == '19') {
                                    include('status_option/doing_status.php');
                                } else if ($row['status_id'] == '6') {
                                    include('status_option/after_doing.php');
                                } else if ($row['status_id'] == '7') {
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
                                            ?>

                                            <script>
                                                var partsOptions = '<?php echo $optionsHTML; ?>';
                                                var partsData = <?php echo json_encode($partsData); ?>;

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

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

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
</body>

</html>
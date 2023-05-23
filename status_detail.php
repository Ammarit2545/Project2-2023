<?php
session_start();
include('database/condb.php');
$id = $_SESSION['id'];

$sql1 = "SELECT * FROM member WHERE m_id = '$id '";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);
if ($id == NULL) {
    header('Location: home.php');
}
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
    <title>Status - ANE</title>

    <style>
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
    </style>
</head>

<body>
    <!-- navbar-->
    <?php
    if ($row1 > 0) {
        include('bar/topbar_invisible.php');
    }
    $id_get_r = $_GET['id'];
    $sql = "SELECT * FROM get_repair
        LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id 
        LEFT JOIN status_type ON repair_status.status_id  = status_type.status_id 
        WHERE get_repair.get_r_id = $id_get_r ORDER BY repair_status.rs_date_time DESC;";
    $result = mysqli_query($conn, $sql);

    $sql2 = "SELECT * FROM get_repair
        LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id 
        LEFT JOIN status_type ON repair_status.status_id  = status_type.status_id 
        WHERE get_repair.get_r_id = $id_get_r ORDER BY repair_status.rs_date_time DESC;";
    $result2 = mysqli_query($conn, $sql2);
    $row_2 = mysqli_fetch_array($result2);

    $sql_c = "SELECT * FROM get_repair LEFT JOIN repair ON repair.r_id = get_repair.r_id WHERE get_r_id = '$id_get_r' AND del_flg = '0'";
    $result_c = mysqli_query($conn, $sql_c);
    $row_c = mysqli_fetch_array($result_c);
    ?>
    <!-- end navbar-->

    <!-- <div class="background"></div> -->
    <br><br>
    <div class="px-5 pt-5 repair">
        <div class="container">
            <div class="row">

                <div class="col-6 text-left" style="background-color: #F1F1F1;">
                    <h3 class="pt-5"><button class="btn btn-primary">ยี่ห้อ : <?= $row_c['r_brand'] ?> , รุ่น : <?= $row_c['r_model'] ?></button></h3>
                    <h3 class="pt-2">เลข Serial Number : <?= $row_c['r_serial_number'] ?></h3>
                    <h3 class="pb-5">เลขที่ใบรับซ่อมที่ : <?= $row_c['get_r_id'] ?></h3>
                </div>
                <div class="col-6" style="background-color: #F1F1F1;">
                    <h3 class="pt-5 text-center"><button class="btn btn-primary">รายละเอียดการซ่อม : </button></h3>
                    <p class="pt-2 text-center"><?= $row_c['get_r_detail'] ?>
                    <p>
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
                <div class="">
                    <h4 style="margin-left: 1.2rem;">Status (สถานะ)</h4>

                    <ul class="timeline-3">
                        <?php
                        while ($row1 = mysqli_fetch_array($result)) {
                            $i = $i + 1;
                            $id_r = $row1[0];
                            $sql_c = "SELECT * FROM get_repair WHERE r_id = '$id_r' AND del_flg = '0' ORDER BY get_r_id DESC LIMIT 1";
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
                        ?>
                            <li>
                                <h6><i class="uil uil-clock"></i>&nbsp;<?= $formattedDate ?> เวลา <?= date('H:i:s', strtotime($row_c['get_r_date_in'])); ?></h6>
                                <h5><button class="btn btn-outline-secondary" style="color : white; background-color : <?= $row1['status_color'] ?>; border : 2px solid <?= $row1['status_color'] ?>;"><?= $row1['status_name'] ?></button></h5>
                                <p class="mt-2"><?= $row1['rs_detail'] ?></p>
                                <!-- <button class="btn btn_custom" type="button">ยืนยัน</button> -->
                                <div class="col text-left" style="background-color: #F1F1F1;">
                                    <!-- <h3 class="pt-5"><button class="btn btn-primary">รูปภาพ : </button></h3>
                                     -->
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
                                        <!-- <img src="<?= $row_pic['rp_pic'] ?>" width="100px"> -->
                                        <a href="#"><img src="<?= $row_pic['rp_pic'] ?>" width="100px" class="picture_modal" alt="" onclick="openModal(this)"></a>
                                    <?php
                                    } ?>
                                </div>
                                <div id="modal" class="modal">
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <img id="modal-image" src="" alt="Modal Photo">
                                </div>

                                <script src="script.js"></script>
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
                                </script>
                            </li>
                            <br>
                        <?php } ?>

                        <!-- <li>
                            <h6><i class="uil uil-clock"></i>&nbsp;21 March, 2014</h6>
                            <h5>การซ่อมเสร็จสิ้น/รอการชำระเงิน</h5>
                            <p class="mt-2">แจ้งการนัดรับสินค้าหรือแจ้งการจัดส่งสินค้าหลังชำระเงิน</p>
                            <button class="btn btn_custom_wearn" type="button">ชำระเงิน</button>
                        </li>
                        <li>
                            <h6><i class="uil uil-clock"></i>&nbsp;21 March, 2014</h6>
                            <h5>กำลังดำเนินการซ่อม</h5>
                        </li> -->
                        <!-- <li>
                            <h6><i class="uil uil-clock"></i>&nbsp;21 March, 2014</h6>
                            <h5>เกิดปัญหาขึ้นระหว่างซ่อม (ซ่อมต่อ)</h5>
                            <p class="mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam
                                non nisi semper, et elementum lorem ornare. Maecenas placerat facilisis mollis. Duis sagittis
                                ligula in sodales vehicula....</p>
                            <div class="row">
                                <div class="col-4">
                                    <img src="img/1.jpg" alt="" class="img-fluid">
                                </div>
                                <div class="col-4">
                                    <p>หย่องล่างกีต้าร์ไฟฟ้าแบบเดียว PS-001 ZX</p>
                                    <p>ราคา 55.00 บาท </p>
                                    <p>จำนวน 2 ชิ้น</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <img src="img/2.png" alt="" class="img-fluid">
                                </div>
                                <div class="col-4">
                                    <p>หย่องล่างกีต้าร์ไฟฟ้าแบบคู่ PS-001 ZX</p>
                                    <p>ราคา 100.00 บาท </p>
                                    <h5>จำนวน 2 ชิ้น</h5>
                                    <p style="color: red;">รอของ 3 วัน</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <h6><i class="uil uil-clock"></i>&nbsp;21 March, 2014</h6>
                            <h5>อยู่ระหว่างการซ่อม</h5>
                        </li>
                        <li>
                            <h6><i class="uil uil-clock"></i>&nbsp;21 March, 2014</h6>
                            <h5>ได้รับเครื่องของคุณแล้ว</h5>
                        </li>
                        <li>
                            <h6><i class="uil uil-clock"></i>&nbsp;21 March, 2014</h6>
                            <h5>ยืนยันการซ่อมแล้ว</h5>
                            <button class="btn btn_custom_wearn" type="button">ใบแจ้งซ่อม</button>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
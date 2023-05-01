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
    <title>Status - ANE</title>
</head>

<body>

    <!-- navbar-->
    <?php
    if ($row1 > 0) {
        include('bar/topbar_invisible.php');
    }


    ?>
    <!-- end navbar-->

    <div class="background"></div>

    <div class="px-5 pt-5 repair">
        <h1 class="pt-5 text-center">รุ่น ............. <?= $id  ?></h1>
        <h1 class="pt-2 text-center">เลข Serial Number .....................</h1>
        <h1 class="pt-2 text-center">เลขที่ใบรับซ่อม ........................</h1>
        <div class="container my-5">
            <div class="row">
                <div class="">
                    <h4 style="margin-left: 1.2rem;">Latest News</h4>
                    <ul class="timeline-3">
                        <li>
                            <h6><i class="uil uil-clock"></i>&nbsp;21 March, 2014</h6>
                            <h5>ชำระเงินเรียบร้อย</h5>
                            <p class="mt-2">แจ้งการนัดรับสินค้าหรือแจ้งการจัดส่งสินค้าหลังชำระเงิน</p>
                            <button class="btn btn_custom" type="button">ยืนยัน</button>
                        </li>
                        <li>
                            <h6><i class="uil uil-clock"></i>&nbsp;21 March, 2014</h6>
                            <h5>การซ่อมเสร็จสิ้น/รอการชำระเงิน</h5>
                            <p class="mt-2">แจ้งการนัดรับสินค้าหรือแจ้งการจัดส่งสินค้าหลังชำระเงิน</p>
                            <button class="btn btn_custom_wearn" type="button">ชำระเงิน</button>
                        </li>
                        <li>
                            <h6><i class="uil uil-clock"></i>&nbsp;21 March, 2014</h6>
                            <h5>กำลังดำเนินการซ่อม</h5>
                        </li>
                        <li>
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
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
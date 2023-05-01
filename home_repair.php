<?php
session_start();
include('database/condb.php');

if(!isset($_SESSION["id"])){
    header('Location:home.php');
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
    <link rel="stylesheet" href="css/repair.css">
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <title>ANE - Repair</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
</head>

<body>

    <!-- navbar-->
    <?php
    include('bar/topbar_invisible.php');
    ?>
    <!-- end navbar-->

    <!-- <div class="background"></div> -->

    <div class="px-5 pt-5 edit">
        <h1 class="pt-5 text-center">การบริการส่งซ่อม ANE Electronic</h1>
        <center>
            <p>กรุณาเลือกประเภทรายการที่ต้องการซ่อม</p>
        </center>
        <br>
        <div class="container mt-4">
            <div class="row">
                <div class="col-6">
                    <center>
                        <a href="repair_gua.php" type="button" class="button">มีประกันทางร้าน</a>
                    </center>
                </div>

                <div class="col-6">
                    <center>
                        <a href="repair_non_gua.php" type="button" class="button">ไม่มีประกันทางร้าน</a>
                    </center>
                </div>
            </div>
            <br>
            <div class="row mt-4">
                <div class="col-1"></div>
                <div class="col-10">
                    <br><br>
                    <h4>แจ้งเตือน</h4>
                    <p style="font-size:14px">
                        1.ค่าใช้จ่ายในการขนส่งของบริการส่งซ่อม บริษัท MY SHOP จะเป็นผู้รับผิดชอบ<br>

                        2.บริการส่งซ่อมให้บริการเฉพาะอะไหล่แท้ โปรดอ่านเงื่อนไขการรับประกันบน เว็บไซต์ทางการของ MY SHOP (กิจกรรมมอบของสมนาคุณ/ของขวัญไม่ สามารถใช้ในบริการส่งซ่อมได้)<br>

                        3.โปรดนำอุปกรณ์เสริมออกจากกล่องและสำรองข้อมูลสำคัญส่วนบุคคลก่อน ทำการส่งซ่อม ทาง MY SHOP จะไม่รับผิดชอบต่อข้อมูลที่เสียหายหรือสูญหาย<br>

                        4.คุณสามารถตรวจสอบสถานะการส่งซ่อมได้โดยคลิกที่ 'รายการการส่งซ่อม' ใส่หมายเลขโทรศัพท์ของคุณและรหัสยืนยันเพื่อตรวจสอบสถานะ<br>

                        5.หากโทรศัพท์มือถือของคุณไม่สามารถเปิดได้ หรือคุณลืมรหัสผ่านหน้าจอล็อก ฯลฯ ขอแนะนำให้คุณไปที่ศูนย์บริการพร้อมหลักฐานการซื้อเพื่อขอความช่วยเหลือเพิ่มเติม<br>

                    </p>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
    </div>


    <!-- footer-->
    <?php include('footer/footer.php') ?>
    <!-- end footer-->

    <script>
        // Show full page LoadingOverlay
        $.LoadingOverlay("show");

        // Hide it after 3 seconds
        setTimeout(function() {
            $.LoadingOverlay("hide");
        }, 10);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
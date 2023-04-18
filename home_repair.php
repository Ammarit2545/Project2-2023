<?php
session_start();
include('database/condb.php');
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
    <title>ANE - Repair</title>
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
                        <a type="button" class="button">มีประกันทางร้าน</a>
                    </center>
                </div>
                
                <div class="col-6">
                    <center>
                        <a type="button" class="button">ไม่มีประกันทางร้าน</a>
                    </center>
                </div>
            </div>
            <br>
            <div class="row mt-4">
                <div class="col-2"></div>
                <div class="col-8">
                   <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum ad blanditiis maiores nobis architecto, mollitia, eaque labore veritatis corrupti totam consequatur. Quos dolorum iste quis earum architecto distinctio soluta placeat!</p>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </div>


    <!-- footer-->
    <div class="container-fluid fixed-bottom" style="background-color: #000141;">
        <footer class="my-4 px-5">
            <div class="">
                <p style="color: white;">Copyright © 2023 MY SHOP. สงวนสิทธิ์ทุกประการ</p>
                <p style="color: white;">ติดต่อ 0000-00-0000 </p>
            </div>
        </footer>
    </div>
    <!-- end footer-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
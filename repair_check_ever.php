<?php
session_start();
include('database/condb.php');

$id = $_SESSION["id"];

$sql = "SELECT * FROM member WHERE m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/repair_non_gua.css">
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <title>ANE - Support</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
</head>

<body>

    <!-- navbar-->
    <?php
    include('bar/topbar_invisible.php');

    $id = $_SESSION["id"];

    $sql = "SELECT * FROM member WHERE m_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $id_r = $_SESSION["id_repair"];
    $name_brand = $_SESSION["name_brand"];
    $serial_number = $_SESSION["serial_number"];
    $name_model = $_SESSION["name_model"];
    $number_model = $_SESSION["number_model"];
    $tel = $_SESSION["tel"];
    $description = $_SESSION["description"];

    $id = $_SESSION["id"];

?>
    <!-- end navbar-->

    <div class="background"></div>

    <div class="px-5 pt-5 edit">
        <h1 class="pt-5 text-center">ตรวจเช็คข้อมูลก่อนทำการบันทึก</h1>
        <center>
            <p>ข้อมูลถูกต้องหรือไม่</p>
        </center>
        <br>
        <form action="action/add_repair_ever_db.php" method="POST">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="name_brand" placeholder="ชื่อยี่ห้อ" value="<?= $name_brand ?>" readonly require>
                                <input type="text" class="form-control input" id="borderinput" name="id_repair" readonly placeholder="ไอดี" value="<?= $id_r ?>" style="display:none">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="serial_number" placeholder="ไม่มีเลข Serial Number" value="<?= $serial_number ?>" readonly>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="name_model" placeholder="ชื่อรุ่น" value="<?= $name_model ?>" readonly require>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="number_model" placeholder="ไม่มีหมายเลขรุ่น" value="<?= $number_model ?>" readonly>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col">
                                <label for="borderinput1" class="form-label">หมายเลขโทรศัพท์</label>
                                <input type="text" class="form-control" id="borderinput1" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $tel ?>" readonly require>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="mb-3">
                                <label for="inputtext" class="form-label">รายละเอียดการซ่อม</label>
                                <textarea class="form-control" id="inputtext" rows="3" name="description" readonly require><?= $description ?></textarea>
                            </div>

                            <div class="text-center pt-4">
                                <a href="repair_edit.php?id=1" class="btn btn-danger">แก้ไขข้อมูล</a>
                                <button type="submit" class="btn btn-success">ยืนยัน</button>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </form>


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
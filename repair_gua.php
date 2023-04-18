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
    ?>
    <!-- end navbar-->

    <!-- <div class="background"></div> -->

    <div class="px-5 pt-5 edit">
        <h1 class="pt-5 text-center">การบริการส่งซ่อม</h1>
        <center>
            <p>แบบมีประกันทางร้าน</p>
        </center>
        <form action="action/edit_user.php" method="POST">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <br>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control input" id="borderinput" name="tel" placeholder="ชื่อยี่ห้อ">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control input" id="borderinput" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="mb-3">
                                <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                                <textarea class="form-control" id="inputtext" rows="3"></textarea>
                            </div>

                            <div class="text-center pt-4">
                                <button type="button" class="btn btn-success">ยืนยัน</button>
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
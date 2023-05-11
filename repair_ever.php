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
    $id_r = $_GET["id"];

    $sql1 = "SELECT * FROM repair WHERE r_id = '$id_r ' AND m_id = '$id'";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $company = $row1['com_id'];

    $sql2 = "SELECT * FROM get_repair WHERE r_id = '$id_r'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);
    
    if($row2['get_r_detail'] == NULL){
        $description = $_SESSION["description"];
    }else{
        $description = $row2['get_r_detail'];
    }
    

    $sql = "SELECT * FROM member WHERE m_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    ?>
    <!-- end navbar-->

    <div class="background"></div>

    <div class="px-5 pt-5 edit">
        <h1 class="pt-5 text-center">ระบบได้ตรวจพบหมายเลขรุ่นนี้ในระบบ</h1>
        <center>
            <p>คุณต้องการใช้รายละเอียดการซ่อม"เดิม"หรือไม่ ถ้าใช่กด "ยืนยัน"</p>
        </center>
        <br>
        <form action="action/add_rapair_ever.php" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="name_brand" readonly placeholder="ชื่อยี่ห้อ" value="<?= $row1['r_brand'] ?>">
                                <input type="text" class="form-control input" id="borderinput" name="id_repair" readonly placeholder="ไอดี" value="<?= $id_r ?>" style="display:none">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="serial_number" readonly placeholder="เลข Serial Number(ไม่จำเป็น)" value="<?= $row1['r_serial_number'] ?>">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="name_model" readonly placeholder="ชื่อรุ่น" value="<?= $row1['r_model'] ?>">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="number_model" readonly placeholder="หมายเลขรุ่น  (ไม่จำเป็น)" value="<?= $row1['r_number_model'] ?>">
                            </div>
                        </div>
                        <br>

                        <?php
                        $com_check = $row1['com_id'];
                        if ($com_check != NULL) {
                            $sql_c = "SELECT * FROM company WHERE com_id = '$company' AND del_flg = '0'";
                            $result_c = mysqli_query($conn, $sql_c);
                            $row_c = mysqli_fetch_array($result_c);

                            $company = $row_c['com_name'];
                        ?>
                            <div class="row">
                                <div class="col-6">
                                    <label for="borderinput1" class="form-label">หมายเลขโทรศัพท์</label>
                                    <?php if($row2['get_tel'] != NULL){
                                        ?><input type="text" class="form-control" id="borderinput" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $row2['get_tel'] ?>" readonly require><?php
                                    }else{
                                        ?><input type="text" class="form-control" id="borderinput" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $_SESSION['tel'] ?>" readonly require><?php
                                    } ?>
                                    
                                </div>
                                <div class="col-6">
                                    <label for="borderinput1" class="form-label">ชื่อบริษัท</label>
                                    <input type="text" class="form-control" id="borderinput" name="show_company" placeholder="กรุณากรอกชื่อบริษัท" value="<?= $company ?>" readonly require>
                                    <input type="text" class="form-control" id="borderinput" name="company" placeholder="กรุณากรอกชื่อบริษัท" value="<?= $row_c['com_id'] ?>" readonly require style="display:none">
                                </div>
                            </div>
                            <br>
                            <label for="borderinput1" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="file" name="image1" onchange="previewImage('image-preview1')" id="fileToUpload">
                                </div>
                                <div class="col-3">
                                    <input type="file" name="image2" onchange="previewImage('image-preview2')" id="fileToUpload">
                                    <div id="image-preview2"></div>
                                </div>
                                <div class="col-3">
                                    <input type="file" name="image3" onchange="previewImage('image-preview3')" id="fileToUpload">
                                    <div id="image-preview3"></div>
                                </div>
                                <div class="col-3">
                                    <input type="file" name="image4" onchange="previewImage('image-preview4')" id="fileToUpload">
                                    <div id="image-preview4"></div>
                                </div>

                                <script>
                                    function previewImage(previewId) {
                                        var input = event.target;
                                        var previewContainer = document.getElementById(previewId);
                                        var previewImage = document.createElement('img');

                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                previewImage.setAttribute('src', e.target.result);
                                                previewContainer.appendChild(previewImage);
                                            };
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>

                            </div>
                            <br>
                            <br>
                            <?php } else {
                            $tel = $row2['get_tel'];
                            if ($tel) {
                            ?>
                                <div class="row">
                                    <div class="col">
                                        <label for="borderinput1" class="form-label">หมายเลขโทรศัพท์</label>
                                        <input type="text" class="form-control" id="borderinput1" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $row2['get_tel'] ?>" readonly require>
                                    </div>
                                </div>
                                <br>

                            <?php
                            } else {
                            ?>
                                <div class="row">
                                    <div class="col">
                                        <label for="borderinput1" class="form-label">หมายเลขโทรศัพท์</label>
                                        <input type="text" class="form-control" id="borderinput1" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $_SESSION['tel'] ?>" require>
                                    </div>
                                </div>
                                <br>
                                <label for="borderinput1" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ</label>
                                <div class="row">
                                    <div class="col-3">
                                        <input type="file" name="image1" onchange="previewImage('image-preview1')" id="fileToUpload">
                                    </div>
                                    <div class="col-3">
                                        <input type="file" name="image2" onchange="previewImage('image-preview2')" id="fileToUpload">
                                        <div id="image-preview2"></div>
                                    </div>
                                    <div class="col-3">
                                        <input type="file" name="image3" onchange="previewImage('image-preview3')" id="fileToUpload">
                                        <div id="image-preview3"></div>
                                    </div>
                                    <div class="col-3">
                                        <input type="file" name="image4" onchange="previewImage('image-preview4')" id="fileToUpload">
                                        <div id="image-preview4"></div>
                                    </div>

                                    <script>
                                        function previewImage(previewId) {
                                            var input = event.target;
                                            var previewContainer = document.getElementById(previewId);
                                            var previewImage = document.createElement('img');

                                            if (input.files && input.files[0]) {
                                                var reader = new FileReader();
                                                reader.onload = function(e) {
                                                    previewImage.setAttribute('src', e.target.result);
                                                    previewContainer.appendChild(previewImage);
                                                };
                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        }
                                    </script>

                                </div>
                                <br>
                            <?php
                            } ?>
                        <?php } ?>
                        <div class="row">
                            <div class="mb-3">
                                <label for="inputtext" class="form-label" style="color:red">กรุณากรอกรายละเอียด (กรณีไม่ใช้ข้อมูลเดิม)</label>
                                <textarea class="form-control" id="inputtext" rows="3" name="description" required><?= $description ?></textarea>
                            </div>

                            <div class="text-center pt-4">
                                <button type="submit" class="btn btn-success">ยืนยัน</button>

                                <a href="">ข้อมูลไม่ถูกต้อง?</a>

                                <!-- <a herf="repair_non_gua.php" class="btn btn-warning">กลับไปหน้าส่งซ่อม</a> -->
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </form>


    </div>
    </div>


    <!-- footer-->
    <?php
    // include('footer/footer.php') 
    ?>
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
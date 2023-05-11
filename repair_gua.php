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
    <style>
        .file-input {
            display: inline-block;
            width: 20px;
        }

        .preview-container {
            display: inline-block;
            width: 20px;
        }

        .preview_pic {
            width: 0.02px;
        }
    </style>
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

    <div class="background"></div>

    <div class="px-5 pt-5 edit">
        <h1 class="pt-5 text-center">การบริการส่งซ่อม</h1>
        <center>
            <p>แบบมีกับมีประกันทางร้าน</p>
        </center>
        <form action="action/add_repair_gua.php" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <label for="tel">ชื่อยี่ห้อ</label>
                                <input type="text" class="form-control input" id="borderinput" name="name_brand" placeholder="กรุณากรอก ชื่อยี่ห้อ" required>
                            </div>
                            <div class="col-6">
                                <label for="tel">เลข Serial Number</label>
                                <input type="text" class="form-control input" id="borderinput" name="serial_number" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-6">
                                <label for="tel">ชื่อรุ่น</label>
                                <input type="text" class="form-control input" id="borderinput" name="name_model" placeholder="กรุณากรอก ชื่อรุ่น" required>
                            </div>
                            <div class="col-6">
                                <label for="tel">หมายเลขรุ่น</label>
                                <input type="text" class="form-control input" id="borderinput" name="number_model" placeholder="กรุณากรอก หมายเลขรุ่น  (ไม่จำเป็น)">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-6">
                                <label for="tel">หมายเลขโทรศัพท์</label>
                                <input type="text" class="form-control" id="borderinput" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $row['m_tel'] ?>" required>
                            </div>
                            
                            <div class="col-6">
                                <label for="tel">ชื่อบริษัท</label>
                                <select class="form-select" aria-label="Default select example" name="company">
                                    <option selected>กรุณาเลือกบริษัท</option>
                                    <?php
                                    $sql_c = "SELECT * FROM company WHERE del_flg = '0'";
                                    $result_c = mysqli_query($conn, $sql_c);
                                    while ($row_c = mysqli_fetch_array($result_c)) {
                                    ?><option value="<?= $row_c['com_id'] ?>"><?= $row_c['com_name'] ?></option><?php
                                    }
                                ?>
                                </select>
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


                        <!-- <label for="borderinput1" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ</label>
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
                        <br> -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                                <textarea class="form-control" id="inputtext" rows="3" name="description" required placeholder="กรุณากรอกรายละเอียด"></textarea>
                            </div>

                            <div class="text-center pt-4">
                                <a href="repair_have.php" class="btn btn-primary" style="color:white">เคยซ่อมแล้วหรือไม่?</a>
                                <button type="submit" class="btn btn-success" value="Upload Image" name="submit">ยืนยัน</button>

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
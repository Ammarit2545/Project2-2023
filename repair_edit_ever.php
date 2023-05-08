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

    $id_repair = $_SESSION["id_repair"];
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
        <h1 class="pt-5 text-center">การบริการส่งซ่อม</h1>
        <center>
            <p>แบบไม่มีกับมีประกันทางร้าน</p>
        </center>
        <?php 
        $company_check = $_SESSION["company"];

        $id = $_GET["id"];
        if($company_check != NULL){
           ?><form action="action/add_repair_gua.php" method="POST"><?php
        }else{
            ?><form action="action/add_repair_non_gua.php" method="POST">
            <?php
        }
        ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="name_brand" placeholder="ชื่อยี่ห้อ" value="<?= $name_brand ?>" required>
                                <?php
                                    if($id != NULL){
                                    ?><input type="text" class="form-control input" id="borderinput" name="id_repair" placeholder="ไอดี" value="<?= $id_repair ?>" required style="display:none"><?php
                                    }
                                    ?>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="serial_number" placeholder="เลข Serial Number  (ไม่จำเป็น)" value="<?= $serial_number ?>">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="name_model" placeholder="ชื่อรุ่น" value="<?= $name_model ?>" required>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control input" id="borderinput" name="number_model" placeholder="หมายเลขรุ่น  (ไม่จำเป็น)" value="<?= $number_model ?>">
                            </div>
                        </div>
                        <br>

                        <?php 
                        $company = $_SESSION["company"];
                        if($company != NULL) {
                                $sql_c = "SELECT * FROM company WHERE com_id = '$company' AND del_flg = '0'";
                                $result_c = mysqli_query($conn, $sql_c);
                                $row_c = mysqli_fetch_array($result_c);

                                
                            ?>
                        <div class="row">
                            <div class="col-6">
                                <label for="borderinput1" class="form-label">หมายเลขโทรศัพท์</label>
                                <input type="text" class="form-control" id="borderinput" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $tel ?>" readonly require>
                            </div>
                            <div class="col-6">
                                <label for="borderinput1" class="form-label">ชื่อบริษัท</label>
                                <select class="form-select" aria-label="Default select example" name="company">
                                    <option value="<?= $row_c['com_id'] ?>"><?= $row_c['com_name'] ?></option>
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
                        <?php }else{?>

                        <div class="row">
                            <div class="col">
                                <label for="borderinput1" class="form-label">หมายเลขโทรศัพท์</label>
                                <input type="text" class="form-control" id="borderinput1" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $tel ?>" readonly require>
                            </div>
                        </div>
                        <br>
                        <?php } ?>
                        <label for="borderinput1" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ</label>
                        <div class="row">
                            <!-- <?php
                                    if (isset($_POST['submit'])) {
                                        // handle image upload
                                        $fileNames = array();
                                        $counter = 0; // initialize counter
                                        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
                                            if ($counter >= 5) { // check counter against limit
                                                break;
                                            }
                                            $file = $_FILES['image'];
                                            $fileName = $file['name'][$key];
                                            $fileTmpName = $file['tmp_name'][$key];
                                            $fileSize = $file['size'][$key];
                                            $fileError = $file['error'][$key];
                                            $fileType = $file['type'][$key];

                                            // check for errors
                                            if ($fileError === UPLOAD_ERR_OK) {
                                                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                                $allowedExt = array('jpg', 'jpeg', 'png', 'gif');
                                                if (in_array($fileExt, $allowedExt)) {
                                                    if ($fileSize < 5000000) { // 5 MB max file size
                                                        // generate unique file name
                                                        $newFileName = uniqid('', true) . '.' . $fileExt;
                                                        $fileDest = 'uploads/' . $newFileName;
                                                        // move uploaded file to destination folder
                                                        move_uploaded_file($fileTmpName, $fileDest);
                                                        $fileNames[] = $newFileName;
                                                        $counter++; // increment counter
                                                    } else {
                                                        echo "File size too large.";
                                                    }
                                                } else {
                                                    echo "Invalid file type.";
                                                }
                                            } else {
                                                echo "Error uploading file.";
                                            }
                                        }

                                        // insert image filenames into database
                                        $db = new mysqli("localhost", "username", "password", "database_name");
                                        $stmt = $db->prepare("INSERT INTO images (filename) VALUES (?)");
                                        foreach ($fileNames as $fileName) {
                                            $stmt->bind_param("s", $fileName);
                                            $stmt->execute();
                                        }
                                        $stmt->close();
                                        $db->close();
                                        echo "Images inserted successfully.";

                                        // display uploaded images
                                        foreach ($fileNames as $fileName) {
                                            echo '<img src="uploads/' . $fileName . '">';
                                        }
                                    }
                                    ?>
                            <div class="col-2">
                                <label for="">กรูณาใส่รูปภาพ (ไม่เกิน 4 รูป)</label>
                                <button type="button" class="btn btn-primary" onclick="addInput()">Add more images</button>
                            </div>
                            <div id="file-inputs">
                                <input type="file" name="image[]">
                            </div>

                            <script>
                                function addInput() {
                                    var div = document.getElementById("file-inputs");
                                    var inputCount = div.getElementsByTagName("input").length;
                                    if (inputCount >= 4) { // check input count against limit
                                        return;
                                    }
                                    var input = document.createElement("input");
                                    input.type = "file";
                                    input.name = "image[]";
                                    div.appendChild(input);
                                }
                            </script> -->

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

                        <div class="row">
                            <div class="mb-3">
                                <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                                <textarea class="form-control" id="inputtext" rows="3" name="description" required><?= $description  ?></textarea>
                            </div>

                            <div class="text-center pt-4">
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
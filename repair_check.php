<?php
session_start();
include('database/condb.php');

$id = $_SESSION["id"];

$sql = "SELECT * FROM member WHERE m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

?>
<?php
if (!isset($_SESSION['id'])) {
    header("location:home.php");
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

    $name_brand = $_SESSION["name_brand"];
    $serial_number = $_SESSION["serial_number"];
    $name_model = $_SESSION["name_model"];
    $number_model = $_SESSION["number_model"];
    $tel = $_SESSION["tel"];
    $description = $_SESSION["description"];

    $id = $_SESSION["id"];

    $image1 = $_SESSION["image1"];
    $image2 = $_SESSION["image2"];
    $image3 = $_SESSION["image3"];
    $image4 = $_SESSION["image4"];

    $folderName = "uploads/$id"; // the name of the new folder
    if (!file_exists($folderName)) { // check if the folder already exists
        mkdir($folderName); // create the new folder
        // echo "Folder created successfully";
    } else {
        // echo "Folder already exists";
    }


    ?>
    <!-- end navbar-->

    <div class="background"></div>

    <div class="px-5 pt-5 edit">
        <h1 class="pt-5 text-center">ตรวจเช็คข้อมูลก่อนทำการบันทึก</h1>
        <center>
            <p>ข้อมูลถูกต้องหรือไม่</p>
        </center>
        <br>
        <!-- <form action="action/add_repair_db.php" method="POST" enctype="multipart/form-data"> -->
        <form action="action/add_new_repair.php" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <label for="borderinput" class="form-label">ชื่อยี่ห้อ</label>
                                <input type="text" class="form-control input" id="borderinput" name="name_brand" placeholder="ชื่อยี่ห้อ" value="<?= $name_brand ?>" readonly require>
                            </div>
                            <div class="col-6">
                                <label for="borderinput" class="form-label">หมายเลข Serial Number</label>
                                <input type="text" class="form-control input" id="borderinput" name="serial_number" placeholder="ไม่มีเลข Serial Number" value="<?= $serial_number ?>" readonly>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-6">
                                <label for="borderinput" class="form-label">ชื่อรุ่น</label>
                                <input type="text" class="form-control input" id="borderinput" name="name_model" placeholder="ชื่อรุ่น" value="<?= $name_model ?>" readonly require>
                            </div>
                            <div class="col-6">
                                <label for="borderinput" class="form-label">หมายเลขรุ่น</label>
                                <input type="text" class="form-control input" id="borderinput" name="number_model" placeholder="ไม่มีหมายเลขรุ่น" value="<?= $number_model ?>" readonly>
                            </div>
                        </div>
                        <br>


                        <?php
                        $company = $_SESSION["company"];
                        if ($company != NULL) {
                            $sql_c = "SELECT * FROM company WHERE com_id = '$company' AND del_flg = '0'";
                            $result_c = mysqli_query($conn, $sql_c);
                            $row_c = mysqli_fetch_array($result_c);

                            $company = $row_c['com_name'];
                        ?>
                            <div class="row">
                                <div class="col-6">
                                    <label for="borderinput1" class="form-label">หมายเลขโทรศัพท์</label>
                                    <input type="text" class="form-control" id="borderinput" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $tel ?>" readonly require>
                                </div>
                                <div class="col-6">
                                    <label for="borderinput1" class="form-label">ชื่อบริษัท</label>
                                    <input type="text" class="form-control" id="borderinput" name="company" placeholder="กรุณากรอกชื่อบริษัท" value="<?= $company ?>" readonly require>
                                </div>
                            </div>
                            <br>
                        <?php } else { ?>

                            <div class="row">
                                <div class="col">
                                    <label for="borderinput1" class="form-label">หมายเลขโทรศัพท์</label>
                                    <input type="text" class="form-control" id="borderinput1" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $tel ?>" readonly require>
                                    <td class="image"><img src="<?php echo $target_file; ?>" /></td>
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

                            <!-- <div class="col-3">
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
                            </div> -->
                            <?php
                            $i = 1;
                            while (isset($_SESSION['r_id_' . $i])) {
                                $i++;
                            }

                            foreach (new DirectoryIterator("uploads/$id/Holder/$i/") as $file) {
                                if ($file->isFile()) {
                                    // print $file->getFilename() . "\n";
                            ?>
                                    <div class="col-3">
                                        <img src="uploads/<?= $id ?>/Holder/<?= $i ?>/<?= $file ?>" style="max-width: 100%; height: auto;" alt="picture error">
                                    </div>
                            <?php
                                }
                            }
                            ?>


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
                                <label for="inputtext" class="form-label">รายละเอียดการซ่อม</label>
                                <textarea class="form-control" id="inputtext" rows="3" name="description" readonly require><?= $description ?></textarea>
                            </div>

                            <div class="text-center pt-4">
                                <a href="repair_edit.php" class="btn btn-danger">แก้ไขข้อมูล</a>
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
    <?php
    //  include('footer/footer.php') 
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
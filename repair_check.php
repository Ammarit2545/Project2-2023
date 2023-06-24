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
        .grid {
            margin-bottom: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 600px));
            grid-gap: 2rem;

        }

        .grid-pic {
            margin-bottom: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 2rem;

        }

        .grid-item {
            /* box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); */
            /* Add a gray shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Add transition for transform and box-shadow */
        }

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

    $name_brand = $_SESSION["name_brand"];
    $serial_number = $_SESSION["serial_number"];
    $name_model = $_SESSION["name_model"];
    $number_model = $_SESSION["number_model"];
    $tel = $_SESSION["tel"];
    $description = $_SESSION["description"];
    $company = $_SESSION["company"];

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
    <br>
    <div class="px-5 pt-5 edit">
        <h1 class="pt-5 text-center">การบริการส่งซ่อม</h1>
        <center>
            <!-- <p>แบบไม่มีกับมีประกันทางร้าน</p> -->
            <p>กรุณาใส่รายละเอียดการซ่อมของท่าน</p>
        </center>
        <br>
        <br>
        <form action="action/add_new_repair.php" method="POST" class="contact-form" name="inputname" enctype="multipart/form-data">
            <div class="container">
                <div class="grid">
                    <div class="grid-item">
                        <label for="borderinput1" class="form-label">ชื่อยี่ห้อ</label>
                        <input type="text" class="form-control input" id="borderinput" value="<?= $name_brand ?>" name="name_brand" placeholder="กรุณากรอกชื่อยี่ห้อ" required readonly>
                    </div>
                    <div class="grid-item">
                        <label for="borderinput1" class="form-label">เลข Serial Number</label>
                        <input type="text" class="form-control input" id="borderinput" value="<?= $serial_number ?>" name="serial_number" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)" readonly>
                    </div>
                    <div class="grid-item">
                        <label for="borderinput1" class="form-label">ชื่อรุ่น</label>
                        <input type="text" class="form-control input" id="borderinput" value="<?= $name_model ?>" name="name_model" placeholder="กรุณากรอกชื่อรุ่น" required readonly>
                    </div>
                    <div class="grid-item">
                        <label for="borderinput1" class="form-label">หมายเลขรุ่น</label>
                        <input type="text" class="form-control input" id="borderinput" value="<?= $number_model ?>" name="number_model" placeholder="กรุณากรอก หมายเลขรุ่น  (ไม่จำเป็น)" readonly>
                    </div>
                    <div class="grid-item">
                        <label for="borderinput1" class="form-label">ประเภทของการซ่อม</label>
                        <!-- <input type="text" class="form-control" id="borderinput" name="tel" placeholder="กรุณากรอกหมายเลขโทรศัพท์" value="<?= $row['m_tel'] ?>" required> -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                <?php if ($_SESSION["company"] != NULL) {
                                    echo 'มีประกันกับทางร้าน';
                                } else {
                                    echo 'ไม่มีประกันกับทางร้าน';
                                } ?>
                            </label>
                        </div>
                        <!-- <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" onclick="return check_gua()">
                            <label class="form-check-label" for="flexRadioDefault2">
                                มีประกันกับทางร้าน
                            </label>
                        </div> -->
                    </div>

                    <div class="grid-item" id="check_gua">

                        <!-- <select class="form-select" name="company" aria-label="Default select example" required>
                            <option value="" selected>กรุณาเลือกบริษัทที่ต้องการเคลม</option> -->
                        <label for="borderinput1" class="form-label">บริษัท</label>
                        <?php
                        $sql_company = "SELECT * FROM company WHERE del_flg = '0' AND com_id = '$company'";
                        $result_company = mysqli_query($conn, $sql_company);
                        $row_company = mysqli_fetch_array($result_company);
                        if ($row_company[0] > 0) {
                            
                        ?>
                            <input type="text" class="form-control input" id="borderinput" value="<?= $row_company['com_name'] ?>" name="com_name" placeholder="กรุณากรอกชื่อรุ่น" required readonly>
                            <!-- <input type="text" class="form-control input" id="borderinput" value="ไม่มีประกัน" name="com_name" placeholder="กรุณากรอกชื่อรุ่น" required> -->
                        <?php
                        } else {
                        ?>
                            <input type="text" class="form-control input" id="borderinput" value="ไม่มีประกัน" name="com_name" placeholder="กรุณากรอกชื่อรุ่น" required readonly>
                        <?php
                        }
                        ?>
                        <!-- </select> -->
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                    <textarea class="form-control" id="inputtext" rows="3" name="description" required placeholder="กรุณากรอกรายละเอียด" readonly><?= $description ?></textarea>
                </div>
            </div>
            <br>
            <div class="container">
                <label for="borderinput1" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ</label>
                <div class="row">
                    <!-- <?php
                            $folderName = "uploads/$id/Holder"; // the name of the new folder
                            if (!file_exists($folderName)) { // check if the folder already exists
                                mkdir($folderName); // create the new folder
                                // echo "Folder created successfully";
                            } else {
                                // echo "Folder already exists";
                            }


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
                        $folderName = "uploads/$id/Holder/$i/"; // the name of the new folder
                        if (!file_exists($folderName)) { // check if the folder already exists
                            mkdir($folderName); // create the new folder
                            // echo "Folder created successfully";
                        } else {
                            // echo "Folder already exists";
                        }
                    }
                    // $i -= 1;
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
            </div>


            <script>
                function check_gua() {
                    document.getElementById('check_gua').style.display = 'block';
                    document.getElementById('insert_bill').style.display = 'inline-block';
                }

                function check_non_gua() {
                    document.getElementById('check_gua').style.display = 'none';
                    document.getElementById('insert_bill').style.display = 'none';
                }

                function addImage4() {
                    var fileInput = document.createElement('input');
                    fileInput.setAttribute('type', 'file');
                    fileInput.setAttribute('name', 'image1');
                    fileInput.setAttribute('onchange', "previewImage('image-preview1', this)");
                    fileInput.setAttribute('id', 'fileToUpload');

                    var gridItems = document.querySelectorAll('.grid-item input[type="file"]');
                    var emptyGridItem = Array.prototype.find.call(gridItems, function(item) {
                        return !item.value; // Find the first empty grid item
                    });

                    if (emptyGridItem) {
                        emptyGridItem.parentNode.replaceChild(fileInput, emptyGridItem);
                    } else {
                        console.log('Maximum number of images reached');
                    }
                }

                function previewImage(previewId, input) {
                    var previewContainer = document.getElementById(previewId);
                    var previewImage = document.createElement('img');

                    // Set the maximum width and maximum height of the image
                    previewImage.style.maxWidth = '200px';
                    previewImage.style.maxHeight = '200px';

                    // Set the border radius and border style of the image
                    previewImage.style.borderRadius = '10%';
                    previewImage.style.border = '2px solid gray';

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.setAttribute('src', e.target.result);
                            previewContainer.innerHTML = ''; // Clear previous content
                            previewContainer.appendChild(previewImage);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>

            <center>
                <div class="row">
                    <!-- <div class="mb-3">
                        <label for="inputtext" class="form-label">รายละเอียดการซ่อม</label>
                        <textarea class="form-control" id="inputtext" rows="3" name="description" readonly require><?= $description ?></textarea>
                    </div> -->

                    <div class="text-center py-4">
                        <a href="repair_edit.php" class="btn btn-danger">แก้ไขข้อมูล</a>
                        <button type="submit" class="btn btn-success">ยืนยัน</button>

                    </div>

                </div>
            </center>
        </form>


    </div>
    </div>

    <!-- footer-->
    <?php
    include('footer/footer.php')
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
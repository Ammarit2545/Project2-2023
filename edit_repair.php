<?php
session_start();
include('database/condb.php');

$id = $_SESSION["id"];
$id_session = $_GET['id'];

if (!isset($_SESSION['r_id_' . $id_session])) {
    $_SESSION['add_data_detail'] = 2;
    header('Location: listview_repair.php');
}

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

    <!-- Sweet Alert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        #plus_img_card {
            width: 100%;
            height: 100%;
        }

        #bounce-item {
            /* box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); */
            /* Add a gray shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Add transition for transform and box-shadow */
        }

        #bounce-item:hover {
            transform: scale(1.1);
            /* Increase size on hover */
            /* box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); */
            /* Increase shadow size and intensity on hover */

        }

        #plus_img_card {
            display: inline-block;
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        #plus_img_card:hover {
            transform: scale(1.1);
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

    if (isset($_SESSION['r_id_' . $id_session])) {
        $i = $id_session;
        $r_id = 'r_id_' . $i;

        $_SESSION[$r_id] = $i;

        $name_brand = 'name_brand_' . $i;

        $serial_number = 'serial_number_' . $i;

        $name_model = 'name_model_' . $i;

        $number_model = 'number_model_' . $i;

        // $tel = 'tel_' . $i;

        $description = 'description_' . $i;

        $company = 'company_' . $i;

        $image1 = 'image1_' . $i;

        $image2 = 'image2_' . $i;

        $image3 = 'image3_' . $i;

        $image4 = 'image4_' . $i;

        // การกระทำอื่น
        $name_brand_data = $_SESSION[$name_brand];

        $serial_number_data = $_SESSION[$serial_number];

        $name_model_data = $_SESSION[$name_model];

        $number_model_data = $_SESSION[$number_model];

        // $tel = 'tel_' . $i;

        $description_data = $_SESSION[$description];

        $company_data = $_SESSION[$company];

        $image1_data = $_SESSION[$image1];

        $image2_data = $_SESSION[$image2];

        $image3_data = $_SESSION[$image3];

        $image4_data = $_SESSION[$image4];
    ?>
        <!-- end navbar-->

        <div class="background"></div>
        <br>
        <div class="px-5 pt-5 edit">
            <h1 class="pt-5 text-center">การบริการส่งซ่อม</h1>
            <center>
                <p>แบบไม่มีกับมีประกันทางร้าน</p>
            </center>
            <br>
            <br>
            <form id="formedit" action="action/edit_repair.php" method="POST" class="contact-form" name="inputname" enctype="multipart/form-data">
                <div class="container">
                    <div class="grid">
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ชื่อยี่ห้อ</label>
                            <input type="text" class="form-control input" id="borderinput" name="name_brand" value="<?= $name_brand_data ?>" placeholder="กรุณากรอกชื่อยี่ห้อ" required>
                            <input type="text" class="form-control input" id="borderinput" name="session_number" value="<?= $id_session ?>" placeholder="กรุณากรอกชื่อยี่ห้อ" required hidden>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">เลข Serial Number</label>
                            <input type="text" class="form-control input" id="borderinput" name="serial_number" value="<?= $serial_number_data ?>" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)">
                        </div>

                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ชื่อรุ่น</label>
                            <input type="text" class="form-control input" id="borderinput" name="name_model" value="<?= $name_model_data ?>" placeholder="กรุณากรอกชื่อรุ่น" required>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">หมายเลขรุ่น</label>
                            <input type="text" class="form-control input" id="borderinput" name="number_model" value="<?= $number_model_data ?>" placeholder="กรุณากรอก หมายเลขรุ่น  (ไม่จำเป็น)">
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ประเภทของการซ่อม</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="have_non_gua" id="flexRadioDefault1" onclick="return check_non_gua()" <?php if ($company_data == NULL) {
                                                                                                                                                                                    ?>checked<?php
                                                                                                                                                                                            } ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    ไม่มีประกันกับทางร้าน
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="have_gua" id="flexRadioDefault2" onclick="return check_gua()" <?php if ($company_data != NULL) {
                                                                                                                                                                            ?>checked<?php
                                                                                                                                                                                    } ?>>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    มีประกันกับทางร้าน
                                </label>
                            </div>
                        </div>
                        <div class="grid-item" id="check_gua" <?php if ($company_data == NULL) {
                                                                ?>style="display:none" <?php } ?>>
                            <label for="borderinput1" class="form-label">บริษัท</label>
                            <select class="form-select" name="company" aria-label="Default select example" required>

                                <?php
                                $sql_company_old = "SELECT * FROM company WHERE del_flg = '0' AND com_id = '$company_data'";
                                $result_company_old = mysqli_query($conn, $sql_company_old);
                                $row_company_old = mysqli_fetch_array($result_company_old);
                                if ($row_company_old[0] > 0) {
                                ?>
                                    <option value="<?= $row_company_old['com_id'] ?>" selected><?= $row_company_old['com_name'] ?></option>
                                <?php
                                } else {
                                ?>
                                    <option value="" selected>กรุณาเลือกบริษัทที่ต้องการเคลม</option>
                                <?php
                                }
                                ?>

                                <?php
                                $sql_company = "SELECT * FROM company WHERE del_flg = '0' AND NOT com_id = '$company_data'";
                                $result_company = mysqli_query($conn, $sql_company);
                                while ($row_company = mysqli_fetch_array($result_company)) {
                                ?>
                                    <option value="<?= $row_company['com_id'] ?>"><?= $row_company['com_name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                        <textarea class="form-control" id="inputtext" rows="3" name="description" required placeholder="กรุณากรอกรายละเอียด"><?= $description_data ?></textarea>
                    </div>
                </div>
                <br>

                <div class="container">
                    <label for="borderinput" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ (สูงสุด 4 ไฟล์) <p id="insert_bill" style="display: none; color:red">*** เพิ่มรูปใบเสร็จของท่านเพื่อเป็นการยืนยันอย่างน้อย 1 รูป ***</p></label>
                    <br><br>
                    <!-- <a class="btn btn-primary" style="margin-left:10px;" onclick="addImage4()">+</a> -->
                    <div class="row grid">
                        <!-- <div class="col-3 grid-item" id="insert_pic_1" style="display: none;">
                        <input type="file" name="image1" onchange="previewImage('image-preview1', this)" id="fileToUpload">
                    </div> -->
                        <!-- <div class="col-3 grid-item">
                        <input type="file" name="image2" onchange="previewImage('image-preview2', this)" id="fileToUpload">
                    </div>
                    <div class="col-3 grid-item">
                        <input type="file" name="image3" onchange="previewImage('image-preview3', this)" id="fileToUpload">
                    </div>
                    <div class="col-3 grid-item">
                        <input type="file" name="image4" onchange="previewImage('image-preview4', this)" id="fileToUpload">
                    </div> -->
                    </div>
                </div>

                <div class="container">
                    <div class="grid-pic">
                        <div class="grid-item">

                            <div id="image-preview1">
                                <div class="container">
                                    <div class="row">
                                        <!-- Add any desired content here -->
                                    </div>
                                </div>

                                <?php
                                $directory = "uploads/$id/Holder/$id_session/"; // Directory path where your files are located
                                $files = glob($directory . "1" . "*"); // Get all files that start with index 1

                                ?>

                                <?php

                                if (empty($files)) {
                                    // Display a card or message when there are no files
                                ?>
                                    <center>
                                        <div class="image-container">
                                            <button class="delete-icon" onclick="deleteImage('<?php echo $file; ?>', 'image-preview1',1)" title="Delete" id="deleteButton">&times;</button>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var deleteButton = document.getElementById('deleteButton');
                                                    deleteButton.click();
                                                });
                                            </script>
                                            <img src="<?php echo $file; ?>" style="max-width: 200px; max-height: 200px;border: 1px solid gray;border-radius: 2%">
                                        </div>
                                    </center>
                                    <?php
                                } else {
                                    foreach ($files as $file) {
                                    ?>
                                        <div class="image-container">
                                            <button class="delete-icon" onclick="deleteImage('<?php echo $file; ?>', 'image-preview1',1)" title="Delete">&times;</button>
                                            <?php
                                            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                            if (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mkv', 'mov'])) {
                                                echo '<video src="' . $file . '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%" autoplay muted controls></video>';
                                            } else {
                                                echo '<img src="' . $file . '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%">';
                                            }
                                            ?>

                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <center>
                                <div id="insert_pic_1" style="display: none;">
                                    <a id="bounce-item">
                                        <label id="plus_img_card">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" id="plus-button-1" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%;" alt="">
                                            <p id="change-button-1" class="btn btn-primary" style="display : none" alt="">เปลี่ยนรูปภาพ</p>
                                            <input type="file" name="image1" onchange="previewImage_NEW('image-preview1', this, 'preview-image-new-1',1)" id="fileToUpload" style="display: none;">
                                        </label>
                                    </a>
                                    <div id="preview-image-new-1"></div>
                                </div>
                            </center>
                        </div>

                        <!-- img 2 -->
                        <div class="grid-item">
                            <div id="image-preview2">
                                <div class="container">
                                    <div class="row">
                                        <!-- Add any desired content here -->
                                    </div>
                                </div>

                                <?php
                                $files = glob($directory . "2" . "*"); // Get all files that start with index 2

                                if (empty($files)) {
                                    // Display a card or message when there are no files
                                ?>
                                    <center>
                                        <div class="image-container">
                                            <button class="delete-icon" onclick="deleteImage('<?php echo $file; ?>', 'image-preview2',2)" title="Delete" id="deleteButton">&times;</button>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var deleteButton = document.getElementById('deleteButton');
                                                    deleteButton.click();
                                                });
                                            </script>
                                            <img src="<?php echo $file; ?>" style="max-width: 200px; max-height: 200px;border: 1px solid gray;border-radius: 2%">
                                        </div>
                                    </center>
                                    <?php
                                } else {
                                    foreach ($files as $file) {
                                    ?>
                                        <div class="image-container">
                                            <button class="delete-icon" onclick="deleteImage('<?php echo $file; ?>', 'image-preview2' ,2)" title="Delete">&times;</button>
                                            <?php
                                            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                            if (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mkv', 'mov'])) {
                                                echo '<video src="' . $file . '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%" autoplay muted controls></video>';
                                            } else {
                                                echo '<img src="' . $file . '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%">';
                                            }
                                            ?>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <center>
                                <div id="insert_pic_2" style="display: none;">
                                    <a id="bounce-item">
                                        <label id="plus_img_card">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" id="plus-button-2" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%" alt="">
                                            <p id="change-button-2" class="btn btn-primary" style="display : none" alt="">เปลี่ยนรูปภาพ</p>
                                            <input type="file" name="image2" onchange="previewImage_NEW('image-preview2', this, 'preview-image-new-2',2)" id="fileToUpload" style="display: none;">
                                        </label>
                                    </a>
                                    <div id="preview-image-new-2"></div>
                                </div>
                            </center>
                        </div>

                        <!-- img 3 -->
                        <div class="grid-item">
                            <div id="image-preview3">
                                <div class="container">
                                    <div class="row">
                                        <!-- Add any desired content here -->
                                    </div>
                                </div>

                                <?php
                                $files = glob($directory . "3" . "*"); // Get all files that start with index 3

                                if (empty($files)) {
                                    // Display a card or message when there are no files
                                ?>
                                    <center>
                                        <div class="image-container">
                                            <button class="delete-icon" onclick="deleteImage('<?php echo $file; ?>', 'image-preview3',3)" title="Delete" id="deleteButton">&times;</button>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var deleteButton = document.getElementById('deleteButton');
                                                    deleteButton.click();
                                                });
                                            </script>
                                            <img src="<?php echo $file; ?>" style="max-width: 200px; max-height: 200px;border: 1px solid gray;border-radius: 2%">
                                        </div>
                                    </center>
                                    <?php
                                } else {
                                    foreach ($files as $file) {
                                    ?>
                                        <div class="image-container">
                                            <button class="delete-icon" onclick="deleteImage('<?php echo $file; ?>', 'image-preview3',3)" title="Delete">&times;</button>
                                            <?php
                                            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                            if (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mkv', 'mov'])) {
                                                echo '<video src="' . $file . '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%" autoplay muted controls></video>';
                                            } else {
                                                echo '<img src="' . $file . '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%">';
                                            }
                                            ?>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <center>
                                <div id="insert_pic_3" style="display: none;">
                                    <a id="bounce-item">
                                        <label id="plus_img_card">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" id="plus-button-3" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%" alt="">
                                            <p id="change-button-3" class="btn btn-primary" style="display : none" alt="">เปลี่ยนรูปภาพ</p>
                                            <input type="file" name="image3" onchange="previewImage_NEW('image-preview3', this, 'preview-image-new-3',3)" id="fileToUpload" style="display: none;">
                                        </label>
                                    </a>
                                    <div id="preview-image-new-3"></div>
                                </div>
                            </center>
                        </div>
                        <div class="grid-item">
                            <div id="image-preview4">
                                <div class="container">
                                    <div class="row">
                                        <!-- Add any desired content here -->
                                    </div>
                                </div>

                                <?php
                                $files = glob($directory . "4" . "*"); // Get all files that start with index 4

                                if (empty($files)) {
                                    // Display a card or message when there are no files
                                ?>
                                    <center>
                                        <div class="image-container">
                                            <button class="delete-icon" onclick="deleteImage('<?php echo $file; ?>', 'image-preview4',4)" title="Delete" id="deleteButton">&times;</button>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var deleteButton = document.getElementById('deleteButton');
                                                    deleteButton.click();
                                                });
                                            </script>
                                            <img src="<?php echo $file; ?>" style="max-width: 200px; max-height: 200px;border: 1px solid gray;border-radius: 2%">
                                        </div>
                                    </center>
                                    <?php
                                } else {
                                    foreach ($files as $file) {
                                    ?>
                                        <div class="image-container">
                                            <button class="delete-icon" onclick="deleteImage('<?php echo $file; ?>', 'image-preview4',4)" title="Delete">&times;</button>
                                            <?php
                                            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                            if (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mkv', 'mov'])) {
                                                echo '<video src="' . $file . '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%" autoplay muted controls></video>';
                                            } else {
                                                echo '<img src="' . $file . '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%">';
                                            }
                                            ?>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <center>
                                <div id="insert_pic_4" style="display: none;">
                                    <a id="bounce-item">
                                        <label id="plus_img_card">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Plus_symbol.svg/1200px-Plus_symbol.svg.png" id="plus-button-4" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%" alt="">
                                            <p id="change-button-4" class="btn btn-primary" style="display : none" alt="">เปลี่ยนรูปภาพ</p>
                                            <input type="file" name="image4" onchange="previewImage_NEW('image-preview4', this, 'preview-image-new-4',4)" id="fileToUpload" style="display: none;">
                                        </label>
                                    </a>

                                    <div id="preview-image-new-4"></div>
                                </div>
                            </center>
                        </div>
                    </div>

                </div>
                <script>
                    function previewImage_NEW(previewContainerId, fileInput, previewImageId, count) {
                        var previewContainer = document.getElementById(previewContainerId);
                        var previewImage = document.getElementById(previewImageId);

                        if (fileInput.files && fileInput.files[0]) {
                            var reader = new FileReader();

                            // Hide the plus button and show the change button
                            document.getElementById('plus-button-' + count).style.display = 'none';
                            document.getElementById('change-button-' + count).style.display = 'block';

                            reader.onload = function(e) {
                                if (fileInput.files[0].type.includes('video')) {
                                    // If the file is a video, create a video element
                                    previewImage.innerHTML = '<video src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%;" autoplay muted controls></video>';
                                } else {
                                    // If the file is an image, create an image element
                                    previewImage.innerHTML = '<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 2%">';
                                }
                            };

                            reader.readAsDataURL(fileInput.files[0]);
                            previewContainer.style.display = 'block';
                        } else {
                            previewImage.innerHTML = '';
                            previewContainer.style.display = 'none';
                        }
                    }

                    function deleteImage(file, previewId, numberPreview) {
                        var imageContainer = document.getElementById(previewId);
                        imageContainer.parentNode.removeChild(imageContainer);

                        document.getElementById("insert_pic_" + numberPreview).style.display = 'block';
                        // Perform additional logic for deleting the file from the server
                        // You can use the 'file' parameter to send the necessary data to the server
                    }
                </script>

                <div class="container">
                    <div class="grid-pic">
                        <div class="grid-item">
                            <div id="image-preview1"></div>
                        </div>
                        <div class="grid-item">
                            <div id="image-preview2"></div>
                        </div>
                        <div class="grid-item">
                            <div id="image-preview3"></div>
                        </div>
                        <div class="grid-item">
                            <div id="image-preview4"></div>
                        </div>
                    </div>
                </div>
                <script>
                    function check_non_gua() {
                        document.getElementById("check_gua").style.display = "none";
                        document.getElementById("company").required = false;
                        return true;
                    }

                    function check_gua() {
                        document.getElementById("check_gua").style.display = "block";
                        document.getElementById("company").required = true;
                        return true;
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
                    <br>
                    <!-- <a href="repair_have.php" class="btn btn-primary" style="color:white">เคยซ่อมแล้วหรือไม่?</a> -->
                    <a class="btn btn-danger" onclick="cancelButton()">ยกเลิก</a>
                    <a class="btn btn-success" name="submit" onclick="confirmData()">ยืนยัน</a>
                    <script>
                        function cancelButton() {
                            Swal.fire({
                                title: 'ต้องการยกเลิกหรือไม่',
                                text: 'การยกเลิกจะทำการลบข้อมูลข้างต้นทั้งหมด',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'ยกเลิกการแก้ไข',
                                cancelButtonText: 'แก้ไขข้อมูลต่อไป'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'listview_repair.php';
                                }
                            });
                        }

                        function confirmData() {
                            Swal.fire({
                                title: 'คุณต้องการทำการส่งหรือไม่?',
                                text: 'ข้อมูลของคุณจะถูกบันทึก',
                                icon: 'question',
                                showCancelButton: true,
                                cancelButtonColor: '#d33',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ยืนยัน',
                                cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // User confirmed, submit the form
                                    document.getElementById('formedit').submit();
                                }
                            });
                        }

                        function submitData() {
                            // Perform the submission action here
                            // You can replace this comment with your actual code
                            console.log('Data submitted successfully!');
                        }
                    </script>


                </center>
            </form>


        </div>
    <?php
    }
    ?>
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
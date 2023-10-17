<?php
session_start();
include('database/condb.php');

$id = $_SESSION["id"];

$sql = "SELECT * FROM member WHERE m_id = '$id' AND del_flg = 0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$id_r = $_GET["id"];
$get_r_id = $_GET["get_r_id"];

$sql1 = "SELECT * FROM repair WHERE r_id = '$id_r ' AND m_id = '$id'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);
$company = $row1['com_id'];

if ($row2['get_r_detail'] == NULL) {
    $description = $_SESSION["description"];
} else {
    $description = $row2['get_r_detail'];
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
    <style>
        <?php include('css/all_page.css'); ?>.grid {
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
    </style>
</head>

<body>

    <!-- navbar-->
    <?php
    include('bar/topbar_user.php');

    $id = $_SESSION["id"];

    $sql = "SELECT get_r_date_in FROM get_repair WHERE get_r_id = '$get_r_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    ?>
    <!-- end navbar-->

    <div class="background"></div>
    <br>
    <div class="px-5 pt-5 edit">
        <?php if (isset($_SESSION['sn_check_success'])) { ?>
            <h1 class="pt-5 text-center">อุปกรณ์อยู่ระหว่าง<span style="color:blue">การซ่อม</span><a href="detail_status.php?id=<?= $get_r_id ?>"><span class="btn btn-primary"> #หมายเลขซ่อม <?= $get_r_id ?> </span></a></h1>
        <?php } else {  ?>
            <h1 class="pt-5 text-center">ระบบได้ตรวจพบหมายเลขรุ่นนี้ในระบบ</h1>
        <?php  } ?>

        <?php if (isset($_SESSION['sn_check_success'])) { ?>
            <center>
                <!-- <p>แบบไม่มีกับมีประกันทางร้าน</p> -->
                <p>กด <a href="detail_status.php?id=<?= $get_r_id ?>"><u>"ดูรายการของท่าน"</u> </a> เพื่อตรวจสอบการซ่อมของท่าน</p>
            </center>
        <?php } else {  ?>
            <center>
                <!-- <p>แบบไม่มีกับมีประกันทางร้าน</p> -->
                <p>คุณต้องการใช้รายละเอียดการซ่อม"เดิม"หรือไม่ ถ้าใช่กด "ยืนยัน"</p>
            </center>
        <?php  } ?>


        <br>
        <br>
        <form action="action/add_repair.php" method="POST" class="contact-form" name="inputname" enctype="multipart/form-data">
            <div class="container">
                <?php if (!isset($_SESSION['sn_check_success'])) { ?>
                    <div class="grid">
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ชื่อยี่ห้อ</label>
                            <input type="text" class="form-control input" id="borderinput" name="name_brand" value="<?= $row1['r_brand'] ?>" placeholder="กรุณากรอกชื่อยี่ห้อ" required disabled>
                            <input type="text" class="form-control input" id="borderinput" name="id_repair" disabled placeholder="ไอดี" value="<?= $id_r ?>" style="display:none">
                            <input type="text" class="form-control input" id="borderinput" name="id_repair_ever" disabled placeholder="ไอดี" value="1" style="display:none">
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">หมายเลข Serial Number</label>
                            <input type="text" class="form-control input" id="borderinput" name="serial_number" value="<?= $row1['r_serial_number'] ?>" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)" disabled>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ชื่อรุ่น</label>
                            <input type="text" class="form-control input" id="borderinput" name="name_model" value="<?= $row1['r_model']  ?>" placeholder="กรุณากรอกชื่อรุ่น" required disabled>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">หมายเลขรุ่น</label>
                            <input type="text" class="form-control input" id="borderinput" name="number_model" value="<?= $row1['r_number_model'] ?>" placeholder="กรุณากรอก หมายเลขรุ่น  (ไม่จำเป็น)" disabled>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ประเภทของการซ่อม</label>
                            <?php if ($row1['com_id'] != NULL) {
                                $have_company = 1;
                            } else {
                                $have_company = 0;
                            } ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="have_non_gua" id="flexRadioDefault1" onclick="return check_non_gua()" <?php if ($have_company == 0) {
                                                                                                                                                                                    ?>checked<?php
                                                                                                                                                                                            } else {
                                                                                                                                                                                                ?>hidden<?php
                                                                                                                                                                                                    } ?>>
                                <label class="form-check-label" for="flexRadioDefault1" <?php if ($have_company == 0) {
                                                                                        } else { ?>hidden<?php } ?>>
                                    ไม่มีประกันกับทางร้าน
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="have_gua" id="flexRadioDefault2" onclick="return check_gua()" <?php if ($have_company == 1) {
                                                                                                                                                                            ?>checked<?php } else {
                                                                                                                                                                                        ?>hidden<?php
                                                                                                                                                                                            }
                                                                                                                                                                                                ?>>
                                <label class="form-check-label" for="flexRadioDefault2" <?php if ($have_company == 1) {
                                                                                        } else { ?>hidden<?php } ?>>
                                    มีประกันกับทางร้าน
                                </label>
                            </div>
                        </div>

                        <div class="grid-item" id="check_gua" <?php if ($have_company == 1) {
                                                                ?>style="display: block;" <?php } else {
                                                                                            ?> style="display: none;" <?php
                                                                                                                    } ?>>
                            <label for="borderinput1" class="form-label">บริษัท</label>
                            <select class="form-select" name="company" id="company" aria-label="Default select example" disabled>
                                <?php
                                $sql_c = "SELECT * FROM company WHERE com_id = '$company' AND del_flg = '0'";
                                $result_c = mysqli_query($conn, $sql_c);
                                $row_c = mysqli_fetch_array($result_c);
                                ?>
                                <?php if ($have_company == 1) { ?><option value="<?= $row_c['com_id'] ?>"><?= $row_c['com_name'] ?></option>
                                <?php } else {
                                ?> <option value="" selected>กรุณาเลือกบริษัทที่ต้องการเคลม</option> <?php } ?>


                            </select>
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
                        </script>


                    </div>
                    <div class="mb-3">
                        <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                        <textarea class="form-control" id="inputtext" rows="3" name="description" required placeholder="กรุณากรอกรายละเอียด"></textarea>
                    </div>
                <?php } else { ?>
                    <div class="card text-center">
                        <div class="card-header">
                            รายละเอียดของอุปกรณ์
                        </div>
                        <div class="card-body">
                            <br>
                            <h4 class="card-title"><?= $row1['r_brand'] . ' ' . $row1['r_model'] ?> </h4>
                            <br>
                            <h5>Model : <?= $row1['r_number_model'] ?></h5>
                            <p class="card-text">Serial Number : <?= $row1['r_serial_number'] ?></p>
                            <a href="detail_status.php?id=<?= $get_r_id ?>" class="btn btn-primary" style="color:white">ดูรายการของท่าน</a>
                        </div>
                        <div class="card-footer text-muted">
                            <?php
                            // Assuming $row['get_r_date_in'] contains the date in a string format like 'YYYY-MM-DD'
                            $get_r_date_in = $row['get_r_date_in'];

                            // Create a DateTime object for the current date and time
                            $currentDate = new DateTime();

                            // Create a DateTime object for the date stored in $row['get_r_date_in']
                            $get_r_date_in_object = new DateTime($get_r_date_in);

                            // Calculate the interval between the two dates
                            $interval = $currentDate->diff($get_r_date_in_object);

                            // Get the number of days from the interval
                            $daysAgo = $interval->days;
                            ?>

                            <?php if ($daysAgo > 0) {
                                echo $daysAgo . ' days ago';
                            } else {
                                echo '> 1 day';
                            } ?>
                        </div>

                    </div>
                <?php  } ?>
            </div>
            <br>
            <?php if (!isset($_SESSION['sn_check_success'])) { ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 mt-2">

                            <div id="image-preview1">
                                <div class="container">
                                    <div class="row">
                                        <!-- Add any desired content here -->
                                    </div>
                                </div>

                                <?php
                                $directory = "uploads/$id/Holder/$count_session/"; // Directory path where your files are located
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
                        <div class="col-lg-3 mt-2">
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
                        <div class="col-lg-3 mt-2">
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
                        <div class="col-lg-3 mt-2">
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
            <?php } ?>
            <script>
                function switchInput() {
                    var inputIndex = parseInt(document.getElementById('inputIndex').value);
                    var nextIndex = inputIndex + 1;
                    if (nextIndex > 4) {
                        nextIndex = 4;
                        document.querySelector('button').style.display = 'none';
                    }
                    document.getElementById('inputIndex').value = nextIndex;

                    // Hide all input fields
                    var inputFields = document.getElementsByClassName('input-field');
                    for (var i = 0; i < inputFields.length; i++) {
                        inputFields[i].style.display = 'none';
                    }

                    // Show the input field corresponding to the current index
                    var currentInputField = document.getElementById('input' + nextIndex);
                    currentInputField.style.display = 'block';
                    currentInputField.focus();

                    // Trigger click event on the input field
                    var clickEvent = new MouseEvent('click', {
                        view: window,
                        bubbles: true,
                        cancelable: true
                    });
                    currentInputField.dispatchEvent(clickEvent);
                }

                window.onload = function() {
                    switchInput(); // Automatically trigger the switchInput() function on page load
                };
            </script>
            <!-- <button type="button" onclick="switchInput()">Switch Input</button> -->

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
                    var previewElement;

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            if (input.files[0].type.includes('video')) {
                                // If the file is a video, create a video element
                                previewElement = document.createElement('video');
                                previewElement.setAttribute('src', e.target.result);
                                previewElement.setAttribute('style', 'max-width: 200px; max-height: 200px; border-radius: 10%; border: 2px solid gray;');
                                previewElement.setAttribute('autoplay', 'true');
                                previewElement.setAttribute('muted', 'true');
                                previewElement.setAttribute('controls', 'true');
                            } else {
                                // If the file is an image, create an image element
                                previewElement = document.createElement('img');
                                previewElement.setAttribute('src', e.target.result);
                                previewElement.setAttribute('style', 'max-width: 200px; max-height: 200px; border-radius: 10%; border: 2px solid gray;');
                            }

                            previewContainer.innerHTML = ''; // Clear previous content
                            previewContainer.appendChild(previewElement);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>
            <?php if (!isset($_SESSION['sn_check_success'])) { ?>
                <center>
                    <br>
                    <a href="listview_repair.php" class="btn btn-danger" style="color:white">ยกเลิก</a>
                    <button type="submit" class="btn btn-success" name="submit">ยืนยัน</button>
                </center>
            <?php } else {  ?>
                <center>
                    <br>
                    <a href="add_repair.php" class="btn btn-success">กลับไปก่อนหน้า</a>
                    <!-- <a href="detail_status.php?id=<?= $get_r_id ?>" class="btn btn-primary" style="color:white">ดูรายการของท่าน</a> -->

                </center>
            <?php  } ?>
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
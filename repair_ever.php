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
                            <input type="text" class="form-control input" id="borderinput" name="name_brand" value="<?= $row1['r_brand'] ?>" placeholder="กรุณากรอกชื่อยี่ห้อ" required readonly>
                            <input type="text" class="form-control input" id="borderinput" name="id_repair" readonly placeholder="ไอดี" value="<?= $id_r ?>" style="display:none">
                            <input type="text" class="form-control input" id="borderinput" name="id_repair_ever" readonly placeholder="ไอดี" value="1" style="display:none">
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">หมายเลข Serial Number</label>
                            <input type="text" class="form-control input" id="borderinput" name="serial_number" value="<?= $row1['r_serial_number'] ?>" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)" readonly>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ชื่อรุ่น</label>
                            <input type="text" class="form-control input" id="borderinput" name="name_model" value="<?= $row1['r_model']  ?>" placeholder="กรุณากรอกชื่อรุ่น" required readonly>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">หมายเลขรุ่น</label>
                            <input type="text" class="form-control input" id="borderinput" name="number_model" value="<?= $row1['r_number_model'] ?>" placeholder="กรุณากรอก หมายเลขรุ่น  (ไม่จำเป็น)" readonly>
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
                            <select class="form-select" name="company" id="company" aria-label="Default select example" readonly>
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
                            <h4 class="card-title"><?= $row1['r_brand'] . ' ' . $row1['r_model'] ?> </h4><h5>Model : <?= $row1['r_number_model'] ?></h5>
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

                            <?php if($daysAgo > 0){
                                echo $daysAgo.' days ago';
                            }else{
                                echo 'Today';
                            } ?>
                        </div>

                    </div>
                <?php  } ?>
            </div>
            <br>
            <?php if (!isset($_SESSION['sn_check_success'])) { ?>
                <div class="container">
                    <label for="borderinput" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ (สูงสุด 4 ไฟล์) <p id="insert_bill" <?php if ($have_company == 1) {
                                                                                                                                    ?> style="display: inline-block; color:red" <?php } else {
                                                                                                                                                                                ?> style="display: none; color:red" <?php
                                                                                                                                                                                                                } ?>>*** เพิ่มรูปใบเสร็จของท่านเพื่อเป็นการยืนยันอย่างน้อย 1 รูป ***</p></label>
                    <!-- <a class="btn btn-primary" style="margin-left:10px;" onclick="addImage4()">+</a> -->
                    <div class="row grid">
                        <div class="col-3 grid-item">
                            <input type="file" name="image1" onchange="previewImage('image-preview1', this)" id="input1">
                        </div>
                        <div class="col-3 grid-item">
                            <input type="file" name="image2" onchange="previewImage('image-preview2', this)" id="input2">
                        </div>
                        <div class="col-3 grid-item">
                            <input type="file" name="image3" onchange="previewImage('image-preview3', this)" id="input3">
                        </div>
                        <div class="col-3 grid-item">
                            <input type="file" name="image4" onchange="previewImage('image-preview4', this)" id="input1">
                        </div>
                    </div>
                </div>
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
                    <a href="repair_have.php" class="btn btn-primary" style="color:white">เคยซ่อมแล้วหรือไม่?</a>
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
<?php
session_start();
include('database/condb.php');

$id = $_SESSION["id"];
$id_session = $_GET['id'];

if (!isset($_SESSION['r_id_'.$id_session])) {
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
            <form action="action/edit_repair.php" method="POST" class="contact-form" name="inputname" enctype="multipart/form-data">
                <div class="container">
                    <div class="grid">
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ชื่อยี่ห้อ</label>
                            <input type="text" class="form-control input" id="borderinput" name="name_brand" value="<?= $name_brand_data ?>" placeholder="กรุณากรอกชื่อยี่ห้อ" required>
                            <input type="text" class="form-control input" id="borderinput" name="session_number" value="<?= $id_session ?>" placeholder="กรุณากรอกชื่อยี่ห้อ" required hidden >
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
                    <label for="borderinput" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ (สูงสุด 4 ไฟล์)</label>
                    <!-- <a class="btn btn-primary" style="margin-left:10px;" onclick="addImage4()">+</a> -->
                    <div class="row grid">
                        <div class="col-3 grid-item">
                            <input type="file" name="image1" onchange="previewImage('image-preview1', this)" id="fileToUpload">
                        </div>
                        <div class="col-3 grid-item">
                            <input type="file" name="image2" onchange="previewImage('image-preview2', this)" id="fileToUpload">
                        </div>
                        <div class="col-3 grid-item">
                            <input type="file" name="image3" onchange="previewImage('image-preview3', this)" id="fileToUpload">
                        </div>
                        <div class="col-3 grid-item">
                            <input type="file" name="image4" onchange="previewImage('image-preview4', this)" id="fileToUpload">
                        </div>
                    </div>
                </div>

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
                    <a href="repair_have.php" class="btn btn-primary" style="color:white">เคยซ่อมแล้วหรือไม่?</a>
                    <button type="submit" class="btn btn-success" name="submit">ยืนยัน</button>
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
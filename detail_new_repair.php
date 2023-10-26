<?php
session_start();
include('database/condb.php');

$id = $_SESSION["id"];
$id_session = $_GET['session_id'];

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
    <link rel="stylesheet" href="css/detail_new_repair.css">
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
    include('bar/topbar_user.php');

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
            <h1 class="pt-5 text-center">รายละเอียดคำสั่งซ่อมที่ #<?= $id_session ?></h1>
            <center>
                <p>กรุณาตรวจสอบข้อมูลของท่านให้เรียบร้อย</p>
            </center>
            <br>
            <br>
            <form id="formedit" action="action/edit_repair.php" method="POST" class="contact-form" name="inputname" enctype="multipart/form-data">
                <div class="container">
                    <div class="grid">
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ชื่อยี่ห้อ</label>
                            <input type="text" class="form-control input" id="borderinput" name="name_brand" value="<?= $name_brand_data ?>" placeholder="กรุณากรอกชื่อยี่ห้อ" required disabled>
                            <input type="text" class="form-control input" id="borderinput" name="session_number" value="<?= $id_session ?>" placeholder="กรุณากรอกชื่อยี่ห้อ" required hidden>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">เลข Serial Number</label>
                            <input type="text" class="form-control input" id="borderinput" name="serial_number" value="<?= $serial_number_data ?>" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)" disabled>
                        </div>

                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ชื่อรุ่น</label>
                            <input type="text" class="form-control input" id="borderinput" name="name_model" value="<?= $name_model_data ?>" placeholder="กรุณากรอกชื่อรุ่น" required disabled>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">หมายเลขรุ่น</label>
                            <input type="text" class="form-control input" id="borderinput" name="number_model" value="<?= $number_model_data ?>" placeholder="กรุณากรอก หมายเลขรุ่น  (ไม่จำเป็น)" disabled>
                        </div>
                        <div class="grid-item">
                            <label for="borderinput1" class="form-label">ประเภทของการซ่อม</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="have_non_gua" disabled id="flexRadioDefault1" onclick="return check_non_gua()" <?php if ($company_data == NULL) {
                                                                                                                                                                                            ?>checked<?php
                                                                                                                                                                                                    } ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    ไม่มีประกันกับทางร้าน
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="have_gua" disabled id="flexRadioDefault2" onclick="return check_gua()" <?php if ($company_data != NULL) {
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
                            <select class="form-select" name="company" aria-label="Default select example" required disabled>

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
                        <textarea class="form-control auto-expand" id="inputtext" rows="3" name="description" required placeholder="กรุณากรอกรายละเอียด" disabled><?= $description_data ?></textarea>
                    </div>
                </div>
                <br>
                <div class="container">
                    <!-- <label for="borderinput1" class="form-label">ไฟล์อ้างอิงของท่าน</label> -->
                    <div class="row">
                        <?php
                        $i = $id_session;
                        foreach (new DirectoryIterator("uploads/$id/Holder/$i/") as $file) {    
                            if ($file->isFile()) {
                                $rp_pic = "uploads/{$id}/Holder/{$i}/" . $file->getFilename();
                                $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif'])) :
                        ?>
                                    <div class="col-md-3">
                                        <a href="#">
                                            <img src="<?= $rp_pic ?>" style="max-width: 100%; height: auto; border-radius: 2%; border: 1px solid gray" alt="picture error" onclick="openModalIMG(this)">
                                        </a>
                                    </div>
                                <?php elseif (in_array($file_extension, ['mp4', 'ogg', 'mov'])) : ?>
                                    <div class="col-md-3">
                                        <a href="#">
                                            <video style="max-width: 100%; max-height: auto; border-radius: 2%" alt="picture error" autoplay muted onclick="openModalVideo(this)" src="<?= $rp_pic ?>">
                                                <source src="<?= $rp_pic ?>" type="video/mp4">
                                                <source src="<?= $rp_pic ?>" type="video/ogg">
                                                Your browser does not support the video tag.
                                            </video>
                                        </a>
                                    </div>
                        <?php
                                endif;
                            }
                        }
                        ?>
                    </div>

                    <div id="modalimg" class="modal">
                        <span class="close" onclick="closeModalIMG()">&times;</span>
                        <img id="modal-image" src="" alt="Modal Photo">
                    </div>

                    <script src="script.js"></script>
                    <script>
                        function openModalIMG(img) {
                            var modal = document.getElementById("modalimg");
                            var modalImg = document.getElementById("modal-image");
                            modal.style.display = "block";
                            modalImg.src = img.src;
                            modalImg.style.width = "60%"; // Set the width to 1000 pixels
                            modalImg.style.borderRadius = "2%"; // Set the border radius to 20%
                            modal.classList.add("show");
                        }

                        function closeModalIMG() {
                            var modal = document.getElementById("modalimg");
                            modal.style.display = "none";
                        }
                    </script>

                    <div id="modal" class="modal">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <video id="modal-video" controls class="modal-video"></video>
                    </div>

                    <script>
                        function openModalVideo(element) {
                            var modal = document.getElementById('modal');
                            var modalVideo = document.getElementById('modal-video');

                            modal.style.display = 'block';
                            modal.classList.add('show');

                            modalVideo.src = element.src;
                            modalVideo.style.height = '90%';
                            modalVideo.style.borderRadius = '2%';
                            modalVideo.style.display = 'block';
                            modalVideo.style.margin = '0 auto';
                        }

                        function closeModal() {
                            var modal = document.getElementById('modal');
                            var modalVideo = document.getElementById('modal-video');
                            modalVideo.pause();
                            modalVideo.currentTime = 0;
                            modalVideo.src = ""; // Reset the video source
                            modal.style.display = 'none';
                        }

                        window.addEventListener('click', function(event) {
                            var modal = document.getElementById('modal');
                            if (event.target === modal) {
                                closeModal();
                            }
                        });
                    </script>
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
                    <a href="listview_repair.php" class="btn btn-primary">กลับสู่หน้าการซ่อม</a>
                    <a href="edit_repair.php?id=<?= $id_session ?>" class="btn btn-danger">แก้ไขข้อมูล</a>
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
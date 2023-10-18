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

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            /* Dim black background */
        }

        .modal-content {
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 100%;
            max-height: 100%;
            background-color: black;
            /* Set the background color to black */
        }

        #modal-image {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: auto;
            /* Center the image horizontally */
        }


        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .iframe-container {
            display: none;
        }

        .check_icon {
            margin-left: 10px;
        }

        #drop-shadow {
            border-radius: 5%;
            box-shadow: 0 2px 4px rgba(0, 0.2, 0.2, 0.2);
            /* Adjust the shadow properties as needed */
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
                    </div>

                    <div class="grid-item" id="check_gua">
                        <label for="borderinput1" class="form-label">บริษัท</label>
                        <?php
                        $sql_company = "SELECT * FROM company WHERE del_flg = '0' AND com_id = '$company'";
                        $result_company = mysqli_query($conn, $sql_company);
                        $row_company = mysqli_fetch_array($result_company);
                        if ($row_company[0] > 0) {

                        ?>
                            <input type="text" class="form-control input" id="borderinput" value="<?= $row_company['com_name'] ?>" name="com_name" placeholder="กรุณากรอกชื่อรุ่น" required readonly>
                        <?php
                        } else {
                        ?>
                            <input type="text" class="form-control input" id="borderinput" value="ไม่มีประกัน" name="com_name" placeholder="กรุณากรอกชื่อรุ่น" required readonly>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                    <textarea class="form-control" id="inputtext" rows="3" name="description" required placeholder="กรุณากรอกรายละเอียด" readonly><?= $description ?></textarea>
                </div>
            </div>
            <br>
            <div class="container">
                <label for="borderinput1" class="form-label">ไฟล์อ้างอิงของท่าน</label>
                <div class="row">
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
                    foreach (new DirectoryIterator("uploads/$id/Holder/$i/") as $file) {
                        if ($file->isFile()) {
                            $rp_pic = "uploads/{$id}/Holder/{$i}/" . $file->getFilename();
                            $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                    ?>
                            <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif'])) : ?>
                                <div class="col-3">
                                    <a href="#">
                                        <img src="<?= $rp_pic ?>" style="max-width: 100%; height: auto; border-radius:2%" alt="picture error" onclick="openModalIMG(this)">
                                    </a>
                                </div>
                            <?php elseif (in_array($file_extension, ['mp4', 'ogg', 'mov'])) : ?>
                                <div class="col-3">
                                    <a href="#">
                                        <video style="max-width: 100%; height: auto; border-radius:2%" alt="picture error" autoplay muted onclick="openModalVideo(this)" src="<?= $rp_pic ?>">
                                            <source src="<?= $rp_pic ?>" type="video/mp4">
                                            <source src="<?= $rp_pic ?>" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    </a>
                                </div>
                            <?php endif; ?>

                    <?php
                        }
                    }
                    ?>
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
                    <!-- Modal -->
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
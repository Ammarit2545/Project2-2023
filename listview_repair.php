<?php
session_start();
include('database/condb.php');

$id = $_SESSION["id"];

if (!isset($_SESSION["id"])) {
    header('Location:home.php');
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

    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>ANE - Repair Request</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .grid {
            margin-bottom: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            /* if 4 is 200px */
            grid-gap: 3rem;
        }

        .grid-item {
            /* box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); */
            /* Add a gray shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Add transition for transform and box-shadow */
        }

        .grid-item:hover {
            transform: scale(1.1);
            /* Increase size on hover */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            /* Increase shadow size and intensity on hover */

        }


        #card-show {
            display: flex;
            justify-content: center;
            width: 100%;
            height: 100%;
            text-align: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            text-decoration: none;
            font-size: 47px;
        }

        a {
            text-decoration: none;
            /* Remove underline */
        }

        a:hover {
            text-decoration: none;
            /* Remove underline on hover */
        }

        #card-show i {
            transition: transform 0.3s;
        }

        #card-show:hover i {
            transform: scale(1.2);
        }

        .grid-item .tooltip {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 8px;
            border-radius: 4px;
            font-size: 14px;
            white-space: nowrap;
            transition: opacity 0.3s, transform 0.3s;
        }

        .grid-item:hover .tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-10px);
            animation: tooltipFadeIn 0.3s, tooltipBounce 0.6s;
        }

        #drop-shadow {
            border-radius: 10%;
            box-shadow: 0 2px 4px rgba(0, 0.2, 0.2, 0.2);
            /* Adjust the shadow properties as needed */
            object-fit: cover;
            width: 50px;
        }

        #card-detail {
            width: 100%;
            height: 100%
        }

        @keyframes tooltipFadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes tooltipBounce {

            0%,
            100% {
                transform: translateX(-50%) translateY(-10px);
            }

            50% {
                transform: translateX(-50%) translateY(0);
            }
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
    </style>
</head>

<body>
    <?php
    include('bar/topbar_user.php');

    $i = 1;

    while (isset($_SESSION['r_id_' . $i])) {
        $i += 1;
    }
    $i -= 1;
    // The value of $i will be the lastest session r_id_ + 1

    ?>
    <br><br><br>
    <h1 class="pt-5 text-center">
        การบริการส่งซ่อม
    </h1>
    <center>
        <p>สามารถเพิ่มได้หลายรายการ</p>
    </center>
    <br><br>
    <div class="container">
        <div class="grid">
            <div class="grid-item">
                <!-- <a href="add_repair_information.php" class="card-show"> -->
                <a href="add_repair.php" class="card-show">
                    <div class="alert alert-secondary" id="card-show">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                    <span class="tooltip">เพิ่มการส่งซ่อมใหม่</span>
                </a>
            </div>

            <?php

            $i = 0;

            if (!isset($_SESSION["r_id_1"])) {
            } else {
                for ($i = 1; $i < 1000; $i++) {
                    $r_id = 'r_id_' . $i;

                    if (isset($_SESSION[$r_id])) {
                        $r_id = 'r_id_' . $i;

                        $_SESSION[$r_id] = $i;

                        $name_brand = 'name_brand_' . $i;

                        $serial_number = 'serial_number_' . $i;

                        $name_model = 'name_model_' . $i;

                        $number_model = 'number_model_' . $i;

                        $tel = 'tel_' . $i;

                        $description = 'description_' . $i;

                        $company = 'company_' . $i;

                        $image1 = 'image1_' . $i;

                        $image2 = 'image2_' . $i;

                        $image3 = 'image3_' . $i;

                        $image4 = 'image4_' . $i;

                        $id_repair_ever = 'id_repair_ever_' . $i;

                        $id_repair_round = 'id_repair_round_' . $i;
            ?>
                        <div class="grid-item">
                            <a href="detail_new_repair.php?session_id=<?= $i ?>">
                                <div class="card" id="card-detail">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <h5 style="display:inline; margin-right:10px" class="btn btn-secondary"><?= $_SESSION[$r_id] ?></h5><?= $_SESSION[$name_brand] ?> <?= $_SESSION[$name_model] ?>
                                            <?php
                                            $company_name = $_SESSION[$company];
                                            if ($company_name != NULL) {
                                                $sql_c = "SELECT * FROM company WHERE com_id = '$company_name' AND del_flg = '0'";
                                                $result_c = mysqli_query($conn, $sql_c);
                                                $row_c = mysqli_fetch_array($result_c);

                                                $company_name = $row_c['com_name'];
                                            ?>
                                            <br><hr>
                                            <h6 style="display:inline; margin-right:10px;color:black" >บริษัทประกัน : <u><?= $company_name ?></u></h6>
                                        
                                            <?php } ?>


                                        </h5>
                                        <h6 class="card-subtitle mb-2 text-muted mt-2">Serial Number : <?= $_SESSION[$serial_number] ?>
                                            <?php if (isset($_SESSION[$id_repair_ever])) {   ?>
                                                <?php if ($_SESSION[$id_repair_round] > 1) { ?>
                                                    <span style="display:inline; margin-right:10px" class="btn btn-primary">ครั้งที่ # <?= $_SESSION[$id_repair_round] ?></span>
                                                <?php } ?>
                                            <?php  } ?>
                                        </h6>
                                        <hr>
                                        <!-- <h6 style="display:inline">รายละเอียดการซ่อม : </h6>
                                        <p class="card-text" style="display:inline"><?= $_SESSION[$description] ?></p>
                                        <hr> -->
                            </a>
                            <!-- <?php if ($_SESSION['image1_' . $i] != NULL || $_SESSION['image2_' . $i] != NULL || $_SESSION['image3_' . $i] != NULL || $_SESSION['image_' . $i] != NULL) { ?>
                                <h6>รูปภาพประกอบ</h6>
                            <?php } ?> -->
                            <h6>รูปภาพ/ไฟล์</h6>
                            <?php
                            $folderPath = "uploads/$id/Holder/$i/"; // Replace with the actual path to your folder

                            $files = scandir($folderPath);

                            foreach (new DirectoryIterator("uploads/{$id}/Holder/{$i}/") as $file) {
                                if ($file->isFile()) {
                                    $rp_pic = "uploads/{$id}/Holder/{$i}/" . $file->getFilename();
                                    $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                            ?>

                                    <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif'])) : ?>
                                        <img src="<?= $folderPath . '/' . $file ?>" class="picture_modal" alt="" onclick="openModalIMG(this)" style="width: 15%;  border : 1px solid gray; border-radius: 10%;">
                                    <?php elseif (in_array($file_extension, ['mp4', 'ogg', 'mov'])) : ?>
                                        <video style="width: 10%; height: 10%; border-radius: 10%; border : 1px solid gray;" class="picture_modal_video" alt="picture error" autoplay muted onclick="openModalVideo(this)" src="<?= $rp_pic ?>">
                                            <source src="<?= $rp_pic ?>" type="video/mp4">
                                            <source src="<?= $rp_pic ?>" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php endif; ?>

                            <?php
                                }
                            }
                            ?>


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
                            <hr>

                            <div class="d-flex justify-content-end">
                                <a href="edit_repair.php?id=<?= $i ?>" class="btn btn-outline-primary" style="margin-right: 10px;">แก้ไข</a>
                                <a class="btn btn-outline-danger ml-2" onclick="confirmDelete('<?= $_SESSION[$r_id] ?>')">ลบ</a>
                            </div>
                        </div>
        </div>
        <span class="tooltip">คำสั่งซ่อมที่ #<?= $_SESSION[$r_id] ?></span>
    </div>

<?php
                    }
                }
            } ?>
</div>
<div id="modalimg" class="modal">
    <span class="close" onclick="closeModalIMG()">&times;</span>
    <img id="modal-image" src="" alt="Modal Photo">
</div>
<!-- Modal -->
<div id="modal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <video id="modal-video" controls class="modal-video"></video>
</div>
<script src="script.js"></script>
<?php

mysqli_query($conn, "SET NAMES 'utf8' ");
error_reporting(error_reporting() & ~E_NOTICE);
date_default_timezone_set('Asia/Bangkok');

$sql_provinces = "SELECT * FROM provinces";
$query = mysqli_query($conn, $sql_provinces);

?>

<div style="display: none;">
    <hr>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <br>
    <h3>กรุณากรอกรายละเอียดที่อยู่ของท่าน</h3>
    <br>
    <label for="sel1">จังหวัด:</label>
    <select class="form-control" name="Ref_prov_id" id="provinces">
        <option value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
        <!-- <option value="18" >สระแก้ว</option> -->
        <?php foreach ($query as $value) { ?>
            <option value="<?= $value['id'] ?>"><?= $value['name_th'] ?></option>
        <?php } ?>
    </select>
    <br>

    <label for="sel1">อำเภอ:</label>
    <select class="form-control" name="Ref_dist_id" id="amphures" required>
    </select>
    <br>

    <label for="sel1">ตำบล:</label>
    <select class="form-control" name="Ref_subdist_id" id="districts" required>
    </select>
    <br>

    <label for="sel1">รหัสไปรษณีย์:</label>
    <input type="text" name="zip_code" id="zip_code" class="form-control" required>
    <br>
    <input type="text" name="get_r_id" value="<?= $id_g ?>" required hidden>
    <br>
    <label for="exampleFormControlTextarea1" class="form-label">กรุณากรอกที่อยู่ที่ต้องการจัดส่ง</label>
    <textarea class="form-control auto-expand" name="description" id="exampleFormControlTextarea1" rows="3" required><?= $_SESSION['address'] ?></textarea>
    <hr>
</div>
</div>

<center>
    <?php if (isset($_SESSION['r_id_1'])) {
    ?>
        <button class="btn btn-success" onclick="confirmReq()">ยืนยัน</button>
    <?php
    } ?>

</center>
<br><br><br><br>
<?php include('script.php'); ?>
<!-- <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
                <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> -->
<script>
    function confirmReq(cardId) {
        swal.fire({
            title: 'คุณต้องการเพิ่มรายการเหล่านี้หรือไม่?',
            text: 'การกระทำนี้ไม่สามารถย้อนกลับได้',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ทำการเพิ่ม',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, perform the delete action
                AddNewCard(cardId);
            }
        });
    }

    function AddNewCard(cardId) {
        // Perform the delete action
        window.location.href = 'add_detail.php';
    }

    function confirmDelete(cardId) {
        swal.fire({
            title: 'คุณต้องการลบรายการนี้หรือไม่?',
            text: 'การกระทำนี้ไม่สามารถย้อนกลับได้',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, perform the delete action
                deleteCard(cardId);
            }
        });
    }

    function deleteCard(cardId) {
        // Perform the delete action
        window.location.href = 'action/delete_card.php?id=' + cardId;
    }
    // Assuming you have included Font Awesome library

    // If you are using Font Awesome 4
    var icon = document.querySelector('#card-show i');
    icon.classList.add('fa-plus');

    // If you are using Font Awesome 5
    var icon = document.querySelector('#card-show i');
    icon.classList.add('fas', 'fa-plus');
</script>
<?php
if (isset($_SESSION['add_data_detail'])) {
    $message = "";
    $icon = "error";

    switch ($_SESSION['add_data_detail']) {
        case 1:
            $message = "โปรดทำการเพิ่มรายการส่งซ่อมก่อนทำรายการ";
            break;
        case 2:
            $message = "ไม่มีรายการนี้";
            break;
        case 3:
            $message = "ทำรายการสำเร็จ";
            $icon = "success";
            break;
        case 4:
            $message = "ไม่สามารถทำรายการได้";
            $message .= "\nโปรดติดต่อผู้ดูแลระบบ";
            break;
        default:
            // Handle any other cases if needed
            break;
    }
?>

    <script>
        Swal.fire({
            title: '<?= $message ?>',
            text: 'กด Accept เพื่อออก',
            icon: '<?= $icon ?>',
            confirmButtonText: 'Accept'
        });
    </script>

<?php
    unset($_SESSION['add_data_detail']);
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

    function closeModal() {
        var modal = document.getElementById('modal');
        var modalVideo = document.getElementById('modal-video');
        modalVideo.pause();
        modalVideo.currentTime = 0;
        modalVideo.src = ""; // Reset the video source
        modal.style.display = 'none';
    }
</script>
<?php include('footer/footer.php'); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>



</html>
<?php
session_start();
include('database/condb.php');

$id = $_SESSION["id"];

$sql = "SELECT * FROM member WHERE m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

?>

<!-- MAIN -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/all_page.css">
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>ANE - Repair Request</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    <style>
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
    <?php
    include('bar/topbar_user.php');

    $i = 1;

    while (isset($_SESSION['r_id_' . $i])) {
        $i += 1;
    }
    $i -= 1;
    // The value of $i will be the lastest session r_id_ + 1


    $jsonobj = $row['m_add'];

    $obj = json_decode($jsonobj);

    $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
    FROM provinces
    LEFT JOIN amphures ON provinces.id = amphures.province_id
    LEFT JOIN districts ON amphures.id = districts.amphure_id
    WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
    $result_p = mysqli_query($conn, $sql_p);
    $row_p = mysqli_fetch_array($result_p);

    ?>
    <br><br><br>
    <h1 class="pt-5 text-center">
        เพิ่มข้อมูลการติดต่อของท่าน
        <!-- <?= $i ?> -->
    </h1>
    <center>
        <p>ข้อมูลนี้จะต้องเป็นข้อมูลจริงที่สามารถใช้ติดต่อท่านได้</p>
    </center>

    <form id="detail_repair" action="action/add_all_req.php" method="POST">
        <div class="container">
            <div class="mb-3" id="old_address">
                <label for="exampleFormControlTextarea1" class="btn btn-outline-primary">รายละเอียดข้อมูลการติดต่อ</label>
                <br><br>
                <?php if ($row['m_add'] != NULL) {
                ?>
                    <div class="row">
                        <div class="col-4" id="bounce-item">
                            <label for="exampleFormControlTextarea1" class="col-form-label">จังหวัด :</label>
                            <input type="text" class="form-control" value="<?= $row_p[0] ?>" readonly>
                        </div>
                        <div class="col-4" id="bounce-item">
                            <label for="exampleFormControlTextarea1" class="col-form-label">อำเภอ :</label>
                            <input type="text" class="form-control" value="<?= $row_p[1] ?>" readonly>
                        </div>
                        <div class="col-4" id="bounce-item">
                            <label for="exampleFormControlTextarea1" class="col-form-label">ตำบล :</label>
                            <input type="text" class="form-control" value="<?= $row_p[2] ?>" readonly>
                        </div>
                    </div>
                    <br>
                    <label for="exampleFormControlTextarea1" class="col-form-label" id="bounce-item">รายละเอียดเพิ่มเติม :</label>
                    <textarea class="form-control" id="bounce-item" rows="3" disabled="disabled"><?php
                                                                                                    if ($obj->description        == NULL) {
                                                                                                        echo "ไม่มีข้อมูล";
                                                                                                    } else {

                                                                                                        echo $obj->description;
                                                                                                    }
                                                                                                    ?>
                                </textarea>
                <?php
                } else {
                ?>
                    <center>
                        <h5>ไม่มีข้อมูลที่อยู่</h5>
                    </center>
                <?php
                }
                ?>
            </div>

            <?php

            mysqli_query($conn, "SET NAMES 'utf8' ");
            error_reporting(error_reporting() & ~E_NOTICE);
            date_default_timezone_set('Asia/Bangkok');

            $sql_provinces = "SELECT * FROM provinces";
            $query = mysqli_query($conn, $sql_provinces);

            ?>
            <center>
                <button class="btn btn-primary" onclick="New_address()" id="button_new_address" style="display: block;">ต้องการใช้ที่อยู่ใหม่</button>
            </center>
            <div id="address" style="display:none">
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
                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" required><?= $_SESSION['address'] ?></textarea>
                <center>
                    <br>
                    <a class="btn btn-warning" onclick="New_address()" href="">ต้องการใช้ที่อยู่เดิม</a>
                </center>
                <br>
            </div>

            <label for="exampleFormControlTextarea1" class="col-form-label">เบอร์โทรศัพท์ :</label>
            <input type="text" name="get_tel" class="form-control" value="<?= $row['m_tel'] ?>" required>
            <br>
            <label for="exampleFormControlTextarea1" class="col-form-label">โปรดเลือกวิธีการรับอุปกรณ์ :</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="0" checked>
                <label class="form-check-label" for="flexRadioDefault1">
                    รับที่ร้าน
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="1">
                <label class="form-check-label" for="flexRadioDefault2">
                    จัดส่งโดยขนส่ง <span style="color:red"> (ที่อยู่ตามที่ท่านได้กรอกลงไป)</span>
                </label>
            </div>
        </div>
    </form>

    <br>
    <br>
    <center>
        <a href="listview_repair.php" class="btn btn-danger">กลับไปแก้ไขข้อมูลอุปกรณ์</a>
        <button class="btn btn-success" onclick="confirmReq()">ยืนยัน</button>
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
            document.getElementById('detail_repair').submit();
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

        function New_address() {
            document.getElementById('address').style.display = 'block';
            document.getElementById('old_address').style.display = 'none';
            document.getElementById('button_new_address').style.display = 'none';
        }

        // function Close_New_address() {
        //     document.getElementById('address').style.display = 'none';
        //     document.getElementById('old_address').style.display = 'none';
        //     document.getElementById('button_new_address').style.display = 'none';
        // }
    </script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>



</html>
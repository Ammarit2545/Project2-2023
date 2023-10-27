<?php
session_start();
include('../database/condb.php');

if (!isset($_SESSION['role_id'])) {

    header('Location:../home.php');
}
$disallowed_roles = array(1, 2, 3);

if (!in_array($_SESSION['role_id'], $disallowed_roles)) {
    header('Location: ../home.php');
}
$get_r_id = $_GET['id'];


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Repair Information - Anan Electronic</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">


</head>
<style>
    body {
        font-family: 'Kanit', sans-serif;
    }

    .bg-img-1 {
        position: relative;
        background-image: url('../img/background/blue_1.png');
        background-size: cover;
        background-repeat: no-repeat;
        height: 100%;
        border-radius: 10px;
        /* Adjust the height as needed */
    }

    .overlay {

        width: 100%;
        height: 100%;
        background-color: rgba(246, 246, 246, 0.2);
        /* Adjust the background color and opacity as needed */
    }


    <?php include('../css/all_page.css'); ?>

    /* Your existing CSS classes */
    .picture_modal {
        margin-right: 20px;
        border-radius: 10%;
    }

    .image-container {
        position: relative;
        display: inline-block;
        margin: 8px;
    }

    .preview-image {
        display: block;
        width: 200px;
        height: auto;
    }

    .delete-button {
        position: absolute;
        top: 0;
        right: 0;
        background-color: none;
        border: none;
        color: black;
        font-weight: bold;
        font-size: 24px;
        cursor: pointer;
        outline: none;
    }

    .gallery {
        display: flex;
        flex-wrap: wrap;
    }

    .gallery img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
        margin: 10px;
    }

    .modal_ed {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.8);
        opacity: 0;
        transition: opacity 0.3s ease-in;
    }

    .modal_ed.show {
        opacity: 1;
    }

    .modal-image {
        display: block;
        margin: 0 auto;
        max-width: 80%;
        max-height: 80%;
        text-align: center;
    }

    .close {
        color: #fff;
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #ccc;
        text-decoration: none;
        cursor: pointer;
    }

    .part_pic_show {
        border-radius: 20%;
    }

    .color_text {
        color: white;
    }

    .file-input-container {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .file-input-container label {
        margin-right: 10px;
        text-align: start;
    }

    .file-input-container .col-4 {
        flex: 0 0 25%;
        max-width: 25%;
        padding: 0 5px;
    }

    .no-scrollbar {
        overflow: hidden;
    }

    .grid {
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        grid-gap: 2rem;
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

    #modalimg {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Fixed position to cover the whole viewport */
        z-index: 9999;
        /* Set a high z-index to make it appear on top of everything */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        /* Semi-transparent background */
    }

    #modal_ed {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Fixed position to cover the whole viewport */
        z-index: 9999;
        /* Set a high z-index to make it appear on top of everything */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        /* Semi-transparent background */
    }

    .modal-video {
        /* Add styles for the video element, e.g., width and height */
        width: 80%;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }


    /* Rest of your modal styles... */

    .close {
        position: absolute;
        top: 15px;
        right: 15px;
        color: #fff;
        font-size: 25px;
        cursor: pointer;
    }
</style>
<style>
    /* Style the search input */
    #search-box {
        width: 300px;
        padding: 10px;
    }

    /* Style the autocomplete container */
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    /* Style the autocomplete list */
    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        max-height: 150px;
        overflow-y: auto;
        z-index: 99;
    }

    /* Style each autocomplete item */
    .autocomplete-item {
        padding: 10px;
        cursor: pointer;
    }

    /* Highlight the selected autocomplete item */
    .autocomplete-item:hover {
        background-color: #e9e9e9;
    }

    <?php
    $repair_count = 0;
    // $get_r_id = $_GET['id'];
    $parts_ar = array();
    $sql_get_co = "SELECT p_id,p_brand, p_model FROM parts ";

    $result_get_co = mysqli_query($conn, $sql_get_co);

    while ($row_get_co = mysqli_fetch_array($result_get_co)) {
        $brand = $row_get_co['p_brand'];
        $model = $row_get_co['p_model'];
        $p_id = $row_get_co['p_id'];
        $part_str = "\"$brand $model\"";
        $parts_ar[$p_id] = $part_str;
    }

    // Now $parts_ar contains an array of strings with brand and model enclosed in double quotes
    ?>
</style>

<body id="page-top">


    <div id="modalimg" class="modal_ed">
        <span class="close" onclick="closeModalIMG()">&times;</span>
        <img id="modal-image" src="" alt="Modal Photo">
    </div>
    <!-- Modal -->
    <div id="modal_ed" class="modal_ed">
        <span class="close" onclick="closeModal()">&times;</span>
        <video id="modal-video" controls class="modal-video"></video>
    </div>

    <!-- Modal -->
    <!-- Your HTML content -->


    <!-- Page Wrapper -->
    <div id="wrapper">


        <!-- Sidebar -->
        <?php
        include('bar/sidebar.php');
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">


            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php
                include('bar/topbar_admin.php');
                ?>
                <!-- End of Topbar -->



                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    $get_r_id = $_GET['id'];

                    $sql = "SELECT * FROM get_repair
                    LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id 
                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id 
                                        LEFT JOIN member ON member.m_id = repair.m_id
                                        LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id
                                        LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
                                        WHERE  repair_status.del_flg = '0' AND get_repair.get_r_id = '$get_r_id' ORDER BY rs_date_time DESC;";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);

                    $sql_s = "SELECT * FROM repair_status 
                            WHERE del_flg = '0' AND get_r_id = '$get_r_id'
                            ORDER BY rs_date_time DESC LIMIT 1";
                    $result_s = mysqli_query($conn, $sql_s);
                    $row_s = mysqli_fetch_array($result_s);
                    $rs_id = $row_s['rs_id'];

                    $sql_get_count = "SELECT COUNT(get_r_id) FROM get_detail 
                    WHERE get_r_id = '$get_r_id' ";
                    $result_get_count = mysqli_query($conn, $sql_get_count);
                    $row_get_count = mysqli_fetch_array($result_get_count);



                    $dateString = date('d-m-Y', strtotime($row['get_r_date_in']));
                    $date = DateTime::createFromFormat('d-m-Y', $dateString);
                    $formattedDate = $date->format('F / d / Y');
                    ?>
             

                    <div class="card-header py-3">
                        <?php
                        $sql_2 = "SELECT gr.get_config
                                        FROM get_repair gr
                                        WHERE gr.get_r_id = '$get_r_id'";
                        $result_2 = mysqli_query($conn, $sql_2);
                        $row2 = mysqli_fetch_array($result_2);
                        $row2['get_config'];
                        if ($row2['get_config'] > 0) {
                        ?>
                            <div class="row">
                                <div class="alert alert-primary" role="alert">
                                    <h5> ต่อเนื่องมาจากหมายเลขซ่อมสั่งซ่อมที่ : <?= $row2['get_config'] ?></h5>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <h1 class="m-0 font-weight-bold mb-2 f-black-5">หมายเลขใบแจ้งซ่อม #<?= $row['get_r_id'] ?></h1>
                        <!-- <a class="btn btn-danger" href="action/delete_repair.php?get_r_id=<?= $row['get_r_id'] ?>" onclick="return confirmDelete(event);">ลบ</a>

                                                       
                                                        <script>
                                                            function confirmDelete(event) {
                                                                event.preventDefault(); // Prevent the default action of the link

                                                                Swal.fire({
                                                                    title: 'คุณแน่ใจหรือไม่?',
                                                                    text: 'คุณต้องการลบข้อมูลนี้หรือไม่',
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#dc3545',
                                                                    cancelButtonColor: '#6c757d',
                                                                    confirmButtonText: 'Yes, delete it!'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // If confirmed, continue with the deletion process
                                                                        window.location.href = event.target.href; // Redirect to the deletion URL
                                                                    }
                                                                });
                                                            }
                                                        </script> -->
                        <!-- <?php
                                if ($row_get_count[0] == 1) {
                                ?>
    <h1 class="m-0 font-weight-bold text-success mb-2">Serial Number : <?= $row['r_serial_number'] ?></h1>
<?php
                                } else { ?>
    <h1 class="m-0 font-weight-bold text-success mb-2">คำส่งซ่อมนี้มี <?= $row_get_count[0] ?> รายการ</h1>
<?php
                                }
?> -->
                        <h2>สถานะล่าสุด : <button id="bounce-item" onclick="openModalStatus('quantitystatus')" style="background-color: <?= $row['status_color'] ?>; color : white;" class="btn btn"> <?= $row['status_name'] ?>
                                <?php
                                if ($row['status_id'] == 6) {
                                    $get_r_id = $row['get_r_id'];
                                    $carry_out_id = $row['status_id'];
                                    $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = '$get_r_id' AND status_id = 6ORDER BY rs_date_time DESC;";
                                    $result_carry_out = mysqli_query($conn, $sql_cary_out);
                                    $row_carry_out = mysqli_fetch_array($result_carry_out);

                                    if ($row_carry_out[0] > 1) {
                                ?>
                                        #ครั้งที่ <?= $row_carry_out[0] ?>

                                <?php
                                    }
                                }
                                ?></h2>
                        <span class="tooltip">ดูสถานะ</span>
                        </button>
                        <br>
                        <h6>วันแรกที่ทำการแจ้ง : <?= $formattedDate ?></h6>

                    </div>
                    <div class="card shadow bg-img-1 overlay">
                        <?php
                        $repair_count = 0;
                        $sql_get_c1 = "SELECT * FROM get_detail
                                                        LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                        WHERE get_detail.get_r_id =  '$get_r_id' ";
                        $result_get_c1 = mysqli_query($conn, $sql_get_c1);
                        while ($row_get_c1 = mysqli_fetch_array($result_get_c1)) {
                            $repair_count++;
                        } ?>
                        <!-- Button trigger modal -->
                        <button id="bounce-item" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <h5 style="margin-bottom: 0px;"> รายละเอียดอุปกรณ์ (มี <?= $repair_count ?> อุปกรณ์)</h5>
                            <span class="tooltip">รายการอะไหล่ที่ใช้</span>
                        </button>
                        <br>
                        <div class="container p-2">
                            <div class="row">
                                <div class="col" id="bounce-item">
                                    <center>
                                        <!-- <h4><a href="#" onclick="openModalPart('status')">ติดตามสถานะ <i class="fa fa-chevron-right" style="color: gray; font-size: 17px;"></i></a></h4> -->
                                        <h3>
                                            <a href="#" class="un-scroll f-white-1" onclick="openModalStatus('quantitystatus')">ติดตามสถานะ <i class="fa fa-chevron-right" style="color: gray; font-size: 17px;"></i>
                                                <span class="tooltip">ดูสถานะ</span>
                                            </a>
                                        </h3>
                                    </center>
                                </div>
                                <div class="col">
                                    <center>
                                        <h3 style="color: white;">|</h3>
                                    </center>
                                </div>
                                <div class="col" id="bounce-item">
                                    <center>
                                        <h3>
                                            <a href="#" class="un-scroll f-white-1" onclick="openModalPart('quantitypart')">จำนวนอะไหล่ <i class="fa fa-chevron-right" style="color: gray; font-size: 17px;"></i>
                                                <span class="tooltip">รายการอะไหล่ที่ใช้</span>
                                            </a>
                                        </h3>
                                    </center>
                                </div>

                            </div>
                        </div>
                        <br>
                        <hr style="background-color: white;">
                        <?php
                        $repair_count = 0;
                        $sql_get_c = "SELECT * FROM get_detail
                                                        LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                        WHERE get_detail.get_r_id =  '$get_r_id' ";
                        $result_get_c = mysqli_query($conn, $sql_get_c);
                        while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                            $repair_count++;
                        } ?>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header"> :
                                        <h4>รายการซ่อมในหมายเลขแจ้งซ่อม <?= $get_r_id  ?></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="background-color: #E7E7E7;">
                                        <br>
                                        <div class="container">


                                            <?php
                                            $count_get_no = 0;
                                            $repair_count = 0;
                                            $sql_get_c2 = "SELECT *
                                            FROM get_detail
                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                            LEFT JOIN company_transport ON  tracking.t_c_id = company_transport.com_t_id
                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                            WHERE get_detail.get_r_id = '$get_r_id';
                                            ";
                                            $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN company_transport ON  tracking.t_c_id = company_transport.com_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$get_r_id' AND get_d_conf = 0";
                                            $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                                            $result_get = mysqli_query($conn, $sql_get_c2);
                                            $row_get_count_track = mysqli_fetch_array($result_get_count_track);

                                            $sql_get_c = "SELECT * FROM get_detail
                                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                                            
                                                            LEFT JOIN company_transport ON  tracking.t_c_id = company_transport.com_t_id
                                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                                            WHERE get_detail.get_r_id =  '$get_r_id' ";
                                            $result_get_c = mysqli_query($conn, $sql_get_c);
                                            while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                                                $repair_count++;
                                            }
                                            if ($repair_count > 0) {
                                            ?>
                                                <h2>มีรายการซ่อมทั้งหมด <span class="badge bg-primary"><?= $repair_count ?></span> รายการ</h2>
                                                <hr>
                                                <br>
                                            <?php
                                            }

                                            while ($row_get = mysqli_fetch_array($result_get)) {
                                                $count_get_no++;
                                            ?>
                                                <div class="row alert alert-light shadow">
                                                    <h1 style="text-align:start; color:blue" id="body_text">
                                                        <span>รายการที่ <?= $count_get_no ?></span> :
                                                        <span class="f-black-5">
                                                            <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" class="un-scroll f-black-5" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item"><?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?><span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                            </a>
                                                        </span>
                                                    </h1>
                                                    <hr>
                                                    <div style=" color:#2c2f34" class="my-4">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md alert alert-light shadow ml-1 bg-gray-1">
                                                                    <h5 class="f-black-5">ข้อมูลอุปกรณ์</h5>
                                                                    <hr>
                                                                    <p class=" f-gray-5">
                                                                        <?php if ($row_get['com_id'] != NULL) { ?><br>
                                                                            <span class="badge bg-success">
                                                                                ประกัน :
                                                                                <span>
                                                                                    <?php
                                                                                    $com_id = $row_get['com_id'];
                                                                                    $sql_com = "SELECT com_name FROM company WHERE com_id ='$com_id'";
                                                                                    $result_com = mysqli_query($conn, $sql_com);
                                                                                    $row_com = mysqli_fetch_array($result_com);
                                                                                    echo $row_com['com_name'];
                                                                                    $row_get['r_id']
                                                                                    ?>
                                                                                </span>
                                                                            </span>
                                                                        <?php } ?>
                                                                        <?php if ($row_get['r_guarantee'] != NULL) { ?><br>ระยะประกัน :
                                                                            <span class="f-black-5"><?= $row_get['r_guarantee'] ?> ปี</span><?php } ?>
                                                                        <?php if ($row_get['r_id'] != NULL) { ?><br>รหัสอุปกรณ์ในระบบ :
                                                                            <span class="f-black-5"><?= $row_get['r_id'] ?></span>
                                                                            <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item">
                                                                                <i class="fa fa-question-circle"></i>
                                                                                <span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                                            </a>
                                                                        <?php } ?>
                                                                        <?php if ($row_get['r_brand'] != NULL) { ?><br>ยี่ห้อ/แบรนด์ :
                                                                            <span class="f-black-5"><?= $row_get['r_brand'] ?></span><?php } ?>
                                                                        <?php if ($row_get['r_model'] != NULL) { ?><br>รุ่น :
                                                                            <span class="f-black-5"><?= $row_get['r_model'] ?></span><?php } ?>
                                                                        <?php if ($row_get['r_number_model'] != NULL) { ?><br>หมายเลขรุ่น :
                                                                            <span class="f-black-5"><?= $row_get['r_number_model'] ?></span><?php } ?>
                                                                        <?php if ($row_get['r_serial_number'] != NULL) { ?><br>หมายเลขประจำเครื่อง/Serial Number :
                                                                            <span class="f-black-5"><?= $row_get['r_serial_number'] ?></span><?php } ?>
                                                                        <?php if ($row_get['t_parcel'] != NULL) { ?><br>หมายเลขพัสดุ :
                                                                            <span class="f-black-5"><?= $row_get['t_parcel'] ?></span>
                                                                        <?php }
                                                                        if ($row_get['com_t_name'] != NULL) { ?><br>ชื่อบริษัท :
                                                                            <span class="f-black-5"><?= $row_get['com_t_name'] ?></span>
                                                                        <?php } ?>
                                                                    </p>
                                                                    <br>
                                                                    <h5 class="mb-3" style="color:black">รายละเอียดอาการ</h5>
                                                                    <hr>
                                                                    <p><?= $row_get['get_d_detail'] ?></p>
                                                                </div>
                                                                <div class="col-md-1"></div>
                                                                <?php
                                                                $check_have_pic = 0;
                                                                $get_d_id = $row_get['get_d_id'];
                                                                $sql_pic = "SELECT * FROM repair_pic
                                                                            LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                                                            WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.get_d_id = '$get_d_id'";
                                                                $result_pic = mysqli_query($conn, $sql_pic);
                                                                if (mysqli_num_rows($result_pic)) {
                                                                    $check_have_pic++;
                                                                ?>
                                                                    <div class="col-md-5 alert alert-light shadow bg-gray-1">
                                                                        <h5 style="color:black" class="mb-3">รูปภาพ</h5>
                                                                        <hr>
                                                                        <br>
                                                                        <?php }
                                                                    while ($row_pic = mysqli_fetch_array($result_pic)) {
                                                                        if ($row_pic[0] != NULL) {
                                                                        ?>
                                                                            <?php
                                                                            $rp_pic = $row_pic['rp_pic'];
                                                                            $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                                            ?>
                                                                            <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                                                <a href="#" id="bounce-item"><img src="../<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                                            <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                                                <a href="#">
                                                                                    <video width="100px" autoplay muted onclick="openModalVideo(this)" src="../<?= $row_pic['rp_pic'] ?>">
                                                                                        <source src="../<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                                                        <source src="../<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                                                        Your browser does not support the video tag.
                                                                                    </video>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        <?php
                                                                        }
                                                                    }
                                                                    if ($check_have_pic > 0) { ?>
                                                                    </div>
                                                                <?php  } ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php
                                            $count_get_no = 0;
                                            $sql_get_c3 = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            
                                                            LEFT JOIN company_transport ON  tracking.t_c_id = company_transport.com_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$get_r_id' AND get_d_conf = 1";
                                            $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$get_r_id' AND get_d_conf = 1";
                                            $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                                            $result_get_c3 = mysqli_query($conn, $sql_get_c3);
                                            $row_get_count_track = mysqli_fetch_array($result_get_count_track);
                                            if (mysqli_num_rows($result_get_c3)) {

                                            ?><h1><span class="badge bg-warning">รายการที่ไม่สามารถซ่อมได้ (อยู่ในช่วงยื่นข้อเสนอ)</span></h1><?php
                                                                                                                                            }

                                                                                                                                            while ($row_get = mysqli_fetch_array($result_get)) {
                                                                                                                                                $count_get_no++;
                                                                                                                                                ?>
                                                <div class="row alert alert-warning shadow">
                                                    <h1 style="text-align:start; color:blue" id="body_text">
                                                        <span>รายการที่ <?= $count_get_no ?></span> :
                                                        <span class="f-black-5">
                                                            <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" class="un-scroll f-black-5" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item"><?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?><span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                            </a>
                                                        </span>
                                                    </h1>
                                                    <hr>
                                                    <div style=" color:#2c2f34" class="my-4">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md alert alert-light shadow ml-1 bg-gray-1">
                                                                    <h5 class="f-black-5">ข้อมูลอุปกรณ์</h5>
                                                                    <hr>
                                                                    <p class=" f-gray-5">
                                                                        <?php if ($row_get['com_id'] != NULL) { ?><br>
                                                                            <span class="badge bg-success">
                                                                                ประกัน :
                                                                                <span>
                                                                                    <?php
                                                                                                                                                    $com_id = $row_get['com_id'];
                                                                                                                                                    $sql_com = "SELECT com_name FROM company WHERE com_id ='$com_id'";
                                                                                                                                                    $result_com = mysqli_query($conn, $sql_com);
                                                                                                                                                    $row_com = mysqli_fetch_array($result_com);
                                                                                                                                                    echo $row_com['com_name'];
                                                                                                                                                    $row_get['r_id']
                                                                                    ?>
                                                                                </span>
                                                                            </span>
                                                                        <?php } ?>
                                                                        <?php if ($row_get['r_guarantee'] != NULL) { ?><br>ระยะประกัน :
                                                                            <span class="f-black-5"><?= $row_get['r_guarantee'] ?> ปี</span><?php } ?>
                                                                        <?php if ($row_get['r_id'] != NULL) { ?><br>รหัสอุปกรณ์ในระบบ :
                                                                            <span class="f-black-5"><?= $row_get['r_id'] ?></span>
                                                                            <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item">
                                                                                <i class="fa fa-question-circle"></i>
                                                                                <span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                                            </a>
                                                                        <?php } ?>
                                                                        <?php if ($row_get['r_brand'] != NULL) { ?><br>ยี่ห้อ/แบรนด์ :
                                                                            <span class="f-black-5"><?= $row_get['r_brand'] ?></span><?php } ?>
                                                                        <?php if ($row_get['r_model'] != NULL) { ?><br>รุ่น :
                                                                            <span class="f-black-5"><?= $row_get['r_model'] ?></span><?php } ?>
                                                                        <?php if ($row_get['r_number_model'] != NULL) { ?><br>หมายเลขรุ่น :
                                                                            <span class="f-black-5"><?= $row_get['r_number_model'] ?></span><?php } ?>
                                                                        <?php if ($row_get['r_serial_number'] != NULL) { ?><br>หมายเลขประจำเครื่อง/Serial Number :
                                                                            <span class="f-black-5"><?= $row_get['r_serial_number'] ?></span><?php } ?>
                                                                        <?php if ($row_get['get_t_id'] != NULL) { ?><br>หมายเลขพัสดุ :
                                                                            <span class="f-black-5"><?= $row_get['t_parcel'] ?></span>
                                                                        <?php } ?>
                                                                    </p>
                                                                    <br>
                                                                    <h5 class="mb-3" style="color:black">รายละเอียดอาการ</h5>
                                                                    <hr>
                                                                    <p><?= $row_get['get_d_detail'] ?></p>
                                                                </div>
                                                                <div class="col-md-1"></div>
                                                                <?php
                                                                                                                                                $check_have_pic = 0;
                                                                                                                                                $get_d_id = $row_get['get_d_id'];
                                                                                                                                                $sql_pic = "SELECT * FROM repair_pic
                                        LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                        WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.get_d_id = '$get_d_id' ";
                                                                                                                                                $result_pic = mysqli_query($conn, $sql_pic);
                                                                                                                                                if (mysqli_num_rows($result_pic)) {
                                                                                                                                                    $check_have_pic++;
                                                                ?>
                                                                    <div class="col-md-5 alert alert-light shadow bg-gray-1">
                                                                        <h5 style="color:black" class="mb-3">รูปภาพ</h5>
                                                                        <hr>
                                                                        <br>
                                                                        <?php }
                                                                                                                                                while ($row_pic = mysqli_fetch_array($result_pic)) {
                                                                                                                                                    if ($row_pic[0] != NULL) {
                                                                        ?>
                                                                            <?php
                                                                                                                                                        $rp_pic = $row_pic['rp_pic'];
                                                                                                                                                        $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                                            ?>
                                                                            <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                                                <a href="#" id="bounce-item"><img src="../<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                                            <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                                                <a href="#">
                                                                                    <video width="100px" autoplay muted onclick="openModalVideo(this)" src="../<?= $row_pic['rp_pic'] ?>">
                                                                                        <source src="../<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                                                        <source src="../<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                                                        Your browser does not support the video tag.
                                                                                    </video>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        <?php
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                                if ($check_have_pic > 0) { ?>
                                                                    </div>
                                                                <?php  } ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php
                                            $count_get_no = 0;


                                            $sql_get = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            
                                                            LEFT JOIN company_transport ON  tracking.t_c_id = company_transport.com_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$get_r_id' AND get_detail.del_flg = 1";
                                            $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN company_transport ON  tracking.t_c_id = company_transport.com_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$get_r_id' AND get_detail.del_flg = 1";
                                            $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                                            $result_get = mysqli_query($conn, $sql_get);
                                            $row_get_count_track = mysqli_fetch_array($result_get_count_track);
                                            if (mysqli_num_rows($result_get)) {

                                            ?><h1><span class="badge bg-danger">รายการที่ไม่สามารถซ่อมได้</span></h1><?php
                                                                                                                    }

                                                                                                                    while ($row_get = mysqli_fetch_array($result_get)) {
                                                                                                                        $count_get_no++;
                                                                                                                        ?>
                                                <div class="row alert alert-danger shadow">
                                                    <h1 style="text-align:start; color:blue" id="body_text">
                                                        <span>รายการที่ <?= $count_get_no ?></span> :
                                                        <span class="f-black-5">
                                                            <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" class="un-scroll f-black-5" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item"><?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?><span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                            </a>
                                                        </span>
                                                    </h1>
                                                    <hr>
                                                    <div style=" color:#2c2f34" class="my-4">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md alert alert-light shadow ml-1 bg-gray-1">
                                                                    <h5 class="f-black-5">ข้อมูลอุปกรณ์</h5>
                                                                    <hr>
                                                                    <p class=" f-gray-5">
                                                                        <?php if ($row_get['com_id'] != NULL) { ?><br>
                                                                            <span class="badge bg-success">
                                                                                ประกัน :
                                                                                <span>
                                                                                    <?php
                                                                                                                            $com_id = $row_get['com_id'];
                                                                                                                            $sql_com = "SELECT com_name FROM company WHERE com_id ='$com_id' ";
                                                                                                                            $result_com = mysqli_query($conn, $sql_com);
                                                                                                                            $row_com = mysqli_fetch_array($result_com);
                                                                                                                            echo $row_com['com_name'];
                                                                                                                            $row_get['r_id']
                                                                                    ?>
                                                                                </span>
                                                                            </span>
                                                                        <?php } ?>
                                                                        <?php if ($row_get['r_guarantee'] != NULL) { ?><br>ระยะประกัน :
                                                                            <span class="f-black-5"><?= $row_get['r_guarantee'] ?> ปี</span><?php } ?>
                                                                        <?php if ($row_get['r_id'] != NULL) { ?><br>รหัสอุปกรณ์ในระบบ :
                                                                            <span class="f-black-5"><?= $row_get['r_id'] ?></span>
                                                                            <a href="search_repair.php?id=<?= $row_get['r_id'] ?>" title="คลิกเพื่อดูข้อมูลเพิ่มเติม" id="bounce-item">
                                                                                <i class="fa fa-question-circle"></i>
                                                                                <span class="tooltip">ดูประวัติและรายละเอียดอุปกรณ์</span>
                                                                            </a>
                                                                        <?php } ?>
                                                                        <?php if ($row_get['r_brand'] != NULL) { ?><br>ยี่ห้อ/แบรนด์ :
                                                                            <span class="f-black-5"><?= $row_get['r_brand'] ?></span><?php } ?>
                                                                        <?php if ($row_get['r_model'] != NULL) { ?><br>รุ่น :
                                                                            <span class="f-black-5"><?= $row_get['r_model'] ?></span><?php } ?>
                                                                        <?php if ($row_get['r_number_model'] != NULL) { ?><br>หมายเลขรุ่น :
                                                                            <span class="f-black-5"><?= $row_get['r_number_model'] ?></span><?php } ?>
                                                                        <?php if ($row_get['r_serial_number'] != NULL) { ?><br>หมายเลขประจำเครื่อง/Serial Number :
                                                                            <span class="f-black-5"><?= $row_get['r_serial_number'] ?></span><?php } ?>
                                                                        <?php if ($row_get['get_t_id'] != NULL) { ?><br>หมายเลขพัสดุ :
                                                                            <span class="f-black-5"><?= $row_get['t_parcel'] ?></span>
                                                                        <?php } ?>
                                                                        <?php if ($row_get['com_t_name'] != NULL) { ?><br>จากบริษัท :
                                                                            <span class="f-black-5"><?= $row_get['com_t_name'] ?></span>
                                                                        <?php } ?>
                                                                    </p>
                                                                    <br>
                                                                    <h5 class="mb-3" style="color:black">รายละเอียดอาการ</h5>
                                                                    <hr>
                                                                    <p><?= $row_get['get_d_detail'] ?></p>
                                                                </div>
                                                                <div class="col-md-1"></div>
                                                                <?php
                                                                                                                        $check_have_pic = 0;
                                                                                                                        $get_d_id = $row_get['get_d_id'];
                                                                                                                        $sql_pic = "SELECT * FROM repair_pic
                                        LEFT JOIN get_detail ON repair_pic.get_d_id = get_detail.get_d_id
                                        WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.get_d_id = '$get_d_id' ";
                                                                                                                        $result_pic = mysqli_query($conn, $sql_pic);
                                                                                                                        if (mysqli_num_rows($result_pic)) {
                                                                                                                            $check_have_pic++;
                                                                ?>
                                                                    <div class="col-md-5 alert alert-light shadow bg-gray-1">
                                                                        <h5 style="color:black" class="mb-3">รูปภาพ</h5>
                                                                        <hr>
                                                                        <br>
                                                                        <?php }
                                                                                                                        while ($row_pic = mysqli_fetch_array($result_pic)) {
                                                                                                                            if ($row_pic[0] != NULL) {
                                                                        ?>
                                                                            <?php
                                                                                                                                $rp_pic = $row_pic['rp_pic'];
                                                                                                                                $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                                            ?>
                                                                            <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                                                <a href="#" id="bounce-item"><img src="../<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModalIMG(this)"></a>
                                                                            <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                                                <a href="#">
                                                                                    <video width="100px" autoplay muted onclick="openModalVideo(this)" src="../<?= $row_pic['rp_pic'] ?>">
                                                                                        <source src="../<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                                                        <source src="../<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                                                        Your browser does not support the video tag.
                                                                                    </video>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        <?php
                                                                                                                            }
                                                                                                                        }
                                                                                                                        if ($check_have_pic > 0) { ?>
                                                                    </div>
                                                                <?php  } ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--  Part modal -->
                        <div id="quantitypartModal" class="modal_ed">
                            <!-- <div class="modal-content">
                                <h2>จำนวนอะไหล่ทั้งหมด</h2>
                                <button class="close-button btn btn-primary" onclick="closeModalStatus('quantitypart')" width="200px">
                                    <i class="fa fa-times"></i>
                                </button>
                                <iframe src="mini_part_detail.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px;" class="no-scrollbar"></iframe>
                            </div> -->

                            <div class="modal-content" style="height: 100%">
                                <div class="modal-header">
                                    <h2 class="mx-auto" style="margin-bottom: 0px;">จำนวนอะไหล่ทั้งหมด</h2>
                                    <button type="button" class="btn my-auto" onclick="closeModalStatus('quantitypart')">
                                        <i class="fa fa-times fa-lg"></i></button>
                                </div>
                                <iframe src="mini_part_detail.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px; border:none;" class="no-scrollbar"></iframe>
                            </div>
                        </div>

                        <!--  Status modal -->
                        <div id="quantitystatusModal" class="modal_ed" style="overflow: hidden;">
                            <div class="modal-content" style="height: 100%">
                                <div class="modal-header">
                                    <h1 class="mx-auto" style="margin-bottom: 0px;">สถานะ</h1>
                                    <button type="button" class="btn my-auto" onclick="closeModalStatus('quantitystatus')">
                                        <i class="fa fa-times fa-lg"></i></button>
                                </div>
                                <iframe src="mini_status.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px; border:none;" class="no-scrollbar"></iframe>
                            </div>
                            <!-- <div class="modal-content">
                                <h1>สถานะ</h1>
                                <button class="close-button btn btn-primary" onclick="closeModalStatus('quantitystatus')" width="200px">
                                    <i class="fa fa-times"></i>
                                </button>
                                 content for Status modal
                                <iframe src="mini_status.php?id=<?= $get_r_id ?>" style="width: 100%; height: 1000px;" class="no-scrollbar"></iframe>
                            </div> -->
                        </div>


                        <script>
                            function openModalPart(modalName) {
                                var modal_ed = document.getElementById(modalName + "Modal");
                                modal_ed.style.display = "block";
                                modal_ed.classList.add("show");
                            }

                            function closeModalPart(modalName) {
                                var modal_ed = document.getElementById(modalName + "Modal");
                                modal_ed.style.display = "none";
                                modal_ed.classList.remove("show");
                            }
                            // ////////////////////////////////////////////////////////////

                            function openModalStatus(modalName) {
                                var modal_ed = document.getElementById(modalName + "Modal");
                                modal_ed.style.display = "block";
                                modal_ed.classList.add("show");
                            }

                            function closeModalStatus(modalName) {
                                var modal_ed = document.getElementById(modalName + "Modal");
                                modal_ed.style.display = "none";
                                modal_ed.classList.remove("show");
                            }
                        </script>
                        <!-- <hr> -->
                        <script>
                            // Number of status dots
                            var numStatus = 5;

                            // Get the progress bar container
                            var progressBar = document.getElementById('progress-bar');

                            // Generate status dots dynamically
                            for (var i = 0; i < numStatus; i++) {
                                var dot = document.createElement('div');
                                dot.classList.add('dot');
                                dot.classList.add('info-color');
                                dot.style.left = (i / (numStatus - 1)) * 100 + '%';
                                progressBar.appendChild(dot);
                            }
                        </script>
                        <div class="overlay card-body bg-img-1">
                            <!-- <div class="overlay"> -->
                            <?php
                            if ($row['rs_conf'] == 1 && $row['status_id'] != 8 && $row['status_id'] != 24) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ได้รับการยืนยันการซ่อมแล้ว</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะ "ดำเนินการ" ไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php } else if ($row['rs_conf'] != NULL && $row['rs_conf'] == 0 && $row['status_id'] == 17) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                        <?php
                                        if ($rs_cancel_detail_data != '' || $rs_cancel_detail_data != NULL) { //$rs_cancel_detail_data เช็คว่าไม่มีค่าว่างจากขางบนที่ส่งมา
                                        ?>
                                            <hr>
                                            <p class="f-red-5">เหตุผลไม่ยืนยันการซ่อม : <span class="f-black-5"><u><?= $rs_cancel_detail_data  ?></u></span></p>
                                        <?php
                                        }
                                        ?>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                    <p>
                                    </p>
                                </center>ะเงินแล้ว
                                <br>
                            <?php
                            } else if ($row['rs_conf'] != NULL && $row['rs_conf'] == 0 && $row['status_id'] == 4) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>ะเงินแล้ว
                                <br>
                            <?php
                            } else if (isset($row_s['rs_cancel_detail']) != NULL) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>ะเงินแล้ว
                                <br>
                            <?php
                            } else if ($row['status_id'] == 3) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">เสร็จสิ้นคำสั่งซ่อมนี้แล้ว</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : white">*** การซ่อมดำเนินการเสร็จสิ้นแล้ว ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['status_id'] == 24) {
                            ?>
                                <div class="alert alert-primary" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">รอสมาชิกตอบกลับการซ่อม</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจรอสมาชิกตรวจสอบและตอบกลับมายังพนักงาน ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['status_id'] == 25) {
                            ?>
                                <div class="alert alert-primary" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">สมาชิกต้องทำการชำระเงินเรียบร้อยแล้ว</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] != NULL && $row['rs_conf'] == 4 && $row['status_id'] == 8) {
                            ?>
                                <div class="alert alert-primary" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">สมาชิกต้องการจัดส่งแบบไปรษณีย์ โปรดระบุค่าจัดส่ง</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == 1 && $row['status_id'] == 24) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == 1 && $row['status_id'] == 8) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ได้รับยืนยันการชำระเงินจากสมาชิกแล้ว</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลการยืนยันการชำระเงินและที่อยู่ให้ครบถ้วน ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == NULL && $row['status_id'] == 13) {
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">รอการตอบกลับจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดรอการตอบกลับการยืนยันจากสมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == NULL && $row['status_id'] == 8) {
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">รอการตอบกลับจากสมาชิก</h4>
                                    </center>
                                </div>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == 0 && $row['status_id'] == 13) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['rs_conf'] == 0 && $row['rs_conf'] == 9) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">ไม่ได้รับการยืนยันการซ่อมจากสมาชิก</h4>
                                    </center>
                                </div>
                                <center>
                                    <p style="color : red">*** โปรดตรวจสอบข้อมูลและทำการแจ้งสถานะไปที่สมาชิก ***</p>
                                </center>
                                <br>
                            <?php
                            } else if ($row['status_id'] == 4 || $row['status_id'] == 17 && $row['rs_conf'] == NULL) {
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <center>
                                        <h4 class="py-2" style="margin-bottom: 0px;">รอการตอบกลับจากสมาชิก</h4>
                                    </center>
                                </div>
                                <br>

                            <?php
                            }

                            $jsonobj = $row['get_add'];

                            $obj = json_decode($jsonobj);

                            // echo 'จังหวัด' . $row_p[0];
                            // echo ' อำเภอ' . $row_p[1];
                            // echo ' ตำบล' . $row_p[2];
                            // echo  $obj->zip_code;
                            // echo ' รายละเอียด ' . $obj->description;

                            // $sql_p = "SELECT provinces.name_th, amphures.name_th, districts.name_th
                            $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
                                    FROM provinces
                                    LEFT JOIN amphures ON provinces.id = amphures.province_id
                                    LEFT JOIN districts ON amphures.id = districts.amphure_id
                                    WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
                            $result_p = mysqli_query($conn, $sql_p);
                            $row_p = mysqli_fetch_array($result_p);
                            ?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6  alart alert-light shadow p-4 br-10">
                                        <!-- <button type="button" class="btn btn-outline-primary mb-3" style="display: inline-block;">ข้อมูลการติดต่อ</button> -->
                                        <p style="display: inline;">
                                            <!-- <?php if ($row['get_deli'] == 0) { ?>
                                    <span class="btn btn-info  mb-3 ml-4">#รับที่ร้าน</span>
                                <?php } else { ?>
                                    <span class="btn btn-info mb-3 ml-4">#จัดส่งโดยบริษัทขนส่ง</span>
                                <?php } ?> -->
                                            <?php if ($row_get_count_track['get_t_id'] != NULL) { ?>
                                        <h5>
                                            <span class="f-yellow-5"><i class="fa fa-check"></i> สมาชิกทำการส่งหมายเลขพัสดุ</span><?php  }
                                                                                                                                    ?>
                                        </h5>
                                        </p>
                                        <h5 style="color:black">ข้อมูลติดต่อ <i class="fa fa-address-book ln"></i></h5>
                                        <p>
                                            <?php
                                            $m_id = $row['m_id'];

                                            $sql_m = "SELECT * FROM member WHERE m_id = '$m_id'";
                                            $result_m = mysqli_query($conn, $sql_m);
                                            $row_m = mysqli_fetch_array($result_m);
                                            if ($row_m['m_fname'] != NULL && $row_m['m_lname'] != NULL) {
                                            ?>
                                                ชื่อ : <span><?= $row_m['m_fname'] . ' ' . $row_m['m_lname'] ?></span>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php
                                            if ($row['get_tel'] != NULL) {
                                            ?>
                                                เบอร์โทรติดต่อ :
                                                <span style="color: black">
                                                    <span id="PhoneNumber"><?= $row['get_tel'] ?>
                                                        <a href="#" id="copyPhoneNumber"><i class='fas fa-copy'>

                                                            </i>
                                                        </a>
                                                    </span>
                                                    <span class="tooltip">กดเพื่อคัดลอก</span>
                                                </span>
                                                <span id="copyConfirmationPhone" style="display: none; color: green;">คัดลอกแล้ว</span></span>
                                                <script>
                                                    document.getElementById("copyPhoneNumber").addEventListener("click", function() {
                                                        // Get the serial number text
                                                        const serialNumber = document.getElementById("PhoneNumber").textContent;

                                                        // Create a textarea element to temporarily hold the text
                                                        const tempTextarea = document.createElement("textarea");
                                                        tempTextarea.value = serialNumber;
                                                        document.body.appendChild(tempTextarea);

                                                        // Select the text in the textarea and copy it to the clipboard
                                                        tempTextarea.select();
                                                        document.execCommand("copy");

                                                        // Remove the temporary textarea
                                                        document.body.removeChild(tempTextarea);

                                                        // Display the copy confirmation message
                                                        const copyConfirmation = document.getElementById("copyConfirmationPhone");
                                                        copyConfirmation.style.display = "inline";

                                                        // Hide the confirmation message after a few seconds
                                                        setTimeout(function() {
                                                            copyConfirmation.style.display = "none";
                                                        }, 3000); // Display for 3 seconds
                                                    });
                                                </script>
                                                <?php
                                                if ($row_m['m_email'] != NULL) {
                                                ?>
                                                    <br>
                                                    <!-- อีเมล :
                                                    <span style="color: black" id="EmailMember"><?= $row_m['m_email'] ?>
                                                        <a href="#" id="copyEmail" title="กดเพื่อคัดลอก"><i class='fas fa-copy'></i>
                                                            <span class="tooltip">กดเพื่อคัดลอก</span></a>

                                                    </span>
                                                    <span id="copyEmailnofi" style="display: none; color: green;">คัดลอกแล้ว</span></span> -->
                                                    อีเมล :
                                                    <span style="color: black">
                                                        <span id="EmailMember"><?= $row['m_email'] ?>
                                                            <a href="#" id="copyEmail"><i class='fas fa-copy'>

                                                                </i>
                                                            </a>
                                                        </span>
                                                        <span class="tooltip">กดเพื่อคัดลอก</span>
                                                    </span>
                                                    <span id="copyEmailnofi" style="display: none; color: green;">คัดลอกแล้ว</span></span>

                                                    <?php if ($row['get_deli'] == 0) { ?>
                                                        <br> รูปแบบการจัดส่งกลับ : <span class="f-green-5">รับที่ร้าน</span>
                                                    <?php } else { ?>
                                                        <br> รูปแบบการจัดส่งกลับ :<span class="f-green-5">จัดส่งโดยบริษัทขนส่ง</span>
                                                    <?php } ?>
                                                    <script>
                                                        document.getElementById("copyEmail").addEventListener("click", function() {
                                                            // Get the serial number text
                                                            const serialNumber = document.getElementById("EmailMember").textContent;

                                                            // Create a textarea element to temporarily hold the text
                                                            const tempTextarea = document.createElement("textarea");
                                                            tempTextarea.value = serialNumber;
                                                            document.body.appendChild(tempTextarea);

                                                            // Select the text in the textarea and copy it to the clipboard
                                                            tempTextarea.select();
                                                            document.execCommand("copy");

                                                            // Remove the temporary textarea
                                                            document.body.removeChild(tempTextarea);

                                                            // Display the copy confirmation message
                                                            const copyConfirmation = document.getElementById("copyEmailnofi");
                                                            copyConfirmation.style.display = "inline";

                                                            // Hide the confirmation message after a few seconds
                                                            setTimeout(function() {
                                                                copyConfirmation.style.display = "none";
                                                            }, 3000); // Display for 3 seconds
                                                        });
                                                    </script>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($row_m['m_add'] != NULL) {
                                                ?>

                                                    <center>
                                                        <hr style="width:95%">
                                                    </center>
                                                    <br>
                                        <h5 style="color:black">ที่อยู่ <i class="fa fa-map"></i> (บิลใบเสร็จและใช้จัดส่ง)</h5>
                                        <div class="row">
                                            <p>
                                                <?php

                                                    $jsonobj = $row_m['m_add'];

                                                    $obj = json_decode($jsonobj);

                                                    $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
                                                            FROM provinces
                                                            LEFT JOIN amphures ON provinces.id = amphures.province_id
                                                            LEFT JOIN districts ON amphures.id = districts.amphure_id
                                                            WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
                                                    $result_p = mysqli_query($conn, $sql_p);
                                                    $row_p = mysqli_fetch_array($result_p);
                                                ?>
                                                <?= $obj->description ?>
                                                ตำบล<?= $row_p[2] ?> อำเภอ<?= $row_p[1] ?> จังหวัด<?= $row_p[0] ?>
                                            <?php
                                                }
                                            ?>
                                            </p>
                                        </div>
                                    <?php
                                            }
                                    ?></p>
                                    </div>
                                    <div class="col-md-1"></div>

                                    <div class="col-md-4 alart alert-light shadow p-4 br-10">

                                        <?php
                                        // $get_r_id = $row['get_r_id'];
                                        $status_id = $row['status_id'];
                                        // $get_r_id = $_GET['id'];

                                        $sql_s = "SELECT * FROM repair_status 
                                                WHERE del_flg = '0' AND get_r_id = '$get_r_id'
                                                ORDER BY rs_date_time DESC LIMIT 1";
                                        $result_s = mysqli_query($conn, $sql_s);
                                        $row_s = mysqli_fetch_array($result_s);
                                        $rs_id = $row_s['rs_id'];
                                        ?>
                                        <div class="mb-3">


                                            <h5 class="ln ">สถานะล่าสุด : <h5 id="bounce-item" onclick="openModalStatus('quantitystatus')" style=" color : <?= $row['status_color'] ?>;" class="ln "> <?= $row['status_name'] ?>
                                                    <?php
                                                    if ($row['status_id'] == 6) {
                                                        $get_r_id = $row['get_r_id'];
                                                        $carry_out_id = $row['status_id'];
                                                        $sql_cary_out = "SELECT COUNT(get_r_id) FROM `repair_status` WHERE get_r_id = '$get_r_id' AND status_id = 6 ORDER BY rs_date_time DESC;";
                                                        $result_carry_out = mysqli_query($conn, $sql_cary_out);
                                                        $row_carry_out = mysqli_fetch_array($result_carry_out);

                                                        if ($row_carry_out[0] > 1) {
                                                    ?>
                                                            #ครั้งที่ <?= $row_carry_out[0] ?>

                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    <span class="tooltip">ดูรายละเอียดสถานะทั้งหมด</span>
                                                </h5>
                                            </h5>
                                            <?php if ($row['status_id'] == 3 || $row['status_id'] == 8 || $row['status_id'] == 9 || $row['status_id'] == 10 || $row['status_id'] == 24) : ?>
                                                <a class="btn btn-primary float-end" target="_blank" href="bill_repair.php?id=<?= $row['get_r_id'] ?>">ใบแจ้งซ่อม</a>
                                            <?php endif; ?>
                                            <hr>
                                            <h4 class="mb-3 f-black-5">รายละเอียด</h4>
                                            <!-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?= $row_s['rs_detail']  ?></textarea> -->
                                            <p class="col-form-label" style="color: gray"><?= $row_s['rs_detail']  ?></p>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <?php
                                $sql_pic3 = "SELECT * FROM repair_pic WHERE rs_id = '$rs_id' AND del_flg = 0 ";
                                $result_pic3 = mysqli_query($conn, $sql_pic3);

                                if (mysqli_num_rows($result_pic3)) {
                                    $roe_c =  mysqli_fetch_array($result_pic3);
                                ?>
                                    <div class="row">
                                        <div class="col-md alert alert-light shadow br-10">
                                            <div class="mb-3">
                                                <?php
                                                if (isset($roe_c[0]) == NULL) {
                                                ?>
                                                    <hr>

                                                    <h5 style="display:none">รูปภาพประกอบ:</h5>
                                                <?php
                                                } else {
                                                ?>
                                                    <h5>รูปภาพประกอบ </h5>
                                                <?php
                                                }
                                                ?>
                                                <!-- <label for="exampleFormControlTextarea1" class="col-form-label">รูปภาพประกอบ <?= $get_r_id ?>:</label> -->
                                                <div class="row">
                                                    <div class="container">
                                                        <div class="row">
                                                            <?php


                                                            $sql_pic = "SELECT * FROM repair_pic WHERE rs_id = '$rs_id' ";
                                                            $result_pic = mysqli_query($conn, $sql_pic);


                                                            // $sql_pic = "SELECT * FROM `repair_pic` WHERE get_r_id = '$get_r_id'";
                                                            // $result_pic = mysqli_query($conn, $sql_pic);
                                                            while ($row_pic = mysqli_fetch_array($result_pic)) {

                                                                if ($row_pic[0] != NULL) { ?>
                                                                    <div class="col-md-2 ">
                                                                        <?php
                                                                        $rp_pic = $row_pic['rp_pic'];
                                                                        $file_extension = pathinfo($rp_pic, PATHINFO_EXTENSION);
                                                                        ?> <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                                                            <a id="bounce-item" href="#" style="margin-left: 20px;"><img src="../<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal shadow" alt="" onclick="openModalIMG(this)"><span class="tooltip">คลิกเพื่อดู</span></a>
                                                                        <?php elseif (in_array($file_extension, ['mp4', 'ogg'])) : ?>
                                                                            <a id="bounce-item" href="#" style="margin-left: 20px;" class="shadow">
                                                                                <video width="100px" autoplay muted onclick="openModalVideo(this)" src="../<?= $row_pic['rp_pic'] ?>">
                                                                                    <source src="../<?= $row_pic['rp_pic'] ?>" type="video/mp4">
                                                                                    <source src="../<?= $row_pic['rp_pic'] ?>" type="video/ogg">
                                                                                    Your browser does not support the video tag.
                                                                                </video>
                                                                                <span class="tooltip">คลิกเพื่อดู</span>
                                                                            </a>
                                                                        <?php endif; ?>
                                                                    </div>

                                                                    <!-- <h2><?= $row_pic['rp_pic'] ?></h2> -->
                                                                <?php
                                                                } else { ?> <h2>ไม่มีข้อมูล</h2> <?php
                                                                                                }
                                                                                            } ?>
                                                        </div>
                                                    </div>


                                                    <script src="script.js"></script>
                                                    <script>
                                                        function openModalIMG(img) {
                                                            var modal_ed = document.getElementById("modalimg");
                                                            var modalImg = document.getElementById("modal-image");
                                                            modal_ed.style.display = "block";
                                                            modalImg.src = img.src;
                                                            modalImg.style.width = "60%"; // Set the width to 1000 pixels
                                                            modalImg.style.borderRadius = "2%"; // Set the border radius to 20%
                                                            modal_ed.classList.add("show");
                                                        }

                                                        function closeModalIMG() {
                                                            var modal_ed = document.getElementById("modalimg");
                                                            modal_ed.style.display = "none";
                                                        }
                                                    </script>
                                                    <script>
                                                        function openModalVideo(element) {
                                                            var modal_ed = document.getElementById('modal_ed');
                                                            var modalVideo = document.getElementById('modal-video');
                                                            modal_ed.style.display = 'block';
                                                            modalVideo.src = element.src;
                                                            modalVideo.style.height = '90%';
                                                            modalVideo.style.borderRadius = '2%';
                                                            modal_ed.classList.add('show');
                                                        }

                                                        function closeModal() {
                                                            var modal_ed = document.getElementById('modal_ed');
                                                            var modalVideo = document.getElementById('modal-video');
                                                            modalVideo.pause();
                                                            modalVideo.currentTime = 0;
                                                            modalVideo.src = ""; // Reset the video source
                                                            modal_ed.style.display = 'none';
                                                        }

                                                        window.addEventListener('click', function(event) {
                                                            var modal_ed = document.getElementById('modal_ed');
                                                            if (event.target === modal_ed) {
                                                                closeModal();
                                                            }
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="row">
                                    <br>
                                    <br>
                                </div>
                            </div>

                            <div style="display: none;">
                                <h4>ข้อมูลสมาชิก</h4>
                                <div class="row">
                                    <p class="col-form-label" style="color: #2c2f34">ชื่อ : <?= $row['m_fname']  . ' ' . $row['m_lname']  ?>
                                        <br>อีเมล์ : <?= $row['m_email']  ?>
                                        <br> เบอร์โทรศัพท์ : <?= $row['get_tel']  ?>
                                        <?php if ($row['get_deli'] == 0) { ?>
                                            <br> รูปแบบการจัดส่งกลับ : <span class="f-green-5">รับที่ร้าน</span>
                                        <?php } else { ?>
                                            <br> รูปแบบการจัดส่งกลับ :<span class="f-green-5">จัดส่งโดยบริษัทขนส่ง</span>
                                        <?php } ?>
                                    </p>
                                </div>
                                <hr>

                                <div class="">
                                    <label for=" exampleFormControlTextarea1" class="btn btn-outline-primary">ที่อยู่</label>
                                    <?php if ($row['get_add'] != NULL) {
                                    ?>
                                        <div class="row">
                                            <label for="exampleFormControlTextarea1" class="col-sm-1 col-form-label">จังหวัด :</label>
                                            <div class="col">
                                                <!-- <input type="text" class="form-control" value="<?= $row_p[0] ?>" readonly> -->
                                                <p class="col-form-label" style="color: #2c2f34"><?= $row_p[0] ?></p>
                                            </div>
                                            <label for="exampleFormControlTextarea1" class="col-sm-1 col-form-label">อำเภอ :</label>
                                            <div class="col">
                                                <!-- <input type="text" class="form-control" value="<?= $row_p[1] ?>" readonly> -->
                                                <p class="col-form-label" style="color: #2c2f34"><?= $row_p[1] ?></p>
                                            </div>
                                            <label for="exampleFormControlTextarea1" class="col-sm-1 col-form-label">ตำบล :</label>
                                            <div class="col">
                                                <!-- <input type="text" class="form-control" value="<?= $row_p[2] ?>" readonly> -->
                                                <p class="col-form-label" style="color: #2c2f34"><?= $row_p[2] ?></p>
                                            </div>
                                            <label for="exampleFormControlTextarea1" class="col-sm-1 col-form-label">รหัสไปรษณีย์ :</label>
                                            <div class="col">
                                                <!-- <input type="text" class="form-control" value="<?= $row_p[2] ?>" readonly> -->
                                                <p class="col-form-label" style="color: #2c2f34"><?= $row_p[3] ?></p>
                                            </div>
                                        </div>
                                        <!-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?php
                                                                                                                                            if ($row['get_add'] == NULL) {
                                                                                                                                                echo "ไม่มีข้อมูล";
                                                                                                                                            } else {

                                                                                                                                                echo $obj->description;
                                                                                                                                            }
                                                                                                                                            ?>
                                </textarea> -->
                                        <div class="row">
                                            <label for="exampleFormControlTextarea1" class="col-1 col-form-label">รายละเอียด :</label>
                                            <div class="col">
                                                <p class="col-form-label" style="color: #2c2f34"><?php
                                                                                                    if ($row['get_add'] == NULL) {
                                                                                                        echo "ไม่มีข้อมูล";
                                                                                                    } else {

                                                                                                        echo $obj->description;
                                                                                                    }
                                                                                                    ?></p>
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
                                        </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <br>
                <center>
                    <!-- /.container-fluid -->
                    <!-- <button type="button" id="bounce-item" class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#statusOrRepairModal">
                                        ดำเนินการสถานะถัดไป
                                        <span class="tooltip">อัพเดตสถานะ</span>
                                    </button> -->
                </center>
                <br><br>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            include('bar/admin_footer.php')
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Sweet Alert Show Start -->
    <?php
    if (isset($_SESSION['add_data_alert'])) {
        if ($_SESSION['add_data_alert'] == 0) {
            $id = 123; // Replace 123 with the actual ID you want to pass to the deletion action
    ?>
            <script>
                Swal.fire({
                    title: 'ข้อมูลของคุณได้ถูกบันทึกแล้ว',
                    text: 'กด Accept เพื่อออก',
                    icon: 'success',
                    confirmButtonText: 'Accept'
                });
            </script>
        <?php
            unset($_SESSION['add_data_alert']);
        } else if ($_SESSION['add_data_alert'] == 1) {
        ?>
            <script>
                Swal.fire({
                    title: 'ข้อมูลของคุณไม่ได้ถูกบันทึก',
                    text: 'กด Accept เพื่อออก',
                    icon: 'error',
                    confirmButtonText: 'Accept'
                });
            </script>

        <?php
            unset($_SESSION['add_data_alert']);
        } else if ($_SESSION['add_data_alert'] == 2) {
        ?>
            <script>
                Swal.fire({
                    title: 'ข้อมูลของคุณได้ถูกลบแล้ว',
                    text: 'กด Accept เพื่อออก',
                    icon: 'success',
                    confirmButtonText: 'Accept'
                });
            </script>
    <?php unset($_SESSION['add_data_alert']);
        }
    }
    ?>
    <!-- Sweet Alert Show End -->

    <script>
        const input = document.querySelector('#upload');
        const container = document.querySelector('#image-container');

        input.addEventListener('change', () => {
            const files = input.files;
            if (files) {
                for (let i = 0; i < files.length; i++) {
                    const url = URL.createObjectURL(files[i]);
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('image-container');

                    const image = document.createElement('img');
                    image.classList.add('preview-image');
                    image.setAttribute('src', url);

                    const deleteBtn = document.createElement('button');
                    deleteBtn.classList.add('delete-button');
                    deleteBtn.innerHTML = '&times;';

                    deleteBtn.addEventListener('click', () => {
                        imageContainer.remove();
                    });

                    imageContainer.appendChild(image);
                    imageContainer.appendChild(deleteBtn);
                    container.appendChild(imageContainer);
                }
            }
        });
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
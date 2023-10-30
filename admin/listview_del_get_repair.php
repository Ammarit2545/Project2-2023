<?php
session_start();
include('../database/condb.php');

if (!isset($_SESSION['role_id'])) {
    header('Location:../home.php');
}

// ใส่สถานะที่ต้องการตอบกลับ ตรงนี้
$excludedStatusIDs = [];

$excludedStatusIDs = ($_SESSION['role_id'] == 1) ? [1, 25, 20] : [];
$excludedStatusIDs = ($_SESSION['role_id'] == 2) ? [1] : [];
$excludedStatusIDs = ($_SESSION['role_id'] == 3) ? [25] : [];

// role_id = 2  ------ 1, 2, 4, 5, 6, 10, 11, 12, 13, 14, 15, 17, 18, 19, 24
// role_id = 3  ------ 3, 8, 9, 25, 26

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <title>การส่งซ่อม</title> -->
    <title>Admin - Repair Information</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        .font-more-one-style {
            font-size: 90%;
            color: blue;
        }

        .font-one-style {
            font-size: 90%;
        }
    </style>

</head>

<body id="page-top">

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
                    <br>
                    <!-- Page Heading -->

                    <h1 class="mb-2 " style="color : black">ใบแจ้งซ่อม/เคลม สถานะต่างๆที่ลบ </h1>
                    <br>
                    <h4>
                        <?php if (isset($_GET['status_select'])) {
                            $sql_count = 0;
                            $status_select = $_GET['status_select'];

                            $sql_status_get1 = "SELECT repair_status.get_r_id FROM repair_status
                                            WHERE repair_status.status_id = '$status_select'
                                            AND repair_status.del_flg = '0'";
                            $result_status_get1 = mysqli_query($conn, $sql_status_get1);

                            if ($result_status_get1) {
                                while ($row_status_get1 = mysqli_fetch_array($result_status_get1)) {
                                    $get_r_id = $row_status_get1['get_r_id'];

                                    $sql_count_status = "SELECT repair_status.status_id, repair_status.get_r_id FROM get_repair 
                                                        LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                                                        LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
                                                        WHERE get_repair.get_r_id = '$get_r_id' 
                                                        AND repair_status.del_flg = '0'
                                                        AND get_repair.del_flg = '0' 
                                                        AND get_detail.del_flg = '0' 
                                                        ORDER BY repair_status.rs_id DESC LIMIT 1";

                                    $result_count_status = mysqli_query($conn, $sql_count_status);

                                    if (mysqli_num_rows($result_count_status)) {
                                        $row_count_status = mysqli_fetch_array($result_count_status);
                                        if ($row_count_status['status_id'] == $status_select) {
                                            $sql_count += 1;
                                        }
                                    }
                                }
                            }

                            $sql_sel = "SELECT * FROM status_type WHERE status_id = '$status_select'";
                            $result_sel = mysqli_query($conn, $sql_sel);
                            $row_sel = mysqli_fetch_array($result_sel);
                            if ($_GET['status_select'] != 0) {  ?>
                                <span style="display: inline;">ประเภท : <span style="display: inline;color : <?= $row_sel['status_color'] ?>"><?= $row_sel['status_name'] ?> </span><u>
                                        <h5 style="display: inline;color:black">(<?= $sql_count . ' รายการ' ?>)</h5>
                                    </u></span>
                            <?php
                            } else {
                            ?>
                                <span>ประเภท : การแจ้งเตือนทั้งหมด</span>
                        <?php
                            }
                        } ?>
                        <?php if (!isset($_GET['status_select'])) {   ?>
                            <span>สถานะต่างๆที่ลบ</span>
                        <?php  } ?>
                    </h4>
                    <br>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

                    <br>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">การส่งซ่อม</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <!-- <th>ลำดับ</th> -->
                                            <th data-order="desc">
                                                <center>
                                                    หมายเลขซ่อม
                                                </center>
                                            </th>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#dataTable').DataTable();
                                                });
                                            </script>
                                            <th>สถานะ</th>
                                            <th>ประเภท</th>
                                            <!-- <th>ยี่ห้อ</th>
                                            <th>รุ่น</th> -->
                                            <!-- <th>ครั้งที่</th> -->
                                            <th>เลข serail</th>
                                            <!-- <th>ชื่อ</th> -->
                                            <th>จำนวน</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count_del = 0;
                                        $status_select = 0;

                                        $sql_nofi = "SELECT get_repair.get_r_id, MAX(get_detail.get_d_id) AS get_d_id, MAX(repair.r_id) AS r_id, MAX(status_type.status_id) AS status_id, MAX(get_repair.get_deli) AS get_deli
                                                            FROM get_repair
                                                            LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id
                                                            LEFT JOIN repair ON get_detail.r_id = repair.r_id   
                                                            LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
                                                            LEFT JOIN status_type ON repair_status.status_id = status_type.status_id
                                                            WHERE get_repair.del_flg = '1' 
                                                            GROUP BY get_repair.get_r_id
                                                            ORDER BY get_repair.get_r_id DESC;";

                                        $result_nofi = mysqli_query($conn, $sql_nofi);
                                        $num_rows = mysqli_fetch_array($result_nofi_count);
                                        $i = 0;
                                        while ($row = mysqli_fetch_array($result_nofi)) {
                                            $count_del ++;
                                            $get_r_id = $row['get_r_id'];

                                       
                                            $sql_date = "SELECT get_r_date_in FROM get_repair WHERE get_r_id = '$get_r_id' ";
                                            $result_date = mysqli_query($conn, $sql_date);
                                            $row_date = mysqli_fetch_array($result_date);


                                            if (isset($row_date['get_r_date_in']) && $row_date['get_r_date_in'] !== null) {
                                                $dateString = date('d-m-Y', strtotime($row_date['get_r_date_in']));
                                                // Rest of the code that uses $dateString
                                                $date = DateTime::createFromFormat('d-m-Y', $dateString);
                                                // Additional code using $date
                                            }
                                            $formattedDate = $date->format('d / F / Y');
                                            $i = $i + 1;
                                            $get_r_id = $row['get_r_id'];
                                            $sql_c = "SELECT * FROM repair_status
                                                    LEFT JOIN status_type ON repair_status.status_id = status_type.status_id
                                                    WHERE repair_status.del_flg = '0' AND repair_status.get_r_id = '$get_r_id'
                                                    ORDER BY repair_status.rs_date_time DESC LIMIT 1";
                                            $result_c = mysqli_query($conn, $sql_c);
                                            $row_c = mysqli_fetch_array($result_c);


                                            $sql_get_count = "SELECT COUNT(get_r_id) FROM get_detail 
                                                    WHERE get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                                            $result_get_count = mysqli_query($conn, $sql_get_count);
                                            $row_get_count = mysqli_fetch_array($result_get_count);
                                            $row_repair;

                                            if ($row_get_count[0] == 1) {
                                                // เก็บค่า $r_id จาก
                                                $r_id = $row['r_id'];

                                                // หากมีแค่ 1 ชิ้น
                                                $sql_repair = "SELECT r_brand,r_model,r_number_model,r_serial_number FROM repair 
                                                                WHERE r_id = '$r_id' AND repair.del_flg = 0";
                                                $result_repair = mysqli_query($conn, $sql_repair);
                                                $row_repair = mysqli_fetch_array($result_repair);
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $count_del ?></td>
                                                <td>
                                                    <!-- หมายเลขซ่อม -->
                                                    <?php
                                                    if ($row['get_r_id'] != NULL) {
                                                    ?><center>
                                                            <h5 style="color:black"><a href="detail_del_repair.php?id=<?= $row['get_r_id'] ?>"> <?= $row['get_r_id'] ?></a> </h5>
                                                        </center><?php
                                                                } else {
                                                                    echo "-";
                                                                } ?>
                                                </td>
                                                <!-- สถานะล่าสุด -->
                                                <td>
                                                    <center>
                                                        <u style="color: <?= $row_c['status_color'] ?>;">
                                                            <h5 style="color: <?= $row_c['status_color'] ?>; margin-top:2%"><?= $row_c['status_name'] ?></h5>
                                                        </u>
                                                    </center>
                                                </td>

                                                <td>
                                                    <!-- วิธีการรับ/ส่งอุปกรณ์ -->
                                                    <?php
                                                    if ($row['get_deli'] != NULL) {
                                                        if ($row['get_deli'] == 0) {
                                                            // echo "รับที่ร้าน";
                                                    ?>
                                                            <p style="color:black">รับที่ร้าน</p>
                                                        <?php
                                                        } else {
                                                            // echo "จัดส่งไปรษณีย์";
                                                        ?>
                                                            <p style="color:green">จัดส่งไปรษณีย์</p>
                                                    <?php
                                                        }
                                                        // echo $row['get_deli'];
                                                    } else {
                                                        echo "-";
                                                    } ?>
                                                </td>
                                                <!-- <td>
                                                    <?php
                                                    // ชื่อยี่ห้อ
                                                    if ($row_get_count[0] > 1) {
                                                    ?>
                                                        <p class="font-more-one-style">มากกว่า 1 ชิ้น</p>
                                                    <?php
                                                    } elseif (isset($row['r_brand']) || $row_repair['r_brand'] != NULL) {
                                                    ?>
                                                        <p class="font-one-style"><?= $row_repair['r_brand'] ?></p>
                                                    <?php
                                                    } else {
                                                        echo "-";
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // ชื่อโมเดล
                                                    if ($row_get_count[0] > 1) {
                                                    ?>
                                                        <p class="font-more-one-style">มากกว่า 1 ชิ้น</p>
                                                    <?php
                                                    } elseif (isset($row['r_model']) || $row_repair['r_model'] != NULL) {
                                                    ?>
                                                        <p class="font-one-style"><?= $row_repair['r_model'] ?></p>
                                                    <?php
                                                    } else {
                                                        echo "-";
                                                    } ?>
                                                </td> -->
                                                <!-- <td>
                                                    <?php
                                                    // ซ่อมครั้งที่เท่าไหร่
                                                    if ($row_get_count[0] > 1) {
                                                    ?>
                                                        <p class="font-more-one-style">มากกว่า 1 ชิ้น</p>
                                                    <?php
                                                    } elseif ($row['get_d_record'] != NULL  || $row_repair['r_model'] != NULL) {
                                                        $get_r_id_round = $row['get_r_id'];
                                                        $sql_round = "SELECT get_d_record FROM get_detail 
                                                                    WHERE r_id = '$r_id' AND get_r_id = '$get_r_id_round' AND del_flg = 0";
                                                        $result_round = mysqli_query($conn, $sql_round);
                                                        $row_round = mysqli_fetch_array($result_round);
                                                    ?>
                                                        <p class="font-one-style"><?= $row_round['get_d_record'] ?></p>
                                                    <?php
                                                    } else {
                                                        echo "-";
                                                    } ?>
                                                </td> -->
                                                <td>
                                                    <!-- หมายเลขประจำเครื่อง SN -->
                                                    <?php
                                                    if ($row_get_count[0] > 1) {
                                                    ?>
                                                        <p class="font-more-one-style">มากกว่า 1 ชิ้น</p>
                                                    <?php
                                                    } elseif (isset($row['r_serial_number']) || $row_repair['r_serial_number'] != NULL) {
                                                    ?>
                                                        <p class="font-one-style">
                                                            <span style="color:black">
                                                                <?= $row_repair['r_brand'] ?>
                                                                <?= $row_repair['r_model'] ?>
                                                            </span>

                                                            <?= ', S/N ' ?><span style="color:blue"><u><?= $row_repair['r_serial_number'] ?></u>
                                                            </span>
                                                        </p>
                                                    <?php
                                                    } else {
                                                        echo "-";
                                                    } ?>
                                                </td>
                                                <td>
                                                    <!-- จำนวนของอุปกรณ์ที่นำมาซ๋อม -->
                                                    <?php
                                                    if ($row_get_count[0] > 1) {
                                                    ?>
                                                        <p class="font-more-one-style"><?php echo $row_get_count[0]; ?></p>
                                                    <?php
                                                    } elseif ($row_get_count[0] == 1) {
                                                    ?>
                                                        <p class="font-one-style"><?= $row_get_count[0] ?></p>
                                                    <?php
                                                    } else {
                                                        echo "-";
                                                    } ?>
                                                </td>
                                                <td>
                                                    <!-- วันที่รับซ่อม -->
                                                    <?php
                                                    if ($formattedDate != NULL) {
                                                    ?>
                                                        <p class="font-one-style"><?= $formattedDate ?></p>
                                                    <?php
                                                    } else {
                                                        echo "-";
                                                    } ?>
                                                </td>

                                               
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            include('bar/admin_footer.php');
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
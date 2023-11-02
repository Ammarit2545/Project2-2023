<?php
        session_start();
        include('../database/condb.php');

        if (!isset($_SESSION['role_id'])) {
            header('Location:../home.php');
        }

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">

            <title>ข้อมูลสมาชิก - ANE Electronic</title>
            <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

            <!-- Custom fonts for this template -->
            <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

            <!-- Custom styles for this template -->
            <link href="css/sb-admin-2.min.css" rel="stylesheet">

            <!-- Custom styles for this page -->
            <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

            <style>
                .font-style {
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

                            <!-- Page Heading -->
                            <h1 class="h3 mb-2 text-gray-800">ข้อมูลสมาชิกที่ถูกลบ</h1>

                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิก</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ชื่อ-นามสกุล</th>
                                                    <th>Email</th>
                                                    <th>ที่อยู่</th>
                                                    <th>เบอร์โทรศัพท์</th>
                                                    <th>Start date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM member WHERE del_flg = '1' ORDER BY m_id DESC";
                                                $result = mysqli_query($conn, $sql);
                                                $i = 0;
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $i = $i + 1;
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php if ($row['m_email'] != NULL) { ?>
                                                                <p class="font-style"><?= $i ?></p>
                                                            <?php  } else { ?>
                                                                <p class="font-style">ไม่มีข้อมูล</p>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($row['m_fname'] != NULL && $row['m_lname'] != NULL) { ?>
                                                                <p class="font-style"> <?= $row['m_fname'] . " " . $row['m_lname']  ?></p>
                                                            <?php  } else { ?>
                                                                <p class="font-style">ไม่มีข้อมูล</p>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($row['m_email'] != NULL) { ?>
                                                                <p class="font-style"><?= $row['m_email'] ?></p>
                                                            <?php  } else { ?>
                                                                <p class="font-style">ไม่มีข้อมูล</p>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($row['m_add'] != NULL) {
                                                                $jsonobj = $row['m_add'];
                                                                if ($jsonobj) {
                                                                    $obj = json_decode($jsonobj);

                                                                    if ($obj !== null && property_exists($obj, 'province') && property_exists($obj, 'district') && property_exists($obj, 'sub_district')) {
                                                                        $sql_p = "SELECT provinces.name_th, amphures.name_th, districts.name_th
                                                                            FROM provinces
                                                                            LEFT JOIN amphures ON provinces.id = amphures.province_id
                                                                            LEFT JOIN districts ON amphures.id = districts.amphure_id
                                                                            WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
                                                                        $result_p = mysqli_query($conn, $sql_p);
                                                                        $row_p = mysqli_fetch_array($result_p);
                                                                    }
                                                                }
                                                            ?><p class="font-style"><?= 'จ.' . $row_p[0] . ' ,อ.' . $row_p[1] . ' ,ต.' . $row_p[2]; ?></p>
                                                            <?php  } else { ?>
                                                                <p class="font-style">ไม่มีข้อมูล</p>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($row['m_tel'] != NULL) { ?>
                                                                <p class="font-style"><?= $row['m_tel'] ?></p>
                                                            <?php  } else { ?>
                                                                <p class="font-style">ไม่มีข้อมูล</p>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($row['m_date_in'] != NULL) { ?>
                                                                <p class="font-style"><?= $row['m_date_in'] ?></p>
                                                            <?php  } else { ?>
                                                                <p class="font-style">ไม่มีข้อมูล</p>
                                                            <?php } ?>
                                                        </td>
                                                    
                                                    </tr>
                                                <?php
                                                }
                                                ?>

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
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; Your Website 2020</span>
                            </div>
                        </div>
                    </footer>
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
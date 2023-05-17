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
                    <h1 class="h3 mb-2 text-gray-800">การส่งซ่อม</h1>
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
                                            <th>เลขที่ซ่อม</th>
                                            <th>ยี่ห้อ</th>
                                            <th>รุ่น</th>
                                            <th>ครั้งที่</th>
                                            <th>เลข serail</th>
                                            <!-- <th>ชื่อ</th> -->
                                            <th>รายละเอียด</th>
                                            <th>Date</th>
                                            <th>สถานะ</th>
                                            <th>ปุ่ม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql_nofi = "SELECT *
                                        FROM get_repair
                                        LEFT JOIN repair ON get_repair.r_id = repair.r_id
                                        LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
                                        LEFT JOIN status_type ON repair_status.status_id = status_type.status_id
                                        WHERE get_repair.del_flg = '0'
                                        ORDER BY get_repair.get_r_id DESC;
                                         ";
                                        $result_nofi = mysqli_query($conn, $sql_nofi);
                                        $num_rows = mysqli_fetch_array($result_nofi_count);
                                        $i = 0;
                                        while ($row = mysqli_fetch_array($result_nofi)) {
                                            $dateString = date('d-m-Y', strtotime($row['get_r_date_in']));
                                            $date = DateTime::createFromFormat('d-m-Y', $dateString);
                                            $formattedDate = $date->format('F / d / Y');
                                            $i = $i + 1;
                                        ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?php
                                                    if ($row['get_r_id'] != NULL) {
                                                        echo $row['get_r_id'];
                                                    } else {
                                                        echo "ไม่มีข้อมูล";
                                                    } ?>
                                                </td>
                                                <td><?php
                                                    if ($row['r_brand'] != NULL) {
                                                        echo $row['r_brand'];
                                                    } else {
                                                        echo "ไม่มีข้อมูล";
                                                    } ?>
                                                </td>
                                                <td><?php
                                                    if ($row['r_model'] != NULL) {
                                                        echo $row['r_model'];
                                                    } else {
                                                        echo "ไม่มีข้อมูล";
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['get_r_record'] != NULL) {
                                                        echo $row['get_r_record'];
                                                    } else {
                                                        echo "ไม่มีข้อมูล";
                                                    } ?>
                                                </td>
                                                <td><?php
                                                    if ($row['r_serial_number'] != NULL) {
                                                        echo $row['r_serial_number'];
                                                    } else {
                                                        echo "ไม่มีข้อมูล";
                                                    } ?>
                                                </td>

                                                <!-- <td>System Architect</td> -->
                                                <td><?php
                                                    if ($row['get_r_detail'] != NULL) {
                                                        echo $row['get_r_detail'];
                                                    } else {
                                                        echo "ไม่มีข้อมูล";
                                                    } ?></td>
                                                <td>
                                                    <?php
                                                    if ($formattedDate != NULL) {
                                                        echo $formattedDate;
                                                    } else {
                                                        echo "ไม่มีข้อมูล";
                                                    } ?>
                                                </td>
                                                <td style="color: <?= $row['status_color'] ?>;"><?= $row['status_name'] ?></td>
                                                <td>

                                                    <div class="text-center">
                                                        <a class="btn btn-primary" href="detail_repair.php?id=<?= $row['get_r_id'] ?>">ดู</a>
                                                        <a class="btn btn-danger" href="action/delete_repair.php?get_r_id=<?= $row['get_r_id'] ?>" onclick="return confirmDelete(event);">ลบ</a>

                                                        <!-- Include SweetAlert library -->
                                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                                                        <!-- JavaScript function for confirmation -->
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
                                                        </script>

                                                    </div>
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
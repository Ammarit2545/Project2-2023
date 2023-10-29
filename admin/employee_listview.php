<?php
session_start();
include('../database/condb.php');

if (!isset($_SESSION['role_id'])) {
    header('Location:../home.php');
}
$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Edit Employee Information</title>
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

                    <!-- Page Heading -->
                    <br>
                    <h1 class="h3 mb-2 text-gray-800" style="display:inline-block">เพิ่มข้อมูลพนักงาน</h1>
                    <a href="add_employee.php" style="display:inline-block; margin-left: 10px; position :relative">คุณต้องการเพิ่มรายชื่อพนักงานหรือไม่?</a>
                    <br>
                    <br>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลพนักงาน</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>รหัสพนักงาน</th>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>ตำแหน่ง</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <!-- <th>ที่อยู่</th> -->
                                            <!-- <th>Start date</th> -->
                                            <!-- <th>Salary</th> -->
                                            <th>ปุ่มดำเนินการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM employee 
                                                LEFT JOIN role 
                                                ON employee.role_id = role.role_id 
                                                WHERE employee.del_flg = '0'";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                            <tr>
                                                <td><?php
                                                    if ($row['e_id'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                    ?>
                                                        <p style="font-size : 80%"><?= $row['e_id'] ?></p>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                    if ($row['e_fname'] == NULL || $row['e_lname'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                    ?>
                                                        <p style="font-size : 80%"><?= $row['e_fname'] . " " . $row['e_lname']; ?></p>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['role_name'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                    ?>
                                                        <p style="font-size : 80%"><?= $row['role_name']; ?></p>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['e_tel'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                    ?>
                                                        <p style="font-size : 80%"><?= $row['e_tel']; ?></p>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <!-- <td>
                                                    <?php
                                                    if ($row['e_add'] == NULL) {
                                                        echo "-";
                                                    } else {

                                                        $jsonobj = $row['e_add'];

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
                                                    ?><p style="font-size : 80%"><?= 'จ.' . $row_p[0] . ' ,อ.' . $row_p[1] . ' ,ต.' . $row_p[2]; ?></p><?php
                                                                                                                                                    }
                                                                                                                                                        ?>
                                                </td> -->
                                                <!-- <td>
                                                    <?php
                                                    if ($row['e_date_in'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                    ?>
                                                        <p style="font-size : 80%"><?= $row['e_date_in'] ?></p>
                                                    <?php
                                                    }
                                                    ?>
                                                </td> -->
                                                <!-- <td>
                                                    <?php
                                                    if ($row['e_salary'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                    ?>
                                                        <p style="font-size : 80%"><?= number_format($row['e_salary'], 0, '.', ',') . " ฿"; ?></p>
                                                    <?php
                                                    }
                                                    ?>
                                                </td> -->
                                                <td>
                                                    <?php if ($row['e_id'] != $id) {
                                                    ?>
                                                        <a href="action/del_employee.php?id=<?= $row['e_id'] ?>" class="btn btn-danger" onclick="return confirmDelete(event);">ลบ</a>&nbsp; &nbsp;

                                                    <?php
                                                    } ?>
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
                                                    <a class="btn btn-success" href="show_profile.php?id=<?= $row['e_id'] ?>">ดู</a>
                                                    <a class="btn btn-warning" href="edit_employee.php?id=<?= $row['e_id'] ?>">แก้ไข</a>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_SESSION['edit_employee'])) {
        if ($_SESSION['edit_employee'] == 1) {
    ?>
            <script>
                let timerInterval
                Swal.fire({
                    title: 'แก้ไขข้อมูลพนักงานเสร็จสิ้น',
                    html: 'จะปิดภายใน <b></b> มิลลิวินาที.',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    },
                    onClose: () => {
                        // You can add your code here to run when the alert is closed
                    }
                });
            </script>
        <?php
            unset($_SESSION['edit_employee']);
        } else {
        ?>
            <script>
                Swal.fire(
                    'มีข้อผิดพลาดในการแก้ไข?',
                    'โปรดแก้ไขอีกครั้งหรือติดต่อผู้ดูแลระบบ?',
                    'question'
                )
            </script>
    <?php
            unset($_SESSION['edit_employee']);
        }
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
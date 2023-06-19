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

    <title>View Part - Edit Employee Information</title>
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

                    <?php
                    $i = 1;
                    while (isset($_SESSION['part_p_id_' . $i])) {
                        $i++;
                    }
                    ?>
                    <br>
                    <h1 class="h3 mb-2 text-gray-800" style="display:inline-block">จัดการจำนวนอะไหล่</h1>
                    <a href="add_part_stock.php" style="display:inline-block; margin-left: 10px; position :relative">คุณต้องการเพิ่มรายการหรือไม่? <?= $i ?></a>
                    <br>
                    <br>





                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลที่ท่านต้องการเพิ่ม</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>รูปภาพ</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Model Number</th>
                                            <th>ประเภท</th>
                                            <th>ราคา</th>
                                            <th>จำนวน</th>
                                            <th>ปุ่มดำเนินการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 1;
                                        while (isset($_SESSION['part_p_id_' . $i])) {


                                            $sql = "SELECT * FROM parts LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id WHERE parts.del_flg = '0' AND parts.p_id = '$i' LIMIT 1";
                                            $result = mysqli_query($conn, $sql);

                                            $row = mysqli_fetch_array($result);
                                        ?>
                                            <tr>
                                                <td><?php
                                                    if ($row['p_id'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['p_id'];
                                                    }
                                                    ?>
                                                </td>

                                                <td><?php
                                                    if ($row['p_pic'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                    ?>
                                                        <img src="../<?= $row['p_pic'] ?>" width="50px" alt="Not Found">
                                                    <?php
                                                    }
                                                    ?>
                                                </td>


                                                <td><?php
                                                    if ($row['p_name'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['p_name'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                    if ($row['p_brand'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['p_brand'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                    if ($row['p_model'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['p_model'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                    if ($row['p_type_name'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['p_type_name'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                    if ($row['p_price'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo number_format($row['p_price']);
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                    if ($row['p_stock'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $_SESSION['part_p_stock_' . $i];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <!-- <button onclick="confirmDelete(<?= $row['p_id'] ?>)" class="btn btn-danger">ลบ</button> -->
                                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                                                    <!-- JavaScript function for confirmation -->
                                                    <script>
                                                        function confirmDelete(id) {
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
                                                                    window.location.href = "action/delete_part.php?id=" + id;
                                                                }
                                                            });
                                                        }
                                                    </script>

                                                    <center>
                                                        <a class="btn btn-warning" href="edit_parts.php?id=<?= $row['p_id'] ?>">แก้ไข</a>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                        ?>




                                        <!-- <tr>
                                            <td>Tiger Nixon</td>
                                            <td>Yamaha</td>
                                            <td>cc61</td>
                                            <td>หูฟังไร้สาย เชื่อมต่อผ่าน bluetooth</td>
                                            <td>$320,800</td>
                                            <th>2</th>
                                            <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>KKM</td>
                                            <td>aas63</td>
                                            <td>ลำโพงใหญ่ โคตรดัง</td>
                                            <td>$170,750</td>
                                            <th>2</th>
                                            <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td>
                                        </tr>

                                        <tr>
                                            <td>Senior Marketing Designer</td>
                                            <td>4545</td>
                                            <td>43</td>
                                            <td>กีต้าร์ไร้สาย หาสายเอาเอง</td>
                                            <td>$313,500</td>
                                            <th>2</th>
                                            <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td>
                                        </tr>
                                        <tr>
                                            <td>Tatyana Fitzpatrick</td>
                                            <td>Regional Director</td>
                                            <td>19</td>
                                            <td>กลองชุด</td>
                                            <td>$385,750</td>
                                            <th>2</th>
                                            <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <center>
                        <button href="action/delete_parts.php" class="btn btn-danger" onclick="return showConfirmation('ล้างทั้งหมด', 'คุณต้องการล้างทั้งหมดหรือไม่')">ทำการล้างทั้งหมด</button>

                        <button href="action/add_stock_part_db.php" class="btn btn-success" onclick="return showConfirmation('เพิ่มจำนวนอะไหล่ไปสู่คลัง', 'คุณต้องการเพิ่มจำนวนอะไหล่ไปสู่คลังหรือไม่')">เพิ่มจำนวนอะไหล่ไปสู่คลัง</button>

                        <!-- Example CDNs, use appropriate versions and sources -->
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                        <script>
                            function showConfirmation(action, message) {
                                return Swal.fire({
                                    title: "คุณแน่ใจหรือไม่?",
                                    text: message,
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "ยืนยัน",
                                    cancelButtonText: "ยกเลิก"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // User confirmed, proceed with the action
                                        window.location.href = action;
                                    } else {
                                        // User canceled, do nothing
                                        return false;
                                    }
                                });
                            }
                        </script>

                    </center>
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


</body>

</html>
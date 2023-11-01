<?php
session_start();
include('../database/condb.php');

if (!isset($_SESSION['role_id'])) {
    header('Location:../home.php');
}
$st_id = -1;

if (isset($_GET['st_id'])) {
    $st_id = $_GET['st_id'];
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
                    <h1 class="h3 mb-2 text-gray-800" style="display:inline-block">ประวัติการเพิ่ม "อะไหล่"</h1>
                    <!-- <a href="add_employee.php" style="display:inline-block; margin-left: 10px; position :relative">คุณต้องการเพิ่มรายชื่อพนักงานหรือไม่?</a> -->
                    <hr>
                    <p>ค้นหาเพิ่มเติมด้วยประเภท</p>
                    <a href="log_part.php" class="btn btn-success">ทั้งหมด</a>
                    <a href="log_part.php?st_id=2" class="btn btn-primary">มีใบเสร็จ</a>
                    <a href="log_part.php?st_id=1" class="btn btn-warning">เพิ่มด้วตัวเอง</a>
                    <!-- <a href="log_part.php?st_id=0" class="btn btn-danger">รายการที่ลด</a> -->
                    <br>
                    <br>
                    <br>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลการการจัดการอะไหล่</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>วันที่ทำรายการ</th>
                                            <th>ประเภทที่ทำรายการ</th>
                                            <!-- <th>เพิ่ม / ลบ</th> -->
                                            <th>หมายเลขใบเสร็จ</th>
                                            <th>เลขกำกับภาษี</th>
                                            <th>จำนวนที่ทำรายการ</th>
                                            <th>บริษัท</th>
                                            <th>เพิ่มเติม</th>

                                            <!-- <th>ลบ</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($st_id == 0) {
                                            $sql = "SELECT * FROM `parts_log` 
    LEFT JOIN stock_type ON stock_type.st_id = parts_log.st_id 
    WHERE stock_type.st_type = 0
    ORDER BY parts_log.pl_id  DESC";
                                        } elseif ($st_id == 1) {
                                            $sql = "SELECT * FROM `parts_log` 
    LEFT JOIN stock_type ON stock_type.st_id = parts_log.st_id 
    WHERE stock_type.st_id = 1
    ORDER BY parts_log.pl_id  DESC";
                                        } elseif ($st_id == 2) {
                                            $sql = "SELECT * FROM `parts_log` 
    LEFT JOIN stock_type ON stock_type.st_id = parts_log.st_id 
    WHERE stock_type.st_source = 1
    ORDER BY parts_log.pl_id  DESC";
                                        } else {
                                            $sql = "SELECT * FROM `parts_log` 
    LEFT JOIN stock_type ON stock_type.st_id = parts_log.st_id 
    ORDER BY parts_log.pl_id  DESC";
                                        }


                                        $result = mysqli_query($conn, $sql);
                                        $i = 0;
                                        while ($row = mysqli_fetch_array($result)) {
                                            $pl_id = $row['pl_id'];
                                            $i++;
                                        ?>
                                            <tr>
                                                <td><?php
                                                    if ($i == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $i;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['pl_date'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $formattedDate = date("Y-m-d H:i:s", strtotime($row['pl_date']));
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $sql_type = "SELECT * FROM `stock_type` 
                                                                LEFT JOIN parts_log ON parts_log.st_id = stock_type.st_id
                                                                WHERE parts_log.pl_id = '$pl_id' AND stock_type.del_flg = 0";
                                                    $result_type = mysqli_query($conn, $sql_type);
                                                    $row_type = mysqli_fetch_array($result_type);
                                                    if ($row_type['st_name'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        if ($row_type['st_source'] == 1) {
                                                    ?>
                                                            <p style="color:white" class="btn btn-primary"><?= $row_type['st_name'] ?></p>
                                                    <?php
                                                        } else {
                                                            // echo $row_type['st_name'];
                                                            ?>
                                                            <p style="color:white" class="btn btn-warning"><?= $row_type['st_name'] ?></p>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <!-- <td>
                                                    <?php
                                                    if ($row_type['st_type'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        if ($row_type['st_type'] > 0) {
                                                            echo 'เพิ่ม';
                                                        } else {
                                                            echo 'ลบ';
                                                        }
                                                    }
                                                    ?>
                                                </td> -->
                                                <td><?php
                                                    if ($row['pl_bill_number'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['pl_bill_number'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <!-- <?php

                                                            $sql_c = "SELECT * FROM `parts`WHERE p_id = '$p_id'";
                                                            $result_c = mysqli_query($conn, $sql_c);
                                                            $rows = mysqli_fetch_array($result_c);

                                                            if ($row['p_id'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo $rows['p_brand'] . ' ';
                                                            }
                                                            ?> -->

                                                    <?php
                                                    if ($row['pl_tax_number'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['pl_tax_number'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php

                                                    $sql_c = "SELECT COUNT(pl_id) FROM `parts_log_detail` WHERE pl_id = '$pl_id' AND del_flg = 0";
                                                    $result_c = mysqli_query($conn, $sql_c);
                                                    $rows = mysqli_fetch_array($result_c);

                                                    if ($row[0] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $rows[0] . ' รายการ';
                                                    }
                                                    ?>
                                                </td>

                                                </td>
                                                <td>
                                                    <?php
                                                    $sql_com = "SELECT * FROM `company_parts` 
                                                                LEFT JOIN parts_log ON parts_log.com_p_id = company_parts.com_p_id
                                                                WHERE parts_log.pl_id = '$pl_id' AND company_parts.del_flg = 0";
                                                    $result_com = mysqli_query($conn, $sql_com);
                                                    $row_com = mysqli_fetch_array($result_com);
                                                    if ($row_com['com_p_name'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row_com['com_p_name'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="parts_log_detail.php?pl_id=<?= $pl_id ?>" class="btn btn-info">รายละเอียด</a>
                                                </td>

                                                <!-- <td>
                                                    <center>
                                                        <a href="action/del_employee.php?id=<?= $row['e_id'] ?>" class="btn btn-danger" onclick="return confirmDelete(event);">ลบ</a>&nbsp; &nbsp;
                                                    </center>
                                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
                                                </td> -->
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
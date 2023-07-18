<?php
session_start();
include('../database/condb.php');

if (!isset($_SESSION['role_id']) || !isset($_GET['pl_id'])) {
    header('Location:../home.php');
}
$pl_id = $_GET['pl_id'];

$sql = "SELECT * FROM `parts_log`
        LEFT JOIN stock_type ON stock_type.st_id = parts_log.st_id
        WHERE parts_log.pl_id = '$pl_id'";
$result = mysqli_query($conn, $sql);
$row_pl = mysqli_fetch_array($result);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

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
                    <h1 class="h3 mb-2 text-gray-800" style="display:inline-block">ประวัติการจัดการ <span style="color:#ffff" class="badge badge-primary"> ID #<?= $pl_id ?></span></h1>

                    <div class="accordion mt-4" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    รายละเอียด
                                </button>
                            </h2>      
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <font>  
                                        <br>
                                        <?php if ($row_pl['st_source'] == 1) {
                                        ?>
                                            <p><span class="badge badge-secondary">ประเภท</span> : <?= $row_pl['st_name'] ?></p>
                                            <p><span class="badge badge-secondary">ประเลขที่ใบเสร็จเภท</span> : <?= $row_pl['pl_bill_number'] ?></p>
                                            <p><span class="badge badge-secondary">เลขที่กำกับภาษี</span> : <?= $row_pl['pl_tax_number'] ?></p>
                                            <p><span class="badge badge-secondary">วันที่ทำรายการ</span> : <?= date('Y-m-d -- H:i:s', strtotime($row_pl['pl_date'])) ?></p>
                                            <p><span class="badge badge-secondary">รายละเอียด</span> : <?= $row_pl['pl_detail'] ?></p>
                                        <?php
                                        } else {
                                        ?>
                                            <p>ประเภท : <?= $row_pl['st_name'] ?></p>
                                            <p>วันที่ทำรายการ : <?= date('Y-m-d -- H:i:s', strtotime($row_pl['pl_date'])) ?></p>
                                            <!-- <p>รายละเอียด : <?= $row_pl['pl_detail'] ?></p> -->
                                        <?php
                                        } ?>
                                    </font> 
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <th>รูปภาพ</th>
                                            <th>ID</th>
                                            <th>Brand</th>
                                            <th>Modal</th>
                                            <th>Number MD</th>
                                            <th>จำนวนที่ทำรายการ</th>

                                            <!-- <th>ลบ</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `parts_log_detail` 
                                                LEFT JOIN parts ON parts_log_detail.p_id = parts.p_id
                                                WHERE parts_log_detail.pl_id = '$pl_id' ORDER BY pl_id  DESC";
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
                                                <td width="120px">
                                                    <?php
                                                    if ($row['p_pic'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                    ?>
                                                        <img src="../<?= $row['p_pic']  ?>" alt="" width="100%" style="border-radius:20%">
                                                    <?php
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
                                                    if ($row['p_id'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['p_id'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['p_brand'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        if ($row['p_brand'] > 0) {
                                                            echo $row['p_brand'];
                                                        } else {
                                                            echo '0';
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['p_model'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        if ($row['p_model'] > 0) {
                                                            echo $row['p_model'];
                                                        } else {
                                                            echo '0';
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['p_name'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        if ($row['p_name'] > 0) {
                                                            echo $row['p_name'];
                                                        } else {
                                                            echo '0';
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['pl_d_value'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        if ($row['pl_d_value'] > 0) {
                                                            echo $row['pl_d_value'];
                                                        } else {
                                                            echo '0';
                                                        }
                                                    }
                                                    ?>
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
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

    <title>Role - View Employee Information</title>
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
                <form action="action/add_role.php" method="POST">

                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">เพิ่มแผนกพนักงาน</h1>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">แผนกพนักงาน</label>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" name="role_name" id="inputPartType" class="form-control" id="staticEmail" onblur="checkPartType()" placeholder="กรุณากรอกแผนกที่ต้องการ" required>
                                            <span id="part-type-error" style="color:red;display:none;">ข้อมูลนี้มีอยู่ในระบบแล้ว</span>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-success" onclick="return confirm('คุณต้องการเพิ่มชื่อแผนกใหม่ในระบบหรือไม่?')">ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function checkPartType() {
                                        var role_name = document.getElementById('inputPartType').value;
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                if (this.responseText == 'exists') {
                                                    document.getElementById('part-type-error').style.display = 'block';
                                                    document.getElementById('inputPartType').setCustomValidity('มีข้อมูลอยู่แล้ว');
                                                    document.getElementById('submit-button').disabled = true; // disable the submit button
                                                } else {
                                                    document.getElementById('part-type-error').style.display = 'none';
                                                    document.getElementById('inputPartType').setCustomValidity('');
                                                    document.getElementById('submit-button').disabled = false; // enable the submit button
                                                }
                                            }
                                        };
                                        xhttp.open('GET', 'action/check_role.php?role_name=' + role_name, true);
                                        xhttp.send();
                                    }
                                </script>

                            </div>
                        </div>

                        <!-- <div class="text-center pt-4">
                            <button type="submit" class="btn btn-success" onclick="return confirm('คุณต้องการเพิ่มชื่อแผนกใหม่ในระบบหรือไม่?')">ยืนยัน</button>
                        </div> -->

                    </div>


                </form>
                <br>
                <hr>
                <br>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">แผนกพนักงาน</h1>
                    <br>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">แผนกพนักงาน</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ลำดับที่</th>
                                            <th>ประเภทอะไหล่</th>
                                            <th>ปุ่มดำเนินการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `role` WHERE del_flg = 0 ORDER BY role_id ASC";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <tr>

                                                <td>
                                                    <?php
                                                    if ($row['role_id'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['role_id'];
                                                    }
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    if ($row['role_name'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['role_name'];
                                                    }
                                                    ?>
                                                </td>

                                                <td>
                                                    <a href="action/delete_role.php?id=<?= $row['role_id'] ?>" class="btn btn-danger" onclick="return confirmDelete(event)">ลบ</a>&nbsp; &nbsp;
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
                                                    <button type="button" class="btn btn-warning" onclick="window.location.href='edit_role.php?id=<?= $row['role_id'] ?>'">แก้ไข</button>&nbsp; &nbsp;
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
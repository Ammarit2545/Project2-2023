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

    <title>Add Company - ANE Electronic</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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

                    <form action="action/edit_company.php" method="POST">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">เพิ่มข้อมูลบริษัท</h1>
                        </div>

                        <div class="mb-3 row">
                            <?php
                            $id_com = $_GET['id'];

                            $sql = "SELECT * FROM company WHERE com_id = '$id_com' AND del_flg = '0'";
                            $result = mysqli_query($conn,$sql);
                            $row_c = mysqli_fetch_array($result);
                            ?>
                            <label for="staticEmail" class="col-sm-1 col-form-label">ชื่อบริษัท</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" name="com_name" id="inputPartType" onblur="checkPartType()" value="<?= $row_c['com_name'] ?>" placeholder="กรุณากรอกชื่อบริษัท" required>
                            <input type="text" class="form-control" name="com_id" id="inputPartType" value="<?= $id_com ?>" placeholder="กรุณากรอกรหัส" required hidden>
                                <!-- <input type="text" class="form-control" name="p_type_id" id="staticEmail" value="<?= $row['p_type_id'] ?>" placeholder="กรุณากรอกข้อมูล" hidden> -->
                                <span id="part-type-error" style="color:red;display:none;">ชื่อบริษัทนี้มีอยู่แล้ว</span>
                                <script>
                                    function checkPartType() {
                                        var com_name = document.getElementById('inputPartType').value;
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
                                        xhttp.open('GET', 'action/check_company.php?com_name=' + com_name, true);
                                        xhttp.send();
                                    }
                                </script>
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">เบอร์โทรศัพท์</label>
                            <div class="col-sm-4">
                                <input name="com_tel" type="text" class="form-control" id="inputPassword" value="<?= $row_c['com_tel'] ?>" placeholder="กรุณากรอกชื่อเบอร์บริษัท (*ไม่จำเป็น)" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-1 col-form-label">FAX</label>
                            <div class="col-sm-4">
                                <input name="com_fax" type="text" class="form-control" id="inputPassword" value="<?= $row_c['com_fax'] ?>" placeholder="กรุณากรอกชื่อเบอร์ Fax บริษัท (*ไม่จำเป็น)" required> 
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="col-form-label">ที่อยู่ :</label>
                            <textarea name="com_add" class="form-control auto-expand" id="exampleFormControlTextarea1" rows="3" required><?= $row_c['com_add'] ?></textarea>
                        </div>
                        <div class="text-center pt-4">
                            <button type="submit" class="btn btn-success">ยืนยัน</button>
                        </div>
                    </form>

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

</body>

</html>
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

    <title>Admin - Edit Employee Information</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        #myList {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #myList li {
            padding: 8px 12px;
            cursor: pointer;
        }

        #myList li:hover {
            background-color: #ddd;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Dim background color */
            z-index: 9999;
        }

        .modal-content {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 10000;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #999;
            background: none;
            border: none;
            cursor: pointer;
        }

        .close-button:hover {
            color: #666;
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
                <div class="background"></div>

                <!-- Content Here Start -->

                <h1 class="pt-5 text-center">บันทึกการซ่อมด้วยตัวเอง</h1>
                <center>
                    <p>บันทึกการซ่อมด้วยตัวเอง สินค้าที่เสียหายจะต้องซ่อมเสร็จสิ้นแล้วเท่านั้น</p>
                </center>
                <br>

                <form action="action/edit_stock.php" method="POST" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <label for="tel">ชื่อยี่ห้อ</label>
                                <input type="text" class="form-control input" id="borderinput" name="name_brand" placeholder="กรุณากรอก ชื่อยี่ห้อ" required>
                            </div>
                            <div class="col-6">
                                <label for="tel">เลข Serial Number</label>
                                <!-- <input type="text" class="form-control input" id="borderinput" name="serial_number" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)"> -->
                                <input type="text" name="serial_number" value="NPE123456" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)" class="form-control" id="inputPassword" onblur="CheckSerial()" required>
                                <span id="serial-error" style="color:red;display:none;">อุปกรณ์หมดระยะประกันแล้ว</span>
                                <!-- exits -->
                                <span id="serial-error-ok" style="color:green;display:none;">อุปกรณ์นี้ยังอยู่ในระยะประกัน</span>
                                <!-- else -->
                                <span id="serial-error-none" style="color:blue;display:none;">อุปกรณ์นี้ยังไม่มีประกัน</span>
                                <!-- exits ok-->
                                <span id="serial-error-have" style="color:red;display:none;">อุปกรณ์นี้อยู่ระหว่างการซ่อมของคุณ</span>
                                <!-- exits have-->
                                <script>
                                    function CheckSerial() {
                                        var serial = document.getElementById('inputPassword').value;
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                if (this.responseText == 'exists') {
                                                    document.getElementById('serial-error').style.display = 'block';
                                                    document.getElementById('serial-error-ok').style.display = 'none';
                                                    document.getElementById('serial-error-none').style.display = 'none';
                                                    document.getElementById('serial-error-have').style.display = 'none';
                                                    document.getElementById('inputPassword').setCustomValidity('');
                                                } else if (this.responseText == 'exists-ok') {
                                                    document.getElementById('serial-error').style.display = 'none';
                                                    document.getElementById('serial-error-ok').style.display = 'none';
                                                    document.getElementById('serial-error-none').style.display = 'block';
                                                    document.getElementById('serial-error-have').style.display = 'none';
                                                    document.getElementById('inputPassword').setCustomValidity('');
                                                } else if (this.responseText == 'exists-have') {
                                                    document.getElementById('serial-error').style.display = 'none';
                                                    document.getElementById('serial-error-ok').style.display = 'none';
                                                    document.getElementById('serial-error-none').style.display = 'none';
                                                    document.getElementById('serial-error-have').style.display = 'block';
                                                    document.getElementById('inputPassword').setCustomValidity('ไม่สามารถส่งข้อมูลที่อยู่ในขณะดำเนินการซ่อมได้');
                                                } else {
                                                    document.getElementById('serial-error').style.display = 'none';
                                                    document.getElementById('serial-error-ok').style.display = 'block';
                                                    document.getElementById('serial-error-none').style.display = 'none';
                                                    document.getElementById('serial-error-have').style.display = 'none';
                                                    document.getElementById('inputPassword').setCustomValidity('');
                                                }
                                            }
                                        };
                                        xhttp.open('GET', 'action/check_serial_number.php?serial=' + serial, true);
                                        xhttp.send();
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Content End -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


    </div>
    <!-- End of Content Wrapper -->

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

    <!-- Sweet Alert Show Start -->
    <?php
    if (isset($_SESSION['add_data_alert'])) {
        if ($_SESSION['add_data_alert'] == 0) {
            $id = 123; // Replace 123 with the actual ID you want to pass to the deletion action
    ?>
            <script>
                Swal.fire({
                    title: 'เพิ่มข้อมูลสำเร็จ',
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
                    title: 'มี Serial Number นี้อยู่แล้ว ',
                    text: 'กด Accept เพื่อออก',
                    icon: 'error',
                    confirmButtonText: 'Accept'
                });
            </script>

    <?php
            unset($_SESSION['add_data_alert']);
        }
    }
    ?>
    <!-- Sweet Alert Show End -->

</body>

</html>
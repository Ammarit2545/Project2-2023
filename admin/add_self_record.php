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
                <div class="background"></div>


                <h1 class="pt-5 text-center">บันทึกการซ่อมด้วยตัวเอง</h1>
                <center>
                    <p>บันทึกการซ่อมด้วยตัวเอง สินค้าที่เสียหายจะต้องซ่อมเสร็จสิ้นแล้วเท่านั้น</p>
                </center>
                <br>
                <form action="action/add_self_repair.php" method="POST" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="tel">ชื่อยี่ห้อ</label>
                                        <input type="text" class="form-control input" id="borderinput" name="name_brand" placeholder="กรุณากรอก ชื่อยี่ห้อ" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="tel">เลข Serial Number</label>
                                        <!-- <input type="text" class="form-control input" id="borderinput" name="serial_number" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)"> -->
                                        <input type="text" name="serial_number" value="NPE123456" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)" class="form-control" id="inputPassword" onblur="CheckSerial()" required>
                                        <span id="serial-error" style="color:red;display:none;">สินค้าชิ้นนี้หมดระยะประกันแล้ว</span>
                                        <!-- exits -->
                                        <span id="serial-error-ok" style="color:green;display:none;">สินค้าชิ้นนี้ยังอยู่ในระยะประกัน</span> 
                                        <!-- else -->
                                        <span id="serial-error-none" style="color:blue;display:none;">สินค้าชิ้นนี้ยังไม่มีประกัน</span>
                                        <!-- exits ok-->
                                        <span id="serial-error-have" style="color:blue;display:none;">สินค้าชิ้นนี้อยู่ระหว่างการซ่อมของคุณ</span>
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
                                                        }else if (this.responseText == 'exists-ok') {   
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
                                                        } 
                                                        else {
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
                                <br>

                                <div class="row">
                                    <div class="col-6">
                                        <label for="tel">ชื่อรุ่น</label>
                                        <input type="text" class="form-control input" id="borderinput" name="name_model" placeholder="กรุณากรอก ชื่อรุ่น" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="tel">หมายเลขรุ่น</label>
                                        <input type="text" class="form-control input" id="borderinput" name="number_model" placeholder="กรุณากรอก หมายเลขรุ่น  (ไม่จำเป็น)">
                                    </div>
                                </div>
                                <br>

                                <div class="row">

                                    <div class="col-6">
                                        <label for="tel">ชื่อบริษัท <p style="color : red; display : inline">*กรณีมีประกันกับทางร้าน</p></label>
                                        <br>
                                        <select class="form-select" aria-label="Default select example" name="company">
                                            <option selected>กรุณาเลือกบริษัท</option>
                                            <?php
                                            $sql_c = "SELECT * FROM company WHERE del_flg = '0'";
                                            $result_c = mysqli_query($conn, $sql_c);
                                            while ($row_c = mysqli_fetch_array($result_c)) {
                                            ?><option value="<?= $row_c['com_id'] ?>"><?= $row_c['com_name'] ?></option><?php
                                                                                                                    }
                                                                                                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <label for="borderinput1" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ</label>
                                <div class="row">
                                    <div class="col-3">
                                        <input type="file" name="image1" onchange="previewImage('image-preview1')" id="fileToUpload">
                                        <div id="image-preview1"></div>
                                    </div>
                                    <div class="col-3">
                                        <input type="file" name="image2" onchange="previewImage('image-preview2')" id="fileToUpload">
                                        <div id="image-preview2"></div>
                                    </div>
                                    <div class="col-3">
                                        <input type="file" name="image3" onchange="previewImage('image-preview3')" id="fileToUpload">
                                        <div id="image-preview3"></div>
                                    </div>
                                    <div class="col-3">
                                        <input type="file" name="image4" onchange="previewImage('image-preview4')" id="fileToUpload">
                                        <div id="image-preview4"></div>
                                    </div>





                                </div>
                                <!-- <div class="row">
                                    <div id="image-preview1"></div>
                                    <div id="image-preview2"></div>
                                    <div id="image-preview3"></div>
                                    <div id="image-preview4"></div>
                                </div> -->
                                <br>
                                <script>
                                    function previewImage(previewId) {
                                        var input = event.target;
                                        var previewContainer = document.getElementById(previewId);
                                        var previewImage = document.createElement('img');

                                        // Set the maximum width and maximum height of the image
                                        previewImage.style.maxWidth = '200px';
                                        previewImage.style.maxHeight = '200px';

                                        // Set the border radius and border style of the image
                                        previewImage.style.borderRadius = '10%';
                                        previewImage.style.border = '2px solid gray';

                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                previewImage.setAttribute('src', e.target.result);
                                                previewContainer.appendChild(previewImage);
                                            };
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                                        <textarea class="form-control" id="inputtext" rows="3" name="description" required placeholder="กรุณากรอกรายละเอียด"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="text-center pt-4">
                                        <center>

                                            <button type="submit" class="btn btn-success" value="Upload Image" name="submit">ยืนยัน</button>
                                        </center>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
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

    <!-- <script>
        function checkEmail() {
            var email = document.getElementById('inputPassword').value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 'exists') {
                        document.getElementById('email-error').style.display = 'block';
                        document.getElementById('inputPassword').setCustomValidity('invalid');
                    } else {
                        document.getElementById('email-error').style.display = 'none';
                        document.getElementById('inputPassword').setCustomValidity('');
                    }
                }
            };
            xhttp.open('GET', 'action/check_email.php?email=' + email, true);
            xhttp.send();
        }
    </script> -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
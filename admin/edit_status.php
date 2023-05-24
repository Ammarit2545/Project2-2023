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

    <title>Status - View Status Information</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
                $status_id = $_GET['id'];
                $sql = "SELECT * FROM status_type WHERE status_id = '$status_id' AND del_flg = '0'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                ?>
                <!-- End of Topbar -->
                <form id="edit_status" action="action/edit_status.php" method="POST">

                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">เพิ่มประเภทของสถานะ</h1>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">ประเภทสถานะ</label>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="text" name="status_name" id="inputstatus_name" class="form-control" id="staticEmail" onblur="checkStatus()" placeholder="กรุณาใส่ประเภทที่ต้องการเพิ่มอะไหล่" value="<?= $row['status_name'] ?>" required>
                                            <span id="part-type-error" style="color:red;display:none;">ข้อมูลนี้มีอยู่ในระบบแล้ว</span>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function checkStatus() {
                                        var status_name = document.getElementById('inputstatus_name').value;
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
                                        xhttp.open('GET', 'action/check_status.php?status_name=' + status_name, true);
                                        xhttp.send();
                                    }
                                </script>
                            </div>
                            <label for="staticEmail" class="col-sm-0 col-form-label">สีของสถานะ</label>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="color" name="status_color" id="inputstatus_name" class="form-control" id="staticEmail" placeholder="กรุณากรอกสีที่ต้องการ (ตัวอย่าง 'red')" value="<?= $row['status_color'] ?>" required>
                                            <input type="text" name="status_id" class="form-control" id="staticEmail" placeholder="กรุณากรอกสีที่ต้องการ (ตัวอย่าง 'red')" value="<?= $row['status_id'] ?>" required hidden>
                                            <span id="part-type-error" style="color:red;display:none;">ข้อมูลนี้มีอยู่ในระบบแล้ว</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <label for="staticEmail" class="col-sm-1 col-form-label" style="font-size: 80%;">Value Code (ชื่อย่อ)</label>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="row">
                                        <!-- <div class="col-md-7">
                                        <input type="text" name="status_color" id="inputstatus_name" class="form-control" id="staticEmail" placeholder="กรุณากรอกสีที่ต้องการ (ตัวอย่าง 'red')" value="<?= $row['value_code'] ?>" required>
                                            <span id="part-type-error" style="color:red;display:none;">ข้อมูลนี้มีอยู่ในระบบแล้ว</span>
                                        </div> -->
                                        <div class="col-md-7">
                                            <input type="text" name="value_code" id="inputvalue_code" class="form-control" onblur="checkValue()" placeholder="กรุณาใส่ประเภทที่ต้องการเพิ่มอะไหล่" value="<?= $row['value_code'] ?>" required>
                                            <span id="part-value-error" style="color: red; display: none;">ข้อมูลนี้มีอยู่ในระบบแล้ว</span>
                                            <span id="word-count-error" style="color: red; display: none;">กรุณาใส่คำที่มีจำนวนมากกว่า 6 คำ</span>
                                        </div>

                                        <script>
                                            function checkValue() {
                                                var value_code = document.getElementById('inputvalue_code').value;
                                                var words = value_code.trim().split(/\s+/); // Split input value by whitespace
                                                var xhttp = new XMLHttpRequest();
                                                xhttp.onreadystatechange = function() {
                                                    if (this.readyState == 4 && this.status == 200) {
                                                        if (this.responseText == 'exists') {
                                                            document.getElementById('part-value-error').style.display = 'block';
                                                            document.getElementById('word-count-error').style.display = 'none';
                                                            document.getElementById('inputvalue_code').setCustomValidity('มีข้อมูลอยู่แล้ว');
                                                            document.getElementById('submit-button').disabled = true; // Disable the submit button
                                                        } else {
                                                            document.getElementById('part-value-error').style.display = 'none';
                                                            if (words.length > 6) {
                                                                document.getElementById('word-count-error').style.display = 'block';
                                                                document.getElementById('inputvalue_code').setCustomValidity('กรุณาใส่คำที่มีจำนวนมากกว่า 6 คำ');
                                                                document.getElementById('submit-button').disabled = true; // Disable the submit button
                                                            } else {
                                                                document.getElementById('word-count-error').style.display = 'none';
                                                                document.getElementById('inputvalue_code').setCustomValidity('');
                                                                document.getElementById('submit-button').disabled = false; // Enable the submit button
                                                            }
                                                        }
                                                    }
                                                };
                                                xhttp.open('GET', 'action/check_value_code.php?value_code=' + value_code, true);
                                                xhttp.send();
                                            }
                                        </script>


                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-success" onclick="showConfirmation(event)">ยืนยัน</button>

                                            <script>
                                                function showConfirmation(event) {
                                                    event.preventDefault(); // Prevent the form from being submitted

                                                    Swal.fire({
                                                        title: 'คุณแน่ใจหรือไม่?',
                                                        text: 'คุณต้องการส่งข้อมูลนี้หรือไม่',
                                                        icon: 'question',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'ใช่',
                                                        cancelButtonText: 'ไม่'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // User confirmed, submit the form
                                                            document.getElementById('edit_status').submit();
                                                        }
                                                    });
                                                }
                                            </script>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <hr>
                <br>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <?php
                include('bar/admin_footer.php');
                ?>
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
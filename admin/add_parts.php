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

    <!-- <title>เพิ่มข้อมูลเครื่องเสียง</title> -->
    <title>Add Part - Edit Employee Information</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">


    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<style>
    .image-container {
        position: relative;
        display: inline-block;
        margin: 8px;
    }

    .preview-image {
        display: block;
        width: 200px;
        height: auto;
    }

    .delete-button {
        position: absolute;
        top: 0;
        right: 0;
        background-color: none;
        border: none;
        color: black;
        font-weight: bold;
        font-size: 24px;
        cursor: pointer;
        outline: none;
    }
</style>

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
                <form id="your-form-id" action="action/add_part.php" method="POST" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">เพิ่มข้อมูลเครื่องเสียง</h1>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">Brand</label>
                            <div class="col-sm-4">
                                <input type="text" name="p_brand" class="form-control" id="staticEmail" placeholder="กรุณากรอกชื่อ Brand" required>
                            </div>
                            <label for="inputPassword" class="col-sm-0 col-form-label ml-4">Model</label>
                            <div class="col-sm-5">
                                <!-- <input type="text" name="p_model" class="form-control" id="inputPassword" placeholder="กรุณาใส่ชื่อ Model" required> -->
                                <input type="text" name="p_model" id="inputPart" class="form-control" onblur="checkPartType()" placeholder="กรุณากรอกชื่อ Model" required>
                                <span id="part-error" style="color:red;display:none;">รหัสโมเดลนี้มีอยู่ในระบบแล้ว</span>
                                <script>
                                    function checkPartType() {
                                        var p_name = document.getElementById('inputPart').value;
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                if (this.responseText == 'exists') {
                                                    document.getElementById('part-error').style.display = 'block';
                                                    document.getElementById('inputPart').setCustomValidity('มีข้อมูลอยู่แล้ว');
                                                    document.getElementById('submit-button').disabled = true; // disable the submit button
                                                } else {
                                                    document.getElementById('part-error').style.display = 'none';
                                                    document.getElementById('inputPart').setCustomValidity('');
                                                    document.getElementById('submit-button').disabled = false; // enable the submit button
                                                }
                                            }
                                        };
                                        xhttp.open('GET', 'action/check_part_model.php?p_name=' + p_name, true);
                                        xhttp.send();
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-1 col-form-label">ชื่อ</label>
                            <div class="col-sm-2 mr-4">
                                <input type="text" name="p_name" class="form-control" id="inputPassword" placeholder="กรุณาใส่ชื่ออะไหล่" required>
                            </div>
                            <label for="inputPassword" class="col-sm-0 col-form-label">ราคา</label>
                            <div class="col-sm-2 mr-4">
                                <input type="text" name="p_price" class="form-control" id="inputPassword" placeholder="กรุณาใส่ราคา" required>
                            </div>
                            <label for="inputPassword" class="col-sm-0 col-form-label">จำนวน</label>
                            <div class="col-sm-2 mr-4">
                                <input type="text" name="p_stock" class="form-control" id="inputPassword" placeholder="กรุณาใส่จำนวน" required>
                            </div>
                            <!-- <label for="inputPassword" class="col-sm-0 col-select-label mt-2">ประเภทอะไหล่</label> -->
                            <label for="inputPassword" class="col-sm-0 col-form-label">ประเภท</label>
                            <div class="col-sm-0 mr-0 mt-0">

                                <!-- <select name="p_type_id" class="form-select" aria-label="Default select example">
                                    <option selected>กรุณาเลือกประเภทอะไหล่</option>
                                    <?php
                                    $sql = "SELECT * FROM parts_type WHERE del_flg = '0'";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?= $row['p_type_id'] ?>"><?= $row['p_type_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select> -->

                                <div class="col">
                                    <select name="p_type_id" id="p_type_id" class="mt-2 form-select" aria-label="Default select example">
                                        <?php
                                        if (isset($conn)) {
                                            $sql = "SELECT * FROM parts_type WHERE del_flg = '0'";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo '<option value="' . $row['p_type_id'] . '">' . $row['p_type_name'] . '</option>';
                                            }
                                        }
                                        ?>
                                        <option value="-1">*เพิ่มประเภทใหม่</option>
                                    </select>
                                    <!-- <input type="text" name="p_type_name" class="form-control mt-2" style="display:none;" required> -->
                                    <label for="p_type_name" style="display:none;">ชื่อประเภทใหม่:</label>
                                    <input type="text" name="p_type_name" id="inputTypePart" class="form-control mt-2" onblur="checkPartType1()" placeholder="กรุณากรอกประเภทที่ต้องการ" style="display:none;" required>
                                    <span id="part-type-error" style="color:red;display:none;">มีประเภทนี้อยู่ในระบบแล้ว</span>
                                    <script>
                                        function checkPartType1() {
                                            var p_type_name = document.getElementById('inputTypePart').value;
                                            var xhttp = new XMLHttpRequest();
                                            xhttp.onreadystatechange = function() {
                                                if (this.readyState == 4 && this.status == 200) {
                                                    if (this.responseText == 'exists') {
                                                        document.getElementById('part-type-error').style.display = 'block';
                                                        document.getElementById('inputTypePart').setCustomValidity('มีข้อมูลอยู่แล้ว');
                                                        document.getElementById('submit-button').disabled = true; // disable the submit button
                                                    } else {
                                                        document.getElementById('part-type-error').style.display = 'none';
                                                        document.getElementById('inputTypePart').setCustomValidity('');
                                                        document.getElementById('submit-button').disabled = false; // enable the submit button
                                                    }
                                                }
                                            };
                                            xhttp.open('GET', 'action/check_part_type.php?p_type_name=' + p_type_name, true);
                                            xhttp.send();
                                        }

                                        // Add the following code to hide the error message when a specific option is selected
                                        var selectElement = document.getElementById('p_type_id');
                                        selectElement.addEventListener('change', function() {
                                            var selectedOption = this.value;
                                            if (selectedOption !== "-1") {
                                                document.getElementById('part-type-error').style.display = 'none';
                                            }
                                        });
                                    </script>
                                </div>
                                <script>
                                    const roleSelect = document.querySelector('#p_type_id');
                                    const newRoleInput = document.querySelector('input[name="p_type_name"]');
                                    roleSelect.addEventListener('change', function() {
                                        if (roleSelect.value == '-1') {
                                            newRoleInput.style.display = 'block';
                                            newRoleInput.setAttribute('required', 'required');
                                        } else {
                                            newRoleInput.style.display = 'none';
                                            newRoleInput.removeAttribute('required');
                                        }
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="col-form-label">รายละเอียด :</label>
                            <textarea name="p_description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <br>
                        <div class="mb-3">
                            <input name="p_pic" type="file" id="upload" id="p_pic" hidden multiple>
                            <h6>เพิ่มรูป</h6>
                            <label for="upload" style="display: block; color: blue;">Choose file</label>
                            <div id="image-container"></div>
                        </div>
                        <div class="text-center pt-4">
                            <a type="submit" class="btn btn-success" onclick="confirmSend()">ยืนยัน</a>

                            <script>
                                function confirmSend() {
                                    Swal.fire({
                                        title: 'คุณต้องการยืนยันการส่งฟอร์มหรือไม่?',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'ตกลง',
                                        cancelButtonText: 'ยกเลิก'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // If user clicks "OK", submit the form
                                            document.getElementById('your-form-id').submit();
                                        }
                                    });

                                    // Prevent the default form submission
                                    return false;
                                }
                            </script>
                        </div>

                    </div>

                </form>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- <script>
        function confirmSend() {
            Swal.fire({
                title: 'คุณต้องการยืนยันการส่งฟอร์มหรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user clicks "OK", submit the form
                    document.getElementById('your-form-id').submit();
                }
            });

            // Prevent the default form submission
            return false;
        }
    </script> -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        const input = document.querySelector('#upload');
        const container = document.querySelector('#image-container');

        input.addEventListener('change', () => {
            const files = input.files;
            if (files) {
                for (let i = 0; i < files.length; i++) {
                    const url = URL.createObjectURL(files[i]);
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('image-container');

                    const image = document.createElement('img');
                    image.classList.add('preview-image');
                    image.setAttribute('src', url);

                    const deleteBtn = document.createElement('button');
                    deleteBtn.classList.add('delete-button');
                    deleteBtn.innerHTML = '&times;';

                    deleteBtn.addEventListener('click', () => {
                        imageContainer.remove();
                    });

                    imageContainer.appendChild(image);
                    imageContainer.appendChild(deleteBtn);
                    container.appendChild(imageContainer);
                }
            }
        });
    </script>

</body>

</html>
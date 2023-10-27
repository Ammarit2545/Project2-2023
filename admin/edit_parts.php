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

    <title>View Part - Edit Part Information</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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

                <?php
                $p_id = $_GET['id'];

                $sql = "SELECT * FROM parts LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id WHERE parts.del_flg = '0' AND p_id = '$p_id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result); {
                ?>
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <form id="editForm" action="action/edit_parts.php" method="POST" enctype="multipart/form-data">

                            <!-- Page Heading -->
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h1 class="h3 mb-0 text-gray-800">แก้ไขข้อมูลเครื่องเสียง</h1>
                            </div>

                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-1 col-form-label">Brand</label>
                                <div class="col-sm-4">
                                    <!-- <input type="text" name="p_brand" class="form-control" id="staticEmail"placeholder="กรุณากรอกยี่ห้ออะไหล่"> -->
                                    <input type="text" name="p_id" class="form-control" id="staticEmail" value="<?= $row['p_id'] ?>" placeholder="กรุณากรอกยี่ห้ออะไหล่" hidden>
                                    <input type="text" name="p_brand" class="form-control" id="part_name_check" value="<?= $row['p_brand'] ?>" placeholder="กรุณากรอกชื่อ Brand" required>
                                    <span id="name-part-error" style="color: red; display: none;">ข้อมูลนี้มีอยู่ในระบบแล้ว</span>


                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">Model</label>
                                <div class="col-sm-4">
                                    <input type="text" name="p_model" id="part_modal_name" class="form-control" onblur="checkPartType()" placeholder="กรุณากรอกชื่อ Model" value="<?= $row['p_model'] ?>" required>
                                    <span id="part-error" style="color: red; display: none;">รหัสโมเดลนี้มีอยู่ในระบบแล้ว</span>
                                </div>
                            </div>
                            <div class="mb-3 row">

                                <div class="col-sm-2 mr-4">
                                    <label for="inputPassword" class="col-sm-1 col-form-label">ชื่อ</label>
                                    <input type="text" name="p_name" class="form-control" id="inputPassword" placeholder="กรุณาใส่ชื่ออะไหล่" value="<?= $row['p_name'] ?>" required>
                                </div>

                                <div class="col-sm-2 mr-4">
                                    <label for="inputPassword" class="col-sm-0 col-form-label">ราคา</label>
                                    <input type="text" name="p_price" class="form-control" id="inputPassword" placeholder="กรุณาใส่ราคา" value="<?= $row['p_price'] ?>" required>
                                </div>

                                <div class="col-sm-2 mr-4">
                                    <label for="inputPassword" class="col-sm-0 col-select-label mt-2">ประเภทอะไหล่</label>
                                    <select name="p_type_id" class="form-select" aria-label="Default select example">
                                        <?php if ($row['p_type_id']) {
                                            $p_type_id = $row['p_type_id'];
                                            $sql = "SELECT * FROM parts_type WHERE del_flg = '0' AND p_type_id <> $p_type_id";
                                            $result = mysqli_query($conn, $sql);
                                        ?>
                                            <option value="<?= $row['p_type_id'] ?>"><?= $row['p_type_name'] ?></option>

                                        <?php
                                        } else {
                                            $sql = "SELECT * FROM parts_type WHERE del_flg = '0'";
                                            $result = mysqli_query($conn, $sql);
                                        ?>
                                            <option selected>กรุณาเลือกประเภทอะไหล่</option>
                                        <?php

                                        } ?>

                                        <?php
                                        while ($row1 = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?= $row1['p_type_id'] ?>"><?= $row1['p_type_name'] ?></option>
                                        <?php
                                        }
                                        ?>

                                    </select>

                                </div>

                                <div class="col-sm-2 mr-4">
                                    <label for="inputPassword" class="col-sm-0 col-form-label">จำนวนอะไหล่คงคลัง</label>
                                    <input type="text" name="p_stock" class="form-control" id="inputPassword" placeholder="กรุณาใส่ราคา" value="<?= $row['p_stock'] ?>" required disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="col-form-label">รายละเอียด :</label>
                                <textarea name="p_description" class="form-control auto-expand" id="exampleFormControlTextarea1" rows="3"><?= $row['p_detail'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="file" name="p_pic" id="upload" hidden onchange="displayImages(this)" accept="image/*">
                                <h6>เพิ่มรูป</h6>
                                <label for="upload" style="display: block; color: blue;">Choose file</label>
                                <div id="image-container">
                                    <img id="original-image" src="../<?= $row['p_pic'] ?>" style="max-width: 100%; max-height: 200px;" alt=" img not found">
                                </div>
                            </div>
                            <div class="text-center pt-4">
                                <a class="btn btn-danger" onclick="return swalConfirmCancel()">ยกเลิก</a>
                                <a class="btn btn-success" onclick="return swalConfirmEdit()">ยืนยัน</a>

                                <script>
                                    function swalConfirmCancel() {
                                        return Swal.fire({
                                            title: "คุณต้องการยกเลิกการแก้ไขข้อมูลนี้หรือไม่?",
                                            text: "ข้อมูลทั้งหมดจะไม่ถูกบันทึก",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "ยืนยัน",
                                            cancelButtonText: "ยกเลิก"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "listview_parts.php";
                                            } else {
                                                return false;
                                            }
                                        });
                                    }

                                    function swalConfirmEdit() {
                                        return Swal.fire({
                                            title: "คุณต้องการแก้ไขข้อมูลหรือไม่?",
                                            text: "โปรดตรวจสอบข้อมูลของคุณให้ครบถ้วน",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "ยืนยัน",
                                            cancelButtonText: "ยกเลิก"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // Submit the form
                                                document.getElementById("editForm").submit();
                                            } else {
                                                return false;
                                            }
                                        });
                                    }
                                </script>

                            </div>
                    </div>
                    <!-- /.container-fluid -->
                <?php } ?>
                </form>
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

    <script>
        function displayImages(input) {
            var container = document.getElementById("image-container");
            var originalImage = document.getElementById("original-image");

            if (input.files.length > 0) {
                originalImage.style.display = "none"; // Hide the original image

                container.innerHTML = ""; // Clear the container first

                // Loop through each selected file
                for (var i = 0; i < input.files.length; i++) {
                    var file = input.files[i];

                    // Create a new image element for the file
                    var image = document.createElement("img");
                    image.style.maxWidth = "100%";
                    image.style.maxHeight = "200px";

                    // Use FileReader to read the contents of the file as a data URL
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        // Set the src attribute of the image to the data URL
                        image.src = event.target.result;
                    };
                    reader.readAsDataURL(file);

                    // Append the image element to the container
                    container.appendChild(image);
                }
            } else {
                originalImage.style.display = "block"; // Show the original image
                container.innerHTML = ""; // Clear the container
            }
        }
    </script>
    <script>
        var BrandNames = [
            <?php
            $sql = "SELECT p_brand FROM parts WHERE del_flg = '0'";
            $result = mysqli_query($conn, $sql);
            $first = true;
            while ($row_c = mysqli_fetch_array($result)) {
                if (!$first) {
                    echo ", ";
                }
                echo "\"" . $row_c['p_brand'] . "\"";
                $first = false;
            }
            ?>
        ];

        function checkBrandName() {
            var inputElement = document.getElementById('part_name_check');
            var errorElement = document.getElementById('name-part-error');
            var inputValue = inputElement.value;

            if (BrandNames.includes(inputValue)) {
                errorElement.style.display = 'inline';
            } else {
                errorElement.style.display = 'none';
            }
        }

        document.getElementById('part_name_check').addEventListener('keyup', checkBrandName);

        var PartNames = [
            <?php
            $sql = "SELECT p_model FROM parts WHERE del_flg = '0'";
            $result = mysqli_query($conn, $sql);
            $first = true;
            while ($row_c = mysqli_fetch_array($result)) {
                if (!$first) {
                    echo ", ";
                }
                echo "\"" . $row_c['p_model'] . "\"";
                $first = false;
            }
            ?>
        ];

        function checkPartType() {
            var inputElement = document.getElementById('part_modal_name');
            var errorElement = document.getElementById('part-error');
            var inputValue = inputElement.value;

            if (PartNames.includes(inputValue)) {
                errorElement.style.display = 'inline';
            } else {
                errorElement.style.display = 'none';
            }
        }

        document.getElementById('part_modal_name').addEventListener('keyup', checkPartType);
    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>



</body>

</html>
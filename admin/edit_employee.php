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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        <?php include('../css/all_page.php'); ?>
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

                $e_id = $_GET['id'];
                ?>
                <!-- End of Topbar -->

                <?php
                $sql = "SELECT * FROM employee WHERE e_id = '$e_id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);

                $jsonobj = $row['e_add'];

                if ($jsonobj) {
                    $obj = json_decode($jsonobj);

                    if ($obj !== null && property_exists($obj, 'province') && property_exists($obj, 'district') && property_exists($obj, 'sub_district')) {
                        $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
                                    FROM provinces
                                    LEFT JOIN amphures ON provinces.id = amphures.province_id
                                    LEFT JOIN districts ON amphures.id = districts.amphure_id
                                    WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
                        $result_p = mysqli_query($conn, $sql_p);
                        $row_p = mysqli_fetch_array($result_p);
                    }
                }
                ?>

                <!-- Begin Page Content -->
                <form id="form_edit" action="action/edit_employee.php?id=<?= $e_id ?>" method="POST">


                    <div class="container-fluid">
                        <br>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h1 mb-0 text-gray-800"> <span style=" color:black">จัดการและแก้ไขข้อมูล</span></h1>
                        </div>
                        <br>
                        <hr>
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user" "></i> <span style=" color:black">ข้อมูลพนักงาน </span></h1>
                        </div>
                        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">แก้ไขข้อมูลพนักงาน</h1>
                        </div> -->
                        <?php

                        $sql = "SELECT * FROM employee WHERE del_flg = '0' AND e_id = '$e_id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        ?>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">ชื่อ</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="e_fname" id="staticEmail" value="<?= $row['e_fname'] ?>" placeholder="กรุณากรอกชื่อ">
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">นามสกุล</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="e_lname" id="inputPassword" value="<?= $row['e_lname'] ?>" placeholder="กรุณากรอกนามสกุล">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-1 col-form-label">เบอร์โทรศัพท์</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="e_tel" id="inputPassword" value="<?= $row['e_tel'] ?>" placeholder="กรุณากรอกเบอร์โทร">
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">เงินเดือน</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="e_salary" id="inputPassword" value="<?= $row['e_salary'] ?>" placeholder="กรุณากรอกชื่อ">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-1 col-form-label">email</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputPassword" value="<?= $row['e_email'] ?>" placeholder="ไม่มีข้อมูล" readonly>
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">ตำแหน่ง</label>
                            <div class="col-sm-4">
                                <!-- <input type="text" class="form-control" name="role_id" id="inputPassword" value="<?= $row['role_id'] ?>" placeholder="Accountant"> -->
                                <select name="role_id" class="mt-2 form-select" aria-label="Default select example" <?php if ($row['role_id'] == '1') {
                                                                                                                    ?>disabled<?php
                                                                                                                            } ?>>
                                    <?php
                                    $role_id = $row['role_id'];
                                    $sql_s1 = "SELECT * FROM role WHERE del_flg = '0' AND role_id = '$role_id'";
                                    $result_s1 = mysqli_query($conn, $sql_s1);
                                    $row_s1 = mysqli_fetch_array($result_s1);
                                    if ($row_s1['role_id'] > 0) {
                                        $sql_s = "SELECT * FROM role WHERE del_flg = '0' AND role_id <> '$role_id' ORDER BY role_id ASC";
                                        $result_s = mysqli_query($conn, $sql_s);
                                    ?>
                                        <option value="<?= $row_s1['role_id'] ?>"><?= $row_s1['role_name'] ?></option>
                                    <?php
                                    } else {
                                        $sql_s = "SELECT * FROM role WHERE del_flg = '0' AND role_id <> '$role_id' ORDER BY role_id ASC";
                                        $result_s = mysqli_query($conn, $sql_s);
                                    } ?>
                                    <?php
                                    while ($row_s = mysqli_fetch_array($result_s)) {
                                    ?>
                                        <option value="<?= $row_s['role_id'] ?>"><?= $row_s['role_name'] ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3" id="old_address">
                                <br>
                                <hr>
                                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-map"></i> <span style="color:black">ที่อยู่</span></h1>
                                </div>
                                <!-- <label for="exampleFormControlTextarea1" class="form-label fw-bold">รายละเอียดข้อมูลการติดต่อ</label> -->
                                <!-- <br> -->
                                <?php if ($row['e_add'] != NULL) {
                                ?>
                                    <div class="row">
                                        <div class="col-4" id="bounce-item">
                                            <label for="exampleFormControlTextarea1" class="col-form-label">จังหวัด :</label>
                                            <input type="text" class="form-control" value="<?= $row_p[0] ?>" placeholder="กรุณาเลือกจังหวัดที่ต้องการ" readonly>
                                        </div>
                                        <div class="col-4" id="bounce-item">
                                            <label for="exampleFormControlTextarea1" class="col-form-label">อำเภอ :</label>
                                            <input type="text" class="form-control" value="<?= $row_p[1] ?>" placeholder="กรุณาเลือกอำเภอที่ต้องการ" readonly>
                                        </div>
                                        <div class="col-4" id="bounce-item">
                                            <label for="exampleFormControlTextarea1" class="col-form-label">ตำบล :</label>
                                            <input type="text" class="form-control" value="<?= $row_p[2] ?>" placeholder="กรุณาเลือกตำบลที่ต้องการ" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <label for="exampleFormControlTextarea1" class="col-form-label" id="bounce-item">รายละเอียดเพิ่มเติม :</label>
                                    <textarea class="form-control" id="bounce-item" rows="3" disabled="disabled" required>
                                <?php
                                    if ($obj->description == NULL) {
                                        echo "ไม่มีข้อมูล";
                                    } else {
                                        echo $obj->description;
                                    }
                                ?>
                    </textarea>
                                <?php
                                } else {
                                ?>
                                    <center>
                                        <h5>ไม่มีข้อมูลที่อยู่</h5>
                                    </center>
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            mysqli_query($conn, "SET NAMES 'utf8' ");
                            error_reporting(error_reporting() & ~E_NOTICE);
                            date_default_timezone_set('Asia/Bangkok');

                            $sql_provinces = "SELECT * FROM provinces";
                            $query = mysqli_query($conn, $sql_provinces);

                            ?>
                            <center>
                                <button class="btn btn-primary" onclick="New_address()" id="button_new_address" style="display: block;">แก้ไขที่อยู่</button>
                            </center>


                            <div id="address" style="display:none">
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
                                <br>
                                <hr>
                                <!-- Page Heading -->
                                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                    <h1 class="h3 mb-0 text-gray-800">รายละเอียดข้อมูลการติดต่อ</h1>
                                </div>
                                <br>
                                <label for="sel1">จังหวัด:</label>
                                <select class="form-control" name="Ref_prov_id" id="provinces" required>
                                    <option value="" selected disabled>กรุณาเลือกจังหวัด</option>
                                    <?php foreach ($query as $value) { ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['name_th'] ?></option>
                                    <?php } ?>
                                </select>
                                <br>

                                <label for="sel1">อำเภอ:</label>
                                <select class="form-control" name="Ref_dist_id" id="amphures" required>
                                    <option value="" selected disabled>กรุณาเลือกอำเภอ</option>
                                </select>
                                <br>

                                <label for="sel1">ตำบล:</label>
                                <select class="form-control" name="Ref_subdist_id" id="districts" required>
                                    <option value="" selected disabled>กรุณาเลือกตำบล</option>
                                </select>
                                <br>

                                <label for="sel1">รหัสไปรษณีย์:</label>
                                <input type="text" name="zip_code" id="zip_code" class="form-control" required>
                                <br>

                                <label for="exampleFormControlTextarea1" class="form-label">รายละเอียดที่อยู่</label>
                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" required></textarea>

                                <!-- <div class="text-center py-4">
                                    <a class="btn btn-success" name="submit" onclick="validateForm()">ยืนยัน</a>
                                </div> -->
                            </div>
                            <br>
                            <center>
                                <button class="btn btn-danger" onclick="New_close_address()" id="button_re_address" style="display: none;">ยกเลิกการแก้ไข</button>
                            </center>
                            <div class="text-center pt-4">
                                <hr>
                                <center>*** หากท่านกรอกข้อมูลเสร็จแล้ว กรุณากดยืนยัน *** </center>
                                <br>
                                <a href="#" class="btn btn-danger" onclick="showCancel()">ยกเลิก</a>
                                <a href="#" class="btn btn-success" onclick="showConfirmation()">ยืนยัน</a>

                                <script>
                                    function showConfirmation() {
                                        Swal.fire({
                                            title: 'คุณต้องการแก้ไขข้อมูลพนักงานหรือไม่?',
                                            text: '*โปรดตรวจสอบข้อมูลให้ถูกต้อง',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonText: 'ยืนยัน',
                                            cancelButtonText: 'ยกเลิก'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // User clicked "Confirm", trigger the form submission
                                                document.getElementById('form_edit').submit();
                                            }
                                        });
                                    }
                                </script>
                                <script>
                                    function showCancel() {
                                        Swal.fire({
                                            title: 'คุณต้องการยกเลิกหรือไม่?',
                                            text: 'ข้อมูลของท่านจะไม่ถูกบันทึก',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonText: 'ยืนยัน',
                                            cancelButtonText: 'ยกเลิก'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // User clicked "Confirm", trigger the form submission
                                                window.location.href = 'employee_listview.php';
                                            }
                                        });
                                    }
                                </script>

                            </div>

                            <script>
                                let provinceSelect = document.getElementById("provinces");
                                let amphurSelect = document.getElementById("amphures");
                                let districtSelect = document.getElementById("districts");

                                // Event listener for province select change
                                provinceSelect.addEventListener("change", function() {
                                    let provinceId = this.value;
                                    resetSelectOptions(amphurSelect);
                                    resetSelectOptions(districtSelect);
                                    if (provinceId) {
                                        loadAmphurData(provinceId);
                                    }
                                });

                                // Event listener for amphur select change
                                amphurSelect.addEventListener("change", function() {
                                    let amphurId = this.value;
                                    resetSelectOptions(districtSelect);
                                    if (amphurId) {
                                        loadDistrictData(amphurId);
                                    }
                                });

                                // Event listener for district select change
                                districtSelect.addEventListener("change", function() {
                                    let districtId = this.value;
                                    let selectedDistrict = response.find(district => district.id === districtId);
                                    if (selectedDistrict) {
                                        document.getElementById("zip_code").value = selectedDistrict.zip_code;
                                    }
                                });

                                // Function to reset select options
                                function resetSelectOptions(selectElement) {
                                    selectElement.innerHTML = '<option value="" selected disabled>-กรุณาเลือก-</option>';
                                }

                                // Function to load amphur data
                                function loadAmphurData(provinceId) {
                                    // Perform an AJAX request to fetch the amphur data
                                    $.ajax({
                                        url: "../get_amphures.php",
                                        method: "POST",
                                        data: {
                                            province_id: provinceId
                                        }, // เพิ่มการส่งค่า province_id
                                        dataType: "json",
                                        success: function(response) {
                                            // Populate the amphur select options
                                            response.forEach(function(amphur) {
                                                let option = document.createElement("option");
                                                option.value = amphur.id;
                                                option.textContent = amphur.name_th;
                                                amphurSelect.appendChild(option);
                                            });
                                        }
                                    });
                                }

                                // Function to load district data
                                function loadDistrictData(amphurId) {
                                    // Perform an AJAX request to fetch the district data
                                    $.ajax({
                                        url: "../get_districts.php",
                                        method: "POST",
                                        data: {
                                            amphur_id: amphurId
                                        }, // เพิ่มการส่งค่า amphur_id
                                        dataType: "json",
                                        success: function(response) {
                                            // Reset district select options
                                            resetSelectOptions(districtSelect);

                                            // Populate the district select options
                                            response.forEach(function(district) {
                                                let option = document.createElement("option");
                                                option.value = district.id;
                                                option.textContent = district.name_th;
                                                districtSelect.appendChild(option);
                                            });

                                            // Set the zip code based on the first district
                                            if (response.length > 0) {
                                                document.getElementById("zip_code").value = response[0].zip_code;
                                            }
                                        }
                                    });
                                }

                                // Function to validate the form before submission
                                function validateForm() {
                                    // Check if all required fields have values
                                    let provinceValue = provinceSelect.value;
                                    let amphurValue = amphurSelect.value;
                                    let districtValue = districtSelect.value;
                                    let zipCodeValue = document.getElementById("zip_code").value;
                                    let descriptionValue = document.getElementById("exampleFormControlTextarea1").value;

                                    if (provinceValue && amphurValue && districtValue && zipCodeValue && descriptionValue) {
                                        // All required fields have values, proceed with submission
                                        showConfirmation();
                                    } else {
                                        // Missing required fields, display an error message or take appropriate action
                                        incompleteInformation();
                                    }
                                }
                            </script>
                            <!-- <center>
                    <br>
                    <a class="btn btn-warning" onclick="New_address()" href="">ต้องการใช้ที่อยู่เดิม</a>
                </center> -->
                            <br>
                        </div>
                    </div>

                    <?php include('script.php'); ?>

                    <!-- <label for="exampleFormControlTextarea1" class="col-form-label">ที่อยู่ :</label>
                            <textarea name="e_add" class="form-control" id="exampleFormControlTextarea1" rows="3"><?= $row['e_add'] ?></textarea> -->

                </form>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            include('bar/admin_footer.php');
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        // Show full page LoadingOverlay
        $.LoadingOverlay("show");

        // Hide it after 3 seconds
        setTimeout(function() {
            $.LoadingOverlay("hide");
        }, 10);

        function New_address() {
            document.getElementById('address').style.display = 'block';
            document.getElementById('old_address').style.display = 'none';
            document.getElementById('button_new_address').style.display = 'none';
            document.getElementById('button_re_address').style.display = 'block';
        }

        function New_close_address() {
            document.getElementById('address').style.display = 'none';
            document.getElementById('old_address').style.display = 'block';
            document.getElementById('button_new_address').style.display = 'block';
            document.getElementById('button_re_address').style.display = 'none';

        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
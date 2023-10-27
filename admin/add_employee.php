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
                <form action="action/add_employee.php" method="POST">
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">เพิ่มข้อมูลพนักงาน</h1>
                        </div>

                        <div class="mb-3 row">

                            <label for="inputPasswordEmail" class="col-sm-1 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" name="e_email" class="form-control" id="inputPasswordEmail" placeholder="กรุณากรอกอีเมลของท่าน" required>
                                <span id="email-error" style="color:red; display:none;">อีเมลนี้ถูกใช้งานแล้ว</span>
                            </div>

                            <!-- <script>
                                var emailAddresses = [
                                    <?php
                                    $sql = "SELECT m_email FROM member WHERE del_flg = '0'";
                                    $result = mysqli_query($conn, $sql);
                                    $first = true;
                                    while ($row_c = mysqli_fetch_array($result)) {
                                        if (!$first) {
                                            echo ", ";
                                        }
                                        echo "\"" . $row_c['m_email'] . "\"";
                                        $first = false;
                                    }
                                    echo ", ";
                                    $sql1 = "SELECT e_email FROM employee WHERE del_flg = '0'";
                                    $result1 = mysqli_query($conn, $sql1);
                                    $first1 = true;
                                    while ($row_c = mysqli_fetch_array($result1)) {
                                        if (!$first1) {
                                            echo ", ";
                                        }
                                        echo "\"" . $row_c['e_email'] . "\"";
                                        $first1 = false;
                                    }
                                    ?>
                                ];

                                function checkEmail() {
                                    var inputElement = document.getElementById('inputPasswordEmail');
                                    var errorElement = document.getElementById('email-error');
                                    var inputValue = inputElement.value;

                                    if (emailAddresses.includes(inputValue)) {
                                        // Email exists in the array, show the error message
                                        errorElement.style.display = 'inline';
                                    } else {
                                        // Email doesn't exist in the array, hide the error message
                                        errorElement.style.display = 'none';
                                    }
                                }

                                // Attach the checkEmail function to the blur event of the input field
                                document.getElementById('inputPasswordEmail').addEventListener('keyup', checkEmail);
                            </script> -->


                            <label for="inputPassword" class="col-sm-1 col-form-label">Password</label>
                            <div class="col-sm-2">
                                <input type="password" class="form-control" oninput="checkPasswordLength()" onblur="checkPasswordLength()" id="password_name" name="e_password" placeholder="กรุณากรอกรหัสผ่าน" required>

                                <span id="password-error" style="color: red; font-size: 12px; display: none;">
                                    <button class="btn btn-danger" style="font-size: 12px; padding: -2px">
                                        รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร
                                    </button>
                                </span>
                            </div>

                            <label for="inputConfirmPassword" class="col-sm-1 col-form-label">Confirm Password</label>
                            <div class="col-sm-2">
                                <!-- <input type="password" name="e_confirm_password" class="form-control" id="inputConfirmPassword" oninput="validateConfirmPassword(this)"> -->
                                <input type="password" class="form-control" oninput="checkPasswordLengthAgain()" onblur="checkPasswordLengthAgain()" id="password_con" name="e_confirm_password" placeholder="กรุณากรอกรหัสผ่านอีกครั้ง" required>
                                <span id="password-again-error" style="color: red; font-size: 12px; display: none;">
                                    <button class="btn btn-danger" style="font-size: 12px; padding: -2px">
                                        รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร
                                    </button>
                                </span>

                                <span id="password-match-error" style="color: red; font-size: 12px; display: none;">
                                    <button class="btn btn-danger" style="font-size: 12px; padding: -2px">
                                        รหัสผ่านไม่ตรงกัน
                                    </button>
                                </span>
                            </div>

                            <script>
                                // Add the 'fade-in' class to trigger the transition
                                document.addEventListener("DOMContentLoaded", function() {
                                    var passwordError = document.getElementById("password-error");
                                    passwordError.style.display = "block";
                                    passwordError.classList.add("fade-in");
                                });

                                function checkPasswordLength() {
                                    // Get the password input element
                                    const passwordInput = document.getElementById('password_name');

                                    // Get the error message span element
                                    const errorMessage = document.getElementById('password-error');

                                    // Function to check the password length
                                    const password = passwordInput.value;

                                    if (password.length < 8) {
                                        // Display the error message if the password length is invalid
                                        errorMessage.style.display = 'inline';
                                    } else {
                                        // Hide the error message if the password meets the length requirement
                                        errorMessage.style.display = 'none';
                                    }
                                }
                                // Add the 'fade-in' class to trigger the transition
                                document.addEventListener("DOMContentLoaded", function() {
                                    var passwordError = document.getElementById("password-again-error");
                                    passwordError.style.display = "block";
                                    passwordError.classList.add("fade-in");
                                });

                                function checkPasswordLengthAgain() {
                                    // Get the password input element
                                    const passwordInput = document.getElementById('password_con');

                                    // Get the error message span elements
                                    const lengthErrorMessage = document.getElementById('password-again-error');
                                    const matchErrorMessage = document.getElementById('password-match-error');

                                    // Function to check the password length
                                    const password = passwordInput.value;

                                    if (password.length < 8) {
                                        // Display the length error message if the password length is invalid
                                        lengthErrorMessage.style.display = 'inline';
                                        matchErrorMessage.style.display = 'none';
                                    } else {
                                        // Hide the length error message if the password meets the length requirement
                                        lengthErrorMessage.style.display = 'none';
                                        // Get the original password input element
                                        const originalPasswordInput = document.getElementById('password_name');
                                        const originalPassword = originalPasswordInput.value;

                                        if (password !== originalPassword) {
                                            // Display the match error message if the passwords do not match
                                            matchErrorMessage.style.display = 'inline';
                                        } else {
                                            // Hide the match error message if the passwords match
                                            matchErrorMessage.style.display = 'none';
                                        }
                                    }
                                }
                            </script>



                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">ชื่อ</label>
                            <div class="col-sm-4">
                                <input type="text" name="e_fname" class="form-control" id="staticEmail" placeholder="ชื่อจริง">
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">นามสกุล</label>
                            <div class="col-sm-4">
                                <input type="text" name="e_lname" class="form-control" id="inputPassword" placeholder="นามสกุลจริง">
                            </div>
                        </div>
                        <br>
                        <div class="mb-3 row">
                            <label for="inputPasswordTel" class="col-sm-1 col-form-label">เบอร์โทรศัพท์</label>
                            <div class="col-sm-3">
                                <input type="text" name="e_tel" class="form-control" id="inputPasswordTel" placeholder="กรุณากรอกเบอร์โทรติดต่อ">
                                <span id="tel-error" style="color:red; display:none;">เบอร์โทรนี้ถูกใช้งานแล้ว</span>
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">เงินเดือน</label>
                            <div class="col-sm-3">
                                <input type="text" name="e_salary" class="form-control" id="inputPassword" placeholder="เพิ่มเงินเดือน">
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">ตำแหน่ง</label>
                            <div class="col-sm-3">
                                <select name="role_id" id="role_id" class="mt-2 form-select" aria-label="Default select example">
                                    <?php
                                    if (isset($conn)) {
                                        $sql = "SELECT * FROM role WHERE del_flg = '0'";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo '<option value="' . $row['role_id'] . '">' . $row['role_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                    <option value="-1">*เพิ่มตำแหน่งใหม่</option>
                                </select>
                                <!-- <label for="new_role_name" style="display:none;">ชื่อตำแหน่งใหม่:</label> -->
                                <!-- <input type="text" name="new_role_name" class="form-control mt-2" style="display:none;" required> -->
                                <label for="p_type_name" style="display:none;">ชื่อตำแหน่งใหม่:</label>
                                <input type="text" name="new_role_name" id="inputTypePart" class="form-control mt-2" onblur="checkRole()" placeholder="กรุณากรอกตำแหน่งที่ต้องการ" style="display:none;" required>
                                <span id="part-type-error" style="color:red;display:none;">มีแผนกนี้อยู่ในระบบแล้ว</span>
                                <script>
                                    function checkRole() {
                                        var role_name = document.getElementById('inputTypePart').value;
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
                                        xhttp.open('GET', 'action/check_role.php?role_name=' + role_name, true);
                                        xhttp.send();
                                    }

                                    // Add the following code to hide the error message when a specific option is selected
                                    var selectElement = document.getElementById('role_id');
                                    selectElement.addEventListener('change', function() {
                                        var selectedOption = this.value;
                                        if (selectedOption !== "-1") {
                                            document.getElementById('part-type-error').style.display = 'none';
                                        }
                                    });
                                </script>
                            </div>



                            <script>
                                const roleSelect = document.querySelector('#role_id');
                                const newRoleInput = document.querySelector('input[name="new_role_name"]');
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
                        <div class="mb-3">
                            <?php
                            mysqli_query($conn, "SET NAMES 'utf8' ");
                            error_reporting(error_reporting() & ~E_NOTICE);
                            date_default_timezone_set('Asia/Bangkok');

                            $sql_provinces = "SELECT * FROM provinces";
                            $query = mysqli_query($conn, $sql_provinces);

                            ?>
                            <!-- <label for="exampleFormControlTextarea1" class="col-form-label">ที่อยู่ :</label> -->
                            <!-- <textarea class="form-control" name="e_add" id="exampleFormControlTextarea1" rows="3"></textarea> -->
                            <div id="address">
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="sel1">จังหวัด:</label>
                                        <select class="form-control" name="Ref_prov_id" id="provinces" required>
                                            <option value="" selected disabled>กรุณาเลือกจังหวัด</option>
                                            <?php foreach ($query as $value) { ?>
                                                <option value="<?= $value['id'] ?>"><?= $value['name_th'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="sel1">อำเภอ:</label>
                                        <select class="form-control" name="Ref_dist_id" id="amphures" required>
                                            <option value="" selected disabled>กรุณาเลือกอำเภอ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="sel1">ตำบล:</label>
                                        <select class="form-control" name="Ref_subdist_id" id="districts" required>
                                            <option value="" selected disabled>กรุณาเลือกตำบล</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="sel1">รหัสไปรษณีย์:</label>
                                        <input type="text" name="zip_code" id="zip_code" class="form-control" required placeholder="รหัสไปรษณีย์">
                                    </div>
                                </div>
                                <br>

                                <label for="exampleFormControlTextarea1" class="form-label">รายละเอียดที่อยู่</label>
                                <textarea class="form-control auto-expand" name="description" id="exampleFormControlTextarea1" rows="3" required></textarea>

                                <!-- <div class="text-center py-4">
                                    <a class="btn btn-success" name="submit" onclick="validateForm()">ยืนยัน</a>
                                </div> -->
                            </div>
                        </div>
                        <div class="text-center pt-4">
                            <!-- <button type="submit" class="btn btn-success" 
                            onclick="return confirm('Are You Sure You Want to Add This Employee Information?')"
                            >ยืนยัน</button> -->

                            <button type="submit" class="btn btn-success">ยืนยัน</button>
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
    <script>
        var emailAddresses = [
            <?php
            $sql = "SELECT m_email FROM member WHERE del_flg = '0'";
            $result = mysqli_query($conn, $sql);
            $first = true;
            while ($row_c = mysqli_fetch_array($result)) {
                if (!$first) {
                    echo ", ";
                }
                echo "\"" . $row_c['m_email'] . "\"";
                $first = false;
            }
            echo ", ";
            $sql1 = "SELECT e_email FROM employee WHERE del_flg = '0'";
            $result1 = mysqli_query($conn, $sql1);
            $first1 = true;
            while ($row_c = mysqli_fetch_array($result1)) {
                if (!$first1) {
                    echo ", ";
                }
                echo "\"" . $row_c['e_email'] . "\"";
                $first1 = false;
            }
            ?>
        ];

        var TelAddresses = [
            <?php
            $sql = "SELECT m_tel FROM member WHERE del_flg = '0'";
            $result = mysqli_query($conn, $sql);
            $first = true;
            while ($row_c = mysqli_fetch_array($result)) {
                if (!$first) {
                    echo ", ";
                }
                echo "\"" . $row_c['m_tel'] . "\"";
                $first = false;
            }
            echo ", ";
            $sql1 = "SELECT e_tel FROM employee WHERE del_flg = '0'";
            $result1 = mysqli_query($conn, $sql1);
            $first1 = true;
            while ($row_c = mysqli_fetch_array($result1)) {
                if (!$first1) {
                    echo ", ";
                }
                echo "\"" . $row_c['e_tel'] . "\"";
                $first1 = false;
            }
            ?>
        ];

        function checkEmail() {
            var inputElement = document.getElementById('inputPasswordEmail');
            var errorElement = document.getElementById('email-error');
            var inputValue = inputElement.value;

            if (emailAddresses.includes(inputValue)) {
                errorElement.style.display = 'inline';
            } else {
                errorElement.style.display = 'none';
            }
        }

        function checkTel() {
            var inputElement = document.getElementById('inputPasswordTel');
            var errorElement = document.getElementById('tel-error');
            var inputValue = inputElement.value;

            if (TelAddresses.includes(inputValue)) {
                errorElement.style.display = 'inline';
            } else {
                errorElement.style.display = 'none';
            }
        }

        document.getElementById('inputPasswordEmail').addEventListener('keyup', checkEmail);
        document.getElementById('inputPasswordTel').addEventListener('keyup', checkTel);
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inputPassword').on('keyup', function() {
                checkEmail();
            });
        });

        function checkEmail() {
            var email = $('#inputPassword').val();

            $.ajax({
                url: 'action/check_email.php',
                type: 'GET',
                data: {
                    email: email
                },
                success: function(response) {
                    if (response == 'exists') {
                        $('#email-error').css('display', 'block');
                        $('#inputPassword').get(0).setCustomValidity('invalid');
                    } else {
                        $('#email-error').css('display', 'none');
                        $('#inputPassword').get(0).setCustomValidity('');
                    }
                }
            });
        }
    </script>


    <?php include('script.php'); ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
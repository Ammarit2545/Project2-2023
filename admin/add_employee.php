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
                <form action="action/add_employee.php" method="POST">
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">เพิ่มข้อมูลพนักงาน</h1>
                        </div>

                        <div class="mb-3 row">

                            <label for="inputPassword" class="col-sm-1 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" name="e_email" class="form-control" id="inputPassword" onblur="checkEmail()" required>
                                <span id="email-error" style="color:red;display:none;">This email is already registered.</span>
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">Password</label>
                            <div class="col-sm-2">
                                <input type="password" class="form-control" oninput="checkPasswordLength()" onblur="checkPasswordLength()" id="password_name" name="e_password" required>

                                <span id="password-error" style="color: red; font-size: 12px; display: none;">
                                    <button class="btn btn-danger" style="font-size: 12px; padding: -2px">
                                        รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร
                                    </button>
                                </span>
                            </div>

                            <label for="inputConfirmPassword" class="col-sm-1 col-form-label">Confirm Password</label>
                            <div class="col-sm-2">
                                <!-- <input type="password" name="e_confirm_password" class="form-control" id="inputConfirmPassword" oninput="validateConfirmPassword(this)"> -->
                                <input type="password" class="form-control" oninput="checkPasswordLengthAgain()" onblur="checkPasswordLengthAgain()" id="password_con" name="e_confirm_password" required>
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
                                <input type="text" name="e_fname" class="form-control" id="staticEmail">
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">นามสกุล</label>
                            <div class="col-sm-4">
                                <input type="text" name="e_lname" class="form-control" id="inputPassword">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-1 col-form-label">เบอร์โทรศัพท์</label>
                            <div class="col-sm-4">
                                <input type="text" name="e_tel" class="form-control" id="inputPassword">
                            </div>
                            <label for="inputPassword" class="col-sm-1 col-form-label">เงินเดือน</label>
                            <div class="col-sm-4">
                                <input type="text" name="e_salary" class="form-control" id="inputPassword">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-1 col-form-label">ตำแหน่ง</label>
                            <div class="col-sm-4">
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
                            <label for="exampleFormControlTextarea1" class="col-form-label">ที่อยู่ :</label>
                            <textarea class="form-control" name="e_add" id="exampleFormControlTextarea1" rows="3"></textarea>
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
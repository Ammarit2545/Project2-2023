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

                $p_type_id = $_GET['id'];
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <form id="form" action="action/add_stock_part.php" method="POST">
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">เพิ่มอะไหล่ในสต๊อก</h1>
                        </div>

                        <?php

                        $sql = "SELECT * FROM parts_type WHERE del_flg = '0' AND p_type_id = '$p_type_id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        ?>
                        <!-- <p style="color:red">*** ข้อมูลเดิม "<?= $row['p_type_name'] ?>" ***</p> -->
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">รหัสอะไหล่</label>

                            <div class="col-sm-4">
                                <!-- <label for="basic-url" class="form-label">รหัสสมาชิก</label> -->
                                <input type="text" name="p_brand" class="form-control" id="brandInput" onclick="openModal('brandInput')" placeholder="ค้นหาอะไหล่">
                                <input type="text" name="p_id" class="form-control" id="idInput" onclick="openModal('idInput')" placeholder="ค้นหาอะไหล่">
                                <div id="myModal" class="modal">
                                    <div class="modal-overlay" id="myModal">
                                        <div class="modal-content">
                                            <button class="close-button" onclick="closeModal()">&times;</button>
                                            <label for="tel">รายการอะไหล่ <p style="color: red; display: inline;">*ส่งค่าเป็นรหัสอะไหล่</p></label>
                                            <input type="text" id="searchInput" oninput="searchFunction()" placeholder="Search...">
                                            <ul id="myList"></ul>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $sql1 = "SELECT * FROM parts WHERE del_flg = 0";
                                $result1 = mysqli_query($conn, $sql1);
                                $data = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                                ?>

                                <script>
                                    var brandInput = document.getElementById("brandInput");
                                    var idInput = document.getElementById("idInput");
                                    var modal = document.getElementById("myModal");
                                    var searchInput = document.getElementById("searchInput");
                                    var myList = document.getElementById("myList");
                                    var data = <?php echo json_encode($data); ?>;

                                    function openModal(inputId) {
                                        modal.style.display = "block";
                                        searchInput.value = "";
                                        populateList(data);
                                        searchInput.focus();
                                        if (inputId === "brandInput") {
                                            searchInput.setAttribute("data-target", "brandInput");
                                        } else if (inputId === "idInput") {
                                            searchInput.setAttribute("data-target", "idInput");
                                        }
                                    }

                                    function closeModal() {
                                        modal.style.display = "none";
                                    }

                                    function selectItem(event) {
                                        var selectedValue = event.target.textContent;
                                        var m_id = selectedValue.split(" - ")[0]; // Extract m_id from the selected value
                                        var p_brand = selectedValue.split(" - ")[1]; // Extract p_brand from the selected value
                                        var targetInput = searchInput.getAttribute("data-target");
                                        if (targetInput === "brandInput") {
                                            brandInput.value = p_brand;
                                            brandInput.placeholder = p_brand;
                                            idInput.value = m_id;
                                        } else if (targetInput === "idInput") {
                                            idInput.value = m_id;
                                            idInput.placeholder = p_brand;
                                            brandInput.value = p_brand;
                                        }
                                        closeModal();
                                    }

                                    function populateList(items) {
                                        myList.innerHTML = "";

                                        for (var i = 0; i < items.length; i++) {
                                            var li = document.createElement("li");
                                            li.textContent = items[i].p_id + " - " + items[i].p_brand + " " + items[i].p_model;
                                            li.addEventListener("click", selectItem);
                                            myList.appendChild(li);
                                        }
                                    }

                                    function searchFunction() {
                                        var searchTerm = searchInput.value.toLowerCase();
                                        var filteredData = data.filter(function(item) {
                                            var fullName = item.p_brand.toLowerCase() + " " + item.p_model.toLowerCase();
                                            return (
                                                item.p_id.toString().includes(searchTerm) ||
                                                fullName.includes(searchTerm)
                                            );
                                        });
                                        populateList(filteredData);
                                    }
                                </script>
                            </div>

                            <label for="staticEmail" class="col-sm-1 col-form-label">ชื่อประเภท</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="unit" id="unitInput" placeholder="กรุณากรอกจำนวนที่ต้องการเพิ่ม">
                                <span id="errorSpan" style="color: red; display: none;">ค่าต้องไม่น้อยกว่า 0</span>

                                <script>
                                    var unitInput = document.getElementById("unitInput");
                                    var errorSpan = document.getElementById("errorSpan");
                                    var form = document.querySelector("form"); // Replace "form" with the ID or class of your form

                                    form.addEventListener("submit", function(event) {
                                        var unitValue = unitInput.value;
                                        if (unitValue < 0) {
                                            unitInput.classList.add("is-invalid");
                                            errorSpan.style.display = "block";
                                            event.preventDefault(); // Prevent form submission
                                        }
                                    });

                                    unitInput.addEventListener("input", validateUnit);

                                    function validateUnit() {
                                        var unitValue = unitInput.value;
                                        if (unitValue < 0) {
                                            unitInput.classList.add("is-invalid");
                                            errorSpan.style.display = "block";
                                        } else {
                                            unitInput.classList.remove("is-invalid");
                                            errorSpan.style.display = "none";
                                        }
                                    }
                                </script>

                                <!-- <input type="text" class="form-control" name="p_type_id" id="staticEmail" value="<?= $row['p_type_id'] ?>" placeholder="กรุณากรอกข้อมูล" hidden> -->
                                <span id="part-type-error" style="color:red;display:none;">This Part Type is already exit.</span>
                                <script>
                                    function checkPartType() {
                                        var p_type = document.getElementById('inputPartType').value;
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
                                        xhttp.open('GET', 'action/check_type_part.php?p_type=' + p_type, true);
                                        xhttp.send();
                                    }
                                </script>
                            </div>

                        </div>

                    </div>
                    <div class="text-center pt-4">
                        <a href="edit_stock.php" class="btn btn-danger" onclick="return showCancellation()">ยกเลิก</a>

                        <!-- Example CDNs, use appropriate versions and sources -->
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


                        <button class="btn btn-success" onclick="return showConfirmation()">ยืนยัน</button>




                    </div>

            </div>
            </form>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <!-- <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2020</span>
                </div>
            </div>
        </footer> -->
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
    <?php
    include('bar/admin_footer.php');
    ?>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Example CDNs, use appropriate versions and sources -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script>
        function showCancellation() {
            Swal.fire({
                title: "คุณต้องการยกเลิกการแก้ไขหรือไม่",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "ยกเลิก",
                cancelButtonText: "ย้อนกลับ",
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = "edit_stock.php"; // Redirect to the cancellation page
                }
            });

            return false; // Prevent default link behavior
        }

        function showConfirmation() {
            Swal.fire({
                title: "Are You Sure?",
                text: "You want to edit this Parts Type information.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
            }).then(function(result) {
                if (result.isConfirmed) {
                    // User confirmed, proceed with form submission
           
                    document.getElementById('form').submit();
                }
            });

            return false; // Prevent default link behavior
        }
    </script>

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
    <!-- Sweet Alert Show Start -->
    <?php
    if (isset($_SESSION['add_data_alert'])) {
        if ($_SESSION['add_data_alert'] == 0) {
            $id = 123; // Replace 123 with the actual ID you want to pass to the deletion action
    ?>
            <script>
                Swal.fire({
                    title: 'ข้อมูลของคุณได้ถูกบันทึกแล้ว',
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
                    title: 'ข้อมูลของคุณไม่ได้ถูกบันทึก',
                    text: 'กด Accept เพื่อออก',
                    icon: 'error',
                    confirmButtonText: 'Accept'
                });
            </script>

        <?php
            unset($_SESSION['add_data_alert']);
        } else if ($_SESSION['add_data_alert'] == 2) {
        ?>
            <script>
                Swal.fire({
                    title: 'ข้อมูลของคุณได้ถูกลบแล้ว',
                    text: 'กด Accept เพื่อออก',
                    icon: 'success',
                    confirmButtonText: 'Accept'
                });
            </script>
    <?php unset($_SESSION['add_data_alert']);
        }
    }
    ?>
    <!-- Sweet Alert Show End -->


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
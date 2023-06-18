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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Page - Create Auto Create Serial Number</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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


                <h1 class="pt-5 text-center">บันทึกคำสั่งซื้อ</h1>
                <center>
                    <p>บันทึกการซ่อมด้วยตัวเอง สินค้าที่เสียหายจะต้องซ่อมเสร็จสิ้นแล้วเท่านั้น</p>
                </center>
                <br>
                <form id="self_newserialnumber" action="action/add_self_newequipment.php" method="POST" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="tel">ชื่อยี่ห้อ</label>
                                        <input type="text" class="form-control input" id="borderinput" name="name_brand" placeholder="กรุณากรอก ชื่อยี่ห้อ" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="tel">เลข Serial Number</label>
                                        <!-- <input type="text" class="form-control input" id="borderinput" name="serial_number" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)"> -->
                                        <input type="text" name="serial_number" value="" placeholder="กรุณากรอก หมายเลข Serial Number (ไม่จำเป็น)" class="form-control" id="inputPassword" onblur="CheckSerial()" required>                                       
                                        <span id="serial-error" style="color:red;display:none;">อุปกรณ์หมดระยะประกันแล้ว</span>
                                        <!-- exits -->
                                        <span id="serial-error-ok" style="color:blue;display:none;">อุปกรณ์นี้ยังอยู่ในระยะประกัน</span>
                                        <!-- else -->
                                        <span id="serial-error-none" style="color:green;display:none;">หมายเลข Serial Number นี้สามารถใช้งานได้</span>
                                        <!-- exits ok-->
                                        <span id="serial-error-have" style="color:red;display:none;">อุปกรณ์นี้อยู่ระหว่างการซ่อมของคุณ</span>
                                        <!-- exits have-->
                                        <span id="serial-error-none-2" style="color:green;display:none;">หมายเลข Serial Number นี้สามารถใช้งานได้</span>
                                        <!-- none -->
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
                                                            document.getElementById('serial-error-none-2').style.display = 'none';
                                                            document.getElementById('inputPassword').setCustomValidity('');
                                                        } else if (this.responseText == 'exists-ok') {
                                                            document.getElementById('serial-error').style.display = 'none';
                                                            document.getElementById('serial-error-ok').style.display = 'none';
                                                            document.getElementById('serial-error-none').style.display = 'block';
                                                            document.getElementById('serial-error-have').style.display = 'none';
                                                            document.getElementById('serial-error-none-2').style.display = 'none';
                                                            document.getElementById('inputPassword').setCustomValidity('');
                                                        } else if (this.responseText == 'exists-have') {
                                                            document.getElementById('serial-error').style.display = 'none';
                                                            document.getElementById('serial-error-ok').style.display = 'none';
                                                            document.getElementById('serial-error-none').style.display = 'none';
                                                            document.getElementById('serial-error-have').style.display = 'block';
                                                            document.getElementById('serial-error-none-2').style.display = 'none';
                                                            document.getElementById('inputPassword').setCustomValidity('');
                                                        } else if (this.responseText == 'exists-have-guarantee') {
                                                            document.getElementById('serial-error').style.display = 'none';
                                                            document.getElementById('serial-error-ok').style.display = 'block';
                                                            document.getElementById('serial-error-none').style.display = 'none';
                                                            document.getElementById('serial-error-have').style.display = 'none';
                                                            document.getElementById('serial-error-none-2').style.display = 'none';
                                                            document.getElementById('inputPassword').setCustomValidity('');
                                                        } else {
                                                            document.getElementById('serial-error').style.display = 'none';
                                                            document.getElementById('serial-error-ok').style.display = 'none';
                                                            document.getElementById('serial-error-none').style.display = 'none';
                                                            document.getElementById('serial-error-have').style.display = 'none';
                                                            document.getElementById('serial-error-none-2').style.display = 'block';
                                                            document.getElementById('inputPassword').setCustomValidity('');
                                                        }
                                                    }
                                                };
                                                xhttp.open('GET', 'action/check_serial_number.php?serial=' + serial, true);
                                                xhttp.send();
                                            }
                                        </script>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding-top: 2rem;">
                                            <button type="button" class="btn btn-primary" onclick="generateSerialNumber()">สุ่มตัวเลข</button>
                                        </div>
                                    </div>
                                    <script>
                                        function generateSerialNumber() {
                                            var randomDigits = Math.floor(Math.random() * 1000000).toString().padStart(6, '0');
                                            var serialNumber = "ANE" + randomDigits;
                                            document.getElementById('inputPassword').value = serialNumber;
                                            CheckSerial();
                                        }
                                    </script>
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
                                <!-- <div class="col-6" style="padding-right: 0px;padding-left: 0px;">
                                    <label for="tel">วันที่ซื้อ</label>
                                    <input type="text" class="form-control input" id="borderinput" name="number_model" placeholder="กรุณากรอก หมายเลขรุ่น  (ไม่จำเป็น)">
                                </div> -->
                                <hr>
                                <div class="row">

                                    <div class="col-4">
                                        <label for="tel">ชื่อบริษัท <p style="color : red; display : inline">*กรณีมีประกันกับทางร้าน</p></label>
                                        <br>
                                        <select class="form-select" aria-label="Default select example" name="company">
                                            <option value="0">กรุณาเลือกบริษัท</option>
                                            <?php
                                            $sql_c = "SELECT * FROM company WHERE del_flg = '0'";
                                            $result_c = mysqli_query($conn, $sql_c);
                                            while ($row_c = mysqli_fetch_array($result_c)) {
                                            ?><option value="<?= $row_c['com_id'] ?>"><?= $row_c['com_name'] ?></option>
                                            <?php  }  ?>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label for="tel">ระยะประกัน</label>
                                        <input type="text" name="guarantee" class="form-control" id="" placeholder="กรุณากรอกระยะประกัน">
                                    </div>


                                    <div class="col-4">
                                        <label for="basic-url" class="form-label">รหัสสมาชิก</label>
                                        <input type="text" name="m_id" class="form-control" id="myInput" onclick="openModal()" placeholder="ค้นหาข้อมูลสมาชิก">
                                        <div id="myModal" class="modal">
                                            <div class="modal-overlay" id="myModal">
                                                <div class="modal-content">
                                                    <button class="close-button" onclick="closeModal()">&times;</button>
                                                    <label for="tel">รายชื่อสมาชิก <p style="color: red; display: inline;">*ส่งค่าเป็นรหัส ID สมาชิก</p></label>
                                                    <input type="text" id="searchInput" oninput="searchFunction()" placeholder="Search...">
                                                    <ul id="myList"></ul>
                                                </div>
                                            </div>


                                        </div>
                                        <?php
                                        $sql1 = "SELECT * FROM member WHERE del_flg = 0";
                                        $result1 = mysqli_query($conn, $sql1);
                                        $data = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                                        ?>

                                        <script>
                                            var input = document.getElementById("myInput");
                                            var modal = document.getElementById("myModal");
                                            var searchInput = document.getElementById("searchInput");
                                            var myList = document.getElementById("myList");
                                            var data = <?php echo json_encode($data); ?>;

                                            function openModal() {
                                                modal.style.display = "block";
                                                searchInput.value = "";
                                                populateList(data);
                                                searchInput.focus();
                                            }

                                            function closeModal() {
                                                modal.style.display = "none";
                                            }

                                            function selectItem(event) {
                                                var selectedValue = event.target.textContent;
                                                var option = document.createElement("option");
                                                option.value = selectedValue.split(" - ")[0]; // Extract m_id from the selected value
                                                option.textContent = selectedValue;
                                                option.selected = true;
                                                input.appendChild(option);
                                                closeModal();
                                            }


                                            function populateList(items) {
                                                myList.innerHTML = "";

                                                // Create the default option element
                                                var defaultOption = document.createElement("option");
                                                defaultOption.value = "0";
                                                defaultOption.textContent = " 0 - ไม่มี";
                                                defaultOption.selected = true;
                                                myList.appendChild(defaultOption);

                                                for (var i = 0; i < items.length; i++) {
                                                    var li = document.createElement("li");
                                                    li.textContent = items[i].m_id + " - " + items[i].m_fname + " " + items[i].m_lname; // Display m_id, first name, and last name
                                                    li.addEventListener("click", selectItem);
                                                    myList.appendChild(li);
                                                }
                                            }


                                            function searchFunction() {
                                                var searchTerm = searchInput.value.toLowerCase();
                                                var filteredData = data.filter(function(item) {
                                                    var fullName = item.m_fname.toLowerCase() + " " + item.m_lname.toLowerCase(); // Concatenate first name and last name
                                                    return (
                                                        item.m_id.toString().includes(searchTerm) || // Check if m_id includes the search term
                                                        fullName.includes(searchTerm) // Check if the full name includes the search term
                                                    );
                                                });
                                                populateList(filteredData);
                                            }

                                            function selectItem(event) {
                                                var selectedValue = event.target.textContent;
                                                var m_id = selectedValue.split(" - ")[0]; // Extract m_id from the selected value
                                                input.value = m_id;
                                                closeModal();
                                            }
                                        </script>

                                    </div>
                                </div>
                                <hr>
                                <!-- <label for="borderinput1" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ</label>
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
                                </script> -->
                                <!-- <div class="row">
                                    <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                                    <textarea class="form-control" id="inputtext" rows="3" name="description" required placeholder="กรุณากรอกรายละเอียด"></textarea>
                                </div> -->
                                <div class="row">
                                    <div class="text-center pt-4 mx-auto">
                                        <center>
                                            <a class="btn btn-success" value="Upload Image" name="submit" onclick="showConfirmation()">ยืนยัน</a>

                                            <script>
                                                function showConfirmation() {
                                                    Swal.fire({
                                                        title: "ยืนยันการส่งข้อมูล",
                                                        text: "คุณต้องการที่จะยืนยันการส่งข้อมูลหรือไม่?",
                                                        icon: "question",
                                                        showCancelButton: true,
                                                        confirmButtonColor: "#3085d6",
                                                        cancelButtonColor: "#d33",
                                                        confirmButtonText: "ใช่, ยืนยัน!",
                                                        cancelButtonText: "ยกเลิก"
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // User confirmed, proceed with form submission
                                                            document.getElementById("self_newserialnumber").submit();
                                                        }
                                                    });
                                                }
                                            </script>

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
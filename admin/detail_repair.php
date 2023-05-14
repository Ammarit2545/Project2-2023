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

    <title>Repair Information - Anan Electronic</title>
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
                <div class="container-fluid">
                    <?php
                    $get_r_id = $_GET['id'];

                    $sql = "SELECT * FROM get_repair
                    LEFT JOIN repair ON repair.r_id = get_repair.r_id 
                    LEFT JOIN member ON member.m_id = repair.m_id
                    WHERE get_repair.del_flg = '0' AND get_r_id = '$get_r_id'";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_array($result);

                    $dateString = date('d-m-Y', strtotime($row['get_r_date_in']));
                    $date = DateTime::createFromFormat('d-m-Y', $dateString);
                    $formattedDate = $date->format('F / d / Y');
                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="m-0 font-weight-bold text-primary">Serial Number : <?= $row['r_serial_number'] ?></h1>
                            <h2 style="color: #f6c23e;">สถานะ : ส่งเรื่อง (เคลม)</h2>
                            <h6><?= $formattedDate ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <h6 for="staticEmail" class="col-sm-1 col-form-label">ชื่อ</h6>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="staticEmail" value="<?= $row['m_fname']  ?>" placeholder="สวย" disabled>
                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">นามสกุล</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" value="<?= $row['m_lname']  ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-1 col-form-label">Brand :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" value="<?= $row['r_brand']  ?>"  placeholder="Yamaha" disabled="disabled">
                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">Model :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" value="<?= $row['r_model']  ?>" placeholder="NPX8859" disabled="disabled">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-1 col-form-label">เบอร์โทรศัพท์</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" placeholder="000000000"  value="<?= $row['get_tel']  ?>" disabled="disabled">
                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">บริษัท</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" placeholder="ไทยคมนาคม" value="<?php
                                     if($row['com_id'] == NULL){
                                        echo "ไม่มีข้อมูล";
                                     } else{
                                        $com_id = $row['com_id'];
                                        $sql_com = "SELECT * FROM company WHERE com_id = '$com_id'";
                                        $result_com = mysqli_query($conn,$sql_com);
                                        $row_com = mysqli_fetch_array($result_com);

                                        echo $row_com['com_name'];
                                     }
                                     ?>"   disabled="disabled">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="col-form-label">ที่อยู่ :</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?php
                                if ($row['get_add'] == NULL){
                                    echo "ไม่มีข้อมูล";
                                }else{
                                    echo ($row['get_add']);
                                }
                                ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="col-form-label">รายละเอียด :</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?= $row['get_r_detail']  ?></textarea>
                            </div>
                            <div class="card-footer">
                                <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ</h1>
                                <div class="mb-3 pt-3">
                                    <label for="exampleFormControlInput1" class="form-label">หัวข้อ</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">สถานะ</label>&nbsp;&nbsp;
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>เลือกสถานะ</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด :</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <h6>อะไหร่</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Default checkbox
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Checked checkbox
                                        </label>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <input type="file" id="upload" hidden multiple>
                                    <h6>เพิ่มรูป</h6>
                                    <label for="upload" style="display: block; color: blue;">Choose file</label>
                                    <div id="image-container"></div>
                                </div>
                                <div class="mb-3 ">
                                    <label for="exampleFormControlInput1" class="form-label">รวมราคาอะไหร่</label>
                                    <input type="text" class="form-control col-1" id="exampleFormControlInput1">
                                </div>
                                <div class="mb-3 ">
                                    <label for="exampleFormControlInput1" class="form-label">ค่าแรงช่าง</label>
                                    <input type="text" class="form-control col-1" id="exampleFormControlInput1">
                                </div>
                                <div class="mb-3 ">
                                    <label for="exampleFormControlInput1" class="form-label">ราคารวม</label>
                                    <input type="text" class="form-control col-1" id="exampleFormControlInput1">
                                </div>
                            </div>
                            <div class="text-center pt-4">
                                <button type="button" class="btn btn-success">ตอบกลับ</button>
                            </div>
                        </div>
                    </div>



                </div>
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
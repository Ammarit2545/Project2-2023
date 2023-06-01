<?php
session_start();
include('database/condb.php');

if (!isset($_SESSION['id'])) {
    header('Location:home.php');
}
$get_id = $_GET['id'];

if (isset($_GET['get_add'])) {
    if ($_GET['get_add'] > 0) {
        $total = $_GET['get_add'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/all_page.css">

    <title>View Part - Edit Employee Information</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.min.css">


</head>

<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Page Heading -->
                        <!-- <br> -->
                        <!-- <h1 style="display:inline-block">ข้อมูลอะไหล่ของคุณ</h1> -->
                        <br>
                        <h4 class="alert alert-primary" role="alert">หมายเลขส่งซ่อมที่ : <?= $get_id ?></h4>
                        <!-- <a href="add_parts.php" style="display:inline-block; margin-left: 10px; position :relative">คุณต้องการเพิ่มอะไหล่หรือไม่?</a> -->
                        <!-- <br> -->
                        <br>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">ข้อมูลอะไหล่เครื่องเสียง</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ชื่อ</th>
                                                <th>Brand</th>
                                                <th>Model</th>
                                                <!-- <th>Name</th> -->
                                                <th>ประเภท</th>
                                                <!-- <th>รายละเอียด</th> -->
                                                <th>ราคา</th>
                                                <th>จำนวน</th>
                                                <th>ราคารวม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT
                                        repair_detail.p_id,
                                        COUNT(repair_detail.p_id) AS count,
                                        parts.p_brand,
                                        parts.p_model,
                                        parts.p_price,
                                        parts_type.p_type_name,
                                        repair_status.rs_id,
                                        parts.p_pic
                                      FROM
                                        `repair_detail`
                                        LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                                        LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
                                        JOIN parts ON parts.p_id = repair_detail.p_id
                                        LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id
                                      WHERE
                                        get_repair.del_flg = 0 AND repair_detail.del_flg = 0
                                        AND get_repair.get_r_id = '$get_id'
                                      GROUP BY
                                        p_id;
                                        ";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $p_id = $row['p_id'];
                                                $rs_id = $row['rs_id'];
                                                $sql_count = "SELECT * FROM repair_detail WHERE rs_id = '$rs_id' AND p_id = '$p_id'";
                                                $result_count = mysqli_query($conn, $sql_count);
                                                $row_count = mysqli_fetch_array($result_count);

                                            ?>
                                                <tr>
                                                    <td><?php
                                                        if ($row['p_id'] == NULL) {
                                                            echo "-";
                                                        } else {
                                                            echo $row['p_id'];
                                                        }
                                                        ?>
                                                    </td>

                                                    <td><?php
                                                        if ($row['p_pic'] == NULL) {
                                                            echo "-";
                                                        } else {
                                                        ?>
                                                            <img src="<?= $row['p_pic'] ?>" width="50px" alt="Not Found">
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>


                                                    <!-- <td><?php
                                                                if ($row['p_name'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo $row['p_name'];
                                                                }
                                                                ?>
                                                </td> -->
                                                    <td><?php
                                                        if ($row['p_brand'] == NULL) {
                                                            echo "-";
                                                        } else {
                                                            echo $row['p_brand'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                        if ($row['p_model'] == NULL) {
                                                            echo "-";
                                                        } else {
                                                            echo $row['p_model'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                        if ($row['p_type_name'] == NULL) {
                                                            echo "-";
                                                        } else {
                                                            echo $row['p_type_name'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <!-- <td><?php
                                                                if ($row['p_detail'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                ?>
                                                        <p><?= substr($row['p_detail'], 0, 50) . '...' ?></p>
                                                    <?php
                                                                }
                                                    ?>
                                                </td> -->

                                                    <td><?php
                                                        if ($row['p_price'] == NULL) {
                                                            echo "-";
                                                        } else {
                                                            echo $row['p_price'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                        if ($row_count['rd_value_parts'] == NULL) {
                                                            echo "-";
                                                        } else {
                                                            echo $row_count['rd_value_parts'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <!-- <?php
                                                            if (isset($_GET['get_add'])) {
                                                                if ($_GET['get_add'] > 0) {
                                                                    $total = $_GET['get_add'];
                                                                }
                                                            }
                                                            ?> -->
                                                    <td>
                                                        <?php
                                                        if ($row_count['rd_value_parts'] == NULL) {
                                                            echo "-";
                                                        } else {
                                                            echo number_format($row_count['rd_value_parts'] * $row['p_price']);
                                                            $total += $row_count['rd_value_parts'] * $row['p_price'];
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="5">ยอดอะไหล่ทั้งหมด</td>
                                                <td colspan="2">ราคารวม</td>
                                                <td><?= number_format($total) ?></td>
                                                <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                            </tr>
                                            <tr>
                                                <?php
                                                $sql_w = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                $result_w = mysqli_query($conn, $sql_w);
                                                $row_w = mysqli_fetch_array($result_w);
                                                ?>
                                                <td colspan="5">ค่าแรงช่าง</td>
                                                <td colspan="2">ค่าแรง</td>
                                                <td><?= number_format($row_w['get_wages']) ?></td>
                                                <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                            </tr>
                                            <?php if (isset($_GET['get_add'])) {
                                            ?>
                                                <tr>
                                                    <td colspan="5">ค่าจัดส่งอุปกรณ์ <span style="color : blue">(ไปรษณีย์ไทยแบบลงทะเบียน)</span></td>
                                                    <td colspan="2">ค่าจัดส่งอุปกรณ์</td>
                                                    <td><?= number_format($_GET['get_add']) ?></td>
                                                    <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                </tr>
                                            <?php
                                            } ?>

                                            <tr>
                                                <td colspan="5"></td>
                                                <td colspan="2">ราคารวมทั้งหมด</td>
                                                <td>
                                                    <h5><?= number_format($total + $row_w['get_wages']) ?> </h5>
                                                </td>
                                                <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- <img src="img/kbank-icon.png" alt="kbank" width="50px" style="border-radius:10%"><p style="display:inline">บัญชีธนาคารกสิกร : 0254859696</p>
                            <br> -->
                        <center>
                            <hr>
                            <br>
                            <img src="img/kbank-icon.png" alt="kbank" width="50px" style="border-radius:10%">
                            <h4 style="display:inline; margin-left:15px">บัญชีธนาคารกสิกร : <span style="color:green">0254859696</span></h4>
                            <br>
                            <br>
                            <hr>
                            <br>
                            <h5>*** หากชำระเงินแล้วให้ท่านกลับไปหน้า <span style="color: blue;">สถานะ</span> และแนบสลิปเพื่อเป็น<span style="color: red;"> หลักฐานในการโอนเงิน</span> ***</h5>
                            <br>
                            <!-- <a class="btn btn-danger">ไม่ทำการยืนยัน</a>
                            
                            <a class="btn btn-success" id="confirmButton">ยืนยัน</a> -->

                            <!-- <a class="btn btn-danger">ไม่ทำการยืนยัน</a>
                    <a class="btn btn-success" id="confirmButton">ยืนยัน</a>  -->
                        </center>

                        <!-- <h4>บัญชีธนาคารกสิกร : 0254589658 </h4>
                        <h4>บัญชีธนาคารกสิกร : 0254589658 </h4>
                        <h4>บัญชีธนาคารกสิกร : 0254589658 </h4> -->
                    </div>
                </div>
            </div>
            <br><br><br>
            <div class="col-4">
                <div class="card shadow">
                    <div class="card-body">

                        <center>

                            <img src="img/promtpay.png" alt="PromptPay" width="200px">
                            <h5>หมายเลข Promtpay : 0957655647</h5>
                        </center>
                        <br>
                        <?php
                        $price = $_GET['total'];
                        require_once("lib/PromptPayQR.php");

                        $PromptPayQR = new PromptPayQR(); // new object
                        $PromptPayQR->size = 8; // Set QR code size to 8
                        $PromptPayQR->id = '0957655647'; // PromptPay ID
                        $PromptPayQR->amount = $total + $row_w['get_wages']; // Set amount (not necessary)
                        echo '<center><img src="' . $PromptPayQR->generate() . '" /></center>';
                        ?>
                        <br>
                        <br>
                        <center>
                            <h3>ชื่อ : อมฤต โชติทินวัฒน์</h3>
                            <br>
                            <h2>ราคารวม : <?= number_format($total + $row_w['get_wages']) ?> บาท</h2>
                        </center>
                        <br>
                        <center>
                            <div class="alert alert-secondary" role="alert">
                                <h5>หากจ่ายแล้วกรุณาแนบสลิปและกดปุ่ม <h4 style="color: blue">"ชำระเงินแล้ว"</h4> เพื่อยืนยันให้ทางเจ้าหน้าที่ตรวจสอบ</h5>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Place this in the <head> section of your HTML document -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Place this before the closing </body> tag -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('confirmButton').addEventListener('click', function() {
                Swal.fire({
                    icon: 'question',
                    title: 'ยืนยันการดำเนินการ',
                    text: 'การ "ยืนยัน" จะไม่สามารถกลับมาแก้ไขข้อมูลได้?',
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((willConfirm) => {
                    if (willConfirm.isConfirmed) {
                        window.location.href = "action/conf_part.php?id=<?= $get_id ?>"; // Redirect to home.php
                    }
                });
            });
        });
    </script>

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
    <br>
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
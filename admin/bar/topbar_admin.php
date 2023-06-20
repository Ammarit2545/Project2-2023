<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search
<form
    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
            aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form> -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">

            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!-- <img src="../img brand/anelogo.jpg" style="width : 2%" alt="">   -->
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <?php
                $sql_nofi = "SELECT get_repair.get_r_id, get_detail.get_d_id, repair.r_id, COUNT(*) as count
                FROM get_repair
                LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id
                LEFT JOIN repair ON get_detail.r_id = repair.r_id
                WHERE get_repair.del_flg = '0' AND repair.del_flg = '0'
                GROUP BY get_repair.get_r_id, get_detail.get_d_id, repair.r_id
                ORDER BY get_repair.get_r_id DESC
                LIMIT 3;";

                $result_nofi = mysqli_query($conn, $sql_nofi);

                $sql_nofi_count = "SELECT COUNT(get_repair.get_r_id) FROM repair_status
                LEFT JOIN get_repair ON get_repair.get_r_id = repair_status.get_r_id 
                WHERE get_repair.del_flg = '0' AND repair_status.status_id = 1;";
                $result_nofi_count = mysqli_query($conn, $sql_nofi_count);
                $num_rows = mysqli_fetch_array($result_nofi_count);
                ?>
                <span class="badge badge-danger badge-counter"><?= $num_rows[0] - 1 ?>+</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>

                <?php


                while ($row_nofi = mysqli_fetch_array($result_nofi)) {
                    $dateString = date('d-m-Y', strtotime($row_nofi['get_r_date_in']));
                    $date = DateTime::createFromFormat('d-m-Y', $dateString);
                    $formattedDate = $date->format('F / d / Y');
                ?>
                    <a class="dropdown-item d-flex align-items-center" href="detail_repair.php?id=<?= $row_nofi['get_r_id'] ?>">
                        <div>

                            <div class="small text-gray-500"><?= $formattedDate ?></div>
                            <p class="font-weight-bold">หมายเลขแจ้งซ่อม : <button class="btn btn-primary" style="font-size: 15px;"><?= $row_nofi['get_r_id'] ?></button></p>
                            <p class="font-weight-bold">Brand : <?= $row_nofi['r_brand'] ?> , Model : <?= $row_nofi['r_model'] ?></p>
                            <span class="font-weight-bold" style="font-size : 12px"><?= $row_nofi['get_r_detail'] ?></span> <br />

                            <!-- <span class="font-weight-bold">ส่งซ่อม</span> -->

                        </div>
                    </a>
                <?php
                }
                ?>

                <!-- <a class="dropdown-item d-flex align-items-center" href="detail_repair.html">
                    <div class="mr-3">
                    <div class="icon-circle bg-success">
                        <i class="fas fa-donate text-white"></i>
                    </div>
                </div> -->
                <!-- <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        <span class="font-weight-bold">Garrett Winters</span> <br />
                        <span class="font-weight-bold">ปฏิเสธการส่งซ่อม</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="detail_repair.html"> -->
                <!-- <div class="mr-3">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                </div> -->
                <!-- <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        <span class="font-weight-bold">Paul Byrd</span> <br />
                        <span class="font-weight-bold">ชำระเงินแล้ว</span>
                    </div>
                </a>  -->
                <a class="dropdown-item text-center small text-gray-500" href="listview_nofi.php">Show All Alerts</a>
            </div>
        </li>

        <!-- Nav Item - Messages -->


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">

            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">


                <!-- <img src="../img brand/anelogo.jpg" style="margin-top : 10% ;  width : 2%" alt="">  -->

                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION["fname"] . " " . $_SESSION["lname"]  ?></span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="edit_employee.php" data-toggle="" data-target="#logoutModal">
                    <i class="fas fa-solid fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    แก้ไขข้อมูล
                </a>

                <a class="dropdown-item" href="../action/logout.php" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

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
                <a class="btn btn-primary" href="../action/logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>


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
<style>
    body {
        opacity: 0;
        background-color: white;
        transition: opacity 1s ease-in;
    }

    body.loaded {
        opacity: 1;
    }
</style>

<!-- Your page content here -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Fade in when the page loads
    window.addEventListener("load", function() {
        document.body.classList.add("loaded");
    });

    // Fade out when the page is being closed
    window.addEventListener("beforeunload", function() {
        document.body.style.transition = "opacity 0.25s ease-out";
        document.body.style.opacity = "0";
    });
</script>
<link rel="stylesheet" href="styles.css">
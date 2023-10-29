<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <img src="../img brand/anelogo.jpg" style="width : 30%; border-radius : 20%;" alt="">
        <div class="sidebar-brand-text mx-3" style="font-size: 70%;">Admin Anan Electronic</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        การแจ้งเตือน
    </div>

    <!-- Nav Item - employee Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-solid fa-envelope"></i>
            <span>การแจ้งเตือนการซ่อม</span>
        </a>
        <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">รายละเอียด :</h6>
                <a class="collapse-item" href="listview_repair.php">รายการแจ้งซ่อม</a>
            </div>
        </div>
    </li> -->
    <li class="nav-item">
        <a class="nav-link" href="listview_repair.php">
            <i class="fas fa-solid fa-envelope"></i>
            <span>รายการแจ้งซ่อม</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="search_repair.php">
            <i class="fa fa-search"></i>
            <span>ค้นหาอุปกรณ์</span></a>
    </li>
    <br>

    <div class="sidebar-heading">
        ข้อมูลทั่วไป
    </div>
    <?php
    if ($_SESSION['role_id'] == 1) {
    ?> <!-- Nav Item - employee Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-solid fa-users"></i>
                <span>พนักงาน</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">รายละเอียด :</h6>
                    <a class="collapse-item" href="employee_listview.php"><i class="fa fa-address-card"></i> ข้อมูลพนักงาน</a>
                    <a class="collapse-item" href="add_employee.php"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล</a>
                    <a class="collapse-item" href="log_employee.php"><i class="	fa fa-calendar-check"></i> ข้อมูลการ เข้า-ออก ระบบ</a>
                    <hr>
                    <h6 class="collapse-header">แผนกพนักงาน :</h6>
                    <a class="collapse-item" href="add_em_type.php"><i class="	fa fa-cubes"></i> แผนก</a>
                </div>
            </div>
        </li><?php
            }
                ?>
    <?php
    if ($_SESSION['role_id'] == 1) {
    ?>
        <!-- Nav Item - customer Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecustomer" aria-expanded="true" aria-controls="collapsecustomer">
                <i class="fas fa-user"></i>
                <span>สมาชิก</span>
            </a>
            <div id="collapsecustomer" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">รายละเอียด :</h6>
                    <a class="collapse-item" href="listview_member.php"><i class="fa fa-address-card"></i> ข้อมูลลูกค้า</a>
                    <a class="collapse-item" href="log_member.php"><i class="fa fa-calendar-check"></i> ข้อมูลการ เข้า-ออก ระบบ</a>
                    <!-- <a class="collapse-item" href="repair.html">การส่งซ่อม</a> -->
                </div>
            </div>
        </li>
    <?php } ?>

    <!-- Nav Item - soundsystem Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsesoundsystem" aria-expanded="true" aria-controls="collapsesoundsystem">
            <i class="f	fa fa-cogs"></i>
            <span>อะไหล่</span>
        </a>
        <div id="collapsesoundsystem" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">รายละเอียด :</h6>
                <a class="collapse-item" href="listview_parts.php"><i class="fa fa-search"></i> ข้อมูลอะไหล่</a>
                <hr>

                <h6 class="collapse-header">การจัดการ :</h6>
                <a class="collapse-item" href="add_parts.php" style="color:green"> <i class="fa fa-plus-square"></i> เพิ่มข้อมูลอะไหล่</a>
                <a class="collapse-item" href="edit_stock.php" style="color:blue"> <i class="fa fa-search"></i> จัดการสต๊อก</a>

                <hr>
                <h6 class="collapse-header">แจ้งเตือน :</h6>
                <a class="collapse-item" href="stock_alert.php" style="color:red"><i class="fas fa-exclamation-circle"></i> เหลือน้อยกว่า 10 ชิ้น</a>
                <!-- stock_alert.php -->

                <hr>
                <h6 class="collapse-header">ประเภทอะไหล่ :</h6>
                <a class="collapse-item" href="add_parts_type.php"><i class="fa fa-clone"></i> จัดการประเภทอะไหล่</a>

                <hr>
                <h6 class="collapse-header">ประวัติการใช้อะไหล่ :</h6>
                <a class="collapse-item" href="log_part.php"><i class="	fa fa-download"></i> ประวัติการเพิ่ม</a>
                <a class="collapse-item" href="log_part_use.php"><i class="fa fa-paper-plane"></i> ประวัติการใช้</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - company Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecompany" aria-expanded="true" aria-controls="collapsecompany">
            <i class="fas fa-solid fa-building"></i>
            <span>บริษัท</span>
        </a>
        <div id="collapsecompany" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">รายละเอียด :</h6>
                <a class="collapse-item" href="listview_company.php"><i class="	fa fa-building"></i> ข้อมูลบริษัท</a>
                <a class="collapse-item" href="add_company.php"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล</a>
           <hr>
                <h6 class="collapse-header">ไปรษณีย์ :</h6>
                <a class="collapse-item" href="listview_company_transpost.php"><i class="	fa fa-paper-plane"></i> ข้อมูลบริษัทขนส่ง</a>
                <a class="collapse-item" href="add_company_transpost.php"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล</a>
            </div>
        </div>
    </li>
    <?php
    if ($_SESSION['role_id'] == 1) {
    ?>
        <!-- Nav Item - company Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsestatus" aria-expanded="true" aria-controls="collapsestatus">
                <i class="fas fa-solid fa-bars"></i>
                <span>สถานะ</span>
            </a>
            <div id="collapsestatus" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">รายละเอียด :</h6>
                    <a class="collapse-item" href="listview_status.php"><i class="	fa fa-code"></i> ข้อมูลสถานะ</a>
                </div>
            </div>
        </li>
    <?php } ?>
    <br>
    <div class="sidebar-heading">
        บันทึกด้วยตัวเอง
    </div>
    <!-- <li class="nav-item">
        <a class="nav-link" href="add_self_record.php">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            <span>บันทึกการซ่อมด้วยตัวเอง</span></a>
    </li> -->

    <li class="nav-item">
        <a class="nav-link" href="add_new_equipment.php">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            <span>บันทึกคำสั่งซื้อ</span></a>
    </li>
    <!-- 
    <li class="nav-item">
        <a class="nav-link" href="edit_stock.php">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            <span>จัดการสต๊อก</span></a>
    </li> -->
    <br>

    <div class="sidebar-heading">
        รายงาน
    </div>
    <!-- Nav Item - company Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsereport" aria-expanded="true" aria-controls="collapsereport">
            <i class="fas fa-solid fa-file"></i>
            <span>รายงาน</span>
        </a>
        <div id="collapsereport" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">รายละเอียด :</h6>
                <a class="collapse-item" href="report_parts.php"><i class="	fa fa-cogs"></i> ยอดอะไหล่</a>
                <a class="collapse-item" href="report_employee.php"><i class="	fa fa-address-book"></i> ยอดบุคลากร</a>
                <a class="collapse-item" href="report_repair.php"> <i class="fa fa-wrench"></i> ยอดการซ่อม</a>
                <!-- <a class="collapse-item" href="report_profit.php">ยอดรายได้การซ่อม</a> -->
            </div>
        </div>
    </li>
    <li class="nav-item" style="color:red">
        <a class="nav-link collapsed btn btn-danger" href="#" data-toggle="collapse" data-target="#collapseDelete" aria-expanded="true" aria-controls="collapseDelete" style="color:white; ">
            <i class="fas fa-solid fa-file" style="color:white"></i>
            <span>รายการที่ลบไปแล้ว</span>
        </a>
        <div id="collapseDelete" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header" >รายละเอียด :</h6>
                <a class="collapse-item" href="listview_del_get_repair.php" style="color:red"><i class="fa fa-wrench"></i> ใบแจ้งซ่อม</a>
                <a class="collapse-item" href="listview_del_repair.php" style="color:red"><i class="fa fa-cubes"></i> อุปกรณ์</a>
                <hr>
                <h5 class="collapse-header" >ข้อมูลทั้วไป :</h5>
                <a class="collapse-item" href="listview_del_employee.php" style="color:red"> <i class="fas fa-solid fa-users"></i> พนักงาน</a>
                <a class="collapse-item" href="listview_del_member.php" style="color:red"> <i class="fas fa-user"></i> สมาชิก</a>
                <a class="collapse-item" href="listview_del_part.php" style="color:red"><i class="fa fa-cubes"></i> อะไหล่</a>
                <a class="collapse-item" href="listview_del_company.php" style="color:red"> <i class="fas fa-solid fa-building"></i> บริษัท</a>
                <a class="collapse-item" href="listview_del_company_transpost.php" style="color:red"><i class="fas fa-paper-plane"></i> บริษัทขนส่ง</a>
                <!-- <a class="collapse-item" href="report_profit.php">ยอดรายได้การซ่อม</a> -->
            </div>
        </div>
    </li>
</ul>
<!-- End of Sidebar -->
<script>
    document.addEventListener("input", function(e) {
        if (e.target && e.target.classList.contains("auto-expand")) {
            e.target.style.height = "auto";
            e.target.style.height = (e.target.scrollHeight) + "px";
        }
    });

    // Trigger the 'input' event on page load to set the initial height
    window.addEventListener("load", function() {
        const textareas = document.querySelectorAll(".auto-expand");
        textareas.forEach(function(textarea) {
            textarea.style.height = "auto";
            textarea.style.height = (textarea.scrollHeight) + "px";
        });
    });
</script>
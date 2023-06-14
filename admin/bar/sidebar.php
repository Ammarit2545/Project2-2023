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
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-solid fa-envelope"></i>
            <span>การแจ้งเตือนการซ่อม</span>
        </a>
        <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">รายละเอียด :</h6>
                <a class="collapse-item" href="listview_repair.php">รายการแจ้งซ่อม</a>
                <!-- <a class="collapse-item" href="add_employee.php">เพิ่มข้อมูล</a> -->
                <!-- <hr>
                <h6 class="collapse-header">แผนกพนักงาน :</h6>
                <a class="collapse-item" href="add_em_type.php">แผนก</a> -->
            </div>
        </div>
    </li>
    <br>
    <div class="sidebar-heading">
        ข้อมูลทั่วไป
    </div>
    <!-- Nav Item - employee Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-solid fa-users"></i>
            <span>พนักงาน</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">รายละเอียด :</h6>
                <a class="collapse-item" href="employee_listview.php">ข้อมูลพนักงาน</a>
                <a class="collapse-item" href="add_employee.php">เพิ่มข้อมูล</a>
                <hr>
                <h6 class="collapse-header">แผนกพนักงาน :</h6>
                <a class="collapse-item" href="add_em_type.php">แผนก</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - customer Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecustomer" aria-expanded="true" aria-controls="collapsecustomer">
            <i class="fas fa-user"></i>
            <span>ลูกค้า</span>
        </a>
        <div id="collapsecustomer" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">รายละเอียด :</h6>
                <a class="collapse-item" href="listview_member.php">ข้อมูลลูกค้า</a>
                <!-- <a class="collapse-item" href="repair.html">การส่งซ่อม</a> -->
            </div>
        </div>
    </li>

    <!-- Nav Item - soundsystem Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsesoundsystem" aria-expanded="true" aria-controls="collapsesoundsystem">
            <i class="fas fa-solid fa-music"></i>
            <span>อะไหล่</span>
        </a>
        <div id="collapsesoundsystem" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">รายละเอียด :</h6>
                <a class="collapse-item" href="listview_parts.php">ข้อมูลอะไหล่</a>
                <a class="collapse-item" href="add_parts.php">เพิ่มข้อมูลอะไหล่</a>
                <hr>
                <h6 class="collapse-header">ประเภทอะไหล่ :</h6>
                <a class="collapse-item" href="add_parts_type.php">ประเภทอะไหล่</a>
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
                <a class="collapse-item" href="listview_company.php">ข้อมูลบริษัท</a>
                <a class="collapse-item" href="add_company.php">เพิ่มข้อมูล</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - company Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsestatus" aria-expanded="true" aria-controls="collapsestatus">
            <i class="fas fa-solid fa-bars"></i>
            <span>สถานะ</span>
        </a>
        <div id="collapsestatus" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">รายละเอียด :</h6>
                <a class="collapse-item" href="listview_status.php">ข้อมูลสถานะ</a>
            </div>
        </div>
    </li>
    <br>
    <div class="sidebar-heading">
        บันทึกด้วยตัวเอง
    </div>
    <li class="nav-item">
        <a class="nav-link" href="add_self_record.php">
            <!-- <i class="fas fa-fw fa-arrow-down fa-fade"></i> -->
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            <span>บันทึกการซ่อมด้วยตัวเอง</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="add_new_equipment.php">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            <span>บันทึกคำสั่งซื้อ</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="edit_stock.php">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            <span>จัดการสต๊อก</span></a>
    </li>
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
                <a class="collapse-item" href="report_parts.php">ยอดอะไหล่</a>
                <a class="collapse-item" href="report_employee.php">ยอดบุคลากร</a>
                <a class="collapse-item" href="report_repair.php">ยอดการซ่อม</a>
            </div>
        </div>
    </li>
</ul>
<!-- End of Sidebar -->
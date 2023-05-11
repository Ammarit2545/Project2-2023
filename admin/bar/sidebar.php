<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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
        Interface
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
                <a class="collapse-item" href="customer.html">ข้อมูลลูกค้า</a>
                <a class="collapse-item" href="repair.html">การส่งซ่อม</a>
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
                <a class="collapse-item" href="add_parts.php">เพิ่มข้อมูล</a>
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
                <a class="collapse-item" href="company.html">ข้อมูลบริษัท</a>
                <a class="collapse-item" href="addcompany.html">เพิ่มข้อมูล</a>
            </div>
        </div>
    </li>
</ul>
<!-- End of Sidebar -->
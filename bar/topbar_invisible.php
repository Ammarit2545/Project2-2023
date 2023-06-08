<!-- <nav class="navbar fixed-top navbar-expand-lg navbar-light " id="navcolor"> -->
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#" style="color: #000141;">
      <h4>Anan Electronic</h4>
    </a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ps-5">
        <a class="nav-link" style="color: black; text-decoration:none; " href="home.php">หน้าหลัก</a>
        <!-- <a class="nav-link" style="color: black; text-decoration:none; " href="home_repair.php">ส่งซ่อม</a> -->
        <a class="nav-link" style="color: black; text-decoration:none; " href="listview_repair.php">ส่งซ่อม</a>
        <a class="nav-link" style="color: black; text-decoration:none; " href="listview_status.php">ติดตาม</a>
        <a class="nav-link" style="color: black; text-decoration:none; " href="history_main.php">ประวัติ</a>
      </div>
    </div>
    <div class="dropdown col-md-3 text-end">
      <!-- <?= $_SESSION['fname'] . " " . $_SESSION['lname']  ?> -->
      <i class="uil uil-user-circle" style="font-size: 40px; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false"></i>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="edit_user.php">แก้ไขข้อมูล</a></li>
        <li><a class="dropdown-item" href="action/logout.php">Log out</a></li>
      </ul>
    </div>
  </div>
</nav>
<style>
  body {
    font-family: sans-serif;
  }

  /* CSS for the scroll-to-top button */
  #scrollToTop {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #555;
    color: #fff;
    text-align: center;
    font-size: 20px;
    line-height: 50px;
    cursor: pointer;
    z-index: 9999;
    /* Adjust the z-index value as needed */
  }

  #scrollToTop.visible {
    opacity: 1;
  }
</style>
<!-- Your web content here -->

<!-- Scroll-to-top button -->
<div id="scrollToTop" onclick="scrollToTop()">
  &uarr;
</div>
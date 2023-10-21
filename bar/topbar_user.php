<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function checkRecords() {
    // Get the current domain dynamically
    const currentDomain = window.location.protocol + '//' + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
    console.log(currentDomain);

    $.ajax({
      url: currentDomain + '/Project2023/Project2-2023/admin/action/check_records.php',
      dataType: 'json',
      success: function(data) {
        if (data.length > 0) {
          // Handle the response, e.g., display a notification or update the UI
          for (let i = 0; i < data.length; i++) {
            const getRId = data[i].get_r_id;
            console.log(`Repair ID ${getRId} has not been paid.`);
          }

          // Call the function again after a delay (e.g., 5 seconds)
          setTimeout(checkRecords, 5000); // 5 seconds (5000 milliseconds)
        } else {
          // No records found, call the function again after a delay
          setTimeout(checkRecords, 5000); // 5 seconds (5000 milliseconds)
        }
      },
      error: function() {
        // Handle errors, and call the function again after a delay
        setTimeout(checkRecords, 5000); // 5 seconds (5000 milliseconds)
      }
    });
  }

  // Start checking records when the page loads
  $(document).ready(function() {
    checkRecords();
  });
</script>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
  body {
    font-family: sans-serif;
  }

  .NameTopbar {
    position: absolute;
    /* Default positioning */
    top: 30%;
    left: 45%;
    font-size: 100%;

    /* Add any other styles you need */
    /* Media query for screens with a maximum width of 768px */
    @media (max-width: 1400px) {
      top: 30%;
      left: 50%;
      transform: translateX(-50%);
    }

    /* Media query for screens with a maximum width of 768px */
    @media (max-width: 1200px) {
      top: 30%;
      left: 40%;
      transform: translateX(-50%);
    }

    /* Media query for screens with a maximum width of 768px */
    @media (max-width: 992px) {
      top: 30%;
      left: 20%;
      transform: translateX(-50%);
    }

    /* Media query for screens with a maximum width of 768px */
    @media (max-width: 768px) {
      top: 30%;
      left: 0%;
      transform: translateX(-100%);
      display: none;
    }

    /* Media query for screens with a maximum width of 480px */
    @media (max-width: 480px) {
      top: 30%;
      left: 20%;
      display: none;
    }
  }

  /* navbar */
  .header {
    background: #fff;
    transition: all 0.5s;
    z-index: 997;
    height: 90px;
    border-bottom: 1px solid #fff;
  }

  .header.sticked {
    border-color: #fff;
    border-color: #eee;
  }

  .header .logo h1 {
    font-size: 28px;
    font-weight: 700;
    color: #000141;
    margin: 0;
    /* font-family: var(--font-secondary); */
  }

  /* Desktop Navigation*/
  @media (min-width: 1280px) {
    .navbar {
      padding: 0;
    }

    .navbar ul {
      margin: 0;
      padding: 0;
      display: flex;
      list-style: none;
      align-items: center;
    }

    .navbar li {
      position: relative;
    }

    .navbar>ul>li {
      white-space: nowrap;
      padding: 10px 0 10px 28px;
    }

    .navbar a,
    .navbar a:focus {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 3px;
      /* font-family: var(--font-secondary); */
      font-size: 16px;
      font-weight: 600;
      color: #7f7f90;
      white-space: nowrap;
      transition: 0.3s;
      position: relative;
      text-decoration: none;
    }

    .navbar a i,
    .navbar a:focus i {
      font-size: 12px;
      line-height: 0;
      margin-left: 5px;
    }

    .navbar>ul>li>a:before {
      content: "";
      position: absolute;
      width: 100%;
      height: 2px;
      bottom: -6px;
      left: 0;
      background-color: #000141;
      visibility: hidden;
      width: 0px;
      transition: all 0.3s ease-in-out 0s;
    }

    .navbar a:hover:before,
    .navbar li:hover>a:before,
    .navbar .active:before {
      visibility: visible;
      width: 100%;
    }

    .navbar a:hover,
    .navbar .active,
    .navbar .active:focus,
    .navbar li:hover>a {
      color: #000;
    }

    .navbar .dropdown ul {
      display: block;
      position: absolute;
      left: 28px;
      top: calc(100% + 30px);
      margin: 0;
      padding: 10px 0;
      z-index: 99;
      opacity: 0;
      visibility: hidden;
      background: #fff;
      box-shadow: 0px 0px 30px rgba(127, 137, 161, 0.25);
      transition: 0.3s;
      border-radius: 4px;
    }

    .navbar .dropdown ul li {
      min-width: 200px;
    }

    .navbar .dropdown ul a {
      padding: 10px 20px;
      font-size: 15px;
      text-transform: none;
      font-weight: 600;
    }

    .navbar .dropdown ul a i {
      font-size: 12px;
    }

    .navbar .dropdown ul a:hover,
    .navbar .dropdown ul .active:hover,
    .navbar .dropdown ul li:hover>a {
      color: #000141;
    }

    .navbar .dropdown:hover>ul {
      opacity: 1;
      top: 100%;
      visibility: visible;
    }

    .navbar .dropdown .dropdown ul {
      top: 0;
      left: calc(100% - 30px);
      visibility: hidden;
    }

    .navbar .dropdown .dropdown:hover>ul {
      opacity: 1;
      top: 0;
      left: 100%;
      visibility: visible;
    }
  }

  @media (min-width: 1280px) and (max-width: 1366px) {
    .navbar .dropdown .dropdown ul {
      left: -90%;
    }

    .navbar .dropdown .dropdown:hover>ul {
      left: -100%;
    }
  }

  @media (min-width: 1280px) {

    .mobile-nav-show,
    .mobile-nav-hide {
      display: none;
    }
  }

  /*Mobile Navigation*/
  @media (max-width: 1279px) {
    .navbar {
      position: fixed;
      top: 0;
      right: -100%;
      width: 100%;
      max-width: 400px;
      border-left: 1px solid #666;
      bottom: 0;
      transition: 0.3s;
      z-index: 9997;
    }

    .navbar ul {
      position: absolute;
      inset: 0;
      padding: 50px 0 10px 0;
      margin: 0;
      background: rgba(255, 255, 255, 0.9);
      overflow-y: auto;
      transition: 0.3s;
      z-index: 9998;
    }

    .navbar a,
    .navbar a:focus {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      font-family: var(--font-secondary);
      border-bottom: 2px solid rgba(255, 255, 255, 0.8);
      font-size: 16px;
      font-weight: 600;
      color: #7f7f90;
      white-space: nowrap;
      transition: 0.3s;
      text-decoration: none !important;
    }

    .navbar a i,
    .navbar a:focus i {
      font-size: 12px;
      line-height: 0;
      margin-left: 5px;
    }

    .navbar a:hover,
    .navbar li:hover>a {
      color: #000;
    }

    .navbar .active,
    .navbar .active:focus {
      color: #000;
      border-color: #000141;
    }

    .navbar .dropdown ul,
    .navbar .dropdown .dropdown ul {
      position: static;
      display: none;
      padding: 10px 0;
      margin: 10px 20px;
      transition: all 0.5s ease-in-out;
      border: 1px solid #eee;
    }

    .navbar .dropdown>.dropdown-active,
    .navbar .dropdown .dropdown>.dropdown-active {
      display: block;
    }

    .mobile-nav-show {
      color: #37373f;
      font-size: 28px;
      cursor: pointer;
      line-height: 0;
      transition: 0.5s;
      z-index: 9999;
      margin: 0 10px 0 20px;
    }

    .mobile-nav-hide {
      color: #37373f;
      font-size: 32px;
      cursor: pointer;
      line-height: 0;
      transition: 0.5s;
      position: fixed;
      right: 20px;
      top: 20px;
      z-index: 9999;
    }

    .mobile-nav-active {
      overflow: hidden;
    }

    .mobile-nav-active .navbar {
      right: 0;
    }

    .mobile-nav-active .navbar:before {
      content: "";
      position: fixed;
      inset: 0;
      background: rgba(255, 255, 255, 0.8);
      z-index: 9996;
    }
  }


  .about .content ul {
    list-style: none;
    padding: 0;
  }

  .about .content ul li {
    padding: 0 0 8px 26px;
    position: relative;
  }

  .about .content ul i {
    position: absolute;
    font-size: 20px;
    left: 0;
    top: -3px;
    color: #000141;
  }
</style>

<!-- navbar-->
<header class="header fixed-top d-flex align-items-center sticked">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="index.php" class="logo d-flex align-items-center me-auto me-lg-0" style="text-decoration: none;">

      <img src="img brand/anelogo.png" width="100px" alt="">
    </a>
    <nav id="navbar" class="navbar">
      <ul>
        <li><a href="home.php">หน้าหลัก</a></li>
        <li><a href="listview_repair.php">ส่งซ่อม</a></li>
        <li><a href="listview_status.php">ติดตาม</a></li>
        <li><a href="history_main.php">ประวัติ</a></li>
        <li><a href="history_main_old.php" style="color:green">สำเร็จ<i class="fa fa-check-square"></i></a></li>
        <li class="dropdown"><a href="#"><span><?= $_SESSION['fname'] . " " . $_SESSION['lname']  ?></span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
          <ul>
            <li><a href="edit_user.php">แก้ไขข้อมูล</a></li>
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">ข้อกำหนดเกี่ยวกับเว็บไซต์</a></li>
            <li><a href="#" onclick="logout()">Log out</a></li>
          </ul>
        </li>
      </ul>
    </nav><!-- .navbar -->
    <!-- <a class="btn-book-a-table" href="#book-a-table">Book a Table</a> -->
    <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
    <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
  </div>
  <script>
    const preloader = document.querySelector('#preloader');
    if (preloader) {
      window.addEventListener('load', () => {
        preloader.remove();
      });
    }

    const selectHeader = document.querySelector('.header');
    if (selectHeader) {
      document.addEventListener('scroll', () => {
        window.scrollY > 100 ? selectHeader.classList.add('sticked') : selectHeader.classList.remove('sticked');
      });
    }

    let navbarlinks = document.querySelectorAll('#navbar a');

    function initialNavbarlinksActive() {
      let currentLocation = window.location.href;
      navbarlinks.forEach(navbarlink => {
        if (currentLocation.includes(navbarlink.getAttribute('href'))) {
          navbarlink.classList.add('active');
        }
      });
    }
    window.addEventListener('load', initialNavbarlinksActive);

    navbarlinks.forEach(navbarlink => {
      navbarlink.addEventListener('click', () => {
        navbarlinks.forEach(link => {
          link.classList.remove('active');
        });
        navbarlink.classList.add('active');
      });
    });


    const mobileNavShow = document.querySelector('.mobile-nav-show');
    const mobileNavHide = document.querySelector('.mobile-nav-hide');

    document.querySelectorAll('.mobile-nav-toggle').forEach(el => {
      el.addEventListener('click', function(event) {
        event.preventDefault();
        mobileNavToggle();
      });
    });

    function mobileNavToggle() {
      document.querySelector('body').classList.toggle('mobile-nav-active');
      mobileNavShow.classList.toggle('d-none');
      mobileNavHide.classList.toggle('d-none');
    }

    document.querySelectorAll('#navbar a').forEach(navbarlink => {
      if (!navbarlink.hash) return;
      let section = document.querySelector(navbarlink.hash);
      if (!section) return;
      navbarlink.addEventListener('click', () => {
        if (document.querySelector('.mobile-nav-active')) {
          mobileNavToggle();
        }
        navbarlinks.forEach(link => {
          link.classList.remove('active');
        });
        navbarlink.classList.add('active');
      });
    });

    const navDropdowns = document.querySelectorAll('.navbar .dropdown > a');
    navDropdowns.forEach(el => {
      el.addEventListener('click', function(event) {
        if (document.querySelector('.mobile-nav-active')) {
          event.preventDefault();
          this.classList.toggle('active');
          this.nextElementSibling.classList.toggle('dropdown-active');
          let dropDownIndicator = this.querySelector('.dropdown-indicator');
          dropDownIndicator.classList.toggle('bi-chevron-up');
          dropDownIndicator.classList.toggle('bi-chevron-down');
        }
      });
    });
  </script>

</header>

<!-- end navbar-->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">ข้อจำกัดในการใช้เว็บ Anan Electronic</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="fw-bold">เว็บไซต์มีวัตถุประสงค์การใช้งานโดยบุคคลซึ่งไม่บรรลุนิติภาวะตามกฎหมาย ซึ่งหมายถึงผู้เยาว์หรือบุคคลไร้ความสามารถหรือบุคคลเสมือนไร้ความสามารถ การใช้งานเว็บแอพลิเคชัน
          ในการเข้าถึงหรือใช้แพลตฟอร์มของเรา คุณตกลงว่าจะไม่กระทำการดังต่อไปนี้</p>
        <p>1. ใช้อุปกรณ์ ซอฟท์แวร์ กระบวนการ หรือวิธีการอัตโนมัติในการเข้าถึง เรียกดู ทำลาย หรือสร้างดัชนีแพลตฟอร์มของเราหรือเนื้อหาอื่น ๆ บนเว็บไซต์</p>
        <p>2.ใช้อุปกรณ์ ซอฟท์แวร์ กระบวนการ หรือวิธีการในการแทรกแซงหรือพยายามที่จะแทรกแซงการทำงานบนเว็บแอพลิเคชันของเรา</p>
        <p>3.ใช้หรือสร้างดัชนีของข้อมูลบนแพลตฟอร์มเพื่อวัตถุประสงค์ต่อไปนี้</p>
        <p>- ละเมิดสิทธิของบุคคลอื่น ซึ่งรวมถึงลิขสิทธิ์ ความลับทางการค้า สิทธิความเป็นส่วนตัว หรือทรัพย์สินทางปัญญาหรือกรรมสิทธิ์อื่น</p>
        <p>- เลียนแบบบุคคลหรือหน่วยงานใด ๆ หรือพยายามเรียกเงิน รหัสผ่าน หรือข้อมูลส่วนบุคคลจากบุคคลอื่น</p>
        <p>- กระทำการใด ๆ ที่เป็นการละเมิดข้อกำหนดการใช้เว็บไซต์และเงื่อนไขอื่น ๆ ที่เราประกาศ หรือบทบัญญัติกฎหมายกำหนดไว้</p>
        <p>- ทำซ้ำ พิมพ์ซ้ำ ส่งต่อซ้ำ ดัดแปลง ประยุกต์ แจกจ่าย แปล สร้างงานต่อเนื่องหรืองานประยุกต์ แสดงต่อสาธารณะ ขาย ค้า หรือกระทำ
          การอย่างอื่นที่เข้าข่ายการใช้ประโยชน์อันมิชอบจากแพลตฟอร์มของเราหรือเนื้อหาบนเว็บไซต์ของเรา เว้นแต่เราอนุญาตให้กระทำ หรือ ส่งต่อหรือพยายามส่งต่อซึ่งไวรัสคอมพิวเตอร์ หนอนคอมพิวเตอร์ ข้อบกพร่อง หรือโปรแกรมอื่น ๆ ที่มีลักษณะทำลาย หรือสร้างความเสียหายต่อระบบ</p>
        <p>ทั้งนี้ เราสงวนสิทธิ์ในการดำเนินการตามที่เราเห็นว่าจำเป็นเพื่อป้องกันการเข้าถึงหรือใช้เว็บไซต์ของเราโดยไม่ได้รับอนุญาต ซึ่งรวมถึงแต่ไม่จำกัดเพียงการสร้างอุปสรรคทางเทคนิค หรือรายงานความประพฤติของคุณต่อบุคคลหรือหน่วยงาน</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ตกลง</button>
      </div>
    </div>
  </div>
</div>
<script>
  function logout() {
    swal.fire({
      title: 'Logout?',
      text: 'การออกจากระบบจะล้างเซสซัสทั้งหมดของคุณ',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'ออกจากระบบ',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        // Perform the delete action
        window.location.href = 'action/logout.php';
      }
    });
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


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

<!-- 
<style>
  html {
    box-sizing: border-box;
  }

  *,
  *:before,
  *:after {
    box-sizing: inherit;
    padding: 0;
  }

  body {
    height: 100%;
    overflow: hidden;
  }

  .buttons {
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 10px;
    z-index: -1;
  }

  .buttons button {
    border: none;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 5px;
    cursor: pointer;
  }

  .buttons button:hover {
    background: rgba(0, 0, 0, 0.04);
  }

  .buttons #top {
    position: absolute;
    top: 0%;
    left: 50%;
  }

  .buttons #bottom {
    position: absolute;
    bottom: 0;
    left: 50%;
  }

  .buttons #left {
    position: absolute;
    top: 50%;
    left: 0px;
  }

  .buttons #right {
    position: absolute;
    top: 50%;
    right: 0;
  }

  .top-layer {
    position: absolute;
    width: 100%;
    height: 100%;
    top: -100%;
    left: 0;
    bottom: auto;
    right: auto;
    background: #6c567b;
    transition: all 0.9s cubic-bezier(0.6, 0.05, 0.4, 1);
  }

  .top-layer.active {
    top: 100%;
  }

  .top-layer--2 {
    background: #393e46;
    transition-delay: 0.6s;
  }

  .top-layer--3 {
    background: #6c5b7b;
    transition-delay: 0.4s;
  }

  .top-layer--4 {
    background: #c06c84;
    transition-delay: 0.2s;
  }

  .top-layer--5 {
    background: #f67280;
    transition-delay: 0.1s;
  }

  .bottom-layer {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 100%;
    left: 0;
    bottom: auto;
    right: auto;
    background: #48466d;
    transition: all 0.7s cubic-bezier(0.645, 0.045, 0.355, 1);
  }

  .bottom-layer.active {
    top: -100%;
  }

  .bottom-layer--2 {
    background: #ecf3a3;
    transition-delay: 0.12s;
  }

  .bottom-layer--3 {
    background: #95a792;
    transition-delay: 0.4s;
  }

  .left-layer {
    position: absolute;
    width: 100%;
    height: 100%;
    top: auto;
    left: -100%;
    bottom: auto;
    right: auto;
    background: #4d606e;
    transition: all 0.7s cubic-bezier(0.645, 0.045, 0.355, 1);
  }

  .left-layer.active {
    left: 100%;
  }

  .left-layer--2 {
    background: #d3d4d8;
    transition-delay: 0.3s;
  }

  .left-layer--3 {
    background: #d3d4d8;
    transition-delay: 0.12s;
  }

  .left-layer--4 {
    background: #c06c84;
    transition-delay: 0.08s;
  }

  .right-layer {
    position: absolute;
    width: 100%;
    height: 100%;
    top: auto;
    left: 100%;
    bottom: auto;
    right: auto;
    background: #7f4a88;
    transition: all 0.9s cubic-bezier(0.645, 0.045, 0.355, 1);
  }

  .right-layer.active {
    left: -100%;
  }

  .right-layer--2 {
    background: #c79ecf;
    transition-delay: 0.3s;
  }

  .right-layer--3 {
    background: #fe9191;
    transition-delay: 0.2s;
  }
</style>




<div class="container">
  <div class="top-layer"></div>
  <div class="top-layer top-layer--2"></div>
  <div class="top-layer top-layer--3"></div>
  <div class="top-layer top-layer--4"></div>
  <div class="top-layer top-layer--5"></div>
  <div class="bottom-layer"></div>
  <div class="bottom-layer bottom-layer--2"></div>
  <div class="bottom-layer bottom-layer--3"></div>
  <div class="left-layer"></div>
  <div class="left-layer left-layer--2"></div>
  <div class="left-layer left-layer--3"></div>
  <div class="left-layer left-layer--4"></div>
  <div class="right-layer"></div>
  <div class="right-layer right-layer--2"></div>
  <div class="right-layer right-layer--3"></div>
  <div class="buttons">
    <button id="top"><img src="https://icongr.am/feather/arrow-down.svg" /></button>
    <button id="bottom"><img src="https://icongr.am/feather/arrow-up.svg" /></button>
    <button id="left"><img src="https://icongr.am/feather/arrow-right.svg" /></button>
    <button id="right"><img src="https://icongr.am/feather/arrow-left.svg" /></button>
  </div>
</div>

<script>
  const buttons = document.getElementsByTagName("button");

  for (const button of buttons) {
    button.addEventListener('click', () => {
      var id = button.getAttribute("id");

      var layerClass = "." + id + "-layer";
      var layers = document.querySelectorAll(layerClass);
      for (const layer of layers) {
        layer.classList.toggle("active");
      }
    });
  }
</script> -->
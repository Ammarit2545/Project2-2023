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
    opacity: 0;
  }

  #scrollToTop.visible {
    display: block;
    opacity: 1;
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
</style>
<!-- Your web content here -->

<!-- Scroll-to-top button -->
<div id="scrollToTop" onclick="scrollToTop()">
  &uarr;
</div>

<!-- JavaScript for scrolling to top -->
<script>
  // Show the scroll-to-top button when scrolling down
  window.onscroll = function() {
    showScrollButton();
  };

  function showScrollButton() {
    var scrollToTopButton = document.getElementById("scrollToTop");
    if (
      document.body.scrollTop > 20 ||
      document.documentElement.scrollTop > 20
    ) {
      scrollToTopButton.classList.add("visible");
      scrollToTopButton.style.opacity = 1;
    } else {
      scrollToTopButton.classList.remove("visible");
      scrollToTopButton.style.opacity = 0;
    }
  }

  // Scroll to the top of the page when the button is clicked
  function scrollToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }
</script>

<!-- navbar-->
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#" style="color: #000141;">
     <!-- <h4>Anan Electronic</h4> -->
      <img src="img brand/anelogo.png" alt="" width="100px">
    </a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ps-5">
        <a class="nav-link active" aria-current="page" href="home.php">หน้าหลัก</a>
        <!-- <a class="nav-link" href="home_repair.php">ส่งซ่อม</a> -->
        <a class="nav-link" href="listview_repair.php" title="ส่งซ่อมอุปกรณ์ของคุฯ">ส่งซ่อม</a>
        <a class="nav-link" href="listview_status.php" title="ติดตามหมายเลขซ่อม สถานะต่างๆ"> ติดตาม</i></a>
        <a  class="nav-link" href="history_main.php" tabindex="-1" aria-disabled="true" title="ดูอุปกรณ์ที่เคยซ่อมในระบบของคุณ">ประวัติอุปกรณ์<i class="fa fa-history"></i></a>
        <a style="color:green" class="nav-link" href="history_main_old.php" tabindex="-1" aria-disabled="true" title="หมายเลขซ่อมที่สำเร็จของคุณ">สำเร็จ <i class="fa fa-check-square"></i> </a>
      </div>
    </div>
    <div class="dropdown col-md-3 text-end">

      <span class="NameTopbar"><?= $_SESSION['fname'] . " " . $_SESSION['lname']  ?></span>

      <i class="uil uil-user-circle" style="font-size: 40px; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false"></i>

      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="edit_user.php">แก้ไขข้อมูล <i class="fa fa-edit"></i></a></li>
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">ข้อกำหนดเกี่ยวกับเว็บไซต์ <i class="fa fa-info-circle"></i></a></li>
        <li><a class="dropdown-item" onclick="logout()">Log out <i class="fa fa-sign-out"></i></a></li>
      </ul>
    </div>
  </div>
</nav>

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
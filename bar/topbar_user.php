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
      scrollToTopButton.style.display = "block";
    } else {
      scrollToTopButton.style.display = "none";
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
      <h4>Anan Electronic</h4>
    </a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ps-5">
        <a class="nav-link active" aria-current="page" href="home.php">หน้าหลัก</a>
        <!-- <a class="nav-link" href="home_repair.php">ส่งซ่อม</a> -->
        <a class="nav-link" href="listview_repair.php">ส่งซ่อม</a>
        <a class="nav-link" href="listview_status.php">ติดตาม</a>
        <a class="nav-link" href="history_main.php" tabindex="-1" aria-disabled="true">ประวัติ</a>
      </div>
    </div>
    <div class="dropdown col-md-3 text-end">
      <!-- <?= $_SESSION['fname'] . " " . $_SESSION['lname']  ?> -->
      <i class="uil uil-user-circle" style="font-size: 40px; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false"></i>


      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="edit_user.php">แก้ไขข้อมูล</a></li>
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">ข้อกำหนดเกี่ยวกับเว็บไซต์</a></li>
        <li><a class="dropdown-item" onclick="logout()">Log out</a></li>
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
<?php
session_start();

// git remote add origin https://github.com/Ammarit2545/Final-Project-2023.git


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
  <title>ANE - Home</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

  </script>
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

  <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
</head>

<body>

  <!-- navbar-->
  <?php
  include('database/condb.php');
  $id = $_SESSION['id'];

  $sql1 = "SELECT * FROM member WHERE m_id = '$id '";
  $result1 = mysqli_query($conn, $sql1);
  $row1 = mysqli_fetch_array($result1);

  if ($row1 > 0) {
    include('bar/topbar_user.php');
  }

  if ($id == NULL) {
    include('bar/topbar.php');
  }

  ?>
  <!-- end navbar-->

  <!-- Modal Login-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 39px; background-color: #D4E8FF;">
        <div class="modal-body pt-5 mx-3">
          <div class="text-center mb-3">
            <h2>ยินดีต้อนรับ</h2><br>
            <h4>เข้าสู่ระบบ</h4>
          </div>
          <form action="action/login.php" method="POST">
            <div class="input-group">
              <input type="text" class="input-field" id="email" name="email" required>
              <label for="email">Email</label>
            </div>
            <div class="input-group">
              <input type="password" class="input-field" id="password" name="password" required>
              <label for="password">Password</label>
            </div>
            <p class="text-end">
              <a href="#" style="color: black; text-decoration:none; " data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">Forgot password?</a>
            </p><br>
            <div class="d-grid gap-2">
              <button class="btn btn-primary btn-lg" type="submit">LOGIN</button>
            </div><br>
            <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p><br>
            <p class="text-center">
              <center>

                <p>Don’t have an Account?
                  <a href="#" style="color: #0066CC; text-decoration:none;" data-bs-toggle="modal" data-bs-target="#Register">Create yours now.</a>
                </p>
            </p>
            </center>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- ลืมรหัสผ่าน-->
  <div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 39px; background-color: #D4E8FF;">
        <div class="modal-body pt-5 mx-3">
          <div class="text-center mb-3">
            <h2>ยินดีต้อนรับสู่ร้าน MY SHOP</h2><br>
            <h4>ลืมรหัสผ่าน</h4>
          </div>
          <form action="">
            <div class="input-group">
              <input type="text" class="input-field" id="username" required>
              <label for="username">เบอร์โทรศัพท์</label>
            </div><br>
            <div class="d-grid gap-2">
              <button class="btn btn-primary btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#ResetModal" data-bs-dismiss="modal">Reset password</button>
            </div><br>
            <p class="text-center mx-3 mb-0">ระบบจำทำการส่งรหัสให้เพื่อรีเซ็ทรหัสผ่าน</p><br>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- ยืนยันรหัสใหม่-->
  <div class="modal fade" id="ResetModal" tabindex="-1" aria-labelledby="ResetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 39px; background-color: #D4E8FF;">
        <div class="modal-body pt-5 mx-3">
          <div class="text-center mb-3">
            <h2>ยินดีต้อนรับสู่ร้าน MY SHOP</h2><br>
            <h4>Reset password</h4>
          </div>
          <form action="">
            <div class="input-group">
              <input type="text" class="input-field" id="username" required>
              <label for="username">Password</label>
            </div>
            <div class="input-group">
              <input type="text" class="input-field" id="username" required>
              <label for="username">Confirm Password</label>
            </div><br>
            <div class="d-grid gap-2">
              <button class="btn btn-primary btn-lg" type="button">Reset</button>
            </div><br>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Login-->

  <!-- Modal Register-->
  <div class="container">
    <div class="row">
      <div class="col-1">
      </div>
      <div class="col">
        <div class="modal fade" id="Register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 39px; background-color: #D4E8FF;">
              <div class="modal-body py-5 mx-3">
                <div class="text-center mb-3">
                  <h2>ยินดีต้อนรับสู่ร้าน MY SHOP</h2><br>
                  <h4>เข้าสู่ระบบ</h4>
                </div>
                <form action="action/register.php" method="POST">
                  <div class="input-group">
                    <input type="email" class="input-field" id="email" name="email" required>
                    <label for="email">Email</label>
                  </div>
                  <div class="input-group">
                    <input type="password" class="input-field" id="password" name="password" required>
                    <label for="password">Password</label>
                    <p style="color : red; font-size:12px">รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัว และไม่เกิน 10 ตัว</p>
                  </div>

                  <div class="input-group">
                    <input type="text" class="input-field" id="fname" name="fname" required>
                    <label for="fname">ชื่อ</label>
                  </div>
                  <div class="input-group">
                    <input type="text" class="input-field" id="lname" name="lname" required>
                    <label for="lname">นามสกุล</label>
                  </div>

                  <div class="input-group">
                    <input type="text" class="input-field" id="tel" name="tel" required>
                    <label for="tel">เบอร์โทรศัพท์</label>
                  </div><br>
                  <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" type="submit">Sign up</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-1">
      </div>
    </div>
  </div>

  <!-- End Modal Register-->

  <div class="p-5">
    <div class="container pt-5">
      <div class="card card_header">
        <div class="card-body mx-5 my-5">
          <?php
          if (!isset($_SESSION['id'])) {
          ?>
            <h1 style="color: white;">สวัสดีท่านสมาชิกใหม่</h1>
          <?php } else { ?>
            <h1 style="color: white;">สวัสดีคุณ <?= $row1['m_fname'] . " " . $row1['m_lname'] ?></h1>
          <?php } ?>
          <h3 style="color: white;">เราคือร้านจำหน่ายและรับซ่อมสินค้า <br> ประเภทเครื่องดนตรีทุกชนิด</h3>
          <p class="col" style="color: white;">เราหวังว่าจะคุณจะพอใจในการบริการของเราหากต้องการส่งซ่อม<br> คุณสามารถส่งรูปภาพเข้ามาสอบถามก่อนได้</p>
          <a href="home_repair.php" class="btn btn_custom ">ส่งซ่อม</a>
        </div>
      </div>
    </div>
  </div>

  <div class="container d-flex mb-5" style="height: 500px;">
    <div class="row">
      <div class="col">
        <h1>ทำไมถึงต้องเลือกเรา</h1>
        <p>เพราะเรามีประสบการณ์ด้านการขายและการซ่อมมายาวนาน <br> อีกทั้งยังมีการรับประกันในด้านสินค้าจากทางร้านและทางบริษัทต่างๆ</p>
      </div>
    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="row">
      <div class="col text-center align-self-center">
        <div class="card" style="height: 300px; background: #FFFFFF; box-shadow: 0px 10px 50px rgba(0, 1, 65, 0.18); border-radius: 48px; width: 15rem;">
          <div class="card-body">
            <h5 class="card-title">Card title1</h5>
            <p class="card-text">มีการรับประกันหลังการซ่อม 1 ปี</p>
            <a href="#" class="btn btn-primary">Button</a>
          </div>
        </div>
      </div>
    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="row">
      <div class="col text-center">
        <div class="card" style="height: 300px; background: #FFFFFF; box-shadow: 0px 10px 50px rgba(0, 1, 65, 0.18); border-radius: 48px; width: 15rem;">
          <div class="card-body">
            <h5 class="card-title">Card title2</h5>
            <p class="card-text">ส่งตรงเวลา</p>
            <a href="#" class="btn btn-primary">Button</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- footer-->
  <?php
  include('footer/footer.php')
  ?>
  <!-- end footer-->

  <script>
    // Show full page LoadingOverlay
    $.LoadingOverlay("show");

    // Hide it after 3 seconds
    setTimeout(function() {
      $.LoadingOverlay("hide");
    }, 10);
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
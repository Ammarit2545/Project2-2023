<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
session_start();
include('database/condb.php');
require_once('action/line_login.php');

if ($_SESSION["log_login"] == 0) {
  $_SESSION["log_login"] = 1;
?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'SweetAlert!',
      text: 'Your session login value is 0.',
      showConfirmButton: false,
      timer: 3000
    });
  </script>
<?php
} elseif ($_SESSION["log_login"] == 2) {
  $_SESSION["log_login"] = 1;
?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Something went wrong!',
      footer: '<a href="home.php">Why do I have this issue?</a>'
    });
  </script>
<?php
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
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    .fade-in {
      animation: fadein 0.5s ease-in-out;
    }

    @keyframes fadein {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @media screen and (max-width: 1024px) {
      .bigimg {
        height: 25% !important;
      }
    }

    @media screen and (max-width: 768px) {
      .bigimg {
        height: 25% !important;
      }
    }

    @media screen and (max-width: 320px) {
      img.imglogo {
        width: 36%;
      }
    }

    @media screen and (max-width: 425px) {
      .bigimg {
        height: 25% !important;
      }

      img.imglogo {
        width: 32%;
      }
    }
  </style>

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
      document.body.style.transition = "opacity 1s ease-out";
      document.body.style.opacity = "0";
    });
  </script>
  <link rel="stylesheet" href="styles.css">


  <title>ANE - Home</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

  <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
              <input type="text" class="input-field" name="email" required>
              <label for="email">Email</label>
            </div>
            <div class="input-group">
              <input type="password" class="input-field" id="password" name="password" required>
              <label for="password">Password</label>
            </div>
            <p class="text-end">
              <!-- <a href="#" style="color: black; text-decoration:none; " data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">Forgot password?</a> -->
            </p><br>
            <div class="d-grid gap-2">
              <button class="btn btn-primary btn-lg" type="submit">LOGIN</button>
              <?php
              if (!isset($_SESSION['profile'])) {
                $line = new LineLogin();
                $link = $line->getLink();
              ?>
                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button> -->
                <a href="<?php echo $link; ?>" class="btn btn-success"><img src="img/icon/line.png" alt="Line Picture" width="8%" style="border-radius:20%"> Line Login</a>
              <?php }  ?>
            </div><br>
            <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p><br>
            <p class="text-center">
              <center>
                <p>Don’t have an Account?
                  <a href="#" style="color: #0066CC; text-decoration:none;" data-bs-toggle="modal" data-bs-target="#Register">Create yours now.</a>
                </p>
              </center>
            </p>
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
                  <h2>ยินดีต้อนรับสู่ร้าน Anan Electronic</h2><br>
                  <h4>เข้าสู่ระบบ</h4>
                </div>
                <form action="action/register.php" method="POST">
                  <div class="input-group">

                    <!-- </button> -->
                    <input type="email" class="input-field" id="inputPasswordEmail" name="email" required>
                    <label for="email">Email</label>
                    <span id="email-error" style="color:red; display:none;">อีเมลนี้ถูกใช้งานแล้ว</span>

                  </div>

                  <div class="input-group">
                    <input type="password" class="input-field" oninput="checkPasswordLength()" onblur="checkPasswordLength()" id="password_name" name="password" required>
                    <label for="password">Password</label>

                    <span id="password-error" style="color: red; font-size: 12px; display: none;">
                      <span style="font-size: 12px; padding: -2px">
                        รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร
                      </span>
                    </span>

                    <script>
                      // Add the 'fade-in' class to trigger the transition
                      document.addEventListener("DOMContentLoaded", function() {
                        var passwordError = document.getElementById("password-error");
                        passwordError.style.display = "block";
                        passwordError.classList.add("fade-in");
                      });

                      function checkPasswordLength() {
                        // Get the password input element
                        const passwordInput = document.getElementById('password_name');

                        // Get the error message span element
                        const errorMessage = document.getElementById('password-error');

                        // Function to check the password length
                        const password = passwordInput.value;

                        if (password.length < 8) {
                          // Display the error message if the password length is invalid
                          errorMessage.style.display = 'inline';
                        } else {
                          // Hide the error message if the password meets the length requirement
                          errorMessage.style.display = 'none';
                        }
                      }
                    </script>
                  </div>

                  <div class="input-group">
                    <input type="password" class="input-field" oninput="checkPasswordLengthAgain()" onblur="checkPasswordLengthAgain()" id="password_con" name="password" required>
                    <label for="password">Confirm Password</label>

                    <span id="password-again-error" style="color: red; font-size: 12px; display: none;">
                      <span style="font-size: 12px; padding: -2px">
                        รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร
                      </span>
                    </span>

                    <span id="password-match-error" style="color: red; font-size: 12px; display: none;">
                      <span style="font-size: 12px; padding: -2px">
                        รหัสผ่านไม่ตรงกัน
                      </span>
                    </span>

                    <script>
                      // Add the 'fade-in' class to trigger the transition
                      document.addEventListener("DOMContentLoaded", function() {
                        var passwordError = document.getElementById("password-again-error");
                        passwordError.style.display = "block";
                        passwordError.classList.add("fade-in");
                      });

                      function checkPasswordLengthAgain() {
                        // Get the password input element
                        const passwordInput = document.getElementById('password_con');

                        // Get the error message span elements
                        const lengthErrorMessage = document.getElementById('password-again-error');
                        const matchErrorMessage = document.getElementById('password-match-error');

                        // Function to check the password length
                        const password = passwordInput.value;

                        if (password.length < 8) {
                          // Display the length error message if the password length is invalid
                          lengthErrorMessage.style.display = 'inline';
                          matchErrorMessage.style.display = 'none';
                        } else {
                          // Hide the length error message if the password meets the length requirement
                          lengthErrorMessage.style.display = 'none';
                          // Get the original password input element
                          const originalPasswordInput = document.getElementById('password_name');
                          const originalPassword = originalPasswordInput.value;

                          if (password !== originalPassword) {
                            // Display the match error message if the passwords do not match
                            matchErrorMessage.style.display = 'inline';
                          } else {
                            // Hide the match error message if the passwords match
                            matchErrorMessage.style.display = 'none';
                          }
                        }
                      }
                    </script>
                  </div>


                  <div class="input-group">
                    <input type="text" class="input-field" id="fname" name="fname" required>
                    <label for="fname">ชื่อ</label>
                  </div>
                  <div class="input-group">
                    <input type="text" class="input-field" id="lname" name="lname" required>
                    <label for="lname">นามสกุล</label>
                  </div>

                  <!-- <label for="inputPasswordTel" class="col-sm-1 col-form-label">เบอร์โทรศัพท์</label>
                  <div class="col-sm-3">
                    <input type="text" name="tel" class="input-field" id="inputPasswordTel" placeholder="กรุณากรอกเบอร์โทรติดต่อ">
                    <span id="tel-error" style="color:red; display:none;">เบอร์โทรนี้ถูกใช้งานแล้ว</span>
                  </div> -->

                  <div class="input-group">
                    <input type="text" class="input-field" id="inputPasswordTel" name="tel" required>
                    <label for="inputPasswordTel">เบอร์โทรศัพท์</label>
                    <span id="tel-error" style="color:red; display:none;">เบอร์โทรนี้ถูกใช้งานแล้ว</span>
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

  <center>
    <div style="padding: 90px 0 50px 0;">
      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="width: 100%;">
        <div class="carousel-inner bigimg" style="height: 100%">
          <?php
          $folderPath = 'img/promote/'; // Specify the folder path
          $files = glob($folderPath . '*'); // Get all files in the folder

          $active = true; // Flag for active carousel item

          foreach ($files as $file) {
          ?>
            <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
              <img src="<?php echo $file; ?>" class="d-block w-100 img-fluid" alt="...">
            </div>
          <?php
            $active = false; // Set the flag to false after the first carousel item
          }
          ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </center>
  <!-- Hero -->
  <div class="px-1 py-1 my-1 text-center">
    <img class="d-block mx-auto my-4 imglogo" src="img brand/anelogo.png" alt="" width="20%" data-aos="fade-up" data-aos-delay="100">

    <h1 class="display-5 fw-bold text-body-emphasis mt-2" data-aos="fade-up" data-aos-delay="100">ANE อนันต์อิเล็กทรอนิกส์</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">จำหน่ายและซ่อมเครื่องเสียงทุกชนิด โดยทีมงานมืออาชีพมากประสบการณ์ที่พร้อมจะบริการ การันตรีทั้งคุณภาพและประสิทธิภาพของผลลัพธ์</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" data-aos="fade-up" data-aos-delay="100">
        <a href="listview_repair.php" class="btn btn-primary btn-lg px-4 gap-3" style="box-shadow: 0px 5px 25px rgba(65, 84, 241, 0.3);">ส่งซ่อม</a>
        <button type="button" class="btn btn-outline-secondary btn-lg px-4">วิธีการส่งซ่อม</button>
      </div>
    </div>
  </div>
  <!-- End Hero -->

  <section id="why-us" class="why-us section-bg" style="margin-top: 60px;">
    <div class="container" data-aos="fade-up">

      <div class="row gy-4">

        <div class="col-lg-4 my-auto" data-aos="fade-up" data-aos-delay="100" style="margin-bottom: 24px;">
          <div class="why-box">
            <h3>ทำไมต้อง ANE?</h3>
            <p>
              เนื่องจากปัจจุบันลูกค้าบางท่านอาจไม่สะดวกมายังหน้าร้าน ดังนั้นทางร้านจึงมีการจัดทำเว็บขึ้นมาเพื่ออำนวยความสะดวกแก่ลูกค้า
              ให้ลูกค้าได้ส่งเรื่องมาทางเว็บได้เลย โดยทางร้านมีหน้าร้าน มีตัวตนอย่างถูกต้อง และมีช่างผู้เชี่ยวชาญในการซ่อม นอกจากนั้นทางเรายังมี
              บริการจัดส่งพัสดุกลับไปให้ในกรณีที่ลูกค้าไม่สะดวกมารับเอง
            </p>
            <!-- <div class="text-center">
                                <a href="#" class="more-btn">Learn More <i class="bx bx-chevron-right"></i></a>
                            </div> -->
          </div>
        </div><!-- End Why Box -->

        <div class="col-lg-8 d-flex align-items-center" style="margin-bottom: 24px;">
          <div class="row gy-4">

            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="200">
              <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-geo-alt"></i>
                <h4>ติดต่อสะดวก</h4>
                <p>สามารถติดต่อส่งซ่อมกับเรา ได้ทั้งทางหน้าร้านและออนไลน์</p>
              </div>
            </div><!-- End Icon Box -->

            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
              <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-clock"></i>
                <h4>รวดเร็ว</h4>
                <p>มีการซ่อมที่รวดเร็ว ไม่นานจนเกินไป</p>
              </div>
            </div><!-- End Icon Box -->

            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
              <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-tools"></i>
                <h4>มีผู้เชี่ยวชาญ</h4>
                <p>เรามีผู้เชี่ยวชาญในการซ่อม ดังนั้นท่านจะได้รับบริการจากช่างผู้เชี่ยวชาญอย่างแน่นอน</p>
              </div>
            </div><!-- End Icon Box -->

          </div>
        </div>

      </div>

    </div>
  </section>
  <!-- End Features -->

  <!-- ======= REVIEW Section ======= -->
  <section id="gallery" class="gallery">
    <div class="container-fluid">

      <div class="section-title text-center">
        <h2>REVIEW</h2>
        <p>ภาพรีวิวบางส่วนจากทางร้าน</p>
      </div>

      <div class="row g-0">

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="gallery-item">
            <img src="img/review/383970602_823379349790406_6690656903408277112_n.jpg" alt="" class="img-fluid">
          </div>
        </div>

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="gallery-item">
            <img src="img/review/375598797_808268331301508_2174038410938474552_n.jpg" alt="" class="img-fluid">
          </div>
        </div>

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="gallery-item">
            <img src="img/review/387094307_828601502601524_7975221138491196415_n.jpg" alt="" class="img-fluid">
          </div>
        </div>

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="gallery-item">
            <img src="img/review/383006980_822737626521245_1136385593892097670_n.jpg" alt="" class="img-fluid">
          </div>
        </div>

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="gallery-item">
            <img src="img/review/391650041_835762578552083_8354594631154264069_n.jpg" alt="" class="img-fluid">
          </div>
        </div>

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="gallery-item">
            <img src="img/review/366986258_793333816128293_3955095931783667611_n.jpg" alt="" class="img-fluid">
          </div>
        </div>

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="gallery-item">
            <img src="img/review/366722333_791445006317174_3605743124027557854_n.jpg" alt="" class="img-fluid">
          </div>
        </div>

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="gallery-item">
            <img src="img/review/393369930_836411291820545_5293328076192840653_n.jpg" alt="" class="img-fluid">
          </div>
        </div>

      </div>

    </div>
  </section><!-- End REVIEW Section -->

  <!-- ======= Guarantee Logo Section ======= -->
  <section id="clients" class="clients clients">
    <div class="container">

      <div class="row">

        <div class="col-lg-2 col-md-4 col-6">
          <img src="img/guarantee/300362600_782934319427391_2334636618198316713_n-removebg-preview.png" class="img-fluid aos-init aos-animate" alt="" data-aos="zoom-in">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="img/guarantee/a034lw-removebg-preview.png" class="img-fluid aos-init aos-animate" alt="" data-aos="zoom-in" data-aos-delay="100">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="img/guarantee/g0x2wl-removebg-preview.png" class="img-fluid aos-init aos-animate" alt="" data-aos="zoom-in" data-aos-delay="200">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="img/guarantee/logo-npe-removebg-preview.png" class="img-fluid aos-init aos-animate" alt="" data-aos="zoom-in" data-aos-delay="300">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="img/guarantee/logo-removebg-preview.png" class="img-fluid aos-init aos-animate" alt="" data-aos="zoom-in" data-aos-delay="400">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="img/guarantee/download-removebg-preview.png" class="img-fluid aos-init aos-animate" alt="" data-aos="zoom-in" data-aos-delay="500">
        </div>

      </div>

    </div>
  </section><!-- End Guarantee Logo Section -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

      <div class="section-header text-center">
        <h2>Contact</h2>
      </div>

      <div class="mb-3">
        <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.303866314885!2d102.0650244759325!3d13.820783395690919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311c83a14e936047%3A0x6106f4f477627c7f!2z4Lit4LiZ4Lix4LiZ4LiV4LmM4Lit4Li04LmA4Lil4LmH4LiB4LiX4Lij4Lit4LiZ4Li04LiB4Liq4LmM!5e0!3m2!1sth!2sth!4v1697529995770!5m2!1sth!2sth" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div><!-- End Google Maps -->

      <div class="row gy-4">

        <div class="col-md-6">
          <div class="info-item  d-flex align-items-center">
            <i class="icon bi bi-map flex-shrink-0"></i>
            <div>
              <h3>ที่อยู่</h3>
              <p>175 ถ.สุวรรณศร อ.เมืองสระแก้ว ต.สระแก้ว จ.สระแก้ว, Sa Kaeo, Thailand, Sa Kaeo</p>
            </div>
          </div>
        </div><!-- End Info Item -->

        <div class="col-md-6">
          <div class="info-item d-flex align-items-center">
            <i class="icon bi bi-envelope flex-shrink-0"></i>
            <div>
              <h3>Email Us</h3>
              <p>Anan_Electronic@gmail.com</p>
            </div>
          </div>
        </div><!-- End Info Item -->

        <div class="col-md-6">
          <div class="info-item  d-flex align-items-center">
            <i class="icon bi bi-telephone flex-shrink-0"></i>
            <div>
              <h3>Call Us</h3>
              <p>0856993391</p>
            </div>
          </div>
        </div><!-- End Info Item -->

        <div class="col-md-6">
          <div class="info-item  d-flex align-items-center">
            <i class="icon bi bi-share flex-shrink-0"></i>
            <div>
              <h3>เปิดทำการ</h3>
              <div><strong>จันทร์-ศุกร์:</strong> 8:00 น. – 17:00 น.;
                <strong>เสาร์-อาทิตย์:</strong> 8:00 น. – 17:00 น.
              </div>
            </div>
          </div>
        </div><!-- End Info Item -->
      </div>
    </div>
  </section><!-- End Contact Section -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <html>
  <script>
    /**
     * Scroll top button
     */
    const scrollTop = document.querySelector('.scroll-top');
    if (scrollTop) {
      const togglescrollTop = function() {
        window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
      }
      window.addEventListener('load', togglescrollTop);
      document.addEventListener('scroll', togglescrollTop);
      scrollTop.addEventListener('click', window.scrollTo({
        top: 0,
        behavior: 'smooth'
      }));
    }
  </script>

  <!-- footer-->
  <?php
  include('footer/footer.php')
  ?>
  <!-- end footer-->

  <!-- Sweet Alert Show Start -->
  <?php
  if (isset($_SESSION['add_data_alert'])) {
    if ($_SESSION['add_data_alert'] == 0) {
      if (isset($_SESSION['add_line_alert'])) {
        if (isset($_SESSION['add_new_line_alert']) && $_SESSION['add_new_line_alert'] == 0) {
  ?>
          <script>
            Swal.fire({
              title: 'Line ของคุณได้ทำการผูกกับบัญชี Email เก่าของคุณแล้ว',
              text: 'รายการเก่าของคุณยังคงอยู่',
              icon: 'success',
              confirmButtonText: 'Accept'
            });
          </script>
        <?php
          unset($_SESSION['add_data_alert']);
          unset($_SESSION['add_line_alert']);
        } else {
        ?>
          <script>
            Swal.fire({
              title: 'Line Login เสร็จสิ้น',
              text: 'กด Accept เพื่อออก',
              icon: 'success',
              confirmButtonText: 'Accept'
            });
          </script>
        <?php
          unset($_SESSION['add_data_alert']);
          unset($_SESSION['add_line_alert']);
        }
      } else {
        ?>
        <script>
          Swal.fire({
            title: 'เข้าสู่ระบบเสร็จสิ้น',
            text: 'กด Accept เพื่อออก',
            icon: 'success',
            confirmButtonText: 'Accept'
          });
        </script>
      <?php
        unset($_SESSION['add_data_alert']);
      }
      $id = 123; // Replace 123 with the actual ID you want to pass to the deletion action

    } else if ($_SESSION['add_data_alert'] == 1) {
      ?>
      <script>
        Swal.fire({
          title: 'ข้อมูล Email กับ Password \nไม่ถูกต้อง ',
          text: 'กด Accept เพื่อออก',
          icon: 'error',
          confirmButtonText: 'Accept'
        });
      </script>

    <?php
      unset($_SESSION['add_data_alert']);
    } else if ($_SESSION['add_data_alert'] == 3) {
    ?>
      <script>
        Swal.fire({
          title: 'ข้อมูล Email หรือ เบอร์โทรศัพท์นี้ถูกใช้งานแล้ว ',
          text: 'กด Accept เพื่อออก',
          icon: 'error',
          confirmButtonText: 'Accept'
        });
      </script>

    <?php
      unset($_SESSION['add_data_alert']);
    } else if ($_SESSION['add_data_alert'] == 4) {
    ?>
      <script>
        Swal.fire({
          title: 'สมัครบัญชีผู้ใช้ของคุณเสร็จสิ้น',
          text: 'กด Accept เพื่อออกและทำการ Login',
          icon: 'success',
          confirmButtonText: 'Accept'
        });
      </script>
    <?php
      unset($_SESSION['add_data_alert']);
    } else if ($_SESSION['add_data_alert'] == 5) {
    ?>
      <script>
        Swal.fire({
          title: 'แก้ไขข้อมูลของคุณเสร็จสิ้น',
          text: 'กด Accept เพื่อออก',
          icon: 'success',
          confirmButtonText: 'Accept'
        });
      </script>
    <?php
      unset($_SESSION['add_data_alert']);
    } else if ($_SESSION['add_data_alert'] == 6) {
    ?>
      <script>
        Swal.fire({
          title: 'ข้อมูลไม่ถูกต้อง',
          text: 'กด Accept เพื่อออก',
          icon: 'error',
          confirmButtonText: 'Accept'
        });
      </script>

  <?php
      unset($_SESSION['add_data_alert']);
    }
  }
  ?>
  <!-- Sweet Alert Show End -->

  <!-- <script>
    // Show full page LoadingOverlay
    $.LoadingOverlay("show");

    // Hide it after 3 seconds
    setTimeout(function() {
      $.LoadingOverlay("hide");
    }, 10);
  </script> -->
  <script>
    var emailAddresses = [
      <?php
      $sql = "SELECT m_email FROM member WHERE del_flg = '0'";
      $result = mysqli_query($conn, $sql);
      $first = true;
      while ($row_c = mysqli_fetch_array($result)) {
        if (!$first) {
          echo ", ";
        }
        echo "\"" . $row_c['m_email'] . "\"";
        $first = false;
      }
      echo ", ";
      $sql1 = "SELECT e_email FROM employee WHERE del_flg = '0'";
      $result1 = mysqli_query($conn, $sql1);
      $first1 = true;
      while ($row_c = mysqli_fetch_array($result1)) {
        if (!$first1) {
          echo ", ";
        }
        echo "\"" . $row_c['e_email'] . "\"";
        $first1 = false;
      }
      ?>
    ];

    var TelAddresses = [
      <?php
      $sql = "SELECT m_tel FROM member WHERE del_flg = '0'";
      $result = mysqli_query($conn, $sql);
      $first = true;
      while ($row_c = mysqli_fetch_array($result)) {
        if (!$first) {
          echo ", ";
        }
        echo "\"" . $row_c['m_tel'] . "\"";
        $first = false;
      }
      echo ", ";
      $sql1 = "SELECT e_tel FROM employee WHERE del_flg = '0'";
      $result1 = mysqli_query($conn, $sql1);
      $first1 = true;
      while ($row_c = mysqli_fetch_array($result1)) {
        if (!$first1) {
          echo ", ";
        }
        echo "\"" . $row_c['e_tel'] . "\"";
        $first1 = false;
      }
      ?>
    ];

    function checkEmail() {
      var inputElement = document.getElementById('inputPasswordEmail');
      var errorElement = document.getElementById('email-error');
      var inputValue = inputElement.value;

      if (emailAddresses.includes(inputValue)) {
        errorElement.style.display = 'inline';
      } else {
        errorElement.style.display = 'none';
      }
    }

    function checkTel() {
      var inputElement = document.getElementById('inputPasswordTel');
      var errorElement = document.getElementById('tel-error');
      var inputValue = inputElement.value;

      if (TelAddresses.includes(inputValue)) {
        errorElement.style.display = 'inline';
      } else {
        errorElement.style.display = 'none';
      }
    }

    document.getElementById('inputPasswordEmail').addEventListener('keyup', checkEmail);
    document.getElementById('inputPasswordTel').addEventListener('keyup', checkTel);
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

  </script>
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
                  <h2>ยินดีต้อนรับสู่ร้าน Anan Electronic</h2><br>
                  <h4>เข้าสู่ระบบ</h4>
                </div>
                <form action="action/register.php" method="POST">
                  <div class="input-group">
                    <input type="email" class="input-field" id="email" name="email" onblur="checkEmail()" required>
                    <label for="email">Email</label>
                    <span id="email-error" style="color: red; font-size: 12px; display: none;">
                      <button class="btn btn-danger" style="font-size: 12px; padding : -2px">
                        อีเมลนี้ถูกใช้งานแล้วโดยบัญชีอื่น
                      </button>
                    </span>

                    <script>
                      document.addEventListener("DOMContentLoaded", function() {
                        var emailError = document.getElementById("email-error");
                        var emailInput = document.getElementById('email');

                        function showError() {
                          emailError.style.display = 'block';
                          emailInput.setCustomValidity('มีข้อมูลอยู่แล้ว');
                        }

                        function hideError() {
                          emailError.style.display = 'none';
                          emailInput.setCustomValidity('');
                        }

                        emailInput.addEventListener('input', hideError); // Hide the error on input change

                        function checkEmail() {
                          var email = emailInput.value;

                          if (emailInput.validity.valid) {
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                              if (this.readyState == 4 && this.status == 200) {
                                if (this.responseText === 'exists') {
                                  showError();
                                } else {
                                  hideError();
                                }
                              }
                            };
                            xhttp.open('GET', 'action/check_email.php?email=' + encodeURIComponent(email), true);
                            xhttp.send();
                          } else {
                            hideError();
                          }
                        }

                        emailInput.addEventListener('blur', checkEmail); // Trigger checkEmail() on blur event
                      });
                    </script>
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
  <center>
    <div>
      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="width: 100%;">
        <div class="carousel-inner bigimg" style="height: 50%">
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



  <!-- <div class="p-5">
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
  </div> -->

  <!-- Hero -->
  <div class="px-1 py-1 my-1 text-center">
    <img class="d-block mx-auto my-4 imglogo" src="img brand/anelogo.png" alt="" width="20%">

    <h1 class="display-5 fw-bold text-body-emphasis mt-2">ANE อนันต์อิเล็กทรอนิกส์</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">จำหน่ายและซ่อมเครื่องเสียงทุกชนิด โดยทีมงานมืออาชีพมากประสบการณ์ที่พร้อมจะบริการ การันตรีทั้งคุณภาพและประสิทธิภาพของผลลัพธ์</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <button type="button" class="btn btn-primary btn-lg px-4 gap-3">ส่งซ่อม</button>
        <button type="button" class="btn btn-outline-secondary btn-lg px-4">วิธีการส่งซ่อม</button>
      </div>
    </div>
  </div>
  <!-- End Hero -->
  <div>
    <?php
    if (isset($_SESSION['profile'])) {
      $profile = $_SESSION['profile'];
    }
    ?>
    <h1>Welcome , <?= $profile->name; ?></h1>
    <p class="lead">Your Email : <?= $profile->email; ?></p>
    <p class="lead">Line ID : <?= $profile->line_id; ?></p>
    <img width="200px" src="<?php echo $profile->picture  ?>" class="rounded" alt="Profile Picture">
  </div>
  <!-- Features -->
  <div class="container px-4 py-5" id="custom-cards">
    <h2 class="pb-2 border-bottom">ทำไมต้องเลือกเรา?</h2>

    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('https://www.shutterstock.com/th/blog/wp-content/uploads/sites/16/2020/10/shutterstock_509699914.jpg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">เช็คสถานะสินค้าได้ทุกที่ทุกเวลา</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
                <img src="data:image/png;base64,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" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
              </li>
              <li class="d-flex align-items-center me-3">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#geo-fill"></use>
                </svg>
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#calendar3"></use>
                </svg>
                <small>สามารถเช็คสถานะของสินค้าได้ด้วยตัวเองผ่านเว็ปแอพลิเคชั่น</small>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('https://p4.wallpaperbetter.com/wallpaper/805/526/459/target-4k-windows-background-wallpaper-thumb.jpg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">เจาะตรงเป้าหมาย แก้ปัญหาถูกจุด</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
                <img src="data:image/png;base64,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" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
              </li>
              <li class="d-flex align-items-center me-3">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#geo-fill"></use>
                </svg>
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#calendar3"></use>
                </svg>
                <small>วางแผนการซ่อมแซมได้อย่างรวดเร็ว แม่นยำ เหมาะสม และมีการรับประกันครอบคลุมถึง1ปี</small>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('https://i.pinimg.com/originals/99/c3/b2/99c3b240b8a64b392a009f6192c2afd1.jpg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">ครอบคลุมทุกแพลตฟอร์ม</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="d-flex align-items-center me-3">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#geo-fill"></use>
                </svg>
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#calendar3"></use>
                </svg>
                <small>เว็ปแอพลิเคชั่นขยายฐานการเข้าถึงกลุ่มลูกค้าได้อย่างเหมาะสม เพื่อความสะดวก ใช้งานง่าย</small>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Features -->

  <!-- -ขอแปะเป็นรูปไว้ก่อน -->
  <div class="px-1 py-1 my-1 text-center">
    <img class="d-block mx-auto my-4 imglogo" src="img brand/S__4358151.jpg" alt="" width="100%">
  </div>
  <!-- End ขอแปะเป็นรูปไว้ก่อน -->


  <html>

  <head>
    <style>
      .my-div {
        padding-top: 700px;
      }
    </style>
  </head>

  <body>
    <div class="my-div">
      <!-- สโลแกน -->
      <main class="px-3">
        <div class="px-1 py-1 my-1 text-center">
          <h1>รู้ดีกว่าช่าง กรุณาซ่อมเอง</h1>
          <p class="lead">ANAN ELECTRONIC</p>
          <p class="lead">
            <a href="#" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Learn more</a>
        </div>
        </p>
      </main>
      <!-- End สโลแกน -->
    </div>
  </body>

  </html>


  <!-- รีวิว -->
  <div class="px-1 py-1 my-1 text-center">
    <img class="d-block mx-auto my-4 imglogo" src="img brand/S__4358153.jpg" alt="" width="100%">
    <img class="d-block mx-auto my-4 imglogo" src="img brand/S__4358154.jpg" alt="" width="100%">
  </div>
  <!-- End รีวิว -->

  <html>

  <head>
    <style>
      .my-div {
        padding-top: 200px;
        padding-bottom: 200px;
      }
    </style>
  </head>

  <body>
    <div class="my-div">
      <!-- Features อันสุดท้าย -->
      <main class="px-3">
        <div class="px-1 py-1 my-1 text-center">
          <h1>COMING SOON</h1>
          <p class="lead">สินค้าเข้าใหม่จากทางร้านที่พร้อมให้บริการคุณ</p>
          <p class="lead">
            <a href="#" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Learn more</a>
        </div>
        </p>
      </main>
      <!-- End Featuresอันสุดท้าย -->
    </div>
  </body>

  </html>


  <!-- แนะนำสินค้า -->
  <div class="px-1 py-1 my-1 text-center">
    <img class="d-block mx-auto my-4 imglogo" src="img brand/S__4358156.jpg" alt="" width="100%">
  </div>
  <!-- End แนะนำสินค้า -->
  <html>

  <!-- footer-->
  <?php
  include('footer/footer.php')
  ?>
  <!-- end footer-->

  <!-- Sweet Alert Show Start -->
  <?php
  if (isset($_SESSION['add_data_alert'])) {
    if ($_SESSION['add_data_alert'] == 0) {
      if($_SESSION['add_line_alert'] == 0){
        if(isset($_SESSION['add_new_line_alert']) && $_SESSION['add_new_line_alert'] == 0){
          ?>
          <script>
            Swal.fire({
              title: 'Line ของคุณได้ทำการผูกกับบัญชี Email เก่าของคุณแล้ว',
              text: 'รายการเก่าของคุณยังอยู่',
              icon: 'success',
              confirmButtonText: 'Accept'
            });
          </script>
        <?php
          unset($_SESSION['add_data_alert']);
          unset($_SESSION['add_line_alert']);
        }else{
          ?>
          <script>
            Swal.fire({
              title: 'ใช้ Line ในการ Login เสร็จสิ้น',
              text: 'กด Accept เพื่อออก',
              icon: 'success',
              confirmButtonText: 'Accept'
            });
          </script>
        <?php
          unset($_SESSION['add_data_alert']);
          unset($_SESSION['add_line_alert']);
        }
       
      }else{
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
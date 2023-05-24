<!-- footer-->
<!-- <div class="container-fluid fixed-bottom" style="background-color: #000141;">
    <footer class="my-4 px-5">
      <div class="">
        <p style="color: white;">Copyright © 2023 MY SHOP. สงวนสิทธิ์ทุกประการ</p>
        <p style="color: white;">ติดต่อ 0000-00-0000 </p>
      </div>
    </footer>
  </div> -->
<!-- end footer-->

<style>
  /* body {
    background: #ff5f6d;
    background: -webkit-linear-gradient(to right, #ff5f6d, #ffc371);
    background: linear-gradient(to right, #ff5f6d, #ffc371);
    min-height: 100vh;
  } */

  /* #button-addon1 {
    color: #ffc371;
  } */

  /* i {
    color: #ffc371;
  } */

  .form-control::placeholder {
    font-size: 0.95rem;
    color: #aaa;
    font-style: italic;
  }

  .form-control.shadow-0:focus {
    box-shadow: none;
  }

  footer {
    background: #E5E5E5;
    background: -webkit-linear-gradient(to right, #E5E5E5, #FFFFFF);
    background: linear-gradient(to right, #E5E5E5, #FFFFFF);
  }

  .copy-button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 14px;
    color: blue;
    text-decoration: none;
    display: inline;
  }

  .success-message {
    display: none;
    font-size: 12px;
    color: green;
    opacity: 0;
    transition: opacity 0.5s;
  }

  .fade-in {
    opacity: 1;
  }
</style>
<!-- Footer -->
<br>
<footer class="mt-4 " style="background: #E7F0FE;">
  <div class="container">
    <div class="row py-4">
      <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
        <img src="img brand/anelogo.png" alt="" width="180" class="mb-3">
        <!-- <h3 class="font-italic text-uppercase" style="color: #000141;">Anan Electronic</h3> -->
        <p> พร้อมให้บริการด้วยคุณภาพจากผู้ชำนาญการพิเศษด้านเครื่องดนตรี ที่มีประสบการณ์ด้านการซ่อมยาวนาน ผ่านการฝึกอบรม เพื่อรองรับทุกปัญหาของคุณด้วยคุณภาพสูงสุด</p>
        <!-- <ul class="list-inline mt-4">
          <li class="list-inline-item"><a href="#" target="_blank" title="twitter"><i class="fa fa-twitter" >a</i></a></li>
          <li class="list-inline-item"><a href="#" target="_blank" title="facebook"><i class="fa fa-facebook" >a</i></a></li>
          <li class="list-inline-item"><a href="#" target="_blank" title="instagram"><i class="fa fa-instagram" >a</i></a></li>
          <li class="list-inline-item"><a href="#" target="_blank" title="pinterest"><i class="fa fa-pinterest">a</i></a></li>
          <li class="list-inline-item"><a href="#" target="_blank" title="vimeo"><i class="fa fa-vimeo">a</i></a></li>
        </ul> -->
      </div>
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <h5 class="text-uppercase font-weight-bold mb-4">ติดต่อเรา</h5>
        <ul class="list-unstyled mb-0">
          <!-- <li class="mb-2"><a href="#" class="" style="text-decoration: none; color: black;">Tel : 085-699-3391</a></li> -->
          <p style="display: inline">Tel:</p>
          <button onclick="copyHTML()" class="copy-button" style="display: inline;">085-699-3391<h6 style="display: inline; color: green; margin-left: 10px">Click to copy</h6></button>
          <button class="success-message btn btn-success" id="successMessage" style="color: white; display: none;">Copied successfully!</button>

          <script>
            function copyHTML() {
              var phoneNumber = '0856993391';
              var tempElement = document.createElement('textarea');
              tempElement.value = phoneNumber;
              document.body.appendChild(tempElement);
              tempElement.select();
              document.execCommand('copy');
              document.body.removeChild(tempElement);
              showSuccessMessage();
            }

            function showSuccessMessage() {
              var successMessage = document.getElementById('successMessage');
              successMessage.style.display = 'block';
              successMessage.classList.add('fade-in');
              setTimeout(function() {
                successMessage.classList.remove('fade-in');
                successMessage.style.display = 'none';
              }, 2000);
            }
          </script>

          <li class="mb-2"><a href="#" class="" style="text-decoration: none; color: black;">Email : Anan_Electronic@gmail.com</a></li>

          <button class="btn btn-success">
            <li class="mb-2 mt-2"><img src="img icon/line.png" alt="" style=" width: 30px; height: 30px; border-radius: 20%;"><a href="#" class="" style="text-decoration: none; color: white;"> Anan_Electronic</a></li>
          </button>
          <button class="btn btn-primary">
            <li class="mb-2 mt-2"><img src="img icon/Facebook.png" alt="" style=" width: 30px; height: 30px; border-radius: 20%;"><a href="https://www.facebook.com/Fresh.Pongsakorn" class="" style="text-decoration: none; color: white;" target="_blank"> Anan_Electronic</a></li>
          </button>
        </ul>
      </div>
      <!-- <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h6 class="text-uppercase font-weight-bold mb-4">Company</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="#" class="text-muted">Login</a></li>
          <li class="mb-2"><a href="#" class="text-muted">Register</a></li>
          <li class="mb-2"><a href="#" class="text-muted">Wishlist</a></li>
          <li class="mb-2"><a href="#" class="text-muted">Our Products</a></li>
        </ul>
      </div> -->
      <div class="col-lg-3 col-md-6 mb-lg-0">
        <h5 class="text-uppercase font-weight-bold mb-4">ที่อยู่</h5>
        <p class="mb-4">175 ถ.สุวรรณศร อ.เมืองสระแก้ว ต.สระแก้ว จ.สระแก้ว, Sa Kaeo, Thailand, Sa Kaeo</p>
        <!-- <div class="p-1 rounded border">
          <div class="input-group">
            <input type="email" placeholder="Enter your email address" aria-describedby="button-addon1" class="form-control border-0 shadow-0">
            <div class="input-group-append">
              <button id="button-addon1" type="submit" class="btn btn-link"><i class="fa fa-paper-plane"></i></button>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </div>

  <!-- Copyrights -->
  <div class=" py-3" style="background: #000141;">
    <div class="container text-center">
      <p class="mb-0 py-2" style="color: #8996a1;"> Copyright 2023 © Anan Electronic Sakaeo.</p>
    </div>
  </div>
</footer>
<!-- End -->
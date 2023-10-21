<style>
  /* Add the styles for the footer and other elements here */

  html,
  body {
    height: 100%;
    margin: 0;
    padding: 0;
  }

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
<br><br>
<footer style="background: #E7F0FE;">
  <div class="container">
    <div class="row py-4">
      <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
        <img src="img brand/anelogo.png" alt="" width="180" class="mb-3">
        <p> พร้อมให้บริการด้วยคุณภาพจากผู้ชำนาญการพิเศษด้านเครื่องดนตรี ที่มีประสบการณ์ด้านการซ่อมยาวนาน ผ่านการฝึกอบรม เพื่อรองรับทุกปัญหาของคุณด้วยคุณภาพสูงสุด</p>
      </div>
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <h5 class="text-uppercase font-weight-bold mb-4">ติดต่อเรา</h5>
        <ul class="list-unstyled mb-0">
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
          <br>
          <button class="btn btn-outline-light">
            <li class="mb-2 mt-2"><img src="img icon/line.png" alt="" style=" width: 30px; height: 30px; border-radius: 20%;"><a href="#" class="" style="text-decoration: none; color: green;"> Anan_Electronic</a></li>
          </button>
          <button class="btn btn-outline-light">
            <li class="mb-2 mt-2"><img src="img icon/Facebook.png" alt="" style=" width: 30px; height: 30px; border-radius: 20%;"><a href="https://www.facebook.com/Fresh.Pongsakorn" class="" style="text-decoration: none; color: blue;" target="_blank"> Anan_Electronic</a></li>
          </button>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 mb-lg-0">
        <h5 class="text-uppercase font-weight-bold mb-4">ที่อยู่</h5>
        <p class="mb-4">175 ถ.สุวรรณศร อ.เมืองสระแก้ว ต.สระแก้ว จ.สระแก้ว, Sa Kaeo, Thailand, Sa Kaeo</p>
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
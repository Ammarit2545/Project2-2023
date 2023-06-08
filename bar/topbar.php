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
        <a class="nav-link active" aria-current="page" href="#">หน้าหลัก</a>
        <a class="nav-link" href="#">ส่งซ่อม</a>
        <a class="nav-link" href="#">ติดตาม</a>
        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">ประวัติ</a>
      </div>
    </div>
    <div class="col-md-3 text-end">
      <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Register">Sign-up</button>
    </div>
  </div>
</nav>
<!-- end navbar-->
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
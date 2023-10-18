<?php
session_start();
?>
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
<!-- navbar-->
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#" style="color: #000141;">
      <h4>Anan Electronic</h4>
      <img src="../img brand/anelogo.png" alt="">
    </a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ps-5">
        <a class="nav-link active" aria-current="page" href="#">หน้าหลัก</a>
        <a class="nav-link" href="#">ส่งซ่อม</a>
        <a class="nav-link" href="#">ติดตาม</a>
        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">ประวัติ</a>
        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">สำเร็จ</a>
      </div>
    </div>
    <div class="col-md-3 text-end">

      <?php
      if (!isset($_SESSION['profile'])) {
        $line = new LineLogin();
        $link = $line->getLink();
      ?>
        <!-- <a href="<?php echo $link; ?>" class="btn btn-success">Line Login</a> -->
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Register">Sign-up</button>
      <?php
      } else {
      ?>
        <!-- <li><a class="dropdown-item" onclick="logout()">Log out</a></li> -->
        <a href="action/logout.php" class="btn btn-outline-primary">Log out</a>
      <?php
      }
      ?>

      <!-- 
      <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Register">Sign-up</button> -->
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
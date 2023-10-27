<?php
session_start();
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
<header class="header fixed-top d-flex align-items-center sticked">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="#" class="logo d-flex align-items-center me-auto me-lg-0" style="text-decoration: none;">
      <img src="img brand/anelogo.png" width="120px" alt="">
    </a>

    <div>
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
    </div>
  </div>
</header>
<!-- end navbar-->
<style>
  body {
    font-family: sans-serif;
  }

  /* CSS for the scroll-to-top button */
  /* .scroll-top {
    position: fixed;
    visibility: hidden;
    opacity: 0;
    right: 15px;
    bottom: 15px;
    z-index: 99999;
    background: #ec2727;
    width: 44px;
    height: 44px;
    border-radius: 50px;
    transition: all 0.4s;
  }

  .scroll-top i {
    font-size: 24px;
    color: #fff;
    line-height: 0;
  }

  .scroll-top:hover {
    background: #ec2727;
    color: #fff;
  }

  .scroll-top.active {
    visibility: visible;
    opacity: 1;
  } */

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

  /*--------------------------------------------------------------
# Mobile Navigation
--------------------------------------------------------------*/
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

  .btn {
    border-radius: 50px;
    padding: 8px 20px;
  }
</style>
<!-- Your web content here -->

<!-- Scroll-to-top button -->
<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- JavaScript for scrolling to top -->
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
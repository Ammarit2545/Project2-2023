<?php
session_start();
include('database/condb.php');

if (!isset($_SESSION["id"])) {
  header('Location:home.php');
}

$id = $_SESSION["id"];

$sql = "SELECT * FROM member WHERE m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if (isset($_GET["search"])) {
  $search = $_GET["search"];
  $search = rtrim($search);
}

if (isset($_GET["status_id"])) {
  $status_id = $_GET["status_id"];
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
  <link rel="stylesheet" href="css/repair_non_gua.css">
  <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
  <title>ANE - Support</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

  </script>
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
  <style>
    #card_sent {
      text-decoration: none;
    }

    .search-form {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    input[type="text"] {
      padding: 10px;
      width: 50%;
      border: none;
      border-radius: 20px 0 0 20px;
      box-shadow: 0 1px 6px rgba(32, 33, 36, 0.28);
      font-size: 16px;
    }

    button[type="submit"] {
      padding: 10px 20px;
      background-color: #4285F4;
      border: none;
      border-radius: 0 20px 20px 0;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }

    @media only screen and (max-width: 600px) {

      #date_time,
      #body_text {
        font-size: 14px;
      }

      #title_main {
        font-size: 24px;
      }

      #head_text {
        font-size: 16px;
      }
    }

    @media only screen and (max-width: 1215px) {
      #select_under {
        display: inline;
      }

      #bar_under {
        display: none;
      }
    }

    @media only screen and (min-width: 1215px) {
      #select_under {
        display: none;
      }
    }
  </style>
</head>

<body>

  <!-- navbar-->
  <?php
  include('bar/topbar_user.php');
  ?>
  <!-- end navbar-->

  <div class="background"></div>

  <div class="px-5 pt-5 edit">

    <?php if (!isset($_GET["search"])) { ?>
      <h1 class="pt-5 text-center" id="title_main">ข้อมูลการซ่อมทั้งหมดของคุณ <?= $row['m_fname'] . " " . $row['m_lname']  ?></h1>
    <?php } else { ?>
      <h1 class="pt-5 text-center">ผลการหาข้อมูล "<?= $search ." ". $status_id ?>" </h1>
    <?php } ?>
    <br>
    <div class="container">
      <div class="row">
        <div class="col-2"></div>
        <div class="col">
          <center>
            <!-- <select class="form-select" aria-label="Default select example" id="select_under">
              <option selected>ทั้งหมด</option>
              <option value="1"><a href="home.php">ที่ต้องชำระ</a></option>
              <option value="2">กำลังดำเนินการ</option>
              <option value="3">ที่ต้องจัดส่ง</option>
              <option value="2">รอการยืนยัน</option>
              <option value="3">สำเร็จ</option>
              <option value="2">ยกเลิกแล้ว</option>
            </select> -->
            <ul class="nav nav-tabs" id="select_under">

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="box-shadow: 0 1px 6px rgba(32, 33, 36, 0.28);">ทั้งหมด</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="status.php">ทั้งหมด</a></li>
                <?php
              $sql_s = "SELECT * FROM `status_type`";
              $result_s = mysqli_query($conn, $sql_s);

              while ($row_s = mysqli_fetch_array($result_s)) {
              ?>
                <li class="nav-item">
                  <li> <a class="dropdown-item" href="status.php?status_id=<?= $row_s['status_id'] ?>&search=<?= $search ?>"><?= $row_s['status_name'] ?></a></li>
                </li>
              <?php } ?>
                  <!-- <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#">Separated link</a></li> -->
                </ul>
              </li>

            </ul>
          </center>
          <center>
            <ul class="nav nav-tabs" id="bar_under">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="status.php">ทั้งหมด</a>
              </li>
              <?php
              $sql_s = "SELECT * FROM `status_type`";
              $result_s = mysqli_query($conn, $sql_s);

              while ($row_s = mysqli_fetch_array($result_s)) {
              ?>
                <li class="nav-item">
                  <a class="nav-link" href="status.php?status_id=<?= $row_s['status_id'] ?>&search=<?= $search ?>"><?= $row_s['status_name'] ?></a>
                </li>
              <?php } ?>
              <!-- <li class="nav-item">
                <a class="nav-link " href="#">กำลังดำเนินการ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="#">ที่ต้องจัดส่ง</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="#">รอการยืนยัน</a>
              </li> -->
              <!-- <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li> -->
              <!-- <li class="nav-item">
                <a class="nav-link" href="#">สำเร็จ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="status.php?status_id=11&search=<?= $search ?>">ยกเลิกแล้ว</a>
              </li> -->
              <!-- <li class="nav-item">
              <a class="nav-link" href="#">การคืนเงิน</a>
            </li> -->
            </ul>
          </center>
        </div>
        <div class="col-2"></div>
      </div>
    </div>
    <br>
    <form class="search-form" action="status.php" method="GET">
      <input type="text" name="search" placeholder="หาด้วยเลข Serial Number ,ชื่อแบรนด์ ,ชื่อรุ่น" value="<?= $search ?>">
      <button type="submit">Search</button>
    </form>
    <br>
    <!-- <center>
      <hr width="70%">
    </center> -->
    <!-- <center>
      <hr width="70%">
    </center> -->

    <form action="action/add_repair_non_gua.php" method="POST">
      <div class="container">
        <div class="row">
          <?php
          if (!isset($search) && !isset($status_id)) {
            $sql = "SELECT * FROM `get_repair` 
            LEFT JOIN repair ON get_repair.r_id = repair.r_id
            WHERE m_id= '$id' ORDER BY get_repair.get_r_date_in DESC;";
          }
          elseif ($status_id > 0) {
              $sql="SELECT get_repair.*, repair.*, rs.status_id
              FROM get_repair
              LEFT JOIN repair ON get_repair.r_id = repair.r_id
              LEFT JOIN (
                SELECT get_r_id, MAX(rs_date_time) AS max_date
                FROM repair_status
                GROUP BY get_r_id
              ) AS subquery ON get_repair.get_r_id = subquery.get_r_id
              LEFT JOIN repair_status AS rs ON subquery.get_r_id = rs.get_r_id AND subquery.max_date = rs.rs_date_time
              WHERE repair.m_id = '$id' AND rs.status_id = '$status_id' AND rs.rs_date_time = subquery.max_date
              ORDER BY get_repair.get_r_date_in DESC;
              ";
          } else {
            $sql = "SELECT * FROM get_repair 
            LEFT JOIN repair ON get_repair.r_id = repair.r_id 
            WHERE m_id = '$id' AND (repair.r_brand LIKE '%$search%' 
            OR repair.r_model LIKE '%$search%' 
            OR repair.r_serial_number LIKE '%$search%' 
            OR CONCAT(repair.r_brand,' ',repair.r_model) LIKE '%$search%' 
            OR CONCAT(repair.r_brand,'',repair.r_model) LIKE '%$search%') 
            ORDER BY get_repair.get_r_date_in DESC;";
          }
          $result = mysqli_query($conn, $sql);
          $i = 0;
          $found_data = false;

          while ($row1 = mysqli_fetch_array($result)) {
            $i = $i + 1;
            $id_r = $row1[0];
            $sql_c = "SELECT * FROM get_repair WHERE r_id = '$id_r' AND del_flg = '0' ORDER BY get_r_id DESC LIMIT 1";
            $result_c = mysqli_query($conn, $sql_c);
            $row_c = mysqli_fetch_array($result_c);

            $id_g = $row_c[0];

            $sql_s = "SELECT status_type.status_name,status_type.status_color,repair_status.status_id FROM repair_status 
            LEFT JOIN status_type ON status_type.status_id = repair_status.status_id 
            WHERE get_r_id = '$id_r' ORDER BY rs_date_time DESC LIMIT 1;";
            $result_s = mysqli_query($conn, $sql_s);
            $row_status = mysqli_fetch_array($result_s);

            // Check if data is found
            if ($row_c) {
              $found_data = true;
              // Display data
            }
          ?>
            <div class="col-md-6 mt-5">
              <a href="status_detail.php?id=<?= $id_r ?>" id="card_sent">
                <div class="card" style="box-shadow: 0px 10px 50px rgba(0, 1, 65, 0.18);">
                  <div class="card-header">
                    <h2> <button type="button" class="btn btn-primary" style="font-size:16px; display:inline-block;"><?= $i ?></button> : <?= $row1['r_brand'] ?> <?= $row1['r_model'] ?>
                      <button class="btn" style="background-color: <?= $row_status['status_color'] ?>; color:white;"><?= $row_status['status_name'] ?></button>

                      <?php if ($row1['get_r_record'] != 1) {
                      ?><button class="btn btn-outline-secondary">#ครั้งที่ <?= $row1['get_r_record'] ?> </button><?php
                                                                                                                } ?>

                    </h2>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <h5 style="color:blue" id="head_text"><?= $id_r ?> หมายเลขประจำเครื่อง : </h5>
                      <br>
                      <p style="text-align:start" id="body_text"> Serial Number : <?= $row1['r_serial_number'] ?></p>
                      <p style="text-align:start" id="body_text">Model : <?= $row1['r_number_model'] ?></p>
                    </li>
                    <?php if ($row_c['get_r_detail'] != NULL) {
                      $text = $row_c['get_r_detail'];

                      $summary = strlen($text) > 100 ? substr($text, 0, 200) . "..." : $text;
                      // echo $summary;
                    ?>
                      <li class="list-group-item">
                        <h5 style="color:blue" id="head_text">รายละเอียดการส่งซ่อม : </h5>
                        <br>
                        <p><?= $summary ?></p>
                      </li>
                    <?php }
                    $dateString = date('d-m-Y', strtotime($row_c['get_r_date_in']));
                    $date = DateTime::createFromFormat('d-m-Y', $dateString);
                    $formattedDate = $date->format('d F Y');
                    ?>
                    <li class="list-group-item">
                      <br>
                      <h5 style="color : gray" id="date_time">ส่งเรื่องล่าสุดวันที่ : <?= $formattedDate ?>, เวลา : <?= date('H:i:s', strtotime($row_c['get_r_date_in'])); ?></h5>
                    </li>
                  </ul>
                </div>
              </a>
            </div>
            <br> <br>
          <?php }
          // Display message if no data found
          if (!$found_data) { ?>
            <center>
              <br><br><br>
              <h1>"ไม่พบข้อมูลในระบบ"</h1>
            </center><?php } ?>
        </div>
      </div>
    </form>
  </div>
  </div>

  <!-- footer-->
  <?php
  // include('footer/footer.php') 
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
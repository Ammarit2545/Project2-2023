<?php
session_start();
include('database/condb.php');
$id = $_SESSION['id'];

$sql1 = "SELECT * FROM member WHERE m_id = '$id '";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);
if ($id == NULL) {
  header('Location: home.php');
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
  <link rel="stylesheet" href="css/status.css">
  <title>Status - ANE</title>
  <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
</head>

<body>
  <!-- navbar-->
  <?php
  if ($row1 > 0) {
    include('bar/topbar_invisible.php');
  }
  ?>
  <!-- end navbar-->

  <div class="background"></div>

  <div class="px-5 pt-5 repair">
    <h1 class="pt-5 text-center">การบริการส่งซ่อม MY SHOP</h1>
    <p class="pt-4 text-center">กรุณาคลิกที่ปุ่มเพื่อดู</p>
    <div class="container pt-4" id="card-container">


      <!-- <div class="body_input">
        <div class="card w-75 mx-auto viewstatus">
          <div class="card-body">
            <div class="row justify-content-between">
              <div class="col-4 text-center">
                <h4 style="padding-top: 1.5rem;">รุ่น ............. มีประกัน</h4>
              </div>
              <div class="col-4 text-center">
                <h4 class="fw-bold" style="color: red;">กรุณายืนยันการส่งซ่อม</h4>
                <p>วันที่ 00/00/0000 เวลา 00.00</p>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <?php
      $sql = "SELECT * FROM get_repair 
      LEFT JOIN repair ON repair.r_id = get_repair.r_id 
      WHERE m_id = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      $i = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $i = $i + 1;
        $id_com = $row['com_id'];

        // if ($result == NULL){
        //   echo "ไม่มีข้อมูล";
        // }
      ?>

        <a href="status_detail.php" style="text-decoration:none">
          <div class="body_input pt-5">
            <div class="card w-75 mx-auto viewstatus_2">
              <div class="card-body">
                <div class="row justify-content-between">
                  <div class="col-1 mt-4" style="color:black">
                    <center>
                      <h2><?= $i ?></h2>
                    </center>
                  </div>
                  <div class="col-5 text-center">
                    <h4 style="padding-top: 1.5rem; color : black">ยี่ห้อ : <?= $row['r_brand'] ?> </h4>
                    <h5>
                      <p style="color : black">รุ่น : <?= $row['r_model'] ?> 
                      <? if($id_com == NULL){
                        echo "ไม่มีประกัน";
                      }
                      else{
                        echo "มีประกัน";
                        } 
                        ?>
                    </p>
                    </h5>

                  </div>
                  <div class="col-6 text-center mt-1">
                    <?php
                    $id_r = $row['get_r_id'];
                    $sql2 = "SELECT * FROM repair_status LEFT JOIN status_type ON status_type.status_id = repair_status.status_id WHERE get_r_id = '$id_r' ORDER BY rs_id DESC;";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_array($result2);
                    ?>
                    <h4 class="fw-bold mt-4" style="color: <?= $row2['status_color'] ?>;"><?= $row2['status_name'] ?></h4>
                    <p><?=date('Y-m-d H:i:s', strtotime($row2['rs_date_time'])); ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>

      <?php } ?>


    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
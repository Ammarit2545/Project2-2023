<?php
  session_start();
  include('database/condb.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/edit.css">
    <title>Edit - User</title>
</head>
<body>

  <!-- navbar-->
  <?php
    include('bar/topbar_invisible.php');

    $id = $_SESSION["id"];

    $sql = "SELECT * FROM member WHERE m_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
  ?>
  <!-- end navbar-->

  <!-- <div class="background"></div> -->
  
  <div class="px-5 pt-5 edit">
    <h1 class="pt-5 text-center">แก้ไขข้อมูล</h1>
    <form action="action/edit_user.php" method="POST">
        <div class="p-5">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label fw-bold">ชื่อ</label>
                <input type="text" class="form-control input" id="exampleFormControlInput1" name="fname" value="<?= $row['m_fname'] ?>" >
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label fw-bold">นามสกุล</label>
                <input type="text" class="form-control input" id="exampleFormControlInput1" name="lname" value="<?= $row['m_lname'] ?>" >
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label fw-bold">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control input" id="exampleFormControlInput1" name="tel" value="<?= $row['m_tel'] ?>" >
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label fw-bold">ที่อยู่</label>
                <textarea class="form-control address" id="exampleFormControlTextarea1"   name="address" ><?= $row['m_add'] ?></textarea>
            </div>
            <div class="text-center pt-4">
              <button type="submit" class="btn btn_custom">ยืนยัน</button>
            </div>
        </div>
    </form>
  </div>
  

  <!-- footer-->
  <div class="container-fluid fixed-bottom" style="background-color: #000141;">
    <footer class="my-4 px-5">
      <div class="">
        <p style="color: white;">Copyright © 2023 MY SHOP. สงวนสิทธิ์ทุกประการ</p>
        <p style="color: white;">ติดต่อ 0000-00-0000 </p>
      </div>
    </footer>
  </div>
  <!-- end footer-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
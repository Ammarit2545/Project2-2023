<?php
session_start();
include('database/condb.php');




// // Recipient's email address
// $to = 'ammaritchottinnawat@gmail.com';

// // Sender's email address
// $from = 'blackblue2545@gmail.com';

// // Subject of the email
// $subject = 'Example Email';

// // Message to be sent
// $message = 'This is a test email sent from PHP.';

// // Additional headers
// $headers = 'From: ' . $from . "\r\n" .
//            'Reply-To: ' . $from . "\r\n" .
//            'X-Mailer: PHP/' . phpversion();

// // Send the email
// if (mail($to, $subject, $message, $headers)) {
//     echo 'Email sent successfully!';
// } else {
//     echo 'Failed to send email.';
// }




// $sToken = "T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3";
// // T0lE5UddwpapG3HSgghgwchZWmo45nkRt6KkPMyF5o3

// $dateString = date('Y-m-d');
// $date = DateTime::createFromFormat('Y-m-d', $dateString);
// $formattedDate = $date->format('d F Y');

// $sMessage = "\nวันที่ : " . $formattedDate . "\n";
// $sMessage .= "\nมีการแจ้งซ่อมใหม่เข้ามา : " . "\n";
// $sMessage .= "เลขที่ใบส่งซ่อม : " . $id_r_g;
// $sMessage .= "\nชื่อ : " . $row_m['m_fname'] . " " . $row_m['m_lname'] . "\n";
// $sMessage .= "เบอร์โทรติดต่อ : " . $_SESSION["tel"] . "\n";

// $chOne = curl_init();
// curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
// curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
// curl_setopt($chOne, CURLOPT_POST, 1);
// curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
// $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
// curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
// $result = curl_exec($chOne);

// //Result error 
// if (curl_error($chOne)) {
//     echo 'error:' . curl_error($chOne);
// } else {
//     $result_ = json_decode($result, true);
//     echo "status : " . $result_['status'];
//     echo "message : " . $result_['message'];
// }
// curl_close($chOne);

// $sql1 = "UPDATE status_type SET status_name = 'รายละเอียด' WHERE status_id = 4;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ยืนยันการซ่อม' WHERE status_id = 5;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ดำเนินการซ่อม' WHERE status_id = 6;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ดำเนินการตรวจเช็ค' WHERE status_id = 7;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ซ่อมเสร็จสิ้น รอการชำระเงิน' WHERE status_id = 8;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ชำระเงินเรียบร้อย' WHERE status_id = 9;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ดำเนินกาส่งเครื่องเสียง' WHERE status_id = 10;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ปฏิเสธการซ่อม' WHERE status_id = 11;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'ยกเลิกการซ่อม' WHERE status_id = 12;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'เกิดปัญหาระหว่างซ่อม' WHERE status_id = 13;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $sql1 = "UPDATE status_type SET status_name = 'เกินเวลาชำระเงินตามที่กำหนด' WHERE status_id = 14;";
// $result1 = mysqli_query($conn, $sql1);
// $row1 = mysqli_fetch_array($result1);

// $folderName = "uploads/4"; // the name of the new folder
//         if (!file_exists($folderName)) { // check if the folder already exists
//             mkdir($folderName); // create the new folder
//             echo "Folder created successfully";
//         } else {
//             echo "Folder already exists";
//         }

?>
<!-- <!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
        }

        .gallery img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            cursor: pointer;
            margin: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.8);
            opacity: 0;
            transition: opacity 0.3s ease-in;
        }

        .modal.show {
            opacity: 1;
        }

        .modal-image {
            display: block;
            margin: 0 auto;
            max-width: 80%;
            max-height: 80%;
            text-align: center;
        }


        .close {
            color: #fff;
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #ccc;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="gallery">
        <img src="parts/1/K-1295.PNG" alt="Photo 1" onclick="openModal(this)">
        <img src="parts/1/K-1295.PNG" alt="Photo 2" onclick="openModal(this)">
    Add more photos as needed -->
<!-- </div>

    <div id="modal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modal-image" src="" alt="Modal Photo">
    </div>

    <script src="script.js"></script>
    <script>
        function openModal(img) {
            var modal = document.getElementById("modal");
            var modalImg = document.getElementById("modal-image");
            modal.style.display = "block";
            modalImg.src = img.src;
            modal.classList.add("show");
        }

        function closeModal() {
            var modal = document.getElementById("modal");
            modal.style.display = "none";
        }
    </script>
</body>

</html>  -->

<!-- 
<!DOCTYPE html>
<html>
<head>
  <title>Add Picture Input</title>
  <script>
    function showInput() {
      var input = document.createElement('input');
      input.type = 'file';
      input.accept = 'image/*';
      input.onchange = function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function() {
          var image = document.createElement('img');
          image.src = reader.result;
          document.body.appendChild(image);
        };
        reader.readAsDataURL(file);
      };
      document.body.appendChild(input);
    }
  </script>
</head>
<body>
  <button onclick="showInput()">Add Picture Input</button>
</body>
</html> -->
<!-- -->
<!-- <?php
        include('database/condb.php');
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>select by.devtai.com</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>


    <div class="container">
        <h2>Form control: select by.devtai.com</h2>
        <p>code เลือกจังหวัด อำเภอ ตำบล php + mysqli + ajax + jquery + bootstrap :</p>
        <form>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
            <?php
            mysqli_query($conn, "SET NAMES 'utf8' ");
            error_reporting(error_reporting() & ~E_NOTICE);
            date_default_timezone_set('Asia/Bangkok');

            $sql_provinces = "SELECT * FROM provinces";
            $query = mysqli_query($conn, $sql_provinces);

            ?>
            <div class="form-group">
                <label for="sel1">จังหวัด:</label>
                <select class="form-control" name="Ref_prov_id" id="provinces">
                    <option value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
                    <?php foreach ($query as $value) { ?>
                        <option value="<?= $value['id'] ?>"><?= $value['name_th'] ?></option>
                    <?php } ?>
                </select>
                <br>

                <label for="sel1">อำเภอ:</label>
                <select class="form-control" name="Ref_dist_id" id="amphures">
                </select>
                <br>

                <label for="sel1">ตำบล:</label>
                <select class="form-control" name="Ref_subdist_id" id="districts">
                </select>
                <br>

                <label for="sel1">รหัสไปรษณีย์:</label>
                <input type="text" name="zip_code" id="zip_code" class="form-control">
                <br>
                <a href="https://devtai.com/?cat=38"> <button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button></a>
            </div>
            <?php include('script.php'); ?>
        </form>

    </div>
</body>

</html> -->

<body>

    <select id="select-state" class="form-select" data-live-search="true">
        <option value="">Select a state...</option>
        <option value="AL">Alabama</option>
        <option value="AK">Alaska</option>
        <option value="AZ">Arizona</option>
        <option value="AR">Arkansas</option>
        <option value="CA">California</option>
        <option value="CO">Colorado</option>
        <option value="CT">Connecticut</option>
        <option value="DE">Delaware</option>
        <option value="DC">District of Columbia</option>
        <option value="FL">Florida</option>
        <option value="GA">Georgia</option>
        <option value="HI">Hawaii</option>
        <option value="ID">Idaho</option>
        <option value="IL">Illinois</option>
        <option value="IN">Indiana</option>
    </select>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#select-state').select2({
                placeholder: "Pick a state...",
                allowClear: true
            });
        });
    </script>
</body>
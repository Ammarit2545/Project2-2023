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
</html>

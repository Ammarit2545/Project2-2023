<?php
session_start();
include('database/condb.php');

if (!isset($_SESSION['id'])) {
    header('Location: home.php');
}

if (!isset($_GET['id'])) {
    header('Location: home.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission here (e.g., saving data to the database).
    // You can include your PHP code for form processing here.
    // Don't forget to handle file uploads and database interactions.
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
    <link rel="stylesheet" href="css/require_config.css">
    <link rel="stylesheet" href="css/all_page.css">
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Status - ANE</title>

    <!-- Example CDNs, use appropriate versions and sources -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Add spinner CSS styles */
        .spinner-border {
            display: none;
        }

        .submitting .spinner-border {
            display: inline-block;
        }
    </style>
</head>
<?php
$get_r_id = $_GET['id'];
$m_id = $_SESSION['id'];

$sql = "SELECT m_fname, m_lname, m_id FROM member WHERE m_id = '$m_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
?>

<body>
    <form method="POST" action="action/add_prob.php?id=<?= $get_r_id ?>" enctype="multipart/form-data">
        <div class="container shadow" style="border-radius: 20px;">
            <br>
            <div class="row" style="border-radius: 20px;background-image: linear-gradient(to right,#4D69FF, #4DD1FF);color:white;">
                <center>
                    <br>
                    <h1>ส่งคำร้องของคุณ</h1>
                    <br>
                </center>
            </div>
            <div class="row">
                <label for="formFile" class="form-label">หมายเลขใบแจ้งซ่อม</label>
                <input type="text" class="form-control" name="get_r_id"=placeholder="กรุณากรอกหมายเลขใบแจ้งซ่อม" value="<?= $get_r_id ?>" disabled>

            </div>
            <div class="row">
                <label for="formFile" class="form-label">ชื่อ</label>
                <input type="text" class="form-control" placeholder="กรุณากรอกชื่อของคุณ" value="<?= $row['m_fname'] . " " . $row['m_lname'] ?>" disabled>
                <input type="text" class="form-control" name="m_id" placeholder="กรุณากรอกชื่อของคุณ" value="<?= $m_id  ?>" disabled hidden>
            </div>
            <div class="row">
                <label for="myfile1">Select a file:</label>
                <input class="form-control mt-2" type="file" id="myfile1" name="image1">
                <input class="form-control mt-2" type="file" id="myfile2" name="image2">
                <input class="form-control mt-2" type="file" id="myfile3" name="image3">
                <input class="form-control mt-2" type="file" id="myfile4" name="image4">
            </div>
            <div class="row">
                <label for="comments">เหตุผล</label>
                <textarea class="auto-expand" name="comments" class="form-control" cols="46" rows="3" placeholder="กรุณาระบุเหตุผลของคุณ"></textarea>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function() {
                    // Bind an input event handler to the textarea
                    $('textarea[name="comments"]').on('input', function() {
                        // Get the current text in the textarea
                        var text = $(this).val();

                        // Check if the length exceeds 255 characters
                        if (text.length > 255) {
                            // If it does, truncate the text to 255 characters
                            $(this).val(text.substring(0, 255));
                            Swal.fire({
                                icon: 'error',
                                title: 'Maximum Character Limit Exceeded',
                                text: 'You have reached the maximum character limit (255).',
                            });
                        }
                    });
                });
            </script>


            <div class="row">
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <a href="javascript:void(0);" class="btn btn-danger" onclick="showCancellationPopup()">ยกเลิก</a>
                    <button type="button" class="btn btn-success" onclick="showConfirmationPopup()">ยืนยัน</button>

                </div>
                <br>
            </div>
        </div>
    </form>




    <script>
        // Function to show SweetAlert confirmation popup
        function showConfirmationPopup() {
            Swal.fire({
                title: 'ยืนยันการส่งคำร้อง?',
                text: 'คุณต้องการยืนยันการส่งคำร้องหรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'green',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, you can submit the form
                    document.querySelector('form').submit();
                }
            });
        }

        // Attach the showConfirmationPopup function to the Confirm button
        document.querySelector('.btn-success').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default form submission
            showConfirmationPopup(); // Show the confirmation popup
        });

        // Function to show SweetAlert cancellation popup
        function showCancellationPopup() {
            Swal.fire({
                title: 'ยกเลิกการส่งคำร้อง?',
                text: 'คุณต้องการยกเลิกการส่งคำร้องหรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยกเลิก',
                cancelButtonText: 'ไม่, ยังคงส่ง',
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, redirect to the cancellation URL
                    window.location.href = 'detail_status.php?id=<?= $get_r_id ?>';
                }
            });
        }

        // Attach the showCancellationPopup function to the Cancel button
        document.querySelector('.btn-danger').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default button behavior
            showCancellationPopup(); // Show the cancellation popup
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>
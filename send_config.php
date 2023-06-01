<?php
session_start();
include('database/condb.php');

if (!isset($_SESSION['id'])) {
    header('Location:home.php');
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Add event listener to the form submission
            document.getElementById("formSubmit").addEventListener("click", function(e) {
                e.preventDefault(); // Prevent the default form submission

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Display the spinner
                        document.getElementById("formSpinner").style.display = "inline-block";
                        document.getElementById("formSubmit").classList.add("submitting");

                        // Submit the form using AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "action/add_prob.php", true);
                        xhr.onload = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                // Hide the spinner
                                document.getElementById("formSpinner").style.display = "none";

                                // Reset the form
                                document.getElementById("formSubmit").classList.remove("submitting");
                                document.getElementById("form").reset();

                                // Show success message
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Data has been inserted successfully.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Redirect to status_detail.php
                                    var get_r_id = document.getElementById("basic-url").value;
                                    window.location.href = "status_detail.php?id=" + get_r_id;
                                });
                            } else {
                                // Handle errors, if any
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while inserting data.',
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            }
                        };
                        xhr.send(new FormData(document.getElementById("form")));
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <div class="row header">
            <h1>ติดต่อเรา &nbsp;</h1>
            <h3>แจ้งถึงปัญหาของคุณให้เราทราบ</h3>
        </div>
        <div class="row body">
            <form id="form" enctype="multipart/form-data">
                <ul>
                    <?php
                    $get_r_id = $_GET['id'];
                    $m_id = $_SESSION['id'];

                    $sql = "SELECT m_fname, m_lname, m_id FROM member WHERE m_id = 1";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);
                    ?>
                    <label for="basic-url" class="form-label">หมายเลขแจ้งซ่อมของคุณ</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="get_r_id" value="<?= $get_r_id ?>" placeholder="กรุณาใส่หมายเลขแจ้งซ่อมของท่าน">
                    </div>

                    <label for="basic-url" class="form-label">จาก</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" value="<?= $row['m_fname'] . " " . $row['m_lname'] ?>" placeholder="กรุณาใส่หมายเลขแจ้งซ่อมของท่าน" required readonly>
                    </div>

                    <label for="myfile">Select a file:</label>
                    <input type="file" id="myfile" name="image1">
                    <input type="file" id="myfile" name="image2">
                    <input type="file" id="myfile" name="image3">
                    <input type="file" id="myfile" name="image4">

                    <li>
                        <label for="comments">เหตุผล</label>
                        <textarea cols="46" rows="3" name="comments" placeholder="กรุณาระบุเหตุผลของคุณ"></textarea>
                    </li>

                    <li>
                        <button id="formSubmit" class="btn btn-success">ยืนยัน</button>
                        <span id="formSpinner" class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</body>

</html>

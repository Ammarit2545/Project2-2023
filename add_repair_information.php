<?php
session_start();
include('database/condb.php');

$id = $_SESSION["id"];

$sql = "SELECT * FROM member WHERE m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

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
    <link rel="stylesheet" href="css/all_page.css">
    <link rel="stylesheet" href="css/spinner.css">
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>ANE - Repair Request</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .grid {
            margin-bottom: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
            grid-gap: 3rem;
        }

        .grid-item {
            /* box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); */
            /* Add a gray shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Add transition for transform and box-shadow */
        }

        .grid-item:hover {
            transform: scale(1.1);
            /* Increase size on hover */
            /* box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); */
            /* Increase shadow size and intensity on hover */

        }

        #card-show {
            display: flex;
            justify-content: center;
            width: 100%;
            height: 100%;
            text-align: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            text-decoration: none;
            font-size: 28px;
            color: while;
            padding: 12%;
            box-shadow: 2px 2px 5px rgba(1, 0, 0, 0.5);
        }

        a {
            text-decoration: none;
            /* Remove underline */
        }

        a:hover {
            text-decoration: none;
            /* Remove underline on hover */
        }

        #card-show i {
            transition: transform 0.3s;
        }

        #card-show:hover i {
            transform: scale(1.2);
        }

        .grid-item .tooltip {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 8px;
            border-radius: 4px;
            font-size: 14px;
            white-space: nowrap;
            transition: opacity 0.3s, transform 0.3s;
        }

        .grid-item:hover .tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-10px);
            animation: tooltipFadeIn 0.3s, tooltipBounce 0.6s;
        }

        #card-detail {
            width: 100%;
            height: 100%
        }

        #rule-show {
            margin-top: 5%;
            justify-content: center;
            display: flex;
        }

        @keyframes tooltipFadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes tooltipBounce {

            0%,
            100% {
                transform: translateX(-50%) translateY(-10px);
            }

            50% {
                transform: translateX(-50%) translateY(0);
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

    <br><br><br>

    <h1 class="pt-5 text-center">การบริการส่งซ่อม ANE Electronic</h1>

    <center>
        <p>กรุณาเลือกประเภทรายการที่ต้องการซ่อม</p>
    </center>

    <br><br>

    <div class="container">
        <div class="grid">
            <div class="grid-item">
                <center>
                    <a href="add_repair_gua.php" type="button" style="font-size: 1.2rem;" class="button" id="button-action">มีประกันทางร้าน</a>
                    <span class="tooltip">ในกรณีที่มีประกันกับทางร้าน</span>
                </center>
                <!-- <a href="add_repair_information.php" class="card-show">
                    <div class="alert alert-primary" id="card-show">
                        มีประกันกับทางร้าน
                    </div>
                    <span class="tooltip">ในกรณีที่มีประกันกับทางร้าน</span>
                </a> -->
            </div>
            <div class="grid-item">
                <center>
                    <a href="add_repair_non_gua.php" type="button" class="button" style="font-size: 1.2rem;">ไม่มีประกันทางร้าน</a>
                    <span class="tooltip">กรณีที่ไม่มีประกันหรือซื้อจากทางร้าน</span>
                </center>
                <!-- <a href="add_repair_information.php" class="card-show">
                    <div class="alert alert-info" id="card-show">
                        ไม่มีประกันกับทางร้าน
                    </div>
                    <span class="tooltip">กรณีที่ไม่มีประกันหรือซื้อจากทางร้าน</span>
                </a> -->
            </div>
        </div>
    </div>

    <!-- Add the overlay element after the spinner -->
    <div id="loading-overlay"></div>

    <!-- Add the spinner element -->
    <!-- <div id="loading-spinner" class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div> -->

    <button id="loading-spinner" class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
    </button>

    <script>
        // Show the spinner
        document.getElementById("loading-spinner").style.display = "block";

        // Hide the spinner
        document.getElementById("loading-spinner").style.display = "none";
    </script>

    <script>
        // Assuming you have included Font Awesome library

        // If you are using Font Awesome 4
        var icon = document.querySelector('#card-show i');
        icon.classList.add('fa-plus');

        // If you are using Font Awesome 5
        var icon = document.querySelector('#card-show i');
        icon.classList.add('fas', 'fa-plus');
    </script>

    <!-- footer-->
    <?php
    include('footer/footer.php')
    ?>
    <!-- end footer-->

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
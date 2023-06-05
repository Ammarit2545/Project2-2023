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
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>ANE - Repair Request</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        .grid {
            margin-bottom: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            /* if 4 is 200px */
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
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
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
            font-size: 47px;
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
    <?php
    include('bar/topbar_user.php');

    $i = 1;

    while (isset($_SESSION['r_id_' . $i])) {
        $i += 1;
    }
    $i -= 1;
    // The value of $i will be the lastest session r_id_ + 1

    ?>
    <br><br><br>
    <h1 class="pt-5 text-center">การบริการส่งซ่อม <?= $i ?></h1>
    <center>
        <p>แบบไม่มีกับมีประกันทางร้าน</p>
    </center>
    <br><br>
    <div class="container">
        <div class="grid">
            <div class="grid-item">
                <a href="add_repair_information.php" class="card-show">
                    <div class="alert alert-secondary" id="card-show">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                    <span class="tooltip">เพิ่มการส่งซ่อมของคุณ</span>
                </a>
            </div>

            <?php

            $i = 0;

            if (!isset($_SESSION["r_id_1"])) {
            } else {
                for ($i = 1; $i < 1000; $i++) {
                    $r_id = 'r_id_' . $i;

                    if (isset($_SESSION[$r_id])) {
                        $r_id = 'r_id_' . $i;

                        $_SESSION[$r_id] = $i;

                        $name_brand = 'name_brand_' . $i;

                        $serial_number = 'serial_number_' . $i;

                        $name_model = 'name_model_' . $i;

                        $number_model = 'number_model_' . $i;

                        $tel = 'tel_' . $i;

                        $description = 'description_' . $i;

                        $company = 'company_' . $i;

                        $image1 = 'image1_' . $i;

                        $image2 = 'image2_' . $i;

                        $image3 = 'image3_' . $i;

                        $image4 = 'image4_' . $i;
            ?>
                        <div class="grid-item">
                            <div class="card" id="card-detail">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <h5 style="display:inline; margin-right:10px" class="btn btn-secondary"><?= $_SESSION[$r_id] ?></h5><?= $_SESSION[$name_brand] ?> <?= $_SESSION[$name_model] ?>
                                    </h5>
                                    <br><br>
                                    <h6 class="card-subtitle mb-2 text-muted">Serial Number : <?= $_SESSION[$serial_number] ?></h6>
                                    <hr>
                                    <p class="card-text"><?= $_SESSION[$description] ?></p>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="btn btn-outline-primary" style="margin-right: 10px;">แก้ไข</a>
                                        <a href="#" class="btn btn-outline-danger ml-2" onclick="confirmDelete('<?= $_SESSION[$r_id] ?>')">ลบ</a>

                                    </div>
                                </div>
                            </div>
                            <span class="tooltip">คำส่งซ่อมที่ #<?= $_SESSION[$r_id] ?></span>
                        </div>

            <?php
                    }
                }
            }
            ?>
            <!-- <div class="grid-item">
                <div class="card" id="card-detail">
                    <div class="card-body">
                        <h5 class="card-title">
                            <h5 style="display:inline; margin-right:10px" class="btn btn-secondary">1</h5>YAMAHA DSR118W
                        </h5>
                        <br><br>
                        <h6 class="card-subtitle mb-2 text-muted">Serial Number : YH025666372251</h6>
                        <hr>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->

            <!-- <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a> -->

            <!-- </div>
                </div>
                <span class="tooltip">เพิ่มการส่งซ่อมของคุณ</span>
            </div> -->
        </div>
    </div>
    <center>
        <button class="btn btn-success">ยืนยัน</button>
    </center>

    <script>
        function confirmDelete(cardId) {
            swal.fire({
                title: 'คุณต้องการลบรายการนี้หรือไม่?',
                text: 'การกระทำนี้ไม่สามารถย้อนกลับได้',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, perform the delete action
                    deleteCard(cardId);
                }
            });
        }

        function deleteCard(cardId) {
            // Perform the delete action
            window.location.href = 'action/delete_card.php?id=' + cardId;
        }
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

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
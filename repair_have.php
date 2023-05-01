<?php
session_start();
include('database/condb.php');

if(!isset($_SESSION["id"])){
    header('Location:home.php');
}

$id = $_SESSION["id"];

$sql = "SELECT * FROM member WHERE m_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$search = $_GET["search"];

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
            #date_time,#body_text{
                font-size: 14px;
            }
            #title_main{
                font-size: 24px;
            }
            #head_text{
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <!-- navbar-->
    <?php
    include('bar/topbar_user.php');

    $id = $_SESSION["id"];

    $sql = "SELECT * FROM member WHERE m_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    ?>
    <!-- end navbar-->

    <div class="background"></div>

    <div class="px-5 pt-5 edit">

        <?php if (!isset($search)) { ?>
            <h1 class="pt-5 text-center" id="title_main">ข้อมูลการซ่อมทั้งหมดของคุณ <?= $row['m_fname'] . " " . $row['m_lname'] ?></h1>
        <?php } else { ?>
            <h1 class="pt-5 text-center">ผลการหาข้อมูล "<?= $search ?>" </h1>
        <?php } ?>
        <br>

        <center>
            <p>เลือกข้อมูลที่ท่านต้องการ
                <!-- <a href="#" style="text-decoration: none; color : green">(หาด้วยเลข Serial Number ,ชื่อแบรนด์ ,ชื่อรุ่น)</a>  -->
            </p>
        </center>
        <form class="search-form" action="repair_have.php" method="GET">
            <input type="text" name="search" placeholder="หาด้วยเลข Serial Number ,ชื่อแบรนด์ ,ชื่อรุ่น" value="<?= $search ?>">
            <button type="submit">Search</button>
        </form>
        <br>
        <form action="action/add_repair_non_gua.php" method="POST">
            <div class="container">
                <div class="row">
                    <?php
                    if (!isset($search) and !isset($type)) {
                        $sql = "SELECT * FROM repair WHERE m_id = '$id'";
                        $result = mysqli_query($conn, $sql);
                    } else {
                        $sql = "SELECT * FROM repair WHERE m_id = '$id' 
                                AND r_brand LIKE '%$search%' 
                                OR r_model LIKE '%$search%' 
                                OR r_serial_number LIKE '%$search%'
                                OR CONCAT(r_brand,' ',r_model) LIKE '%$search%' 
                                OR CONCAT(r_brand,'',r_model) LIKE '%$search%'";
                        $result = mysqli_query($conn, $sql);
                    }

                    $i = 0;
                    $found_data = false;

                    while ($row1 = mysqli_fetch_array($result)) {
                        $i = $i + 1;
                        $id_r = $row1[0];
                        $sql_c = "SELECT * FROM get_repair WHERE r_id = '$id_r' ORDER BY get_r_id DESC LIMIT 1";
                        $result_c = mysqli_query($conn, $sql_c);
                        $row_c = mysqli_fetch_array($result_c);

                        // Check if data is found
                        if ($row_c) {
                            $found_data = true;
                            // Display data
                        }
                    ?>
                        <div class="col-md-6 mt-5">
                            <a href="repair_ever.php?id=<?= $row1['r_id'] ?>" id="card_sent">
                                <div class="card" style="box-shadow: 0px 10px 50px rgba(0, 1, 65, 0.18);">
                                    <div class="card-header">
                                        <h2> <button type="button" class="btn btn-primary" style="font-size:16px"><?= $i ?></button> : <?= $row1['r_brand'] ?> <?= $row1['r_model'] ?> </h2>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <h5 style="color:blue" id="head_text">หมายเลขประจำเครื่อง : </h5>
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
                                        <?php } ?>
                                        <li class="list-group-item">
                                            <br>
                                            <h5 style="color : gray" id="date_time">ส่งเรื่องล่าสุดวันที่ : <?= date('Y-m-d H:i:s', strtotime($row_c['get_r_date_in'])); ?></h5>
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
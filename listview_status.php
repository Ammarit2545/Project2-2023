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
    <link rel="stylesheet" href="css/all_page.css">
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

        .grid {
            margin-bottom: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(600px, 1fr));
            /* if 4 is 200px */
            grid-gap: 3rem;
        }

        .grid-item .card {
            /* box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); */
            /* Add a gray shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Add transition for transform and box-shadow */
        }

        .grid-item:hover .card {
            transform: scale(1.1);
            /* Increase size on hover */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            /* Increase shadow size and intensity on hover */

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
        <br>
        <?php if (!isset($_GET["search"])) { ?>
            <h1 class="pt-5 text-center" id="title_main">ข้อมูลการซ่อมทั้งหมดของคุณ <?= $row['m_fname'] . " " . $row['m_lname']  ?></h1>
        <?php } elseif ($status_id == "") {
        ?><h1 class="pt-5 text-center" id="title_main">ข้อมูลการซ่อมทั้งหมดของคุณ <?= $row['m_fname'] . " " . $row['m_lname']  ?></h1>
        <?php
        } else {
            $sql_s = "SELECT * FROM `status_type` WHERE status_id = $status_id";
            $result_s = mysqli_query($conn, $sql_s);
            $row_sk = mysqli_fetch_array($result_s);
        ?>
            <h1 class="pt-5 text-center">ผลการหาข้อมูล "<?= $search . " " . "ประเภท - " . $row_sk['status_name'] ?>" </h1>
        <?php } ?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-2"></div>
                <div class="col">
                    <center>
                        <ul class="nav nav-tabs" id="select_under">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="box-shadow: 0 1px 6px rgba(32, 33, 36, 0.28);">ทั้งหมด</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="listview_status.php">ทั้งหมด</a></li>
                                    <?php
                                    $sql_s = "SELECT status_type.status_id, status_type.status_name, COUNT(*) ,status_type.status_color  as count
                                            FROM get_repair 
                                            LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id
                                            LEFT JOIN repair ON repair.r_id = get_repair.r_id
                                            LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
                                            WHERE repair.m_id = '$id' AND repair_status.del_flg = '0'
                                            GROUP BY status_type.status_id 
                                            ORDER BY status_type.status_id ASC;";
                                    $result_s = mysqli_query($conn, $sql_s);
                                    while ($row_s = mysqli_fetch_array($result_s)) { ?>
                                        <li class="nav-item">
                                        <li> <a class="dropdown-item" href="listview_status.php?status_id=<?= $row_s['status_id'] ?>&search=<?= $search ?>"><?= $row_s['status_name'] ?>
                                                <p style="display: inline-block; color:<?= $row_s[3] ?>; ">(<?= $row_s[2] ?>)</p>
                                            </a>
                                        </li>
                            </li>
                        <?php } ?>
                        </ul>
                        </li>
                        </ul>
                    </center>
                    <center>
                        <ul class="nav nav-tabs" id="bar_under">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="listview_status.php">ทั้งหมด</a>
                            </li>
                            <?php
                            $sql_s = "SELECT status_type.status_id, status_type.status_name, COUNT(*) ,status_type.status_color  as count
                        FROM repair_status 
                        LEFT JOIN get_repair ON get_repair.get_r_id = repair_status.get_r_id
                        LEFT JOIN repair ON repair.r_id = get_repair.r_id
                        LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
                        WHERE repair.m_id = '$id'
                        GROUP BY status_type.status_id 
                        ORDER BY status_type.status_id ASC;";
                            $result_s = mysqli_query($conn, $sql_s);
                            $numItems = mysqli_num_rows($result_s);
                            $counter = 0;
                            while ($row_s = mysqli_fetch_array($result_s)) {
                                $counter++;
                                if ($counter <= 5) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="listview_status.php?status_id=<?= $row_s['status_id'] ?>&search=<?= $search ?>"><?= $row_s['status_name'] ?>
                                            <p style="display: inline-block; color:<?= $row_s[3] ?>; ">(<?= $row_s[2] ?>)</p>
                                        </a>
                                    </li>
                                    <?php
                                } else {
                                    if ($counter === 6) {
                                    ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">อื่นๆ</a>
                                            <ul class="dropdown-menu">
                                            <?php
                                        }
                                            ?>
                                            <li>
                                                <a class="dropdown-item" href="listview_status.php?status_id=<?= $row_s['status_id'] ?>&search=<?= $search ?>">
                                                    <?= $row_s['status_name'] ?>
                                                    <p style="display: inline-block; color:<?= $row_s[3] ?>; ">(<?= $row_s[2] ?>)</p>
                                                </a>
                                            </li>
                                            <?php
                                            if ($counter === $numItems) {
                                            ?>
                                            </ul>
                                        </li>
                            <?php
                                            }
                                        }
                                    }
                            ?>
                        </ul>
                    </center>

                </div>
                <div class="col-2"></div>
            </div>
        </div>
        <br>
        <?php if ($status_id < 0 || !isset($status_id)) { ?>
            <form class="search-form" action="listview_status.php" method="GET">
                <input type="text" name="search" placeholder="หาด้วยเลข Serial Number ,ชื่อแบรนด์ ,ชื่อรุ่น ,หมายเลขแจ้งซ่อม . . ." value="<?= $search ?>">
                <input type="text" name="status_id" placeholder="หาด้วยเลข Serial Number ,ชื่อแบรนด์ ,ชื่อรุ่น ,หมายเลขแจ้งซ่อม . . ." value="<?= $status_id ?>" style="display : none ">
                <button type="submit">Search</button>
            </form>
        <?php } else {
        ?>
            <form class="search-form" action="listview_status.php" method="GET">
                <input type="text" name="search" placeholder="หาด้วยเลข Serial Number ,ชื่อแบรนด์ ,ชื่อรุ่น ,หมายเลขแจ้งซ่อม . . ." value="<?= $search ?>">
                <input type="text" name="status_id" placeholder="หาด้วยเลข Serial Number ,ชื่อแบรนด์ ,ชื่อรุ่น ,หมายเลขแจ้งซ่อม . . ." value="<?= $status_id ?>" style="display : none ">
                <button type="submit">Search</button>
            </form>
        <?php
        } ?>
        <br>
        ิ<br>
        <form action="action/add_repair_non_gua.php" method="POST">
            <div class="container">
                <div class="grid">
                    <?php
                    if (!isset($search) && !isset($status_id)) {
                        $sql = "SELECT * FROM get_repair 
                                LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id 
                                LEFT JOIN repair ON get_detail.r_id = repair.r_id 
                                WHERE m_id = '$id' AND get_repair.del_flg='0'
                                GROUP BY get_repair.get_r_id ORDER BY get_repair.get_r_date_in DESC;";
                    } elseif ($status_id > 0) {
                        $sql = "SELECT get_repair.*, repair.*, rs.status_id
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
                        LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id 
                        LEFT JOIN repair ON get_detail.r_id = repair.r_id 
                        WHERE m_id = '$id' AND (repair.r_brand LIKE '%$search%' 
                        OR repair.r_model LIKE '%$search%' 
                        OR repair.r_serial_number LIKE '%$search%' 
                        OR repair.r_number_model LIKE '%$search%' 
                        OR get_repair.get_r_id LIKE '%$search%' 
                        OR CONCAT(repair.r_brand, ' ', repair.r_model) LIKE '%$search%' 
                        OR CONCAT(repair.r_brand, '', repair.r_model) LIKE '%$search%') 
                        GROUP BY get_repair.get_r_id
                        ORDER BY get_repair.get_r_date_in DESC;
                        ";
                    }
                    $result = mysqli_query($conn, $sql);
                    $i = 0;
                    $found_data = false;

                    while ($row1 = mysqli_fetch_array($result)) {
                        $i = $i + 1;
                        $id_r = $row1[0];
                        $id_r_get = $row1['r_id'];
                        $sql_c = "SELECT COUNT(get_r_id) FROM get_detail WHERE get_r_id = '$id_r'";
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
                        <div class="grid-item">
                            <a href="detail_status.php?id=<?= $id_r ?>" id="card_sent">
                                <div class="card" style="box-shadow: 0px 10px 50px rgba(0, 1, 65, 0.18);">
                                    <div class="card-header">
                                        <h3>
                                            <button type="button" class="btn btn-primary" style="font-size:16px; display:inline-block;">
                                                <?= $i ?>
                                            </button>
                                            หมายเลขส่งซ่อม : <?= $id_r ?>
                                            <a class="btn" style="background-color: <?= $row_status['status_color'] ?>; color:white;">
                                                <?= $row_status['status_name'] ?>
                                            </a>
                                            <?php if ($row_c[0] == 1) { ?>
                                                <a class="btn btn-outline-secondary">#ครั้งที่ <?= $row1['get_d_record'] ?> </a>
                                            <?php } ?>
                                        </h3>
                                    </div>
                                    <?php if ($row_c[0] == 1) { ?>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <h5 style="color: blue" id="head_text"><?= $row1['r_brand'] ?> <?= $row1['r_model'] ?></h5>
                                                <br>
                                                <p style="text-align: start" id="body_text">Serial Number: <?= $row1['r_serial_number'] ?></p>
                                                <p style="text-align: start" id="body_text">Model: <?= $row1['r_number_model'] ?></p>
                                            </li>
                                            <?php if ($row_c['get_r_detail'] != NULL) {
                                                $text = $row_c['get_r_detail'];
                                                $summary = strlen($text) > 100 ? substr($text, 0, 200) . "..." : $text;
                                            ?>
                                                <li class="list-group-item">
                                                    <h5 style="color: blue" id="head_text">รายละเอียดการส่งซ่อม :</h5>
                                                    <br>
                                                    <p><?= $summary ?></p>
                                                </li>
                                            <?php } ?>
                                            <li class="list-group-item">
                                                <br>
                                                <h5 style="color: gray" id="date_time">
                                                    ส่งเรื่องล่าสุดวันที่: <?= $formattedDate ?>, เวลา: <?= date('H:i:s', strtotime($row1['get_r_date_in'])); ?>
                                                </h5>
                                            </li>
                                        </ul>
                                        <span class="tooltip">#หมายเลขส่งซ่อมที่ <?= $id_r ?></span>
                                    <?php } else {
                                        $sql_get_count = "SELECT COUNT(get_r_id) FROM get_detail 
                                         WHERE get_r_id = '$id_r'";
                                        $result_get_count = mysqli_query($conn, $sql_get_count);
                                        $row_get_count = mysqli_fetch_array($result_get_count);
                                    ?>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <br>
                                                <h5 style="color:blue" id="head_text"> คำส่งซ่อมนี้มี <?= $row_get_count[0] ?> รายการ </h5>
                                                <br>
                                                <!-- <p style="text-align:start" id="body_text"> Serial Number : <?= $row1['r_serial_number'] ?></p>
                                                <p style="text-align:start" id="body_text">Model : <?= $row1['r_number_model'] ?></p> -->
                                                <div class="accordion-item" style="border: 1px solid black; padding:15px;   ">
                                                    <h2 class="accordion-header" id="flush-headingThree">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                            <h5> ดูรายการส่งซ่อมทั้งหมด </h5>
                                                        </button>
                                                    </h2>
                                                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">

                                                        <hr>
                                                        <?php
                                                        $count_get_no = 0;
                                                        $sql_get = "SELECT * FROM get_detail 
                                               LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                               WHERE get_detail.get_r_id = '$id_r'";
                                                        $result_count = mysqli_query($conn, $sql_get);
                                                        $result_get = mysqli_query($conn, $sql_get);
                                                        while ($row_get = mysqli_fetch_array($result_get)) {
                                                            $count_get_no++;
                                                        ?>

                                                            <p style="text-align:start" id="body_text"> <span class="btn btn-secondary"><?= $count_get_no ?></span> : <?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?> | Serial Number : <?= $row_get['r_serial_number'] ?> </p>

                                                        <?php
                                                        }


                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <br>
                                                <h5 style="color : gray" id="date_time">
                                                    ส่งเรื่องล่าสุดวันที่ : <?= $formattedDate ?>, เวลา : <?= date('H:i:s', strtotime($row1['get_r_date_in'])); ?>
                                                </h5>
                                            </li>
                                        </ul>
                                        <span class="tooltip">#หมายเลขส่งซ่อมที่ <?= $id_r ?></span>
                                    <?php } ?>
                                </div>
                            </a>
                            <br> <br>
                        </div>


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
    include('footer/footer.php')
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
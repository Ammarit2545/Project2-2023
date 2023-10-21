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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        <?php include('css/all_page.css'); ?>#card_sent {
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
            grid-template-columns: repeat(auto-fit, minmax(1000px, 1fr));
            /* if 4 is 200px */
            /* grid-gap: 3rem; */
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

        .search-form {
            position: relative;
        }

        .search-form {
            position: relative;
        }

        #search-results {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40%;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-top: none;
            display: none;
        }

        .search-result {
            padding: 8px;
            cursor: pointer;
        }

        .search-result:hover {
            background-color: #f1f1f1;
        }

        /* Reset default margin and padding */
        body,
        html {
            margin: 0;
            padding: 0;
        }

        /* Style for the sidebar */
        .sidebar {

            position: fixed;
            /* Fixed position */
            top: 10;
            left: 0;
            height: 100%;
            /* Full height */
            width: 60px;
            /* Set your desired width */
            background-color: #f1f1f1;
            /* Background color */
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 50%;
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
            <h1 class="pt-5 text-center" id="title_main">ข้อมูลอุปกรณ์ทั้งหมดของคุณ <?= $row['m_fname'] . " " . $row['m_lname']  ?></h1>
        <?php } elseif ($status_id == "") {
        ?><h1 class="pt-5 text-center" id="title_main">ข้อมูลอุปกรณ์ทั้งหมดของคุณ <?= $row['m_fname'] . " " . $row['m_lname']  ?></h1>
        <?php
        } else {
            $sql_s = "SELECT * FROM `status_type` WHERE status_id = $status_id";
            $result_s = mysqli_query($conn, $sql_s);
            $row_sk = mysqli_fetch_array($result_s);
        ?>
            <h1 class="pt-5 text-center">ผลการหาข้อมูล "<?= $search . " " . "ประเภท - " . $row_sk['status_name'] ?>" </h1>
        <?php } ?>
        <br>
        <br>
        <form class="search-form" action="repair_have.php" method="GET">
            <input type="text" name="search" id="search" placeholder="หาด้วยเลข Serial Number, ชื่อแบรนด์, ชื่อรุ่น, หมายเลขแจ้งซ่อม..." onkeyup="showResults(this.value)">
            <input type="text" name="status_id" placeholder="หาด้วยเลข Serial Number, ชื่อแบรนด์, ชื่อรุ่น, หมายเลขแจ้งซ่อม. . ." value="<?= isset($status_id) ? $status_id : '' ?>" style="display: none">
            <button type="submit">Search</button>
            <div id="search-results"></div> <!-- Add the id attribute here -->
        </form>

        <!-- Add jQuery library (you can get it from a CDN) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <br>
        <br>

        <!-- <nav aria-label="Page navigation example">

            <ul class="pagination justify-content-center ">
                <li class="page-item">
                    <a class="page-link" href="repair_have.php" tabindex="-1" aria-disabled="true">ทั้งหมด</a>
                </li>
                <?php
                $sql_f = "SELECT repair.r_brand
                        FROM get_detail
                        LEFT JOIN get_repair ON get_repair.get_r_id = get_detail.get_r_id
                        LEFT JOIN repair ON get_detail.r_id = repair.r_id
                        LEFT JOIN (
                            SELECT get_r_id, MAX(rs_date_time) AS max_date
                            FROM repair_status
                            GROUP BY get_r_id
                        ) AS subquery ON get_repair.get_r_id = subquery.get_r_id
                        LEFT JOIN repair_status AS rs ON subquery.get_r_id = rs.get_r_id AND subquery.max_date = rs.rs_date_time
                        WHERE repair.m_id = '$id' AND rs.status_id = '3' AND rs.rs_date_time = subquery.max_date AND get_repair.del_flg = 0 
                        
                        ORDER BY repair.r_brand ASC;  ";
                $result_f = mysqli_query($conn, $sql_f);

                $original = ''; // Initialize $original to an empty string
                $first_char = ''; // Initialize $first_char to an empty string

                while ($row_f = mysqli_fetch_array($result_f)) {
                    $first_char = $row_f['r_brand']; // Get the first character from the database result
                    $first_char = strtoupper($first_char[0]);

                    // Check if $first_char is not equal to $original
                    if ($first_char != $original) {
                        $original = $first_char; // Update $original with the current $first_char
                ?>
                        <li class="page-item">
                            <a class="page-link" href="repair_have.php?word=<?= $first_char ?>" tabindex="-1" aria-disabled="true"><?= $first_char ?></a>
                        </li>
                <?php
                    }
                }
                ?>
            </ul>
        </nav> -->

        <form action="action/add_repair_non_gua.php" method="POST">
            <div class="container">
                <div class="row">
                    <?php
                    if (!isset($_GET["search"])) {
                        $sql = "SELECT get_repair.get_r_id,repair.*
                        FROM get_detail
                        LEFT JOIN get_repair ON get_repair.get_r_id = get_detail.get_r_id
                        LEFT JOIN repair ON get_detail.r_id = repair.r_id
                        LEFT JOIN (
                            SELECT get_r_id, MAX(rs_date_time) AS max_date
                            FROM repair_status
                            GROUP BY get_r_id
                        ) AS subquery ON get_repair.get_r_id = subquery.get_r_id
                        LEFT JOIN repair_status AS rs ON subquery.get_r_id = rs.get_r_id AND subquery.max_date = rs.rs_date_time
                        WHERE repair.m_id = '$id' AND rs.status_id = '3' AND rs.rs_date_time = subquery.max_date AND get_repair.del_flg = 0 
                        
                        ORDER BY repair.r_brand ASC;  ";
                    } else {
                        $sql = "SELECT get_repair.get_r_id,repair.*
                        FROM get_detail
                        LEFT JOIN get_repair ON get_repair.get_r_id = get_detail.get_r_id
                        LEFT JOIN repair ON get_detail.r_id = repair.r_id
                        LEFT JOIN (
                            SELECT get_r_id, MAX(rs_date_time) AS max_date
                            FROM repair_status
                            GROUP BY get_r_id
                        ) AS subquery ON get_repair.get_r_id = subquery.get_r_id
                        LEFT JOIN repair_status AS rs ON subquery.get_r_id = rs.get_r_id AND subquery.max_date = rs.rs_date_time
                        WHERE repair.m_id = '$id' AND rs.status_id = '3' AND rs.rs_date_time = subquery.max_date AND get_repair.del_flg = 0 AND (
                                repair.r_brand LIKE '%$search%'
                                OR repair.r_model LIKE '%$search%'
                                OR repair.r_serial_number LIKE '%$search%'
                                OR repair.r_number_model LIKE '%$search%'
                                OR get_repair.get_r_id LIKE '%$search%'
                                OR CONCAT(repair.r_brand, ' ', repair.r_model) LIKE '%$search%'
                                OR CONCAT(repair.r_brand, '', repair.r_model) LIKE '%$search%'
                            )
                        
                        ORDER BY repair.r_brand ASC;
                                ";
                    }

                    $result = mysqli_query($conn, $sql);
                    $i = 0;
                    $found_data = false;
                    $id_r;
                    $remember_first = '';

                    // while card get_repair id
                    while ($row1 = mysqli_fetch_array($result)) {
                        if (isset($_GET['word'])) {
                            $word = $_GET['word'];
                            $string = $row1['r_brand'];
                            $firstChar = strtoupper($string[0]);

                            if ($word == $firstChar) {
                                // Check get_r_id is not as it was 
                                if ($id_r != $row1['get_r_id']) {
                                    $i = $i + 1;
                                    $id_r = $row1['get_r_id'];
                                    $id_r_get = $row1['r_id'];


                                    $sql_c = "SELECT COUNT(get_r_id) FROM get_detail WHERE get_r_id = '$id_r' AND del_flg = '0'";
                                    $result_c = mysqli_query($conn, $sql_c);
                                    $row_c = mysqli_fetch_array($result_c);

                                    $id_g = $row_c[0];

                                    $sql_s = "SELECT status_type.status_name,status_type.status_color,repair_status.status_id FROM repair_status 
                                    LEFT JOIN status_type ON status_type.status_id = repair_status.status_id 
                                    WHERE get_r_id = '$id_r' AND repair_status.del_flg = '0' ORDER BY rs_date_time DESC LIMIT 1;";
                                    $result_s = mysqli_query($conn, $sql_s);
                                    $row_status = mysqli_fetch_array($result_s);

                                    // Check if data is found
                                    if ($row_c) {
                                        $found_data = true;
                                        // Display data
                                    }
                                    if ($remember_first !== $firstChar) {
                                        $remember_first = $firstChar;?>
                    <h2><span class="badge bg-secondary mt-4"><?= $remember_first; ?></span></h2>
                                        <hr>
                                    <?php
                                    }
                                    ?>
                                    <style>
                                        .dsad {
                                            font-size: 100;
                                        }
                                    </style>
                                    <div id="bounce-item">
                                        <a href="repair_ever.php?id=<?= $row1['r_id'] ?>" id="card_sent" data-bs-toggle="tooltip" data-bs-placement="top" title="Model: <?= $row1['r_number_model'] ?>">
                                            <div class="alert alert-light shadow" role="alert" style="color: black; background-color: #F5F5F5; border: 1px solid #F5F5F5;">
                                                <style>

                                                </style>
                                                <b class="ln auto-font"><?= $row1['r_brand'] ?></b><span class="ln auto-font"><?= ' - ' . $row1['r_model'] . '   '  ?></span>
                                                <h5 class="ln auto-font"><span class="badge bg-primary ln auto-font"><?= 'SH : ' . $row1['r_number_model'] ?></span></h5>
                                            </div>
                                        </a>
                                    </div>


                                    <?php }
                            }
                        } else { {

                                $string = $row1['r_brand'];
                                $firstChar = $string[0];
                                // Check get_r_id is not as it was 
                                if ($id_r != $row1['get_r_id']) {
                                    $i = $i + 1;
                                    $id_r = $row1['get_r_id'];
                                    $id_r_get = $row1['r_id'];


                                    $sql_c = "SELECT COUNT(get_r_id) FROM get_detail WHERE get_r_id = '$id_r' AND del_flg = '0'";
                                    $result_c = mysqli_query($conn, $sql_c);
                                    $row_c = mysqli_fetch_array($result_c);

                                    $id_g = $row_c[0];

                                    $sql_s = "SELECT status_type.status_name,status_type.status_color,repair_status.status_id FROM repair_status 
                                        LEFT JOIN status_type ON status_type.status_id = repair_status.status_id 
                                        WHERE get_r_id = '$id_r' AND repair_status.del_flg = '0' ORDER BY rs_date_time DESC LIMIT 1;";
                                    $result_s = mysqli_query($conn, $sql_s);
                                    $row_status = mysqli_fetch_array($result_s);

                                    // Check if data is found
                                    if ($row_c) {
                                        $found_data = true;
                                        // Display data
                                    }
                                    if ($remember_first !== $firstChar) {
                                        $remember_first = $firstChar;

                                    ?><h2><span class="badge bg-secondary mt-4"><?= strtoupper($remember_first) ?></span></h2>
                                        <hr>
                                    <?php
                                    }
                                    ?>
                                    <style>
                                        .dsad {
                                            font-size: 100;
                                        }
                                    </style>
                                    <div id="bounce-item">
                                        <a href="repair_ever.php?id=<?= $row1['r_id'] ?>" id="card_sent" data-bs-toggle="tooltip" data-bs-placement="top" title="Model: <?= $row1['r_number_model'] ?>">
                                            <div class="alert alert-light shadow" role="alert" style="color: black; background-color: #F5F5F5; border: 1px solid #F5F5F5;">
                                                <style>

                                                </style>
                                                <b class="ln auto-font"><?= $row1['r_brand'] ?></b><span class="ln auto-font"><?= ' - ' . $row1['r_model'] . '   '  ?></span>
                                                <h5 class="ln auto-font"><span class="badge bg-primary ln auto-font"><?= 'SH : ' . $row1['r_number_model'] ?></span></h5>
                                            </div>
                                        </a>
                                    </div>


                        <?php }
                            }
                        }
                    }
                    // Display message if no data found
                    if (!$found_data) { ?>
                        <center>
                            <br><br><br>
                            <h1>"ไม่พบข้อมูลในระบบ"</h1>
                        </center><?php } ?>
                </div>
                <?php if (isset($_GET["search"]) && $_GET["search"] != NULL) { ?>
                    <center>
                        <br>
                        <p>*** หากคุณต้องการดูข้อมูล "การซ่อมทั้งหมด" *** </p>
                        <a href="repair_have.php" class="btn btn-primary">ข้อมูลทั้งหมด</a>
                    </center>
                <?php  } ?>
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
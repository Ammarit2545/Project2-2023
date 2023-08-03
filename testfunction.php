<!-- <?php
        session_start();
        $_SESSION['add_data_detail'] = 3;
        // Replace 'Project2-2023' with the folder name you want to select
        $selectedFolder = '../';

        // Get the path of the selected folder
        $selectedFolderPath = __DIR__ . '/' . $selectedFolder;

        // Use dirname twice to get the mother folder path
        $motherFolderPath = dirname(dirname($selectedFolderPath));

        // Use basename to get the name of the mother folder
        $motherFolderName = basename($motherFolderPath);

        // Display the name of the mother folder
        echo "The mother folder is: " . $motherFolderName . "<br>";
        echo $_SESSION['id_repair_ever_1'];
        ?>

<?php echo 'SESSION =' . $_SESSION['add_data_detail']; ?> -->

<?php
include('database/condb.php');

$id = $_SESSION["id"];
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
    </style>
</head>

<body>
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col">
                <center>
                    <ul class="nav nav-tabs" id="bar_under">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="listview_status.php">ทั้งหมด</a>
                        </li>
                        <?php
                        $sql_st = "SELECT status_type.status_id FROM status_type WHERE status_type.del_flg = 0";
                        $result_st = mysqli_query($conn, $sql_st);
                        $status_data = array(); // Array to store status data
                        while ($row_st_id = mysqli_fetch_array($result_st)) {
                            $status_id = $row_st_id['status_id'];
                            $sql_status_get = "SELECT repair_status.get_r_id, (
                                            SELECT COUNT(*)
                                            FROM repair_status AS rs
                                            LEFT JOIN (
                                                SELECT get_r_id, MAX(r_id) AS r_id
                                                FROM get_detail
                                                GROUP BY get_r_id
                                            ) AS latest_get_detail ON latest_get_detail.get_r_id = rs.get_r_id
                                            LEFT JOIN repair ON repair.r_id = latest_get_detail.r_id
                                            WHERE rs.status_id = '$status_id'
                                            AND repair.m_id = '$id'
                                            AND rs.del_flg = '0'
                                        ) AS row_count
                                        FROM repair_status
                                        LEFT JOIN (
                                            SELECT get_r_id, MAX(r_id) AS r_id
                                            FROM get_detail
                                            GROUP BY get_r_id
                                        ) AS latest_get_detail ON latest_get_detail.get_r_id = repair_status.get_r_id
                                        LEFT JOIN repair ON repair.r_id = latest_get_detail.r_id
                                        LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
                                        WHERE repair_status.status_id = '$status_id'
                                        AND repair.m_id = '$id'
                                        AND repair_status.del_flg = '0';
                                        ";
                            $result_status_get = mysqli_query($conn, $sql_status_get);
                            $sql_count = 0; // Unique count for each status type
                            while ($row_status_get = mysqli_fetch_array($result_status_get)) {
                                $get_r_id = $row_status_get['get_r_id'];
                                $sql_count_status = "SELECT repair_status.status_id FROM get_repair 
                                    LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
                                    WHERE get_repair.get_r_id = '$get_r_id' AND repair_status.del_flg = '0' ORDER BY repair_status.rs_id DESC LIMIT 1";
                                $result_count_status = mysqli_query($conn, $sql_count_status);
                                $row_count_status = mysqli_fetch_array($result_count_status);
                                if ($row_count_status['status_id'] == $status_id) {
                                    $sql_count++;
                                }
                            }
                            if ($sql_count > 0) {
                                $sql_status = "SELECT status_name ,status_id,status_color FROM status_type WHERE status_id = '$status_id' AND del_flg = '0'";
                                $result_status = mysqli_query($conn, $sql_status);
                                $row_status_1 = mysqli_fetch_array($result_status);
                                $status_data[] = array(
                                    'status_name' => $row_status_1['status_name'],
                                    'status_id' => $row_status_1['status_id'],
                                    'status_color' => $row_status_1['status_color'],
                                    'count' => $sql_count,
                                );
                            }
                        }
                        $counter = 0;
                        $numItems = count($status_data);
                        foreach ($status_data as $data) {
                            $counter++;
                            if ($counter <= 4) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="listview_status.php?status_id=<?= $data['status_id'] ?>&search=<?= $search ?>"><?= $data['status_name'] ?>
                                        <p style="display: inline-block; color:<?= $data['status_color'] ?>; ">(<?= $data['count'] ?>)</p>
                                    </a>
                                </li>
                                <?php } else {
                                if ($counter === 5) {
                                ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">อื่นๆ</a>
                                        <ul class="dropdown-menu">
                                        <?php
                                    }
                                        ?>
                                        <li>
                                            <a class="dropdown-item" href="listview_status.php?status_id=<?= $data['status_id'] ?>&search=<?= $search ?>">
                                                <?= $data['status_name'] ?>
                                                <p style="display: inline-block; color:<?= $data['status_color'] ?>; ">(<?= $data['count'] ?>)</p>
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
</body>
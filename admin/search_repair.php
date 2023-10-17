<?php
session_start();
include('../database/condb.php');

if (!isset($_SESSION['role_id'])) {
    header('Location:../home.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- All Page Css-->
    <link href="../css/all_page.css" rel="stylesheet">


    <title>Admin Page - Create Auto Create Serial Number</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .modal_ed {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content-ed {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        #myList {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #myList li {
            padding: 8px 12px;
            cursor: pointer;
        }

        #myList li:hover {
            background-color: #ddd;
        }

        .modal-overlay-ed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Dim background color */
            z-index: 9999;
        }

        .modal-content-ed {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 10000;
        }

        .close-button {
            position: absolute;
            top: -18px;
            right: -2px;
            font-size: 34px;
            color: #999;
            background: none;
            border: none;
            cursor: pointer;
        }

        .close-button:hover {
            color: #666;
        }
    </style>
    <style>
        <?php include('../css/all_page.css') ?>body {
            font-family: Arial, sans-serif;
        }

        #search-container {
            text-align: center;
            padding: 50px;
        }

        #search-input {
            width: 100%;
            padding: 10px;
            font-size: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #search-button {
            background-color: #4285f4;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        #search-results {
            margin-top: 1%;
            background-color: #f2f2f2;
            border-radius: 5px;
            text-align: left;
            padding: 20px;
        }

        #search-results div {
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            padding: 10px;
        }

        #search-results div:hover {
            border-radius: 5px;
            background-color: #4285f4;
            /* Background color on hover */
            color: #ffff;
            /* Text color on hover */
        }

        .shadow-drop {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.05), 0 6px 20px 0 rgba(0, 0, 0, 0.05);
        }
    </style>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include('bar/sidebar.php');
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include('bar/topbar_admin.php');
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="background"></div>


                <h1 class="pt-5 text-center f-black-5">ค้นหาอุปกรณ์</h1>
                <center>
                    <p>ค้นหาอุปกรณ์ในระบบของคุณ สามารถตรวจสอบสถานะของแต่ละอุปกรณ์ได้</p>
                </center>

                <div class="row">

                    <div class="col">

                        <div id="search-container">
                            <form id="search-form">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" id="search-input" placeholder="หาด้วยเลข Serial Number, ชื่อแบรนด์, ชื่อรุ่น ..." style="border:2px solid #75D3E5">
                                        </div>
                                        <!-- <div class="col-2">
                                            <button type="submit" id="search-button">Search</button>
                                        </div> -->

                                        <div id="search-results">
                                            ค้นหาอุปกรณ์ที่คุณต้องการ....
                                        </div>
                                    </div>
                                    <br>
                                    <nav aria-label="Page navigation example">

                                        <ul class="pagination justify-content-center ">
                                            <li class="page-item">
                                                <a class="page-link" href="search_repair.php" tabindex="-1" aria-disabled="true">ทั้งหมด</a>
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
WHERE rs.status_id = '3' AND rs.rs_date_time = subquery.max_date AND get_repair.del_flg = 0 

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
                                                    <!-- <a href="repair_have.php?search=<?= $first_char ?>" style="color: black;"><?= $first_char ?></a> -->
                                                    <li class="page-item">
                                                        <a class="page-link" href="search_repair.php?word=<?= $first_char ?>" tabindex="-1" aria-disabled="true"><?= $first_char ?></a>
                                                    </li>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </nav>


                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <script>
                    const searchForm = document.getElementById("search-form");
                    const searchInput = document.getElementById("search-input");
                    const searchResults = document.getElementById("search-results");
                    let allResults = [];

                    searchForm.addEventListener("submit", function(e) {
                        e.preventDefault();
                        performSearch();
                    });

                    searchInput.addEventListener("keyup", function() {
                        performSearch();
                    });

                    function performSearch() {
                        const searchTerm = searchInput.value;
                        if (searchTerm) {
                            // Filter results that match the search term
                            const matchingResults = allResults.filter(result => result.text.toLowerCase().includes(searchTerm.toLowerCase()));
                            displaySearchResults(matchingResults);
                        } else {
                            clearSearchResults();
                        }
                    }

                    function simulateSearch(searchTerm) {
                        // Simulated search results
                        const results = [
                            <?php
                            $sql_r = "SELECT * FROM repair WHERE del_flg = 0 ORDER BY r_id DESC";
                            $result_r = mysqli_query($conn, $sql_r);
                            while ($row_r = mysqli_fetch_array($result_r)) {
                            ?> {
                                    id: <?= $row_r['r_id'] ?>,
                                    text: "<?= $row_r['r_brand'] . ' ' . $row_r['r_model'] . ' ' . $row_r['r_number_model'] . ' :  SH - ' . $row_r['r_serial_number'] ?>"
                                },
                            <?php
                            }
                            ?>
                        ];

                        // Store all results
                        allResults = results;

                        // Display search results initially
                        if (searchInput.value) {
                            displaySearchResults(results);
                        }
                    }

                    function displaySearchResults(results) {
                        searchResults.innerHTML = "";
                        if (results.length > 0) {
                            results.forEach((result, index) => {
                                const resultElement = document.createElement("div");
                                resultElement.textContent = result.text;
                                resultElement.addEventListener("click", function() {
                                    window.location.href = `search_repair.php?id=${result.id}`;
                                });
                                searchResults.appendChild(resultElement);
                            });
                        } else {
                            searchResults.textContent = "No results found.";
                        }
                    }

                    function clearSearchResults() {
                        searchResults.innerHTML = "";
                    }

                    // Initial search when the page loads
                    simulateSearch("");
                </script>
                <?php
                if (isset($_GET['id'])) { ?>
                    <div class="container alert alert-light shadow-drop" style="background-color:#F3F3F3">
                        <div class="row">
                            <?php
                            $r_id = $_GET['id'];
                            $sql_check = "SELECT * FROM repair WHERE r_id = ' $r_id'";
                            $result_check = mysqli_query($conn, $sql_check);
                            $row_check = mysqli_fetch_array($result_check);

                            $sql_f = "SELECT * FROM get_repair 
                            LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                            WHERE get_detail.r_id = '$r_id' ORDER BY get_repair.get_r_date_in ASC";
                            $result_f = mysqli_query($conn, $sql_f);
                            $row_f = mysqli_fetch_array($result_f);
                            ?>
                        </div>
                        <div class="row mt-4" class="f-black-5">
                            <span>
                                <h2 class="ln" style="display: inline; color:black"><?= $row_check['r_brand'] ?></h2>
                                <h5 class="ln ml-2" style="display: inline;"><?= '   ' . $row_check['r_model'] . ' ' . $row_check['r_number_model'] ?></h5>
                            </span>
                        </div>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
                        <div class="row ">
                            <div class="col-md pt-3 alart alert-ligth " style="background-color:#F9F9F9">

                                <div class="row mt-4">
                                    <!-- <center>
                                        <hr style="width:98%">
                                    </center> -->

                                    <h5 style="color:black">รายละเอียด <i class="	fa fa-tag"></i></h5>
                                    <?php
                                    if ($row_check['r_date_buy'] != NULL) {
                                    ?>
                                        <p>
                                            วันที่ซื้อ : <?php
                                                            $dateString = $row_check['r_date_buy'];
                                                            $formattedDate = date('d/m/Y - H:i', strtotime($dateString));
                                                            echo $formattedDate;
                                                            ?>

                                        </p>
                                    <?php
                                    } else {
                                    ?>
                                        <p>
                                            วันที่ส่งซ่อมครั้งแรก : <?php


                                                                    $dateString = $row_f['get_r_date_in'];
                                                                    $formattedDate = date('d/m/Y - H:i', strtotime($dateString));
                                                                    if ($row_f['get_r_date_in'] != NULL) {
                                                                        echo $formattedDate;
                                                                    } else {
                                                                        echo "ไม่มีข้อมูล";
                                                                    }

                                                                    ?>

                                        </p>
                                    <?php
                                    }

                                    ?>

                                    <p>หมายเลขอุปกรณ์
                                        <br>


                                        <span style="color: black" id="serialNumber"><?= $row_check['r_serial_number'] ?>
                                            <a href="#" id="copySerialNumber" title="กดเพื่อคัดลอก"><i class='fas fa-copy'></i></a>

                                        </span>
                                        <span id="copyConfirmation" style="display: none; color: green;">คัดลอกแล้ว</span></span>

                                        <script>
                                            document.getElementById("copySerialNumber").addEventListener("click", function() {
                                                // Get the serial number text
                                                const serialNumber = document.getElementById("serialNumber").textContent;

                                                // Create a textarea element to temporarily hold the text
                                                const tempTextarea = document.createElement("textarea");
                                                tempTextarea.value = serialNumber;
                                                document.body.appendChild(tempTextarea);

                                                // Select the text in the textarea and copy it to the clipboard
                                                tempTextarea.select();
                                                document.execCommand("copy");

                                                // Remove the temporary textarea
                                                document.body.removeChild(tempTextarea);

                                                // Display the copy confirmation message
                                                const copyConfirmation = document.getElementById("copyConfirmation");
                                                copyConfirmation.style.display = "inline";

                                                // Hide the confirmation message after a few seconds
                                                setTimeout(function() {
                                                    copyConfirmation.style.display = "none";
                                                }, 3000); // Display for 3 seconds
                                            });
                                        </script>

                                    </p>
                                    <center>
                                        <hr style="width:95%">
                                    </center>


                                    <h5 style="color:black">ข้อมูลติดต่อ <i class="fa fa-address-book ln"></i></h5>
                                    <p>
                                        <?php
                                        $m_id = $row_check['m_id'];

                                        $sql_m = "SELECT * FROM member WHERE m_id = '$m_id'";
                                        $result_m = mysqli_query($conn, $sql_m);
                                        $row_m = mysqli_fetch_array($result_m);
                                        if ($row_m['m_fname'] != NULL && $row_m['m_lname'] != NULL) {
                                        ?>
                                            ชื่อ : <span><?= $row_m['m_fname'] . ' ' . $row_m['m_lname'] ?></span>
                                        <?php
                                        }
                                        ?>
                                        <br>
                                        <?php
                                        if ($row_f['get_tel'] != NULL) {
                                        ?>
                                            เบอร์โทรติดต่อ :
                                            <span style="color: black" id="PhoneNumber"><?= $row_f['get_tel'] ?>
                                                <a href="#" id="copyPhoneNumber" title="กดเพื่อคัดลอก"><i class='fas fa-copy'></i></a>

                                            </span>
                                            <span id="copyConfirmationPhone" style="display: none; color: green;">คัดลอกแล้ว</span></span>
                                            <script>
                                                document.getElementById("copyPhoneNumber").addEventListener("click", function() {
                                                    // Get the serial number text
                                                    const serialNumber = document.getElementById("PhoneNumber").textContent;

                                                    // Create a textarea element to temporarily hold the text
                                                    const tempTextarea = document.createElement("textarea");
                                                    tempTextarea.value = serialNumber;
                                                    document.body.appendChild(tempTextarea);

                                                    // Select the text in the textarea and copy it to the clipboard
                                                    tempTextarea.select();
                                                    document.execCommand("copy");

                                                    // Remove the temporary textarea
                                                    document.body.removeChild(tempTextarea);

                                                    // Display the copy confirmation message
                                                    const copyConfirmation = document.getElementById("copyConfirmationPhone");
                                                    copyConfirmation.style.display = "inline";

                                                    // Hide the confirmation message after a few seconds
                                                    setTimeout(function() {
                                                        copyConfirmation.style.display = "none";
                                                    }, 3000); // Display for 3 seconds
                                                });
                                            </script>
                                            <?php
                                            if ($row_m['m_email'] != NULL) {
                                            ?>
                                                <br>
                                                อีเมล :
                                                <span style="color: black" id="EmailMember"><?= $row_m['m_email'] ?>
                                                    <a href="#" id="copyEmail" title="กดเพื่อคัดลอก"><i class='fas fa-copy'></i></a>

                                                </span>
                                                <span id="copyEmailnofi" style="display: none; color: green;">คัดลอกแล้ว</span></span>

                                                <script>
                                                    document.getElementById("copyEmail").addEventListener("click", function() {
                                                        // Get the serial number text
                                                        const serialNumber = document.getElementById("EmailMember").textContent;

                                                        // Create a textarea element to temporarily hold the text
                                                        const tempTextarea = document.createElement("textarea");
                                                        tempTextarea.value = serialNumber;
                                                        document.body.appendChild(tempTextarea);

                                                        // Select the text in the textarea and copy it to the clipboard
                                                        tempTextarea.select();
                                                        document.execCommand("copy");

                                                        // Remove the temporary textarea
                                                        document.body.removeChild(tempTextarea);

                                                        // Display the copy confirmation message
                                                        const copyConfirmation = document.getElementById("copyEmailnofi");
                                                        copyConfirmation.style.display = "inline";

                                                        // Hide the confirmation message after a few seconds
                                                        setTimeout(function() {
                                                            copyConfirmation.style.display = "none";
                                                        }, 3000); // Display for 3 seconds
                                                    });
                                                </script>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if ($row_m['m_add'] != NULL) {
                                            ?>

                                                <center>
                                                    <hr style="width:95%">
                                                </center>
                                                <br>
                                    <h5 style="color:black">ที่อยู่ <i class="fa fa-map"></i></h5>
                                    <div class="row">
                                        <p>
                                            <?php

                                                $jsonobj = $row_m['m_add'];

                                                $obj = json_decode($jsonobj);

                                                $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
                                                            FROM provinces
                                                            LEFT JOIN amphures ON provinces.id = amphures.province_id
                                                            LEFT JOIN districts ON amphures.id = districts.amphure_id
                                                            WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
                                                $result_p = mysqli_query($conn, $sql_p);
                                                $row_p = mysqli_fetch_array($result_p);
                                            ?>
                                            <?= $obj->description ?>
                                            ตำบล<?= $row_p[2] ?> อำเภอ<?= $row_p[1] ?> จังหวัด<?= $row_p[0] ?>
                                        <?php
                                            }
                                        ?>
                                        </p>
                                    </div>
                                <?php
                                        }
                                ?></p>

                                </div>
                            </div>
                            <?php
                            $cancel_conf = 0;
                            $delete_conf = 0;
                            $count_round = 0;
                            $sql_get = "SELECT get_detail.del_flg ,get_detail.get_d_conf FROM get_repair 
                             LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                             WHERE get_detail.r_id = '$r_id' AND get_repair.del_flg = 0 ORDER BY get_repair.get_r_date_in DESC";
                            $result_get = mysqli_query($conn, $sql_get);
                            while ($row_get = mysqli_fetch_array($result_get)) {
                                $count_round++;
                                if ($row_get['get_d_conf'] == 1) {
                                    $cancel_conf = 1;
                                }
                                if ($row_get['del_flg'] == 1) {
                                    $delete_conf = 1;
                                }
                            }
                            if ($count_round != 0) {
                            ?>
                                <div class="col-md-8">
                                    <div class="accordion accordion" id="accordionFlushExample">
                                        <?php
                                        $count_get = 0;
                                        $sql_get = "SELECT * FROM get_repair 
                                                    LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                                                    WHERE get_detail.r_id = '$r_id' AND get_repair.del_flg = 0 ORDER BY get_repair.get_r_date_in DESC";
                                        $result_get = mysqli_query($conn, $sql_get);
                                        while ($row_get = mysqli_fetch_array($result_get)) {
                                            $count_get++;
                                        ?>
                                            <div class="accordion-item shadow">
                                                <h2 class="accordion-header" id="flush-heading<?= $row_get['get_r_id'] ?>">
                                                    <button id="bounce-item" class="accordion-button <?php if ($count_get == 1) {  ?><?php } else {  ?>collapsed<?php } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $row_get['get_r_id'] ?>" aria-expanded="<?php if ($count_get == 1) {  ?>true<?php  } else {  ?>false<?php } ?>" aria-controls="flush-collapse<?= $row_get['get_r_id'] ?>">
                                                        <?php
                                                        if ($count_get == 1 && $count_round != 1) {
                                                        ?>
                                                            <h5>ครั้งที่ <?= $count_round ?> (ครั้งล่าสุด) </h5>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <h5>ครั้งที่ <?= $count_round ?></h5>
                                                        <?php
                                                        }
                                                        ?>
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse<?= $row_get['get_r_id'] ?>" class="accordion-collapse collapse 
                                                <?php
                                                if ($count_get == 1) {  ?> show <?php } ?>" aria-labelledby="flush-heading<?= $row_get['get_r_id'] ?>" data-bs-parent="#accordionFlushExample">

                                                    <div class="container " style="background-color: #F7FCFF;">
                                                        <br>
                                                        <a class="btn btn-primary" id="bounce-item" href="detail_repair.php?id=<?= $row_get['get_r_id'] ?>">
                                                            <h4 class="ln" style="color:white">หมายเลขซ่อมที่ <?= $row_get['get_r_id'] ?></h4>
                                                        </a>
                                                        <hr>
                                                        <!-- <h5 id="bounce-item"><a href="detail_repair.php?id=<?= $row_get['get_r_id'] ?>" class="btn btn-primary" title="ไปที่หมายเลขซ่อมนี้">หมายเลขซ่อม <?= $row_get['get_r_id'] ?></a>
                                                           
                                                        </h5> -->
                                                        <?php
                                                        $get_r_id = $row_get['get_r_id'];
                                                        $sql_select = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id'";
                                                        $result_select = mysqli_query($conn, $sql_select);
                                                        $row_select = mysqli_fetch_array($result_select);
                                                        ?>
                                                        <h5 style="color:black">รายละเอียด</h5>
                                                        <p>
                                                            <?php
                                                            $get_r_id = $row_get['get_r_id'];
                                                            $sql_p = "SELECT * FROM get_repair WHERE get_r_id = $get_r_id ";
                                                            $result_p = mysqli_query($conn, $sql_p);
                                                            $row_p = mysqli_fetch_array($result_p);

                                                            $dateString = $row_p['get_r_date_in'];
                                                            $formattedDate = date('d/m/Y', strtotime($dateString));

                                                            ?>
                                                            <i class="fa fa-paper-plane"></i> วันที่ส่งซ่อม : <span style="color:black"> <?php
                                                                                                                                            if ($row_f['get_r_date_in'] != NULL) {
                                                                                                                                                echo $formattedDate;
                                                                                                                                            } else {
                                                                                                                                                echo "ไม่มีข้อมูล";
                                                                                                                                            }
                                                                                                                                            ?>
                                                            </span>

                                                            <?php
                                                            $sql_date_out = "SELECT * FROM repair_status WHERE repair_status.del_flg = 0 AND repair_status.status_id = 3 AND repair_status.get_r_id = '$get_r_id'";
                                                            $result_date_out = mysqli_query($conn, $sql_date_out);

                                                            if (mysqli_num_rows($result_date_out)) {
                                                                $row_date_out = mysqli_fetch_array($result_date_out);
                                                                $success = 1;
                                                            ?>

                                                                <br>
                                                                <span style="color:green">
                                                                    <i style="color:green" class="	fa fa-check-circle"></i> วันที่เสร็จสิ้น : <u>
                                                                        <?php



                                                                        $dateString = $row_date_out['rs_date_time'];
                                                                        $formattedDate = date('d/m/Y ', strtotime($dateString));
                                                                        if ($row_f['get_r_date_in'] != NULL) {
                                                                            echo $formattedDate;
                                                                        } else {
                                                                            echo "ไม่มีข้อมูล";
                                                                        }

                                                                        ?>
                                                                </span>
                                                                </u>


                                                            <?php
                                                            } ?>
                                                            <br>
                                                            อาการเสีย : <?= $row_get['get_d_detail']; ?>
                                                            <br>
                                                        <h5 style="color:black">การเลือกการจัดส่ง</h5>
                                                        การจัดส่ง : <span><?php
                                                                            if ($row_get['get_deli'] == 1) {
                                                                            ?>จัดส่งด้วยขนส่ง<?php
                                                                                            } else {
                                                                                                ?>มารับด้วยเอง<?php
                                                                                                            } ?></span>
                                                        <br>

                                                        ที่อยู่ : <span> <?php

                                                                            $jsonobj = $row_get['get_add'];

                                                                            $obj = json_decode($jsonobj);

                                                                            $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
                                                                                        FROM provinces
                                                                                        LEFT JOIN amphures ON provinces.id = amphures.province_id
                                                                                        LEFT JOIN districts ON amphures.id = districts.amphure_id
                                                                                        WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
                                                                            $result_p = mysqli_query($conn, $sql_p);
                                                                            $row_p = mysqli_fetch_array($result_p);
                                                                            ?>
                                                            <?= $obj->description ?>
                                                            ตำบล<?= $row_p[2] ?> อำเภอ<?= $row_p[1] ?> จังหวัด<?= $row_p[0] ?>
                                                        </span>
                                                        <!-- Button trigger modal -->
                                                        <!-- <a data-bs-toggle="modal" data-bs-target="#exampleModal<?= $get_r_id  ?>">
                                                                Launch demo modal
                                                            </a> -->
                                                        </p>




                                                        <?php

                                                        if ($delete_conf == 1) {
                                                        ?>
                                                            <center>
                                                                <!-- <hr> -->
                                                                <h5 class="shadow p-1" style="border-radius:3px;background-color:red;color:white">ไม่สามารถซ่อมได้</h5>
                                                                <br>
                                                            </center>
                                                        <?php
                                                        } elseif ($cancel_conf == 1) {
                                                        ?>
                                                            <center>
                                                                <!-- <hr> -->
                                                                <h5 class="shadow p-1" style="border-radius:3px;background-color:orange;color:white">อยู่ในระหว่างยื่นข้อเสนอ ไม่สามารถซ่อมได้</h5>
                                                                <br>
                                                            </center>
                                                        <?php
                                                        }

                                                        $count_part = 0;
                                                        $count_part_check = 0;
                                                        $get_d_id = $row_get['get_d_id'];
                                                        $sql_p = "SELECT * FROM repair_detail
                                                        LEFT JOIN get_detail ON repair_detail.get_d_id = get_detail.get_d_id
                                                        LEFT JOIN parts ON repair_detail.p_id = parts.p_id
                                                         WHERE get_detail.get_d_id = '$get_d_id'";
                                                        $result_p = mysqli_query($conn, $sql_p);
                                                        while ($row_p = mysqli_fetch_array($result_p)) {
                                                            $count_part++;
                                                            $count_part_check++;
                                                        }
                                                        if ($count_part > 0) { ?>
                                                            <!-- <hr> -->
                                                            <br>
                                                            <div class="row">
                                                                <div>
                                                                    <br>
                                                                    <?php
                                                                    $count_part = 0;
                                                                    $sql_p = "SELECT * FROM repair_detail
                                                                    LEFT JOIN get_detail ON repair_detail.get_d_id = get_detail.get_d_id
                                                                    LEFT JOIN parts ON repair_detail.p_id = parts.p_id
                                                                     WHERE get_detail.get_d_id = '$get_d_id' AND get_detail.del_flg = 0 AND repair_detail.del_flg = 0";
                                                                    $result_p = mysqli_query($conn, $sql_p);
                                                                    while ($row_p = mysqli_fetch_array($result_p)) {
                                                                        if ($row_p['p_id'] != NULL) {
                                                                    ?>
                                                                            <!-- <div class="alert alert-secondary" role="alert">
                                                                                <?= $row_p['p_name'] . ' ' . $row_get['get_d_id'] ?>
                                                                            </div> -->
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        <?php
                                                            $sql_p = "SELECT * FROM repair_detail
                                                                    LEFT JOIN get_detail ON repair_detail.get_d_id = get_detail.get_d_id
                                                                    LEFT JOIN parts ON repair_detail.p_id = parts.p_id
                                                                    WHERE get_detail.get_d_id = '$get_d_id' AND get_detail.del_flg = 0 AND repair_detail.del_flg = 0";
                                                            $result_p = mysqli_query($conn, $sql_p);
                                                            $row_p = mysqli_fetch_array($result_p);
                                                        } elseif ($success != '1') {  ?>
                                                            <center>
                                                                <!-- <hr> -->
                                                                <h5 class="shadow p-1" style="border-radius:3px;background-color:#D8CB00;color:white">การซ่อมอยู่ระหว่างดำเนินการในขณะนี้ <span id="dot-animation<?= $row_get['get_d_id'] ?>"></span></h5>

                                                                <!-- <hr> -->
                                                                <script>
                                                                    const dotAnimation = document.getElementById("dot-animation<?= $row_get['get_d_id'] ?>");
                                                                    let dotCount = 0;

                                                                    function updateDots() {
                                                                        dotCount = (dotCount + 1) % 7; // Reset after 5 dots

                                                                        // Create a string with the desired number of dots
                                                                        const dots = ".".repeat(dotCount);

                                                                        // Update the content of the <span> element
                                                                        dotAnimation.textContent = dots;

                                                                        // Call this function again after a short delay (e.g., 500ms)
                                                                        setTimeout(updateDots, 500);
                                                                    }

                                                                    // Start the animation
                                                                    updateDots();
                                                                </script>
                                                                <br>
                                                            </center>
                                                        <?php
                                                        } elseif ($success == '1') {  ?>
                                                            <center>
                                                                <!-- <hr> -->
                                                                <h5 class="shadow p-1" style="border-radius:3px;background-color:green;color:white">การซ่อมดำเนินการเสร็จสิ้นแล้ว </h5>

                                                                <br>
                                                            </center>
                                                            <?php
                                                        }
                                                        $sql2 = "SELECT rs.rs_id, rs.status_id, st.status_color, rs.rs_conf, rs.rs_date_time, rs.rs_detail,
                                                        gr.get_tel, gr.get_add, gr.get_wages, gr.get_add_price, gr.get_add_price
                                                    FROM get_repair gr
                                                    LEFT JOIN repair_status rs ON gr.get_r_id = rs.get_r_id 
                                                    LEFT JOIN status_type st ON rs.status_id = st.status_id 
                                                    WHERE gr.get_r_id = ? AND rs.del_flg = '0' 
                                                    ORDER BY rs.rs_date_time DESC
                                                    LIMIT 1;";

                                                        // Use prepared statements
                                                        $stmt2 = mysqli_prepare($conn, $sql2);

                                                        if ($stmt2) {
                                                            // Bind the parameter
                                                            mysqli_stmt_bind_param($stmt2, "s", $get_r_id);

                                                            // Execute the statement
                                                            mysqli_stmt_execute($stmt2);

                                                            // Get the result
                                                            $result2 = mysqli_stmt_get_result($stmt2);

                                                            // Fetch data as needed
                                                            $row_2 = mysqli_fetch_assoc($result2);

                                                            // Close the statement
                                                            mysqli_stmt_close($stmt2);
                                                        } else {
                                                            // Handle the error
                                                            echo "Error: " . mysqli_error($conn);
                                                        }
                                                        $sql_c_part = "SELECT
                                                           *,
                                                           repair_detail.p_id,
                                                           repair_detail.rd_value_parts,
                                                           repair_detail.get_d_id,
                                                           parts.p_brand,
                                                           parts.p_model,
                                                           parts.p_price,
                                                           parts_type.p_type_name,
                                                           repair_status.rs_id,
                                                           parts.p_pic
                                                           FROM
                                                           `repair_detail`
                                                           LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                                                           LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
                                                           LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                                                           LEFT JOIN repair ON get_detail.r_id = repair.r_id
                                                           JOIN parts ON parts.p_id = repair_detail.p_id
                                                           LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id
                                                           WHERE
                                                           get_repair.del_flg = 0 AND repair_detail.del_flg = 0
                                                           AND get_repair.get_r_id = ?
                                                           GROUP BY
                                                           rd_id, get_detail.get_d_id;";

                                                        // Use prepared statements
                                                        $stmt_c_part = mysqli_prepare($conn, $sql_c_part);

                                                        if ($stmt_c_part) {
                                                            // Bind the parameter
                                                            mysqli_stmt_bind_param($stmt_c_part, "s", $get_r_id);

                                                            // Execute the statement
                                                            mysqli_stmt_execute($stmt_c_part);

                                                            // Get the result
                                                            $result_c_part = mysqli_stmt_get_result($stmt_c_part);

                                                            // Fetch data as needed
                                                            while ($row_c_part = mysqli_fetch_assoc($result_c_part)) {
                                                                // Process the row data
                                                                $total_part_price +=  $row_c_part['rd_parts_price'];
                                                            }

                                                            // Close the statement
                                                            mysqli_stmt_close($stmt_c_part);
                                                        } else {
                                                            // Handle the error
                                                            echo "Error: " . mysqli_error($conn);
                                                        }
                                                            ?><?php if ($row_2['get_add_price'] + $row_2['get_wages'] + $total_part_price > 0) {  ?>


                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal<?= $get_r_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?= $get_r_id ?>" aria-hidden="true">
                                                                <div class="modal-dialog  modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 style="color:black" class="modal-title" id="exampleModalLabel<?= $get_r_id ?>">รายการซ่อมและค่าบริการ</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <br>
                                                                            <div class="row">
                                                                                <div class="col-md-6 d-flex  justify-content-start">
                                                                                    ค่าอะไหล่
                                                                                </div>
                                                                                <div class="col-md-6 d-flex  justify-content-end">
                                                                                    ฿ <?= number_format($total_part_price) ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6 d-flex  justify-content-start">
                                                                                    ค่าแรง
                                                                                </div>
                                                                                <div class="col-md-6 d-flex  justify-content-end">
                                                                                    ฿ <?php
                                                                                        if ($row_2['get_wages'] != NULL) {
                                                                                            echo number_format($row_2['get_wages']);
                                                                                        } else {
                                                                                            echo '0';
                                                                                        }
                                                                                        ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6 d-flex  justify-content-start">
                                                                                    ค่าจัดส่ง
                                                                                </div>
                                                                                <div class="col-md-6 d-flex  justify-content-end">
                                                                                    ฿ <?php
                                                                                        if ($row_2['get_add_price'] != NULL) {
                                                                                            echo number_format($row_2['get_add_price']);
                                                                                        } else {
                                                                                            echo '0';
                                                                                        }
                                                                                        ?>
                                                                                </div>
                                                                            </div>

                                                                            <?php if ($total_part_price > 0) {   ?>
                                                                                <br>
                                                                                <div class="row">
                                                                                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">ดูรายการอะไหล่</button>
                                                                                </div>
                                                                            <?php   } ?>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion accordion-flush auto-font" id="accordionFlushExample<?= $get_r_id ?>" style="background-color: #F1F1F1;">
                                                                <div class="accordion-item" id="totalprice">
                                                                    <div>
                                                                        <h5 class="accordion-header" id="flush-headingTwo">
                                                                            <br>
                                                                            <!-- Button trigger modal -->
                                                                            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $get_r_id ?>">
                                                                            รวมการสั่งซ่อม <?= number_format($total_part_price + $row_2['get_wages'] + $row_2['get_add_price']) ?> บาท
                                                                        </button> -->
                                                                            <button style="background-color: #F1F1F1;" class="accordion-button collapsed" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $get_r_id ?>" type="button" data-bs-toggle="collapse<?= $get_r_id ?>" data-bs-target="#flush-collapseTwo<?= $get_r_id ?>" aria-expanded="false" aria-controls="flush-collapseTwo<?= $get_r_id ?>" style="background-color: #F1F1F1;">
                                                                                <h6 class="auto-font-head">
                                                                                    รวมการสั่งซ่อม <?= number_format($total_part_price + $row_2['get_wages'] + $row_2['get_add_price']) ?> บาท
                                                                                </h6>
                                                                            </button>
                                                                        </h5>
                                                                    </div>

                                                                    <!-- <span class="tooltip">กดเพื่อดูรายละเอียดเพิ่มเติม</span> -->

                                                                    <div id="flush-collapseTwo<?= $get_r_id ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo<?= $get_r_id ?>" data-bs-parent="#accordionFlushExample<?= $get_r_id ?>">
                                                                        <div class="accordion-body" style="margin-left : 0%;color : gray">
                                                                            <br>
                                                                            <div class="row">
                                                                                <div class="col-md-6 d-flex  justify-content-start">
                                                                                    ค่าอะไหล่
                                                                                </div>
                                                                                <div class="col-md-6 d-flex  justify-content-end">
                                                                                    <?= number_format($total_part_price) ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6 d-flex  justify-content-start">
                                                                                    ค่าแรง
                                                                                </div>
                                                                                <div class="col-md-6 d-flex  justify-content-end">
                                                                                    ฿ <?php
                                                                                        if ($row_2['get_wages'] != NULL) {
                                                                                            echo number_format($row_2['get_wages']);
                                                                                        } else {
                                                                                            echo '0';
                                                                                        }
                                                                                        ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6 d-flex  justify-content-start">
                                                                                    ค่าจัดส่ง
                                                                                </div>
                                                                                <div class="col-md-6 d-flex  justify-content-end">
                                                                                    ฿ <?php
                                                                                        if ($row_2['get_add_price'] != NULL) {
                                                                                            echo number_format($row_2['get_add_price']);
                                                                                        } else {
                                                                                            echo '0';
                                                                                        }
                                                                                        ?>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <div class="row">
                                                                                <!-- <div class="d-flex justify-content-center p-4">
                        
                        
                                                                                <nav aria-label="breadcrumb">
                                                                                    <ol class="breadcrumb">
                                                                                        <li class="breadcrumb-item"><a href="#">ดูรายการอะไหล่</a></li>
                                                                                    </ol>
                                                                                </nav>
                                                                            </div> -->
                                                                                <?php if ($count_part_check > 0) {   ?>
                                                                                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">ดูรายการอะไหล่</button>
                                                                                <?php   } ?>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        <?php
                                                                } ?>
                                                        <hr>
                                                        <center>
                                                            <a class="ln" href="detail_repair.php?id=<?= $row_get['get_r_id'] ?>" style="color:;text-decortion:none">ดูรายละเอียดต่างๆเพิ่มเติม</a>
                                                        </center>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            $count_round--;
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                } else {
                ?>
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
                        WHERE  rs.status_id = '3' AND rs.rs_date_time = subquery.max_date AND get_repair.del_flg = 0 
                        
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
                        WHERE   rs.status_id = '3' AND rs.rs_date_time = subquery.max_date AND get_repair.del_flg = 0 AND (
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
                                                    $remember_first = $firstChar; ?>
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
                                                    <a href="search_repair.php?id=<?= $row1['r_id'] ?>" id="card_sent" data-bs-toggle="tooltip" data-bs-placement="top" title="Model: <?= $row1['r_number_model'] ?>">
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
                                                    <a href="search_repair.php?id=<?= $row1['r_id'] ?>" id="card_sent" data-bs-toggle="tooltip" data-bs-placement="top" title="Model: <?= $row1['r_number_model'] ?>">
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
                                    <p>*** หากคุณต้องการดูข้อมูล "การซ่อมทั้งหมด" *** </p>
                                    <a href="search_repair.php" class="btn btn-primary">ข้อมูลทั้งหมด</a>
                                </center>
                            <?php  } ?>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


    </div>
    <!-- End of Content Wrapper -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website 2020</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Sweet Alert Show Start -->
    <?php
    if (isset($_SESSION['add_data_alert'])) {
        if ($_SESSION['add_data_alert'] == 0) {
            $id = 123; // Replace 123 with the actual ID you want to pass to the deletion action
    ?>
            <script>
                Swal.fire({
                    title: 'เพิ่มข้อมูลสำเร็จ',
                    text: 'กด Accept เพื่อออก',
                    icon: 'success',
                    confirmButtonText: 'Accept'
                });
            </script>
        <?php
            unset($_SESSION['add_data_alert']);
        } else if ($_SESSION['add_data_alert'] == 1) {
        ?>
            <script>
                Swal.fire({
                    title: 'มี Serial Number นี้อยู่แล้ว ',
                    text: 'กด Accept เพื่อออก',
                    icon: 'error',
                    confirmButtonText: 'Accept'
                });
            </script>

    <?php
            unset($_SESSION['add_data_alert']);
        }
    }
    ?>
    <!-- Sweet Alert Show End -->

</body>

</html>
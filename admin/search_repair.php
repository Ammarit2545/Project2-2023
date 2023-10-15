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
        body {
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


                <h1 class="pt-5 text-center">ค้นหาอุปกรณ์</h1>
                <center>
                    <p>ค้นหาอุปกรณ์ในระบบของคุณ สามารถตรวจสอบสถานะของแต่ละอุปกรณ์ได้</p>
                </center>
                <div class="row">

                    <div class="col">

                        <div id="search-container">
                            <form id="search-form">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" id="search-input" placeholder="Search...">
                                        </div>
                                        <div class="col-2">
                                            <button type="submit" id="search-button">Search</button>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div id="search-results">
                                            ค้นหาอุปกรณ์ที่คุณต้องการ....
                                        </div>
                                    </div>
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
                    <div class="container alert alert-light">
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
                            <!-- <div class="col">
                                <h1><?= $row_check['r_brand'] . ' ' . $row_check['r_model'] . ' ' . $row_check['r_number_model'] . ' :  SH - ' . $row_check['r_serial_number'] ?></h1>
                            </div> -->
                        </div>
                        <div class="row" class="f-black-5">
                            <span>
                                <h2 class="ln" style="display: inline; color:black"><?= $row_check['r_brand'] ?></h2>
                                <h5 class="ln ml-2" style="display: inline;"><?= '   ' . $row_check['r_model'] . ' ' . $row_check['r_number_model'] ?></h5>
                            </span>
                        </div>
                        <hr>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                   
                                    <?php
                                    if ($row_check['r_date_buy'] != NULL) {
                                    ?>
                                        <p>
                                            วันที่ซื้อ : <?php
                                                            $dateString = $row_check['r_date_buy'];
                                                            $formattedDate = date('d / m / Y - H:i', strtotime($dateString));
                                                            echo $formattedDate;
                                                            ?>

                                        </p>
                                    <?php
                                    } else {
                                    ?>
                                        <p>
                                            วันที่ส่งซ่อมครั้งแรก : <?php


                                                                    $dateString = $row_f['get_r_date_in'];
                                                                    $formattedDate = date('d /m /Y - H:i', strtotime($dateString));
                                                                    echo $formattedDate;
                                                                    ?>

                                        </p>
                                    <?php
                                    }
                                    ?>
                                     <p>หมายเลขอุปกรณ์
                                        <br>
                                        <!-- Add an ID to the serial number span for easier JavaScript targeting -->
                                        <span style="color: black" id="serialNumber"><?= $row_check['r_serial_number'] ?></span>
                                        <!-- Add a clickable copy icon -->
                                        <span>
                                            <a href="#" id="copySerialNumber" title="กดเพื่อคัดลอก"><i class='fas fa-copy'></i></a>
                                            <!-- Add a span for the copy confirmation message -->
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


                                    <h5 style="color:black">ข้อมูลติดต่อ</h5>
                                    <?php
                                    if ($row_f['get_tel'] != NULL) {
                                    ?>
                                        <p>เบอร์โทรติดต่อ : <span><?= $row_f['get_tel'] ?></span></p>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                Accordion Item #1
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                Accordion Item #2
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                Accordion Item #3
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
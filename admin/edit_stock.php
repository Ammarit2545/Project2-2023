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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Edit Employee Information</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .modal {
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

        .modal-content {
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

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Dim background color */
            z-index: 9999;
        }

        .modal-content {
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
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #999;
            background: none;
            border: none;
            cursor: pointer;
        }

        .close-button:hover {
            color: #666;
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

                <!-- Content Here Start -->

                <h1 class="pt-5 text-center">จัดการสต๊อก</h1>
                <center>
                    <p>บันทึกจำนวนอะไหล่</p>
                </center>
                <br>

                <form action="action/edit_stock.php" method="POST" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div style="background-color : #EEEEEE; margin-top : 40px" id="parts_select" class="col-12">
                                <!-- Content of the parts select div -->
                                <hr>
                                <div class="mb-3">
                                    <h3>อะไหล่</h3>
                                    <div id="cardContainer" style="display: none;">
                                        <table class="table" id="cardSection"></table>
                                    </div>
                                    <!-- <button type="button" class="btn btn-primary" onclick="showNextCard()">Show Card</button> -->
                                </div>

                                <?php
                                $sql_p = "SELECT * FROM parts WHERE del_flg = '0'";
                                $result_p = mysqli_query($conn, $sql_p);
                                $optionsHTML = "";
                                while ($row_p = mysqli_fetch_array($result_p)) {
                                    $optionsHTML .= '<option value="' . $row_p['p_id'] . '" data-pic="../' . $row_p['p_pic'] . '" data-price="' . $row_p['p_price'] . '" data-name="' . $row_p['p_name'] . '">' . $row_p['p_name'] . '</option>';
                                }
                                ?>

                                <script>
                                    vvar partsOptions = '<?php echo $optionsHTML; ?>';
                                    var partsData = <?php echo json_encode($partsData); ?>;

                                    function showNextCard() {
                                        cardCount++;
                                        var cardContainer = document.getElementById("cardContainer");
                                        var cardSection = document.getElementById("cardSection");
                                        cardSection.innerHTML = ""; // Clear existing cards

                                        for (var i = 1; i <= cardCount; i++) {
                                            // ... existing code ...

                                            var selectElement = document.createElement("select");
                                            selectElement.name = "p_id" + i;
                                            selectElement.className = "custom-select";
                                            selectElement.id = "inputGroupSelect" + i;
                                            selectElement.addEventListener("change", function() {
                                                showSelectedOption(i);
                                            });

                                            var defaultOption = document.createElement("option");
                                            defaultOption.selected = true;
                                            defaultOption.textContent = "Choose...";
                                            selectElement.appendChild(defaultOption);

                                            // Append each option to the select element
                                            partsOptions.forEach(function(option) {
                                                var optionElement = document.createElement("option");
                                                optionElement.value = option.value;
                                                optionElement.textContent = option.label;
                                                selectElement.appendChild(optionElement);
                                            });

                                            // ... existing code ...
                                        }

                                        cardContainer.style.display = "block"; // Show the card section

                                        // Update the hidden input field value with the cardCount
                                        document.getElementById("cardCountInput").value = cardCount;
                                    }

                                    function showSelectedOption(cardIndex) {
                                        var selectElement = document.getElementById(`inputGroupSelect${cardIndex}`);
                                        var selectedOption = selectElement.options[selectElement.selectedIndex];
                                        var cardImg = document.getElementById(`cardImg${cardIndex}`);
                                        var cardTitle = document.getElementById(`cardTitle${cardIndex}`);
                                        var cardPrice = document.getElementById(`cardPrice${cardIndex}`);

                                        // Retrieve the data attributes from the selected option
                                        var pic = selectedOption.getAttribute("data-pic");
                                        var name = selectedOption.getAttribute("data-name");
                                        var p_price = selectedOption.getAttribute("data-price");
                                        var partId = selectedOption.value;

                                        // Update the card image and title with the selected option's data
                                        cardImg.src = pic;
                                        cardTitle.textContent = name;

                                        // Assign the price value directly as a string
                                        cardPrice.value = p_price;

                                        // Find the selected part in the partsData array
                                        var selectedPart = partsData.find(function(part) {
                                            return part.p_id === partId;
                                        });

                                        if (selectedPart) {
                                            // Update the input field value with the price from the database
                                            var price = parseFloat(selectedPart.p_price);
                                            cardPrice.value = parseInt(price).toString();
                                        }

                                        // Hide the selected option in the next select dropdown
                                        selectedOption.style.display = "none";

                                        // Disable the selected option to prevent selection
                                        selectedOption.disabled = true;
                                    }

                                    var cardCount = 0;
                                    var cardValues = {}; // Object to store card values

                                    function increment(inputId) {
                                        var input = document.getElementById(inputId);
                                        var value = parseInt(input.value);
                                        input.value = value + 1;
                                        cardValues[inputId] = value + 1; // Update card value in the object
                                        calculateTotalPrice(inputId.slice(4)); // Calculate total price when incremented
                                    }

                                    function decrement(inputId) {
                                        var input = document.getElementById(inputId);
                                        var value = parseInt(input.value);
                                        if (value > 0) {
                                            input.value = value - 1;
                                            cardValues[inputId] = value - 1; // Update card value in the object
                                            calculateTotalPrice(inputId.slice(4)); // Calculate total price when decremented
                                        }
                                    }

                                    function deleteCard(cardId) {
                                        var cardContainer = document.getElementById("cardContainer");
                                        var cardSection = document.getElementById("cardSection");

                                        if (cardId in cardValues) {
                                            delete cardValues[cardId]; // Remove card value from the object
                                        }

                                        var cardElement = document.getElementById(cardId);
                                        if (cardElement) {
                                            cardElement.closest("tr").remove(); // Remove the card row from the DOM
                                        }

                                        cardCount--; // Decrease the card count

                                        if (cardCount === 0) {
                                            cardContainer.style.display = "none"; // Hide the card section if there are no cards
                                        }
                                    }
                                </script>
                                <br>
                                <div class="mb-3">
                                    <div id="cardContainer" style="display: none;">
                                        <table class="table" id="cardSection"></table>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="showNextCard()">เพิ่มอะไหล่</button>
                                    <input type="hidden" name="cardCount" id="cardCountInput" value="0">
                                </div>

                                <?php
                                $sql_p = "SELECT * FROM parts WHERE del_flg = '0'";
                                $result_p = mysqli_query($conn, $sql_p);
                                $optionsHTML = "";
                                while ($row_p = mysqli_fetch_array($result_p)) {
                                    $optionsHTML .= '<option value="' . $row_p['p_id'] . '" data-pic="../' . $row_p['p_pic'] . '" data-price="' . $row_p['p_price'] . '" data-name="' . $row_p['p_name'] . '">' . $row_p['p_name'] . '</option>';
                                }
                                ?>

                                <script>
                                    var partsOptions = '<?php echo $optionsHTML; ?>';
                                    var partsData = <?php echo json_encode($partsData); ?>;

                                    function showNextCard() {
                                        cardCount++;
                                        var cardContainer = document.getElementById("cardContainer");
                                        var cardSection = document.getElementById("cardSection");
                                        cardSection.innerHTML = ""; // Clear existing cards

                                        for (var i = 1; i <= cardCount; i++) {
                                            var cardId = "card" + i; // Unique ID for each card
                                            cardValues[cardId] = cardValues[cardId] || 0; // Initialize card value to 0 if not set

                                            var tableRow = document.createElement("tr");
                                            tableRow.innerHTML = `
                                                                <td><img id="cardImg${i}" alt="Card image cap" style="max-width: 150px;"></td>
                                                                <td id="cardTitle${i}"></td>
                                                                <td>
                                                                    <select name="p_id${i}" class="custom-select" id="inputGroupSelect${i}" onchange="showSelectedOption(${i})">
                                                                        <option selected>Choose...</option>
                                                                        ${partsOptions}
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <div class="col-6 px-0">
                                                                            <input type="number" name="value_p${i}" id="${cardId}" value="1" class="form-control" onchange="calculateTotalPrice(${i})">
                                                                        </div>
                                                                        <div class="col-6 px-0">
                                                                            <div class="input-group-prepend">
                                                                                <button type="button" class="btn btn-primary" onclick="increment('${cardId}')">+</button>
                                                                                <button type="button" class="btn btn-danger" onclick="decrement('${cardId}')">-</button>
                                                                                <button type="button" class="btn btn-secondary" onclick="deleteCard('${cardId}')">Delete</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            `;

                                            cardSection.appendChild(tableRow); // Add new card row
                                        }

                                        cardContainer.style.display = "block"; // Show the card section

                                        // Update the hidden input field value with the cardCount
                                        document.getElementById("cardCountInput").value = cardCount;
                                    }

                                    function showSelectedOption(cardIndex) {
                                        var selectElement = document.getElementById(`inputGroupSelect${cardIndex}`);
                                        var selectedOption = selectElement.options[selectElement.selectedIndex];
                                        var cardImg = document.getElementById(`cardImg${cardIndex}`);
                                        var cardTitle = document.getElementById(`cardTitle${cardIndex}`);

                                        // Retrieve the data attributes from the selected option
                                        var pic = selectedOption.getAttribute("data-pic");
                                        var name = selectedOption.getAttribute("data-name");
                                        var p_price = selectedOption.getAttribute("data-price");
                                        var partId = selectedOption.value;

                                        // Update the card image and title with the selected option's data
                                        cardImg.src = pic;
                                        cardTitle.textContent = name;
                                        // Hide the selected option in the next select dropdown
                                        selectedOption.style.display = "none";

                                        // Disable the selected option to prevent selection
                                        selectedOption.disabled = true;
                                    }
                                    var cardCount = 0;
                                    var cardValues = {}; // Object to store card values

                                    function increment(inputId) {
                                        var input = document.getElementById(inputId);
                                        var value = parseInt(input.value);
                                        input.value = value + 1;
                                        cardValues[inputId] = value + 1; // Update card value in the object
                                        calculateTotalPrice(inputId.slice(4)); // Calculate total price when incremented
                                    }

                                    function decrement(inputId) {
                                        var input = document.getElementById(inputId);
                                        var value = parseInt(input.value);
                                        if (value > 0) {
                                            input.value = value - 1;
                                            cardValues[inputId] = value - 1; // Update card value in the object
                                            calculateTotalPrice(inputId.slice(4)); // Calculate total price when decremented
                                        }
                                    }

                                    function deleteCard(cardId) {
                                        var cardContainer = document.getElementById("cardContainer");
                                        var cardSection = document.getElementById("cardSection");

                                        if (cardId in cardValues) {
                                            delete cardValues[cardId]; // Remove card value from the object
                                        }

                                        var cardElement = document.getElementById(cardId);
                                        if (cardElement) {
                                            cardElement.closest("tr").remove(); // Remove the card row from the DOM
                                        }

                                        cardCount--; // Decrease the card count

                                        if (cardCount === 0) {
                                            cardContainer.style.display = "none"; // Hide the card section if there are no cards
                                        }
                                    }
                                </script>
                                <hr>
                            </div>

                        </div>
                    </div>
                </form>

                <!-- Content End -->

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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div>

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
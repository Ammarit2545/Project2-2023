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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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


                <h1 class="pt-5 text-center">บันทึกการซ่อมด้วยตัวเอง</h1>
                <center>
                    <p>บันทึกการซ่อมด้วยตัวเอง สินค้าที่เสียหายจะต้องซ่อมเสร็จสิ้นแล้วเท่านั้น</p>
                </center>
                <br>
                <form id="self_record" action="action/add_self_repair.php" method="POST" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="tel">ชื่อยี่ห้อ</label>
                                        <input type="text" class="form-control input" id="borderinput" name="name_brand" placeholder="กรุณากรอก ชื่อยี่ห้อ" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="tel">เลข Serial Number</label>
                                        <!-- <input type="text" class="form-control input" id="borderinput" name="serial_number" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)"> -->
                                        <input type="text" name="serial_number" value="NPE123456" placeholder="กรุณากรอก หมายเลข Serial Number  (ไม่จำเป็น)" class="form-control" id="inputPassword" onblur="CheckSerial()" required>
                                        <span id="serial-error" style="color:red;display:none;">อุปกรณ์หมดระยะประกันแล้ว</span>
                                        <!-- exits -->
                                        <span id="serial-error-ok" style="color:blue;display:none;">อุปกรณ์นี้ยังอยู่ในระยะประกัน</span>
                                        <!-- else -->
                                        <span id="serial-error-none" style="color:green;display:none;">หมายเลข Serial Number นี้สามารถใช้งานได้</span>
                                        <!-- exits ok-->
                                        <span id="serial-error-have" style="color:red;display:none;">อุปกรณ์นี้อยู่ระหว่างการซ่อมของคุณ</span>
                                        <!-- exits have-->
                                        <script>
                                            function CheckSerial() {
                                                var serial = document.getElementById('inputPassword').value;
                                                var xhttp = new XMLHttpRequest();
                                                xhttp.onreadystatechange = function() {
                                                    if (this.readyState == 4 && this.status == 200) {
                                                        if (this.responseText == 'exists') {
                                                            document.getElementById('serial-error').style.display = 'block';
                                                            document.getElementById('serial-error-ok').style.display = 'none';
                                                            document.getElementById('serial-error-none').style.display = 'none';
                                                            document.getElementById('serial-error-have').style.display = 'none';
                                                            document.getElementById('inputPassword').setCustomValidity('');
                                                        } else if (this.responseText == 'exists-ok') {
                                                            document.getElementById('serial-error').style.display = 'none';
                                                            document.getElementById('serial-error-ok').style.display = 'none';
                                                            document.getElementById('serial-error-none').style.display = 'block';
                                                            document.getElementById('serial-error-have').style.display = 'none';
                                                            document.getElementById('inputPassword').setCustomValidity('');
                                                        } else if (this.responseText == 'exists-have') {
                                                            document.getElementById('serial-error').style.display = 'none';
                                                            document.getElementById('serial-error-ok').style.display = 'none';
                                                            document.getElementById('serial-error-none').style.display = 'none';
                                                            document.getElementById('serial-error-have').style.display = 'block';
                                                            document.getElementById('inputPassword').setCustomValidity('ไม่สามารถส่งข้อมูลที่อยู่ในขณะดำเนินการซ่อมได้');
                                                        } else {
                                                            document.getElementById('serial-error').style.display = 'none';
                                                            document.getElementById('serial-error-ok').style.display = 'block';
                                                            document.getElementById('serial-error-none').style.display = 'none';
                                                            document.getElementById('serial-error-have').style.display = 'none';
                                                            document.getElementById('inputPassword').setCustomValidity('');
                                                        }
                                                    }
                                                };
                                                xhttp.open('GET', 'action/check_serial_number.php?serial=' + serial, true);
                                                xhttp.send();
                                            }
                                        </script>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-6">
                                        <label for="tel">ชื่อรุ่น</label>
                                        <input type="text" class="form-control input" id="borderinput" name="name_model" placeholder="กรุณากรอก ชื่อรุ่น" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="tel">หมายเลขรุ่น</label>
                                        <input type="text" class="form-control input" id="borderinput" name="number_model" placeholder="กรุณากรอก หมายเลขรุ่น  (ไม่จำเป็น)">
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="row">

                                    <div class="col-4">
                                        <label for="tel">ชื่อบริษัท <p style="color : red; display : inline">*กรณีมีประกันกับทางร้าน</p></label>
                                        <br>
                                        <select class="form-select" aria-label="Default select example" name="company">
                                            <option selected>กรุณาเลือกบริษัท</option>
                                            <?php
                                            $sql_c = "SELECT * FROM company WHERE del_flg = '0'";
                                            $result_c = mysqli_query($conn, $sql_c);
                                            while ($row_c = mysqli_fetch_array($result_c)) {
                                            ?><option value="<?= $row_c['com_id'] ?>"><?= $row_c['com_name'] ?></option>
                                            <?php  }  ?>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label for="tel">ยืนยันการใช้อะไหล่จากสมาชิกหรือยัง</label>
                                        <br>
                                        <select class="form-select" aria-label="Default select example" name="status_id" onchange="togglePartsSelect()">
                                            <option selected>กรุณาเลือกสถานะ</option>
                                            <option value="3">เสร็จสิ้น - สินค้าที่ซื้อแล้วเก็บเลข Serial</option>
                                            <option value="4">รายละเอียด - ยังไม่ได้รับการยืนยัน</option>
                                            <option value="5">ยืนยัน - ยืนยันการใช้อะไหล่แล้ว</option>
                                        </select>
                                    </div>



                                    <script>
                                        function togglePartsSelect() {
                                            var selectElement = document.querySelector('select[name="status_id"]');
                                            var partsSelectDiv = document.getElementById('parts_select');

                                            if (selectElement.value === '5' || selectElement.value === '4') {
                                                partsSelectDiv.style.display = 'block';
                                            } else {
                                                partsSelectDiv.style.display = 'none';
                                            }
                                        }
                                    </script>


                                    <div class="col-4">
                                        <label for="basic-url" class="form-label">รหัสสมาชิก</label>
                                        <input type="text" name="m_id" class="form-control" id="myInput" onclick="openModal()" placeholder="ค้นหาข้อมูลสมาชิก">
                                        <div id="myModal" class="modal">
                                            <div class="modal-overlay" id="myModal">
                                                <div class="modal-content">
                                                    <button class="close-button" onclick="closeModal()">&times;</button>
                                                    <label for="tel">รายชื่อสมาชิก <p style="color: red; display: inline;">*ส่งค่าเป็นรหัส ID สมาชิก</p></label>
                                                    <input type="text" id="searchInput" oninput="searchFunction()" placeholder="Search...">
                                                    <ul id="myList"></ul>
                                                </div>
                                            </div>


                                        </div>
                                        <?php
                                        $sql1 = "SELECT * FROM member WHERE del_flg = 0";
                                        $result1 = mysqli_query($conn, $sql1);
                                        $data = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                                        ?>

                                        <script>
                                            var input = document.getElementById("myInput");
                                            var modal = document.getElementById("myModal");
                                            var searchInput = document.getElementById("searchInput");
                                            var myList = document.getElementById("myList");
                                            var data = <?php echo json_encode($data); ?>;

                                            function openModal() {
                                                modal.style.display = "block";
                                                searchInput.value = "";
                                                populateList(data);
                                                searchInput.focus();
                                            }

                                            function closeModal() {
                                                modal.style.display = "none";
                                            }

                                            function selectItem(event) {
                                                var selectedValue = event.target.textContent;
                                                var option = document.createElement("option");
                                                option.value = selectedValue.split(" - ")[0]; // Extract m_id from the selected value
                                                option.textContent = selectedValue;
                                                option.selected = true;
                                                input.appendChild(option);
                                                closeModal();
                                            }


                                            function populateList(items) {
                                                myList.innerHTML = "";

                                                // Create the default option element
                                                var defaultOption = document.createElement("option");
                                                defaultOption.value = "0";
                                                defaultOption.textContent = " 0 - ไม่มี";
                                                defaultOption.selected = true;
                                                myList.appendChild(defaultOption);

                                                for (var i = 0; i < items.length; i++) {
                                                    var li = document.createElement("li");
                                                    li.textContent = items[i].m_id + " - " + items[i].m_fname + " " + items[i].m_lname; // Display m_id, first name, and last name
                                                    li.addEventListener("click", selectItem);
                                                    myList.appendChild(li);
                                                }
                                            }


                                            function searchFunction() {
                                                var searchTerm = searchInput.value.toLowerCase();
                                                var filteredData = data.filter(function(item) {
                                                    var fullName = item.m_fname.toLowerCase() + " " + item.m_lname.toLowerCase(); // Concatenate first name and last name
                                                    return (
                                                        item.m_id.toString().includes(searchTerm) || // Check if m_id includes the search term
                                                        fullName.includes(searchTerm) // Check if the full name includes the search term
                                                    );
                                                });
                                                populateList(filteredData);
                                            }

                                            function selectItem(event) {
                                                var selectedValue = event.target.textContent;
                                                var m_id = selectedValue.split(" - ")[0]; // Extract m_id from the selected value
                                                input.value = m_id;
                                                closeModal();
                                            }
                                        </script>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div style="display: none; background-color : #EEEEEE; margin-top : 40px" id="parts_select" class="col-12">
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

                                                // Calculate the total price when the option is selected
                                                calculateTotalPrice(cardIndex);
                                            }


                                            function calculateTotalPrice(cardIndex) {
                                                var quantityInput = document.getElementById(`card${cardIndex}`);
                                                var priceInput = document.getElementById(`cardPrice${cardIndex}`);
                                                var totalPriceInput = document.getElementById(`cardTotalPrice${cardIndex}`);

                                                var quantity = parseFloat(quantityInput.value);
                                                var price = parseInt(priceInput.value);
                                                var totalPrice = quantity * price;

                                                totalPriceInput.value = totalPrice.toFixed(3);
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
                                                               
                                                                <td>
                                                                    <input type="text" name="p_price_total${i}" id="cardPrice${i}" class="form-control" readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="p_price_total${i}" id="cardTotalPrice${i}" class="form-control" readonly value="0">
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

                                                // Calculate the total price when the option is selected
                                                calculateTotalPrice(cardIndex);
                                            }

                                            function calculateTotalPrice(cardIndex) {
                                                var quantityInput = document.getElementById(`card${cardIndex}`);
                                                var priceInput = document.getElementById(`cardPrice${cardIndex}`);
                                                var totalPriceInput = document.getElementById(`cardTotalPrice${cardIndex}`);

                                                var quantity = parseFloat(quantityInput.value);
                                                var price = parseInt(priceInput.value);
                                                var totalPrice = quantity * price;

                                                totalPriceInput.value = totalPrice.toFixed(3);
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
                                <br>
                                <label for="borderinput1" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ</label>
                                <div class="row">
                                    <div class="col-3">
                                        <input type="file" name="image1" onchange="previewImage('image-preview1')" id="fileToUpload">
                                        <div id="image-preview1"></div>
                                    </div>
                                    <div class="col-3">
                                        <input type="file" name="image2" onchange="previewImage('image-preview2')" id="fileToUpload">
                                        <div id="image-preview2"></div>
                                    </div>
                                    <div class="col-3">
                                        <input type="file" name="image3" onchange="previewImage('image-preview3')" id="fileToUpload">
                                        <div id="image-preview3"></div>
                                    </div>
                                    <div class="col-3">
                                        <input type="file" name="image4" onchange="previewImage('image-preview4')" id="fileToUpload">
                                        <div id="image-preview4"></div>
                                    </div>
                                </div>
                                <br>
                                <script>
                                    function previewImage(previewId) {
                                        var input = event.target;
                                        var previewContainer = document.getElementById(previewId);
                                        var previewImage = document.createElement('img');

                                        // Set the maximum width and maximum height of the image
                                        previewImage.style.maxWidth = '200px';
                                        previewImage.style.maxHeight = '200px';

                                        // Set the border radius and border style of the image
                                        previewImage.style.borderRadius = '10%';
                                        previewImage.style.border = '2px solid gray';

                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                previewImage.setAttribute('src', e.target.result);
                                                previewContainer.appendChild(previewImage);
                                            };
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                                <div class="row">
                                    <label for="inputtext" class="form-label">กรุณากรอกรายละเอียด</label>
                                    <textarea class="form-control" id="inputtext" rows="3" name="description" required placeholder="กรุณากรอกรายละเอียด"></textarea>
                                </div>
                                <div class="row">
                                    <div class="text-center pt-4">
                                        <center>
                                            <a class="btn btn-success" value="Upload Image" name="submit" onclick="showConfirmation()">ยืนยัน</a>

                                            <script>
                                                function showConfirmation() {
                                                    Swal.fire({
                                                        title: "ยืนยันการส่งข้อมูล",
                                                        text: "คุณต้องการที่จะยืนยันการส่งข้อมูลหรือไม่?",
                                                        icon: "question",
                                                        showCancelButton: true,
                                                        confirmButtonColor: "#3085d6",
                                                        cancelButtonColor: "#d33",
                                                        confirmButtonText: "ใช่, ยืนยัน!",
                                                        cancelButtonText: "ยกเลิก"
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // User confirmed, proceed with form submission
                                                            document.getElementById("self_record").submit();
                                                        }
                                                    });
                                                }
                                            </script>

                                        </center>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
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
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

    <title>Repair Information - Anan Electronic</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<style>
    .picture_modal {
        margin-right: 20px;
        border-radius: 10%;
    }

    .image-container {
        position: relative;
        display: inline-block;
        margin: 8px;
    }

    .preview-image {
        display: block;
        width: 200px;
        height: auto;
    }

    .delete-button {
        position: absolute;
        top: 0;
        right: 0;
        background-color: none;
        border: none;
        color: black;
        font-weight: bold;
        font-size: 24px;
        cursor: pointer;
        outline: none;
    }

    .gallery {
        display: flex;
        flex-wrap: wrap;
    }

    .gallery img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
        margin: 10px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.8);
        opacity: 0;
        transition: opacity 0.3s ease-in;
    }

    .modal.show {
        opacity: 1;
    }

    .modal-image {
        display: block;
        margin: 0 auto;
        max-width: 80%;
        max-height: 80%;
        text-align: center;
    }


    .close {
        color: #fff;
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #ccc;
        text-decoration: none;
        cursor: pointer;
    }

    .part_pic_show {
        border-radius: 20%;
    }

    .color_text {
        color: white;
    }

    .file-input-container {
        display: flex;
        flex-direction: row;
        align-items: center;

    }

    .file-input-container label {
        margin-right: 10px;
        text-align: start;
    }

    .file-input-container .col-4 {
        flex: 0 0 25%;
        max-width: 25%;
        padding: 0 5px;

    }
</style>

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
                <div class="container-fluid">
                    <?php
                    $get_r_id = $_GET['id'];

                    $sql = "SELECT * FROM get_repair
                    LEFT JOIN repair ON repair.r_id = get_repair.r_id 
                    LEFT JOIN member ON member.m_id = repair.m_id
                    LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id
                    LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
                    WHERE get_repair.del_flg = '0' AND get_repair.get_r_id = '$get_r_id' ORDER BY rs_date_time DESC";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);

                    $dateString = date('d-m-Y', strtotime($row['get_r_date_in']));
                    $date = DateTime::createFromFormat('d-m-Y', $dateString);
                    $formattedDate = $date->format('F / d / Y');
                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="m-0 font-weight-bold text-primary">หมายเลขแจ้งซ่อม : <?= $row['get_r_id'] ?></h1>
                            <h1 class="m-0 font-weight-bold text-success">Serial Number : <?= $row['r_serial_number'] ?></h1>
                            <h2>สถานะ : <button style="background-color: <?= $row['status_color'] ?>; color : white;" class="btn btn"> <?= $row['status_name'] ?></h2></button>
                            <h6><?= $formattedDate ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <h6 for="staticEmail" class="col-sm-1 col-form-label">ชื่อ</h6>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="staticEmail" value="<?= $row['m_fname']  ?>" placeholder="สวย" disabled>
                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">นามสกุล</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" value="<?= $row['m_lname']  ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-1 col-form-label">Brand :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" value="<?= $row['r_brand']  ?>" placeholder="Yamaha" disabled="disabled">
                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">Model :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" value="<?= $row['r_model']  ?>" placeholder="NPX8859" disabled="disabled">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-1 col-form-label">เบอร์โทรศัพท์</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" placeholder="000000000" value="<?= $row['get_tel']  ?>" disabled="disabled">
                                </div>
                                <label for="inputPassword" class="col-sm-1 col-form-label">บริษัท</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputPassword" placeholder="ไทยคมนาคม" value="<?php
                                                                                                                                if ($row['com_id'] == NULL) {
                                                                                                                                    echo "ไม่มีข้อมูล";
                                                                                                                                } else {
                                                                                                                                    $com_id = $row['com_id'];
                                                                                                                                    $sql_com = "SELECT * FROM company WHERE com_id = '$com_id'";
                                                                                                                                    $result_com = mysqli_query($conn, $sql_com);
                                                                                                                                    $row_com = mysqli_fetch_array($result_com);

                                                                                                                                    echo $row_com['com_name'];
                                                                                                                                }
                                                                                                                                ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="col-form-label">ที่อยู่ :</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?php
                                                                                                                                if ($row['get_add'] == NULL) {
                                                                                                                                    echo "ไม่มีข้อมูล";
                                                                                                                                } else {
                                                                                                                                    echo ($row['get_add']);
                                                                                                                                }
                                                                                                                                ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="col-form-label">รายละเอียด :</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled"><?= $row['get_r_detail']  ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="col-form-label">รูปภาพประกอบ <?= $get_r_id ?>:</label>
                                <div class="row">
                                    <?php
                                    // $get_r_id = $row['get_r_id'];
                                    $status_id = $row['status_id'];
                                    // $get_r_id = $_GET['id'];

                                    $sql_s = "SELECT * FROM repair_status 
                                    WHERE del_flg = '0' AND get_r_id = '$get_r_id'
                                    ORDER BY rs_date_time DESC LIMIT 1";
                                    $result_s = mysqli_query($conn, $sql_s);
                                    // $row_s = mysqli_fetch_array($result_s);

                                    // $sql_s = "SELECT * FROM repair_status 
                                    //             WHERE status_id = '$status_id' AND del_flg = '0' AND get_r_id = $get_r_id 
                                    //             ORDER BY rs_date_time DESC LIMIT 1";
                                    // $result_s = mysqli_query($conn, $sql_s);
                                    $row_s = mysqli_fetch_array($result_s);
                                    $rs_id = $row_s['rs_id'];

                                    $sql_pic = "SELECT * FROM repair_pic WHERE rs_id = '$rs_id' AND del_flg = 0 ";
                                    $result_pic = mysqli_query($conn, $sql_pic);


                                    // $sql_pic = "SELECT * FROM `repair_pic` WHERE get_r_id = '$get_r_id'";
                                    // $result_pic = mysqli_query($conn, $sql_pic);
                                    while ($row_pic = mysqli_fetch_array($result_pic)) {
                                        if ($row_pic[0] != NULL) { ?>
                                            <a href="#"><img src="../<?= $row_pic['rp_pic'] ?>" width="120px" class="picture_modal" alt="" onclick="openModal(this)"></a>
                                        <?php
                                        } else { ?> <h2>ไม่มีข้อมูล</h2> <?php
                                                                        }
                                                                    }

                                                                            ?>

                                    <div id="modal" class="modal">
                                        <span class="close" onclick="closeModal()">&times;</span>
                                        <img id="modal-image" src="" alt="Modal Photo">
                                    </div>

                                    <script src="script.js"></script>
                                    <script>
                                        function openModal(img) {
                                            var modal = document.getElementById("modal");
                                            var modalImg = document.getElementById("modal-image");
                                            modal.style.display = "block";
                                            modalImg.src = img.src;
                                            modal.classList.add("show");
                                        }

                                        function closeModal() {
                                            var modal = document.getElementById("modal");
                                            modal.style.display = "none";
                                        }
                                    </script>
                                </div>
                            </div>





                            <form action="action/add_respond.php" method="POST" enctype="multipart/form-data">
                                <div class="card-footer">
                                    <!-- Other form elements... -->
                                    <br>
                                    <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ <?= $rs_id ?></h1>
                                    <br>
                                    <div class="card-footer">

                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด :</label>
                                            <textarea class="form-control" name="rs_detail" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">สถานะ</label>&nbsp;&nbsp;
                                            <select class="form-select" name="status_id" aria-label="Default select example">
                                                <option selected>เลือกสถานะ</option>
                                                <?php
                                                $sql_s = "SELECT * FROM status_type WHERE del_flg = '0' ORDER BY status_name ASC";
                                                $result_s = mysqli_query($conn, $sql_s);
                                                while ($row_s = mysqli_fetch_array($result_s)) {
                                                ?><option value="<?= $row_s['status_id'] ?>"><?= $row_s['status_name'] ?></option><?php } ?>
                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <h6>อะไหล่</h6>
                                            <div id="cardContainer" style="display: none;">
                                                <table class="table" id="cardSection"></table>
                                            </div>
                                            <button type="button" class="btn btn-primary" onclick="showNextCard()">Show Card</button>
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
                    <div class="input-group">
                        <div class="col-6 px-0">
                            <input type="number" name="value_p${i}" id="${cardId}" value="${cardValues[cardId]}" class="form-control" onchange="calculateTotalPrice(${i})">
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
                    <select name="p_id${i}" class="custom-select" id="inputGroupSelect${i}" onchange="showSelectedOption(${i})">
                        <option selected>Choose...</option>
                        ${partsOptions}
                    </select>
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
                                        <br>
                                        <div class="mb-3">
                                            <!-- <input type="file" id="upload" hidden multiple>
                                            <h6>เพิ่มรูป</h6>
                                            <label for="upload" style="display: block; color: blue;">Choose file</label>
                                            <div id="image-container"></div> -->
                                            <div class="row file-input-container">
                                                <div class="col-4">
                                                    <label for="picture_1">Select a file:</label>
                                                    <input type="file" id="picture_1" name="picture_1">
                                                </div>
                                                <div class="col-4">
                                                    <label for="picture_2">Select a file:</label>
                                                    <input type="file" id="picture_2" name="picture_2">
                                                </div>
                                                <div class="col-4">
                                                    <label for="picture_3">Select a file:</label>
                                                    <input type="file" id="picture_3" name="picture_3">
                                                </div>
                                                <div class="col-4">
                                                    <label for="picture_4">Select a file:</label>
                                                    <input type="file" id="picture_4" name="picture_4">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <!-- <div class="mb-3 ">
                                            <label for="exampleFormControlInput1" class="form-label">รวมราคาอะไหร่</label>
                                            <input name="p_price_sum" type="text" class="form-control col-1" id="exampleFormControlInput1" required>
                                        </div> -->
                                        <div class="mb-3 ">
                                            <label for="exampleFormControlInput1" class="form-label">ค่าแรงช่าง</label>
                                            <input name="rate" type="text" class="form-control col-1" id="exampleFormControlInput1" required value="0">
                                        </div>
                                        <!-- <div class="mb-3 ">
                                            <label for="exampleFormControlInput1" class="form-label">ราคารวม</label>
                                            <input name="total" type="text" class="form-control col-1" id="exampleFormControlInput1" required>
                                            <input type="hidden" name="cardCount" id="cardCountInput" value="0">
                                            
                                        </div> -->
                                    </div>
                                    <div class="text-center pt-4">
                                    <input type="text" name="get_r_id" value="<?= $row['get_r_id'] ?>" hidden>
                                        <button type="submit" class="btn btn-success">ตอบกลับ</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            include('bar/admin_footer.php')
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

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

    <script>
        const input = document.querySelector('#upload');
        const container = document.querySelector('#image-container');

        input.addEventListener('change', () => {
            const files = input.files;
            if (files) {
                for (let i = 0; i < files.length; i++) {
                    const url = URL.createObjectURL(files[i]);
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('image-container');

                    const image = document.createElement('img');
                    image.classList.add('preview-image');
                    image.setAttribute('src', url);

                    const deleteBtn = document.createElement('button');
                    deleteBtn.classList.add('delete-button');
                    deleteBtn.innerHTML = '&times;';

                    deleteBtn.addEventListener('click', () => {
                        imageContainer.remove();
                    });

                    imageContainer.appendChild(image);
                    imageContainer.appendChild(deleteBtn);
                    container.appendChild(imageContainer);
                }
            }
        });
    </script>
</body>

</html>
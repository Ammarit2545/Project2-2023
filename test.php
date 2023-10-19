<?php
session_start();
include('database/condb.php');
$get_r_id = 151; // Start Value Required !!!!
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: sans-serif;
        }

        .h1-text {
            font-size: 2rem;
            /* Adjust the font size as needed */
        }

        .un-scroll {
            text-decoration: none;
        }

        .f-wh {
            color: white;
        }

        #bounce-item {
            /* box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); */
            /* Add a gray shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Add transition for transform and box-shadow */
        }

        #bounce-item:hover {
            transform: scale(1.1);
            /* Increase size on hover */
            /* box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); */
            /* Increase shadow size and intensity on hover */

        }

        /* Default font size */
        .auto-font {
            font-size: 16px;
        }


        /* Media query for smaller screens */
        @media screen and (max-width: 768px) {
            .auto-font {
                font-size: 14px;
            }
        }

        /* Media query for even smaller screens */
        @media screen and (max-width: 576px) {
            .auto-font {
                font-size: 12px;
            }
        }

        .auto-font-head {
            font-size: 1vw;
        }

        /* Media query for smaller screens */
        @media screen and (max-width: 1920px) {
            .auto-font-head {
                font-size: 1.2vw;
            }
        }

        /* Media query for smaller screens */
        @media screen and (max-width: 1645px) {
            .auto-font-head {
                font-size: 1.5vw;
            }
        }

        /* Media query for smaller screens */
        @media screen and (max-width: 768px) {
            .auto-font-head {
                font-size: 3vw;
            }
        }

        /* Media query for even smaller screens */
        @media screen and (max-width: 576px) {
            .auto-font-head {
                font-size: 4.5vw;
            }
        }


        .ln {
            display: inline;
        }

        .shadow {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .tooltip {
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

        .f-black-5 {
            color: black;
        }

        .f-gray-5 {
            color: gray;
        }

        .f-red-5 {
            color: red;
        }

        .f-yellow-5 {
            color: #92AD2D;
        }

        .f-green-5 {
            color: green;
        }

        .f-blue-5 {
            color: blue;
        }

        .f-white-1 {
            color: white;
        }


        .bg-gray-1 {
            background-color: #F5F5F5;
        }


        .bg-gray-2 {
            background-color: #F4F4F4;
        }

        .br-10 {
            border-radius: 10px;
        }

        #bounce-item:hover .tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-10px);
            animation: tooltipFadeIn 0.3s, tooltipBounce 0.6s;
        }

        a:hover .tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-10px);
            animation: tooltipFadeIn 0.3s, tooltipBounce 0.6s;
        }



        button:hover .tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-10px);
            animation: tooltipFadeIn 0.3s, tooltipBounce 0.6s;
        }


        span:hover .tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-10px);
            animation: tooltipFadeIn 0.3s, tooltipBounce 0.6s;
        }
    </style>
</head>

<body>
    <form action="action/test.php" method="POST">
        <div class="container mt-4">
            <div class="row">
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <?php
                    $sql_detail = "SELECT * FROM get_detail 
                    LEFT JOIN repair ON repair.r_id = get_detail.r_id
                    WHERE get_detail.del_flg = 0 AND get_detail.get_r_id = '$get_r_id'";
                    $result_detail = mysqli_query($conn, $sql_detail);
                    while ($row_detail = mysqli_fetch_array($result_detail)) {
                        $get_d_id = $row_detail['get_d_id'];
                    ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne<?= $get_d_id ?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne<?= $get_d_id ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne<?= $get_d_id ?>">
                                    <h3><?= $row_detail['r_brand'] . ' ' .  $row_detail['r_model'] . ' - Serial Number' . $row_detail['r_number_model']  ?></h3>
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne<?= $get_d_id ?>" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne<?= $get_d_id ?>">
                                <div class="accordion-body">
                                    <div class="row">
                                        <a class="btn btn-primary" onclick="addInputFields(this)" id="bounce-item">+
                                            <span class="tooltip">กดเพื่อเพิ่มอะไหล่</span>
                                        </a>
                                        <br>
                                    </div>
                                    <input type="hidden" name="get_d_id<?= $get_d_id ?>" value="<?= $get_d_id ?>">
                                    <div class="input-container">
                                        <div class="row mt-4">
                                            <!-- <div class="col-md-1">
                                                <img id="partImage<?= $get_d_id ?>" src="default_image.jpg" alt="Part Image">
                                            </div> -->
                                            <div class="col-md">
                                                <div class="input-group mb-3">
                                                    <input type="text" list="brow" name="p_id_<?= $get_d_id ?>[]" class="form-control" id="partInput<?= $get_d_id ?>" placeholder="กรุณาเลือกอะไหล่ที่ต้องการ" onchange="updatePartImage(<?= $get_d_id ?>)">
                                                    <datalist id="brow">
                                                        <?php
                                                        $sql_part = "SELECT * FROM parts WHERE del_flg = 0";
                                                        $result_part = mysqli_query($conn, $sql_part);
                                                        while ($row_part = mysqli_fetch_array($result_part)) {
                                                        ?>
                                                            <option value="<?= $row_part['p_id'] ?>" data-img="<?= $row_part['p_pic'] ?>"> <?= $row_part['p_name'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" type="number" name="value_p_<?= $get_d_id ?>[]" placeholder="กรุณากรอกจำนวนที่ต้องการ...">
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-danger" type="button" onclick="deleteRow(this)">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <script>
                            function updatePartImage(get_d_id) {
                                const partInput = document.getElementById('partInput' + get_d_id);
                                const partImage = document.getElementById('partImage' + get_d_id);
                                const selectedPartId = partInput.value;

                                if (selectedPartId) {
                                    // Log the selected value to the console
                                    console.log('Selected Part ID:', selectedPartId);

                                    // Use AJAX to fetch the image URL from the server
                                    const xhr = new XMLHttpRequest();
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                            const response = JSON.parse(xhr.responseText);
                                            if (response && response.image_url) {
                                                partImage.src = response.image_url;
                                            } else {
                                                partImage.src = 'parts/default-image.jpg';
                                            }
                                        }
                                    };

                                    xhr.open('GET', 'get_part_image.php?p_id=' + selectedPartId, true);
                                    xhr.send();
                                } else {
                                    partImage.src = 'parts/default-image.jpg';
                                }
                            }
                        </script> -->
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <script>
            function addInputFields(button) {
                // Clone the input fields container
                const accordionBody = button.closest('.accordion-body');
                const inputContainer = accordionBody.querySelector('.input-container').cloneNode(true);

                // Clear the input values in the new row
                const inputs = inputContainer.querySelectorAll('input');
                inputs.forEach(input => {
                    input.value = '';
                });

                // Append the new input container to the accordion body
                accordionBody.appendChild(inputContainer);
            }

            function deleteRow(button) {
                // Remove the parent input container when the delete button is clicked
                const inputContainer = button.closest('.input-container');
                inputContainer.remove();
            }
        </script>
        <center>
            <button type="submit" class="btn btn-success">Send</button>
        </center>
    </form>
</body>

</html>
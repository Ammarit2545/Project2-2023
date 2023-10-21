<form action="action/test.php" method="POST">
    <div class="container mt-4">
        <div class="row">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <?php
                $count_conf =0;
                $sql_detail = "SELECT * FROM get_detail 
                    LEFT JOIN repair ON repair.r_id = get_detail.r_id
                    WHERE get_detail.del_flg = 0 AND get_detail.get_r_id = '$get_r_id'";
                $result_detail = mysqli_query($conn, $sql_detail);
                while ($row_detail = mysqli_fetch_array($result_detail)) {
                    $get_d_id = $row_detail['get_d_id'];
                    $count_conf ++;
                ?>
                    <div class="accordion-item">
                        <style>

                        </style>
                        <h5 class="accordion-header" id="panelsStayOpen-headingOne<?= $get_d_id ?>">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne<?= $get_d_id ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne<?= $get_d_id ?>">
                                <div class="col-md-1">
                                    <input class="form-check-input center-checkbox" name="check_<?= $count_conf ?>" type="checkbox" id="checkbox_<?= $get_d_id ?>" value="option1" onclick="stopPropagation(event);">
                                    <label class="form-check-label" for="checkbox_<?= $get_d_id ?>"></label>
                                </div>
                                <div class="col-md">
                                    <h5 class="center-checkbox" style="margin-left: -9%;">
                                        <?= $row_detail['r_brand'] . ' ' .  $row_detail['r_model'] . ' - Serial Number' . $row_detail['r_number_model']  ?>
                                    </h5>
                                </div>
                            </button>

                            <script>
                                function stopPropagation(event) {
                                    event.stopPropagation();
                                }
                            </script>


                        </h5>

                        <div id="panelsStayOpen-collapseOne<?= $get_d_id ?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne<?= $get_d_id ?>">
                            <div class="accordion-body">
                                <div class="row">
                                    <p>กดเพื่อเพิ่มอะไหล่
                                    <span class="f-black-5">(หากไม่ต้องการใช้อะไหล่ ท่านไม่ต้องดำเนินการใดๆ) :   <a class="btn btn-primary" onclick="addInputFields(this)" id="bounce-item">เพิ่มอะไหล่
                                        <span class="tooltip">กดเพื่อเพิ่มอะไหล่</span>
                                    </a></span>
                                </p>
                                   
                                    <br>
                                </div>
                                <input type="hidden" name="get_d_id<?= $count_conf ?>" value="<?= $get_d_id ?>">
                                <div class="input-container">
                                    <div class="row mt-4">
                                        <!-- <div class="col-md-1">
                                                <img id="partImage<?= $get_d_id ?>" src="default_image.jpg" alt="Part Image">
                                            </div> -->
                                        <div class="col-md">
                                            <div class="input-group mb-3">
                                                <input type="text" list="brow" name="p_id_<?= $count_conf ?>[]" class="form-control" id="partInput<?= $get_d_id ?>" placeholder="กรุณาเลือกอะไหล่ที่ต้องการ" onchange="updatePartImage(<?= $get_d_id ?>)">
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
                                            <input class="form-control" type="number" name="value_p_<?= $count_conf ?>[]" placeholder="กรุณากรอกจำนวนที่ต้องการ...">
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
    <!-- <center>
        <button type="submit" class="btn btn-success">Send</button>
    </center> -->
</form>
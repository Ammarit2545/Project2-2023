


<!-- สถานะ "ส่งเรื่องแล้ว" -->
<?php if ($row['value_code'] == "submit") {
?>
    <!-- เปลี่ยนสถานะเป็น  -->
    <center>
        <a class="btn btn-success" href="action/add_submit_repair.php?id=<?= $get_r_id ?>" onclick="confirmChangeStatus_received(event)">รับเรื่องแล้ว</a>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmChangeStatus_received(event) {
            event.preventDefault(); // Prevent the default link action

            Swal.fire({
                title: "คุณต้องการเปลี่ยนสถานะเป็น 'รับเรื่องแล้ว' ใช่หรือไม่?",
                text: "การเปลี่ยนสถานะจะไม่สามารถย้อนกลับได้",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
            }).then(function(result) {
                if (result.isConfirmed) {
                    // Proceed with the link action
                    window.location.href = event.target.href;
                }
            });
        }
    </script>

    <!-- สถานะ "รับเรื่องแล้ว" -->
<?php
} ?>
<?php if ($row['value_code'] == "received") { ?>
    <center>
        <button class="btn btn-danger" onclick="showCancelValue()">ปฏิเสธการซ่อม</button>
        <button class="btn btn-secondary" onclick="showDetailValue()">รายละเอียด</button>
    </center>

    <div id="cancel_value_code" style="display: none;">
        <hr>
        <br>
        <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ </h1>
        <br>
        <div class="alert alert-secondary shadow">
            <form id="cancel_status_id" action="action/status/status_non_del_part.php" method="POST" enctype="multipart/form-data">
                <label for="cancelFormControlTextarea" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการ <p style="display:inline; color : red"> ปฏิเสธการซ่อม</p> :</label>
                <textarea class="form-control" name="rs_detail" id="cancelFormControlTextarea" rows="3" required placeholder="กรอกรายละเอียดในการปฏิเสธการซ่อม"></textarea>
                <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
                <input type="text" name="status_id" value="11" hidden>
                <br>
                <!-- <p style="color:red">*** โปรดกรอกรายละเอียดข้างต้นก่อนทำการเพิ่มรูปภาพ ***</p>
            <hr>
            <label for="cancelFormControlTextarea" class="form-label">เพิ่มรูปภาพหรือวิดีโอ *ไม่จำเป็น (สูงสุด 4 ไฟล์):</label>
            <a class="btn btn-primary" onclick="showInput()">เพิ่มรูปภาพหรือวิดีโอ</a>
            <br>
            <div id="inputContainer"></div> -->

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                <center>
                    <br>
                    <button class="btn btn-success" onclick="confirm_cen(event)">ยืนยัน</button>
                </center>
            </form>
            <script>
                var clickCount = 0;

                function showInput() {
                    var textarea = document.getElementById('cancelFormControlTextarea');
                    var textValue = textarea.value.trim();
                    if (textValue === '') {
                        return false; // Prevent form submission if there is no text input
                    }

                    clickCount++;

                    if (clickCount <= 4) {
                        var inputElement = document.createElement('div');
                        inputElement.classList.add('input-group', 'mb-3');

                        var fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.name = 'file' + clickCount;
                        fileInput.classList.add('form-control');
                        fileInput.addEventListener('change', function(event) {
                            showPreview(event.target);
                        });

                        var inputGroupText = document.createElement('span');
                        inputGroupText.classList.add('input-group-text');
                        inputGroupText.textContent = 'File ' + clickCount;

                        var deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.classList.add('btn', 'btn-danger');
                        deleteButton.textContent = 'Delete';
                        deleteButton.addEventListener('click', function() {
                            inputElement.remove();
                            removeFileInputValue(fileInput.name); // Remove corresponding value
                        });

                        var previewElement = document.createElement('div');
                        previewElement.classList.add('preview');
                        previewElement.style.marginTop = '10px';

                        inputElement.appendChild(inputGroupText);
                        inputElement.appendChild(fileInput);
                        inputElement.appendChild(deleteButton);

                        var inputContainer = document.getElementById('inputContainer');
                        inputContainer.appendChild(inputElement);
                        inputContainer.appendChild(previewElement);
                    }

                    return false; // Prevent form submission
                }

                function showPreview(input) {
                    var preview = input.parentNode.nextSibling; // Get the next sibling (preview element)
                    preview.innerHTML = '';

                    if (input.files && input.files[0]) {
                        var file = input.files[0];
                        var fileType = file.type;
                        var validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        var validVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];

                        if (validImageTypes.includes(fileType)) {
                            var img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            img.style.maxWidth = '200px';
                            preview.appendChild(img);
                        } else if (validVideoTypes.includes(fileType)) {
                            var video = document.createElement('video');
                            video.src = URL.createObjectURL(file);
                            video.style.maxWidth = '200px';
                            video.autoplay = true;
                            video.loop = true;
                            video.muted = true;
                            preview.appendChild(video);
                        }
                    }
                }

                function removeFileInputValue(inputName) {
                    var fileInput = document.querySelector('input[name="' + inputName + '"]');
                    if (fileInput) {
                        fileInput.value = ''; // Clear the file input value
                    }
                }
            </script>
        </div>
    </div>

    <!-- ------------------------------------------------------------------ -->

    <div id="detail_value_code" style="display: none;">
        <hr>
        <br>
        <h1 class="m-0 font-weight-bold text-primary">รายละเอียด </h1>
        <br>
        <form id="detail_status_id" action="action/status/insert_new_part_non_del.php" method="POST" enctype="multipart/form-data">
            <div>
                <br>
                <!-- <label for="basic-url" class="form-label">กรุณาเลือกอุปกรณ์ที่ต้องการทำการซ่อม</label> -->
                <?php
                $count_conf = 0;
                $sql_get_c = "SELECT * FROM get_detail 
                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                            WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                $result_get_c = mysqli_query($conn, $sql_get_c);
                while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                    $count_conf++;
                ?>

                    <!-- <div class="alert alert-primary" role="alert">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="check_<?= $row_get_c['get_d_id'] ?>" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                            <label class="form-check-label" for="inlineCheckbox1"><?= $count_conf ?></label>
                        </div>
                        <?= $row_get_c['r_brand'] . " " . $row_get_c['r_model'] . " - Model : " . $row_get_c['r_number_model'] . " - Serial Number : " . $row_get_c['r_serial_number']  ?>
                    </div> -->
                    <div class="col-4">
                        <?php
                        $sql1 = "SELECT * FROM member WHERE del_flg = 0";
                        $result1 = mysqli_query($conn, $sql1);
                        $data = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                        ?>

                        <script>
                            var input = document.getElementById("myInput");
                            var modal_ed = document.getElementById("myModal");
                            var searchInput = document.getElementById("searchInput");
                            var myList = document.getElementById("myList");
                            var data = <?php echo json_encode($data); ?>;

                            function openModal() {
                                modal_ed.style.display = "block";
                                searchInput.value = "";
                                populateList(data);
                                searchInput.focus();
                            }

                            function closeModal() {
                                modal_ed.style.display = "none";
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
                <?php
                }
                $parts_ar = array();
                $sql_get_co = "SELECT parts.p_id,parts.p_brand, parts.p_model,parts_type.p_type_name FROM parts 
                                            LEFT JOIN parts_type ON parts.p_type_id = parts_type.p_type_id
                                            WHERE parts.del_flg = 0";

                $result_get_co = mysqli_query($conn, $sql_get_co);

                while ($row_get_co = mysqli_fetch_array($result_get_co)) {
                    $p_id = $row_get_co['p_id'];
                    $brand = $row_get_co['p_brand'];
                    $model = $row_get_co['p_model'];
                    $type = $row_get_co['p_type_name'];
                    $part_str = "$p_id  - $brand $model : type - $type";
                    $parts_ar[] = $part_str;
                }
                ?>

            </div>

            <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
            <input type="text" name="status_id" value="4" hidden>
            <input type="hidden" name="cardCount" id="cardCountInput" value="0">
            <div class="container alert alert-light bg-gray-2 shadow">
                <div class="alert alert-primary">
                    <h5 class="ln f-black-5">ขั้นตอนที่ 1 : </h5><p class="ln">กรอกค่าแรงและรายละเอียด</p>
                </div>

                <div class="container ">
                    <div class="row">
                        <div class="col-md">
                            <label for="basic-url" class="form-label">ค่าแรงช่าง *แยกกับราคาอะไหล่</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">ค่าแรงช่าง</span>
                                <input name="get_wages" type="number" value="<?= $row['get_wages'] ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณากรอกค่าแรงช่าง" required>
                                <span class="input-group-text">฿</span>
                            </div>
                        </div>

                        <?php
                        if ($row['get_deli'] == 1) { ?>
                            <div class="col-md">
                                <label for="basic-url" class="form-label">ค่าจัดส่ง *แยกกับราคาอะไหล่</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">ค่าจัดส่ง</span>
                                    <input name="get_add_price" type="number" value="<?= $row['get_add_price'] ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณากรอกค่าส่งอุปกรณ์" required>
                                    <span class="input-group-text">฿</span>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="col-md-4">
                            <label for="basic-url" class="form-label">ระยะเวลาซ่อม</label>
                            <div class="input-group mb-3">

                                <input name="get_date_conf" type="number" value="<?= $row['get_date_conf'] ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณากรอกระยะเวลาซ่อม" required>
                                <span class="input-group-text">วัน</span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <label for="DetailFormControlTextarea" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการส่ง <p style="display:inline; color : gray"> รายละเอียด</p> :</label>
                    <textarea class="form-control" name="rs_detail" id="DetailFormControlTextarea" rows="3" required placeholder="กรอกรายละเอียดในการรายละเอียดการซ่อม">อะไหล่ที่ต้องใช้มีดังนี้</textarea>

                </div>

                <br>
                <hr>
                <br>
                <div class="alert alert-primary">
                    <!-- <h5>ขั้นตอนที่ 2 : จัดการอะไหล่และเลือกอุปกรณ์</h5> -->
                    <h5 class="ln f-black-5">ขั้นตอนที่ 2 : </h5><p class="ln">จัดการอะไหล่และเลือกอุปกรณ์</p>
                </div>

                <div class="mb-3">
                    <h6>จัดการอะไหล่และเลือกอุปกรณ์</h6>
                    <div id="cardContainer" style="display: none;">
                        <table class="table" id="cardSection"></table>
                    </div>
                    <?php include('func_parts/func_parts.php'); ?>

                    <br>
                    <hr>
                    <br>
                    <div class="alert alert-primary">
                        <!-- <h5>ขั้นตอนที่ 3 : ใส่รูปภาพประกอบ <span class="f-red-5">*ไม่จำเป็น</span></h5> -->
                        <h5 class="ln f-black-5">ขั้นตอนที่ 3 : </h5><p class="ln">ใส่รูปภาพประกอบ <span class="f-red-5">*ไม่จำเป็น</span></p>
                    </div>

                    <p style="color:red">*** โปรดกรอกรายละเอียดข้างต้นก่อนทำการเพิ่มรูปภาพ ***</p>
                    <hr>
                    <label for="DetailFormControlTextarea" class="form-label">เพิ่มรูปภาพหรือวิดีโอ *ไม่จำเป็น (สูงสุด 4 ไฟล์) : </label>
                    <a class="btn btn-primary" onclick="showInputDetail()">เพิ่มรูปภาพหรือวิดีโอ</a>
                    <br><br>
                    <div id="inputContainerDetail"></div>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                    <script>
                        var clickCount = 0;

                        function showInputDetail() {
                            var textarea = document.getElementById('DetailFormControlTextarea');
                            var textValue = textarea.value.trim();
                            if (textValue === '') {
                                return false; // Prevent form submission if there is no text input
                            }

                            clickCount++;

                            if (clickCount <= 4) {
                                var inputElement = document.createElement('div');
                                inputElement.classList.add('input-group', 'mb-3');

                                var fileInput = document.createElement('input');
                                fileInput.type = 'file';
                                fileInput.name = 'file' + clickCount;
                                fileInput.classList.add('form-control');
                                fileInput.addEventListener('change', function(event) {
                                    showPreviewDetail(event.target);
                                });

                                var inputGroupText = document.createElement('span');
                                inputGroupText.classList.add('input-group-text');
                                inputGroupText.textContent = 'File ' + clickCount;

                                var deleteButton = document.createElement('button');
                                deleteButton.type = 'button';
                                deleteButton.classList.add('btn', 'btn-danger');
                                deleteButton.textContent = 'Delete';
                                deleteButton.addEventListener('click', function() {
                                    inputElement.remove();
                                    removeFileInputValue(fileInput.name); // Remove corresponding value
                                });

                                var previewElement = document.createElement('div');
                                previewElement.classList.add('preview');
                                previewElement.style.marginTop = '10px';

                                inputElement.appendChild(inputGroupText);
                                inputElement.appendChild(fileInput);
                                inputElement.appendChild(deleteButton);

                                var inputContainer = document.getElementById('inputContainerDetail');
                                inputContainer.appendChild(inputElement);
                                inputContainer.appendChild(previewElement);
                            }

                            return false; // Prevent form submission
                        }

                        function showPreviewDetail(input) {
                            var preview = input.parentNode.nextSibling; // Get the next sibling (preview element)
                            preview.innerHTML = '';

                            if (input.files && input.files[0]) {
                                var file = input.files[0];
                                var fileType = file.type;
                                var validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                                var validVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];

                                if (validImageTypes.includes(fileType)) {
                                    var img = document.createElement('img');
                                    img.src = URL.createObjectURL(file);
                                    img.style.maxWidth = '200px';
                                    preview.appendChild(img);
                                } else if (validVideoTypes.includes(fileType)) {
                                    var video = document.createElement('video');
                                    video.src = URL.createObjectURL(file);
                                    video.style.maxWidth = '200px';
                                    video.autoplay = true;
                                    video.loop = true;
                                    video.muted = true;
                                    preview.appendChild(video);
                                }
                            }
                        }

                        function removeFileInputValue(inputName) {
                            var fileInput = document.querySelector('input[name="' + inputName + '"]');
                            if (fileInput) {
                                fileInput.value = ''; // Clear the file input value
                            }
                        }

                        function confirm_cen(event) {
                            event.preventDefault(); // Prevent the form from being submitted

                            Swal.fire({
                                title: 'คุณแน่ใจหรือไม่?',
                                text: 'คุณต้องการส่งข้อมูลนี้หรือไม่',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ใช่',
                                cancelButtonText: 'ไม่'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // User confirmed, submit the form
                                    document.getElementById('cancel_status_id').submit();
                                }
                            });
                        }

                        function confirm_detail(event) {
                            event.preventDefault(); // Prevent the form from being submitted

                            Swal.fire({
                                title: 'คุณแน่ใจหรือไม่?',
                                text: 'คุณต้องการส่งข้อมูลนี้หรือไม่',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ใช่',
                                cancelButtonText: 'ไม่'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // User confirmed, submit the form
                                    document.getElementById('detail_status_id').submit();
                                }
                            });
                        }
                    </script>
                    <!-- <input type="file" name="p_picture[]" id="p_pic" multiple accept="image/*,video/*" max="4">
                                        <h6>เพิ่มไฟล์</h6>
                                        <label for="p_pic" style="display: block; color: blue;">Choose file</label>
                                        <div id="media-container"></div> -->

                    <script>
                        function displayMedia(input) {
                            var container = document.getElementById("media-container");
                            container.innerHTML = ""; // Clear the container

                            // Loop through each selected file
                            for (var i = 0; i < input.files.length; i++) {
                                var file = input.files[i];

                                // Create a new media element for the file
                                var media;
                                if (file.type.startsWith("image/")) {
                                    media = document.createElement("img");
                                } else if (file.type.startsWith("video/")) {
                                    media = document.createElement("video");
                                    media.controls = true; // Add video controls
                                } else {
                                    continue; // Skip unsupported file types
                                }

                                media.style.maxWidth = "100%";
                                media.style.maxHeight = "200px";

                                // Use FileReader to read the contents of the file as a data URL
                                var reader = new FileReader();
                                reader.onload = function(event) {
                                    // Set the src attribute of the media element to the data URL
                                    media.src = event.target.result;
                                };
                                reader.readAsDataURL(file);

                                // Append the media element to the container
                                container.appendChild(media);
                            }
                        }

                        // Add an event listener to the file input to trigger the displayMedia function
                        var fileInput = document.getElementById("p_pic");
                        fileInput.addEventListener("change", function() {
                            displayMedia(this);
                        });
                    </script>


                    <center>
                        <hr>
                        <center>
                            <p class="f-black-5">--- ตรวจสอบข้อมูลก่อนการยืนยัน ---</p>
                        </center>
                        <button class="btn btn-danger" type="reset">ล้างแบบฟอร์ม</button>
                        <button class="btn btn-success" onclick="confirm_detail(event)">ยืนยัน</button>
                    </center>
        </form>
    </div>
    </div>
    </div>


    <script>
        function showCancelValue() {
            document.getElementById('cancel_value_code').style.display = 'block';
            document.getElementById('detail_value_code').style.display = 'none';
        }

        function showDetailValue() {
            document.getElementById('cancel_value_code').style.display = 'none';
            document.getElementById('detail_value_code').style.display = 'block';
        }
    </script>

<?php
} ?>




<?php
if ($row['value_code'] == "succ" || $row['value_code'] == "cancel" || $row['value_code'] == "submit" || $row['value_code'] == "received" || $row['status_id'] == "11" || $row['status_id'] == "4" || $row1['status_id'] != "3" || $row1['status_id'] != '17' || $row1['status_id'] != '5') {
?>
    <form action="action/add_respond.php" method="POST" enctype="multipart/form-data" style="display:none">
    <?php
} else {
    ?>
        <form action="action/add_respond.php" method="POST" enctype="multipart/form-data" style="display:block">
        <?php
    }
        ?>
        <div class="card-footer">
            <!-- Other form elements... -->
            <br>
            <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ </h1>
            <br>
            <div class="card-footer">

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด :</label>
                    <textarea class="form-control" name="rs_detail" id="exampleFormControlTextarea1" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">สถานะ</label>&nbsp;&nbsp;
                    <select class="form-select" name="status_id" aria-label="Default select example" onchange="toggleEx1Textarea()">
                        <option selected>เลือกสถานะ</option>
                        <?php
                        $sql_s = "SELECT * FROM status_type WHERE del_flg = '0' ORDER BY status_name ASC";
                        $result_s = mysqli_query($conn, $sql_s);
                        while ($row_s = mysqli_fetch_array($result_s)) {
                        ?><option value="<?= $row_s['status_id'] ?>"><?= $row_s['status_name'] ?></option><?php
                                                                                                        }
                                                                                                            ?>
                    </select>
                </div>

                <div class="mb-3" id="ex1Textarea" style="display: none;">
                    <label for="exampleFormControlTextarea1" class="form-label">ex1 :</label>
                    <textarea class="form-control" name="ex1" id="exampleFormControlTextarea1" rows="3" required></textarea>
                </div>
                <div class="mb-3" id="ex2Textarea" style="display: none;">
                    <label for="exampleFormControlTextarea1" class="form-label">ex2 :</label>
                    <textarea class="form-control" name="ex2" id="exampleFormControlTextarea2" rows="3" required></textarea>
                </div>

                <script>
                    function toggleEx1Textarea() {
                        var statusSelect = document.querySelector('select[name="status_id"]');
                        var ex1Textarea = document.getElementById('ex1Textarea');
                        var ex2Textarea = document.getElementById('ex2Textarea');
                        var ex3Textarea = document.getElementById('ex3Textarea');
                        var ex4Textarea = document.getElementById('ex4Textarea');
                        if (statusSelect.value == 2) {
                            ex1Textarea.style.display = 'block';
                            document.getElementById('exampleFormControlTextarea1').required = true;
                            ex2Textarea.style.display = 'block';
                            document.getElementById('exampleFormControlTextarea2').required = true;
                        } else if (statusSelect.value == 3) {
                            ex1Textarea.style.display = 'block';
                            document.getElementById('exampleFormControlTextarea1').required = true;
                            ex2Textarea.style.display = 'none';
                            document.getElementById('exampleFormControlTextarea2').required = false;
                        } else {
                            ex1Textarea.style.display = 'none';
                            document.getElementById('exampleFormControlTextarea1').required = false;
                            ex2Textarea.style.display = 'none';
                            document.getElementById('exampleFormControlTextarea2').required = false;
                        }
                    }
                </script>

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

                // $sql_d = "SELECT * FROM get_detail 
                // LEFT JOIN repair ON repair.r_id = get_detail.r_id
                // WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0'";
                // $result_d = mysqli_query($conn, $sql_d);
                // $optionsHTMLDetail = "";
                // while ($row_d = mysqli_fetch_array($result_d)) {
                //     $optionsHTMLDetail .= '<option value="' . $row_get_c['get_d_id'] . '"r_brand="../' . $row_get_c['r_brand'] . '" r_model"' . $row_get_c['r_model'] . '"r_number_model="' . $row_get_c['r_number_model'] . '">' .  $row_get_c['r_serial_number'] . '</option>';
                // }
                ?>

                <script>
                    var partsOptions = '<?php echo $optionsHTML; ?>';
                    var partsData = <?php echo json_encode($partsData); ?>;

                    // var partsOptionsDetail = '<?php echo $optionsHTMLDetail; ?>';


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
                                                                    <select name="get_d_id_${i}" class="custom-select" id="inputGroupSelectGet${i}" onchange="showSelectedOptionGet_D(${i})">
                                                                        <option selected>กรุณาเลือกรายการซ่อมที่ต้องการ...</option>
                                                                        <?php
                                                                        $count_conf = 0;
                                                                        $sql_get_c = "SELECT * FROM get_detail 
                                                                                    LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                                                    WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                                                                        $result_get_c = mysqli_query($conn, $sql_get_c);
                                                                        while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                                                                            $count_conf++;
                                                                        ?>
                                                                             <option value="<?= $row_get_c['get_d_id'] ?>"> <?= $row_get_c['r_brand'] . " " . $row_get_c['r_model'] . " - Model : " . $row_get_c['r_number_model'] . " - Serial Number : " . $row_get_c['r_serial_number']  ?></option>
                                                                            <?php
                                                                        }
                                                                            ?>
                                                                    </select>
                                                                </td>
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

                    function showSelectedOptionGet_D(cardIndex) {
                        var selectElement = document.getElementById(`inputGroupSelectGet${cardIndex}`);
                        var selectedOption = selectElement.options[selectElement.selectedIndex];
                        // var cardImg = document.getElementById(`cardImg${cardIndex}`);
                        // var cardTitle = document.getElementById(`cardTitle${cardIndex}`);
                        // var cardPrice = document.getElementById(`cardPrice${cardIndex}`);

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
                    <?php
                    if ($row['get_wages'] > 0) {
                    ?>
                        <input name="get_wages" type="text" class="form-control col-1" id="exampleFormControlInput1" required value="<?= $row['get_wages'] ?>" placeholder="กรุณากรอกค่าแรงช่าง">
                    <?php
                    } else {
                    ?>
                        <input name="get_wages" type="text" class="form-control col-1" id="exampleFormControlInput1" required placeholder="กรุณากรอกค่าแรงช่าง">
                    <?php
                    }
                    ?>

                </div>
                <!-- <div class="mb-3 ">
                                            <label for="exampleFormControlInput1" class="form-label">ราคารวม</label>
                                            <input name="total" type="text" class="form-control col-1" id="exampleFormControlInput1" required>
                                            
                                            
                                        </div> -->
                <input type="hidden" name="cardCount" id="cardCountInput" value="0">
            </div>
            <div class="text-center pt-4">
                <input type="text" name="get_r_id" value="<?= $row['get_r_id'] ?>" hidden>
                <button type="submit" class="btn btn-success">ตอบกลับ</button>
            </div>
        </div>
        </form>
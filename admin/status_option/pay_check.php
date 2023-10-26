<center>
     <!-- 11,26,9 -->
    <!-- <?php
    $sql = "SELECT * FROM status_type WHERE status_id = '11'";
    $result = mysqli_query($conn, $sql);
    $row_q = mysqli_fetch_array($result);
    ?>
    <button class="btn btn-danger" style="background-color:<?= $row_q['status_color'] ?>; border : <?= $row_q['status_color'] ?>" onclick="showCancelValue()"><?= $row_q['status_name'] ?></button> -->

    <?php
    $sql = "SELECT * FROM status_type WHERE status_id = '26'";
    $result = mysqli_query($conn, $sql);
    $row_ag = mysqli_fetch_array($result);
    ?>
    <button class="btn btn-success" style="background-color:<?= $row_ag['status_color'] ?>; border : <?= $row_ag['status_color'] ?>" onclick="show_pay_again('<?php echo $row_ag['id']; ?>')">
        <?= $row_ag['status_name'] ?>
    </button>

    <?php
    $sql = "SELECT * FROM status_type WHERE status_id = '9'";
    $result = mysqli_query($conn, $sql);
    $row_conf = mysqli_fetch_array($result);
    ?>
    <button class="btn btn-success" style="background-color:<?= $row_conf['status_color'] ?>; border : <?= $row_conf['status_color'] ?>" onclick="show_conf_status('<?php echo $row_conf['id']; ?>')">
        <?= $row_conf['status_name'] ?>
    </button>
</center>

<div id="cancel_value_code" style="display: none;">
    <hr>
    <br>
    <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ </h1>
    <br>
    <form id="cancel_status_id_conf" action="action/status/status_refuse_return.php" method="POST" enctype="multipart/form-data">
        <label for="cancelFormControlTextareaConf" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการ <p style="display:inline; color : <?= $row_q['status_color'] ?>"> <?= $row_q['status_name'] ?></p> :</label>
        <textarea class="form-control auto-expand" name="rs_detail" id="cancelFormControlTextareaConf" rows="3" required placeholder="กรอกรายละเอียดในการยกเลิกคำส่งซ่อม">เนื่องจากไม่สามารถจัดสรรหาอะไหล่ที่ท่านต้องการได้ ทางเราต้องขออภัยเป็นอย่างยิ่ง</textarea>
        <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
        <input type="text" name="status_id" value="<?= $row_q['status_id'] ?>" hidden>
        <br>
        <p style="color:red">*** โปรดกรอกรายละเอียดข้างต้นก่อนทำการเพิ่มรูปภาพ ***</p>
        <hr>
        <label for="cancelFormControlTextareaConf" class="form-label">เพิ่มรูปภาพหรือวิดีโอ *ไม่จำเป็น (สูงสุด 4 ไฟล์):</label>
        <a class="btn btn-primary" onclick="showInput_conf()">เพิ่มรูปภาพหรือวิดีโอ</a>
        <br>
        <div id="inputContainer"></div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            var clickCount = 0;

            function showInput_conf() {
                var textarea = document.getElementById('cancelFormControlTextareaConf');
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
                        showPreview_conF(event.target);
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

            function showPreview_conF(input) {
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

            function confirm_cen_conf(event) {
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
                        document.getElementById('cancel_status_id_conf').submit();
                    }
                });
            }
        </script>
        <center>
            <br>
            <button class="btn btn-success" onclick="confirm_cen_conf(event)">ยืนยัน</button>
        </center>
    </form>
</div>

<!-- ------------------------------------------------------------------ -->
<div id="status_doing" style="display: none;">
    <hr>
    <br>
    <h1 class="m-0 font-weight-bold text-success"> <?= $row_conf['status_name'] ?> </h1>
    <br>
    <form id="cancel_status_id_conf_get" action="action/status/status_non_del_part.php" method="POST" enctype="multipart/form-data">
        <label for="cancelFormControlTextareaConf" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการ <p style="display:inline; color : <?= $row_conf['status_color'] ?>"> <?= $row_conf['status_name'] ?></p> :</label>
        <textarea class="form-control auto-expand" name="rs_detail" id="cancelFormControlTextareaConf" rows="3" required placeholder="กรอกรายละเอียดในการยกเลิกคำส่งซ่อม">การตรวจเช็คอุปกรณ์เสร็จสิ้น รอการชำระเงิน</textarea>
        <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
        <input type="text" name="status_id" value="<?= $row_conf['status_id'] ?>" hidden>
        <br>
        
        <br>
        <p style="color:red">*** โปรดกรอกรายละเอียดข้างต้นก่อนทำการเพิ่มรูปภาพ ***</p>
        <!-- <br>
        <label for="basic-url" class="form-label">ราคาค่าส่ง</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
        </div> -->
        <hr>
        <label for="cancelFormControlTextarea_get" class="form-label">เพิ่มรูปภาพหรือวิดีโอ *ไม่จำเป็น (สูงสุด 4 ไฟล์):</label>
        <a class="btn btn-primary" onclick="showInput_conf_get()">เพิ่มรูปภาพหรือวิดีโอ</a>
        <br>
        <div id="inputContainer_get"></div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            var clickCount_get = 0;

            function showInput_conf_get() {
                var textarea_get = document.getElementById('cancelFormControlTextareaConf');
                var textValue_get = textarea_get.value.trim();
                if (textValue_get === '') {
                    return false; // Prevent form submission if there is no text input
                }

                clickCount_get++;

                if (clickCount_get <= 4) {
                    var inputElement_get = document.createElement('div');
                    inputElement_get.classList.add('input-group', 'mb-3');

                    var fileInput_get = document.createElement('input');
                    fileInput_get.type = 'file';
                    fileInput_get.name = 'file' + clickCount_get;
                    fileInput_get.classList.add('form-control');
                    fileInput_get.addEventListener('change', function(event) {
                        showPreview_conF_get(event.target);
                    });

                    var inputGroupText_get = document.createElement('span');
                    inputGroupText_get.classList.add('input-group-text');
                    inputGroupText_get.textContent = 'File ' + clickCount_get;

                    var deleteButton_get = document.createElement('button');
                    deleteButton_get.type = 'button';
                    deleteButton_get.classList.add('btn', 'btn-danger');
                    deleteButton_get.textContent = 'Delete';
                    deleteButton_get.addEventListener('click', function() {
                        inputElement_get.remove();
                        removeFileInputValue_get(fileInput_get.name); // Remove corresponding value
                    });

                    var previewElement_get = document.createElement('div');
                    previewElement_get.classList.add('preview');
                    previewElement_get.style.marginTop = '10px';

                    inputElement_get.appendChild(inputGroupText_get);
                    inputElement_get.appendChild(fileInput_get);
                    inputElement_get.appendChild(deleteButton_get);

                    var inputContainer_get = document.getElementById('inputContainer_get');
                    inputContainer_get.appendChild(inputElement_get);
                    inputContainer_get.appendChild(previewElement_get);
                }

                return false; // Prevent form submission
            }

            function showPreview_conF_get(input) {
                var preview_get = input.parentNode.nextSibling; // Get the next sibling (preview element)
                preview_get.innerHTML = '';

                if (input.files && input.files[0]) {
                    var file_get = input.files[0];
                    var fileType_get = file_get.type;
                    var validImageTypes_get = ['image/jpeg', 'image/png', 'image/gif'];
                    var validVideoTypes_get = ['video/mp4', 'video/webm', 'video/ogg'];

                    if (validImageTypes_get.includes(fileType_get)) {
                        var img_get = document.createElement('img');
                        img_get.src = URL.createObjectURL(file_get);
                        img_get.style.maxWidth = '200px';
                        preview_get.appendChild(img_get);
                    } else if (validVideoTypes_get.includes(fileType_get)) {
                        var video_get = document.createElement('video');
                        video_get.src = URL.createObjectURL(file_get);
                        video_get.style.maxWidth = '200px';
                        video_get.autoplay = true;
                        video_get.loop = true;
                        video_get.muted = true;
                        preview_get.appendChild(video_get);
                    }
                }
            }

            function removeFileInputValue_get(inputName) {
                var fileInput_get = document.querySelector('input[name="' + inputName + '"]');
                if (fileInput_get) {
                    fileInput_get.value = ''; // Clear the file input value
                }
            }

            function confirm_cen_conf_get(event) {
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
                        document.getElementById('cancel_status_id_conf_get').submit();
                    }
                });
            }
        </script>
        <center>
            <br>
            <button class="btn btn-success" onclick="confirm_cen_conf_get(event)">ยืนยัน</button>
        </center>
    </form>
</div>

<!-- ------------------------------------------------------------------ -->
<div id="show_pay_again" style="display: none;">
    <hr>
    <br>
    <h1 class="m-0 font-weight-bold text-danger"> <?= $row_ag['status_name'] ?> </h1>
    <br>
    <form id="status_id_pay_ag" action="action/status/status_non_del_part.php" method="POST" enctype="multipart/form-data">
        <label for="cancelFormControlTextareaConf" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการ <p style="display:inline; color : <?= $row_ag['status_color'] ?>"> <?= $row_ag['status_name'] ?></p> :</label>
        <textarea class="form-control auto-expand" name="rs_detail" id="cancelFormControlTextareaConf" rows="3" required placeholder="กรอกรายละเอียดในการยกเลิกคำส่งซ่อม">กรุณาส่งหลักฐานการชำระเงินใหม่อีกครั้ง เนื่องจากพนักงานไม่สามารถตรวจสอบให้คุณได้</textarea>
        <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
        <input type="text" name="status_id" value="<?= $row_ag['status_id'] ?>" hidden>
        <br>
        
        <br>
        <p style="color:red">*** โปรดกรอกรายละเอียดข้างต้นก่อนทำการเพิ่มรูปภาพ ***</p>
        <!-- <br>
        <label for="basic-url" class="form-label">ราคาค่าส่ง</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
        </div> -->
        <hr>
        <label for="cancelFormControlTextarea_get" class="form-label">เพิ่มรูปภาพหรือวิดีโอ *ไม่จำเป็น (สูงสุด 4 ไฟล์):</label>
        <a class="btn btn-primary" onclick="showInput_conf_get()">เพิ่มรูปภาพหรือวิดีโอ</a>
        <br>
        <div id="inputContainer_get"></div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            var clickCount_get = 0;

            function showInput_conf_get() {
                var textarea_get = document.getElementById('cancelFormControlTextareaConf');
                var textValue_get = textarea_get.value.trim();
                if (textValue_get === '') {
                    return false; // Prevent form submission if there is no text input
                }

                clickCount_get++;

                if (clickCount_get <= 4) {
                    var inputElement_get = document.createElement('div');
                    inputElement_get.classList.add('input-group', 'mb-3');

                    var fileInput_get = document.createElement('input');
                    fileInput_get.type = 'file';
                    fileInput_get.name = 'file' + clickCount_get;
                    fileInput_get.classList.add('form-control');
                    fileInput_get.addEventListener('change', function(event) {
                        showPreview_conF_get(event.target);
                    });

                    var inputGroupText_get = document.createElement('span');
                    inputGroupText_get.classList.add('input-group-text');
                    inputGroupText_get.textContent = 'File ' + clickCount_get;

                    var deleteButton_get = document.createElement('button');
                    deleteButton_get.type = 'button';
                    deleteButton_get.classList.add('btn', 'btn-danger');
                    deleteButton_get.textContent = 'Delete';
                    deleteButton_get.addEventListener('click', function() {
                        inputElement_get.remove();
                        removeFileInputValue_get(fileInput_get.name); // Remove corresponding value
                    });

                    var previewElement_get = document.createElement('div');
                    previewElement_get.classList.add('preview');
                    previewElement_get.style.marginTop = '10px';

                    inputElement_get.appendChild(inputGroupText_get);
                    inputElement_get.appendChild(fileInput_get);
                    inputElement_get.appendChild(deleteButton_get);

                    var inputContainer_get = document.getElementById('inputContainer_get');
                    inputContainer_get.appendChild(inputElement_get);
                    inputContainer_get.appendChild(previewElement_get);
                }

                return false; // Prevent form submission
            }

            function showPreview_conF_get(input) {
                var preview_get = input.parentNode.nextSibling; // Get the next sibling (preview element)
                preview_get.innerHTML = '';

                if (input.files && input.files[0]) {
                    var file_get = input.files[0];
                    var fileType_get = file_get.type;
                    var validImageTypes_get = ['image/jpeg', 'image/png', 'image/gif'];
                    var validVideoTypes_get = ['video/mp4', 'video/webm', 'video/ogg'];

                    if (validImageTypes_get.includes(fileType_get)) {
                        var img_get = document.createElement('img');
                        img_get.src = URL.createObjectURL(file_get);
                        img_get.style.maxWidth = '200px';
                        preview_get.appendChild(img_get);
                    } else if (validVideoTypes_get.includes(fileType_get)) {
                        var video_get = document.createElement('video');
                        video_get.src = URL.createObjectURL(file_get);
                        video_get.style.maxWidth = '200px';
                        video_get.autoplay = true;
                        video_get.loop = true;
                        video_get.muted = true;
                        preview_get.appendChild(video_get);
                    }
                }
            }

            function removeFileInputValue_get(inputName) {
                var fileInput_get = document.querySelector('input[name="' + inputName + '"]');
                if (fileInput_get) {
                    fileInput_get.value = ''; // Clear the file input value
                }
            }

            function conf_ag(event) {
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
                        document.getElementById('status_id_pay_ag').submit();
                    }
                });
            }
        </script>
        <center>
            <br>
            <button class="btn btn-success" onclick="conf_ag(event)">ยืนยัน</button>
        </center>
    </form>
</div>


<script>
    function showCancelValue() {
        document.getElementById('cancel_value_code').style.display = 'block';
        document.getElementById('status_doing').style.display = 'none';
        document.getElementById('show_pay_again').style.display = 'none';
    }

    function show_conf_status() {
        document.getElementById('cancel_value_code').style.display = 'none';
        document.getElementById('status_doing').style.display = 'block';
        document.getElementById('show_pay_again').style.display = 'none';
    }

    function show_pay_again() {
        document.getElementById('cancel_value_code').style.display = 'none';
        document.getElementById('status_doing').style.display = 'none';
        document.getElementById('show_pay_again').style.display = 'block';
    }
</script>
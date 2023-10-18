 <!-- search 11-17 status -->
 <center>
     <?php
        $id_get = $_GET['id'];
        $sql = "SELECT * FROM status_type WHERE status_id = '8'";
        $result = mysqli_query($conn, $sql);
        $row_conf = mysqli_fetch_array($result);
        ?>
     <button class="btn btn-light" onclick="showCancelValue()" style="background-color: <?= $row_conf['status_color'] ?>;color:white"><?= $row_conf['status_name'] ?></button>

     <?php
        $sql = "SELECT * FROM status_type WHERE status_id = '17'";
        $result = mysqli_query($conn, $sql);
        $row_offer = mysqli_fetch_array($result);
        ?>
     <button class="btn btn-warning" onclick="showofferValue()" style="background-color: <?= $row_offer['status_color'] ?>;"><?= $row_offer['status_name'] ?></button>


     <?php
        $sql = "SELECT * FROM status_type WHERE status_id = '6'";
        $result = mysqli_query($conn, $sql);
        $row_conf_do = mysqli_fetch_array($result);
        ?>
     <button class="btn btn-light" onclick="show_conf_status('<?php echo $row_conf_do['id']; ?>')" style="background-color: <?= $row_conf_do['status_color'] ?>;color:white"><?= $row_conf_do['status_name'] ?></button>
 </center>

 <script>
     function show_conf_status(id) {
         Swal.fire({
             title: 'Confirmation',
             text: 'คุณต้องการเปลี่ยนเป็นสถานะดำเนินการใช่หรือไม่?',
             icon: 'question',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes',
             cancelButtonText: 'No'
         }).then((result) => {
             if (result.isConfirmed) {
                 window.location.href = 'action/status/doing_status.php?id=' + <?= $row['get_r_id'] ?>;
             }
         });
     }
 </script>

 <div id="cancel_value_code" style="display: none;">
     <hr>
     <br>
     <h1 class="m-0 font-weight-bold text-primary"><?= $row_conf['status_name'] ?> </h1>
     <br>
     <form id="cancel_status_id_conf_get" action="action/status/add_pay_address.php" method="POST" enctype="multipart/form-data">
         <label for="cancelFormControlTextareaConf" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการ <p style="display:inline; color : <?= $row_conf['status_color'] ?>"> <?= $row_conf['status_name'] ?></p> :</label>
         <textarea class="form-control" name="rs_detail" id="cancelFormControlTextareaConf" rows="3" required placeholder="กรอกรายละเอียดในการยกเลิกคำส่งซ่อม">ทางพนักงานได้ตรวจสอบที่อยู่ของคุณแล้วและได้ราคาค่าส่งรวมค่าบริการดังนี้</textarea>
         <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
         <input type="text" name="status_id" value="<?= $row_conf['status_id'] ?>" hidden>
         <br>
         <div class="row">
             <div class="col-md-6">
                 <label for="basic-url" class="form-label">ราคาค่าส่ง</label>
                 <div class="input-group mb-3">
                     <!-- <span class="input-group-text" id="basic-addon3"></span> -->
                     <input type="text" name="price_add" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณาระบุราคาค่าส่ง">
                 </div>
             </div>
             <div class="col-md-6">
                 <label for="basic-url" class="form-label">ค่าตรวจเช็คอุปกรณ์</label>
                 <div class="input-group mb-3">
                     <!-- <span class="input-group-text" id="basic-addon3"></span> -->
                     <input type="text" name="price_check" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณาระบุราคาค่าตรวจเช็คอุปกรณ์">
                 </div>
             </div>
         </div>
         <br>
         <p style="color:red">*** โปรดกรอกรายละเอียดข้างต้นก่อนทำการเพิ่มรูปภาพ ***</p>
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

 <div id="detail_value_code" style="display: none;">
     <hr>
     <br>
     <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ </h1>
     <br>
     <form id="offers_status_id" action="action/status/insert_new_part_non_del.php" method="POST" enctype="multipart/form-data">
         <div>
             <br>
             <label for="basic-url" class="form-label">กรุณาเลือกอุปกรณ์ที่ต้องการทำการซ่อม</label>
             <?php
                $count_conf = 0;
                $sql_get_c = "SELECT * FROM get_detail 
                                                        LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                        WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                $result_get_c = mysqli_query($conn, $sql_get_c);
                while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                    $count_conf++;
                ?>

                 <div class="alert alert-primary" role="alert">
                     <div class="form-check form-check-inline">
                         <input class="form-check-input" name="check_<?= $row_get_c['get_d_id'] ?>" type="checkbox" id="inlineCheckbox1" value="option1" <?php if ($row_get_c['get_d_conf'] == 0) { ?>checked<?php } ?>>
                         <label class="form-check-label" for="inlineCheckbox1"><?= $count_conf ?></label>
                     </div>
                     <?= $row_get_c['r_brand'] . " " . $row_get_c['r_model'] . " - Model : " . $row_get_c['r_number_model'] . " - Serial Number : " . $row_get_c['r_serial_number']  ?>
                 </div>
             <?php
                }

                ?>

         </div>

         <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
         <input type="text" name="status_id" value="17" hidden>
         <input type="hidden" name="cardCount" id="cardCountInput" value="0">
         <br>
         <div class="row">
             <div class="col-md">
                 <label for="basic-url" class="form-label">ค่าแรงช่าง *แยกกับราคาอะไหล่</label>
                 <div class="input-group mb-3">

                     <span class="input-group-text" id="basic-addon3">ค่าแรงช่าง</span>
                     <input name="get_wages" type="text" value="<?= $row['get_wages'] ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณากรอกค่าแรงช่าง" required>
                     <span class="input-group-text">฿</span>
                 </div>
             </div>

             <?php
                if ($row['get_deli'] == 1) { ?>
                 <div class="col-md">
                     <label for="basic-url" class="form-label">ค่าจัดส่ง *แยกกับราคาอะไหล่</label>
                     <div class="input-group mb-3">
                         <span class="input-group-text" id="basic-addon3">ค่าจัดส่ง</span>
                         <input name="get_add_price" type="text" value="<?= $row['get_add_price'] ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณากรอกค่าส่งอุปกรณ์" required>
                         <span class="input-group-text">฿</span>
                     </div>
                 </div>
             <?php
                }
                ?>
             <div class="col-md">
                 <label for="basic-url" class="form-label">ระยะเวลาซ่อม</label>
                 <div class="input-group mb-3">

                     <input name="get_date_conf" type="text" value="<?= $row['get_date_conf'] ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="กรุณากรอกระยะเวลาซ่อม" required>
                     <span class="input-group-text">วัน</span>
                 </div>
             </div>
         </div>
         <br>
         <label for="DetailFormControlTextarea" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการส่ง <p style="display:inline; color : gray"> รายละเอียด</p> :</label>
         <textarea class="form-control" name="rs_detail" id="DetailFormControlTextarea" rows="3" required placeholder="กรอกรายละเอียดในการรายละเอียดการซ่อม">อะไหล่ที่ต้องใช้มีดังนี้</textarea>



         <br>
         <div class="mb-3">
             <h6>อะไหล่</h6>
             <div id="cardContainer" style="display: none;">
                 <table class="table" id="cardSection"></table>
             </div>
             <button type="button" class="btn btn-primary" onclick="showNextCard()">เพิ่มอะไหล่</button>
         </div>
         <br>
         <p style="color:red">*** โปรดกรอกรายละเอียดข้างต้นก่อนทำการเพิ่มรูปภาพ ***</p>
         <hr>
         <label for="DetailFormControlTextarea" class="form-label">เพิ่มรูปภาพหรือวิดีโอ *ไม่จำเป็น (สูงสุด 4 ไฟล์):</label>
         <a class="btn btn-primary" onclick="showInputDetail()">เพิ่มรูปภาพหรือวิดีโอ</a>
         <br>
         <div id="inputContainerDetail"></div>

         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
         <script>
             var clickCount = 0;

             function showInputDetailConf() {
                 var textarea = document.getElementById('DetailFormControlTextareaConf');
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

             function confirm_offers(event) {
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
                         document.getElementById('offers_status_id').submit();
                     }
                 });
             }
         </script>
         <center>
             <br>
             <button class="btn btn-success" onclick="confirm_offers(event)">ยืนยัน</button>
         </center>
     </form>
 </div>

 <script>
     function showCancelValue() {
         document.getElementById('cancel_value_code').style.display = 'block';
         document.getElementById('detail_value_code').style.display = 'none';
     }

     function showofferValue() {
         document.getElementById('cancel_value_code').style.display = 'none';
         document.getElementById('detail_value_code').style.display = 'block';
     }
 </script>
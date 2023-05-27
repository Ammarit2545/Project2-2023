 <center>
     <button class="btn btn-danger" onclick="showCancelValue()">ปฏิเสธคำสั่งซ่อม</button>
     <button class="btn btn-warning" onclick="showofferValue()">ยื่นข้อเสนอ</button>
 </center>

 <div id="cancel_value_code" style="display: none;">
     <hr>
     <br>
     <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ </h1>
     <br>
     <form id="cancel_status_id_conf" action="action/status/add_conf_cancel.php" method="POST" enctype="multipart/form-data">
         <label for="cancelFormControlTextareaConf" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการ <p style="display:inline; color : red"> ปฏิเสธการซ่อม</p> :</label>
         <textarea class="form-control" name="rs_detail" id="cancelFormControlTextareaConf" rows="3" required placeholder="กรอกรายละเอียดในการยกเลิกคำส่งซ่อม"></textarea>
         <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
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

 <div id="detail_value_code" style="display: none;">
     <hr>
     <br>
     <h1 class="m-0 font-weight-bold text-primary">ตอบกลับ </h1>
     <br>
     <form id="offers_status_id" action="action/status/add_conf_offer.php" method="POST" enctype="multipart/form-data">
         <label for="DetailFormControlTextareaConf" class="form-label">กรุณาใส่รายละเอียดเพื่อทำการ <p style="display:inline; color : orange"> ยื่นข้อเสนอ</p> :</label>
         <textarea class="form-control" name="rs_detail" id="DetailFormControlTextareaConf" rows="3" required placeholder="กรอกรายละเอียดในการรายละเอียดการซ่อม"></textarea>
         <input type="text" name="get_r_id" value="<?= $get_r_id ?>" hidden>
         <input type="hidden" name="cardCount" id="cardCountInput" value="0">
         <br>
         <label for="basic-url" class="form-label">ค่าแรงช่าง *แยกกับราคาอะไหล่</label>
         <div class="input-group mb-3">
         <input type="text" name="status_id" value="<?= $row['rs_id'] ?>" hidden>
             <span class="input-group-text" id="basic-addon3">ค่าแรงช่าง</span>
             <input name="get_wages" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" value="<?= $row['get_wages'] ?>" required>
         </div>
         
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
         <label for="DetailFormControlTextareaConf" class="form-label">เพิ่มรูปภาพหรือวิดีโอ *ไม่จำเป็น (สูงสุด 4 ไฟล์):</label>
         <a class="btn btn-primary" onclick="showInputDetailConf()">เพิ่มรูปภาพหรือวิดีโอ</a>
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
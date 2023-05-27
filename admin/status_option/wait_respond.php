 <center>
     <button class="btn btn-danger" onclick="showCancelValue()">ปฏิเสธคำสั่งซ่อม</button>
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
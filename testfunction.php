<!DOCTYPE html>
<html>

<head>
    <title>Toggle Input Field</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3"></script>
    <script>
        function switchInput() {
            var inputIndex = parseInt(document.getElementById('inputIndex').value);
            var nextIndex = inputIndex + 1;
            if (nextIndex > 4) {
                nextIndex = 4;
                document.querySelector('button').style.display = 'none';
            }
            document.getElementById('inputIndex').value = nextIndex;

            // Hide all input fields
            var inputFields = document.getElementsByClassName('input-field');
            for (var i = 0; i < inputFields.length; i++) {
                inputFields[i].style.display = 'none';
            }

            // Show the input field corresponding to the current index
            var currentInputField = document.getElementById('input' + nextIndex);
            currentInputField.style.display = 'block';
            currentInputField.focus();

            // Trigger click event on the input field
            var clickEvent = new MouseEvent('click', {
                view: window,
                bubbles: true,
                cancelable: true
            });
            currentInputField.dispatchEvent(clickEvent);
        }

        window.onload = function() {
            switchInput(); // Automatically trigger the switchInput() function on page load
        };
    </script>
    <style>
        .input-field {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <label for="borderinput" class="form-label">เพิ่มรูปหรือวีดีโอที่ต้องการ (สูงสุด 4 ไฟล์) <p id="insert_bill" style="display: none; color:red">*** เพิ่มรูปใบเสร็จของท่านเพื่อเป็นการยืนยันอย่างน้อย 1 รูป ***</p></label>
        <div class="row grid">
            <?php for ($i = 1; $i <= 4; $i++) : ?>
                <div class="col-3 grid-item">
                    <input type="file" name="image<?php echo $i; ?>" onchange="previewImage('image-preview<?php echo $i; ?>', this)" id="input<?php echo $i; ?>" class="input-field" <?php if ($inputIndex == $i) echo 'style="display: block;"'; ?>>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <form method="POST" action="">
        <input type="hidden" id="inputIndex" value="<?php echo $inputIndex; ?>">
        <br><br>
        <button type="button" onclick="switchInput()">Switch Input</button>
        <input type="submit" name="switchButton" style="display: none;">
    </form>
</body>

</html>

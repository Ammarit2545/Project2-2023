<?php
$file = $_FILES['myFile'];
$file_name = $file['name'];
$file_tmp = $file['tmp_name'];
$file_size = $file['size'];
$file_error = $file['error'];

if ($file_error === UPLOAD_ERR_OK) {
    $destination = 'uploads/' . $file_name;
    move_uploaded_file($file_tmp, $destination);
  }
?>
<img src="uploads/myfile.jpg" alt="My File">
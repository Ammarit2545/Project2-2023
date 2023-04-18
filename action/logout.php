<?php
    session_start();
    session_destroy();
    echo "<script> alert(' ออกจากระบบเสร็จสิ้นแล้ว '); </script>";
    header("location:../home.php");

?>
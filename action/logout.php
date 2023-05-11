<?php
    session_start();
    include('../database/condb.php');
    if(!isset($_SESSION['role_id'])){
        $log_id = $_SESSION['log_id'];
        echo $log_id;
    
        $sql = "UPDATE `log_member` SET `date_out`= NOW() WHERE m_log_id = '$log_id'";
        if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
        } else {
        echo "Error updating record: " . mysqli_error($conn);
        }
    
        session_destroy();
        echo "<script> alert(' ออกจากระบบเสร็จสิ้นแล้ว '); </script>";
        header("location:../home.php");
    }elseif(isset($_SESSION['role_id'])){
        $log_id = $_SESSION['log_id'];
        echo $log_id;
    
        $sql = "UPDATE `log_employee` SET `date_out`= NOW() WHERE e_log_id = '$log_id'";
        if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
        } else {
        echo "Error updating record: " . mysqli_error($conn);
        }
    
        session_destroy();
        echo "<script> alert(' ออกจากระบบเสร็จสิ้นแล้ว '); </script>";
        header("location:../home.php");
    }

?>
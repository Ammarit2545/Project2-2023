

<?php 
    session_start();
    include '../database/condb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $tel = $_POST['tel'];
    //เข้ารหัส Password ด้วย Sha512
    $password = hash('sha512',$password);

    $sql = "SELECT * FROM member WHERE m_email = '$email' OR m_tel = '$tel'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    // echo($row);

    if($row > 0){
        $_SESSION['add_data_alert'] = 3;
            header("location:../home.php");

        // echo "<script> window.location='../home.php'; </script>";
//////////////////////////////////////////////////////

    //     $sql = "INSERT INTO member(m_email, m_password, m_fname, m_lname, m_tel) 
    //     VALUES ('$email','$password','$fname','$lname','$tel')";
    
    //     $result = mysqli_query($conn,$sql);
    
    //     if($result){
    //         echo "<script> alert(' บันทึกข้อมูลเรียบร้อยแล้ว '); </script>";
    //         echo "<script> window.location='home_user.php'; </script>";
    //     }else{
    //         echo "Error ". $sql . "<br>" . mysqli_error($conn);
    //         echo "<script> alert(' บันทึกข้อมูลไม่สำเร็จ '); </script>";
    //     }
    
    // mysqli_close($conn);


//////////////////////////////////////////////////////
    }else{
        echo $email . " -ไม่มี";

        $sql = "INSERT INTO member(m_email, m_password, m_fname, m_lname, m_tel) 
        VALUES ('$email','$password','$fname','$lname','$tel')";
    
        $result = mysqli_query($conn,$sql);
    
        if($result){
            $_SESSION['add_data_alert'] = 4;
            header("location:../home.php");
        }else{
            $_SESSION['add_data_alert'] = 3;
            header("location:../home.php");
        }
    
    mysqli_close($conn);

    }




?>
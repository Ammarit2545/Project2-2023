<?php
    session_start();
    include '../database/condb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hash the password using SHA-512 algorithm
    $password = hash('sha512', $password);

    $sql = "SELECT * FROM member WHERE m_email = '$email' AND m_password = '$password' AND del_flg = 0;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if ($row > 0) {

        // Store user information in the session
        $_SESSION["email"] = $row['m_email'];
        $_SESSION["id"] = $row['m_id'];
        $_SESSION["tel"] = $row['m_tel'];
        $_SESSION["fname"] = $row['m_fname'];
        $_SESSION["lname"] = $row['m_lname'];
        $_SESSION['Error'] = "";
        $_SESSION["address"] = $row['m_add'];
        $_SESSION["log_login"] = 0;
        echo "ture";

        $m_id = $row['m_id'];

        $sql = "INSERT INTO `log_member`( `m_id`, `date_in`) VALUES ('$m_id',NOW())";
        $result = mysqli_query($conn, $sql);

        $sql_log = "SELECT * FROM log_member WHERE m_id = '$m_id ' ORDER BY date_in DESC";
        $result_log = mysqli_query($conn, $sql_log);
        $row_log = mysqli_fetch_array($result_log);

        $_SESSION["log_id"] = $row_log['m_log_id'];

        // Redirect to the user's dashboard or home page
        $_SESSION['add_data_alert'] = 0;
        header("location: ../home.php");
        
        // exit(); // Terminate the current script
    } else {
        $sql = "SELECT * FROM employee WHERE e_email = '$email' AND e_password = '$password' AND del_flg = 0;";
        $result = mysqli_query($conn, $sql);
        $row_e = mysqli_fetch_array($result);
        if($row_e > 0){
             // Store user information in the session
        $_SESSION["email"] = $row_e ['e_email'];
        $_SESSION["id"] = $row_e['e_id'];
        $_SESSION["tel"] = $row_e['e_tel'];
        $_SESSION["fname"] = $row_e['e_fname'];
        $_SESSION["lname"] = $row_e['e_lname'];
        $_SESSION['Error'] = "";
        $_SESSION["address"] = $row_e['e_add'];
        $_SESSION["tel"] = $row_e['e_tel'];
        $_SESSION["role_id"] = $row_e['role_id'];
        echo "ture";

        $e_id = $row_e['e_id'];

        $sql = "INSERT INTO `log_employee`( `e_id`, `date_in`) VALUES ('$e_id',NOW())";
        $result = mysqli_query($conn, $sql);

        $sql_log = "SELECT * FROM log_employee WHERE e_id = '$e_id ' ORDER BY date_in DESC";
        $result_log = mysqli_query($conn, $sql_log);
        $row_log = mysqli_fetch_array($result_log);

        $_SESSION["log_id"] = $row_log['e_log_id'];

        // Redirect to the user's dashboard or home page
        $_SESSION['add_data_alert'] = 0;
        header("location: ../admin");
        // exit(); // Terminate the current script
        }else{
            $_SESSION["log_login"] = 2;
            $_SESSION["Error"] = "<p>Your username or password is invalid.</p>";
            $_SESSION['add_data_alert'] = 1;
        echo "false";
        header("location: ../index.php");
        }

        // exit(); // Terminate the current script
    }

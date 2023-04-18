<?php
    session_start();
    include '../database/condb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hash the password using SHA-512 algorithm
    $password = hash('sha512', $password);

    $sql = "SELECT * FROM member WHERE m_email = '$email' AND m_password = '$password';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    // echo $email."<br>".$password."<br>".$row."<br>";
    // print_r ($row);

    if ($row > 0) {

        // Store user information in the session
        $_SESSION["email"] = $row['m_email'];
        $_SESSION["id"] = $row['m_id'];
        $_SESSION["tel"] = $row['m_tel'];
        $_SESSION["fname"] = $row['m_fname'];
        $_SESSION["lname"] = $row['m_lname'];
        $_SESSION['Error'] = "";
        $_SESSION["address"] = $row['m_add'];
        echo "ture";

        // Redirect to the user's dashboard or home page
        header("location: ../home.php");
        // exit(); // Terminate the current script
    } else {
        $_SESSION["Error"] = "<p>Your username or password is invalid.</p>";
        echo "false";
        header("location: ../home.php");
        // exit(); // Terminate the current script
    }

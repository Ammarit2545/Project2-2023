<?php
session_start();
include('database/condb.php');
include('action/line_login.php');

$line = new LineLogin();
$get = $_GET;

$code = $get['code'];
$state = $get['state'];
$token = $line->token($code, $state);

if (property_exists($token, 'error')) {
    $_SESSION['add_data_alert'] = 1;
    header('location: index.php');
    exit; // Exit the script after redirect
}

if ($token->id_token) {
    $profile_line = $line->profileFormIdToken($token);
    $_SESSION['profile'] = $profile_line;

    $profile = $profile_line;

    // information Account 
    $name = $profile->name;
    $email = $profile->email;
    $picture = $profile->picture;
    $line_id = $profile->line_id;

    // Line Account Check Data in DB

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM member WHERE m_email = ? AND del_flg = 0;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row_count = mysqli_num_rows($result);

        if ($row_count > 0) {
            // Matching record found, do something here if needed
            // You can access the data using $row = mysqli_fetch_array($result);
            $row = mysqli_fetch_array($result);

            // Store user information in the session
            $_SESSION["email"] = $row['m_email'];
            $_SESSION["id"] = $row['m_id'];
            $_SESSION["tel"] = $row['m_tel'];
            $_SESSION["fname"] = $row['m_fname'];
            $_SESSION["lname"] = $row['m_lname'];
            $_SESSION['Error'] = "";
            $_SESSION["address"] = $row['m_add'];

            $_SESSION["log_login"] = 0;
            $m_id = $_SESSION["id"];
            // Assuming you have already established a database connection in the variable $conn.

            // // Check if the required session variables exist and have valid values.
            // if (!isset($_SESSION["m_line_id"]) || !isset($_SESSION["m_id"]) || !is_numeric($_SESSION["m_id"])) {
            //     // Redirect to an error page or handle the error appropriately.
            //     header('location: error.php');
            //     exit;
            // }

            if ($row['m_line_id'] == NULL) {
                $sql = "UPDATE member SET m_line_id = '$line_id' WHERE m_id = '$m_id'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $_SESSION['add_new_line_alert'] = 0;
                }
            }

            $m_id = $row['m_id'];

            $sql = "INSERT INTO `log_member`(`m_id`, `date_in`) VALUES (?, NOW())";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $m_id);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $_SESSION['add_data_alert'] = 0;
                $_SESSION['add_line_alert'] = 0;
                header('location: index.php');
                exit; // Exit the script after redirect
            }
        } else {
            // Full name received from the input
            $fullname = $name;

            // Split the full name into first name and last name
            $name_parts = explode(" ", $fullname);
            $fname = $name_parts[0];
            $lname = $name_parts[1];

            // No matching record found, do something else here
            $sql = "INSERT INTO member (`m_line_id`, `m_fname`, `m_lname`, `m_date_in`, `m_email`) VALUES (?, ?, ?, NOW(), ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $line_id, $fname, $lname, $email);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $sql = "SELECT * FROM member WHERE m_line_id = ? AND m_email = ?  AND del_flg = 0;";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $line_id, $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_array($result);

                // Store user information in the session
                $_SESSION["email"] = $row['m_email'];
                $_SESSION["id"] = $row['m_id'];
                $_SESSION["tel"] = $row['m_tel'];
                $_SESSION["fname"] = $row['m_fname'];
                $_SESSION["lname"] = $row['m_lname'];
                $_SESSION['Error'] = "";
                $_SESSION["address"] = $row['ml_add'];
                $_SESSION["log_login"] = 0;

                $m_id = $row['m_id'];

                $sql = "INSERT INTO `log_member`(`m_id`, `date_in`) VALUES (?, NOW())";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $m_id);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    $_SESSION['add_data_alert'] = 0;
                    header('location: index.php');
                    exit; // Exit the script after redirect
                }
            }
        }
    } else {
        // Error occurred during the query, handle the error appropriately
        // For example: echo mysqli_error($conn);
        $_SESSION['add_data_alert'] = 1;
        header('location: index.php');
        exit; // Exit the script after redirect
    }
}

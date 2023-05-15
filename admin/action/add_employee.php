<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$e_email = $_POST['e_email'];
$e_password = $_POST['e_password'];
$e_fname = $_POST['e_fname'];
$e_lname = $_POST['e_lname'];
$e_tel = $_POST['e_tel'];
$e_salary = $_POST['e_salary'];
$role_id = $_POST['role_id'];
$e_add = $_POST['e_add'];
$new_role_name = $_POST['new_role_name'];

$password = hash('sha512', $password);

$sql_p = "SELECT * FROM employee WHERE e_email = '$e_email' AND del_flg = '0'";
$result = mysqli_query($conn, $sql_p);
$row = mysqli_fetch_array($result);

if ($row['e_id'] > 0) {
    header('Location:../add_employee.php');
} elseif ($role_id == -1) {

    $sql_p = "SELECT * FROM role WHERE role_name = '$new_role_name'";
    $result = mysqli_query($conn, $sql_p);
    $row = mysqli_fetch_array($result);

    if (!isset($row[0])) {
        $sql_p = "INSERT INTO role (role_name) 
        VALUES ('$new_role_name')";
    } else {
        $role_id_c = $row['role_id'];
    }

    $result = mysqli_query($conn, $sql_p);

    if ($result) {

        $sql_p = "INSERT INTO employee (e_email, e_password, e_fname, e_lname, e_tel, e_salary, role_id, e_add, e_date_in) 
                VALUES ('$e_email', '$password', '$e_fname', '$e_lname', '$e_tel', '$e_salary', '$role_id_c', '$e_add', NOW())";
        $result = mysqli_query($conn, $sql_p);

        header('Location:../employee_listview.php');
    }
} else {
    $sql_p = "INSERT INTO employee (e_email, e_password, e_fname, e_lname, e_tel, e_salary, role_id, e_add, e_date_in) 
    VALUES ('$e_email', '$password', '$e_fname', '$e_lname', '$e_tel', '$e_salary', '$role_id', '$e_add', NOW())";
    $result = mysqli_query($conn, $sql_p);


    if ($result) {
        header('Location:../employee_listview.php');
    }
}

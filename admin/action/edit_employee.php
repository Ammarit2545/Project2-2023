<?php
session_start();
include('../../database/condb.php');
$id_e = $_GET['id'];

foreach ($_POST as $key => $value) {
    echo $key . ": " . $value . "<br>";
}

$address_json;

if (isset($_POST['Ref_prov_id']) && isset($_POST['Ref_dist_id']) && isset($_POST['Ref_subdist_id']) && isset($_POST['zip_code']) && isset($_POST['description'])) {

    $address = array(
        "province" => $_POST['Ref_prov_id'],
        "district" => $_POST['Ref_dist_id'],
        "sub_district" => $_POST['Ref_subdist_id'],
        "zip_code" => $_POST['zip_code'],
        "description" => $_POST['description']
    );

    $address_json = json_encode($address, JSON_UNESCAPED_UNICODE);

    $e_fname = $_POST['e_fname'];
    $e_lname = $_POST['e_lname'];

    $e_tel = $_POST['e_tel'];
    $e_add = $_POST['e_add'];
    $e_salary = $_POST['e_salary'];

    $sql = "UPDATE employee 
    SET e_fname = '$e_fname', e_lname = '$e_lname', e_tel = '$e_tel', e_salary = '$e_salary', e_date_update = NOW()";

    if (isset($_POST['role_id'])) {
        $sql .= ", role_id = '$role_id'";
    }
    if (
        isset($_POST['zip_code']) && $_POST['zip_code'] !== null &&
        isset($_POST['description']) && $_POST['description'] !== null &&
        isset($_POST['Ref_prov_id']) && $_POST['Ref_prov_id'] !== null &&
        isset($_POST['Ref_dist_id']) && $_POST['Ref_dist_id'] !== null &&
        isset($_POST['Ref_subdist_id']) && $_POST['Ref_subdist_id'] !== null
    ) {
        $sql .= ", e_add = '$address_json'";
    }



    $sql .= " WHERE e_id = '$id_e'";

    $result = mysqli_query($conn, $sql);
} else {

    $e_fname = $_POST['e_fname'];
    $e_lname = $_POST['e_lname'];
    $role_id = $_POST['role_id'];
    $e_tel = $_POST['e_tel'];
    $e_add = $_POST['e_add'];
    $e_salary = $_POST['e_salary'];

    $sql = "UPDATE employee 
    SET e_fname = '$e_fname', e_lname = '$e_lname', e_tel = '$e_tel', e_salary = '$e_salary', e_date_update = NOW()";
    if (isset($_POST['role_id'])) {
        $sql .= ", role_id = '$role_id'";
    }
    $sql .= " WHERE e_id = '$id_e'";

    $result = mysqli_query($conn, $sql);
}

if ($result) {
    echo "<script>alert('Update success');</script>";
    $_SESSION['edit_employee'] = 1;
    header('Location:../employee_listview.php');
}else{
    echo "<script>alert('Update success');</script>";
    $_SESSION['edit_employee'] = 0;
    header('Location:../employee_listview.php');
}

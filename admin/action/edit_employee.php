<?php
include('../../database/condb.php');
$id_e = $_GET['id'];

foreach ($_POST as $key => $value) {
    echo $key . ": " . $value . "<br>";
}

$address_json;

if (isset($_POST['Ref_prov_id']) && isset($_POST['Ref_dist_id']) && isset($_POST['Ref_subdist_id']) && isset($_POST['zip_code']) && isset($_POST['description'])) {

    $address = array("province" => $_POST['Ref_prov_id'], "district" => $_POST['Ref_dist_id'], "sub_district" => $_POST['Ref_subdist_id'], "zip_code" => $_POST['zip_code'], "description" => $_POST['description']);
    $address_json = json_encode($address);

    $e_fname = $_POST['e_fname'];
    $e_lname = $_POST['e_lname'];
    $role_id = $_POST['role_id'];
    $e_tel = $_POST['e_tel'];
    $e_add = $_POST['e_add'];
    $e_salary = $_POST['e_salary'];

    $sql = "UPDATE employee 
            SET e_fname = '$e_fname', e_lname = '$e_lname', e_tel = '$e_tel', role_id = '$role_id', e_salary = '$e_salary', e_date_update = NOW() ,e_add = '$address_json'
            WHERE e_id = '$id_e'";
    $result = mysqli_query($conn, $sql);
} else {

    $e_fname = $_POST['e_fname'];
    $e_lname = $_POST['e_lname'];
    $role_id = $_POST['role_id'];
    $e_tel = $_POST['e_tel'];
    $e_add = $_POST['e_add'];
    $e_salary = $_POST['e_salary'];

    $sql = "UPDATE employee 
            SET e_fname = '$e_fname', e_lname = '$e_lname', e_tel = '$e_tel', role_id = '$role_id', e_salary = '$e_salary', e_date_update = NOW() 
            WHERE e_id = '$id_e'";
    $result = mysqli_query($conn, $sql);
}



if ($result) {
    echo "<script>alert('Update success');</script>";
    header('Location:../employee_listview.php');
}

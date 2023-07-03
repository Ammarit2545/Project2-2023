<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$id = $_SESSION["id"];
$r_id = $_GET['id'];

$sum = 1;

while (isset($_SESSION['r_id_' . $sum])) {
    $sum++;
}

$sum -= 1;

if ($r_id != NULL) {
    // การซ่อมถัดไป
    $next_r_id = $r_id + 1;

    // Before :
    for ($i = 1; $i <= $sum; $i++) {
        echo $i;
    }

    // After :
    for ($i = $r_id; $i <= $sum; $i++) {
        if ($i == $r_id) {
            unsetSessionData($i);
            $folderName = "../uploads/{$id}/Holder/{$i}"; // the name of the folder to be deleted
            deleteDirectory($folderName);
        } else {
            $_SESSION['r_id_' . ($i - 1)] = $_SESSION['r_id_' . $i];
            $_SESSION['name_brand_' . ($i - 1)] = $_SESSION['name_brand_' . $i];
            $_SESSION['serial_number_' . ($i - 1)] = $_SESSION['serial_number_' . $i];
            $_SESSION['name_model_' . ($i - 1)] = $_SESSION['name_model_' . $i];
            $_SESSION['number_model_' . ($i - 1)] = $_SESSION['number_model_' . $i];
            $_SESSION['tel_' . ($i - 1)] = $_SESSION['tel_' . $i];
            $_SESSION['description_' . ($i - 1)] = $_SESSION['description_' . $i];
            $_SESSION['company_' . ($i - 1)] = $_SESSION['company_' . $i];

            $_SESSION['image1_' . ($i - 1)] = $_SESSION['image1_' . $i];
            $_SESSION['image2_' . ($i - 1)] = $_SESSION['image2_' . $i];
            $_SESSION['image3_' . ($i - 1)] = $_SESSION['image3_' . $i];
            $_SESSION['image4_' . ($i - 1)] = $_SESSION['image4_' . $i];

            $i1 = $i - 1;
            $oldFolderName = "../uploads/{$id}/Holder/{$i}/";
            $newFolderName = "../uploads/{$id}/Holder/{$i1}/";
            renameFolder($oldFolderName, $newFolderName);

            if ($i == $sum) {
                unsetSessionData($i);

                $folderName = "../uploads/{$id}/Holder/{$i}";
                deleteDirectory($folderName);
            }
            //    $i - 1;
        }
    }
}

header("location:../listview_repair.php");

function unsetSessionData($i)
{
    unset($_SESSION['r_id_' . $i]);
    unset($_SESSION['name_brand_' . $i]);
    unset($_SESSION['serial_number_' . $i]);
    unset($_SESSION['name_model_' . $i]);
    unset($_SESSION['number_model_' . $i]);
    unset($_SESSION['tel_' . $i]);
    unset($_SESSION['description_' . $i]);
    unset($_SESSION['company_' . $i]);

    unset($_SESSION['image1_' . $i]);
    unset($_SESSION['image2_' . $i]);
    unset($_SESSION['image3_' . $i]);
    unset($_SESSION['image4_' . $i]);
}

function deleteDirectory($folderName)
{
    if (!is_dir($folderName)) {
        echo "The folder does not exist.";
        return;
    }

    $files = array_diff(scandir($folderName), array('.', '..'));
    foreach ($files as $file) {
        $filePath = $folderName . '/' . $file;
        if (is_dir($filePath)) {
            deleteDirectory($filePath);
        } else {
            unlink($filePath);
        }
    }

    if (rmdir($folderName)) {
        echo "Folder deleted successfully.";
    } else {
        echo "There was an error deleting the folder.";
    }
}

function renameFolder($oldFolderName, $newFolderName)
{
    if (is_dir($oldFolderName)) {
        if (rename($oldFolderName, $newFolderName)) {
            echo "Folder name was successfully changed.";
        } else {
            echo "There was an error renaming the folder.";
        }
    } else {
        echo "The folder does not exist.";
    }
}

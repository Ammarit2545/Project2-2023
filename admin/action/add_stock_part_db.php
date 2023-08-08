<?php
session_start();
include('../../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}

$id = $_SESSION['id'];
$stock_type = $_SESSION['stock_type'];
$pl_bill_number = $_SESSION['pl_bill_number'];
$pl_tax_number = $_SESSION['pl_tax_number'];
$pl_date_in = $_SESSION['pl_date_in'];
$pl_detail = $_SESSION['pl_detail'];
$com_p_id = $_SESSION['com_p_id'];

// Echoing the values
echo "ID: $id<br>";
echo "Stock Type: $stock_type<br>";
echo "PL Bill Number: $pl_bill_number<br>";
echo "PL Tax Number: $pl_tax_number<br>";
echo "PL Date In: $pl_date_in<br>";
echo "PL Detail: $pl_detail<br>";
echo "Company Product ID: $com_p_id<br>";

if ($stock_type != NULL || $stock_type != '') {
    $sql = "SELECT st_type FROM stock_type WHERE st_id = '$stock_type' AND del_flg = '0'";
    $result = mysqli_query($conn, $sql);
    $row_check = mysqli_fetch_array($result);

    if ($row_check['st_type'] == 1) {
        $sql = "SELECT pl_id FROM parts_log WHERE pl_bill_number = '$pl_bill_number' OR pl_tax_number = '$pl_tax_number'";  // make del flg = 0
        $result = mysqli_query($conn, $sql);
        $row_check_bill = mysqli_fetch_array($result);

        if ($row_check_bill['pl_id'] > 0) {
            $_SESSION["add_data_alert"] = 3;
            // echo '33333';
            // header("Location: ../edit_stock.php");
            // exit();
        } else {
            $sql = "INSERT INTO `parts_log` (`pl_date`, `e_id`, `st_id`, `pl_bill_number`, `pl_tax_number`, `pl_date_in`, `pl_detail`, `com_p_id`)
                    VALUES (NOW(), '$id', '$stock_type', '$pl_bill_number', '$pl_tax_number', '$pl_date_in', '$pl_detail', '$com_p_id')";
            $result = mysqli_query($conn, $sql);
        }
    } else {
        $sql = "INSERT INTO `parts_log` (`pl_date`, `e_id`, `st_id`)
                VALUES (NOW(), '$id', '$stock_type')";
        $result = mysqli_query($conn, $sql);
    }

    if ($result) {
        unset($_SESSION['pl_bill_number'], $_SESSION['pl_tax_number'], $_SESSION['pl_date_in'], $_SESSION['pl_detail'], $_SESSION['com_p_id'], $_SESSION['stock_type']);

        $pl_id = mysqli_insert_id($conn);

        if (isset($_SESSION['part_p_id_1'])) {
            $i = 1;
            while (isset($_SESSION["part_p_id_$i"])) {
                $p_id = $_SESSION["part_p_id_$i"];
                $p_stock = $_SESSION["part_p_stock_$i"];

                $sql_update = "UPDATE parts SET p_stock = p_stock + $p_stock WHERE p_id = '$p_id' AND del_flg = '0'";
                $result_update = mysqli_query($conn, $sql_update);

                if ($result_update) {
                    $sql_count_stock = "SELECT COUNT(pl_d_id) AS count_stock FROM parts_log_detail WHERE p_id = '$p_id'AND del_flg = '0'";  // make del flg = 0
                    $result_count_stock = mysqli_query($conn, $sql_count_stock);
                    $row_count_stock = mysqli_fetch_array($result_count_stock);

                    if ($row_count_stock['count_stock'] == NULL || $row_count_stock['count_stock'] == 0) {
                        $count_stock =  1;
                    } else {
                        $count_stock = $row_count_stock['count_stock'] + 1;
                    }

                    $sql_p = "INSERT INTO `parts_log_detail` (`p_id`, `pl_d_value`, `pl_id`, `count_stock`) VALUES ('$p_id', '$p_stock', '$pl_id', '$count_stock')";
                    $result_insert = mysqli_query($conn, $sql_p);
                    if (!$result_insert) {
                        $_SESSION["add_data_error_alert$i"] = 1;
                    }
                } else {
                    $_SESSION["add_data_error_alert$i"] = 1;
                }

                unset($_SESSION["part_p_id_$i"], $_SESSION["part_p_stock_$i"]);
                $i++;
            }
            $_SESSION["add_data_alert"] = 0;
        } else {
            $_SESSION["add_data_alert"] = 1;
        }
    }
} else {
    $_SESSION["add_data_alert"] = 1;
}

header("Location: ../edit_stock.php");
exit();

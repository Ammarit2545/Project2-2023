<?php
session_start();
include('../database/condb.php');

if (!isset($_SESSION['role_id'])) {
    header('Location:../home.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Anan Electronic</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include('bar/sidebar.php');
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include('bar/topbar_admin.php');
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <?php

                        $status_req = 0;
                        $status_doing = 0;
                        $status_wait_pay = 0;
                        $status_not_suc = 0;

                        $sql_get = "SELECT get_repair.get_r_id
                        FROM get_repair
                        RIGHT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                        WHERE get_repair.del_flg = 0
                        GROUP BY get_repair.get_r_id;
                        ";
                        $result_get = mysqli_query($conn, $sql_get);

                        if ($result_get) {
                            $stmt_found = $conn->prepare("SELECT status_id FROM repair_status WHERE del_flg = 0 AND get_r_id = ? ORDER BY rs_date_time DESC LIMIT 1");

                            while ($row_get = mysqli_fetch_array($result_get)) {
                                $get_r_id = $row_get['get_r_id'];

                                // ซ่อนตัวแปรไว้ข้างใน
                                $stmt_found->bind_param("i", $get_r_id);
                                $stmt_found->execute();

                                $result_found = $stmt_found->get_result();
                                $row_found = mysqli_fetch_array($result_found);

                                if ($row_found && $row_found['status_id'] == 1) {
                                    $status_req = $status_req + 1;
                                }
                                if ($row_found && $row_found['status_id'] == 4) {
                                    $status_doing = $status_doing + 1;
                                }
                                if ($row_found && $row_found['status_id'] == 8) {
                                    $status_wait_pay = $status_wait_pay + 1;
                                }
                                if ($row_found && $row_found['status_id'] == 12) {
                                    $status_not_suc = $status_not_suc + 1;
                                }
                            }

                            // เอาตัวแปรออก
                            $stmt_found->close();
                        }
                        ?>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                คำขอซ่อม</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $status_req; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                คำขอที่กำลังซ่อม</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $status_doing ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                ยังไม่ชำระเงิน</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $status_wait_pay ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                ยังไม่เสร็จ</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $status_not_suc ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">รายได้การซ่อม</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="get">
                                <div class="col-auto">
                                    <h5 for="year" style="margin-top: 8px;">เลือกปี:</h5>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" name="year" id="year">
                                        <?php
                                        // Replace with the range of years you want to display
                                        $currentYear = date('Y');
                                        for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                            $selected = ($year == $_GET['year']) ? 'selected' : '';
                                            echo "<option value='$year' $selected>$year</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <h5 for="month" style="margin-top: 8px;">เลือกเดือน:</h5>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" name="month" id="month">
                                        <option value="">ทั้งหมด</option> <!-- Default option -->
                                        <?php
                                        $months = array(
                                            '01' => 'มกราคม',
                                            '02' => 'กุมภาพันธ์',
                                            '03' => 'มีนาคม',
                                            '04' => 'เมษายน',
                                            '05' => 'พฤษภาคม',
                                            '06' => 'มิถุนายน',
                                            '07' => 'กรกฎาคม',
                                            '08' => 'สิงหาคม',
                                            '09' => 'กันยายน',
                                            '10' => 'ตุลาคม',
                                            '11' => 'พฤศจิกายน',
                                            '12' => 'ธันวาคม',
                                        );
                                        foreach ($months as $monthNumber => $monthName) {
                                            $selected = ($_GET['month'] == $monthNumber) ? 'selected' : '';
                                            echo "<option value='$monthNumber' $selected>$monthName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php if (!empty($_GET['month'])) : ?>
                                    <div class="col-auto">
                                        <h5 for="day" style="margin-top: 8px;">เลือกวันที่:</h5>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select" name="day" id="day">
                                            <option value="">ทั้งหมด</option> <!-- Default option -->
                                            <?php
                                            for ($day = 1; $day <= 31; $day++) {
                                                $selected = (isset($_GET['day']) && $_GET['day'] == $day) ? 'selected' : '';
                                                echo "<option value='$day' $selected>$day</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-3">ดูข้อมูล</button>
                                </div>
                            </form>
                            <?php
                            $selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y'); // Default to the current year if not specified
                            $selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';
                            $selectedDay = isset($_GET['day']) ? $_GET['day'] : '';

                            if (empty($selectedMonth) && empty($selectedDay)) {
                                echo '<h3 style="color:black;">รายงานยอดซ่อมรายปี</h3>';
                            } else if (empty($selectedDay)) {
                                echo '<h3 style="color:black;">รายงานยอดซ่อมรายเดือน</h3>';
                            } else {
                                $formatted_date = $selectedDay . '/' . $selectedMonth . '/' . $selectedYear;
                                echo '<h3 style="color:black;">รายงานยอดซ่อมวันที่ ' . $formatted_date . '</h3>';
                            }
                            ?>

                            <table class="table table-bordered">
                                <thead>
                                    <?php if (empty($selectedMonth)) : ?>
                                        <tr>
                                            <th scope="col">เดือน</th>
                                            <th scope="col" style="text-align: right;">ค่าแรง</th>
                                            <th scope="col" style="text-align: right;">ค่าอะไหล่</th>
                                            <th scope="col" style="text-align: right;">รวม</th>
                                        </tr>
                                    <?php endif; ?>
                                </thead>

                                <tbody>
                                    <?php
                                    $month_translation = array(
                                        'January' => 'มกราคม',
                                        'February' => 'กุมภาพันธ์',
                                        'March' => 'มีนาคม',
                                        'April' => 'เมษายน',
                                        'May' => 'พฤษภาคม',
                                        'June' => 'มิถุนายน',
                                        'July' => 'กรกฎาคม',
                                        'August' => 'สิงหาคม',
                                        'September' => 'กันยายน',
                                        'October' => 'ตุลาคม',
                                        'November' => 'พฤศจิกายน',
                                        'December' => 'ธันวาคม',
                                    );

                                    $month_totals = array(); // Initialize an associative array to store month totals

                                    $selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y'); // Default to the current year if not specified
                                    $selectedMonth = isset($_GET['month']) ? $_GET['month'] : ''; // Default to empty if not specified

                                    // Your SQL query
                                    $sql_get = "SELECT get_repair.get_r_id, MAX(get_detail.get_d_id) AS get_d_id, MAX(repair.r_id) AS r_id, 3 AS status_id, MAX(get_repair.get_deli) AS get_deli
    FROM get_repair
    LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id
    LEFT JOIN repair ON get_detail.r_id = repair.r_id   
    LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
    LEFT JOIN status_type ON repair_status.status_id = status_type.status_id
    LEFT JOIN repair_detail ON get_repair.get_r_id = repair_detail.get_r_id
    WHERE YEAR(get_repair.get_r_date_in) = $selectedYear";

                                    // Add a condition for the selected month if it's not empty
                                    if (!empty($selectedMonth)) {
                                        $sql_get .= " AND MONTH(get_repair.get_r_date_in) = $selectedMonth";
                                    }

                                    $sql_get .= " AND get_repair.del_flg = '0' AND get_detail.del_flg = '0' AND repair_status.status_id = 3
    GROUP BY get_repair.get_r_id
    ORDER BY get_repair.get_r_id ASC;";
                                    $result_get = mysqli_query($conn, $sql_get);

                                    while ($row = mysqli_fetch_array($result_get)) {
                                        $get_r_id = $row['get_r_id'];
                                        $get_d_id = $row['get_d_id'];
                                        $sql_date = "SELECT MONTHNAME(STR_TO_DATE(get_r_date_in, '%Y-%m-%d')) AS month_name
                                                        FROM get_repair WHERE get_r_id = '$get_r_id'
                                                        GROUP BY MONTHNAME(STR_TO_DATE(get_r_date_in, '%Y-%m-%d'))";
                                        $result_date = mysqli_query($conn, $sql_date);
                                        $row_date = mysqli_fetch_array($result_date);

                                        //ค่าแรง
                                        $sql_addprice = "SELECT (get_add_price - get_add_cost_price) as sum_amount FROM get_repair WHERE get_r_id = '$get_r_id'";
                                        $result_addprice = mysqli_query($conn, $sql_addprice);
                                        $row_addprice = mysqli_fetch_array($result_addprice);

                                        if ($row_addprice) {
                                            $sum_amount = $row_addprice['sum_amount'];

                                            // ดึงค่า get_wages จากตาราง get_repair
                                            $sql_get_wages = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_r_id'";
                                            $result_get_wages = mysqli_query($conn, $sql_get_wages);
                                            $row_get_wages = mysqli_fetch_array($result_get_wages);

                                            if ($row_get_wages) {
                                                $current_wages = $row_get_wages['get_wages'];

                                                // นำผลลัพธ์มาบวกกับค่า get_wages
                                                $new_wages = $current_wages + $sum_amount;
                                            }
                                        }

                                        //ค่าอะไหล่
                                        $sql_parts = "SELECT (p_price - p_cost_price) as sum_amountparts FROM parts p
                                        JOIN repair_detail rd ON p.p_id = rd.p_id
                                        JOIN get_detail gd ON rd.get_d_id = gd.get_d_id
                                        JOIN get_repair gr ON gd.get_r_id = gr.get_r_id
                                        WHERE gr.get_r_id = '$get_r_id' AND gd.get_d_id = '$get_d_id'";
                                        $result_parts = mysqli_query($conn, $sql_parts);
                                        $row_parts = mysqli_fetch_array($result_parts);

                                        if ($row_parts) {
                                            $sum_amountparts = $row_parts['sum_amountparts'];

                                            // ดึงค่า get_wages จากตาราง get_repair
                                            $sql_get_parts = "SELECT rd_value_parts
                                            FROM repair_detail
                                            WHERE get_d_id = '$get_d_id';
                                            ";
                                            $result_get_parts = mysqli_query($conn, $sql_get_parts);
                                            $row_get_parts = mysqli_fetch_array($result_get_parts);

                                            if ($row_get_parts) {
                                                $current_parts = $row_get_parts['rd_value_parts'];

                                                // นำผลลัพธ์มาบวกกับค่า get_wages
                                                $new_parts = $current_parts * $sum_amountparts;
                                            }
                                        }

                                        $total = $new_wages + $new_parts;

                                        // Update month total in the associative array
                                        $month_name = $month_translation[$row_date['month_name']];
                                        if (!isset($month_totals[$month_name])) {
                                            $month_totals[$month_name]['new_wages'] = 0;
                                            $month_totals[$month_name]['new_parts'] = 0;
                                            $month_totals[$month_name]['total'] = 0;
                                        }
                                        $month_totals[$month_name]['new_wages'] += $new_wages;
                                        $month_totals[$month_name]['new_parts'] += $new_parts;
                                        $month_totals[$month_name]['total'] += $total;
                                    }

                                    function calculateTotal($month_totals, $key)
                                    {
                                        $grand_total = 0;
                                        foreach ($month_totals as $totals) {
                                            $grand_total += $totals[$key];
                                        }
                                        return $grand_total;
                                    }

                                    if (empty($selectedMonth) && empty($selectedDay)) {
                                        // Loop through the associative array and display month totals
                                        foreach ($month_totals as $month_name => $totals) {
                                    ?>
                                            <tr>
                                                <td><?= $month_name ?></td>
                                                <td align="right"><?= number_format($totals['new_wages']) ?></td>
                                                <td align="right"><?= number_format($totals['new_parts']) ?></td>
                                                <td align="right"><?= number_format($totals['total']) ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td style="font-weight: bold;">รวมทั้งสิ้น</td>
                                            <td align="right" style="font-weight: bold;"><?= number_format(calculateTotal($month_totals, 'new_wages')) ?></td>
                                            <td align="right" style="font-weight: bold;"><?= number_format(calculateTotal($month_totals, 'new_parts')) ?></td>
                                            <td align="right" style="font-weight: bold;"><?= number_format(calculateTotal($month_totals, 'total')) ?></td>
                                        </tr>
                                    <?php
                                    } else if (!empty($selectedMonth) && empty($selectedDay)) {
                                        // เลือกแสดงข้อมูลเป็นรายวัน
                                    ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">วัน</th>
                                                    <th scope="col" style="text-align: right;">ค่าแรง</th>
                                                    <th scope="col" style="text-align: right;">ค่าอะไหล่</th>
                                                    <th scope="col" style="text-align: right;">รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // ใช้ SQL เดิมๆ แต่รวมวันลงไปด้วย
                                                $sql_get = "SELECT get_repair.get_r_id, MAX(get_detail.get_d_id) AS get_d_id, MAX(repair.r_id) AS r_id, 3 AS status_id, MAX(get_repair.get_deli) AS get_deli, DATE(get_repair.get_r_date_in) AS get_r_date_in
                  FROM get_repair
                  LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id
                  LEFT JOIN repair ON get_detail.r_id = repair.r_id   
                  LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
                  LEFT JOIN status_type ON repair_status.status_id = status_type.status_id
                  WHERE YEAR(get_repair.get_r_date_in) = $selectedYear";

                                                // เพิ่มเงื่อนไขสำหรับเดือนที่เลือกถ้าไม่เป็นค่าว่าง
                                                if (!empty($selectedMonth)) {
                                                    $sql_get .= " AND MONTH(get_repair.get_r_date_in) = $selectedMonth";
                                                }

                                                $sql_get .= " AND get_repair.del_flg = '0' AND get_detail.del_flg = '0' AND repair_status.status_id = 3
                  GROUP BY get_repair.get_r_id
                  ORDER BY get_repair.get_r_id ASC;";
                                                $result_get = mysqli_query($conn, $sql_get);

                                                while ($row = mysqli_fetch_array($result_get)) {
                                                    $get_r_id = $row['get_r_id'];
                                                    $get_d_id = $row['get_d_id'];
                                                    $get_r_date_in = $row['get_r_date_in'];

                                                    // แปลงรูปแบบวันที่เป็น "วัน เดือน ปี" (เช่น "1/10/2566")
                                                    $formatted_date = date('j/n/Y', strtotime($get_r_date_in));

                                                    $sql_addprice = "SELECT (get_add_price - get_add_cost_price) as sum_amount FROM get_repair WHERE get_r_id = '$get_r_id'";
                                                    $result_addprice = mysqli_query($conn, $sql_addprice);
                                                    $row_addprice = mysqli_fetch_array($result_addprice);

                                                    if ($row_addprice) {
                                                        $sum_amount = $row_addprice['sum_amount'];

                                                        // ดึงค่า get_wages จากตาราง get_repair
                                                        $sql_get_wages = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_r_id'";
                                                        $result_get_wages = mysqli_query($conn, $sql_get_wages);
                                                        $row_get_wages = mysqli_fetch_array($result_get_wages);

                                                        if ($row_get_wages) {
                                                            $current_wages = $row_get_wages['get_wages'];

                                                            // นำผลลัพธ์มาบวกกับค่า get_wages
                                                            $new_wages = $current_wages + $sum_amount;
                                                        }
                                                    }

                                                    //ค่าอะไหล่
                                                    $sql_parts = "SELECT (p_price - p_cost_price) as sum_amountparts FROM parts p
                                        LEFT JOIN repair_detail rd ON p.p_id = rd.p_id
                                        LEFT JOIN get_detail gd ON rd.get_d_id = gd.get_d_id
                                        LEFT JOIN get_repair gr ON gd.get_r_id = gr.get_r_id
                                        WHERE gr.get_r_id = '$get_r_id' AND gd.get_d_id = '$get_d_id'";
                                                    $result_parts = mysqli_query($conn, $sql_parts);
                                                    $row_parts = mysqli_fetch_array($result_parts);

                                                    if ($row_parts) {
                                                        $sum_amountparts = $row_parts['sum_amountparts'];

                                                        // ดึงค่า get_wages จากตาราง get_repair
                                                        $sql_get_parts = "SELECT rd_value_parts
                                            FROM repair_detail
                                            WHERE get_d_id = '$get_d_id';
                                            ";
                                                        $result_get_parts = mysqli_query($conn, $sql_get_parts);
                                                        $row_get_parts = mysqli_fetch_array($result_get_parts);

                                                        if ($row_get_parts) {
                                                            $current_parts = $row_get_parts['rd_value_parts'];

                                                            // นำผลลัพธ์มาบวกกับค่า get_wages
                                                            $new_parts = $current_parts * $sum_amountparts;
                                                        }
                                                    }

                                                    $total = $new_wages + $new_parts;
                                                ?>
                                                    <tr>
                                                        <td><?= $formatted_date ?></td>
                                                        <td align="right"><?= number_format($new_wages) ?></td>
                                                        <td align="right"><?= number_format($new_parts) ?></td>
                                                        <td align="right"><?= number_format($total) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td style="font-weight: bold;">รวมทั้งสิ้น</td>
                                                    <td align="right" style="font-weight: bold;"><?= number_format(calculateTotal($month_totals, 'new_wages')) ?></td>
                                                    <td align="right" style="font-weight: bold;"><?= number_format(calculateTotal($month_totals, 'new_parts')) ?></td>
                                                    <td align="right" style="font-weight: bold;"><?= number_format(calculateTotal($month_totals, 'total')) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <?php
                                    } else {
                                        // เลือกแสดงข้อมูลรายละเอียดเป็นวันที่เลือก
                                    ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 200px; vertical-align: middle; text-align: center;">หมายเลขใบแจ้งซ่อม</th>
                                                    <th scope="col" style="text-align: center;">รายการ</th>
                                                    <th scope="col" style="text-align: right;">ค่าแรง</th>
                                                    <th scope="col" style="text-align: right;">ค่าอะไหล่</th>
                                                    <th scope="col" style="text-align: right;">รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_get = "SELECT get_repair.get_r_id, MAX(get_detail.get_d_id) AS get_d_id, MAX(repair.r_id) AS r_id, 3 AS status_id, MAX(get_repair.get_deli) AS get_deli, DATE(get_repair.get_r_date_in) AS get_r_date_in
    FROM get_repair
    LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id
    LEFT JOIN repair ON get_detail.r_id = repair.r_id   
    LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
    LEFT JOIN status_type ON repair_status.status_id = status_type.status_id
    WHERE YEAR(get_repair.get_r_date_in) = $selectedYear";

                                                if (!empty($selectedMonth)) {
                                                    $sql_get .= " AND MONTH(get_repair.get_r_date_in) = $selectedMonth";
                                                }

                                                if (!empty($selectedDay)) {
                                                    $sql_get .= " AND DAY(get_repair.get_r_date_in) = $selectedDay";
                                                }

                                                $sql_get .= " AND get_repair.del_flg = '0' AND get_detail.del_flg = '0' AND repair_status.status_id = 3
    GROUP BY get_repair.get_r_id
    ORDER BY get_repair.get_r_id ASC;";
                                                $result_get = mysqli_query($conn, $sql_get);

                                                $daily_totals = array(
                                                    'new_wages' => 0,
                                                    'new_parts' => 0,
                                                    'total' => 0
                                                );

                                                while ($row = mysqli_fetch_array($result_get)) {
                                                    $get_r_id = $row['get_r_id'];
                                                    $get_d_id = $row['get_d_id'];
                                                    $get_r_date_in = $row['get_r_date_in'];

                                                    // SQL query to get repair data based on get_r_id
                                                    $sql_repair = "SELECT r_brand, r_model FROM repair WHERE r_id = (SELECT r_id FROM get_detail WHERE get_r_id = $get_r_id)";
                                                    $result_repair = mysqli_query($conn, $sql_repair);
                                                    $row_repair = mysqli_fetch_array($result_repair);

                                                    $r_brand = $row_repair['r_brand'];
                                                    $r_model = $row_repair['r_model'];

                                                    // SQL query to calculate additional price
                                                    $sql_addprice = "SELECT (get_add_price - get_add_cost_price) as sum_amount FROM get_repair WHERE get_r_id = '$get_r_id'";
                                                    $result_addprice = mysqli_query($conn, $sql_addprice);
                                                    $row_addprice = mysqli_fetch_array($result_addprice);
                                                    $sum_amount = $row_addprice['sum_amount'];

                                                    // SQL query to get wages from get_repair table
                                                    $sql_get_wages = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_r_id'";
                                                    $result_get_wages = mysqli_query($conn, $sql_get_wages);
                                                    $row_get_wages = mysqli_fetch_array($result_get_wages);
                                                    $current_wages = $row_get_wages['get_wages'];

                                                    $new_wages = $current_wages + $sum_amount;

                                                    // SQL query to calculate part cost
                                                    $sql_parts = "SELECT (p_price - p_cost_price) as sum_amountparts FROM parts p
        JOIN repair_detail rd ON p.p_id = rd.p_id
        WHERE rd.get_d_id = '$get_d_id'";
                                                    $result_parts = mysqli_query($conn, $sql_parts);
                                                    $row_parts = mysqli_fetch_array($result_parts);
                                                    $sum_amountparts = $row_parts['sum_amountparts'];

                                                    // SQL query to get parts value from repair_detail table
                                                    $sql_get_parts = "SELECT rd_value_parts FROM repair_detail WHERE get_d_id = '$get_d_id'";
                                                    $result_get_parts = mysqli_query($conn, $sql_get_parts);
                                                    $row_get_parts = mysqli_fetch_array($result_get_parts);
                                                    $current_parts = $row_get_parts['rd_value_parts'];

                                                    $new_parts = $current_parts * $sum_amountparts;

                                                    $total = $new_wages + $new_parts;

                                                    $daily_totals['new_wages'] += $new_wages;
                                                    $daily_totals['new_parts'] += $new_parts;
                                                    $daily_totals['total'] += $total;
                                                ?>
                                                    <tr>
                                                        <td align="center"><?= $get_r_id ?></td>
                                                        <td align="left"><?= $r_brand . " " . $r_model ?></td>
                                                        <td align="right"><?= number_format($new_wages) ?></td>
                                                        <td align="right"><?= number_format($new_parts) ?></td>
                                                        <td align="right"><?= number_format($total) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td style="font-weight: bold;" colspan="2">รวมทั้งสิ้น</td>
                                                    <td align="right" style="font-weight: bold;"><?= number_format($daily_totals['new_wages']) ?></td>
                                                    <td align="right" style="font-weight: bold;"><?= number_format($daily_totals['new_parts']) ?></td>
                                                    <td align="right" style="font-weight: bold;"><?= number_format($daily_totals['total']) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <?php
                                    }
                                    ?>
                            </table>
                            <p style="font-size: 13px">**หมายเหตุ**</p>
                            <p style="font-size: 13px">ค่าแรง = (ราคาค่าส่ง - ราคาค่าส่งต้นทุน) + ค่าแรงช่าง</p>
                            <p style="font-size: 13px">ค่าอะไหล่ = (ราคาอะไหล่ - ราคาต้นทุนอะไหล่) * จำนวนอะไหล่</p>
                            <p style="font-size: 13px">รวมทั้งสิ้น = ค่าแรง + ค่าอะไหล่</p>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">ยอดต่อเดือน</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Color System -->
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-primary text-white shadow">
                                        <div class="card-body">
                                            Primary
                                            <div class="text-white-50 small">#4e73df</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-success text-white shadow">
                                        <div class="card-body">
                                            Success
                                            <div class="text-white-50 small">#1cc88a</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-info text-white shadow">
                                        <div class="card-body">
                                            Info
                                            <div class="text-white-50 small">#36b9cc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-warning text-white shadow">
                                        <div class="card-body">
                                            Warning
                                            <div class="text-white-50 small">#f6c23e</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-danger text-white shadow">
                                        <div class="card-body">
                                            Danger
                                            <div class="text-white-50 small">#e74a3b</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-secondary text-white shadow">
                                        <div class="card-body">
                                            Secondary
                                            <div class="text-white-50 small">#858796</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-light text-black shadow">
                                        <div class="card-body">
                                            Light
                                            <div class="text-black-50 small">#f8f9fc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-dark text-white shadow">
                                        <div class="card-body">
                                            Dark
                                            <div class="text-white-50 small">#5a5c69</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-4">

                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="...">
                                    </div>
                                    <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                                        constantly updated collection of beautiful svg images that you can use
                                        completely free and without attribution!</p>
                                    <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                                        unDraw &rarr;</a>
                                </div>
                            </div>

                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                                </div>
                                <div class="card-body">
                                    <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                                        CSS bloat and poor page performance. Custom CSS classes are used to create
                                        custom components and custom utility classes.</p>
                                    <p class="mb-0">Before working with this theme, you should become familiar with the
                                        Bootstrap framework, especially the utility classes.</p>
                                </div>
                            </div>

                        </div>
                        <!-- Bar Chart -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="myBarChart"></canvas>
                                </div>
                                <hr>
                                Styling for the bar chart can be found in the
                                <code>/js/demo/chart-bar-demo.js</code> file.
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            include('bar/admin_footer.php');
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>

</body>

</html>
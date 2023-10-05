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

    <title>Report Parts - Anan Electronic</title>
    <link rel="icon" type="image/x-icon" href="../img brand/anelogo.jpg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        table.table-bordered {
            width: 100%;
            border-collapse: collapse;
        }

        table.table-bordered th,
        table.table-bordered td {
            padding: 8px;
            border: 1px solid #000;
        }
    </style>

</head>

<body>
    <?php
    include('bar/topbar_admin.php');
    ?>

    <!-- <h3>รายงานประจำเดือน</h3> -->
    <?php
    // Start Export PDF
    require_once __DIR__ . '/vendor/autoload.php';

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/tmp',
        ]),
        'fontdata' => $fontData + [
            'sarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNew Italic.ttf',
                'B' => 'THSarabunNew Bold.ttf',
                'BI' => 'THSarabunNew BoldItalic.ttf'
            ]
        ],
        'default_font' => 'sarabun'
    ]);
    // End Export PDF

    $mpdf->SetFont('sarabun', '', 14);
    ob_start();
    ?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" width="200px"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" rowspan="4"><img src="../img brand/anelogo.jpg" width="120px" alt=""></th>
                        </tr>
                        <tr>
                            <td scope="row" style="font-size: 25px; font-weight: bold;">ร้าน อนันต์อิเล็กทรอนิกส์</td>
                        </tr>
                        <tr>
                            <td scope="row" style="font-size: 11px">รายงานยอดรายได้การซ่อม(แบบสรุป) ณ วันที่ <span id="currentDate"></span></td>

                            <script>
                                // Get the current date and format it
                                var currentDate = new Date().toLocaleDateString('th-TH');
                                document.getElementById('currentDate').textContent = currentDate;
                            </script>
                        </tr>
                        <tr>
                            <td scope="row" style="font-size: 11px">Repair income (summary form) as of date</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>

        <table class="table table-striped table-hover"> <!-- Add table-bordered class -->
            <thead>
                <tr>
                    <th scope="col">เดือน</th>
                    <th scope="col" style="text-align: right;">ค่าแรง</th>
                    <th scope="col" style="text-align: right;">ค่าอะไหล่</th>
                    <th scope="col" style="text-align: right;">รวม</th>
                </tr>
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

                $sql_get = "SELECT get_repair.get_r_id, MAX(get_detail.get_d_id) AS get_d_id, MAX(repair.r_id) AS r_id, 3 AS status_id, MAX(get_repair.get_deli) AS get_deli
FROM get_repair
LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id
LEFT JOIN repair ON get_detail.r_id = repair.r_id   
LEFT JOIN repair_status ON repair_status.get_r_id = get_repair.get_r_id
LEFT JOIN status_type ON repair_status.status_id = status_type.status_id
WHERE get_repair.del_flg = '0' AND get_detail.del_flg = '0' AND repair_status.status_id = 3
GROUP BY get_repair.get_r_id
ORDER BY get_repair.get_r_id DESC;";
                $result_get = mysqli_query($conn, $sql_get);

                while ($row = mysqli_fetch_array($result_get)) {
                    $get_r_id = $row['get_r_id'];
                    $sql_date = "SELECT MONTHNAME(STR_TO_DATE(get_r_date_in, '%Y-%m-%d')) AS month_name
  FROM get_repair WHERE get_r_id = '$get_r_id'
  GROUP BY MONTHNAME(STR_TO_DATE(get_r_date_in, '%Y-%m-%d'))";
                    $result_date = mysqli_query($conn, $sql_date);
                    $row_date = mysqli_fetch_array($result_date);

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

                    $sql_parts = "SELECT (p_price - p_cost_price) as sum_amountparts FROM parts";
                    $result_parts = mysqli_query($conn, $sql_parts);
                    $row_parts = mysqli_fetch_array($result_parts);

                    if ($row_parts) {
                        $sum_amountparts = $row_parts['sum_amountparts'];

                        // ดึงค่า get_wages จากตาราง get_repair
                        $sql_get_parts = "SELECT pu_value FROM parts_use_detail 
LEFT JOIN parts_use ON parts_use.pu_id = parts_use_detail.pu_id";
                        $result_get_parts = mysqli_query($conn, $sql_get_parts);
                        $row_get_parts = mysqli_fetch_array($result_get_parts);

                        if ($row_get_parts) {
                            $current_parts = $row_get_parts['pu_value'];

                            // นำผลลัพธ์มาบวกกับค่า get_wages
                            $new_parts = $current_parts + $sum_amountparts;
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
                    <td colspan="3" style="font-weight: bold;">รวมทั้งสิ้น</td>
                    <td align="right" style="font-weight: bold;">
                        <?php
                        $grand_total = 0;
                        foreach ($month_totals as $totals) {
                            $grand_total += $totals['total'];
                        }
                        echo number_format($grand_total);
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="font-size: 13px">**หมายเหตุ**</p>
        <p style="font-size: 13px">ค่าแรง = (ราคาค่าส่ง - ราคาค่าส่งต้นทุน) + ค่าแรงช่าง</p>
        <p style="font-size: 13px">ค่าอะไหล่ = (ราคาอะไหล่ - ราคาต้นทุนอะไหล่) * จำนวนอะไหล่</p>
        <p style="font-size: 13px">รวมทั้งสิ้น = ค่าแรง + ค่าอะไหล่</p>
    </div>

    <?php
    $html = ob_get_contents();
    $mpdf->WriteHTML($html);
    $filename = date('Y-m-d') . ' - รายงานยอดรายได้การซ่อม_Report.pdf';
    $filePath = __DIR__ . '/report/' . $filename;
    $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
    ob_end_flush();
    ?>

    <?php
    include('bar/admin_footer.php.php');
    ?>
    <center>
        <a href="index.php" class="btn btn-primary">Back</a>
        <a href="Report.pdf" style="text-align: end;"><button class="btn btn-primary" style="text-align: end;">Export PDF</button> </a>
    </center>
</body>

</html>
<!-- --------------------------ส่วนท้าย------------------------ -->
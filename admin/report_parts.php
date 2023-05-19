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
                            <td scope="row" style="font-size: 11px">รายยอดคงเหลืออะไหล่(แบบสรุป) ณ วันที่ <span id="currentDate"></span></td>

                            <script>
                                // Get the current date and format it
                                var currentDate = new Date().toLocaleDateString('th-TH');
                                document.getElementById('currentDate').textContent = currentDate;
                            </script>
                        </tr>
                        <tr>
                            <td scope="row" style="font-size: 11px">Sales of spare parts (summary form) as of date</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>

        <table class="table table-striped table-hover"> <!-- Add table-bordered class -->
            <thead>
                <tr>
                    <th scope="col">ที่</th>
                    <th scope="col">รหัสอะไหล่</th>
                    <th scope="col" width="200px">ชื่อ</th>
                    <th scope="col">ยี่ห้อ</th>
                    <th scope="col">รุ่น</th>
                    <th scope="col">คงเหลือจำนวน</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $p_stock = 0;
                $sql = "SELECT * FROM parts WHERE del_flg = '0'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    $i += 1;
                    $p_stock += $row['p_stock'];
                ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $i ?></th>
                        <td>
                            <?php echo $row['p_id'] ?? "ไม่มีข้อมูล"; ?>
                        </td>
                        <td>
                            <center>
                                <?php echo $row['p_name'] ?? "ไม่มีข้อมูล"; ?>
                            </center>
                        </td>
                        <td>
                            <?php echo $row['p_brand'] ?? "ไม่มีข้อมูล"; ?>
                        </td>
                        <td>
                            <?php echo $row['p_model'] ?? "ไม่มีข้อมูล"; ?>
                        </td>
                        <td>
                            <?php echo $row['p_stock'] ?? "ไม่มีข้อมูล"; ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="4">ยอดอะไหล่ทั้งหมดรวมทั้งสิ้น <?= $i ?> รายการ </td>
                    <td>คงเหลือ</td>
                    <td style="font-weight: bold;"><?= $p_stock ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php
    $html = ob_get_contents();
    $mpdf->WriteHTML($html);
    $filename = date('Y-m-d') . ' - รายงานยอดอะไหล่_Report.pdf';
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
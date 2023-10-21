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
        <table class="table">
            <tr class="head">
                <td>
                    <img src="../img brand/anelogo2.jpg" width="40%" alt="">
                    <h4><strong>ร้าน อนันต์ อิเล็คทรอนิคส์</strong></h4>
                    <p>175 ถ.สุวรรณศร อ.เมืองสระแก้ว ต.สระแก้ว จ.สระแก้ว, Sa Kaeo, Thailand, Sa Kaeo</p>
                    <p>โทร. 085-699-3391</p>
                </td>
                <td class="date">
                    <div class="text-right my-2">
                        <?php
                        $get_r_id = $_GET['id'];

                        $sql_get_count = "SELECT COUNT(get_r_id) FROM get_detail 
                    WHERE get_r_id = '$get_r_id' AND get_detail.del_flg = 0";
                        $result_get_count = mysqli_query($conn, $sql_get_count);
                        $row_get_count = mysqli_fetch_array($result_get_count);

                        $sql = "SELECT * FROM get_repair
    LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id 
    LEFT JOIN repair ON repair.r_id = get_detail.r_id 
    LEFT JOIN member ON member.m_id = repair.m_id
    LEFT JOIN repair_status ON get_repair.get_r_id = repair_status.get_r_id
    LEFT JOIN status_type ON status_type.status_id = repair_status.status_id
    WHERE get_repair.del_flg = '0' AND repair_status.del_flg = '0' AND get_repair.get_r_id = '$get_r_id' ORDER BY rs_date_time DESC;";

                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);

                        // การแปลงวันที่
                        $dateString = date('d-m-Y', strtotime($row['get_r_date_in']));
                        $date = DateTime::createFromFormat('d-m-Y', $dateString);
                        $thaiMonths = array(
                            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                        );
                        $formattedDate = $date->format('d') . ' ' . $thaiMonths[intval($date->format('m')) - 1] . ' ' . $date->format('Y');
                        ?>

                        <h5>
                            <strong>วันที่ <span><?= $formattedDate ?></span></strong>
                        </h5>

                    </div>
                </td>
            </tr>

            <tr class="receipt-title">
                <td colspan="2">
                    <div class="text-right">
                        <h4><strong>ใบแจ้งซ่อม</strong></h4>
                        <h4><strong>REPAIR NOTIFICATION</strong></h4>
                    </div>
                </td>
            </tr>
            <tr class="name">
                <td colspan="2">
                    <?php
                    $sql1 = "SELECT * FROM member WHERE del_flg = 0";
                    $result1 = mysqli_query($conn, $sql1);
                    $data = mysqli_fetch_all($result1, MYSQLI_ASSOC);

                    $jsonobj = $row['get_add'];

                    $obj = json_decode($jsonobj);
                    $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
                                    FROM provinces
                                    LEFT JOIN amphures ON provinces.id = amphures.province_id
                                    LEFT JOIN districts ON amphures.id = districts.amphure_id
                                    WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
                    $result_p = mysqli_query($conn, $sql_p);
                    $row_p = mysqli_fetch_array($result_p);
                    ?>
                    <h6><strong>ชื่อผู้ซื้อ / Customer's Name :</strong> <span><?= $row['m_fname'] . ' ' . $row['m_lname'] ?></span></h6>
                    <h6><strong>ที่อยู่ / Address :</strong> <span><?= $row_p[0] . ' ' . $row_p[1] . ' ' . $row_p[2] . ' ' . $row_p[3] . ' ' . $obj ?></span></h6>
                </td>
            </tr>
            <tr class="name">
                <td colspan="2">
                    <h6><strong>เลขซีเรียล / Serial Number :</strong> <span><?= $row['r_serial_number'] ?></span></h6>
                    <h6><strong>อุปกรณ์ / Device name :</strong> <span><?= $row['r_brand'] . ' ' . $row['r_model'] ?></span></h6>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table class="table table-bordered bill-table">
                        <thead>
                            <tr>
                                <th style="width: 50px; vertical-align: middle;">ลำดับ</th>
                                <th style="vertical-align: middle;">รายการ / Description</th>
                                <th style="width: 100px; text-align: center;">จำนวน / Quantity</th>
                                <th style="width: 100px; text-align: center;">ราคา / Price</th>
                                <th style="width: 100px; text-align: center;">ราคารวม / Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $get_id = $_GET['id'];
                            $sql = "SELECT
                                        repair_detail.p_id,
                                        COUNT(repair_detail.p_id) AS count,
                                        parts.p_brand,
                                        parts.p_model,
                                        parts.p_price,
                                        parts_type.p_type_name,
                                        repair_status.rs_id,
                                        parts.p_pic
                                    FROM
                                        `repair_detail`
                                    LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                                    LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
                                    JOIN parts ON parts.p_id = repair_detail.p_id
                                    LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id
                                    WHERE
                                        get_repair.del_flg = 0 AND repair_detail.del_flg = 0
                                        AND get_repair.get_r_id = '$get_id'
                                    GROUP BY
                                        repair_detail.p_id,
                                        parts.p_brand,
                                        parts.p_model,
                                        parts.p_price,
                                        parts_type.p_type_name,
                                        repair_status.rs_id, -- Include repair_status.rs_id in GROUP BY
                                        parts.p_pic;
                                    
                                        ";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                $p_id = $row['p_id'];
                                $rs_id = $row['rs_id'];
                                $sql_count = "SELECT * FROM repair_detail WHERE rs_id = '$rs_id' AND p_id = '$p_id'";
                                $result_count = mysqli_query($conn, $sql_count);
                                $row_count = mysqli_fetch_array($result_count);

                            ?>
                                <tr>
                                    <td><?php
                                        if ($row['p_id'] == NULL) {
                                            echo "-";
                                        } else {
                                            echo $row['p_id'];
                                        }
                                        ?>
                                    </td>

                                    <td><?php
                                        if ($row['p_brand'] == NULL) {
                                            echo "-";
                                        } else {
                                            echo $row['p_name'] . ' ' . $row['p_brand'] . ' ' . $row['p_model'] . ' ' . $row['p_type_name'];
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;"><?php
                                                                                            if ($row_count['rd_value_parts'] == NULL) {
                                                                                                echo "-";
                                                                                            } else {
                                                                                                echo $row_count['rd_value_parts'];
                                                                                            }
                                                                                            ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php
                                        if ($row['p_price'] == NULL) {
                                            echo "-";
                                        } else {
                                            echo $row['p_price'];
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php
                                        if ($row_count['rd_value_parts'] == NULL) {
                                            echo "-";
                                        } else {
                                            echo number_format($row_count['rd_value_parts'] * $row['p_price']);
                                            $total += $row_count['rd_value_parts'] * $row['p_price'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <?php
                            $sql_p = "SELECT get_deli , get_add_price FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                            $result_p = mysqli_query($conn, $sql_p);
                            $row_p = mysqli_fetch_array($result_p);

                            if ($row_p['get_deli'] == 1) {
                                $total += $row_p['get_add_price'];
                            ?>
                                <tr>
                                    <td colspan="5">ค่าจัดส่ง</td>
                                    <td colspan="2">ราคาจัดส่ง</td>
                                    <td><?= number_format($row_p['get_add_price']) ?></td>
                                    <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                </tr>
                            <?php
                            } ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="2">ยอดอะไหล่ทั้งหมด</td>
                                <td colspan="2" style="text-align: right;">
                                    <strong>รวมเงิน (Sub Total)</strong>
                                </td>
                                <td style="text-align: center;"><?= number_format($total) ?></td>
                            </tr>
                            <tr>
                                <?php
                                $sql_w = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                $result_w = mysqli_query($conn, $sql_w);
                                $row_w = mysqli_fetch_array($result_w);
                                ?>
                                <td colspan="2">ค่าแรงช่าง</td>
                                <td colspan="2" style="text-align: right;">
                                    <strong>ค่าแรง (Mechanic's wages)</strong>
                                </td>
                                <td style="text-align: center;"><?= number_format($row_w['get_wages']) ?></td>
                            </tr>
                            <?php

                            function convertToThaiBahtText($amount)
                            {
                                $thai_num_arr = array('', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
                                $unit_arr = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');

                                $amount = number_format($amount, 2, '.', ''); // format ให้เป็นทศนิยมสองตำแหน่ง

                                $amount_arr = explode('.', $amount); // แยกจำนวนเต็มกับทศนิยม

                                $baht_text = '';

                                // จำนวนเต็ม
                                $integer = $amount_arr[0];
                                $integer_length = strlen($integer);

                                for ($i = 0; $i < $integer_length; $i++) {
                                    $num = substr($integer, $i, 1);
                                    if ($num != 0) {
                                        if ($i == $integer_length - 1 && $num == 1) {
                                            $baht_text .= 'เอ็ด';
                                        } elseif ($i == $integer_length - 2 && $num == 2) {
                                            $baht_text .= 'ยี่';
                                        } elseif ($i == $integer_length - 2 && $num == 1) {
                                            $baht_text .= '';
                                        } else {
                                            $baht_text .= $thai_num_arr[$num];
                                        }
                                        $baht_text .= $unit_arr[$integer_length - $i - 1];
                                    }
                                }

                                $baht_text .= 'บาท';

                                // ทศนิยม
                                if (isset($amount_arr[1])) {
                                    $decimal = $amount_arr[1];
                                    if ($decimal > 0) {
                                        if ($decimal < 10) {
                                            $baht_text .= $thai_num_arr[$decimal] . 'สตางค์';
                                        } else {
                                            $baht_text .= convertToThaiBahtText($decimal) . 'สตางค์';
                                        }
                                    } else {
                                        $baht_text .= 'ถ้วน';
                                    }
                                } else {
                                    $baht_text .= 'ถ้วน';
                                }

                                return $baht_text;
                            }

                            $amount = $total + $row_w['get_wages']; // จำนวนเงินที่ต้องการแปลง
                            $baht_text = convertToThaiBahtText($amount);

                            ?>

                            <tr>
                                <td colspan="2">
                                    <strong><?= $baht_text ?></strong>
                                </td>
                                <td colspan="2" style="text-align: right;">
                                    <strong>รวมเงินทั้งสิ้น (Total)</strong>
                                </td>
                                <td style="text-align: center;"><?= number_format($amount) ?></td>
                            </tr>

                        </tfoot>
                    </table>
                </td>
            </tr>

        </table>
    </div>

    <?php
    $html = ob_get_contents();
    $mpdf->WriteHTML($html);
    $filename = date('Y-m-d') . ' - ใบเสร็จ_Report.pdf';
    $filePath = __DIR__ . '/report/' . $filename;
    $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
    ob_end_flush();
    ?>

    <?php
    include('bar/admin_footer.php.php');
    ?>
    <center class="my-5">
        <a href="listview_repair.php" class="btn btn-primary">Back</a>
        <a href="Report.pdf" style="text-align: end;"><button class="btn btn-primary" style="text-align: end;">Export PDF</button> </a>
    </center>
</body>

</html>
<!-- --------------------------ส่วนท้าย------------------------ -->
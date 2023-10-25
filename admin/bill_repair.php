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
                <td class="date" style="text-align: right;">
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

                        <h4>
                            <strong>วันที่ <span><?= $formattedDate ?></span></strong>
                        </h4>

                    </div>
                </td>
            </tr>

            <tr class="receipt-title">
                <td colspan="2" style="text-align: right;">
                    <div >
                        <h4><strong>ใบแจ้งซ่อม #<?= $row['get_r_id'] ?></strong></h4>
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
                    <p><strong>ชื่อผู้ซื้อ / Customer's Name :</strong> <span><?= $row['m_fname'] . ' ' . $row['m_lname'] ?></span></p>
                    <p><strong>ที่อยู่ / Address :</strong> <span>
                            <?php
                            if ($row_p) {
                                echo $row_p[0] . ' ' . $row_p[1] . ' ' . $row_p[2] . ' ';
                            }
                            if ($obj) {
                                echo $row_p[3] . ' ' . $obj->property1 . ' ' . $obj->property2; // ปรับเปลี่ยน 'property1' และ 'property2' ตามโครงสร้าง JSON ของคุณ
                            }
                            ?>
                        </span></p>

                </td>
            </tr>
            <tr class="name">
                <td colspan="2">
                    <?php
                    $count_get_no = 0;
                    $repair_count = 0;
                    $sql_get_c2 = "SELECT *
                                            FROM get_detail
                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                            LEFT JOIN company_transport ON  tracking.t_c_id = company_transport.com_t_id
                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                            WHERE get_detail.get_r_id = '$get_r_id' AND get_detail.del_flg = 0 AND (get_d_conf != 1 OR get_d_conf IS NULL);
                                            ";
                    $sql_get_count_track = "SELECT * FROM get_detail
                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                            LEFT JOIN company_transport ON  tracking.t_c_id = company_transport.com_t_id
                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                            WHERE get_detail.get_r_id =  '$get_r_id' AND get_detail.del_flg = 0 AND get_d_conf = 0";
                    $result_get_count_track = mysqli_query($conn, $sql_get_count_track);
                    $result_get = mysqli_query($conn, $sql_get_c2);
                    $row_get_count_track = mysqli_fetch_array($result_get_count_track);

                    $sql_get_c = "SELECT * FROM get_detail
                                                                            LEFT JOIN tracking ON tracking.t_id = get_detail.get_t_id
                                                                            
                                                            LEFT JOIN company_transport ON  tracking.t_c_id = company_transport.com_t_id
                                                                            LEFT JOIN repair ON repair.r_id = get_detail.r_id
                                                                            WHERE get_detail.get_r_id =  '$get_r_id' AND get_detail.del_flg = 0";
                    $result_get_c = mysqli_query($conn, $sql_get_c);
                    while ($row_get_c = mysqli_fetch_array($result_get_c)) {
                        $repair_count++;
                    }
                    if ($repair_count > 0) {
                    ?>
                        <p><strong>รายการซ่อมทั้งหมด <?= $repair_count ?> รายการ </strong></p>
                    <?php
                    }
                    while ($row_get = mysqli_fetch_array($result_get)) {
                        $count_get_no++;
                    ?>
                        <div>
                            <?php if ($row_get['r_serial_number'] != NULL) { ?>
                                <p><strong>รายการที่ <?= $count_get_no ?> :</strong> <?= $row_get['r_brand'] ?> <?= $row_get['r_model'] ?> &nbsp; <strong>หมายเลขประจำเครื่อง / Serial Number : </strong><?= $row_get['r_serial_number'] ?></p>
                            <?php } ?>
                        </div>
                    <?php } ?>
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
                    repair_status.rs_id,
                    parts.p_pic;";
                            $result = mysqli_query($conn, $sql);
                            $part_total = 0;
                            $count_part = 0;
                            while ($row2 = mysqli_fetch_array($result)) {
                                $count_part++;
                                $p_id = $row2['p_id'];
                                $rs_id = $row2['rs_id'];
                                $sql_count = "SELECT * FROM repair_detail WHERE rs_id = '$rs_id' AND p_id = '$p_id'";
                                $result_count = mysqli_query($conn, $sql_count);
                                $row_count = mysqli_fetch_array($result_count);
                            ?>
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php
                                        if ($count_part == NULL) {
                                            echo "-";
                                        } else {
                                            echo $count_part;
                                        }
                                        ?>
                                    </td>

                                    <td><?php
                                        if ($row2['p_brand'] == NULL) {
                                            echo "-";
                                        } else {
                                            echo $row2['p_name'] . ' ' . $row2['p_brand'] . ' ' . $row2['p_model'] . ' ' . $row2['p_type_name'];
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
                                        if ($row2['p_price'] == NULL) {
                                            echo "-";
                                        } else {
                                            echo $row2['p_price'];
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php
                                        if ($row_count['rd_value_parts'] == NULL) {
                                            echo "-";
                                        } else {
                                            echo number_format($row_count['rd_value_parts'] * $row2['p_price']);
                                            $part_total += $row_count['rd_value_parts'] * $row2['p_price'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="2">ยอดอะไหล่ทั้งหมด</td>
                                <td colspan="2" style="text-align: right;">
                                    <strong>รวมเงิน (Sub Total)</strong>
                                </td>
                                <td style="text-align: center;"><?= number_format($part_total) ?></td>
                            </tr>
                            <?php
                            $sql_p = "SELECT get_deli , get_add_price, get_wages FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                            $result_p = mysqli_query($conn, $sql_p);
                            $row_p = mysqli_fetch_array($result_p);

                            if ($row_p['get_deli'] == 1) {
                                $shipping_cost = $row_p['get_add_price'];
                            ?>
                                <tr>
                                    <td colspan="2">ค่าจัดส่ง</td>
                                    <td colspan="2" style="text-align: right;">
                                        <strong> ราคาจัดส่ง (Shipping costs)</strong>
                                    </td>
                                    <td style="text-align: center;"><?= number_format($shipping_cost) ?></td>
                                </tr>
                            <?php
                            } ?>
                            <tr>
                                <?php
                                $sql_w = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                $result_w = mysqli_query($conn, $sql_w);
                                $row_w = mysqli_fetch_array($result_w);
                                // Calculate total amount
                                $total_amount = $part_total + $shipping_cost + $row_w['get_wages'];
                                ?>
                                <td colspan="2">ค่าแรงช่าง</td>
                                <td colspan="2" style="text-align: right;">
                                    <strong>ค่าแรง (Mechanic's wages)</strong>
                                </td>
                                <td style="text-align: center;"><?= number_format($row_w['get_wages']) ?></td>
                            </tr>
                            <?php
                            function convertToThaiBahtText($amount)
                            { {
                                    $thai_num_arr = array('', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
                                    $unit_arr = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
                                    $divisor = 100;
                                    $baht_text = '';
                                    $amount = number_format($amount, 2, '.', ''); // format ให้เป็นทศนิยมสองตำแหน่ง
                                    $amount_arr = explode('.', $amount); // แยกจำนวนเต็มกับทศนิยม

                                    $integer = $amount_arr[0];
                                    $integer_length = strlen($integer);

                                    // จำนวนเต็ม
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
                            }
                            // Convert total amount to Thai Baht text
                            $baht_text = convertToThaiBahtText($total_amount);
                            ?>
                            <tr>
                                <td colspan="2">
                                    <strong><?= $baht_text ?></strong>
                                </td>
                                <td colspan="2" style="text-align: right;">
                                    <strong>รวมเงินทั้งสิ้น (Total)</strong>
                                </td>
                                <td style="text-align: center;"><?= number_format($total_amount) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>


        </table>
    </div>

    <?php
    // $html = ob_get_contents();
    // $mpdf->WriteHTML($html);
    // $filename = date('Y-m-d') . ' - ใบแจ้งซ่อม_Report.pdf';
    // $filePath = __DIR__ . '/report/' . $filename;
    // $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
    // ob_end_flush();
    $html = ob_get_clean();
    $mpdf->WriteHTML('
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
            table {
                width: 100%;
            }
            .text-right {
                text-align: right!important;
            }
            .mb-2, .my-2 {
                margin-bottom: 0.5rem!important;
            }
            .table td, .table th {
                padding: 0.75rem;
                vertical-align: top;
                border-top: 1px solid #e3e6f0;
            }
        </style>
        ' . $html);

    $filename = date('Y-m-d') . ' - ใบแจ้งซ่อม_Report.pdf';
    $filePath = __DIR__ . '/report/' . $filename;
    $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

    echo $html; // แสดงข้อมูลในหน้าเว็บไซต์
    ?>

    <center class="my-5">
        <a href="detail_repair.php?id=<?= $row['get_r_id'] ?>" class="btn btn-primary">Back</a>
        <a href="report/<?= $filename ?>" style="text-align: end;"><button class="btn btn-primary" style="text-align: end;">Export PDF</button> </a>
    </center>
</body>

</html>
<!-- --------------------------ส่วนท้าย------------------------ -->
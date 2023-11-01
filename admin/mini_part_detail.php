<?php
include('../database/condb.php');
$id_get_r = $_GET['id'];
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

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>
    <br>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <br>
                    <h1 class="h3 mb-2 text-gray-800" style="display:inline-block">ข้อมูลอะไหล่ของคุณ</h1>
                    <!-- <a href="add_parts.php" style="display:inline-block; margin-left: 10px; position :relative">คุณต้องการเพิ่มอะไหล่หรือไม่?</a> -->
                    <br>
                    <br>

                    <div class="row">
                        <!-- DataTales Example -->
                        <?php
                        $sql_lastest = "SELECT * FROM `repair_status` WHERE del_flg = '0' AND get_r_id = '$id_get_r' ORDER BY rs_date_time DESC LIMIT 1";
                        $result_lastest = mysqli_query($conn, $sql_lastest);
                        $row_lastest = mysqli_fetch_array($result_lastest);
                        $status_id_last = $row_lastest['status_id'];
                        $have_17 = 0;
                        if ($row_lastest['status_id'] == 17) {
                            $sql_lastest = "SELECT * FROM `repair_status` WHERE del_flg = '0' AND get_r_id = '$id_get_r' AND (status_id = '13' OR status_id = '17') ORDER BY rs_date_time DESC LIMIT 1";
                            $result_lastest = mysqli_query($conn, $sql_lastest);

                            if (mysqli_num_rows($result_lastest)) {
                                $have_17 = 17;   // มีสถานะ 17

                                $sql_lastest1 = "SELECT rs_id FROM `repair_status` WHERE del_flg = '0' AND get_r_id = '$id_get_r' AND status_id = '13' OR status_id = '17' ORDER BY rs_date_time DESC LIMIT 1 OFFSET 1";
                                $result_lastest1 = mysqli_query($conn, $sql_lastest1);

                                $row_lastest1 = mysqli_fetch_array($result_lastest1);
                                $rs_id_update_17 = $row_lastest1['rs_id'];

                                // $sql_lastest_up = "UPDATE repair_detail SET del_flg = 0 WHERE rs_id = '$rs_id_update_17'";
                                // $result_lastest_up = mysqli_query($conn, $sql_lastest_up);
                            }
                        }

                        if ($status_id_last == 13 && $row_lastest['rs_conf'] == NULL || $have_17 == 17) {
                        ?>
                            <div class="col-md-6 <?php if ($status_id_last == 13 || $have_17 == 17) { ?> alert alert-primary  <?php  } ?>">
                                <div class="card shadow mb-4 ">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">ข้อมูลอะไหล่ใหม่ของอุปกรณ์</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>ลำดับ</th>
                                                        <th>หมายเลขอะไหล่</th>
                                                        <th>รหัสการซ่อม</th>
                                                        <th>ชื่อ</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>ประเภท</th>
                                                        <th>ราคา</th>
                                                        <th>จำนวน</th>
                                                        <th>ราคารวม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $totalPartPrice = 0;
                                                    $sqlParts = "SELECT
                                                                        repair_detail.p_id,
                                                                        MAX(repair_detail.p_id) AS rBrand,
                                                                        MAX(repair_detail.p_id) AS rModel,
                                                                        MAX(repair_detail.p_id) AS pId,
                                                                        MAX(repair_detail.rd_value_parts) AS rdValueParts,
                                                                        MAX(repair_detail.get_d_id) AS getDId,
                                                                        MAX(parts.p_brand) AS pBrand,
                                                                        MAX(parts.p_model) AS pModel,
                                                                        MAX(parts.p_price) AS pPrice,
                                                                        MAX(parts_type.p_type_name) AS pTypeName,
                                                                        MAX(repair_status.rs_id) AS rsId,
                                                                        MAX(parts.p_pic) AS pPic,
                                                                        MAX(repair.r_brand) AS rBrand,
                                                                        MAX(repair.r_model) AS rModel,
                                                                        MAX(repair.r_serial_number) AS rSerialNumber
                                                                    FROM
                                                                        `repair_detail`
                                                                        LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                                                                        LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
                                                                        LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                                                                        LEFT JOIN repair ON get_detail.r_id = repair.r_id
                                                                        JOIN parts ON parts.p_id = repair_detail.p_id
                                                                        LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id
                                                                    WHERE
                                                                        get_repair.del_flg = 0 AND repair_detail.del_flg = 0
                                                                        AND get_repair.get_r_id = '$get_id'  ";

                                                    if ($status_id_last == 13) {
                                                        $sqlCheckOffer = "SELECT * FROM repair_status WHERE get_r_id = '$get_id' AND status_id = 13 AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1";
                                                        $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                        if (mysqli_num_rows($resultOffer)) {
                                                            $rowOffer = mysqli_fetch_array($resultOffer);
                                                            $Offer_rs =  $rowOffer['rs_id'];
                                                            $sqlParts .=   " AND repair_status.rs_id = $Offer_rs ";
                                                        } else {
                                                            $sqlParts .=   " AND repair_status.status_id != 13 ";
                                                        }
                                                    }


                                                    if ($status_id_last == 17) {
                                                        $sqlCheckOffer = "SELECT * FROM repair_status WHERE get_r_id = '$get_id' AND status_id = 17 AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1";
                                                        $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                        if (mysqli_num_rows($resultOffer)) {
                                                            $rowOffer = mysqli_fetch_array($resultOffer);
                                                            $Offer_rs =  $rowOffer['rs_id'];
                                                            $sqlParts .=   " AND repair_status.rs_id = $Offer_rs ";
                                                        } else {
                                                            $sqlParts .=   " AND repair_status.status_id != 17 ";
                                                        }
                                                    }


                                                    $sqlParts .= "GROUP BY repair_detail.rd_id;";

                                                    $resultParts = mysqli_query($conn, $sqlParts);
                                                    $partCount = 0;
                                                    while ($rowParts = mysqli_fetch_array($resultParts)) {
                                                        $partCount++;
                                                        $pId = $rowParts['pId'];
                                                        $rsId = $rowParts['rsId'];
                                                    ?>
                                                        <?php
                                                        $sqlCount = "SELECT * FROM repair_detail WHERE rs_id = '$rsId' AND p_id = '$pId'";
                                                        $resultCount = mysqli_query($conn, $sqlCount);
                                                        $rowCount = mysqli_fetch_array($resultCount);
                                                        $getDId1 = $rowCount['get_d_id'];
                                                        $sqlRepair = "SELECT * FROM repair 
                                LEFT JOIN get_detail ON get_detail.r_id = repair.r_id
                                WHERE get_detail.get_d_id = '$getDId1'";
                                                        $resultRepair = mysqli_query($conn, $sqlRepair);
                                                        $rowGetD = mysqli_fetch_array($resultRepair);
                                                        ?>
                                                        <tr>
                                                            <td><?php
                                                                if ($partCount == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo $partCount;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php
                                                                if ($rowParts['pId'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo $rowParts['pId'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php
                                                                if ($rowParts['getDId'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo $rowParts['getDId'] . ' ' . $rowParts['rBrand'] . ' ' . $rowParts['rModel'] ?><h5><?= ' S/N :' . $rowParts['rSerialNumber'] ?></h5><?php
                                                                                                                                                                                                                }
                                                                                                                                                                                                                    ?>
                                                            </td>
                                                            <td><?php
                                                                if ($rowParts['pPic'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                ?>
                                                                    <img src="<?= $rowParts['pPic'] ?>" width="50px" alt="Not Found">
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php
                                                                if ($rowParts['pBrand'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo $rowParts['pBrand'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php
                                                                if ($rowParts['pModel'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo $rowParts['pModel'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php
                                                                if ($rowParts['pTypeName'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo $rowParts['pTypeName'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php
                                                                if ($rowParts['pPrice'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo $rowParts['pPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php
                                                                if ($rowParts['rdValueParts'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo $rowParts['rdValueParts'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($rowParts['pPrice'] == NULL) {
                                                                    echo "-";
                                                                } else {
                                                                    echo number_format($rowParts['rdValueParts'] * $rowParts['pPrice']);
                                                                    $totalPartPrice += $rowParts['rdValueParts'] * $rowParts['pPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="7">ยอดอะไหล่ทั้งหมด</td>
                                                        <td colspan="2">ราคารวม</td>
                                                        <td><?php $totalPartPrice = $totalPartPrice; ?><?= number_format($totalPartPrice) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        $sqlWages = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                        $resultWages = mysqli_query($conn, $sqlWages);
                                                        $rowWages = mysqli_fetch_array($resultWages);
                                                        ?>
                                                        <td colspan="7">ค่าแรงช่าง</td>
                                                        <td colspan="2">ค่าแรง</td>
                                                        <td><?= number_format($rowWages['get_wages']) ?></td>
                                                    </tr>
                                                    <?php
                                                    $sqlPrice = "SELECT get_deli , get_add_price FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                    $resultPrice = mysqli_query($conn, $sqlPrice);
                                                    $rowPrice = mysqli_fetch_array($resultPrice);

                                                    if ($rowPrice['get_deli'] == 1) {
                                                        $totalPartPrice += $rowPrice['get_add_price'];
                                                    ?>
                                                        <tr>
                                                            <td colspan="7">ค่าจัดส่ง</td>
                                                            <td colspan="2">ราคาจัดส่ง</td>
                                                            <td><?= number_format($rowPrice['get_add_price']) ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                    <tr>
                                                        <td colspan="7"></td>
                                                        <td colspan="2">ราคารวมทั้งหมด</td>
                                                        <td>
                                                            <h5><?= number_format($totalPartPrice + $rowWages['get_wages']) ?> </h5>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <?php
                        } ?>
                        <div class="col-md 
                                <?php if ($status_id_last == 13 || $have_17 == 17 && $row_lastest['rs_conf'] == NULL) { ?> alert alert-danger  <?php  } ?> ">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <?php
                                    // สถานะเกิดปัญหา
                                    if ($status_id_last == 13 || $have_17 == 17 && $row_lastest['rs_conf'] == NULL) {
                                    ?> <h6 class="m-0 font-weight-bold text-danger">ข้อมูลอะไหล่เก่าของอุปกรณ์</h6>
                                    <?php
                                    } else {
                                    ?> <h6 class="m-0 font-weight-bold text-primary">ข้อมูลอะไหล่อุปกรณ์ของคุณ</h6>
                                    <?php
                                    } ?>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>หมายเลขอะไหล่</th>
                                                    <th>รหัสการซ่อม</th>
                                                    <th>ชื่อ</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <!-- <th>Name</th> -->
                                                    <th>ประเภท</th>
                                                    <!-- <th>รายละเอียด</th> -->
                                                    <th>ราคา</th>
                                                    <th>จำนวน</th>
                                                    <th>ราคารวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total_part_price = 0;
                                                $sql_op = "SELECT
                                                                        repair_detail.p_id,
                                                                        MAX(repair_detail.p_id) AS r_brand,
                                                                        MAX(repair_detail.p_id) AS r_model,
                                                                        MAX(repair_detail.p_id) AS p_id,
                                                                        MAX(repair_detail.rd_value_parts) AS rd_value_parts,
                                                                        MAX(repair_detail.get_d_id) AS get_d_id,
                                                                        MAX(parts.p_brand) AS p_brand,
                                                                        MAX(parts.p_model) AS p_model,
                                                                        MAX(parts.p_price) AS p_price,
                                                                        MAX(parts_type.p_type_name) AS p_type_name,
                                                                        MAX(repair_status.rs_id) AS rs_id,
                                                                        MAX(parts.p_pic) AS p_pic,
                                                                        MAX(repair.r_brand) AS r_brand,
                                                                        MAX(repair.r_model) AS r_model
                                                                    FROM
                                                                        `repair_detail`
                                                                        LEFT JOIN repair_status ON repair_status.rs_id = repair_detail.rs_id
                                                                        LEFT JOIN get_repair ON repair_status.get_r_id = get_repair.get_r_id
                                                                        LEFT JOIN get_detail ON get_detail.get_r_id = get_repair.get_r_id
                                                                        LEFT JOIN repair ON get_detail.r_id = repair.r_id
                                                                        JOIN parts ON parts.p_id = repair_detail.p_id
                                                                        LEFT JOIN parts_type ON parts_type.p_type_id = parts.p_type_id
                                                                    WHERE
                                                                        get_repair.del_flg = 0 AND repair_detail.del_flg = 0
                                                                        AND get_repair.get_r_id = '$get_id' ";
                                                if ($status_id_last == 13) {
                                                    $sqlCheckOffer = "SELECT * FROM repair_status WHERE get_r_id = '$get_id' AND status_id = 13 OR status_id = 17 AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1 OFFSET 1";
                                                    $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                    if (mysqli_num_rows($resultOffer)) {
                                                        $rowOffer = mysqli_fetch_array($resultOffer);
                                                        $Offer_rs =  $rowOffer['rs_id'];
                                                        $sql_op .=   " AND repair_status.rs_id = '$Offer_rs' ";
                                                    } else {
                                                        $sql_op .=   " AND repair_status.status_id != 13 ";
                                                    }
                                                } elseif ($have_17 == 17) {
                                                    $sqlCheckOffer = "SELECT *
                                                            FROM repair_status
                                                            LEFT JOIN repair_detail ON repair_detail.rs_id = repair_status.rs_id
                                                            WHERE repair_status.get_r_id = '$get_id'
                                                            AND (repair_status.status_id = 17 OR repair_status.status_id = 13)
                                                            AND repair_status.del_flg = 0
                                                            AND repair_detail.del_flg = 0
                                                            ORDER BY repair_status.rs_id DESC
                                                            LIMIT 1 OFFSET 1;
                                                            ";
                                                    $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                    if (mysqli_num_rows($resultOffer)) {
                                                        $rowOffer = mysqli_fetch_array($resultOffer);
                                                        $Offer_rs =  $rowOffer['rs_id'];
                                                        $sql_op .=   " AND repair_status.rs_id = $Offer_rs ";
                                                    } else {
                                                        $sql_op .=   " AND repair_status.status_id != 13 ";
                                                    }
                                                }
                                                $sql_op .= "GROUP BY repair_detail.rd_id;";
                                                $result_op = mysqli_query($conn, $sql_op);
                                                $count_part = 0;
                                                while ($row_op = mysqli_fetch_array($result_op)) {

                                                    $count_part++;
                                                    $p_id = $row_op['p_id'];
                                                    $rs_id = $row_op['rs_id'];
                                                ?>
                                                    <?php

                                                    $sql_count = "SELECT * FROM repair_detail WHERE rs_id = '$rs_id' AND p_id = '$p_id'";
                                                    $result_count = mysqli_query($conn, $sql_count);
                                                    $row_count = mysqli_fetch_array($result_count);

                                                    $get_d_id1 = $row_count['get_d_id'];

                                                    $sql_repair = "SELECT * FROM repair 
                                                                        LEFT JOIN get_detail ON get_detail.r_id = repair.r_id
                                                                        WHERE get_detail.get_d_id = '$get_d_id1'";
                                                    $result_repair = mysqli_query($conn, $sql_repair);
                                                    $row_get_d = mysqli_fetch_array($result_repair);
                                                    ?>
                                                    <tr>
                                                        <td><?php
                                                            if ($count_part == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo $count_part . '  ' . $Offer_rs;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            if ($row_op['p_id'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo $row_op['p_id'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            if ($row_op['get_d_id'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo $row_op['get_d_id'] . ' '  . $row_get_d['r_brand'] . ' ' . $row_get_d['r_model'] ?><h5><?= ' S/N :' . $row_get_d['r_serial_number'] ?></h5><?php
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                        ?>
                                                        </td>

                                                        <td><?php
                                                            if ($row_op['p_pic'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                            ?>
                                                                <img src="<?= $row_op['p_pic'] ?>" width="50px" alt="Not Found">
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>


                                                        <!-- <td><?php
                                                                    if ($row_op['p_name'] == NULL) {
                                                                        echo "-";
                                                                    } else {
                                                                        echo $row_op['p_name'];
                                                                    }
                                                                    ?>
                                        </td> -->
                                                        <td><?php
                                                            if ($row_op['p_brand'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo $row_op['p_brand'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            if ($row_op['p_model'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo $row_op['p_model'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            if ($row_op['p_type_name'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo $row_op['p_type_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            if ($row_op['p_price'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo $row_op['p_price'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            if ($row_op['rd_value_parts'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo $row_op['rd_value_parts'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($row_op['p_price'] == NULL) {
                                                                echo "-";
                                                            } else {
                                                                echo number_format($row_op['rd_value_parts'] * $row_op['p_price']);
                                                                $total +=  $row_op['rd_value_parts'] * $row_op['p_price'];
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="7">ยอดอะไหล่ทั้งหมด</td>
                                                    <td colspan="2">ราคารวม</td>
                                                    <td><?php $total_part_price = $total; ?><?= number_format($total) ?></td>
                                                    <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                </tr>
                                                <tr>
                                                    <?php
                                                    $sql_w = "SELECT get_wages FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                    $result_w = mysqli_query($conn, $sql_w);
                                                    $row_w = mysqli_fetch_array($result_w);
                                                    ?>
                                                    <td colspan="7">ค่าแรงช่าง</td>
                                                    <td colspan="2">ค่าแรง</td>
                                                    <td><?= number_format($row_w['get_wages']) ?></td>
                                                    <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                </tr>
                                                <?php
                                                $sql_p = "SELECT get_deli , get_add_price FROM get_repair WHERE get_r_id = '$get_id' AND del_flg = '0'";
                                                $result_p = mysqli_query($conn, $sql_p);
                                                $row_p = mysqli_fetch_array($result_p);

                                                if ($row_p['get_deli'] == 1) {
                                                    $total += $row_p['get_add_price'];
                                                ?>
                                                    <tr>
                                                        <td colspan="7">ค่าจัดส่ง</td>
                                                        <td colspan="2">ราคาจัดส่ง</td>
                                                        <td><?= number_format($row_p['get_add_price']) ?></td>
                                                        <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                    </tr>
                                                <?php
                                                }
                                                ?>


                                                <tr>
                                                    <td colspan="7"></td>
                                                    <td colspan="2">ราคารวมทั้งหมด</td>
                                                    <td>
                                                        <h5><?= number_format($total + $row_w['get_wages']) ?> </h5>
                                                    </td>
                                                    <!-- <td><button type="button" class="btn btn-danger">ลบ</button>&nbsp; &nbsp;<button type="button" class="btn btn-warning" onclick="window.location.href='editsoundsystem.html'">แก้ไข</button></td> -->
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- End of Main Content -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
    </div>
</body>

</html>
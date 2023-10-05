<?php
session_start();
include('database/condb.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title></title>
</head>

<body>
  <div class="container-fluid">
    <br>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">รายได้การซ่อม</h6>
      </div>
      <div class="card-body">
        <form class="row g-3" method="get">
          <div class="col-auto">
            <h5 for="year" style="margin-top : 8px;">เลือกปี:</h5>
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
            <h5 for="month" style="margin-top : 8px;">ทั้งหมด:</h5>
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
          <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">ดูข้อมูล</button>
          </div>
        </form>
        <?php
        $selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y'); // Default to the current year if not specified
        $selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';

        if (empty($selectedMonth)) {
          echo '<h3>รายงานยอดซ่อมรายปี</h3>';
        } else {
          echo '<h3>รายงานยอดซ่อมรายเดือน</h3>';
        }
        ?>
        <table class="table table-striped table-bordered">
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

            function calculateTotal($month_totals)
            {
              $grand_total = 0;
              foreach ($month_totals as $totals) {
                $grand_total += $totals['total'];
              }
              return $grand_total;
            }

            if (empty($selectedMonth)) {
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
                  <?= number_format(calculateTotal($month_totals)) ?>
                </td>
              </tr>
            <?php
            } else {
              // เลือกแสดงข้อมูลเป็นรายวัน
            ?>
              <table class="table table-striped table-bordered">
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
                    <td colspan="3" style="font-weight: bold;">รวมทั้งสิ้น</td>
                    <td align="right" style="font-weight: bold;">
                      <?= number_format(calculateTotal($month_totals)) ?>
                    </td>
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
  </div>
</body>

</html>
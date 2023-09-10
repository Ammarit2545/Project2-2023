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
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3> PHP PDO SQL SUM : รายงานยอดขาย แยกเป็นรายเดือน</h3>
        <table class="table table-striped  table-hover table-responsive table-bordered">
          <thead>
            <tr>
              <th width="30%" class="text-center">เดือน</th>
              <th width="70%" class="text-center">รายได้</th>
            </tr>
          </thead>
          <tbody>
            <?php
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
              $month_name = $row_date['month_name'];
              if (!isset($month_totals[$month_name])) {
                $month_totals[$month_name] = 0;
              }
              $month_totals[$month_name] += $total;
            }

            // Loop through the associative array and display month totals
            foreach ($month_totals as $month_name => $total) {
            ?>
              <tr>
                <td><?= $month_name ?></td>
                <td align="right"><?= $total ?></td>
              </tr>
            <?php
            }
            ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>
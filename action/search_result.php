<?php
// Get the search term from the request
session_start();
include('../database/condb.php');
$search = $_GET['search'];
$id = $_SESSION["id"];

// Perform the search in the database and retrieve the results
// Replace this with your actual database query based on the search term
$sql = "SELECT
        get_repair.*,
        MAX(repair.m_id) AS m_id -- Assuming n_id is a column in the repair table
        FROM get_repair
        LEFT JOIN get_detail ON get_repair.get_r_id = get_detail.get_r_id
        LEFT JOIN repair ON get_detail.r_id = repair.r_id
        WHERE repair.m_id = '$id' AND get_repair.del_flg = 0 AND (
                repair.r_brand LIKE '%$search%'
                OR repair.r_model LIKE '%$search%'
                OR repair.r_serial_number LIKE '%$search%'
                OR repair.r_number_model LIKE '%$search%'
                OR get_repair.get_r_id LIKE '%$search%'
                OR CONCAT(repair.r_brand, ' ', repair.r_model) LIKE '%$search%'
                OR CONCAT(repair.r_brand, '', repair.r_model) LIKE '%$search%'
            )
        GROUP BY get_repair.get_r_id
        ORDER BY MAX(get_repair.get_r_date_in) DESC;";
$results = mysqli_query($conn, $sql);
// Format the results as HTML
$html = '<ul>';
foreach ($results as $result) {
    $html .= '<li>' . $result['name'] . '</li>';
}
$html .= '</ul>';

// Return the results as HTML
echo $html;

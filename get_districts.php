<?php
session_start();
include('database/condb.php');

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// ตรวจสอบการส่งค่า amphur_id มาจาก JavaScript
if (isset($_POST['amphur_id'])) {
    $amphurId = $_POST['amphur_id'];

    // สร้างคำสั่ง SQL สำหรับดึงข้อมูลตำบล
    $sql = "SELECT * FROM districts WHERE amphure_id = '$amphurId'";
    $result = mysqli_query($conn, $sql);

    // ตรวจสอบผลลัพธ์
    if (mysqli_num_rows($result) > 0) {
        // สร้างอาร์เรย์เพื่อเก็บข้อมูลตำบล
        $districts = array();

        // วนลูปผลลัพธ์และเก็บข้อมูลในอาร์เรย์
        while ($row = mysqli_fetch_assoc($result)) {
            $district = array(
                'id' => $row['id'],
                'name_th' => $row['name_th'],
                'zip_code' => $row['zip_code']
            );
            $districts[] = $district;
        }

        // ส่งข้อมูลตำบลเป็น JSON response
        echo json_encode($districts);
    } else {
        echo "ไม่พบข้อมูลตำบล";
    }
} else {
    echo "ไม่พบค่า amphur_id";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>

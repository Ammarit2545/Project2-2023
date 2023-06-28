<?php
session_start();
include('database/condb.php');

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// ตรวจสอบการส่งค่า province_id มาจาก JavaScript
if (isset($_POST['province_id'])) {
    $provinceId = $_POST['province_id'];

    // สร้างคำสั่ง SQL สำหรับดึงข้อมูลอำเภอ
    $sql = "SELECT * FROM amphures WHERE province_id = '$provinceId'";
    $result = mysqli_query($conn, $sql);

    // ตรวจสอบผลลัพธ์
    if (mysqli_num_rows($result) > 0) {
        // สร้างอาร์เรย์เพื่อเก็บข้อมูลอำเภอ
        $amphures = array();

        // วนลูปผลลัพธ์และเก็บข้อมูลในอาร์เรย์
        while ($row = mysqli_fetch_assoc($result)) {
            $amphure = array(
                'id' => $row['id'],
                'name_th' => $row['name_th']
            );
            $amphures[] = $amphure;
        }

        // ส่งข้อมูลอำเภอเป็น JSON response
        echo json_encode($amphures);
    } else {
        echo "ไม่พบข้อมูลอำเภอ";
    }
} else {
    echo "ไม่พบค่า province_id";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>

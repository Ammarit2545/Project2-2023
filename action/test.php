<?php
session_start();
include('../database/condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ': ' . $value . '<br>';
    }
}
print_r($_POST['p_id_22']);
print_r($_POST['value_p_22']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['get_d_id'])  &&  isset($_POST['p_id_1']) && is_array($_POST['p_id_1']) &&  isset($_POST['value_p_1']) && is_array($_POST['value_p_1'])) {
        
        for ($i = 0; $i < count($_POST['get_d_id']); $i++) {
            $get_d_id = $_POST['get_d_id'][$i];
            $p_id = $_POST['p_id_1'][$i];
            $value_p = $_POST['value_p_1'][$i];

            // ทำสิ่งที่คุณต้องการด้วยข้อมูลเหล่านี้
            // ยกตัวอย่าง: เพิ่มลงในฐานข้อมูลหรือทำการประมวลผล

            // แสดงค่าเพื่อตรวจสอบ
            echo "get_d_id: " . $get_d_id . "<br>";
            echo "p_id: " . $p_id . "<br>";
            echo "value_p: " . implode(", ", $value_p) . "<br>";
            echo "<hr>"; // เพิ่มเส้นคั่นระหว่างข้อมูลที่แสดง
        }
    } else {
        // แสดงข้อความข้อผิดพลาดหรือทำสิ่งอื่น ๆ ที่เหมาะสมถ้าข้อมูลไม่ถูกต้อง
        echo "ข้อมูลไม่ถูกต้อง";
    }
}
?>

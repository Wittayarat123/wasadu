<?php
include_once '../connections/mysqli.php';

isset($_GET['o_id']) ? $o_id = $_GET['o_id'] : $o_id = "";
$d_id = $_POST["d_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_date = $_POST["event_date"];
    $sql = "UPDATE order_detail SET d_time = '$event_date' WHERE d_id = $d_id";
    if ($Connection->query($sql) === TRUE) {
        echo '<script>alert("บันทึกวันจ่ายพัสดุแล้ว!!");window.location="receivedQuantity.php?o_id=' . $o_id . '";</script>';
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($Connection);
    }
}

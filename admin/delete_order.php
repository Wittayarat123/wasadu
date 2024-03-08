<?php
require_once('../connections/mysqli.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $o_id = $_GET['o_id'];

    $delete_query = "DELETE FROM order_detail WHERE o_id = $o_id";
    $delete_result = mysqli_query($Connection, $delete_query);
}

// ลบผู้ใช้จากฐานข้อมูล
$delete_query = "DELETE FROM order_head WHERE o_id = $o_id";
$delete_result = mysqli_query($Connection, $delete_query);



if ($delete_result) {
    echo '<script>alert("ลบใบเบิกสำเร็จ");window.location="status.php";</script>';
} else {
    echo '<script>alert("เกิดข้อผิดพลาดในการลบราการเบิก");window.location="status.php";</script>';
}

<?php
require_once('../connections/mysqli.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $w_id = $_GET['w_id'];

    // ลบผู้ใช้จากฐานข้อมูล
    $delete_query = "DELETE FROM tb_wasadu WHERE w_id = $w_id";
    $delete_result = mysqli_query($Connection, $delete_query);

    if ($delete_result) {
        echo '<script>alert("ลบสำเร็จ");window.location="show.php";</script>';
    } else {
        echo '<script>alert("เกิดข้อผิดพลาดในการลบ");window.location="show.php";</script>';
    }
}
?>



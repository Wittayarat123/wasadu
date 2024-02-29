<?php
require_once('../connections/mysqli.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_GET['user_id'];

    // ลบผู้ใช้จากฐานข้อมูล
    $delete_query = "DELETE FROM tb_user WHERE user_id = $user_id";
    $delete_result = mysqli_query($Connection, $delete_query);

    if ($delete_result) {
        echo '<script>alert("ลบผู้ใช้สำเร็จ");window.location="user.php";</script>';
    } else {
        echo '<script>alert("เกิดข้อผิดพลาดในการลบผู้ใช้");window.location="user.php";</script>';
    }
}
?>



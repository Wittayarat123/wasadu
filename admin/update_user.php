<?php
require_once('../connections/mysqli.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['user_username'];
    $password = $_POST['user_password'];

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // อัปเดตข้อมูลผู้ใช้ในฐานข้อมูล
    $update_query = "UPDATE tb_user SET user_username = '$username', user_password = '$hashed_password' WHERE user_id = $user_id";
    $update_result = mysqli_query($Connection, $update_query);

    if ($update_result) {
        echo '<script>alert("อัปเดตผู้ใช้สำเร็จ");window.location="user.php";</script>';
    } else {
        echo '<script>alert("เกิดข้อผิดพลาดในการอัปเดตผู้ใช้");window.location="user.php";</script>';
    }
}
?>

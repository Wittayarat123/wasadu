<?php
session_start();

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['Username']) || $_SESSION['Status'] != 'user') {
    header("Location: login.php");
    exit;
}

// หน้าเว็บสำหรับผู้ใช้ทั่วไป
?>

<!DOCTYPE html>
<html>
<head>
    <title>หน้าเว็บผู้ใช้ทั่วไป</title>
</head>
<body>
    <h2>ยินดีต้อนรับ <?php echo $_SESSION['Username']; ?></h2>
    <p>นี่คือหน้าเว็บสำหรับผู้ใช้ทั่วไป</p>
    <a href="logout.php">ออกจากระบบ</a>
</body>
</html>

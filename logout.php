<?php
session_start();
session_destroy();
header("location:index.php");

// print_r($_COOKIE);  // แสดง Cookies ทั้งหมดที่ php สามารถอ่านได้ 
// สร้าง Loop เพื่อ กำหนดให้ Cookies หมดอายุไป
foreach($_COOKIE as $k=>$v) {
	setcookie($k, "", time() - 3600); 
}  
?>

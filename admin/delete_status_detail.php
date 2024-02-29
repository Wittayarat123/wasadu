<?php
require_once('../connections/mysqli.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $d_id = $_GET['d_id'];
    $o_id = $_GET['o_id'];
    $w_id = $_GET['w_id'];
    $d_qty = $_GET['d_qty'];

    // // ดึงข้อมูลสต็อกปัจจุบันของพัสดุ
    // $current_stock_query = "SELECT w_quantity FROM tb_wasadu WHERE w_id = $w_id";
    // $current_stock_result = mysqli_query($Connection, $current_stock_query);
    // $current_stock_row = mysqli_fetch_assoc($current_stock_result);
    // $current_stock = $current_stock_row['w_quantity'];

    // // ตรวจสอบว่าสต็อกเพียงพอหรือไม่
    // // if ($current_stock < $qty) {
    // //     echo "สต็อกไม่เพียงพอ";
    // //     exit;
    // // }

    // // คำนวณสต็อกใหม่
    // $new_stock = $current_stock + $d_qty;

    // // อัปเดตสต็อกใหม่ในฐานข้อมูล
    // $update_query = "UPDATE tb_wasadu SET w_quantity = $new_stock WHERE w_id = $w_id";
    // $update_result = mysqli_query($Connection, $update_query);
    // ลบผู้ใช้จากฐานข้อมูล
$delete_query = "DELETE FROM order_detail WHERE d_id = $d_id";
$delete_result = mysqli_query($Connection, $delete_query);

}

// ลบผู้ใช้จากฐานข้อมูล
$delete_query = "DELETE FROM order_detail WHERE d_id = $d_id";
$delete_result = mysqli_query($Connection, $delete_query);

if ($delete_result) {
    echo '<script>alert("ลบสำเร็จ");window.location="status_detail.php?o_id=' . $o_id . '";</script>';
} else {
    echo '<script>alert("เกิดข้อผิดพลาดในการลบ");window.location="status_detail.php?o_id=' . $o_id . '";</script>';
}

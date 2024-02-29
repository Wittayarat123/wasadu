<?php
include_once('../connections/mysqli.php');

isset($_GET['w_id']) ? $id = $_GET['w_id'] : $id = "";
isset($_GET['w_price']) ? $w_price = $_GET['w_price'] : $w_price = "";
$data = $_POST;
// print_r($data);
$w_quantity = $data['w_quantity'];
$time_update = Date("Y-m-d h:i:s");

// ตรวจสอบว่าพัสดุนี้มีอยู่ในฐานข้อมูลหรือไม่
$item_query = "SELECT * FROM tb_wasadu WHERE w_id = $id";
$item_result = mysqli_query($Connection, $item_query);

if (mysqli_num_rows($item_result) === 0) {
    echo "ไม่พบพัสดุที่ระบุ";
    exit;
}

$update_query1 = "INSERT INTO 
update_stock (
    `w_id`,
    `w_quantity`,
    `time_update`,
    `w_price`
) VALUES (
    '$id',
    '$w_quantity',
    '$time_update',
    '$w_price'
)";
$update_result1 = mysqli_query($Connection, $update_query1);

// ดึงข้อมูลสต็อกปัจจุบันของพัสดุ
$current_stock_query = "SELECT w_quantity FROM tb_wasadu WHERE w_id = $id";
$current_stock_result = mysqli_query($Connection, $current_stock_query);
$current_stock_row = mysqli_fetch_assoc($current_stock_result);
$current_stock = $current_stock_row['w_quantity'];

// คำนวณสต็อกใหม่
$new_stock = $current_stock + $w_quantity;

// อัปเดตสต็อกใหม่ในฐานข้อมูล
$update_query = "UPDATE tb_wasadu SET w_quantity = $new_stock WHERE w_id = $id";
$update_result = mysqli_query($Connection, $update_query);

if ($update_result) {
    echo '<script>window.location="show.php?w_id&do=ok";</script>';
} else {
    echo '<script>alert("เกิดข้อผิดพลาดในการอัปเดตสต็อก!!");window.location="show.php?w_id=' . $id . '";</scriptwindow.location=>';
}

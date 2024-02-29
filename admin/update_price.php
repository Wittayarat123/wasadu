<?php
include_once '../connections/mysqli.php';

// isset($_POST['o_id']) ? $id = $_POST['o_id'] : $id = "";
// isset($_POST['d_id']) ? $d_id = $_POST['d_id'] : $d_id = "";
// isset($_POST['d_spend']) ? $d_spend = $_POST['d_spend'] : $d_spend = "";
// $data = $_POST;
// print_r($data);
// $d_spend = $data['d_spend'];
isset($_GET['d_id']) ? $d_id = $_GET['d_id'] : $d_id = "";
isset($_GET['o_id']) ? $o_id = $_GET['o_id'] : $o_id = "";
isset($_GET['w_id']) ? $w_id = $_GET['w_id'] : $w_id = "";

$d_price = $_POST["d_price"];
$d_time = Date("Y-m-d h:i:s");

// ดึงข้อมูลสต็อกปัจจุบันของพัสดุ
// $current_stock_query1 = "SELECT w_quantity FROM tb_wasadu WHERE w_id = $w_id";
// $current_stock_result1 = mysqli_query($Connection, $current_stock_query1);
// $current_stock_row1 = mysqli_fetch_assoc($current_stock_result1);
// $current_stock1 = $current_stock_row1['w_quantity'];

// คำนวณสต็อกใหม่
// $new_stock1 = $current_stock1 - $d_price;

// อัปเดตสต็อกใหม่ในฐานข้อมูล
// $update_query = "UPDATE tb_wasadu SET w_quantity = $new_stock1 WHERE w_id = $w_id";
// $update_result = mysqli_query($Connection, $update_query);

// // ดึงข้อมูลสต็อกปัจจุบันของพัสดุ
// $current_stock_query = "SELECT o_id, d_id, d_price FROM order_detail WHERE o_id = $o_id AND d_id = $d_id ";
// $current_stock_result = mysqli_query($Connection, $current_stock_query);
// $current_stock_row = mysqli_fetch_assoc($current_stock_result);
// $current_stock = $current_stock_row['d_price'];

// // คำนวณสต็อกใหม่
// $new_stock = $current_stock - $d_price;

$strSQL = " UPDATE order_detail SET 
                o_id = '$o_id' ,
                d_id = '$d_id' ,
                d_price = '$d_price' , 
                d_time = '$d_time'  
            WHERE  o_id = $o_id AND d_id = $d_id ";

if (mysqli_query($Connection, $strSQL)) {
    echo '<script>alert("บันทึกการแก้ไขแล้ว!!");window.location="receivedQuantity.php?o_id=' . $o_id . '";</script>';
    // echo "อัปเดตข้อมูลสำเร็จ";
} else {
    echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($Connection);
}

    // $objQuery = mysqli_query($Connection, $strSQL);
    // if ($objQuery) {
    //     echo '<script>alert("บันทึกการแก้ไขแล้ว");window.location="status.php";</script>';
    //     echo '<script>alert("พบข้อผิดพลาด!!");window.location="receivedQuantity.php?new_id=' . $o_id . '";</script>';
    // }

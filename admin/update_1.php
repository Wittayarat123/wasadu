<?php
include_once '../connections/mysqli.php';

// isset($_POST['o_id']) ? $id = $_POST['o_id'] : $id = "";
// isset($_POST['d_id']) ? $d_id = $_POST['d_id'] : $d_id = "";
// isset($_POST['d_spend']) ? $d_spend = $_POST['d_spend'] : $d_spend = "";
// $data = $_POST;
// print_r($data);
// $d_spend = $data['d_spend'];
$d_id = $_POST["d_id"];
$o_id = $_POST["o_id"];
$w_id = $_POST["w_id"];
$d_qty = $_POST["d_qty"];
$d_subtotal = $_POST["d_subtotal"];
$d_spend = $_POST["d_spend"];
$d_time = Date("Y-m-d h:i:s");

$strSQL = " INSERT INTO 
tb_pay_detail (
    `d_id`,
    `o_id`,
    `w_id`,
    `d_qty`,
    `d_subtotal`,
    `d_spend`,
    `d_time`
) VALUES (
    '$d_id',
    '$o_id',
    '$w_id',
    '$d_qty',
    '$d_subtotal',
    '$d_spend',
    '$d_time'
)";

if (mysqli_query($Connection, $strSQL)) {
//             echo '<script>alert("บันทึกการแก้ไขแล้ว!!");window.location="receivedQuantity.php?o_id=' . $o_id . '";</script>';
//     // echo "อัปเดตข้อมูลสำเร็จ";
// } else {
//     echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($Connection);
}

    // $objQuery = mysqli_query($Connection, $strSQL);
    // if ($objQuery) {
    //     echo '<script>alert("บันทึกการแก้ไขแล้ว");window.location="status.php";</script>';
    //     echo '<script>alert("พบข้อผิดพลาด!!");window.location="receivedQuantity.php?new_id=' . $o_id . '";</script>';
    // }

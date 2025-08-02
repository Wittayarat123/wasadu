<?php
include_once('../connections/mysqli.php');

$data = $_POST;
//print_r($data);
$o_id = $data['o_id'];
$w_id = $data['w_id'];
$d_qty = $data['d_qty'];
$d_subtotal = $data['d_subtotal'];
$d_spend = $data['d_spend'];
$d_time = $data['d_time'];
$d_price = 'd_price';
//default value

$strSQL = " INSERT INTO 
order_detail (
    `o_id`,
    `w_id`,
    `d_qty`,
    `d_subtotal`,
    `d_spend`,
    `d_time`,
    `d_price`
) VALUES (
    '$o_id',
    '$w_id',
    '$d_qty',
    '$d_subtotal',
    '$d_spend',
    '$d_time',
    '$d_price'
)";

$objQuery = mysqli_query($Connection, $strSQL) or die(mysqli_error($Connection));
if ($objQuery) {
    echo '<script>window.location="status_detail.php?o_id=' . $o_id . '";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด");window.location="status_detail.php?o_id=' . $o_id . '";</script>';
}

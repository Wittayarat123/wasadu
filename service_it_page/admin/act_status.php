<?php
include_once('../../connections/mysqli.php');

isset($_GET['rp_id']) ? $id = $_GET['rp_id'] : $id = "rp_id";
$data = $_POST;
// print_r($data);
$rs_id = $data['rs_id'];

// อัปเดตในฐานข้อมูล
$sql = "UPDATE rp_repair SET rs_id = $rs_id WHERE rp_id = $id";

$update_result = mysqli_query($Connection, $sql);

if ($update_result) {
    echo '<script>window.location="admin_status.php?rp_id&do=ok";</script>';
} else {
    echo '<script>alert("เกิดข้อผิดพลาดในการอัปเดต!!");window.location="admin_status.php?rp_id=' . $id . '";</scriptwindow.location=>';
}

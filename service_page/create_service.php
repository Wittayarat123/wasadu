<?php
include_once('../connections/mysqli.php');

$data = $_POST;
// print_r($data);
$leave_type_id = $data['leave_type_id'];
$el_head = $data['el_head'];
$user_id = $data['user_id'];
$user_name_1 = $data['user_name_1'];
$el_position = $data['el_position'];
$el_detail = $data['el_detail'];
$el_day = $data['el_day'];
$el_time_1 = Date("Y-m-d");
$el_time_2 = Date("Y-m-d");
$el_contact = $data['el_contact'];
$el_status = '1';

// default value

$strSQL = " INSERT INTO 
        el_leave(
        `leave_type_id`, 
        `el_head`, 
        `user_id`,
        `user_name_1`, 
        `el_position`, 
        `el_detail`, 
        `el_day`, 
        `el_time_1`,
        `el_time_2`,
        `el_contact`,
        `el_status`
) VALUES (
        '$leave_type_id'
        ,'$el_head'
        ,'$user_id'
        ,'$user_name_1'
        ,'$el_position'
        ,'$el_detail'
        ,'$el_day'
        ,'$el_time_1'
        ,'$el_time_2'
        ,'$el_contact'
        ,'$el_status')";

$result= mysqli_query($Connection, $strSQL);
if ($result) {
    echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="service.php?el_id&do=ok";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด");window.location="service.php";</script>';
}

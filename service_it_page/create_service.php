<?php
include_once('../connections/mysqli.php');

$data = $_POST;
// print_r($data);
$rp_name = $data['rp_name'];
$a_id = $data['a_id'];
$rp_type = $data['rp_type'];
$rp_detail = $data['rp_detail'];
$rp_date = Date("Y-m-d G:i:s");
$user_id = $data['user_id'];
$rp_img = '';
$rs_id = '1';
// default value

$output_dir = './it_img/'; // folder รูปปก
if (!is_array($_FILES["rp_img"]["name"])) {
    $exts = explode('.', $_FILES["rp_img"]["name"]);
    $ext = $exts[count($exts) - 1]; // get ext image ex. jpeg, jpg, png
    $fileName = basename($_FILES["rp_img"]["name"]);
    if (file_exists($output_dir . $fileName)) {
        $fileName = $fileName = date("YmdHis") . $ext;
    }
    $rp_img = $fileName; // set image value
    @move_uploaded_file($_FILES["rp_img"]["tmp_name"], $output_dir . '/' . $fileName);
}
$strSQL = " INSERT INTO 
        rp_repair(
        `rp_name`, 
        `user_id`, 
        `a_id`, 
        `rp_type`, 
        `rp_detail`, 
        `rp_img`, 
        `rp_date`,
        `rs_id`
) VALUES (
        '$rp_name'
        ,'$user_id'
        ,'$a_id'
        ,'$rp_type'
        ,'$rp_detail'
        ,'$rp_img'
        ,'$rs_id'
        ,'$rp_date')";

$objQuery = mysqli_query($Connection, $strSQL);
if ($objQuery) {
    echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="service.php?rp_id&do=ok";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด");window.location="service.php";</script>';
}

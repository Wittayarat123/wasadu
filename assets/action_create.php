<?php
include_once('../connections/mysqli.php');

$data = $_POST;
//print_r($data);
$w_name = $data['w_name'];
$c_id = $data['c_id'];
$w_price = $data['w_price'];
$w_brand = $data['w_brand'];
$w_detail = $data['w_detail'];
$w_quantity = $data['w_quantity'];
$w_img = '';
//default value

$output_dir = '../assets/img_w/'; // folder
if (!is_array($_FILES["w_img"]["name"])) {
    $exts = explode('.', $_FILES["w_img"]["name"]);
    $ext = $exts[count($exts) - 1]; // get ext image ex. jpeg, jpg, png
    $fileName = basename($_FILES["w_img"]["name"]);
    if (file_exists($output_dir . $fileName)) {
        $fileName = $fileName = date("YmdHis") . $ext;
    }
    $w_img = $fileName; // set image value
    @move_uploaded_file($_FILES["w_img"]["tmp_name"], $output_dir . '/' . $fileName);
}

$strSQL = " INSERT INTO 
tb_wasadu (
    `w_name`,
    `c_id`,
    `w_price`,
    `w_brand`,
    `w_detail`,
    `w_quantity`,
    `w_img`
) VALUES (
    '$w_name',
    '$c_id',
    '$w_price',
    '$w_brand',
    '$w_detail',
    '$w_quantity',
    '$w_img'
)";

$objQuery = mysqli_query($Connection, $strSQL) or die(mysqli_error($Connection));
if ($objQuery) {
    echo '<script>window.location="show.php?w_id&do=ok";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด");window.location="show.php";</script>';
}

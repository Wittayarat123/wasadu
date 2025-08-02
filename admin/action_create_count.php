<?php
include_once('../connections/mysqli.php');

$data = $_POST;
// print_r($data);
$c_name = $data['c_name'];
 // default value

$strSQL = "INSERT INTO 
tb_count(
    `c_name`
) VALUES (
    '$c_name'
)";

$objQuery = mysqli_query($Connection, $strSQL) or die(mysqli_error($Connection));
if ($objQuery) {
    echo '<script>window.location="add_detail_count.php?c_id&do=ok";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด");window.location="add_detail_count.php?c_id&do=notok";</script>';
}

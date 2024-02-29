<?php
include_once('../connections/mysqli.php');

$data = $_POST;
// print_r($data);
$a_name = $data['a_name'];
// default value

$strSQL = "INSERT INTO 
tb_agency(
    `a_name`
) VALUES (
    '$a_name'
)";

$objQuery = mysqli_query($Connection, $strSQL) or die(mysqli_error($Connection));
if ($objQuery) {
    echo '<script>window.location="add_detail_agency.php?a_id&do=ok";</script>';
} else {
    echo '<script>window.location="add_detail_agency.php?a_id&do=notok";</script>';
}

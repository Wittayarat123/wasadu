<?php
require_once('../connections/mysqli.php');

    // ไฟล์ delete.php
    isset( $_GET['a_id'] ) ? $id = $_GET['a_id'] : $id = "";
    if( !empty( $id ) ) {
        mysqli_query( $Connection, "SET NAMES UTF8" );

        $sql = " DELETE FROM tb_agency WHERE ( a_id = '{$id}' ) ";
        if( mysqli_query( $Connection, $sql ) ) {
        echo '<script>window.location="add_detail_agency.php?a_id&do=okok";</script>';
    } else {
        echo '<script>window.location="add_detail_agency.php?a_id&do=notok";</script>';

        mysqli_close( $Connection );
    }
}

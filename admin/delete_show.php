<?php
require_once('../connections/mysqli.php');

    // ไฟล์ delete.php
    isset( $_GET['w_id'] ) ? $id = $_GET['w_id'] : $id = "";
    if( !empty( $id ) ) {
        mysqli_query( $Connection, "SET NAMES UTF8" );

        $sql = " DELETE FROM tb_wasadu WHERE ( w_id = '{$id}' ) ";
        if( mysqli_query( $Connection, $sql ) ) {
        echo '<script>window.location="show.php?w_id&do=okok";</script>';
    } else {
        echo '<script>window.location="show.php?w_id&do=notok";</script>';

        mysqli_close( $Connection );
    }
}

<?php
require_once('../connections/mysqli.php');

session_start();

if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
} elseif ($_SESSION["user_level"] != "admin") {
    header("location:../index.php");
    exit();
}
?>

<?PHP //เปลี่ยนสถานะ
   if($_GET["Action"] == "Change"){

   $o_id = $_GET['o_id'];

   $sql = "SELECT * FROM order_head WHERE o_id = '$o_id'";
   $result = mysqli_query($Connection, $sql);
   $row1 = mysqli_fetch_array($result);

   if($row1['s_id'] == "0"){ // ถ้า = รออนุมัติ
        $s_id = 1; // ให้เปลี่ยนเป็น อนุมัติ
   }elseif ($row1['s_id'] == "2"){ // ถ้า = ไม่อนุมัติ
        $s_id = 0; // ให้เปลี่ยนเป็น รออนุมัติ
   }elseif ($row1['s_id'] == "1"){ // ถ้า = อนุมัติ
        $s_id = 0; // ให้เปลี่ยนเป็น รออนุมัติ
   }else{
        $s_id = 0; // ให้เปลี่ยนเป็น รออนุมัติ
   }
   $sql = "UPDATE order_head SET s_id = '$s_id' WHERE o_id = '$o_id'";
   $result = mysqli_query($Connection, $sql);
   }
    echo '<script>window.location="status.php";</script>';

?>
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

   $w_id = $_GET['w_id'];

   $sql = "SELECT * FROM tb_wasadu WHERE w_id = '$w_id'";
   $result = mysqli_query($Connection, $sql);
   $row1 = mysqli_fetch_array($result);

   if($row1['w_status'] == "1"){
        $w_status = 2;
   }elseif ($row1['w_status'] == "2"){
        $w_status = 1;
   }
   $sql = "UPDATE tb_wasadu SET w_status = '$w_status' WHERE w_id = '$w_id'";
   $result = mysqli_query($Connection, $sql);
   }
    echo '<script>window.location="show.php";</script>';

?>
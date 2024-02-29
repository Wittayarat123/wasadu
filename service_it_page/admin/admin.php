<?php
require_once('../../connections/mysqli.php');

session_start();

if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
} elseif ($_SESSION["user_level"] != "admin") {
    header("location:../index.php");
    exit();
}
?>

<style>
    .container {
        width: 100%;
        min-height: 92.5vh;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 15px;
        /* background: #9053c7;
            background: -webkit-linear-gradient(-135deg, #c850c0, #4158d0);
            background: -o-linear-gradient(-135deg, #c850c0, #4158d0);
            background: -moz-linear-gradient(-135deg, #c850c0, #4158d0);
            background: linear-gradient(-135deg, #c850c0, #4158d0);
            background-image: "admin/img/rainbow-vortex.png"; */
        /* background-image: url("../assets/images/banner.jpg");
      background-repeat: no-repeat;
      background-size: cover; */
    }

    .wrap-login101 {
        width: 960px;
        background: rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(0px);
        -webkit-backdrop-filter: blur(0px);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 10px;
        overflow: hidden;

        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 100px 130px 100px 130px;
    }
</style>

<?php include '../../includes/navbar_service_it_admin.php'; ?>

<div class="container">
    <div class="animate-bottom">
        <div class="wrap-login101">
            <h1>Admin ระบบแจ้งซ่อมIT&nbsp;&nbsp;โรงพยาบาลวังเจ้า</h1>
        </div>
    </div>
</div>
</div>

<?php include '../../includes/footer_service_it_admin.php'; ?>
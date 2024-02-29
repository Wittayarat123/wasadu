<?php
require_once('connections/mysqli.php');

session_start();

$check_submit = "";
$user_username = "";

if (isset($_POST["submit"])) {
  $strSQL = "SELECT * FROM tb_user WHERE user_username = '" . mysqli_real_escape_string($Connection, $_POST['user_username']) . "' and user_password = '" . mysqli_real_escape_string($Connection, md5($_POST['user_password'])) . "'";
  $objQuery = mysqli_query($Connection, $strSQL);
  $objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);

  if (!$objResult) {
    $user_username = $_POST['user_username'];
    $check_submit = '<div class="alert alert-danger" role="alert">';
    $check_submit .= '<span><i class="fa fa-exclamation"></i> ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบใหม่อีกครั้ง</span>';
    $check_submit .= '</div>';
  } else {
    $_SESSION["user_username"] = $objResult["user_username"];
    $_SESSION["user_level"] = $objResult["user_level"];

    header("location:homepage.php?user_id&do=ok");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $title; ?></title>
  <link href="assets/images/BG.png" rel="icon">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/main.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
</head>

<style>
  .default {
    background-image: url("assets/images/banner.jpg");
    background-repeat: no-repeat;
    background-size: cover;
  }

  .container {
    width: 100%;
    min-height: 100vh;
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
    /* background-image: url("assets/images/banner.jpg");
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

  /* Add animation to "page content" */
  .animate-bottom {
    position: relative;
    -webkit-animation-name: animatebottom;
    -webkit-animation-duration: 1s;
    animation-name: animatebottom;
    animation-duration: 1s
  }

  @-webkit-keyframes animatebottom {
    from {
      bottom: -100px;
      opacity: 0
    }

    to {
      bottom: 0px;
      opacity: 1
    }
  }

  @keyframes animatebottom {
    from {
      bottom: -100px;
      opacity: 0
    }

    to {
      bottom: 0;
      opacity: 1
    }
  }
</style>

<body class="default">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-auto"><?php echo $check_submit; ?></div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-xxl-6">
        <div class="row justify-content-md-center mb-2">
          <div class="animate-bottom">
            <div class="wrap-login101">
              <div class="col col-lg-12">
                <h1 class="d-flex justify-content-center mx-auto mb-4"><b>โรงพยาบาลวังเจ้า</b></h1>
              </div>
              <div class="col col-lg-6">
                <img src="assets/images/login.png">
              </div>
              <div class="col col-lg-6">
                <form method="post">
                  <div class="form-group">
                    <label>ชื่อผู้ใช้</label>
                    <!-- &nbsp;<font color='red'>(&nbsp;admin&nbsp;,&nbsp;user01&nbsp;)</font> -->
                    <input type="text" class="form-control" name="user_username" value="<?php echo $user_username; ?>" placeholder="Enter Username" required="" />
                  </div>
                  <div class="form-group">
                    <label>รหัสผ่าน</label>
                    <!-- &nbsp;<font color='red'>(&nbsp;1234&nbsp;)</font> -->
                    <input type="password" class="form-control" name="user_password" placeholder="Enter Password" required="" />
                  </div>
                  <button type="submit" class="btn btn-success" name="submit">เข้าสู่ระบบ</button>
                  <a class="btn btn-warning" href="register.php" role="button">สมัครสมาชิก</a>                  
                </form>
              </div>
              <div class="d-flex justify-content-center mx-auto">
                <a href="User.pdf" class="btn btn-primary btn-sm" target="_blank">คู่มือการใช้งานระบบพัสดุ</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'includes/footer_user.php'; ?>
  <script type="text/javascript" src="assets/jquery/jquery-slim.min.js"></script>
  <script type="text/javascript" src="assets/popper/popper.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <?php mysqli_close($Connection); ?>


</body>

</html>



<?php
if (isset($_GET["register"])) {
  if ($_GET["register"] == "success") {
?>
    <script type="text/javascript">
      alert("สมัครสมาชิกสำเร็จแล้ว เข้าสู่ระบบได้เลย");
    </script>
<?php
  }
}
?>
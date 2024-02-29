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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $title; ?></title>
  <link href="../assets/images/BG.png" rel="icon">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/main.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">

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

</head>

<body class="default">
  <?php include '../includes/navber_admin.php'; ?>
  <div class="container">
    <div class="wrap-login101">

      <h1 class="display-4">Hello, Admin!</h1>

    </div>
  </div>

  <?php mysqli_close($Connection); ?>

<?php include '../includes/footer_admin.php' ; ?>

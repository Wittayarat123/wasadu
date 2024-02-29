<?php
require_once('connections/mysqli.php');

session_start();

if ($_SESSION == NULL) {
  header("location:login.php");
  exit();
}

$strSQL = " SELECT * FROM tb_user u 
            LEFT JOIN tb_agency a ON a.a_id = u.a_id 
            WHERE user_username = '" . $_SESSION['user_username'] . "'";
$objQuery = mysqli_query($Connection, $strSQL);
$objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);
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

<?php include 'includes/navbar_user.php'; ?>

<body class="sidebar-mini layout-fixed" style="height: auto;">
  <div class="wrapper">

    <div class="container-fluid mt-5">
      <div class="row justify-content-md-center">
        <div class="col-md-6">
          <div class="card border-dark mt-4">
            <div class="card-header bg-info">
              <h3 class="card-title"><i class="fa fa-address-card fa-lg"></i> ข้อมูลส่วนตัวของฉัน</h5>
              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <h4>ชื่อผู้ใช้ : <span class="badge badge-info"><?php echo $objResult["user_username"]; ?></span></h4>
              <h4>ชื่อ - นามสกุล : <span class="badge badge-info"><?php echo $objResult["user_name"] . " " . $objResult["user_surname"]; ?></span></h4>
              <h4>เพศ :
                <?php
                if ($objResult["user_sex"] == NULL) {
                ?>
                  <span class="badge badge-danger">ว่าง</span>
                <?php
                } else {
                ?>
                  <span class="badge badge-info"><?php echo $objResult["user_sex"]; ?></span>
                <?php
                }
                ?>
                <!-- <span class="badge badge-info"><?php echo $objResult["user_sex"]; ?></span></h4> -->
                <h4>ตำแหน่ง : <span class="badge badge-info"><?php echo $objResult["position"]; ?></span></h4>
                <h4>หน่วยงาน : <span class="badge badge-info"><?php echo $objResult["a_name"]; ?></span></h4>
                <h4>อีเมล์ :
                  <?php
                  if ($objResult["user_email"] == NULL) {
                  ?>
                    <span class="badge badge-danger">ว่าง</span>
                  <?php
                  } else {
                  ?>
                    <span class="badge badge-info"><?php echo $objResult["user_email"]; ?></span>
                  <?php
                  }
                  ?>
                </h4>
                <h4>ระดับผู้ใช้ : <span class="badge badge-info"><?php if ($objResult["user_level"] == "member") {
                                                                    echo "สมาชิก";
                                                                  } else {
                                                                    echo "ผู้ดูแลระบบ";
                                                                  } ?></span></h4>
                <hr>
                <a href='edit_profile.php?user_id=<?php echo $objResult["user_id"] ?>'><button type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>แก้ไขข้อมูล</button></a>
                <!-- <a href='#'><button type="button" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>เปลี่ยนรหัสผ่าน</button></a> -->
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <?php include 'includes/footer_user.php'; ?>
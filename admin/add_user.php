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

$check_submit = "";
$user_username = "";
$user_name = "";
$user_surname = "";
$user_email = "";
$a_id = "";
$user_level = "member";

if (isset($_POST["submit"])) {
  $strSQL = "SELECT * FROM tb_user WHERE user_username = '" . trim($_POST['user_username']) . "'";
  $objQuery = mysqli_query($Connection, $strSQL);
  $objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);

  $user_username = $_POST["user_username"];
  $user_name = $_POST["user_name"];
  $user_surname = $_POST["user_surname"];
  $user_email = $_POST["user_email"];
  $a_id = $_POST["a_id"];
  $user_level = "member";

  if ($objResult) {
    $check_submit = '<div class="alert alert-danger" role="alert">';
    $check_submit .= '<span><i class="fa fa-exclamation"></i> ชื่อผู้ใช้นี้คนอื่นใช้แล้ว กรอกชื่อผู้ใช้ใหม่</span>';
    $check_submit .= '</div>';
  } else {
    $strSQL = "INSERT INTO tb_user (user_username,user_password,user_name,user_surname,user_sex,user_email,a_id,user_level) 
    VALUES ('" . $_POST["user_username"] . "','" . md5($_POST["user_password"]) . "','" . $_POST["user_name"] . "','" . $_POST["user_surname"] . "','" . $_POST["user_sex"] . "','" . $_POST["user_email"] . "','" . $_POST["a_id"] . "','" . $user_level . "')";
    $objQuery = mysqli_query($Connection, $strSQL);

    header("location:user.php");
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
  <link href="../assets/images/BG.png" rel="icon">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/main.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
</head>

<body class="default">
<?php include'../includes/navber_admin.php' ?>

  <div class="container-fluid">
    <div class="col-md-12 mt-4">
      <div class="row justify-content-md-center">
        <div class="col-md-auto"><?php echo $check_submit; ?></div>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-5">
        <div class="card border-dark mt-2">
          <h5 class="card-header">Register System</h5>
          <div class="card-body">
            <div class="row justify-content-md-center mb-2">
              <div class="col col-lg-6">
                <img src="../assets/images/register.png" style="width: 100%;">
              </div>
            </div>
            <form method="post">
              <div class="form-group">
                <label>ชื่อผู้ใช้</label>
                <input type="text" class="form-control" name="user_username" value="<?php echo $user_username; ?>" placeholder="Username" required="" />
              </div>
              <div class="form-group">
                <label>รหัสผ่าน</label>
                <input type="password" class="form-control" name="user_password" placeholder="Password" required="" />
              </div>
              <div class="form-group">
                <label>ชื่อ</label>
                <input type="text" class="form-control" name="user_name" value="<?php echo $user_name; ?>" placeholder="Name" required="" />
              </div>
              <div class="form-group">
                <label>นามสกุล</label>
                <input type="text" class="form-control" name="user_surname" value="<?php echo $user_surname; ?>" placeholder="Surname" required="" />
              </div>
              <div class="form-group">
                <label>เพศ</label>
                <select class="form-control" name="user_sex">
                  <option value="ชาย">ชาย</option>
                  <option value="หญิง">หญิง</option>
                </select>
              </div>
              <div class="form-group">
                <label>หน่วยงาน</label>
                <select class="form-control" name="a_id">
                  <option value="">เลือกหน่วยงาน</option>
                  <?php
                  $strSQL = "SELECT * FROM tb_agency ORDER BY a_id ASC";
                  $objQuery = mysqli_query($Connection, $strSQL);
                  while ($row = mysqli_fetch_array($objQuery)) {
                  ?>
                    <option value="<?php echo $row["a_id"]; ?>"><?php echo $row["a_name"]; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>อีเมล์</label>
                <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>" placeholder="Email" required="" />
              </div>
              <button type="submit" class="btn btn-success" name="submit">เพิ่มผู้ใช้งาน</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="../assets/jquery/jquery-slim.min.js"></script>
  <script type="text/javascript" src="../assets/popper/popper.min.js"></script>
  <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
  <?php mysqli_close($Connection); ?>
  <?php include'../includes/footer_admin.php'; ?>

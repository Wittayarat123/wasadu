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

$num = 1;

$strSQL2 = "  SELECT 
                * 
              FROM tb_user u
              LEFT OUTER JOIN tb_agency a ON a.a_id = u.a_id 
              ORDER BY u.user_level ASC";
$objQuery2 = mysqli_query($Connection, $strSQL2);
?>

<title><?php echo $title; ?></title>
<link href="../assets/images/BG.png" rel="icon">
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../assets/main.css">
<link rel="stylesheet" type="text/css" href="../assets/DataTables/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">



<?php include '../includes/navber_admin.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ข้อมูลผู้ใช้งาน</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">ข้อมูลผู้ใช้งาน</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">ข้อมูลผู้ใช้งาน</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <a href="add_user.php"><button type="button" class="btn btn-primary mb-3">เพิ่มผู้ใช้งาน</button></a>
              <table class="table table-hover table-bordered mb-0" id="datatables">
                <thead>
                  <tr class="bg-info">
                    <th scope="col" width="60px">ลำดับที่</th>
                    <th scope="col">ชื่อผู้ใช้</th>
                    <!-- <th scope="col" width="90px">รหัสผ่าน</th> -->
                    <th scope="col">ขื่อ</th>
                    <th scope="col">นามสกุล</th>
                    <th scope="col">หน่วยงาน</th>
                    <th scope="col">ตำแหน่ง</th>
                    <th scope="col">เพศ</th>
                    <th scope="col">อีเมล์</th>
                    <th scope="col">ระดับผู้ใช้</th>
                    <th scope="col" width="60px">ตัวเลือก</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC)) {
                  ?>
                    <tr>
                      <th scope="row"><?php echo $num; ?></th>
                      <td><?php echo $objResult2["user_username"]; ?></td>
                      <!-- <td><button type="button" class="btn btn-warning btn-sm">เปลี่ยนรหัสผ่าน</button></td> -->
                      <td><?php echo $objResult2["user_name"]; ?></td>
                      <td><?php echo $objResult2["user_surname"]; ?></td>
                      <td><?php echo $objResult2["a_name"]; ?></td>
                      <td><?php echo $objResult2["position"]; ?></td>
                      <td><?php echo $objResult2["user_sex"]; ?></td>
                      <td><?php echo $objResult2["user_email"]; ?></td>
                      <td><?php if ($objResult2["user_level"] == "member") {
                            echo "สมาชิก";
                          } else {
                            echo "ผู้ดูแลระบบ";
                          } ?></td>
                      <td>
                        <a href='edit_user.php?user_id=<?php echo $objResult2["user_id"] ?>'><button type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button></a>
                        <a href='delete_user.php?user_id=<?php echo $objResult2["user_id"] ?>'><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>
                      </td>
                    </tr>
                  <?php
                    $num++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


    <!-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="container mt-2 mb-4">
          <h1 class="mt-2">เพิ่มผู้ใช้งาน</h1>
          <div class="card mt-3">
            <div class="card-body">
              <div class="container"> -->
    <!-- ฟอร์มเพิ่มข้อมูล -->

    <!-- <form method="POST" action="save_user.php">
                  <label for="user_username">ชื่อผู้ใช้:</label>
                  <input type="text" name="user_username" id="user_username" required>
                  <br>
                  <label for="user_password">รหัสผ่าน:</label>
                  <input type="password" name="user_password" id="user_password" required>
                  <br>
                  <label for="user_password">รหัสผ่าน:</label>
                  <input type="password" name="user_password" id="user_password" required>
                  <br>
                  <label for="user_password">รหัสผ่าน:</label>
                  <input type="password" name="user_password" id="user_password" required>
                  <br>
                  <label for="user_password">รหัสผ่าน:</label>
                  <input type="password" name="user_password" id="user_password" required>
                  <br>
                  <label for="user_password">รหัสผ่าน:</label>
                  <input type="password" name="user_password" id="user_password" required>
                  <br>
                  <label for="user_password">รหัสผ่าน:</label>
                  <input type="password" name="user_password" id="user_password" required>
                  <br>
                  <label for="user_password">รหัสผ่าน:</label>
                  <input type="password" name="user_password" id="user_password" required>
                  <br>
                  <input type="submit" value="เพิ่มผู้ใช้">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->


    <script type="text/javascript">
      $(document).ready(function() {
        $('#datatables').DataTable();
      });
    </script>
    <script type="text/javascript" src="../assets/DataTables/datatables.min.js"></script>

    <?php mysqli_close($Connection); ?>
    <?php include '../includes/footer_admin.php'; ?>
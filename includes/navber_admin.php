<?php
if ($_SESSION != NULL) {
  $sql_tb_user = "SELECT * FROM tb_user u  
  LEFT JOIN tb_agency a ON a.a_id = u.a_id
  WHERE user_username = '" . $_SESSION['user_username'] . "'";
  $query_tb_user = mysqli_query($Connection, $sql_tb_user);
  $result_tb_user = mysqli_fetch_array($query_tb_user, MYSQLI_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title>

  <link href="../assets/images/BG.png" rel="icon">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/main.css">
  <link rel="stylesheet" type="text/css" href="../assets/DataTables/datatables.min.css" />
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <style type="text/css">
    @media print {
      #hid {
        display: none;
        /* ซ่อน  */
      }

      #sidebarMenu {
        display: none;
        /* ซ่อน  */
      }

      #main-navbar {
        display: none;
        /* ซ่อน  */
      }
    }
  </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../assets/images/BG.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <?php
        if ($_SESSION == NULL) {
        ?>
          <button type="submit" class="btn btn-outline-primary my-2 my-sm-0" onclick="window.location.href='index.php'">เข้าสู่ระบบ</button>
        <?php
        } else {
        ?>
          <!-- Right links -->
          <ul class="navbar-nav ms-auto d-flex flex-row">
            <!-- Avatar -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo "<i class='fas fa-user-circle'></i> " . $result_tb_user["user_name"] . ' ' . $result_tb_user["user_surname"]; ?></a>
              <div class="dropdown-menu dropdown-menu-right">
                <!-- <a class="dropdown-item" href="../profile.php">ข้อมูลส่วนตัว</a> -->
                <?php
                if ($_SESSION["user_level"] == "admin") {
                ?>
                  <a class="dropdown-item" href="../stock.php"> <i class='fas fa-home'></i> ออกระบบหลังบ้าน</a>
                <?php
                }
                ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../homepage.php"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
              </div>
            </li>
          </ul>
        <?php
        }
        ?>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../assets/images/BG.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ระบบเบิกพัสดุ</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo "<i class='fas fa-user-circle-o fa-fw'></i>" . $result_tb_user["user_name"] . ' ' . $result_tb_user["user_surname"]; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt" style="color: #ff3e43;"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="status.php" class="nav-link">
              <i class="nav-icon fas fa-th" style="color:#3498DB"></i>
              <p>
                การอนุมัติ
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="show.php" class="nav-link">
              <i class="nav-icon fas fa-th" style="color:#3498DB"></i>
              <p>
                ข้อมูลพัสดุ
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="stock_up.php" class="nav-link">
              <i class="nav-icon fas fa-th" style="color:#3498DB"></i>
              <p>
                +สต๊อกพัสดุ
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="report_stock_pay.php" class="nav-link">
              <i class="nav-icon fas fa-th" style="color:#3498DB"></i>
              <p>
                รายงานการเพิ่มสต๊อก
              </p>
            </a>
          </li>

          <li class="nav-header">
            <h6><b>รายงานพัสดุสำนักงาน</b></h6>
          </li>

          <li class="nav-item">
            <a href="report_v2.php" class="nav-link">
              <i class="far fa-chart-bar nav-icon" style="color:#2ECC71"></i>
              <p>รวมรายงาน(TEST)</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="report_total.php" class="nav-link">
              <i class="far fa-chart-bar nav-icon" style="color:#2ECC71"></i>
              <p>รวมรายงาน</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="report_total_agen.php" class="nav-link">
              <i class="far fa-chart-bar nav-icon" style="color:#2ECC71"></i>
              <p>รายงานการเบิกทุกหน่วย</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="report_send.php" class="nav-link">
              <i class="far fa-chart-bar nav-icon" style="color:#2ECC71"></i>
              <p>รวมรายการจ่าย</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="report_stock.php" class="nav-link">
              <i class="far fa-chart-bar nav-icon" style="color:#2ECC71"></i>
              <p>รายงานนำเข้า(+สต๊อก)</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="report_agen.php" class="nav-link">
              <i class="far fa-chart-bar nav-icon" style="color:#2ECC71"></i>
              <p>รายงานเบิกตามหน่วยงาน</p>
            </a>
          </li>

          <li class="nav-header">
            <h6><b>เพิ่มข้อมูล</b></h6>
          </li>
        <li class="nav-item">
            <a href="calendar.php" class="nav-link">
              <i class="fas fa-cogs nav-icon" style="color:#F1C40F"></i>
              <p>ปฏิทิน</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="add_detail_agency.php" class="nav-link">
              <i class="fas fa-cogs nav-icon" style="color:#F1C40F"></i>
              <p>เพิ่มข้อมูลหน่วยงาน</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="add_detail_count.php" class="nav-link">
              <i class="fas fa-cogs nav-icon" style="color:#F1C40F"></i>
              <p>เพิ่มข้อมูลหน่วยนับ</p>
            </a>
          </li>

          <li class="nav-header">
            <h6><b>จัดการ</b></h6>
          </li>
          <li class="nav-item">
            <a href="user.php" class="nav-link">
              <i class="nav-icon fas fa-users" style="color:#3498DB"></i>
              <p>
                ข้อมูลผู้ใข้งาน
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../stock.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt" style="color:#E74C3C"></i>
              <p>
                ออกจากระบบ
              </p>
            </a>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
    $('ul').Treeview(options)
  </script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../plugins/moment/moment.min.js"></script>
  <script src="../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="../dist/js/pages/dashboard.js"></script>
  </body>

</html>
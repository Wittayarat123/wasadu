<?php
require_once('connections/mysqli.php');

session_start();

if ($_SESSION == NULL) {
  header("location:login.php");
  exit();
}
$user_id = $_GET['user_id']; //สร้างตัวแปร p_id เพื่อรับค่า

$sql = "SELECT * FROM order_head h
LEFT OUTER JOIN tb_user u ON h.user_id = u.user_id
LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN order_detail d ON h.o_id = d.o_id
LEFT OUTER JOIN tb_wasadu w ON d.w_id = w.w_id
LEFT OUTER JOIN tb_status s ON h.s_id = s.s_id
WHERE u.user_id = $user_id
GROUP BY h.o_id DESC

";  //เรียกข้อมูลมาแสดงทั้งหมด
$result = mysqli_query($Connection, $sql);

?>

<title><?php echo $title; ?></title>
<link href="assets/images/BG.png" rel="icon">

<?php include 'includes/navbar_user.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ประวัติการเบิก</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="stock.php">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">ประวัติการเบิก</li>
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
              <h3 class="card-title">ประวัติการเบิก</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-hover table-bordered mb-4" id="example1">
                <thead>
                  <tr class="bg-info">
                    <th class="text-center">ลำดับที่</th>
                    <th class="text-center">ขื่อ</th>
                    <th class="text-center">หน่วยงาน</th>
                    <th class="text-center">วันที่</th>
                    <th class="text-center">สถานะ</th>
                    <th class="text-center">จัดการ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_array($result)) {
                  ?>
                    <td align="center"><?php echo $row["o_id"] ?></td>
                    <td align="center"><?php echo $row["user_name"] . " " . $row["user_surname"] ?></td>
                    <td align="center"><?php echo $row["a_name"] ?></td>
                    <td align="center"><?php echo $row["o_dttm"] ?></td>
                    <td align="center"><?php if ($row['s_id'] == '0') {
                          echo " <span class='badge badge-pill badge-warning'>รออนุมัติ</span>";
                        } else {
                          echo "<span class='badge badge-pill badge-success'>อนุมัติแล้ว</span>";
                        } ?>
                    </td>
                    <td align="center">
                      <a href='history_detail.php?o_id=<?php echo $row["o_id"] ?>'><button type="button" class="btn btn-secondary btn-sm">รายละเอียด</button></a>
                      <a href='report.php?o_id=<?php echo $row["o_id"] ?>' target="_blank"><button type="button" class="btn btn-info btn-sm">รายงาน</button></a>
                    </td>
                </tbody>
              <?php
                  }
              ?>
              </table>
            </div>
          </div>
          <!-- jQuery -->
          <script src="../../plugins/jquery/jquery.min.js"></script>
          <!-- Bootstrap 4 -->
          <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
          <!-- DataTables  & Plugins -->
          <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
          <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
          <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
          <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
          <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
          <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
          <script src="../../plugins/jszip/jszip.min.js"></script>
          <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
          <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
          <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
          <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
          <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
          <!-- AdminLTE App -->
          <script src="../../dist/js/adminlte.min.js"></script>
          <!-- AdminLTE for demo purposes -->
          <script src="../../dist/js/demo.js"></script>
          <!-- Page specific script -->
          <!-- <script>
            $(function() {
              $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
              }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
              $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
              });
            });
          </script> -->
          <script type="text/javascript">
            $(document).ready(function() {
              $('#datatables').DataTable();
            });
          </script>
          <script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>

          <?php mysqli_close($Connection); ?>
          <?php include 'includes/footer_user.php'; ?>
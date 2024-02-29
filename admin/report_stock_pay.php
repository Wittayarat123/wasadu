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
<?php
$sql1 = "SELECT * FROM tb_pay_order
order by pay_id desc
";  //เรียกข้อมูลมาแสดงทั้งหมด
$result1 = mysqli_query($Connection, $sql1);

?>

<?php include '../includes/navber_admin.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รายงานการเพิ่มสต๊อก/ใบเสร็จ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายงานการเพิ่มสต๊อก/ใบเสร็จ</li>
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
                            <h3 class="card-title">รายงานการเพิ่มสต๊อก/ใบเสร็จ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-hover mb-0">
                                <thead>
                                    <tr class="bg-info">
                                        <th scope="col">ลำดับที่</th>
                                        <th scope="col">ขื่อ</th>
                                        <th scope="col">เล่มที่</th>
                                        <th scope="col">เลขที่</th>
                                        <th scope="col">วันรับ</th>
                                        <th scope="col">รายงาน</th>
                                        <th scope="col">หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <form action="update_status.php" id="form_update" method="post" enctype="multipart/form-data">
                                    <tbody>
                                        <?php
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                        ?>
                                            <td align="center"><?php echo $row1["pay_id"] ?></td>
                                            <td><?php echo $row1["pay_head"] ?></td>
                                            <td><?php echo $row1["pay_d"] ?></td>
                                            <td><?php echo $row1["pay_t"] ?></td>
                                            <td><?php echo $row1["pay_time"] ?></td>
                                            <td align="center">
                                                <a href='report_stock_2.php?pay_id=<?php echo $row1["pay_id"] ?>' target="_blank"><button type="button" class="btn btn-outline-primary btn-sm">รายงาน</button></a>
                                            </td>
                                            <td><?php echo $row1["pay_text"] ?></td>
                                            
                                    </tbody>
                                <?php
                                        }
                                ?>
                                </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
if (@$_GET['do'] == 'ok') {
    echo '<script type="text/javascript">
          swal("", "เพิ่มข้อมูลแล้ว !!", "success");
          </script>';

    echo '<meta http-equiv="refresh" content="1;url=status.php" />';
}
?>


<script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable();
    });
</script>

<?php mysqli_close($Connection); ?>
<?php include '../includes/footer_admin.php'; ?>
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
$o_id = $_GET['o_id']; //สร้างตัวแปร p_id เพื่อรับค่า

$sql = "SELECT * FROM order_head h
LEFT OUTER JOIN tb_user u ON h.user_id = u.user_id
LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN order_detail d ON h.o_id = d.o_id
LEFT OUTER JOIN tb_wasadu w ON d.w_id = w.w_id
WHERE d.o_id = $o_id
";  //เรียกข้อมูลมาแสดงทั้งหมด
$result = mysqli_query($Connection, $sql);

$sql123 = "SELECT * FROM order_head h
LEFT OUTER JOIN tb_user u ON h.user_id = u.user_id
LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN order_detail d ON h.o_id = d.o_id
LEFT OUTER JOIN tb_wasadu w ON d.w_id = w.w_id
WHERE d.o_id = $o_id";  //เรียกข้อมูลมาแสดงทั้งหมด
$result123 = mysqli_query($Connection, $sql123);
$row123 = mysqli_fetch_array($result123)
?>


<?php include('../includes/navber_admin.php'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รายละเอียด</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายละเอียด</li>
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
                            <h3 class="card-title">รายละเอียด</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="text"><b>ชื่อผู้ใช้:</b> <?php echo $row123["user_name"] . ' ' . $row123["user_surname"]; ?> </div>
                            <div class="text"><b>หน่วยงาน:</b> <?php echo $row123["a_name"]; ?> </div>
                            <div class="text"><b>วันที่เบิก:</b> <?php echo $row123["o_dttm"] ?> </div>
                            <div class="text"><button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target=".bd-example-modal-lg">เพิ่มข้อมูลพัสดุ</button></div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr align="center">
                                        <th>ชื่อพัสดุ</th>
                                        <th>ราคา/หน่วย</th>
                                        <th>ราคารวม</th>
                                        <th>จำนวน</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $row["w_name"] ?></td>
                                            <td align="center"><?php echo $row["w_price"]; ?></td>
                                            <td align="center"><?php echo $row["d_subtotal"]; ?></td>
                                            <td align="center"><?php echo $row["d_qty"] ?></td>
                                            <td align="center">
                                                <a href='delete_status_detail.php?d_id=<?php echo $row["d_id"] ?>&o_id=<?php echo $row["o_id"] ?>&w_id=<?php echo $row["w_id"] ?>&d_qty=<?php echo $row["d_qty"] ?>'><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php
                                }
                                ?>
                            </table>
                            <input type="button" class="btn btn-outline-primary btn-sm" onclick="history.back()" value="ย้อนกลับ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container mt-2 mb-4">
                <h3 class="mt-2">เพิ่มข้อมูลพัสดุ</h3>
                <div class="container">
                    <!-- ฟอร์มเพิ่มข้อมูล -->
                    <?php
                    $o_id = $_GET['o_id']; //สร้างตัวแปร p_id เพื่อรับค่า

                    $sql456 = " SELECT * FROM order_head h
                                LEFT OUTER JOIN tb_user u ON h.user_id = u.user_id
                                LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
                                LEFT OUTER JOIN order_detail d ON h.o_id = d.o_id
                                LEFT OUTER JOIN tb_wasadu w ON d.w_id = w.w_id
                                WHERE d.o_id = $o_id";  //เรียกข้อมูลมาแสดงทั้งหมด
                    $result456 = mysqli_query($Connection, $sql456);
                    $row456 = mysqli_fetch_array($result456)
                    ?>
                    <form action="add_status_detail.php" id="form_create" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-md-9">
                                <!-- ข้อมูลเนื้อหา -->
                                <div class="row">
                                    <!-- แถวที่ 1 -->
                                    <div class="col-md-4">
                                        <label for="o_id" class="form-label">ลำดับที่เบิก <span class="text-danger">*</span></label>
                                        <input type="number" id="o_id" name="o_id" class="form-control" value="<?php echo $row456["o_id"]; ?>" required readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="w_id" class="form-label">รหัสพัสดุ <span class="text-danger">*</span></label>
                                        <input type="number" id="w_id" name="w_id" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="d_qty" class="form-label">จำนวน/ชิ้น <span class="text-danger">*</span></label>
                                        <input type="text" id="d_qty" name="d_qty" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="d_subtotal" class="form-label">ราคารวม <span class="text-danger">*</span></label>
                                        <input type="number" id="d_subtotal" name="d_subtotal" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="d_spend" class="form-label">จ่าย <span class="text-danger">*</span></label>
                                        <input type="number" id="d_spend" name="d_spend" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="d_time" class="form-label">เวลา <span class="text-danger">*</span></label>
                                        <input type="date" id="d_time" name="d_time" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="d_price" class="form-label">ราคาจ่าย <span class="text-danger">*</span></label>
                                        <input type="text" id="d_price" name="d_price" class="form-control" required>
                                    </div>

                                    <!-- ปุ่มบันทึก -->
                                    <div class="col-md-12 mt-5">
                                        <button type="submit" class="btn btn-success">บันทึก</button>
                                        <button type="reset" class="btn btn-light">ล้างค่า</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php mysqli_close($Connection); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable();
    });
</script>
<script type="text/javascript" src="../assets/DataTables/datatables.min.js"></script>
<?php include('../includes/footer_admin.php'); ?>
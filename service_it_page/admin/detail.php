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
<?php

$o_id = $_GET['o_id']; //สร้างตัวแปร p_id เพื่อรับค่า

$sql = "SELECT * FROM order_head h
LEFT OUTER JOIN tb_user u ON h.user_id = u.user_id
LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN order_detail d ON h.o_id = d.o_id
LEFT OUTER JOIN tb_wasadu w ON d.w_id = w.w_id
WHERE d.o_id = $o_id


";  //เรียกข้อมูลมาแสดงทั้งหมด
$result = mysqli_query($Connection, $sql);
?>

<?php include '../../includes/navbar_service_it_admin.php'; ?>

<!-- Content Wrapper. Contains page content -->
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
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <div class="text"><b>ชื่อผู้ใช้:</b> <?php echo $result_tb_user["user_name"] . ' ' . $result_tb_user["user_surname"]; ?> </div>
                                <div class="text"><b>หน่วยงาน:</b> <?php echo $result_tb_user["a_name"]; ?> </div>
                                <div class="text"><b>วันที่เบิก:</b> <?php echo $row["o_dttm"] ?> </div>
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ชื่อพัสดุ</th>
                                            <th>จำนวน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $row["w_name"] ?></td>
                                            <td><?php echo $row["d_qty"] ?></td>
                                        </tr>
                                    </tbody>
                                <?php
                            }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div><!-- content-wrapper -->
<?php include '../../includes/footer_service_it_admin.php'; ?>
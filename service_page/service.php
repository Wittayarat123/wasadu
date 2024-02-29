<?php
require_once('../connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
}

?>
<?php require_once('../includes/navbar_service.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ฟอร์มบันทึกการลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="stock.php">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">ฟอร์มบันทึกการลา</li>
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
                            <h3 class="card-title">ฟอร์มบันทึกการลา</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- style="background-color: #f7f3bc;" -->
                                    <br>
                                    <form action="create_service.php" method="post">
                                        <div class="form-group row">
                                            <label class="col-2 col-sm-1">
                                                ประเภท
                                            </label>
                                            <div class="col-10 col-sm-4">
                                                <select class="form-control" name="leave_type_id" required>
                                                    <option value="">-เลือกประเภทการลา-</option>
                                                    <?php
                                                    $strSQL = "SELECT * FROM el_leave_types ORDER BY leave_type_id ASC";
                                                    $objQuery = mysqli_query($Connection, $strSQL);
                                                    while ($row = mysqli_fetch_array($objQuery)) {
                                                    ?>
                                                        <option value="<?php echo $row["leave_type_id"]; ?>"><?php echo $row["leave_type_name"]; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-sm-1">
                                                เรียน
                                            </label>
                                            <div class="col-10 col-sm-4">
                                                <input type="text" name="el_head" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-sm-1">
                                                ข้าพเจ้า
                                            </label>
                                            <div class="col-10 col-sm-4">
                                                <input type="text" name="user_name_1" class="form-control" value="<?php echo $result_tb_user["user_name"] . " " . $result_tb_user["user_surname"]; ?>" required>
                                            </div>
                                            <label class="col-2 col-sm-1">
                                                ตำแหน่ง
                                            </label>
                                            <div class="col-10 col-sm-4">
                                                <input type="text" name="el_position" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-sm-1">
                                                สาเหตุ
                                            </label>
                                            <div class="col-10 col-sm-5">
                                                <textarea name="el_detail" class="form-control" required placeholder="ระบุสาเหตุการลา"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-sm-1">
                                                กำหนด
                                            </label>
                                            <div class="col-3 col-sm-2">
                                                <input type="number" name="el_day" required min="0" class="form-control" value="0">
                                            </div>
                                            <label class="col-1 col-sm-1">
                                                วัน
                                            </label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2">
                                                ตั้งแต่
                                            </label>
                                            <div class="col-sm-3">
                                                <input type="date" name="el_time_1" required class="form-control">
                                            </div>
                                            <label class="col-sm-1">
                                                ถึง
                                            </label>
                                            <div class="col-sm-3">
                                                <input type="date" name="el_time_2" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2">
                                                ติดต่อ
                                            </label>
                                            <div class="col-sm-5">
                                                <textarea name="el_contact" class="form-control" required placeholder="ระหว่างลาติดต่อได้ที่"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                ID: <input align="center" name="user_id" value="<?php echo $result_tb_user["user_id"]; ?>" style="width: 5%;">
                                                ชื่อผู้ใช้งาน: <?php echo $result_tb_user["user_name"] . " " . $result_tb_user["user_surname"]; ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">
                                            </label>
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-success" style="width: 100%">บันทึก</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (@$_GET['do'] == 'ok') {
            echo '<script type="text/javascript">
          swal("", "เพิ่มข้อมูลแล้ว !!", "success");
          </script>';

            // echo '<meta http-equiv="refresh" content="1;url=show.php" />';
        }
        ?>
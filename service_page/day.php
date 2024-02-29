<?php include('../connections/config.inc.php');

session_start();
if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
}
$sql = "SELECT * FROM el_leave";
$objQuery1 = mysqli_query($Connection, $sql);

?>

<?php require_once('../includes/navbar_service.php'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>เช็ควันลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="stock.php">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">เช็ควันลา</li>
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
                            <h3 class="card-title">เช็ควันลา</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="create_service.php" method="post">
                                        <div class="form-group row">
                                            <label class="col-1 col-sm-1">
                                                ปีงบประมาณ
                                            </label>
                                            <div class="col-10 col-sm-4">
                                                <select class="form-control" name="a_id" required>
                                                    <option value="">-เลือกประเภทการลา-</option>
                                                    <?php
                                                    $strSQL = "SELECT * FROM el_leave_types ORDER BY leave_type_id ASC";
                                                    $objQuery = mysqli_query($Connection, $strSQL);
                                                    while ($row = mysqli_fetch_array($objQuery)) {
                                                    ?>
                                                        <option value="<?php echo $row["leave_type_id"]; ?>">
                                                            <?php echo $row["leave_type_name"]; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <button class="btn btn-default btn-outline-primary">ค้นหา</button>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    while ($objResult = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                                        if (mysqli_num_rows($objQuery1) > 0) {
                                            // วนลูปผลลัพธ์
                                            while ($objResult = mysqli_fetch_assoc($objQuery1)) {
                                                $date = $objResult['el_time_1'];

                                                // แปลงวันที่ให้เป็นปี พ.ศ.
                                                $year = date('Y', strtotime($date)) + 543;
                                            }
                                        }

                                    ?>
                                        <!-- <p><?php echo $year ?></p> -->
                                        <?php if ($year = '2566') {
                                            echo "<span class='badge badge-pill badge-success'>2566</span>";
                                        } elseif ($year != '2566') {
                                            echo "<span class='badge badge-pill badge-danger'>2566</span>";
                                        }

                                        ?>

                                    <?php 
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-6">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ประเภทการลา</th>
                                                    <th scope="col">จำนวนวัน</th>
                                                    <th scope="col">ครั้ง</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $strSQL = "SELECT * FROM el_leave_types ORDER BY leave_type_id ASC";
                                            $objQuery = mysqli_query($Connection, $strSQL);
                                            while ($row = mysqli_fetch_array($objQuery)) {
                                            ?>
                                                <tbody>
                                                    <td scope="row"><?php echo $row["leave_type_name"]; ?></td>
                                                    <td>00</td>
                                                    <td>00</td>
                                                </tbody>
                                            <?php
                                            }
                                            ?>

                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>


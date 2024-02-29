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
// รับ w_id ที่ต้องการแก้ไขจากพารามิเตอร์ URL
$w_id = $_GET['w_id'];

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_query = "SELECT * FROM tb_wasadu WHERE w_id = $w_id";
$user_result = mysqli_query($Connection, $user_query);
$wasadudata = mysqli_fetch_assoc($user_result);
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
    <link rel="stylesheet" type="text/css" href="../assets/DataTables/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
</head>

<?php include '../includes/navber_admin.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>แก้ไขข้อมูลพัสดุ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">แก้ไขข้อมูลพัสดุ</li>
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
                            <h3 class="card-title">แก้ไขข้อมูลพัสดุ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="card-body">
                                <form method="POST" action="update_wasadu.php">
                                    <div class="row">
                                        <div class="col-3 mb-3">
                                            <input type="hidden" name="w_id" value="<?php echo $wasadudata['w_id']; ?>">
                                            <label for="w_name">ชื่อพัสดุ:</label>
                                            <input class="form-control" type="text" name="w_name" id="w_name" value="<?php echo $wasadudata['w_name']; ?>">
                                        </div>

                                        <div class="col-3 mb-3">
                                            <label for="w_price">ราคา:</label>
                                            <input class="form-control" type="text" name="w_price" id="w_price" value="<?php echo $wasadudata['w_price']; ?>">
                                        </div>

                                        <div class="col-3 mb-3">
                                            <label>&nbsp;หน่วยนับ :&nbsp;</label>
                                            <select class="form-control" name="c_id">
                                                <option value="<?php echo $wasadudata["c_id"]; ?>">&nbsp;เลือกหน่วยนับ&nbsp;</option>
                                                <?php
                                                $strSQL = "SELECT * FROM tb_count ORDER BY c_id ASC";
                                                $objQuery = mysqli_query($Connection, $strSQL);
                                                while ($row = mysqli_fetch_array($objQuery)) {
                                                ?>
                                                    <option value="<?php echo $row["c_id"]; ?>"><?php echo $row["c_name"]; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-3 mb-3">
                                            <label for="w_brand">แบรนด์/ยี่ห้อ:</label>
                                            <input class="form-control" type="text" name="w_brand" id="w_brand" value="<?php echo $wasadudata['w_brand']; ?>">
                                        </div>

                                        <div class="col-3 mb-3">
                                            <label for="w_detail">รายละเอียด:</label>
                                            <textarea class="form-control" type="text" name="w_detail" id="w_detail"><?php echo $wasadudata['w_detail']; ?></textarea>
                                        </div>

                                        <div class="col-3 mb-3">
                                            <label for="w_textcom">หมายเหตุ:</label>
                                            <textarea class="form-control" type="text" name="w_textcom" id="w_textcom"><?php echo $wasadudata['w_textcom']; ?></textarea>
                                        </div>

                                        <!-- <input type="text"  value="<?php echo $wasadudata['w_img']; ?>">

                                        <div class="col-3 mb-3">
                                            <label for="imageFile">รูปพัสดุ:</label>
                                            <input class="form-control" type="file" id="imageFile" name="imageFile" accept="image/png, image/gif, image/jpeg">
                                        </div> -->

                                    </div>
                                    <input class="btn btn-success btn-sm" type="submit" value="บันทึกการแก้ไข">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer_admin.php'; ?>
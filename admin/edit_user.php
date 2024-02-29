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
// รับ user_id ที่ต้องการแก้ไขจากพารามิเตอร์ URL
$user_id = $_GET['user_id'];

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_query = "SELECT * FROM tb_user WHERE user_id = $user_id";
$user_result = mysqli_query($Connection, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
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

<?php include'../includes/navber_admin.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>แก้ไขข้อมูล</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">แก้ไขข้อมูล</li>
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
                            <h3 class="card-title">แก้ไขข้อมูล</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                    <div class="card-body">
                        <form method="POST" action="update_user.php">
                            <input type="hidden" name="user_id" value="<?php echo $user_data['user_id']; ?>">
                            <label for="user_username">ชื่อผู้ใช้:</label>
                            <input type="text" name="user_username" id="user_username" value="<?php echo $user_data['user_username']; ?>" required>
                            <br>
                            <label for="user_password">รหัสผ่าน:</label>
                            <input type="password" name="user_password" id="user_password" required>
                            <br>
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

<?php include'../includes/footer_admin.php';?>
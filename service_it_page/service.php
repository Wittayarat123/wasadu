<?php
require_once('../connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
}

if ($_SESSION != NULL) {
    $sql_tb_user = "SELECT * FROM tb_user WHERE user_username = '" . $_SESSION['user_username'] . "'";
    $query_tb_user = mysqli_query($Connection, $sql_tb_user);
    $result_tb_user = mysqli_fetch_array($query_tb_user, MYSQLI_ASSOC);
}

$sql2 = "SELECT * FROM tb_agency";
$objQuery2 = mysqli_query($Connection, $sql2);
?>

<?php include_once '../includes/navbar_service_it.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>แจ้งซ่อม</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</li>
                        <li class="breadcrumb-item active">แจ้งซ่อม</li>
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
                            <h3 class="card-title">รายละเอียดการซ่อม</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <form action="create_service.php?user_id?<?php echo $result_tb_user["user_id"] ?>" id="form_create" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">ชื่อเครื่อง</label>
                                            <input type="text" class="form-control" id="rp_name" name="rp_name" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">หน่วยงาน</label>
                                            <select name="a_id" id="a_id" class="form-control">
                                                <option value="">--เลือก--</option>
                                                <?php
                                                while ($objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC)) {
                                                ?>
                                                    <option value="<?php echo $objResult2['a_id']; ?>"><?php echo $objResult2['a_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            
                                        </div>
                                    </div>                                   

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียดการซ่อม/ปัญหา</label>
                                            <textarea class="form-control" id="rp_detail" name="rp_detail" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">ประเภท</label>
                                            <select class="form-control" aria-label="Default select example" id="rp_type" name="rp_type">
                                                <option selected>เลือก</option>
                                                <option value="1">โปรแกรม</option>
                                                <option value="2">อุปกรณ์คอมพิวเตอร์</option>
                                                <option value="3">อินเตอร์เน็ต</option>
                                                <option value="4">อื่นๆ</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">แนบไฟล์รูป</label>
                                            <input class="form-control" id="rp_img" name="rp_img" type="file" accept="image/png, image/gif, image/jpeg">
                                        </div>
                                    </div>
                       
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            ID: <input align="center" name="user_id" id="user_id" value="<?php echo $result_tb_user["user_id"]; ?>" style="width: 5%;">
                                            ชื่อผู้แจ้ง: <?php echo $result_tb_user["user_name"] . " " . $result_tb_user["user_surname"]; ?>
                                        </div>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-outline-success btn-sm">ตกลง</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
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


<?php include_once '../includes/footer_admin.php'; ?>
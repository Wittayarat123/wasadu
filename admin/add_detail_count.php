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

$sql = "SELECT * FROM tb_count ORDER BY c_id ASC ";
$objQuery = mysqli_query($Connection, $sql);

?>

<!doctype html>
<html lang="th" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <link href="../assets/images/BG.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/main.css">
    <link rel="stylesheet" type="text/css" href="../assets/DataTables/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./css/style.css" rel="stylesheet">
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<?php include '../includes/navber_admin.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>เพิ่มข้อมูลหน่วยนับ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">เพิ่มข้อมูลหน่วยนับ</li>
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
                            <h3 class="card-title">เพิ่มข้อมูลหน่วยนับ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- ฟอร์มเพิ่มข้อมูล -->
                            <form action="action_create_count.php" id="form_create" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                                <div class="row">
                                    <div class="col-md-9">
                                        <!-- ข้อมูลเนื้อหา -->
                                        <div class="row">
                                            <!-- แถวที่ 1 -->
                                            <div class="col-md-4 ">
                                                <label for="c_name" class="form-label">ชื่อหน่วยนับ <span class="text-danger">*</span></label>
                                                <input type="text" id="c_name" name="c_name" class="form-control" required>
                                            </div>
                                            <!-- ปุ่มบันทึก -->
                                            <div class="col-md-12 mt-3 mb-3">
                                                <button type="submit" class="btn btn-success">บันทึก</button>
                                                <button type="reset" class="btn btn-light">ล้างค่า</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3">
                        ข้อมูลรูปภาพ
                        <div class="row mt-4">
                            <div class="col-md-12 mt-3">
                                <label for="c_image" class="form-label">รูปภาพ</label>
                                <input class="form-control" id="c_image" name="c_image" type="file" onchange="loadFile(event)">
                            </div>
                            <div class="col-md-12 mt-3">
                                <img src="./images/noimg.png" class="img-thumbnail" id="c_image_preview" />
                            </div>
                        </div>
                    </div> -->
                                </div>
                            </form>


                            <table class="table mt-4 " id="datatables">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อหน่วยงาน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $objResult['c_id']; ?></td>
                                            <td><?php echo $objResult['c_name']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
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

    echo '<meta http-equiv="refresh" content="1;url=add_detail_count.php" />';
}
?>

<script>
    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('c_image_preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>



<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable();
    });
</script>
<script type="text/javascript" src="../assets/DataTables/datatables.min.js"></script>

<?php mysqli_close($Connection); ?>
<?php include '../includes/footer_admin.php'; ?>
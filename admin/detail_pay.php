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

// รับ w_id ที่ต้องการแก้ไขจากพารามิเตอร์ URL
$w_id = $_GET['w_id'];

$sql456 = "SELECT * FROM tb_wasadu w
	LEFT JOIN tb_count c ON c.c_id = w.c_id WHERE w.w_id = $w_id ";
$objQuery456 = mysqli_query($Connection, $sql456);



$sql123 = "SELECT
w.w_name,
CONCAT(u.user_name,' ',u.user_surname) AS Fullname,
a.a_name,
h.o_dttm,
d.d_qty,
d.d_subtotal,
h.o_id
FROM
order_detail d
LEFT JOIN order_head h ON h.o_id = d.o_id
LEFT JOIN tb_wasadu w ON w.w_id = d.w_id 
LEFT JOIN tb_user u ON h.user_id = u.user_id
LEFT JOIN tb_agency a ON a.a_id = u.a_id
WHERE
w.w_id = $w_id  ";
$objQuery123 = mysqli_query($Connection, $sql123);


$sql = "SELECT
w.w_name,
p.pay_qty,
w.w_price,
p.pay_subtotal,
d.pay_id,
d.pay_head,
d.pay_time ,
d.pay_d,
d.pay_t
FROM
tb_pay_detail p
LEFT JOIN tb_wasadu w ON w.w_id = p.w_id
LEFT JOIN tb_pay_order d ON d.pay_id = p.pay_id 
WHERE
w.w_id = $w_id ";
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

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รับ-จ่าย</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รับ-จ่าย</li>
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
                            <h3 class="card-title">พัสดุ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover mb-0" >
                                <thead>
                                    <th scope="col">ID</th>
                                    <th scope="col">ชื่อพัสดุ</th>
                                    <th scope="col">ราคา</th>
                                    <th scope="col">หน่วยนับ</th>
                                    <th scope="col">QYT(สต๊อกปัจจุบัน)</th>
                                    <th scope="col">รูป</th>
                                    <th scope="col">หมายเหตุ</th>
                                    <th scope="col">ประเภท</th>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($objResult456 = mysqli_fetch_array($objQuery456, MYSQLI_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td align="center">
                                                <?php echo $objResult456['w_id']; ?>
                                            </td>
                                            <td>
                                                <?php echo $objResult456['w_name']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult456['w_price']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult456['c_name']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult456['w_quantity']; ?>
                                            </td>
                                            <td align="center">
                                                <img src='../assets/img_w/<?php echo $objResult456['w_img']; ?>' style="width: 25%;">
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult456['w_textcom']; ?>
                                            </td>
                                            <td align="center">
                                                <?php
                                                if ($objResult456['w_type'] == '1') {
                                                    echo "<button type='button' class='btn btn-success btn-sm' title='เปลี่ยนประเภท'> พัสดุสำนักงาน</i></button></a>";
                                                } elseif ($objResult456['w_type'] == '2') {
                                                    echo "<button type='button' class='btn btn-warning btn-sm' title='เปลี่ยนประเภท'> งานบ้านงานครัว</i></button></a>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">จ่าย</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-bordered table-striped table-hover mb-0" id="datatables">
                                <thead>
                                    <tr>
                                        <th scope="col">ชื่อพัสดุ</th>
                                        <th scope="col">ชื่อผู้ขอเบิก</th>
                                        <th scope="col">หน่วยงาน</th>
                                        <th scope="col">เวลา</th>
                                        <th scope="col">จำนวน</th>
                                        <th scope="col">ราคารวม</th>
                                        <th scope="col">เลขที่</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($objResult123 = mysqli_fetch_array($objQuery123, MYSQLI_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td align="center">
                                                <?php echo $objResult123['w_name']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult123['Fullname']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult123['a_name']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult123['o_dttm']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult123['d_qty']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult123['d_subtotal']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult123['o_id']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รับ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-bordered table-striped table-hover mb-0" id="datatables2">
                                <thead>
                                    <tr>
                                        <th scope="col">ชื่อ</th>
                                        <th scope="col">จำนวน</th>
                                        <th scope="col">ราคา</th>
                                        <th scope="col">ราคารวม</th>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">ชื่อ</th>
                                        <th scope="col">Iเวลา</th>
                                        <th scope="col">เล่มที่</th>
                                        <th scope="col">เลขที่</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td align="center">
                                                <?php echo $objResult['w_name']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['pay_qty']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['w_price']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['pay_subtotal']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['pay_id']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['pay_head']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['pay_time']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['pay_d']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['pay_t']; ?>
                                            </td>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables2').DataTable();
    });
</script>
<script type="text/javascript" src="../../assets/DataTables/datatables.min.js"></script>



<?php include '../includes/footer_admin.php'; ?>
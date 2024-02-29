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

$sql = "SELECT * FROM el_leave
        ";
$objQuery = mysqli_query($Connection, $sql);

?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../assets/css/service.css">
<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style>
    img {
        width: 25px;
        height: 25px;
    }

    #textttt {
        color: white;
        border-radius: 4px;
        background: #9ec8ff;
        box-shadow: -5px 5px 0px #3f5066,
            5px -5px 0px #fdffff;
    }

    .button1 {
        border-radius: 4px;
        background: #fe5858;
        box-shadow: -5px 5px 0px #662323,
            5px -5px 0px #ff8d8d;
    }

    .button2 {
        border-radius: 4px;
        background: #fed258;
        box-shadow: -5px 5px 0px #665423,
            5px -5px 0px #ffff8d;
    }

    .button3 {
        border-radius: 4px;
        background: #fed258;
        box-shadow: -5px 5px 0px #665423,
            5px -5px 0px #ffff8d;
    }

    .button4 {
        border-radius: 4px;
        background: #fed258;
        box-shadow: -5px 5px 0px #665423,
            5px -5px 0px #ffff8d;
    }

    .button5 {
        border-radius: 4px;
        background: #fe5858;
        box-shadow: -5px 5px 0px #662323,
            5px -5px 0px #ff8d8d;
    }

    .button6 {
        border-radius: 4px;
        background: #fe5858;
        box-shadow: -5px 5px 0px #662323,
            5px -5px 0px #ff8d8d;
    }

    .button7 {
        color: black;
        border-radius: 4px;
        background: #58fe79;
        box-shadow: -5px 5px 0px #236630,
            5px -5px 0px #8dffc2;
    }
</style>

<?php include('../../includes/navbar_service_admin.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>การอนุมัติ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">การอนุมัติ</li>
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
                            <h3 class="card-title">การอนุมัติ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-hover table-bordered mb-0" id="datatables">
                                <thead>
                                    <tr class="bg-info">
                                        <th class="col-sm-1">รหัสลา</th>
                                        <th class="col-xs-1">ประเภทการลา</th>
                                        <th class="col-xs-1">หัวหน้าแผนก</th>
                                        <th class="col-xs-1">ผู้ลา</th>
                                        <th class="col-xs-2">ตำแหน่ง</th>
                                        <th class="col-xs-1">สาเหตุ</th>
                                        <th class="col-xs-1">จำนวนวันลา</th>
                                        <th class="col-xs-1">เริ่มวันที่ลา</th>
                                        <th class="col-xs-1">สิ้นสุดวันลา</th>
                                        <th class="col-xs-2">ติดต่อ</th>
                                        <th class="col-xs-2">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row1 = mysqli_fetch_array($objQuery)) {
                                    ?>
                                        <td><?php echo $row1["el_id"] ?></td>
                                        <td><?php echo $row1["el_type"] ?></td>
                                        <td><?php echo $row1["el_head"] ?></td>
                                        <td><?php echo $row1["user_name_1"] ?></td>
                                        <td><?php echo $row1["el_position"] ?></td>
                                        <td><?php echo $row1["el_detail"] ?></td>
                                        <td><?php echo $row1["el_day"] ?></td>
                                        <td><?php echo $row1["el_time_1"] ?></td>
                                        <td><?php echo $row1["el_time_2"] ?></td>
                                        <td><?php echo $row1["el_contact"] ?></td>
                                        <td><?php echo $row1["el_status"] ?></td>
                                </tbody>
                            <?php
                                    }
                            ?>
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
          swal("", "ลงข้อมูลแล้ว !!", "success");
          </script>';

    // echo '<meta http-equiv="refresh" content="1;url=show.php" />';
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable();
    });
</script>


<?php include_once '../../includes/footer_service_it_admin.php'; ?>
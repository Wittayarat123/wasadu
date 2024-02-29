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

$sql = "SELECT * FROM rp_repair r
        LEFT JOIN tb_user u ON u.user_id = r.user_id
        LEFT JOIN tb_agency a ON a.a_id = r.a_id
        LEFT JOIN rp_repair_status s ON s.rs_id = r.rs_id
        ORDER BY rp_date DESC
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
</style>

<?php include '../../includes/navbar_service_it_admin.php'; ?>
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
                                        <!-- <th class="col-sm-1">ลำดับที่</th> -->
                                        <th class="col-xs-1">ขื่อผู้แจ้ง</th>
                                        <th class="col-xs-1">หน่วยงาน</th>
                                        <th class="col-xs-1">วันที่</th>
                                        <th class="col-xs-2">รายละเอียดการแจ้ง</th>
                                        <th class="col-xs-1">สถานะ</th>
                                        <th class="col-xs-1">รูปภาพ</th>
                                        <th class="col-xs-1">รายละเอียด</th>
                                        <th class="col-xs-1">ผู้ปฏิบัติการ</th>
                                        <th class="col-xs-2">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row1 = mysqli_fetch_array($objQuery)) {
                                    ?>
                                        <!-- <td align="center"><?php echo $row1["rp_id"] ?></td> -->
                                        <td><?php echo $row1["user_name"] . " " . $row1["user_surname"] ?></td>
                                        <td><?php echo $row1["a_name"] ?></td>
                                        <td><?php echo $row1["rp_date"] ?></td>
                                        <td><?php echo $row1["rp_detail"] ?></td>
                                        <td align="center">
                                            <?php if ($row1['rs_id'] == '1') {
                                                echo  "<span class='badge badge-pill badge-danger'>" . $row1["rs_name"] . "</span>";
                                            } elseif ($row1['rs_id'] == '2') {
                                                echo  "<span class='badge badge-pill badge-warning'>" . $row1["rs_name"] . "</span>";
                                            } elseif ($row1['rs_id'] == '3') {
                                                echo  "<span class='badge badge-pill badge-warning'>" . $row1["rs_name"] . "</span>";
                                            } elseif ($row1['rs_id'] == '4') {
                                                echo  "<span class='badge badge-pill badge-success'>" . $row1["rs_name"] . "</span>";
                                            } elseif ($row1['rs_id'] == '5') {
                                                echo  "<span class='badge badge-pill badge-warning'>" . $row1["rs_name"] . "</span>";
                                            } elseif ($row1['rs_id'] == '6') {
                                                echo  "<span class='badge badge-pill badge-danger'>" . $row1["rs_name"] . "</span>";
                                            } elseif ($row1['rs_id'] == '7') {
                                                echo  "<span class='badge badge-pill badge-success'>" . $row1["rs_name"] . "</span>";
                                            }

                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($row1['rp_img'] == '') {
                                                echo "<button class='btn btn-outline-light btn-sm'>
                                        <img src='../../assets/images/noimage.png' alt='Image' class='image-popup' data-bs-toggle='modal' 
                                        data-bs-target='#imageModal123' data-bs-img-src='../../assets/images/noimage.png'></button>";
                                            } else {
                                                echo "<button class='btn btn-outline-light btn-sm'>
                                        <img src='../it_img/" . $row1["rp_img"] . "' alt='Image' class='image-popup' data-bs-toggle='modal' data-bs-target='#imageModal' data-bs-img-src='../it_img/" . $row1["rp_img"] . "'>
                                        </button>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href='detail.php?rp_id=<?php echo $row1["rp_id"] ?>'><button type="button" class="btn btn-default btn-sm">รายละเอียด</button></a>
                                        </td>
                                        <td align="center">
                                            <?php if ($row1['rp_work_id'] == '0') {
                                                echo   "<form id='rp_work_id' action='act_work.php?rp_id=" . $row1["rp_id"] . "' method='post'>";
                                                echo   "<select class='form-select' name='rp_work_id'>";
                                                echo      " <option selected>เลือกผู้ปฏิบัติการ</option>";
                                                echo      " <option value='" . $result_tb_user["user_id"] . "'>" . $result_tb_user["user_name"] . ' ' . $result_tb_user["user_surname"];
                                                "</option>";
                                                echo    "</select>";
                                                echo    "<button id='rp_work_id' class='button btn-outline-success btn-sm' type='submit'>ยืนยืน</button>";
                                                echo    "</form>";
                                                // echo    "<a href='act_work.php?rp_id=" . $row1["rp_id"] . " method='post''></a>";
                                            } else {
                                                echo    " <span class='badge badge-pill badge-info'>" . $result_tb_user["user_name"] . ' ' . $result_tb_user["user_surname"] . "</span> ";
                                            }
                                            ?>

                                        <td><?php if ($row1['rp_work_id'] == '0') {
                                            } else {
                                                echo    "<form id='rs_id' action='act_status.php?rp_id=" . $row1['rp_id'] . "' method='post'>";
                                                echo        "<select class='form-select' name='rs_id'>";
                                                echo            "<option selected>เลือกสถานะ</option>";
                                                echo            "<option value='1'>แจ้งซ่อม </option>";
                                                echo            "<option value='2'>กำลังดำเนินการ </option>";
                                                echo            "<option value='3'>รออะไหล่ </option>";
                                                echo            "<option value='4'>ซ่อมสำเร็จ </option>";
                                                echo            "<option value='5'>ซ่อมไม่สำเร็จ </option>";
                                                echo            "<option value='6'>ยกเลิกการซ่อม </option>";
                                                echo            "<option value='7'>ส่งมอบเรียบร้อย </option>";
                                                echo         "</select>";
                                                echo            "<button id='rs_id' class='button btn-outline-success btn-sm' type='submit'>ยืนยืน</button>";
                                                echo    "</form>";
                                            }
                                            ?>

                                        </td>
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


<!-- Modal123 -->
<div class="modal fade" id="imageModal123" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" align="center">
                <!-- Image inside modal -->
                <img src="../../assets/images/noimage.png" alt="Image" style="width: 500px; height: 500px;">
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    var imageModal = document.getElementById('imageModal123');
    var modalImage = imageModal.querySelector('.modal-body img');

    imageModal.addEventListener('show.bs.modal', function(event) {
        var thumbnail = event.relatedTarget;
        var imageSrc = thumbnail.dataset.bsImgSrc;

        modalImage.src = imageSrc;
    });
</script>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" align="center">
                <img src="" alt="Modal Image" class="img-fluid" style="width: 500px; height: 500px;">
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    var imageModal = document.getElementById('imageModal');
    var modalImage = imageModal.querySelector('.modal-body img');

    imageModal.addEventListener('show.bs.modal', function(event) {
        var thumbnail = event.relatedTarget;
        var imageSrc = thumbnail.dataset.bsImgSrc;

        modalImage.src = imageSrc;
    });
</script>

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
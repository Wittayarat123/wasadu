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

// if ($objCon) {
//     echo 'connected';
// } else {
//     // echo mysqli_connect_error();
//     echo 'not connect';
// }
$perpage = 10;
// $page = $_GET['page'];
if (isset($_GET['page']) && (int) $_GET['page'] > 0) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $perpage;

$condition = "";
$search = "";
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = mysqli_real_escape_string($Connection, $_GET['search']);
    $condition = " AND c_firstname LIKE '%$search%' OR c_lastname LIKE '%$search%' OR c_idcard = '$search'";
}

// echo $search;

$sql = "SELECT *, (w.w_quantity) AS cc FROM tb_wasadu w
        LEFT OUTER JOIN tb_count c ON w.c_id = c.c_id 
        ORDER BY w.w_id ASC ";
$objQuery = mysqli_query($Connection, $sql);

// while($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
//     print_r($objResult);
// }
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        th {
            text-align: center;
        }

        #thumbwrap {
            position: relative;
        }

        .thumb span {
            position: absolute;
            visibility: hidden;
        }

        .thumb img {
            width: 90px;
            height: 90px;
        }

        .thumb:hover,
        .thumb:hover span img {
            visibility: visible;
            top: 0;
            left: 100px;
            z-index: 1;
            width: 300px;
            height: 300px;
        }
    </style>

    <style>
        img {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<?php include '../includes/navber_admin.php'; ?>
<!-- Begin page content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รายการข้อมูล</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการข้อมูล</li>
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
                            <h3 class="card-title">รายการข้อมูล</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- ปุ่มเพิ่มข้อมูล -->
                            <button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target=".bd-example-modal-lg">เพิ่มข้อมูลพัสดุ</button>
                            <!-- ตารางข้อมูล -->
                            <table class="table table-bordered table-striped table-hover mb-0" id="datatables">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">ชื่อพัสดุ</th>
                                        <th scope="col">ราคา</th>
                                        <th scope="col">หน่วยนับ</th>
                                        <th scope="col">ประวัติการเบิก</th>
                                        <!-- <th scope="col">คุณลักษณะ</th> -->
                                        <th scope="col">QYT(สต๊อก)</th>
                                        <th scope="col">รูป</th>
                                        <th scope="col">หมายเหตุ</th>
                                        <th scope="col">ประเภท</th>
                                        <th scope="col">อัพรูป</th>
                                        <!-- <th scope="col">+ สต๊อก</th> -->
                                        <th scope="col">สถานะ</th>
                                        <th scope="col">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td align="center">
                                                <?php echo $objResult['w_id']; ?>
                                            </td>
                                            <td>
                                                <?php echo $objResult['w_name']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['w_price']; ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $objResult['c_name']; ?>
                                            </td>
                                            <td align="center">
                                                <a href="detail_pay.php?w_id=<?php echo $objResult['w_id']; ?>"><button type="button" class="btn btn-info btn-sm">ประวัติการเบิก</button></a>
                                            </td>
                                            <!-- <td><?php echo $objResult['w_brand']; ?></td> -->
                                            <!-- <td><?php echo $objResult['w_detail']; ?></td> -->
                                            <td align="center">
                                                <?php echo $objResult['cc']; ?>
                                            </td>
                                            <td align="center">

                                                <?php if ($objResult['w_img'] == '') {
                                                    echo "<button class='btn btn-outline-light btn-sm'><img src='../assets/images/noimage.png' alt='Image' class='image-popup' data-bs-toggle='modal' data-bs-target='#imageModal123' data-bs-img-src='../assets/images/noimage.png'></button>";
                                                } else {
                                                    echo "<button class='btn btn-outline-light btn-sm'><img src='../assets/img_w/" . $objResult["w_img"] . "' alt='Image' class='image-popup' data-bs-toggle='modal' data-bs-target='#imageModal' data-bs-img-src='../assets/img_w/" . $objResult["w_img"] . "'></button>";
                                                }
                                                ?>

                                            </td>
                                            <td>
                                                <?php echo $objResult['w_textcom']; ?>
                                            </td>
                                            <td align="center">
                                                <!-- <?php
                                                        if ($objResult['w_type'] == 1) {
                                                            echo "<span class='badge badge-pill badge-success'>พัสดุสำนักงาน</span>";
                                                        } else {
                                                            echo "<span class='badge badge-pill badge-warning'>งานบ้านงานครัว</span>";
                                                        }
                                                        ?> -->
                                                <?php
                                                if ($objResult['w_type'] == '1') {
                                                    echo "<a href='edit_status_type.php?Action=Change&w_id=" . $objResult["w_id"] . "'><button type='button' class='btn btn-success btn-sm' title='เปลี่ยนประเภท'><i class='fa fa-refresh'> พัสดุสำนักงาน</i></button></a>";
                                                } elseif ($objResult['w_type'] == '2') {
                                                    echo "<a href='edit_status_type.php?Action=Change&w_id=" . $objResult["w_id"] . "'><button type='button' class='btn btn-warning btn-sm' title='เปลี่ยนประเภท'><i class='fa fa-refresh'> งานบ้านงานครัว</i></button></a>";
                                                }
                                                ?>
                                            </td>
                                            <td align="center">

                                                <?php if ($objResult['w_img'] == '') {
                                                    echo    "<form action='update_img.php?w_id=" . $objResult["w_id"] . "' method='POST' enctype='multipart/form-data'>";
                                                    echo    "   <input type='file' name='imageFile' accept='image/png, image/gif, image/jpeg'  maxlength='50' style='width:200px;'>";
                                                    echo    "   <input type='submit' class='btn-outline-primary btn-sm' value='Update Image'>";
                                                    echo    "</form>";
                                                } else {
                                                    echo "<span class='badge badge-pill badge-success'>ลงรูปแล้ว</span>";
                                                }
                                                ?>

                                            </td>
                                            <!-- <td align="center">

                                                <form class="form-horizontal" action="up_stock.php?w_id=<?php echo $objResult['w_id']; ?>&w_price=<?php echo $objResult['w_price']; ?>" method="post">
                                                    <input type="number" name='w_quantity' id="w_quantity" maxlength="15" style="width:50px;" />
                                                    <button class="btn-outline-primary btn-sm" type="submit">บันทึก</button>
                                                </form>

                                            </td> -->
                                            <td>
                                                <?php
                                                if ($objResult['w_status'] == '1') {
                                                    echo "<a href='edit_status.php?Action=Change&w_id=" . $objResult["w_id"] . "'><button type='button' class='btn btn-success btn-sm' title='เปลี่ยนสถานะปิด'><i class='fa fa-power-off'> เปิด</i></button></a>";
                                                } elseif ($objResult['w_status'] == '2') {
                                                    echo "<a href='edit_status.php?Action=Change&w_id=" . $objResult["w_id"] . "'><button type='button' class='btn btn-danger btn-sm' title='เปลี่ยนสถานะเปิด'><i class='fa fa-power-off'> ปิด</i></button></a>";
                                                }
                                                ?>

                                                <!-- <?php
                                                        if ($objResult['w_status'] == '1') {
                                                            echo "<span class='badge badge-pill badge-success'>เปิดใช้งาน</span>";
                                                        } elseif ($objResult['w_status'] == '2') {
                                                            echo "<span class='badge badge-pill badge-danger'>ปิดใช้งาน</span>";
                                                        }

                                                        ?> -->
                                            </td>
                                            <td>
                                                <a href='edit_wasadu.php?w_id=<?php echo $objResult["w_id"] ?>'><button type="button" class="btn btn-warning btn-sm" title="แก้ไขข้อมูล"><i class="fa fa-edit"> แก้ไขข้อมูล</i></button></a>
                                                <!-- <a href='delete_wasadu.php?w_id=<?php echo $objResult["w_id"] ?>'><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a> -->
                                                <!-- <a href='edit_status.php?Action=Change&w_id=<?php echo $objResult['w_id']; ?>'><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-power-off"></i></button></a> -->
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!-- หมายเลขหน้า -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php
    if (@$_GET['do'] == 'okok') {
        echo '<script type="text/javascript">
          swal("", "ลบข้อมูลแล้ว !!", "success");
          </script>';

        echo '<meta http-equiv="refresh" content="1;url=show.php" />';
    }
    ?>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container mt-2 mb-4">
                    <h3 class="mt-2">เพิ่มข้อมูลพัสดุ</h3>
                    <div class="container">
                        <!-- ฟอร์มเพิ่มข้อมูล -->

                        <form action="action_create.php" id="form_create" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                            <div class="row">
                                <div class="col-md-9">
                                    <!-- ข้อมูลเนื้อหา -->
                                    <div class="row">
                                        <!-- แถวที่ 1 -->
                                        <div class="col-md-4">
                                            <label for="w_name" class="form-label">ชื่อพัสดุ <span class="text-danger">*</span></label>
                                            <input type="text" id="w_name" name="w_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>&nbsp;หน่วยนับ :&nbsp;</label>
                                                <select class="form-control" name="c_id">
                                                    <option value="">&nbsp;เลือกหน่วยนับ&nbsp;</option>
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
                                        </div>

                                        <div class="col-md-4">
                                            <label for="w_quantity" class="form-label">สต๊อก<span class="text-danger">*</span></label>
                                            <input type="text" id="w_quantity" name="w_quantity" class="form-control" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="w_price" class="form-label">ราคา<span class="text-danger">*</span></label>
                                            <input type="text" id="w_price" name="w_price" class="form-control" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="w_brand" class="form-label">ยี่ห้อ<span class="text-danger">*</span></label>
                                            <input type="text" id="w_brand" name="w_brand" class="form-control" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="w_detail" class="form-label">คุณลักษณะ<span class="text-danger">*</span></label>
                                            <input type="text" id="w_detail" name="w_detail" class="form-control" required>
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label for="w_img" class="form-label">รูปพัสดุ<span class="text-danger">*</span></label>
                                            <input type="file" id="w_img" name="w_img" accept="image/png, image/gif, image/jpeg">
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label for="w_textcom">หมายเหตุ:</label>
                                            <textarea class="form-control" type="text" name="w_textcom" id="w_textcom"></textarea>
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <div class="form-group">
                                                <label>&nbsp;ประเภท :&nbsp;</label>
                                                <select class="form-control" name="w_type">
                                                    <option value="">&nbsp;เลือกประเภท&nbsp;</option>
                                                    <option value="1">พัสดุสำนักงาน</option>
                                                    <option value="2">งานบ้านงานครัว</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- ปุ่มบันทึก -->
                                        <div class="col-md-12 mt-5">
                                            <button type="submit" class="btn btn-success">บันทึก</button>
                                            <button type="reset" class="btn btn-light">ล้างค่า</button>
                                        </div>
                                    </div>
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

<!-- ******************** รูปภาพ ******************** -->
<!-- Modal123 -->
<div class="modal fade" id="imageModal123" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" align="center">
                <!-- Image inside modal -->
                <img src="../assets/images/noimage.png" alt="Image" style="width: 500px; height: 500px;">
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
<!-- ******************** รูปภาพ ******************** -->

<?php
if (@$_GET['do'] == 'ok') {
    echo '<script type="text/javascript">
          swal("", "เพิ่มข้อมูลแล้ว !!", "success");
          </script>';

    // echo '<meta http-equiv="refresh" content="1;url=show.php" />';
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable();
    });
</script>

<?php include '../includes/footer_admin.php'; ?>


<?php mysqli_close($Connection); ?>
</body>

</html>
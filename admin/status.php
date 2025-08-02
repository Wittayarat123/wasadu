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
setlocale(LC_TIME, 'th_TH.utf8');

?>

<?php


isset($_GET['o_id']) ? $id = $_GET['o_id'] : $id = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_date = $_POST["event_date"];
    $sql = "UPDATE order_head SET o_time_s = '$event_date' WHERE o_id = $id";
    if ($Connection->query($sql) === TRUE) {
        echo "<script>window.location='status.php;</script>";
    } else {
        echo "<script>alert('พบข้อผิดพลาด');window.location='status.php';</script>" . $Connection->error;
    }
}

?>


<?php
$sql1 = "SELECT * FROM order_head h
INNER JOIN tb_user u ON h.user_id = u.user_id
INNER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN tb_status s ON h.s_id = s.s_id
-- WHERE s.s_id = '0'
order by o_dttm desc
";  //เรียกข้อมูลมาแสดงทั้งหมด
$result1 = mysqli_query($Connection, $sql1);


$sql = "SELECT * FROM order_detail o
INNER JOIN order_head h ON o.o_id = h.o_id 
INNER JOIN tb_wasadu w ON o.w_id = w.w_id
";
$objQuery = mysqli_query($Connection, $sql);

// ************************พัสดุรออนุมัติ************************

$items_per_page_1 = 15; // จำนวนรายการต่อหน้า

// หากมีการส่งค่าหน้ามาจาก URL
$current_page_1 = isset($_GET['page']) ? $_GET['page'] : 1;
$current_page_1 = max(1, intval($current_page_1));

// คำนวณข้อมูลเริ่มต้นและสิ้นสุดของข้อมูลในหน้านี้
$start_index_1 = ($current_page_1 - 1) * $items_per_page_1;

// ดึงข้อมูลจากฐานข้อมูล
$sql2 = "SELECT * FROM order_head h
INNER JOIN tb_user u ON h.user_id = u.user_id
INNER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN tb_status s ON h.s_id = s.s_id
-- WHERE s.s_id = '0'
order by o_dttm desc LIMIT $start_index_1, $items_per_page_1";
//เรียกข้อมูลมาแสดงทั้งหมด
$result2 = $Connection->query($sql2);

// ************************พัสดุอนุมัติ************************

$sql3 = "SELECT * FROM order_head h
INNER JOIN tb_user u ON h.user_id = u.user_id
INNER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN tb_status s ON h.s_id = s.s_id
WHERE s.s_id = '1'
order by o_dttm desc ";
//เรียกข้อมูลมาแสดงทั้งหมด
$result3 = $Connection->query($sql3);

// ************************พัสดุไม่อนุมัติ************************
$sql4 = "SELECT * FROM order_head h
INNER JOIN tb_user u ON h.user_id = u.user_id
INNER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN tb_status s ON h.s_id = s.s_id
WHERE s.s_id = '2'
order by o_dttm desc 
";  //เรียกข้อมูลมาแสดงทั้งหมด
$result4 = mysqli_query($Connection, $sql4);

?>


<link rel="stylesheet" type="text/css" href="../../assets/DataTables/datatables.min.css" />


<?php include '../includes/navber_admin.php'; ?>

<style>
    .pagination {
        display: flex;
        list-style-type: none;
        padding: 0;
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination a {
        text-decoration: none;
        padding: 5px 10px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        color: black;
    }

    .pagination a:hover {
        background-color: #ddd;
    }
</style>

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
                    <div class="card" style="padding-top: 10px; padding-left: 10px; padding-right: 10px;">
                        <!-- <div class="card-header">
                            <h3 class="card-title">การอนุมัติ</h3>
                        </div> -->
                        <!-- /.card-header -->

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1">
                                <div class="card-body">
                                    <table id="datatables1" class="table table-bordered table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>ลำดับที่</th>
                                                <!-- <th>รหัสผู้ใช้งาน</th> -->
                                                <th>ขื่อ</th>
                                                <th>หน่วยงาน</th>
                                                <th>รายละเอียด</th>
                                                <th>จัดการ</th>
                                                <th>อนุมัติ-ไม่อนุมัติ</th>
                                            </tr>
                                        </thead>
                                        <form action="update_status.php" id="form_update" method="post" enctype="multipart/form-data">
                                            <tbody>
                                                <?php
                                                while ($row2 = mysqli_fetch_array($result2)) {
                                                ?>
                                                    <td align="center"><?php echo $row2["o_id"] ?></td>
                                                    <!-- <td align="center"><?php echo $row2["user_id"] ?></td> -->
                                                    <td><?php echo $row2["user_name"] . " " . $row2["user_surname"] ?></td>
                                                    <td><?php echo $row2["a_name"] ?></td>
                                                    <td>
                                                        สถานะ: <?php if ($row2['s_id'] == '0') {
                                                                    // echo "<button type='button' class='btn btn-warning btn-sm' disabled>รออนุมัติ</button>";
                                                                    // echo "<button class='button_2' disabled></button>";
                                                                    echo "<span class='badge badge-pill badge-warning'>รออนุมัติ</span>";
                                                                } elseif ($row2['s_id'] == '2') {
                                                                    // echo "<button type='button' class='btn btn-danger btn-sm' disabled>ไม่อนุมัติ</button>";
                                                                    // echo "<button class='button_1' disabled></button>";
                                                                    echo "<span class='badge badge-pill badge-danger'>ไม่อนุมัติ</span>";
                                                                } else {
                                                                    // echo "<button type='button' class='btn btn-success btn-sm' disabled>อนุมัติแล้ว</button>";
                                                                    // echo "<button class='button_3' disabled></button>";
                                                                    echo "<span class='badge badge-pill badge-success'>อนุมัติ</span>";
                                                                }
                                                                ?>
                                                        <br>
                                                        <?php
                                                        $months = array(
                                                            '01' => 'มกราคม',
                                                            '02' => 'กุมภาพันธ์',
                                                            '03' => 'มีนาคม',
                                                            '04' => 'เมษายน',
                                                            '05' => 'พฤษภาคม',
                                                            '06' => 'มิถุนายน',
                                                            '07' => 'กรกฎาคม',
                                                            '08' => 'สิงหาคม',
                                                            '09' => 'กันยายน',
                                                            '10' => 'ตุลาคม',
                                                            '11' => 'พฤศจิกายน',
                                                            '12' => 'ธันวาคม'
                                                        );
                                                        // แปลงรูปแบบวันที่
                                                        $dateParts = explode('-', $row2["o_dttm"]);
                                                        $thaiDate = (int)$dateParts[2] . ' ' . $months[$dateParts[1]] . ' ' . ($dateParts[0] + 543); // เพิ่ม 543 เพื่อแปลงเป็น พ.ศ.
                                                        ?>
                                                        วันที่เบิก: <?php echo $thaiDate ?>
                                                        <br>
                                                        <?php
                                                        if ($row2['o_time_s'] == '0000-00-00 00:00:00'){
                                                            echo "วันที่จ่าย: ยังไม่ได้จ่าย";
                                                        }elseif ($row2['o_time_s'] <> '0000-00-00 00:00:00'){
                                                            $months1 = array(
                                                                '01' => 'มกราคม',
                                                                '02' => 'กุมภาพันธ์',
                                                                '03' => 'มีนาคม',
                                                                '04' => 'เมษายน',
                                                                '05' => 'พฤษภาคม',
                                                                '06' => 'มิถุนายน',
                                                                '07' => 'กรกฎาคม',
                                                                '08' => 'สิงหาคม',
                                                                '09' => 'กันยายน',
                                                                '10' => 'ตุลาคม',
                                                                '11' => 'พฤศจิกายน',
                                                                '12' => 'ธันวาคม'
                                                            );
                                                            // แปลงรูปแบบวันที่
                                                            $dateParts1 = explode('-', $row2["o_time_s"]);
                                                            $thaiDate1 = (int)$dateParts1[2] . ' ' . $months1[$dateParts1[1]] . ' ' . ($dateParts1[0] + 543); // เพิ่ม 543 เพื่อแปลงเป็น พ.ศ.

                                                            echo "วันที่จ่าย: $thaiDate1";
                                                        }?>
                                                        <br>
                                                        <form action="status.php?o_id=<?php echo $row2["o_id"] ?>" method="post">
                                                            <label for="event_date"></label>
                                                            <input type="date" id="event_date" name="event_date" required>
                                                            <button type="submit" class="btn btn-outline-success btn-sm">บันทึก</button>
                                                        </form>
                                                    </td>
                                                    <td align="center">
                                                        <a href='status_detail.php?o_id=<?php echo $row2["o_id"] ?>'><button type="button" class="btn btn-outline-secondary btn-sm">รายการเบิก</button></a>
                                                        <a href='report.php?o_id=<?php echo $row2["o_id"] ?>' target="_blank"><button type="button" class="btn btn-outline-primary btn-sm">รายงานใบเบิก</button></a>
                                                        <?php
                                                        if ($row2['s_id'] == '1') {
                                                            echo  "<a href='receivedQuantity.php?o_id=" . $row2["o_id"] . "' target='_blank'><button type='button' class='btn btn-outline-info btn-sm'>จ่ายพัสดุ</button></a>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="update_status.php?Action=Change&o_id=<?php echo $row2['o_id']; ?>" onclick="return confirm('ยืนยันการอนุมัติ')">
                                                            <?php if ($row2['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                        <a href="cancel.php?Action=Change&o_id=<?php echo $row2['o_id']; ?>" onclick="return confirm('ยืนยันการยกเลิก')">
                                                            <?php if ($row2['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                        <!--******************************** ปุ่มลบรายการเบิกพัสดุ *************************************** -->
                                                        <a href='delete_order.php?o_id=<?php echo $row2["o_id"] ?>' onclick="return confirm('ยื่นยันลบรายการเบิก')"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>
                                                        </a>
                                                        <!--******************************** ปุ่มลบรายการเบิกพัสดุ *************************************** -->
                                                    </td>
                                            </tbody>
                                        <?php
                                                }
                                        ?>
                                        </form>
                                    </table>
                                    <?php
                                    // ดึงข้อมูลทั้งหมดจากฐานข้อมูล
                                    $sql123 = "SELECT COUNT(*) AS total FROM order_head ";
                                    $result123 = $Connection->query($sql123);
                                    $row123 = $result123->fetch_assoc();
                                    $total_items = $row123['total'];

                                    // คำนวณจำนวนหน้าทั้งหมด
                                    $total_pages = ceil($total_items / $items_per_page_1);

                                    // แสดงปุ่ม Pagination
                                    echo '<ul class="pagination">';
                                    if ($current_page_1 > 1) {
                                        echo '<li><a href="status.php?page=1">หน้าแรก</a></li>';
                                        echo '<li><a href="status.php?page=' . ($current_page_1 - 1) . '">ย้อนกลับ</a></li>';
                                    }
                                    if ($current_page_1 > 3) {
                                        echo '<li>...</li>';
                                    }
                                    $start_page_1 = max(1, $current_page_1 - 2);
                                    $end_page = min($total_pages, $start_page_1 + 4);
                                    for ($page = $start_page_1; $page <= $end_page; $page++) {
                                        echo '<li><a href="status.php?page=' . $page . '">' . $page . '</a></li>';
                                    }
                                    if ($current_page_1 < $total_pages - 2) {
                                        echo '<li>...</li>';
                                    }
                                    if ($current_page_1 < $total_pages) {
                                        echo '<li><a href="status.php?page=' . ($current_page_1 + 1) . '">หน้าต่อไป</a></li>';
                                        echo '<li><a href="status.php?page=' . $total_pages . '">หน้าสุดท้าย</a></li>';
                                    }
                                    echo '</ul>';
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>




</div>
<script type="text/javascript" src="../../assets/DataTables/datatables.min.js"></script>
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
        $('#datatables1').DataTable();
    });
</script>


<?php
if (@$_GET['do'] == 'ok') {
    echo '<script type="text/javascript">
          swal("", "เพิ่มข้อมูลแล้ว !!", "success");
          </script>';

    echo '<meta http-equiv="refresh" content="1;url=status.php" />';
}
?>


<?php include '../includes/footer_admin.php'; ?>
<?php mysqli_close($Connection); ?>
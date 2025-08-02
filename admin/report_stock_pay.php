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

$items_per_page = 15; // จำนวนรายการต่อหน้า

// หากมีการส่งค่าหน้ามาจาก URL
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$current_page = max(1, intval($current_page));

// คำนวณข้อมูลเริ่มต้นและสิ้นสุดของข้อมูลในหน้านี้
$start_index = ($current_page - 1) * $items_per_page;

// ดึงข้อมูลจากฐานข้อมูล
$sql1 = "SELECT * FROM tb_pay_order order by pay_id desc LIMIT $start_index, $items_per_page";
$result1 = $Connection->query($sql1);


?>

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
                    <h1>รายงานการเพิ่มสต๊อก/ใบเสร็จ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายงานการเพิ่มสต๊อก/ใบเสร็จ</li>
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
                            <h3 class="card-title">รายงานการเพิ่มสต๊อก/ใบเสร็จ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-hover mb-0">
                                <thead>
                                    <tr class="bg-info">
                                        <th scope="col">ลำดับที่</th>
                                        <th scope="col">ขื่อ</th>
                                        <th scope="col">เล่มที่</th>
                                        <th scope="col">เลขที่</th>
                                        <th scope="col">วันรับ</th>
                                        <th scope="col">รายงาน</th>
                                        <th scope="col">หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <form action="update_status.php" id="form_update" method="post" enctype="multipart/form-data">
                                    <tbody>
                                        <?php while ($row1 = $result1->fetch_assoc()) {

                                            echo '<td>' . $row1['pay_id'] . '</td>';
                                            echo '<td>' . $row1['pay_head'] . '</td>';
                                            echo '<td>' . $row1['pay_d'] . '</td>';
                                            echo '<td>' . $row1['pay_t'] . '</td>';

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
                                            $dateParts = explode('-', $row1["pay_time"]);
                                            $thaiDate = (int)$dateParts[2] . ' ' . $months[$dateParts[1]] . ' ' . ($dateParts[0] + 543); // เพิ่ม 543 เพื่อแปลงเป็น พ.ศ.

                                            echo '<td>' . $thaiDate . '</td>';
                                            echo "<td> <a href='report_stock_2.php?pay_id=" . $row1["pay_id"] . "' target='_blank' ><button type='button' class='btn btn-outline-primary btn-sm'>รายงาน</button></a> </td>";
                                            echo '<td>' . $row1['pay_text'] . '</td>';

                                            echo '</tbody>';
                                        }


                                        ?>
                                </form>
                            </table>
                            <?php

                            // ดึงข้อมูลทั้งหมดจากฐานข้อมูล
                            $sql = "SELECT COUNT(*) AS total FROM tb_pay_order";
                            $result = $Connection->query($sql);
                            $row = $result->fetch_assoc();
                            $total_items = $row['total'];

                            // คำนวณจำนวนหน้าทั้งหมด
                            $total_pages = ceil($total_items / $items_per_page);

                            // แสดงปุ่ม Pagination
                            echo '<ul class="pagination">';
                            if ($current_page > 1) {
                                echo '<li><a href="report_stock_pay.php?page=1">First</a></li>';
                                echo '<li><a href="report_stock_pay.php?page=' . ($current_page - 1) . '">Previous</a></li>';
                            }
                            if ($current_page > 3) {
                                echo '<li>...</li>';
                            }
                            $start_page = max(1, $current_page - 2);
                            $end_page = min($total_pages, $start_page + 4);
                            for ($page = $start_page; $page <= $end_page; $page++) {
                                echo '<li><a href="report_stock_pay.php?page=' . $page . '">' . $page . '</a></li>';
                            }
                            if ($current_page < $total_pages - 2) {
                                echo '<li>...</li>';
                            }
                            if ($current_page < $total_pages) {
                                echo '<li><a href="report_stock_pay.php?page=' . ($current_page + 1) . '">Next</a></li>';
                                echo '<li><a href="report_stock_pay.php?page=' . $total_pages . '">Last</a></li>';
                            }
                            echo '</ul>';

                            ?>
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

    echo '<meta http-equiv="refresh" content="1;url=status.php" />';
}
?>


<script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable();
    });
</script>

<?php mysqli_close($Connection); ?>
<?php include '../includes/footer_admin.php'; ?>
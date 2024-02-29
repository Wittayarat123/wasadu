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
$sql1 = "SELECT count(user_id) FROM tb_user";
$objQuery1 = mysqli_query($Connection, $sql1);

$sql2 = "SELECT count(a_id) FROM tb_agency";
$objQuery2 = mysqli_query($Connection, $sql2);

$sql3 = "SELECT count(w_id) FROM tb_wasadu";
$objQuery3 = mysqli_query($Connection, $sql3);

$sql4 = "SELECT count(c_id) FROM tb_count";
$objQuery4 = mysqli_query($Connection, $sql4);

$sql5 = "SELECT count(s_id) FROM order_head 
         WHERE s_id = '0' ";
$objQuery5 = mysqli_query($Connection, $sql5);

$sql6 = "SELECT count(s_id) FROM order_head 
         WHERE s_id = '1' ";
$objQuery6 = mysqli_query($Connection, $sql6);

$sql7 = "SELECT count(s_id) FROM order_head 
         WHERE s_id = '2' ";
$objQuery7 = mysqli_query($Connection, $sql7);

$sql8 = "SELECT count(s_id) FROM order_head 
         ";
$objQuery8 = mysqli_query($Connection, $sql8);

?>


<title><?php echo $title; ?></title>
<link href="../assets/images/BG.png" rel="icon">


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link href='http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css' rel='stylesheet' />
<link href='http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.print.css' rel='stylesheet' media='print' />
<style>
    #calendar {
        margin-top: 10px;
        width: auto;
        height: auto;
    }
</style>

<?php include '../includes/navber_admin.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php
                            while ($objResult1 = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                            ?>
                                <h3><i class="fa fa-users" style="font-size:36px"></i> &nbsp;<?php echo $objResult1['count(user_id)']; ?></h3>
                            <?php } ?>
                            <p>ผู้ใช้งาน</p>
                        </div>

                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php
                            while ($objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC)) {
                            ?>
                                <h3><i class="fa fa-building" style="font-size:36px"></i> &nbsp;<?php echo $objResult2['count(a_id)']; ?></h3>
                            <?php } ?>
                            <p>หน่วยงาน</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php
                            while ($objResult3 = mysqli_fetch_array($objQuery3, MYSQLI_ASSOC)) {
                            ?>
                                <h3><i class="fa fa-window-restore" style="font-size:36px"></i>&nbsp;<?php echo $objResult3['count(w_id)']; ?></h3>
                                <p>พัสดุ</p>
                            <?php } ?>
                        </div>
                        <div class="icon">
                            <i class="fa fa-window-restore"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php
                            while ($objResult4 = mysqli_fetch_array($objQuery4, MYSQLI_ASSOC)) {
                            ?>
                                <h3><i class="fa fa-window-restore" style="font-size:36px"></i> &nbsp;<?php echo $objResult4['count(c_id)']; ?></h3>
                                <p>หน่วยนับ</p>
                            <?php } ?>
                        </div>
                        <div class="icon">
                            <i class="fa fa-window-restore"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php
                            while ($objResult5 = mysqli_fetch_array($objQuery5, MYSQLI_ASSOC)) {
                            ?>
                                <h3><i class="fa fa-check" style="font-size:36px"></i>&nbsp;<?php echo $objResult5['count(s_id)']; ?></h3>
                            <?php } ?>
                            <p>การเบิก-จ่าย ที่รออนุมัติ</p>
                        </div>

                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php
                            while ($objResult6 = mysqli_fetch_array($objQuery6, MYSQLI_ASSOC)) {
                            ?>
                                <h3><i class="fa fa-check" style="font-size:36px;"></i>&nbsp;<?php echo $objResult6['count(s_id)']; ?></h3>
                            <?php } ?>
                            <p>การเบิก-จ่าย อนุมัติแล้ว</p>
                        </div>

                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <?php
                            while ($objResult7 = mysqli_fetch_array($objQuery7, MYSQLI_ASSOC)) {
                            ?>
                                <h3><i class="fa fa-close" style="font-size:36px;"></i>&nbsp;<?php echo $objResult7['count(s_id)']; ?></h3>
                            <?php } ?>
                            <p>การเบิก-จ่าย ที่ไม่อนุมัติ</p>
                        </div>

                        <div class="icon">
                            <i class="far fa-window-close"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-gradient-navy">
                        <div class="inner">
                            <?php
                            while ($objResult8 = mysqli_fetch_array($objQuery8, MYSQLI_ASSOC)) {
                            ?>
                                <h3><i class="fa fa-shopping-cart" style="font-size:36px;"></i>&nbsp;<?php echo $objResult8['count(s_id)']; ?></h3>
                            <?php } ?>
                            <p>การเบิก-จ่าย ทั้งหมด</p>
                        </div>

                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-6 col-6 col-md-12 col-sm-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">จำนวนพัสดุ/+สต๊อก</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- สร้างแผนภูมิแสดงข้อมูล -->
                            <canvas id="chart" style="min-height: 350px; height: 350px; max-height: auto; max-width: auto;"></canvas>
                            <script>
                                // ดึงข้อมูลจากฐานข้อมูลสำหรับการสร้างแผนภูมิ
                                <?php
                                // ดึงข้อมูลจำนวนพัสดุแต่ละชนิด
                                $query1212121 = "SELECT     
                                                        w.w_name, 
                                                        SUM( w.w_quantity - '100' ) AS sum_1
                                                     FROM tb_wasadu w
                                                     WHERE w.w_quantity > '0' 
                                                     GROUP BY
                                                        w.w_name 
                                                     ORDER BY
                                                        sum_1 DESC limit 10
                                                     ";
                                $result1212121 = mysqli_query($Connection, $query1212121);

                                if (!$result1212121) {
                                    die('เกิดข้อผิดพลาดในการดึงข้อมูล: ' . mysqli_error($Connection));
                                }

                                // สร้างข้อมูลและป้ายกำกับสำหรับแผนภูมิ
                                $labels = [];
                                $data = [];
                                while ($row = mysqli_fetch_assoc($result1212121)) {
                                    $labels[] = $row['w_name'];
                                    $data[] = $row['sum_1'];
                                }

                                // ปิดการเชื่อมต่อฐานข้อมูล
                                mysqli_close($Connection);
                                ?>

                                // สร้างแผนภูมิด้วย Chart.js
                                var ctx = document.getElementById('chart').getContext('2d');
                                var chart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: <?php echo json_encode($labels); ?>,
                                        datasets: [{
                                            label: 'จำนวน คงคลัง',
                                            data: <?php echo json_encode($data); ?>,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.8)',
                                                'rgba(255, 159, 64, 0.8)',
                                                'rgba(255, 205, 86, 0.8)',
                                                'rgba(75, 192, 192, 0.8)',
                                                'rgba(54, 162, 235, 0.8)',
                                                'rgba(153, 102, 255, 0.8)',
                                                'rgba(134, 209, 246, 0.8)',
                                                'rgba(134, 246, 238, 0.8)',
                                                'rgba(134, 246, 170, 0.8)',
                                                'rgba(194, 246, 134, 0.8)'
                                            ],
                                            borderColor: [
                                                'rgb(255, 99, 132 ,1)',
                                                'rgb(255, 159, 64 ,1)',
                                                'rgb(255, 205, 86 ,1)',
                                                'rgb(75, 192, 192 ,1)',
                                                'rgb(54, 162, 235 ,1)',
                                                'rgb(153, 102, 255 ,1)',
                                                'rgba(134, 209, 246,1)',
                                                'rgba(134, 246, 238,1)',
                                                'rgba(134, 246, 170,1)',
                                                'rgba(194, 246, 134,1)'
                                            ],
                                            borderWidth: 5,
                                            borderRadius: 20,
                                            borderSkipped: false,
                                            is3D: true
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        },
                                        // plugins: {
                                        //     zoom: {
                                        //         zoom: {
                                        //             wheel: {
                                        //                 enabled: true,
                                        //             },
                                        //             pinch: {
                                        //                 enabled: true
                                        //             }
                                        //         }
                                        //     }
                                        // }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-6 col-md-12 col-sm-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">การเบิกพัสดุ</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <canvas id="doughnutChart" style="min-height: 350px; height: 350px; max-height: auto; max-width: auto;"></canvas>
                            <script>
                                // ดึงข้อมูลจากฐานข้อมูลและสร้างกราฟ
                                <?php
                                // เชื่อมต่อฐานข้อมูล
                                $connection = mysqli_connect('172.20.250.202', 'sa', 'wangchao27443', 'wasadu');
                                mysqli_set_charset($connection, "utf8");
                                date_default_timezone_set('Asia/Bangkok');
                                if (!$connection) {
                                    die('ไม่สามารถเชื่อมต่อฐานข้อมูล: ' . mysqli_connect_error());
                                }

                                // ดึงข้อมูลพัสดุจากฐานข้อมูล
                                $query = "  SELECT  	
                                            tb_wasadu.w_name,
                                            COUNT(order_detail.d_qty) AS cc
                                        FROM
                                            order_detail
                                        LEFT JOIN tb_wasadu ON tb_wasadu.w_id = order_detail.w_id
                                        LEFT JOIN order_head ON order_head.o_id = order_detail.o_id
                                        WHERE 
                                            order_head.s_id = '1'
                                        GROUP BY 
                                            tb_wasadu.w_name
                                        Limit 10";
                                $result = mysqli_query($connection, $query);

                                if (!$result) {
                                    die('เกิดข้อผิดพลาดในการดึงข้อมูล: ' . mysqli_error($connection));
                                }

                                // สร้างข้อมูลสำหรับกราฟ
                                $labels = [];
                                $data = [];
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $labels[] = $row['w_name'];
                                    $data[] = $row['cc'];
                                }

                                // ปิดการเชื่อมต่อฐานข้อมูล
                                mysqli_close($connection);
                                ?>

                                // สร้างกราฟแบบ Doughnut Chart
                                var ctx = document.getElementById('doughnutChart').getContext('2d');
                                var doughnutChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: <?php echo json_encode($labels); ?>,
                                        datasets: [{
                                            label: 'จำนวน',
                                            data: <?php echo json_encode($data); ?>,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.8)',
                                                'rgba(255, 159, 64, 0.8)',
                                                'rgba(255, 205, 86, 0.8)',
                                                'rgba(75, 192, 192, 0.8)',
                                                'rgba(54, 162, 235, 0.8)',
                                                'rgba(153, 102, 255, 0.8)',
                                                'rgba(134, 209, 246, 0.8)',
                                                'rgba(134, 246, 238, 0.8)',
                                                'rgba(134, 246, 170, 0.8)',
                                                'rgba(194, 246, 134, 0.8)'
                                            ],
                                            borderColor: [
                                                'rgb(255, 99, 132 ,1)',
                                                'rgb(255, 159, 64 ,1)',
                                                'rgb(255, 205, 86 ,1)',
                                                'rgb(75, 192, 192 ,1)',
                                                'rgb(54, 162, 235 ,1)',
                                                'rgb(153, 102, 255 ,1)',
                                                'rgba(134, 209, 246,1)',
                                                'rgba(134, 246, 238,1)',
                                                'rgba(134, 246, 170,1)',
                                                'rgba(194, 246, 134,1)'
                                            ],
                                            borderWidth: 5,
                                            is3D: true
                                        }]
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- Javascript -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.4.0/lib/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js'></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!-- นำเข้า script File -->
<script src='script.js'></script>

<?php include '../includes/footer_admin.php'; ?>
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
$sql11 = "   SELECT rs.rs_name, COUNT(rp.rs_id) FROM rp_repair rp
            LEFT JOIN rp_repair_status rs ON rs.rs_id = rp.rs_id
            GROUP BY rs.rs_name DESC";
$objQuery11 = mysqli_query($Connection, $sql11);

$sql12 = "   SELECT rs.rs_name, COUNT(rp.rs_id) FROM rp_repair rp
            LEFT JOIN rp_repair_status rs ON rs.rs_id = rp.rs_id
            GROUP BY rs.rs_name DESC";
$objQuery12 = mysqli_query($Connection, $sql12);

$sql1 = "SELECT count(rp_id) FROM rp_repair";
$objQuery1 = mysqli_query($Connection, $sql1);

// แจ้งซ่อม
$sql2 = "SELECT count(rs_id) FROM rp_repair WHERE rs_id = '1'";
$objQuery2 = mysqli_query($Connection, $sql2);

// กำลังดำเนินการ
$sql3 = "SELECT count(rs_id) FROM rp_repair WHERE rs_id = '2'";
$objQuery3 = mysqli_query($Connection, $sql3);

// รออะไหล่
$sql4 = "SELECT count(rs_id) FROM rp_repair WHERE rs_id = '3'";
$objQuery4 = mysqli_query($Connection, $sql4);

// ซ่อมสำเร็จ
$sql5 = "SELECT count(rs_id) FROM rp_repair WHERE rs_id = '4'";
$objQuery5 = mysqli_query($Connection, $sql5);

// ซ่อมไม่สำเร็จ
$sql6 = "SELECT count(rs_id) FROM rp_repair WHERE rs_id = '5'";
$objQuery6 = mysqli_query($Connection, $sql6);

// ยกเลิกการซ่อม
$sql7 = "SELECT count(rs_id) FROM rp_repair WHERE rs_id = '6'";
$objQuery7 = mysqli_query($Connection, $sql7);

// ส่งมอบเรียบร้อย
$sql8 = "SELECT count(rs_id) FROM rp_repair WHERE rs_id = '7'";
$objQuery8 = mysqli_query($Connection, $sql8);

?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../assets/css/service.css">

<?php include '../../includes/navbar_service_it_admin.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dashboard</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mt-3">
                                    <div class="row">
                                        <!-- justify-content-md-center -->
                                        <!-- Card -->
                                        <div class="col-md-2">
                                            <div class="card bg-info text-white">
                                                <div class="card-header">แจ้งซ่อมทั้งหมด</div>
                                                <div class="card-body text-center">
                                                    <?php
                                                    while ($objResult1 = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                                                    ?>
                                                        <h1><i class="fa fa-users" style="font-size:36px"></i>
                                                            &nbsp;<?php echo $objResult1['count(rp_id)']; ?></h1>
                                                        <br>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="col-md-2">
                                        <div class="card bg-info text-white">
                                            <div class="card-header">แจ้งซ่อม</div>
                                            <div class="card-body text-center">
                                                <?php
                                                while ($objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC)) {
                                                ?>
                                                    <h1><i class="fa fa-users" style="font-size:36px"></i>
                                                        &nbsp;<?php echo $objResult2['count(rs_id)']; ?></h1>
                                                    <br>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- End Card -->

                                <!-- Card -->
                                <div class="col-md-2">
                                    <div class="card bg-info text-white">
                                        <div class="card-header">กำลังดำเนินการ</div>
                                        <div class="card-body text-center">
                                            <?php
                                            while ($objResult3 = mysqli_fetch_array($objQuery3, MYSQLI_ASSOC)) {
                                            ?>
                                                <h1><i class="fa fa-users" style="font-size:36px"></i>
                                                    &nbsp;<?php echo $objResult3['count(rs_id)']; ?></h1>
                                                <br>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- End Card -->

                            <!-- Card -->
                            <div class="col-md-2">
                                <div class="card bg-info text-white">
                                    <div class="card-header">รออะไหล่</div>
                                    <div class="card-body text-center">
                                        <?php
                                        while ($objResult4 = mysqli_fetch_array($objQuery4, MYSQLI_ASSOC)) {
                                        ?>
                                            <h1><i class="fa fa-users" style="font-size:36px"></i>
                                                &nbsp;<?php echo $objResult4['count(rs_id)']; ?></h1>
                                            <br>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="col-md-2">
                            <div class="card bg-info text-white">
                                <div class="card-header">ซ่อมสำเร็จ</div>
                                <div class="card-body text-center">
                                    <?php
                                    while ($objResult5 = mysqli_fetch_array($objQuery5, MYSQLI_ASSOC)) {
                                    ?>
                                        <h1><i class="fa fa-users" style="font-size:36px"></i>
                                            &nbsp;<?php echo $objResult5['count(rs_id)']; ?></h1>
                                        <br>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- End Card -->

                    <!-- Card -->
                    <div class="col-md-2">
                        <div class="card bg-info text-white">
                            <div class="card-header">ซ่อมไม่สำเร็จ</div>
                            <div class="card-body text-center">
                                <?php
                                while ($objResult6 = mysqli_fetch_array($objQuery6, MYSQLI_ASSOC)) {
                                ?>
                                    <h1><i class="fa fa-users" style="font-size:36px"></i>
                                        &nbsp;<?php echo $objResult6['count(rs_id)']; ?></h1>
                                    <br>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Card -->

                <!-- Card -->
                <div class="col-md-2 mt-4">
                    <div class="card bg-info text-white">
                        <div class="card-header">ยกเลิกการซ่อม</div>
                        <div class="card-body text-center">
                            <?php
                            while ($objResult7 = mysqli_fetch_array($objQuery7, MYSQLI_ASSOC)) {
                            ?>
                                <h1><i class="fa fa-users" style="font-size:36px"></i>
                                    &nbsp;<?php echo $objResult7['count(rs_id)']; ?></h1>
                                <br>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End Card -->

            <!-- Card -->
            <div class="col-md-2 mt-4">
                <div class="card bg-info text-white">
                    <div class="card-header">ส่งมอบเรียบร้อย</div>
                    <div class="card-body text-center">
                        <?php
                        while ($objResult8 = mysqli_fetch_array($objQuery8, MYSQLI_ASSOC)) {
                        ?>
                            <h1><i class="fa fa-users" style="font-size:36px"></i>
                                &nbsp;<?php echo $objResult8['count(rs_id)']; ?></h1>
                            <br>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- End Card -->
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    จำนวนงานแยกตามประเภท
                                    <!-- สร้างแผนภูมิแสดงข้อมูล -->
                                    <canvas id="chart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                                    <script>
                                        // ดึงข้อมูลจากฐานข้อมูลสำหรับการสร้างแผนภูมิ
                                        <?php
                                        // ดึงข้อมูลจำนวนพัสดุแต่ละชนิด
                                        $query111 = "SELECT rs.rs_name, COUNT(rp.rs_id)as sum_1 FROM rp_repair rp
                                                LEFT JOIN rp_repair_status rs ON rs.rs_id = rp.rs_id
                                                GROUP BY rs.rs_name DESC
                                                     ";
                                        $result111 = mysqli_query($Connection, $query111);

                                        if (!$result111) {
                                            die('เกิดข้อผิดพลาดในการดึงข้อมูล: ' . mysqli_error($Connection));
                                        }

                                        // สร้างข้อมูลและป้ายกำกับสำหรับแผนภูมิ
                                        $labels = [];
                                        $data = [];
                                        while ($row = mysqli_fetch_assoc($result111)) {
                                            $labels[] = $row['rs_name'];
                                            $data[] = $row['sum_1'];
                                        }

                                        // ปิดการเชื่อมต่อฐานข้อมูล
                                        mysqli_close($Connection);
                                        ?>

                                        // สร้างแผนภูมิด้วย Chart.js
                                        var ctx = document.getElementById('chart').getContext('2d');
                                        var chart = new Chart(ctx, {
                                            type: 'pie',
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
                                                        'rgba(153, 102, 255, 0.8)'
                                                    ],
                                                    borderColor: [
                                                        'rgb(255, 99, 132 ,1)',
                                                        'rgb(255, 159, 64 ,1)',
                                                        'rgb(255, 205, 86 ,1)',
                                                        'rgb(75, 192, 192 ,1)',
                                                        'rgb(54, 162, 235 ,1)',
                                                        'rgb(153, 102, 255 ,1)'
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

                                <div class="col-lg-6">
                                    จำนวนงานแยกตามสถานะ
                                    <canvas id="doughnutChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
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
                                        $query = "  SELECT rs.rs_name, COUNT(rp.rs_id) as cc FROM rp_repair rp
                                                    LEFT JOIN rp_repair_status rs ON rs.rs_id = rp.rs_id
                                                    GROUP BY rs.rs_name DESC";
                                        $result = mysqli_query($connection, $query);

                                        if (!$result) {
                                            die('เกิดข้อผิดพลาดในการดึงข้อมูล: ' . mysqli_error($connection));
                                        }

                                        // สร้างข้อมูลสำหรับกราฟ
                                        $labels = [];
                                        $data = [];
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $labels[] = $row['rs_name'];
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
                                                        'rgba(54, 162, 235, 0.8)',
                                                        'rgba(255, 205, 86, 0.8)',
                                                        'rgba(75, 192, 192, 0.8)',
                                                        'rgba(153, 102, 255, 0.8)',
                                                        'rgba(255, 159, 64, 0.8)'
                                                    ],
                                                    borderColor: [
                                                        'rgba(255, 99, 132, 1)',
                                                        'rgba(54, 162, 235, 1)',
                                                        'rgba(255, 205, 86, 1)',
                                                        'rgba(75, 192, 192, 1)',
                                                        'rgba(153, 102, 255, 1)',
                                                        'rgba(255, 159, 64, 1)'
                                                    ],
                                                    borderWidth: 5,
                                                    is3D: true
                                                }]
                                            }
                                        });
                                    </script>
                                </div>

                                <div class="col-lg-6">
                                    จำนวนงานแยกตามประเภท
                                    <table class="table table-bordered table-success">
                                        <thead>
                                            <th>#</th>
                                            <th>ประเภทงานซ่อม</th>
                                            <th style="text-align: center;">จำนวน</th>
                                            <th style="text-align: center;">view</th>
                                        </thead>
                                        <?php
                                        while ($objResult11 = mysqli_fetch_array($objQuery11, MYSQLI_ASSOC)) {
                                        ?>
                                            <tbody>
                                                <td>#</td>
                                                <td><?php echo $objResult11['rs_name']; ?></td>
                                                <td align="center"><?php echo $objResult11['COUNT(rp.rs_id)']; ?></td>
                                                <td align="center"><button type="button" class="btn btn-outline-primary btn-sm"> View </button></td>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    จำนวนงานแยกตามสถานะ
                                    <table class="table table-bordered table-warning">
                                        <thead>
                                            <th>#</th>
                                            <th>สถานะงานซ่อม</th>
                                            <th style="text-align: center;">จำนวน</th>
                                            <th style="text-align: center;">view</th>
                                        </thead>
                                        <?php
                                        while ($objResult12 = mysqli_fetch_array($objQuery12, MYSQLI_ASSOC)) {
                                        ?>
                                            <tbody>
                                                <td>#</td>
                                                <td><?php echo $objResult12['rs_name']; ?></td>
                                                <td align="center"><?php echo $objResult12['COUNT(rp.rs_id)']; ?></td>
                                                <td align="center"><button type="button" class="btn btn-outline-primary btn-sm"> View </button></td>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                </body>
<?php
require_once('../connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
}

$sql1 = "   SELECT rs.rs_name, COUNT(rp.rs_id) FROM rp_repair rp
            LEFT JOIN rp_repair_status rs ON rs.rs_id = rp.rs_id
            GROUP BY rs.rs_name DESC";
$objQuery1 = mysqli_query($Connection, $sql1);

$sql2 = "   SELECT rs.rs_name, COUNT(rp.rs_id) FROM rp_repair rp
            LEFT JOIN rp_repair_status rs ON rs.rs_id = rp.rs_id
            GROUP BY rs.rs_name DESC";
$objQuery2 = mysqli_query($Connection, $sql2);

?>

<?php include_once '../includes/navbar_service_it.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dashboard</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
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
                                        while ($objResult1 = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                                        ?>
                                            <tbody>
                                                <td>#</td>
                                                <td><?php echo $objResult1['rs_name']; ?></td>
                                                <td align="center"><?php echo $objResult1['COUNT(rp.rs_id)']; ?></td>
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
                                        while ($objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC)) {
                                        ?>
                                            <tbody>
                                                <td>#</td>
                                                <td><?php echo $objResult2['rs_name']; ?></td>
                                                <td align="center"><?php echo $objResult2['COUNT(rp.rs_id)']; ?></td>
                                                <td align="center"><button type="button" class="btn btn-outline-primary btn-sm"> View </button></td>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once '../includes/footer_admin.php'; ?>
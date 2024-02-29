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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="../assets/images/BG.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/main.css">
    <link rel="stylesheet" type="text/css" href="../assets/DataTables/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">

    <style>
        table {
            width: 100%;
        }

        th {
            text-align: center;
        }
    </style>

    <style type="text/css">
        @media print {
            #hid {
                display: none;
                /* ซ่อน  */
            }

            #sidebarMenu {
                display: none;
                /* ซ่อน  */
            }

            #main-navbar {
                display: none;
                /* ซ่อน  */
            }
        }
    </style>
</head>

<?php include '../includes/navber_admin.php'; ?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รวมรายการเบิกทุกหน่วยงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รวมรายการเบิกทุกหน่วยงาน</li>
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
                    <div class="card" style="border: 0xp;">
                        <div class="card-header">
                            <h3 class="card-title">รวมรายการเบิกทุกหน่วยงาน</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="panel-body mb-3" id="hid">
                                <form id="form1" name="form1" class="form-inline" method="post" action="report_total_agen.php">
                                    <div class="form-group">
                                        <label for="exampleInputName2">วันที่ :&nbsp;</label>
                                        <input type="date" name="d_s" class="form-control" width="270" />
                                        <!-- <input type="date" name="d_s" id="datepicker" width="270" /> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">&nbsp;ถึงวันที่ :&nbsp;</label>
                                        <input type="date" name="d_e" class="form-control" width="270" />
                                        <!-- <input type="date" name="d_e" id="datepicker2" width="270" /> -->
                                    </div>
                                    &nbsp;<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
                                </form>
                            </div>
                            <!--**** วันที่ **** -->
                            <script>
                                $('#datepicker').datepicker({
                                    uiLibrary: 'bootstrap',
                                    format: "yyyy-mm-dd",
                                    type: "date"
                                });
                            </script>

                            <script>
                                $('#datepicker2').datepicker({
                                    uiLibrary: 'bootstrap',
                                    format: "yyyy-mm-dd",
                                    type: "date"
                                });
                            </script>
                            <div class="row">
                                <div class="col-12">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <?php  //เรียกEBมาแสดง
                                            $d_s = $_POST['d_s']; //ตัวแปรวันที่เริ่มต้น
                                            $d_e = $_POST['d_e']; //ตัวแปรวันที่สิ้นสุด

                                            $sql1 = "   SELECT a.a_name, h.*, u.*, a.* FROM order_head h
                                                                LEFT JOIN tb_user u ON u.user_id = h.user_id
                                                                LEFT JOIN tb_agency a ON a.a_id = u.a_id
                                                                WHERE h.o_dttm BETWEEN '$d_s' AND '$d_e'
                                                                AND h.s_id = '1'
                                                                GROUP BY a.a_id";
                                            $result1 = mysqli_query($Connection, $sql1);
                                            while ($row1 = $result1->fetch_array(MYSQLI_BOTH)) {
                                                $a_name = $row1['a_name'];
                                                $a_id = $row1['a_id'];
                                            ?>
                                                <div class="sidenav">
                                                    <h5><?php echo $row1['a_name']; ?></h5>
                                                    <div class="dropdown-container">
                                                        <div class="table-responsive">
                                                            <table class="table table-success table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 5%; text-align:center">ลำดับ</th>
                                                                        <th style="width: 25%; text-align:center">รายการ</th>
                                                                        <th style="width: 5%; text-align:center">ราคา</th>
                                                                        <th style="width: 5%; text-align:center">หน่วย</th>
                                                                        <th style="width: 7%; text-align:center">รายรับทั้งเดือน</th>
                                                                        <th style="width: 5%; text-align:center">รวมราคาซื้อ</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $num = 1;
                                                                    $d_s = $_POST['d_s']; //ตัวแปรวันที่เริ่มต้น
                                                                    $d_e = $_POST['d_e']; //ตัวแปรวันที่สิ้นสุด
                                                                    // $a_id = $_POST['a_id']; //หน่วยงาน
                                                                    echo "วันที่ &nbsp;";
                                                                    echo $d_s;
                                                                    echo "&nbsp;&nbsp;";
                                                                    echo "ถึงวันที่ &nbsp;";
                                                                    echo $d_e;
                                                                    echo "&nbsp;&nbsp;";


                                                                    $sql = "SELECT
                                                                                w.w_name,
                                                                                SUM( d.d_qty ) AS sum_1,
                                                                                c.c_name,
                                                                                w.w_price,
                                                                                SUM( d.d_qty * w.w_price ) AS sum_2 
                                                                            FROM
                                                                                order_detail d
                                                                                LEFT JOIN tb_wasadu w ON w.w_id = d.w_id
                                                                                LEFT JOIN order_head o ON o.o_id = d.o_id
                                                                                LEFT JOIN tb_count c ON c.c_id = w.c_id
                                                                                LEFT JOIN tb_user u ON u.user_id = o.user_id
                                                                                LEFT JOIN tb_agency a ON a.a_id = u.a_id
                                                                                LEFT JOIN tb_status s ON s.s_id = o.s_id 
                                                                            WHERE
                                                                                o.o_dttm BETWEEN '$d_s' 
                                                                                AND '$d_e' 
                                                                                AND s.s_id = '1' 
                                                                                AND a.a_id = '$a_id'
                                                                            GROUP BY
                                                                                w.w_name ";

                                                                    $objQuery = mysqli_query($Connection, $sql);
                                                                    ?>

                                                                    <?php
                                                                    while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                                                                    ?>
                                                                        <tr>
                                                                            <td align="center"><?php echo $num++; ?></td>
                                                                            <td><?php echo $objResult['w_name']; ?></td>
                                                                            </td>
                                                                            <td align="center"><?php echo $objResult['w_price']; ?></td>
                                                                            <td align="center"><?php echo $objResult['c_name']; ?></td>
                                                                            <td align="center"><?php echo number_format($objResult['sum_1'], 0); ?></td>
                                                                            <td align="center"><?php echo number_format($objResult['sum_2'], 0); ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>

                                                                <thead>
                                                                    <?php
                                                                    $sql1 = "   SELECT 
                                                                                    SUM(d.d_qty) AS sum_1,
                                                                                    SUM(d.d_qty * w.w_price) AS sum_2 
                                                                                FROM order_detail d
                                                                                LEFT JOIN tb_wasadu w ON w.w_id = d.w_id
                                                                                LEFT JOIN order_head o ON o.o_id = d.o_id
                                                                                LEFT JOIN tb_user u ON u.user_id = o.user_id
                                                                                LEFT JOIN tb_agency a ON a.a_id = u.a_id
                                                                                LEFT JOIN tb_status s ON s.s_id = o.s_id 
                                                                                WHERE o.o_dttm BETWEEN '$d_s' AND '$d_e' 
                                                                                AND s.s_id = '1' 
                                                                                AND a.a_id = '$a_id' ";
                                                                    $objQuery1 = mysqli_query($Connection, $sql1);
                                                                    while ($objResult1 = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                                                                    ?>
                                                                        <tr>
                                                                            <th colspan="4" style="text-align:center"> รวม </th>
                                                                            <th style="text-align:center"><?php echo number_format($objResult1['sum_1'], 0); ?></th>
                                                                            <th style="text-align:center"><?php echo number_format($objResult1['sum_2'], 0); ?>&nbsp;บาท</th>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-center no-print">
                                <button id="hid" onclick="window.print();" class="btn btn-primary"> print </button>
                                <a href="index.php" id="hid" type="button" class="btn btn-secondary">กลับหน้าหลัก</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer_admin.php'; ?>
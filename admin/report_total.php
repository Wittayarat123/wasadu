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
        th{
            text-align: center;
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
                    <h1>รวมรายงานการ รับ-จ่าย-คงคลัง</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รวมรายงานการ รับ-จ่าย-คงคลัง</li>
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
                            <h3 class="card-title">รวมรายงานการ รับ-จ่าย-คงคลัง</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="panel-body mb-4" id="hid">
                                <form id="form1" name="form1" class="form-inline" method="post" action="report_total.php">
                                    <div class="form-group">
                                        <label>&nbsp;ประเภท :&nbsp;</label>
                                        <select class="form-control" name="w_type">
                                            <option value="">&nbsp;เลือกประเภท&nbsp;</option>
                                            <option value="1">พัสดุสำนักงาน</option>
                                            <option value="2">งานบ้านงานครัว</option>
                                        </select>
                                    </div>
                                    &nbsp;
                                    <div class="form-group">
                                        <label for="exampleInputName2">วันที่ :&nbsp;</label>
                                        <input type="date" name="d_s" class="form-control" width="270" />
                                        <!-- <input type="date" name="d_s" id="datepicker" width="270" /> -->
                                    </div>
                                    &nbsp;
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
                                    <div class="table-responsive">
                                        <h4><b>รวมรับทั้งเดือน</b></h4>
                                        <table class="table table-success table-bordered table-hover">
                                            <thead>
                                                <tr align="center">
                                                    <th scope="col">ลำดับ</th>
                                                    <th scope="col">รายการ</th>
                                                    <th scope="col">ราคา</th>
                                                    <th scope="col">หน่วย</th>
                                                    <th scope="col">รายรับทั้งเดือน</th>
                                                    <th scope="col">รวมราคาซื้อ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $num = 1;
                                                $d_s = $_POST['d_s']; //ตัวแปรวันที่เริ่มต้น
                                                $d_e = $_POST['d_e']; //ตัวแปรวันที่สิ้นสุด
                                                $w_type = $_POST['w_type']; //ตัวแปรประเภท
                                                echo "วันที่ &nbsp;";
                                                echo $d_s;
                                                echo "&nbsp;&nbsp;";
                                                echo "ถึงวันที่ &nbsp;";
                                                echo $d_e;
                                                echo "&nbsp;&nbsp;";
                                                if ($w_type == 1) {
                                                    echo "<b>ประเภท: พัสดุสำนักงาน</b>";
                                                } else {
                                                    echo "<b>ประเภท: งานบ้านงานครัว</b>";
                                                }


                                                $sql = "SELECT
                                                            w.w_name,
                                                            w.w_price,
                                                            c.c_name,
                                                            p.pay_qty,
                                                            p.pay_subtotal
                                                        FROM
                                                            tb_pay_detail p
                                                            INNER JOIN tb_wasadu w ON w.w_id = p.w_id
                                                            INNER JOIN tb_count c ON c.c_id = w.c_id 
                                                        WHERE
                                                            p.pay_time_detail BETWEEN '$d_s' 
                                                            AND '$d_e' 
                                                            AND w.w_type IN ('$w_type')
                                                        GROUP BY
                                                            p.w_id";

                                                $objQuery = mysqli_query($Connection, $sql);
                                                ?>

                                                <?php
                                                while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                                                ?>
                                                    <tr class="">
                                                        <td style="text-align: center">
                                                            <?php echo $num++; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $objResult['w_name']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php echo $objResult['w_price']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php echo $objResult['c_name']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php echo number_format($objResult['pay_qty'], 0); ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <i class="fa fa-dollar"></i> <?php echo number_format($objResult['pay_subtotal'], 0); ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                            <thead>
                                                <?php
                                                $sql1 = "   SELECT
                                                                p.*,
                                                                w.w_name,
                                                                w.w_price,
                                                                c.c_name ,
                                                                SUM(p.pay_qty) AS sum3,
                                                                SUM(p.pay_qty * w.w_price) AS sum4
                                                            FROM
                                                                tb_pay_detail p
                                                            INNER JOIN tb_wasadu w ON w.w_id = p.w_id
                                                            INNER JOIN tb_count c ON c.c_id = w.c_id 
                                                            WHERE
                                                                p.pay_time_detail BETWEEN '$d_s' 
                                                            AND '$d_e'
                                                            AND w.w_type IN ('$w_type')
                                                             ";
                                                $objQuery1 = mysqli_query($Connection, $sql1);
                                                while ($objResult1 = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <th colspan="4" style="text-align:center"> รวม </th>
                                                        <th style="text-align:center"><?php echo number_format($objResult1['sum3'], 0); ?></th>
                                                        <th style="text-align:center"><?php echo number_format($objResult1['sum4'], 0); ?>&nbsp;บาท</th>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <h4><b>รวมจ่ายทั้งเดือน</b></h4>
                                        <table class="table table-danger table-bordered table-hover">
                                            <thead>
                                                <tr align="center">
                                                    <th scope="col">ลำดับ</th>
                                                    <th scope="col">รายการ</th>
                                                    <th scope="col">ราคา</th>
                                                    <th scope="col">หน่วย</th>
                                                    <th scope="col">รวมจ่ายทั้งเดือน</th>
                                                    <th scope="col">รวมราคาจ่าย</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $num = 1;
                                                $d_s = $_POST['d_s']; //ตัวแปรวันที่เริ่มต้น
                                                $d_e = $_POST['d_e']; //ตัวแปรวันที่สิ้นสุด
                                                echo "วันที่ &nbsp;";
                                                echo $d_s;
                                                echo "&nbsp;&nbsp;";
                                                echo "ถึงวันที่ &nbsp;";
                                                echo $d_e;
                                                echo "&nbsp;&nbsp;";
                                                echo "&nbsp;&nbsp;";
                                                if ($w_type == 1) {
                                                    echo "<b>ประเภท: พัสดุสำนักงาน</b>";
                                                } else {
                                                    echo "<b>ประเภท: งานบ้านงานครัว</b>";
                                                }
                                                $sql2 = "SELECT
                                                           	w.w_name,
                                                            SUM(d.d_qty) AS sum1,
                                                            c.c_name,
                                                            w.w_price,
                                                            SUM( d.d_qty * w.w_price ) AS sum2 
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
                                                            AND w.w_type IN ('$w_type')
                                                        GROUP BY
                                                            w.w_id";

                                                $objQuery2 = mysqli_query($Connection, $sql2);
                                                ?>

                                                <?php
                                                while ($objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC)) {
                                                ?>
                                                    <tr class="">
                                                        <td style="text-align: center">
                                                            <?php echo $num++; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $objResult2['w_name']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php echo $objResult2['w_price']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php echo $objResult2['c_name']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php echo number_format($objResult2['sum1'], 0); ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <i class="fa fa-dollar"></i> <?php echo number_format($objResult2['sum2'], 0); ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                            <thead>
                                                <?php
                                                $sql1 = "SELECT 
                                                        SUM(d.d_qty) AS sum1,
                                                        SUM(d.d_qty * w.w_price) AS sum2 
                                                        FROM order_detail d
                                                        LEFT JOIN tb_wasadu w ON w.w_id = d.w_id
                                                        LEFT JOIN order_head o ON o.o_id = d.o_id
                                                        LEFT JOIN tb_user u ON u.user_id = o.user_id
                                                        LEFT JOIN tb_agency a ON a.a_id = u.a_id
                                                        LEFT JOIN tb_status s ON s.s_id = o.s_id 
                                                        WHERE o.o_dttm BETWEEN '$d_s' AND '$d_e' 
                                                        AND s.s_id = '1' 
                                                        AND w.w_type IN ('$w_type')
                                                        ";
                                                $objQuery1 = mysqli_query($Connection, $sql1);
                                                while ($objResult1 = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <th colspan="4" style="text-align:center"> รวม </th>
                                                        <th style="text-align:center"><?php echo number_format($objResult1['sum1'], 0); ?></th>
                                                        <th style="text-align:center"><?php echo number_format($objResult1['sum2'], 0); ?>&nbsp;บาท</th>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12">

                                    <div class="table-responsive">
                                        <h4><b>จำนวนคงคลัง</b></h4>
                                        <table class="table table-primary table-bordered table-hover">
                                            <thead>
                                                <tr align="center">
                                                    <th scope="col">ลำดับ</th>
                                                    <th scope="col">รายการ</th>
                                                    <th scope="col">ราคา</th>
                                                    <th scope="col">หน่วย</th>
                                                    <th scope="col">รวมจ่ายทั้งเดือน</th>
                                                    <th scope="col">รวมราคาจ่าย</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $num = 1;
                                                $d_s = $_POST['d_s']; //ตัวแปรวันที่เริ่มต้น
                                                $d_e = $_POST['d_e']; //ตัวแปรวันที่สิ้นสุด
                                                echo "วันที่ &nbsp;";
                                                echo $d_s;
                                                echo "&nbsp;&nbsp;";
                                                echo "ถึงวันที่ &nbsp;";
                                                echo $d_e;
                                                echo "&nbsp;&nbsp;";
                                                echo "&nbsp;&nbsp;";
                                                if ($w_type == 1) {
                                                    echo "<b>ประเภท: พัสดุสำนักงาน</b>";
                                                } else {
                                                    echo "<b>ประเภท: งานบ้านงานครัว</b>";
                                                }
                                                $sql3 = "SELECT
                                                            w.w_name,
                                                            c.c_name,
                                                            w.w_price,
                                                            SUM( w.w_quantity - '100' ) AS CC,
                                                            SUM((w.w_quantity - '100') * w.w_price) AS CCC 
                                                        FROM
                                                            tb_wasadu w
                                                            LEFT OUTER JOIN tb_count c ON c.c_id = w.c_id 
                                                        WHERE
                                                            ( w.w_quantity - '100' ) != '0'
                                                            AND w.w_type IN ('$w_type')
                                                        GROUP BY
                                                            w.w_id 
                                                            ";
                                                $objQuery3 = mysqli_query($Connection, $sql3);
                                                ?>

                                                <?php
                                                while ($objResult3 = mysqli_fetch_array($objQuery3, MYSQLI_ASSOC)) {
                                                ?>
                                                    <tr class="">
                                                        <td style="text-align: center">
                                                            <?php echo $num++; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $objResult3['w_name']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php echo $objResult3['w_price']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php echo $objResult3['c_name']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php echo number_format($objResult3['CC'], 0); ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <i class="fa fa-dollar"></i> <?php echo number_format($objResult3['CCC'], 0); ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                            <thead>
                                                <?php
                                                $sql14 = "   SELECT
                                                                w.w_name,
                                                                c.c_name,
                                                                SUM(w.w_quantity - '100') AS sum_1,
                                                                SUM((w.w_quantity - '100') * w.w_price) AS sum_2
                                                            FROM
                                                                tb_wasadu w
                                                                LEFT OUTER JOIN tb_count c ON c.c_id = w.c_id 
                                                            WHERE
                                                                ( w.w_quantity * w.w_price ) != '0' 
                                                                AND ( w.w_quantity != '0') 
                                                                AND w.w_type IN ('$w_type')   
                                                                ";
                                                $objQuery14 = mysqli_query($Connection, $sql14);
                                                while ($objResult14 = mysqli_fetch_array($objQuery14, MYSQLI_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <th colspan="4" style="text-align:center"> รวม </th>
                                                        <th style="text-align:center"><?php echo number_format($objResult14['sum_1'], 0); ?></th>
                                                        <th style="text-align:center"><?php echo number_format($objResult14['sum_2'], 0); ?>&nbsp;บาท</th>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-center no-print">
                                <button id="hid" onclick="window.print();" class="btn btn-primary"> print </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include '../includes/footer_admin.php'; ?>
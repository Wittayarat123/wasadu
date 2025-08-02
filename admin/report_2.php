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
$sql1 = "SELECT SUM(pay_qty),SUM(pay_subtotal) FROM tb_pay_detail ";
$objQuery1 = mysqli_query($Connection, $sql1);
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

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">

    <style>
        th {
            text-align: center;
            font-size: 25px;
        }

        table {
            width: 15%;
        }
    </style>

    <style type="text/css">
        @media print {
            #hid {
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
                    <h1>รายการจ่าย/เดือน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการจ่าย/เดือน</li>
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
                            <h3 class="card-title">รายการจ่าย/เดือน</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="panel-body mb-3" id="hid">
                                <form id="form1" name="form1" class="form-inline" method="post" action="report_2.php">
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
                                    &nbsp;
                                    <div class="form-group">
                                        <label>&nbsp;ประเภท :&nbsp;</label>
                                        <select class="form-control" name="w_type">
                                            <option value="'1','2'">&nbsp;เลือกประเภท&nbsp;</option>
                                            <option value="1">พัสดุสำนักงาน</option>
                                            <option value="2">งานบ้านงานครัว</option>
                                        </select>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary btn-outline-primary"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
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

                            <div class="card border-0 ">
                                <div class="card-body">
                                    <!-- ตารางข้อมูล -->
                                    <table class="table table-bordered mt-3" id="myTable">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center">รายการ</th>
                                                <th style="text-align:center">จำนวน</th>
                                                <th style="text-align:center">หน่วย</th>
                                                <th style="text-align:center">ราคา</th>
                                                <th style="text-align:center">ราคารวม</th>
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
                                                echo "ประเภท: พัสดุสำนักงาน";
                                            } else {
                                                echo "ประเภท: งานบ้านงานครัว";
                                            }
                                            $sql = "SELECT
                                                        tb_wasadu.w_name AS name,
                                                        tb_wasadu.w_price AS price,
                                                        SUM(order_detail.d_spend) AS QTY,
                                                        SUM(order_detail.d_spend * order_detail.d_price) AS Total,
                                                        tb_count.c_name AS cname
                                                    FROM
                                                        order_head
                                                        LEFT JOIN order_detail ON order_detail.o_id = order_head.o_id
                                                        LEFT JOIN tb_wasadu ON tb_wasadu.w_id = order_detail.w_id 
                                                        LEFT JOIN tb_count ON tb_count.c_id = tb_wasadu.c_id
                                                    WHERE
                                                        order_detail.d_time BETWEEN '$d_s' 
                                                        AND '$d_e' 
                                                        AND tb_wasadu.w_type IN ( '$w_type' ) 
                                                    GROUP BY
                                                        tb_wasadu.w_id";
                                            $objQuery = mysqli_query($Connection, $sql);

                                            while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $objResult['name']; ?></td>
                                                    <td align="center"><?php echo $objResult['QTY']; ?></td>
                                                    <td align="center"><?php echo $objResult['cname']; ?></td>
                                                    <td align="center"><?php echo $objResult['price']; ?></td>
                                                    <td align="center"><?php echo number_format($objResult['Total'], 2); ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php
                                            $sql1 = "SELECT
                                            -- 	us.*,
                                                            SUM(order_detail.d_spend) AS SSS,
                                                            SUM(order_detail.d_spend * order_detail.d_price) AS SSSS
                                                        -- SUM(order_detail.d_qty) AS SSS,
                                                        -- SUM(order_detail.d_subtotal) AS SSSS
                                                        -- SUM(pd.pay_qty) AS SSS,
                                                        -- SUM(pd.pay_qty * w.w_price) AS SSSS
                                                    FROM
                                                        order_head
                                                        LEFT JOIN order_detail ON order_detail.o_id = order_head.o_id
                                                        LEFT JOIN tb_wasadu ON tb_wasadu.w_id = order_detail.w_id 
                                                        LEFT JOIN tb_count ON tb_count.c_id = tb_wasadu.c_id
                                                    WHERE
                                                    order_detail.d_time BETWEEN '$d_s' 
                                                        AND '$d_e' 
                                                        AND tb_wasadu.w_type IN ( '$w_type' )";
                                            $objQuery1 = mysqli_query($Connection, $sql1);
                                            while ($objResult1 = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <th style="text-align:center"> รวม </th>
                                                    <th style="text-align:center"><?php echo $objResult1['SSS']; ?></th>
                                                    <th style="text-align:center"> </th>
                                                    <th style="text-align:center"> </th>
                                                    <th style="text-align:center"><?php echo $objResult1['SSSS']; ?>&nbsp;บาท</th>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="mt-4 text-center no-print">
                                        <button id="hid" onclick="window.print();" class="btn btn-primary"> print </button>
                                    </div>
                                    <div id="hid">
                                        <a href='#' id='download_link' onClick='javascript:ExcelReport();'>Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- เรียกใช้ javascript สำหรับ export ไฟล์ excel  -->
                        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
                        <script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>

                        <script>
                            function ExcelReport() //function สำหรับสร้าง ไฟล์ excel จากตาราง
                            {
                                var sheet_name = "excel_sheet"; /* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
                                var elt = document.getElementById('myTable'); /*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/

                                /*------สร้างไฟล์ excel------*/
                                var wb = XLSX.utils.table_to_book(elt, {
                                    sheet: sheet_name
                                });
                                XLSX.writeFile(wb, 'report.xlsx'); //Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx
                            }
                        </script>
                        <?php include '../includes/footer_admin.php'; ?>
                        <?php mysqli_close($Connection); ?>
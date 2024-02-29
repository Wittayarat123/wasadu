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
$sql1 = "SELECT SUM(d_qty),SUM(d_subtotal) FROM order_detail ";
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

    <style>
        th {
            text-align: center;
            font-size: 25px;
        }

        table {
            width: 15%;
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
                    <h1>รายการเบิกตามหน่วยงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการเบิกตามหน่วยงาน</li>
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
                            <h3 class="card-title">รายการเบิกตามหน่วยงาน</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="panel-body mb-3" id="hid">
                                <form id="form1" name="form1" class="form-inline" method="post" action="report_agen.php">
                                    <div class="form-group">
                                        <label>&nbsp;หน่วยงาน :&nbsp;</label>
                                        <select class="form-control" name="a_id">
                                            <option value="">&nbsp;เลือกหน่วยงาน&nbsp;</option>
                                            <?php
                                            $strSQL = "SELECT * FROM tb_agency ORDER BY a_id ASC";
                                            $objQuery = mysqli_query($Connection, $strSQL);
                                            while ($row = mysqli_fetch_array($objQuery)) {
                                            ?>
                                                <option value="<?php echo $row["a_id"]; ?>"><?php echo $row["a_name"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
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

                            <div class="card border-0">
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
                                            $a = $_POST['a_id']; //ตัวแปรหน่วยงาน
                                            $d_s = $_POST['d_s']; //ตัวแปรวันที่เริ่มต้น
                                            $d_e = $_POST['d_e']; //ตัวแปรวันที่สิ้นสุด

                                            $sql0 = "SELECT * FROM tb_agency
                        WHERE a_id = '$a' ";
                                            $objQuery0 = mysqli_query($Connection, $sql0);
                                            while ($objResult0 = mysqli_fetch_array($objQuery0, MYSQLI_ASSOC)) {

                                                echo  "<h5 style='text-shadow: 1px 1px 5px green;'>หน่วยงาน &nbsp;" . $objResult0['a_name'] . "</h5>";
                                            }
                                            echo "&nbsp;&nbsp;";
                                            echo "วันที่ &nbsp;";
                                            echo $d_s;
                                            echo "&nbsp;&nbsp;";
                                            echo "ถึงวันที่ &nbsp;";
                                            echo $d_e;
                                            echo "&nbsp;&nbsp;";

                                            $sql = "SELECT
                                                        w.w_name,
                                                        SUM(d.d_qty),
                                                        c.c_name,
                                                        w.w_price,
                                                        SUM(d.d_qty * w.w_price)
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
                                                        AND a.a_id = '$a'
                                                    GROUP BY
                                                        w.w_name ";
                                            $objQuery = mysqli_query($Connection, $sql);

                                            while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $objResult['w_name']; ?></td>
                                                    <td align="center"><?php echo $objResult['SUM(d.d_qty)']; ?></td>
                                                    <td align="center"><?php echo $objResult['c_name']; ?></td>
                                                    <td align="center"><?php echo $objResult['w_price']; ?></td>
                                                    <td align="center"><?php echo $objResult['SUM(d.d_qty * w.w_price)']; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php
                                            $sql1 = "   SELECT 
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
                                                        AND a.a_id = '$a'
                                                    ";
                                            $objQuery1 = mysqli_query($Connection, $sql1);
                                            while ($objResult1 = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <th style="text-align:center"> รวม </th>
                                                    <th style="text-align:center"><?php echo $objResult1['sum1']; ?></th>
                                                    <th align="center"> </th>
                                                    <th align="center"> </th>
                                                    <th style="text-align:center"><?php echo $objResult1['sum2']; ?>&nbsp;บาท</th>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
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
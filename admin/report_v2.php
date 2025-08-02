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

<?php include '../includes/navber_admin.php'; ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
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
                                <form id="form1" name="form1" class="form-inline" method="post" action="report_v2.php">
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
                                        <table class="table table-bordered border-dark table-hover" id="myTable">
                                            <thead>
                                                <tr align="center">
                                                    <th scope="col" style="background-color: #5A9CFE;">ลำดับ</th>
                                                    <th scope="col" style="background-color: #5A9CFE;">รายการ</th>
                                                    <th scope="col" style="background-color: #5A9CFE;">หน่วย</th>
                                                    <th scope="col" style="background-color: #5A9CFE;">ราคา</th>
                                                    <th scope="col" style="background-color: #6CC281;">รวมรับทั้งเดือน</th>
                                                    <th scope="col" style="background-color: #6CC281;">รวมราคาซื้อ</th>
                                                    <th scope="col" style="background-color: #E67781;">รวมเบิกทั้งเดือน</th>
                                                    <th scope="col" style="background-color: #E67781;">รวมราคาเบิก</th>
                                                    <th scope="col" style="background-color: #ff9dff;">รวมจ่ายทั้งเดือน</th>
                                                    <th scope="col" style="background-color: #ff9dff;">ราคาจ่ายต่อชิ้น</th>
                                                    <th scope="col" style="background-color: #ff9dff;">รวมราคาจ่าย</th>
                                                    <th scope="col" style="background-color: #FEA65E;">จำนวนคงคลัง</th>
                                                    <th scope="col" style="background-color: #FEA65E;">ราคาคงคลัง</th>

                                                    <th scope="col" style="background-color: #ffff9f;">จำนวนคงคลังปัจจุบัน</th>
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
                                                            w.w_type,
                                                            c.c_name,
                                                            w.w_price,
                                                            IFNULL( p.sum1, 0 ) AS stock,
                                                            IFNULL( p.paysub1, 0 ) AS sumstock,
                                                            IFNULL( o.sum2, 0 ) AS เบิก,
                                                            IFNULL( o.paysub2, 0 ) AS ราคาเบิก,
                                                            IFNULL(( p.sum1 - o.sum2 ), 0 ) AS total,
                                                            IFNULL(( p.paysub1 - o.paysub2), 0 ) AS total_2,
                                                            IFNULL( w.w_quantity, 0 ) AS qty,
                                                            IFNULL( o.sum3, 0 ) AS จ่าย,
                                                            IFNULL( o.sum4, 0)  AS ราคาต่อหน่วย,
                                                            IFNULL( o.sum3*o.sum4, 0) AS รวม
                                                        FROM
                                                            tb_wasadu w
                                                            LEFT JOIN tb_count c ON w.c_id = c.c_id
                                                            LEFT JOIN (
                                                            SELECT
                                                                d.w_id,
                                                                IFNULL( SUM( d.pay_qty ), 0 ) AS sum1,
                                                                IFNULL( SUM( d.pay_qty * w.w_price ), 0 ) AS paysub1 
                                                            FROM
                                                                tb_pay_detail d
                                                                LEFT JOIN tb_wasadu w ON w.w_id = d.w_id
                                                                INNER JOIN tb_pay_order po ON po.pay_id = d.pay_id
                                                            WHERE
                                                                po.pay_time BETWEEN '$d_s' 
                                                                AND '$d_e'
                                                                AND w.w_type = '$w_type'
                                                            GROUP BY
                                                                d.w_id 
                                                            ) p ON w.w_id = p.w_id
                                                            LEFT JOIN (
                                                            SELECT
                                                                o.w_id,
                                                            	IFNULL( SUM( d_qty ), 0 ) AS sum2,
                                                                IFNULL( SUM( d_qty * w.w_price ), 0 ) AS paysub2,
                                                                IFNULL( SUM( d_spend ), 0 ) AS sum3,
                                                                d_price  AS sum4  
                                                            FROM
                                                                order_detail o
                                                                INNER JOIN order_head oh ON oh.o_id = o.o_id 
                                                                LEFT JOIN tb_wasadu w ON w.w_id = o.w_id
                                                            WHERE
                                                                oh.s_id = '1' 
                                                                AND oh.o_dttm BETWEEN '$d_s' 
                                                                AND '$d_e' 
                                                                AND w.w_type = '$w_type'
                                                            GROUP BY
                                                                o.w_id 
                                                            ) o ON w.w_id = o.w_id 
                                                        WHERE
                                                            w.w_type = '$w_type'
                                                            AND p.w_id OR o.w_id IS NOT NULL";
                                                $objQuery = mysqli_query($Connection, $sql);
                                                ?>

                                                <?php
                                                while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <td style="text-align: center; background-color: #5A9CFE;">
                                                            <?php echo $num++; ?>
                                                        </td>
                                                        <td style="background-color: #5A9CFE;">
                                                            <?php echo $objResult['w_name']; ?>
                                                        </td>
                                                        <td style="text-align: center; background-color: #5A9CFE;">
                                                            <?php echo $objResult['c_name']; ?>
                                                        </td>
                                                        <td style="text-align: center; background-color: #5A9CFE;">
                                                            <?php echo $objResult['w_price']; ?>
                                                        </td>
                                                        <td style="text-align: center ; background-color: #6CC281;">
                                                            <?php echo $objResult['stock']; ?>
                                                        </td>
                                                        <td style="text-align: center ; background-color: #6CC281;">
                                                            <?php echo number_format($objResult['sumstock'], 2); ?>
                                                        </td>
                                                        <td style="text-align: center ; background-color: #E67781;">
                                                            <?php echo $objResult['เบิก']; ?>
                                                        </td>
                                                        <td style="text-align: center ; background-color: #E67781;">
                                                            <?php echo number_format($objResult['ราคาเบิก'], 2); ?>
                                                        </td>
                                                        <td style="text-align: center ; background-color: #ff9dff;">
                                                            <?php echo $objResult['จ่าย']; ?>
                                                        </td>
                                                        <td style="text-align: center ; background-color: #ff9dff;">
                                                            <?php echo $objResult['ราคาต่อหน่วย']; ?>
                                                        </td>
                                                        <td style="text-align: center ; background-color: #ff9dff;">
                                                            <?php echo $objResult['รวม']; ?>
                                                        </td>
                                                        <td style="text-align: center ; background-color: #FEA65E;">
                                                            <?php if ($objResult['total'] <= 0) {
                                                                echo $objResult['stock'];
                                                            } else {
                                                                echo $objResult['total'];
                                                            }
                                                            ?>

                                                        </td>
                                                        <td style="text-align: center ; background-color: #FEA65E;">
                                                            <?php if ($objResult['total_2'] <= 0) {
                                                                echo number_format($objResult['sumstock'], 2);
                                                            } else {
                                                                echo number_format($objResult['total_2'], 2);
                                                            }
                                                            ?>
                                                            <!-- <?php echo number_format($objResult['total_2'], 2); ?> -->
                                                        </td>

                                                        <td style="text-align: center ; background-color: #ffff9f;">
                                                            <?php echo $objResult['qty']; ?>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        <?php } ?>

                                        <thead>

                                            <?php
                                            $sql1 = "   SELECT
                                                            IFNULL( sum(p.sum1), 0 ) AS sum3,
                                                            IFNULL( sum(p.paysub1), 0 ) AS sum4
                                                        FROM
                                                            tb_wasadu w
                                                            LEFT JOIN tb_count c ON w.c_id = c.c_id
                                                            LEFT JOIN (
                                                            SELECT
                                                                d.w_id,
                                                                IFNULL( SUM( d.pay_qty ), 0 ) AS sum1,
                                                                IFNULL( SUM( d.pay_qty * w.w_price ), 0 ) AS paysub1 
                                                            FROM
                                                                tb_pay_detail d
                                                                LEFT JOIN tb_wasadu w ON w.w_id = d.w_id
                                                                INNER JOIN tb_pay_order po ON po.pay_id = d.pay_id
                                                            WHERE
                                                                po.pay_time BETWEEN '$d_s' 
                                                                AND '$d_e'
                                                                AND w.w_type = '$w_type'
                                                            GROUP BY
                                                                d.w_id 
                                                            ) p ON w.w_id = p.w_id
                                                            LEFT JOIN (
                                                            SELECT
                                                                o.w_id,
                                                                IFNULL( SUM( d_qty ), 0 ) AS sum2,
                                                                IFNULL( SUM( d_qty * w.w_price  ), 0 ) AS paysub2 ,
                                                                IFNULL( SUM( d_spend ), 0 ) AS sum3,
                                                                IFNULL( SUM( d_spend * w.w_price ), 0 ) AS paysub3 
                                                            FROM
                                                                order_detail o
                                                                INNER JOIN order_head oh ON oh.o_id = o.o_id 
                                                                LEFT JOIN tb_wasadu w ON w.w_id = o.w_id
                                                            WHERE
                                                                oh.s_id = '1' 
                                                                AND oh.o_dttm BETWEEN '$d_s' 
                                                                AND '$d_e' 
                                                                AND w.w_type = '$w_type'
                                                            GROUP BY
                                                                o.w_id 
                                                            ) o ON w.w_id = o.w_id 
                                                        WHERE
                                                            w.w_type = '$w_type'
                                                            AND p.w_id OR o.w_id IS NOT NULL ";
                                            $objQuery1 = mysqli_query($Connection, $sql1);
                                            while ($objResult1 = mysqli_fetch_array($objQuery1, MYSQLI_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <th colspan="4" style="text-align:center; background-color: #5A9CFE;"> รวม </th>
                                                    <th style="text-align:center ; background-color: #6CC281;"><?php echo $objResult1['sum3']; ?></th>
                                                    <th style="text-align:center ; background-color: #6CC281;"><?php echo number_format($objResult1['sum4'], 2); ?>&nbsp;บาท</th>

                                                <?php
                                            }
                                                ?>

                                                <?php
                                                $sql11 = "   SELECT
                                                                    IFNULL( SUM( o.d_qty ), 0 ) AS sum3,
                                                                    IFNULL( SUM( o.d_qty * w.w_price ), 0 ) AS sum4 
                                                                FROM
                                                                    order_detail o
                                                                    INNER JOIN tb_wasadu w ON w.w_id = o.w_id
                                                                    INNER JOIN order_head oo ON oo.o_id = o.o_id
                                                                    INNER JOIN tb_count c ON c.c_id = w.c_id 
                                                                WHERE
                                                                    oo.s_id = '1'
                                                                AND 
                                                                    oo.o_dttm BETWEEN '$d_s' 
                                                                    AND '$d_e'  
                                                                    AND w.w_type = '$w_type'
                                                                ";
                                                $objQuery11 = mysqli_query($Connection, $sql11);
                                                while ($objResult11 = mysqli_fetch_array($objQuery11, MYSQLI_ASSOC)) {
                                                ?>
                                                    <th style="text-align:center; background-color: #E67781;"><?php echo $objResult11['sum3']; ?></th>
                                                    <th style="text-align:center; background-color: #E67781;"><?php echo number_format($objResult11['sum4'], 2); ?>&nbsp;บาท</th>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                $sql1111 = " SELECT
                                                                IFNULL( SUM(sum3), 0 ) AS sum77,
                                                                IFNULL( SUM(paysub3), 0 ) AS sum88
                                                            FROM
                                                                tb_wasadu w
                                                                LEFT JOIN tb_count c ON w.c_id = c.c_id
                                                                LEFT JOIN (
                                                                SELECT
                                                                    d.w_id,
                                                                    IFNULL( SUM( d.pay_qty ), 0 ) AS sum1,
                                                                    IFNULL( SUM( d.pay_qty * w.w_price ), 0 ) AS paysub1 
                                                                FROM
                                                                    tb_pay_detail d
                                                                    LEFT JOIN tb_wasadu w ON w.w_id = d.w_id
                                                                    INNER JOIN tb_pay_order po ON po.pay_id = d.pay_id
                                                                WHERE
                                                                    po.pay_time BETWEEN '$d_s' 
                                                                    AND '$d_e'
                                                                    AND w.w_type = '$w_type'
                                                                GROUP BY
                                                                    d.w_id 
                                                                ) p ON w.w_id = p.w_id
                                                                LEFT JOIN (
                                                                SELECT
                                                                    o.w_id,
                                                                    IFNULL( SUM( d_qty ), 0 ) AS sum2,
                                                                    IFNULL( SUM( d_qty * w.w_price  ), 0 ) AS paysub2 ,
                                                                    IFNULL( SUM( d_spend ), 0 ) AS sum3,
                                                                    IFNULL( SUM( d_spend * w.w_price ), 0 ) AS paysub3
                                                                FROM
                                                                    order_detail o
                                                                    INNER JOIN order_head oh ON oh.o_id = o.o_id 
                                                                    LEFT JOIN tb_wasadu w ON w.w_id = o.w_id
                                                                WHERE
                                                                    oh.s_id = '1' 
                                                                    AND oh.o_dttm BETWEEN '$d_s' 
                                                                    AND '$d_e' 
                                                                    AND w.w_type = '$w_type'
                                                                GROUP BY
                                                                    o.w_id 
                                                                ) o ON w.w_id = o.w_id 
                                                            WHERE
                                                                w.w_type = '$w_type'
                                                                AND p.w_id OR o.w_id IS NOT NULL ";
                                                $objQuery1111 = mysqli_query($Connection, $sql1111);
                                                while ($objResult1111 = mysqli_fetch_array($objQuery1111, MYSQLI_ASSOC)) {
                                                ?>
                                                    <th style="text-align:center; background-color: #ff9dff;"></th>
                                                    <th style="text-align:center; background-color: #ff9dff;"></th>
                                                    <th style="text-align:center; background-color: #ff9dff;"></th>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                $sql111 = " SELECT
                                                                IFNULL(SUM(w_quantity), 0) AS sum5,
                                                                IFNULL(SUM(w_quantity*w_price), 0) AS sum6
                                                            FROM
                                                                tb_wasadu w
                                                                LEFT JOIN tb_count c ON w.c_id = c.c_id
                                                                LEFT JOIN (
                                                                SELECT
                                                                    d.w_id,
                                                                    IFNULL( SUM( d.pay_qty ), 0 ) AS sum1,
                                                                    IFNULL( SUM( d.pay_qty * w.w_price ), 0 ) AS paysub1 
                                                                FROM
                                                                    tb_pay_detail d
                                                                    LEFT JOIN tb_wasadu w ON w.w_id = d.w_id
                                                                    INNER JOIN tb_pay_order po ON po.pay_id = d.pay_id
                                                                WHERE
                                                                    po.pay_time BETWEEN '$d_s' 
                                                                    AND '$d_e'
                                                                    AND w.w_type = '$w_type'
                                                                GROUP BY
                                                                    d.w_id 
                                                                ) p ON w.w_id = p.w_id
                                                                LEFT JOIN (
                                                                SELECT
                                                                    o.w_id,
                                                                    IFNULL( SUM( d_qty ), 0 ) AS sum2,
                                                                    IFNULL( SUM( d_qty * w.w_price  ), 0 ) AS paysub2 ,
                                                                    IFNULL( SUM( d_spend ), 0 ) AS sum3,
                                                                    IFNULL( SUM( d_spend * w.w_price ), 0 ) AS paysub3 
                                                                FROM
                                                                    order_detail o
                                                                    INNER JOIN order_head oh ON oh.o_id = o.o_id 
                                                                    LEFT JOIN tb_wasadu w ON w.w_id = o.w_id
                                                                WHERE
                                                                    oh.s_id = '1' 
                                                                    AND oh.o_dttm BETWEEN '$d_s' 
                                                                    AND '$d_e' 
                                                                    AND w.w_type = '$w_type'
                                                                GROUP BY
                                                                    o.w_id 
                                                                ) o ON w.w_id = o.w_id 
                                                            WHERE
                                                                w.w_type = '$w_type'
                                                                AND p.w_id OR o.w_id IS NOT NULL ";
                                                $objQuery111 = mysqli_query($Connection, $sql111);
                                                while ($objResult111 = mysqli_fetch_array($objQuery111, MYSQLI_ASSOC)) {
                                                ?>
                                                    <!-- <th style="text-align:center; background-color: #FEA65E;"><?php echo $objResult111['sum5']; ?></th>
                                                    <th style="text-align:center; background-color: #FEA65E;"><?php echo number_format($objResult111['sum6'], 2); ?>&nbsp;บาท</th> -->
                                                    <th style="text-align:center; background-color: #FEA65E;"></th>
                                                    <th style="text-align:center; background-color: #FEA65E;"></th>
                                                    <th style="text-align:center; background-color: #FFFF9F;"></th>
                                                <?php
                                                }
                                                ?>
                                        </thead>
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
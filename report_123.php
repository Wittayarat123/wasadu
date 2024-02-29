<?php
require_once('connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
    header("location:login.php");
    exit();
}
if ($_SESSION != NULL) {
    $sql_tb_user = "SELECT * FROM tb_user u
    LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
    LEFT OUTER JOIN order_head h ON u.user_id = h.user_id
    WHERE user_username = '" . $_SESSION['user_username'] . "'";
    $query_tb_user = mysqli_query($Connection, $sql_tb_user);
    $result_tb_user = mysqli_fetch_array($query_tb_user, MYSQLI_ASSOC);
}

$o_id = $_GET['o_id']; //สร้างตัวแปร p_id เพื่อรับค่า

$sql = "SELECT SUM(w.w_quantity - '100') AS sum_1, h.*, u.*, a.*, d.*, w.*, c.*  FROM order_head h
LEFT OUTER JOIN tb_user u ON h.user_id = u.user_id
LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN order_detail d ON h.o_id = d.o_id
LEFT OUTER JOIN tb_wasadu w ON d.w_id = w.w_id
LEFT OUTER JOIN tb_count c ON w.c_id = c.c_id
WHERE d.o_id = $o_id ";

$objQuery = mysqli_query($Connection, $sql);
$total_record = mysqli_num_rows($objQuery);

$sql123 = "SELECT * FROM order_head h
LEFT OUTER JOIN tb_user u ON h.user_id = u.user_id
LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN order_detail d ON h.o_id = d.o_id
LEFT OUTER JOIN tb_wasadu w ON d.w_id = w.w_id
WHERE d.o_id = $o_id ";
$objQuery123 = mysqli_query($Connection, $sql123);

?>

<?php
date_default_timezone_set('asia/bangkok');
$date = date("d/m/Y");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <link href="assets/images/BG.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="assets/main.css"> -->
    <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100&display=swap" rel="stylesheet">

</head>
<style type="text/css">
    body {
        font-family: 'Sarabun', sans-serif;
    }

    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
    }

    .center {
        text-align: center;
    }
    .right {
        text-align: right;
    }
</style>
</head>

<body class="default">


    <section>
        <div class="container mt-5">
            <div class="row">
                <div class="col-sm-4 fw-bold" align="center">

                </div>
                <div class="col-sm-4 fw-bold" align="center">
                    <h3><b>รายการเบิก</b></h3>
                </div>
                <div class="col-sm-4 mt-2" align="center">
                    วันที่จ่ายพัสดุ:&nbsp;
                    <?php echo $date; ?>
                </div>
            </div>

            <div class="row mb-1 mt-5">
                <div class="col-sm-6 mb-4">
                    เรียน .......................................................................
                </div>
                <div class="col-sm-6 mb-4 right">
                    วันที่เบิก:&nbsp;&nbsp;&nbsp;
                    <?php
                    $objResult123 = mysqli_fetch_array($objQuery123, MYSQLI_ASSOC)
                    ?>
                    <?php echo $objResult123["o_dttm"]; ?>
                </div>

                <div class="col-sm-12 mb-4 center">
                    ด้านงาน/ฝ่าย............................................................................................................... ขอเบิก ...............................................................................................................
                </div>

                <div class="col-sm-12 center">
                    เพื่อใช้ในราชการตามรายการข้างต้นท้ายนี้มอบให้ ........................................................................................................................................................... เป็นผู้รับ
                </div>

                <div class="col-sm-3 mx-auto">
                    <b>ชื่อผู้ขอเบิก:&nbsp;&nbsp;&nbsp;</b>
                    <?php echo $result_tb_user["user_name"] . " " . $result_tb_user["user_surname"]; ?>
                </div>
                <div class="col-sm-4 mx-auto">
                    <b>หน่วยงาน:&nbsp;&nbsp;&nbsp;</b>
                    <?php echo $result_tb_user["a_name"]; ?>
                </div>
                <div class="col-sm-3 mx-auto">
                    <b>วันที่เบิก:&nbsp;&nbsp;&nbsp;</b>
                    <?php
                    $objResult123 = mysqli_fetch_array($objQuery123, MYSQLI_ASSOC)
                    ?>
                    <?php echo $objResult123["o_dttm"]; ?>
                </div>
                <div class="col-sm-2 mx-auto">
                    <b>รหัสการเบิก:&nbsp;&nbsp;&nbsp;</b>
                    <?php echo $o_id ?>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row mb-3 mt-4">
                <div class="col">จำนวนพัสดุทั้งหมด <?php echo $total_record; ?>
                    รายการ รายละเอียดดังนี้
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:5%">No.</th>
                                <th class="text-center" style="width:40%">ชื่อรายการ</th>
                                <th class="text-center" style="width:8%">หน่วย</th>
                                <th class="text-center" style="width:8%">คงเหลือ</th>
                                <th class="text-center" style="width:8%">จำนวนที่ขอเบิก</th>
                                <th class="text-center" style="width:8%">จำนวนที่จ่ายให้</th>
                                <th class="text-center" style="width:20%">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $i = 0;
                            while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                                $i++;
                            ?>

                                <tr>
                                    <td align="center"><?php echo $i; ?></td>
                                    <td><?php echo $objResult['w_name']; ?></td>
                                    <td align="center"><?php echo $objResult['c_name']; ?></td>
                                    <td align="center"><?php echo $objResult['sum_1']; ?></td>
                                    <td align="center"><?php echo $objResult['d_qty']; ?></td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container mb-5 mt-5 text-center">
            <div class="row">
                <div class="col-sm-6 mt-5">
                    <h6><b>ลงชื่อ: ......................................................... ผู้เบิก</b></h6>
                    <h6><b>( ......................................................... )</b></h6>
                </div>

                <div class="col-sm-6 mt-5">
                    <h6><b>ลงชื่อ: ......................................................... ผู้จ่ายพัสดุ</b></h6>
                    <h6><b>( ......................................................... )</b></h6>
                </div>

                <div class="col-sm-6 mt-5">
                    <h6><b>ลงชื่อ: ......................................................... ผู้อนุมัติจ่าย</b></h6>
                    <h6><b>( นางสาวดรุวรรณ คลังศรี )</b></h6>
                    <h6><b> ตำแหน่ง เภสัชกร ชำนาญการ </b></h6>
                </div>

                <div class="col-sm-6 mt-5">
                    <h6><b>ลงชื่อ: ......................................................... ผู้รับพัสดุ</b></h6>
                    <h6><b>( ......................................................... )</b></h6>
                </div>

                <div class="col-sm-6 mt-5">

                </div>

                <div class="col-sm-6 ">
                    <h6><b>วันที่ ........... เดือน ........................... พ.ศ. .............. </b></h6>
                </div>
            </div>
        </div>


        <!-- ปุ่มพิมพ์ -->
        <div class="mt-4 text-center no-print">
            <button type="button" class="btn btn-warning" onclick="return print();">พิมพ์</button>
        </div>

    </section>


</body>

</html>
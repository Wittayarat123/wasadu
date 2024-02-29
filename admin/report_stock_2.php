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

if ($_SESSION != NULL) {
    $sql_tb_user = "SELECT * FROM tb_user u
    LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
    LEFT OUTER JOIN order_head h ON u.user_id = h.user_id
    WHERE user_username = '" . $_SESSION['user_username'] . "'";
    $query_tb_user = mysqli_query($Connection, $sql_tb_user);
    $result_tb_user = mysqli_fetch_array($query_tb_user, MYSQLI_ASSOC);
}
$pay_id = $_GET['pay_id']; //สร้างตัวแปร p_id เพื่อรับค่า

$sql = "SELECT
	w.w_name,
	c.c_name,
	p.pay_qty,
	p.pay_subtotal,
    (p.pay_qty * p.pay_subtotal)
FROM
	tb_pay_detail p
	LEFT OUTER JOIN tb_wasadu w ON w.w_id = p.w_id
	LEFT OUTER JOIN tb_count c ON w.c_id = c.c_id 
    LEFT OUTER JOIN tb_pay_order po ON  po.pay_id = p.pay_id
WHERE
	p.pay_id = $pay_id ";

$objQuery = mysqli_query($Connection, $sql);
$total_record = mysqli_num_rows($objQuery);

$sql123 = "SELECT
    *,
	w.w_name,
	c.c_name,
	p.pay_qty,
	p.pay_subtotal,
    (p.pay_qty * p.pay_subtotal)
FROM
	tb_pay_detail p
	LEFT OUTER JOIN tb_wasadu w ON w.w_id = p.w_id
	LEFT OUTER JOIN tb_count c ON w.c_id = c.c_id 
    LEFT OUTER JOIN tb_pay_order po ON  po.pay_id = p.pay_id
WHERE
	p.pay_id = $pay_id ";
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
    <link href="../assets/images/BG.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="assets/main.css"> -->
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">

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
                <div class="col-sm-4 fw-bold mb-5" align="center">
                    <h3><b>ใบรับพัสดุ</b></h3>
                </div>
                <?php
                $objResult123 = mysqli_fetch_array($objQuery123, MYSQLI_ASSOC)
                ?>
                <!-- <div class="col-sm-4 mt-2" align="center">
                    <b>วันที่จ่ายพัสดุ:&nbsp;</b>
                    <?php echo $date; ?>
                </div> -->
            </div>
            <div class="row mb-1 mt-2">
                <div class="col-sm-6 mb-2">
                    <b>ชื่อบริษัท:</b>&nbsp;&nbsp;&nbsp; <?php echo $objResult123["pay_head"]; ?>
                </div>
                <div class="col-sm-2 mb-2">
                    <b> เล่มที่:</b>&nbsp;&nbsp;&nbsp; <?php echo $objResult123["pay_d"]; ?>
                </div>
                <div class="col-sm-2 mb-2">
                    <b> เลขที่:</b>&nbsp;&nbsp;&nbsp; <?php echo $objResult123["pay_t"]; ?>
                </div>
                <div class="col-sm-2 mb-2">
                    <b> วันที่:</b>&nbsp;&nbsp;&nbsp; <?php echo $objResult123["pay_time"]; ?>
                </div>
            </div>

            <div class="container">
                <div class="row mb-3 mt-4">
                    <div class="col"><b>จำนวนพัสดุทั้งหมด <?php echo $total_record; ?>
                            รายการ รายละเอียดดังนี้</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No.</th>
                                    <th class="text-center" style="width:40%">ชื่อรายการ</th>
                                    <th class="text-center" style="width:8%">หน่วย</th>
                                    <th class="text-center" style="width:8%">จำนวน</th>
                                    <th class="text-center" style="width:8%">ราคา</th>
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
                                        <td align="center"><?php echo number_format($objResult['pay_qty']); ?></td>
                                        <td align="center"><?php echo number_format($objResult['pay_subtotal'], 2); ?></td>
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
                       
                    </div>

                    <div class="col-sm-6 mt-5">
                        <h6><b>ลงชื่อ: ......................................................... เจ้าหน้าที่พัสดุ</b></h6>
                        <h6><b>( นางสาววรรณภา ชูชื่น )</b></h6>
                    </div>

                    <div class="col-sm-6 mt-5">

                    </div>

                    <div class="col-sm-6 mt-5">
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
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

$sql = "    SELECT
a.a_name
FROM
	order_detail d
	LEFT JOIN tb_wasadu w ON w.w_id = d.w_id
	LEFT JOIN order_head o ON o.o_id = d.o_id
	LEFT JOIN tb_count c ON c.c_id = w.c_id
	LEFT JOIN tb_user u ON u.user_id = o.user_id
	LEFT JOIN tb_agency a ON a.a_id = u.a_id
	LEFT JOIN tb_status s ON s.s_id = o.s_id 
WHERE
	o.o_dttm BETWEEN '2023-01-01' 
	AND '2023-09-15' 
	AND s.s_id = '1' 
GROUP BY
	a.a_name";
$objQuery = mysqli_query($Connection, $sql);

?>

<?php include '../includes/navber_admin.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>การอนุมัติใบเบิก-จ่ายพัสดุ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">การอนุมัติใบเบิก-จ่ายพัสดุ</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">การอนุมัติใบเบิก-จ่ายพัสดุ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- วันที่ -->
                            <div class="panel-body mb-4" id="hid">
                                <form id="form1" name="form1" class="form-inline" method="post" action="">
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
                            <!-- วันที่ -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-success table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20%;">ลำดับ</th>
                                                    <th style="width: 80%;">หน่วยงาน</th>
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

                                                $sql = "    SELECT
                                                            a.a_name
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
                                                                -- AND o.s_id = '1'
                                                            GROUP BY
                                                                a.a_name";

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
                                                            <?php echo $objResult['a_name']; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
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

            $sql = "    SELECT
                            a.a_name
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
                        -- AND o.s_id = '1'
                        GROUP BY
                            a.a_name";

            $objQuery = mysqli_query($Connection, $sql);
            ?>

            <?php
            while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
            ?>

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $objResult['a_name']; ?></h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: block;">
                        รายการ
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer" style="display: block;">
                        Footer
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->


            <?php } ?>

    </section>


</div>


<?php mysqli_close($Connection); ?>
<?php include '../includes/footer_admin.php'; ?>
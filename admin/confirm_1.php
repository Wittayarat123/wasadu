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
    $sql_tb_user = "SELECT * FROM tb_user WHERE user_username = '" . $_SESSION['user_username'] . "'";
    $query_tb_user = mysqli_query($Connection, $sql_tb_user);
    $result_tb_user = mysqli_fetch_array($query_tb_user, MYSQLI_ASSOC);
}

?>

<title><?php echo $title; ?></title>
<link href="assets/images/BG.png" rel="icon">

<?php include '../includes/navber_admin.php' ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>สรุปรายการสต๊อก</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="stock.php">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">สรุปรายการสต๊อก</li>
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
                            <h3 class="card-title">รายการพัสดุ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="frmcart" name="frmcart" method="post" action="saveorder_1.php">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>ชื่อบริษัท</label>
                                            <input type="text" class="form-control" name="pay_head" placeholder="ชื่อบริษัท" required="" />
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label>เล่มที่</label>
                                            <input type="text" class="form-control" name="pay_d" placeholder="เล่มที่" required="" />
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label>เลขที่</label>
                                            <input type="text" class="form-control" name="pay_t" placeholder="เลขที่" required="" />
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="focusedinput" class="col-sm-4 control-label">วันที่รับ</label>
                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" id="pay_time" placeholder="" name="pay_time" style="width: 150px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="pay_text">หมายเหตุ</label>
                                            <textarea class="form-control" id="pay_text" name="pay_text" rows="2" style="width: 515px;"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <table class="table table-bordered table-striped">

                                    <tr>
                                        <td width="1558" colspan="4" bgcolor="#FFDDBB">
                                            <strong>รายการสต๊อก</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#F9D5E3">พัสดุ</td>
                                        <td align="center" bgcolor="#F9D5E3">ราคา</td>
                                        <td align="center" bgcolor="#F9D5E3">จำนวน</td>
                                        <td align="center" bgcolor="#F9D5E3">รวม/รายการ</td>
                                    </tr>
                                    <?php
                                    $total = 0;
                                    foreach ($_SESSION['cart'] as $w_id => $qty) {
                                        $sql  = "select * from tb_wasadu where w_id=$w_id";
                                        $query  = mysqli_query($Connection, $sql);
                                        $row  = mysqli_fetch_array($query);
                                        $sum  = $row['w_price'] * $qty;
                                        $total  += $sum;
                                        echo "<tr>";
                                        echo "<td>" . $row["w_name"] . "</td>";
                                        echo "<td align='center'>" . number_format($row['w_price'], 2) . "</td>";
                                        echo "<td align='center'>$qty</td>";
                                        echo "<td align='center'>" . number_format($sum, 2) . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr>";
                                    echo "<td  align='right' colspan='3' bgcolor='#F9D5E3'><b>รวม</b></td>";
                                    echo "<td align='right' bgcolor='#F9D5E3'>" . "<b>" . number_format($total, 2) . "</b>" . "</td>";
                                    echo "</tr>";
                                    ?>
                                </table>
                                <p>

                                <table border="0" cellspacing="0" align="center">
                                    ID: <input align="center" name="user_id" id="user_id" value="<?php echo $result_tb_user["user_id"]; ?>" style="width: 2%;">
                                    ชื่อผู้เบิก: <?php echo $result_tb_user["user_name"] . " " . $result_tb_user["user_surname"]; ?>

                                    <td colspan="2" align="center" bgcolor="#CCCCCC">
                                        <input class="btn btn-success" type="submit" name="Submit2" value="+สต๊อก" />
                                    </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php mysqli_close($Connection); ?>

    <?php include '../includes/footer_admin.php'; ?>
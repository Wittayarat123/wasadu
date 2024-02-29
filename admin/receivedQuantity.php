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

$o_id = (int) $_GET['o_id'];

$sql = "SELECT * FROM order_head h
LEFT OUTER JOIN tb_user u ON h.user_id = u.user_id
LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN order_detail d ON h.o_id = d.o_id
LEFT OUTER JOIN tb_wasadu w ON d.w_id = w.w_id
WHERE d.o_id = $o_id";  //เรียกข้อมูลมาแสดงทั้งหมด
$result = mysqli_query($Connection, $sql);

$sql123 = "SELECT * FROM order_head h
LEFT OUTER JOIN tb_user u ON h.user_id = u.user_id
LEFT OUTER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN order_detail d ON h.o_id = d.o_id
LEFT OUTER JOIN tb_wasadu w ON d.w_id = w.w_id
WHERE d.o_id = $o_id";  //เรียกข้อมูลมาแสดงทั้งหมด
$result123 = mysqli_query($Connection, $sql123);
$row123 = mysqli_fetch_array($result123)

?>


<?php include '../includes/navber_admin.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>จ่ายพัสดุ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">จ่ายพัสดุ</li>
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
                            <h3 class="card-title">จ่ายพัสดุ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="text"><b>ชื่อผู้ใช้:</b> <?php echo $row123["user_name"] . ' ' . $row123["user_surname"]; ?> </div>
                            <div class="text"><b>หน่วยงาน:</b> <?php echo $row123["a_name"]; ?> </div>
                            <div class="text"><b>วันที่เบิก:</b> <?php echo $row123["o_dttm"] ?> </div>
                            <table class="table table-bordered table-hover">
                                <thead align="center">
                                    <th>ลำดับเบิกพัสดุ</th>
                                    <th>รหัสพัสดุ</th>
                                    <th>รายการ</th>
                                    <th>ราคา/หน่วย</th>
                                    <th>ราคารวม</th>
                                    <th>จำนวนเบิก</th>
                                    <th>วันที่จ่าย</th>
                                    <th>จำนวนจ่าย</th>
                                    <th>จำนวนเงิน/ชิ้น</th>
                                    <th>จำนวนเงินจ่าย/ชิ้น</th>
                                    <th>จ่ายพัสดุ</th>
                                </thead>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tbody>
                                        <td align="center"><?php echo $row["d_id"]; ?></td>
                                        <td align="center"><?php echo $row["w_id"]; ?></td>
                                        <td><?php echo $row["w_name"]; ?></td>
                                        <td align="center"><?php echo $row["w_price"]; ?></td>
                                        <td align="center"><?php echo $row["d_subtotal"]; ?></td>
                                        <td align="center"><?php echo $row["d_qty"]; ?></td>
                                        <td align="center">

                                            <h5><span class="badge badge-pill badge-success"><?php echo $row["d_time"] ?></span></h5>

                                            <form action="update_date.php?o_id=<?php echo $row["o_id"] ?>" method="post">
                                                <label for="event_date">วันที่: </label>
                                                <input type="hidden" name="d_id" value="<?php echo $row["d_id"] ?>">
                                                <input type="date" id="event_date" name="event_date" required>
                                                <button type="submit" class="btn btn-outline-success btn-sm">บันทึก</button>
                                            </form>

                                        </td>
                                        <td align="center">
                                            <?php echo $row["d_spend"]; ?>
                                        </td>
                                        <td align="center">
                                            <?php echo $row["d_price"]; ?>
                                        </td>
                                        <td align="center">
                                            <?php if ($row['d_qty'] == $row['d_price']) {

                                                echo "<span class='badge badge-pill badge-success'>ลงข้อมูลแล้ว</span>";
                                            } else {
                                                echo "<form method='post' class='form-horizontal' action='update_price.php?d_id=" . $row["d_id"] . "&o_id=" . $row["o_id"] . "&w_id=" . $row["w_id"] . "'>";
                                                echo   " <input type='hidden' name='d_id' value=" . $row["d_id"] . ">";
                                                echo    "<input type='hidden' name='o_id' value=" . $row["o_id"] . ">";
                                                echo    "<input type='hidden' name='w_id' value=" . $row["w_id"] . ">";
                                                echo    "<input type='hidden' name='d_qty' value=" . $row["d_qty"] . ">";
                                                echo    "<input type='hidden' name='d_subtotal' value=" . $row["d_subtotal"] . ">";
                                                echo    "<input type='text' name='d_price' id='d_price' maxlength='15' style='width:50px;' />";
                                                echo    "<button class='btn-outline-primary btn-sm' type='submit'>บันทึก</button>";
                                                echo "</form>";
                                            }
                                            ?>
                                        </td>
                                        <td align="center">
                                            <?php if ($row['d_qty'] == $row['d_spend']) {

                                                echo "<span class='badge badge-pill badge-success'>ลงข้อมูลแล้ว</span>";
                                            } else {

                                                echo "<form method='post' class='form-horizontal' action='update.php?d_id=" . $row["d_id"] . "&o_id=" . $row["o_id"] . "&w_id=" . $row["w_id"] . "'>";
                                                echo   " <input type='hidden' name='d_id' value=" . $row["d_id"] . ">";
                                                echo    "<input type='hidden' name='o_id' value=" . $row["o_id"] . ">";
                                                echo    "<input type='hidden' name='w_id' value=" . $row["w_id"] . ">";
                                                echo    "<input type='hidden' name='d_qty' value=" . $row["d_qty"] . ">";
                                                echo    "<input type='hidden' name='d_subtotal' value=" . $row["d_subtotal"] . ">";
                                                echo    "<input type='number' name='d_spend' id='d_spend' maxlength='15' style='width:50px;' />";
                                                echo    "<button class='btn-outline-primary btn-sm' type='submit'>บันทึก</button>";
                                                echo "</form>";
                                            }
                                            ?>
                                        </td>
                                    </tbody>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<?php include '../includes/footer_admin.php'; ?>
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


isset($_GET['o_id']) ? $id = $_GET['o_id'] : $id = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_date = $_POST["event_date"];
    $sql = "UPDATE order_head SET o_time_s = '$event_date' WHERE o_id = $id";
    if ($Connection->query($sql) === TRUE) {
        echo "<script>window.location='status.php;</script>";
    } else {
        echo "<script>alert('พบข้อผิดพลาด');window.location='status.php';</script>" . $Connection->error;
    }
}

?>


<?php
$sql1 = "SELECT * FROM order_head h
INNER JOIN tb_user u ON h.user_id = u.user_id
INNER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN tb_status s ON h.s_id = s.s_id
-- WHERE s.s_id = '0'
order by o_dttm desc
";  //เรียกข้อมูลมาแสดงทั้งหมด
$result1 = mysqli_query($Connection, $sql1);


$sql = "SELECT * FROM order_detail o
INNER JOIN order_head h ON o.o_id = h.o_id 
INNER JOIN tb_wasadu w ON o.w_id = w.w_id
";
$objQuery = mysqli_query($Connection, $sql);

// ************************พัสดุรออนุมัติ************************
$sql2 = "SELECT * FROM order_head h
INNER JOIN tb_user u ON h.user_id = u.user_id
INNER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN tb_status s ON h.s_id = s.s_id
WHERE s.s_id = '0'
order by o_dttm desc 
";  //เรียกข้อมูลมาแสดงทั้งหมด
$result2 = mysqli_query($Connection, $sql2);

// ************************พัสดุอนุมัติ************************
$sql3 = "SELECT * FROM order_head h
INNER JOIN tb_user u ON h.user_id = u.user_id
INNER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN tb_status s ON h.s_id = s.s_id
WHERE s.s_id = '1'
order by o_dttm desc
";  //เรียกข้อมูลมาแสดงทั้งหมด
$result3 = mysqli_query($Connection, $sql3);

// ************************พัสดุไม่อนุมัติ************************
$sql4 = "SELECT * FROM order_head h
INNER JOIN tb_user u ON h.user_id = u.user_id
INNER JOIN tb_agency a ON u.a_id = a.a_id
LEFT OUTER JOIN tb_status s ON h.s_id = s.s_id
WHERE s.s_id = '2'
order by o_dttm desc 
";  //เรียกข้อมูลมาแสดงทั้งหมด
$result4 = mysqli_query($Connection, $sql4);

?>


<link rel="stylesheet" type="text/css" href="../../assets/DataTables/datatables.min.css" />


<?php include '../includes/navber_admin.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>การอนุมัติ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">การอนุมัติ</li>
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
                    <div class="card" style="padding-top: 10px; padding-left: 10px; padding-right: 10px;">
                        <!-- <div class="card-header">
                            <h3 class="card-title">การอนุมัติ</h3>
                        </div> -->
                        <!-- /.card-header -->


                        <nav>
                            <ul class="nav nav-tabs nav-fill" id="myTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1">รออนุมัติ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2">อนุมัติแล้ว</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3">ไม่อนุมัติ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4">รายการทั้งหมด</a>
                                </li>
                            </ul>
                        </nav>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1">
                                <div class="card-body">
                                    <table id="datatables1" class="table table-bordered table-striped table-hover mb-0">
                                        <thead>
                                            <tr class="bg-Warning">
                                                <th scope="col">ลำดับที่</th>
                                                <th scope="col">รหัสผู้ใช้งาน</th>
                                                <th scope="col">ขื่อ</th>
                                                <th scope="col">หน่วยงาน</th>
                                                <th scope="col">วันที่เบิก</th>
                                                <th scope="col">วันที่จ่าย</th>
                                                <th scope="col">จัดการ</th>
                                                <th scope="col">สถานะ</th>
                                                <th scope="col">อนุมัติ-ไม่อนุมัติ</th>
                                            </tr>
                                        </thead>
                                        <form action="update_status.php" id="form_update" method="post" enctype="multipart/form-data">
                                            <tbody>
                                                <?php
                                                while ($row2 = mysqli_fetch_array($result2)) {
                                                ?>
                                                    <td align="center"><?php echo $row2["o_id"] ?></td>
                                                    <td align="center"><?php echo $row2["user_id"] ?></td>
                                                    <td><?php echo $row2["user_name"] . " " . $row2["user_surname"] ?></td>
                                                    <td><?php echo $row2["a_name"] ?></td>
                                                    <td><?php echo $row2["o_dttm"] ?></td>
                                                    <td align="center"><?php echo $row2["o_time_s"] ?>
                                                        <form action="status.php?o_id=<?php echo $row2["o_id"] ?>" method="post">
                                                            <label for="event_date">วันที่: </label>
                                                            <input type="date" id="event_date" name="event_date" required>
                                                            <button type="submit" class="btn btn-outline-success btn-sm">บันทึก</button>
                                                        </form>
                                                    </td>
                                                    <td align="center">
                                                        <a href='status_detail.php?o_id=<?php echo $row2["o_id"] ?>'><button type="button" class="btn btn-outline-secondary btn-sm">รายการเบิก</button></a>
                                                        <a href='report.php?o_id=<?php echo $row2["o_id"] ?>' target="_blank"><button type="button" class="btn btn-outline-primary btn-sm">รายงานใบเบิก</button></a>
                                                        <?php
                                                        if ($row2['s_id'] == '1') {
                                                            echo  "<a href='receivedQuantity.php?o_id=" . $row2["o_id"] . "' target='_blank'><button type='button' class='btn btn-outline-info btn-sm'>จ่ายพัสดุ</button></a>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php if ($row2['s_id'] == '0') {
                                                            // echo "<button type='button' class='btn btn-warning btn-sm' disabled>รออนุมัติ</button>";
                                                            // echo "<button class='button_2' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-warning'>รออนุมัติ</span>";
                                                        } elseif ($row2['s_id'] == '2') {
                                                            // echo "<button type='button' class='btn btn-danger btn-sm' disabled>ไม่อนุมัติ</button>";
                                                            // echo "<button class='button_1' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-danger'>ไม่อนุมัติ</span>";
                                                        } else {
                                                            // echo "<button type='button' class='btn btn-success btn-sm' disabled>อนุมัติแล้ว</button>";
                                                            // echo "<button class='button_3' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-success'>อนุมัติ</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="update_status.php?Action=Change&o_id=<?php echo $row2['o_id']; ?>" onclick="return confirm('ยืนยันการอนุมัติ')">
                                                            <?php if ($row2['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                        <a href="cancel.php?Action=Change&o_id=<?php echo $row2['o_id']; ?>" onclick="return confirm('ยืนยันการยกเลิก')">
                                                            <?php if ($row2['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                        <!--******************************** ปุ่มลบรายการเบิกพัสดุ *************************************** -->
                                                        <a href='delete_order.php?o_id=<?php echo $row2["o_id"] ?>' onclick="return confirm('ยื่นยันลบรายการเบิก')" ><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>
                                                        </a>
                                                        <!--******************************** ปุ่มลบรายการเบิกพัสดุ *************************************** -->
                                                    </td>
                                            </tbody>
                                        <?php
                                                }
                                        ?>
                                        </form>
                                    </table>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="tab2">
                                <div class="card-body">
                                    <table id="datatables2" class="table table-bordered table-striped table-hover mb-0">
                                        <thead>
                                            <tr class="bg-Success">
                                                <th scope="col">ลำดับที่</th>
                                                <th scope="col">รหัสผู้ใช้งาน</th>
                                                <th scope="col">ขื่อ</th>
                                                <th scope="col">หน่วยงาน</th>
                                                <th scope="col">วันที่เบิก</th>
                                                <th scope="col">วันที่จ่าย</th>
                                                <th scope="col">จัดการ</th>
                                                <th scope="col">สถานะ</th>
                                                <th scope="col">อนุมัติ-ไม่อนุมัติ</th>
                                            </tr>
                                        </thead>
                                        <form action="update_status.php" id="form_update" method="post" enctype="multipart/form-data">
                                            <tbody>
                                                <?php
                                                while ($row3 = mysqli_fetch_array($result3)) {
                                                ?>
                                                    <td align="center"><?php echo $row3["o_id"] ?></td>
                                                    <td align="center"><?php echo $row3["user_id"] ?></td>
                                                    <td><?php echo $row3["user_name"] . " " . $row3["user_surname"] ?></td>
                                                    <td><?php echo $row3["a_name"] ?></td>
                                                    <td><?php echo $row3["o_dttm"] ?></td>
                                                    <td align="center"><?php echo $row3["o_time_s"] ?>
                                                        <form action="status.php?o_id=<?php echo $row3["o_id"] ?>" method="post">
                                                            <label for="event_date">วันที่: </label>
                                                            <input type="date" id="event_date" name="event_date" required>
                                                            <button type="submit" class="btn btn-outline-success btn-sm">บันทึก</button>
                                                        </form>
                                                    </td>
                                                    <td align="center">
                                                        <a href='status_detail.php?o_id=<?php echo $row3["o_id"] ?>'><button type="button" class="btn btn-outline-secondary btn-sm">รายการเบิก</button></a>
                                                        <a href='report.php?o_id=<?php echo $row3["o_id"] ?>' target="_blank"><button type="button" class="btn btn-outline-primary btn-sm">รายงานใบเบิก</button></a>
                                                        <?php
                                                        if ($row3['s_id'] == '1') {
                                                            echo  "<a href='receivedQuantity.php?o_id=" . $row3["o_id"] . "' target='_blank'><button type='button' class='btn btn-outline-info btn-sm'>จ่ายพัสดุ</button></a>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php if ($row3['s_id'] == '0') {
                                                            // echo "<button type='button' class='btn btn-warning btn-sm' disabled>รออนุมัติ</button>";
                                                            // echo "<button class='button_2' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-warning'>รออนุมัติ</span>";
                                                        } elseif ($row3['s_id'] == '2') {
                                                            // echo "<button type='button' class='btn btn-danger btn-sm' disabled>ไม่อนุมัติ</button>";
                                                            // echo "<button class='button_1' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-danger'>ไม่อนุมัติ</span>";
                                                        } else {
                                                            // echo "<button type='button' class='btn btn-success btn-sm' disabled>อนุมัติแล้ว</button>";
                                                            // echo "<button class='button_3' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-success'>อนุมัติ</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="update_status.php?Action=Change&o_id=<?php echo $row3['o_id']; ?>" onclick="return confirm('ยืนยันการอนุมัติ')">
                                                            <?php if ($row3['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                        <a href="cancel.php?Action=Change&o_id=<?php echo $row3['o_id']; ?>" onclick="return confirm('ยืนยันการยกเลิก')">
                                                            <?php if ($row3['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                    </td>
                                            </tbody>
                                        <?php
                                                }
                                        ?>
                                        </form>
                                    </table>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="tab3">
                                <div class="card-body">
                                    <table id="datatables3" class="table table-bordered table-striped table-hover mb-0">
                                        <thead>
                                            <tr class="bg-danger">
                                                <th scope="col">ลำดับที่</th>
                                                <th scope="col">รหัสผู้ใช้งาน</th>
                                                <th scope="col">ขื่อ</th>
                                                <th scope="col">หน่วยงาน</th>
                                                <th scope="col">วันที่เบิก</th>
                                                <th scope="col">วันที่จ่าย</th>
                                                <th scope="col">จัดการ</th>
                                                <th scope="col">สถานะ</th>
                                                <th scope="col">อนุมัติ-ไม่อนุมัติ</th>
                                            </tr>
                                        </thead>
                                        <form action="update_status.php" id="form_update" method="post" enctype="multipart/form-data">
                                            <tbody>
                                                <?php
                                                while ($row4 = mysqli_fetch_array($result4)) {
                                                ?>
                                                    <td align="center"><?php echo $row4["o_id"] ?></td>
                                                    <td align="center"><?php echo $row4["user_id"] ?></td>
                                                    <td><?php echo $row4["user_name"] . " " . $row4["user_surname"] ?></td>
                                                    <td><?php echo $row4["a_name"] ?></td>
                                                    <td><?php echo $row4["o_dttm"] ?></td>
                                                    <td align="center"><?php echo $row4["o_time_s"] ?>
                                                        <form action="status.php?o_id=<?php echo $row4["o_id"] ?>" method="post">
                                                            <label for="event_date">วันที่: </label>
                                                            <input type="date" id="event_date" name="event_date" required>
                                                            <button type="submit" class="btn btn-outline-success btn-sm">บันทึก</button>
                                                        </form>
                                                    </td>
                                                    <td align="center">
                                                        <a href='status_detail.php?o_id=<?php echo $row4["o_id"] ?>'><button type="button" class="btn btn-outline-secondary btn-sm">รายการเบิก</button></a>
                                                        <a href='report.php?o_id=<?php echo $row4["o_id"] ?>' target="_blank"><button type="button" class="btn btn-outline-primary btn-sm">รายงานใบเบิก</button></a>
                                                        <?php
                                                        if ($row4['s_id'] == '1') {
                                                            echo  "<a href='receivedQuantity.php?o_id=" . $row4["o_id"] . "' target='_blank'><button type='button' class='btn btn-outline-info btn-sm'>จ่ายพัสดุ</button></a>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php if ($row4['s_id'] == '0') {
                                                            // echo "<button type='button' class='btn btn-warning btn-sm' disabled>รออนุมัติ</button>";
                                                            // echo "<button class='button_2' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-warning'>รออนุมัติ</span>";
                                                        } elseif ($row4['s_id'] == '2') {
                                                            // echo "<button type='button' class='btn btn-danger btn-sm' disabled>ไม่อนุมัติ</button>";
                                                            // echo "<button class='button_1' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-danger'>ไม่อนุมัติ</span>";
                                                        } else {
                                                            // echo "<button type='button' class='btn btn-success btn-sm' disabled>อนุมัติแล้ว</button>";
                                                            // echo "<button class='button_3' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-success'>อนุมัติ</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="update_status.php?Action=Change&o_id=<?php echo $row4['o_id']; ?>" onclick="return confirm('ยืนยันการอนุมัติ')">
                                                            <?php if ($row4['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                        <a href="cancel.php?Action=Change&o_id=<?php echo $row4['o_id']; ?>" onclick="return confirm('ยืนยันการยกเลิก')">
                                                            <?php if ($row4['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                    </td>
                                            </tbody>
                                        <?php
                                                }
                                        ?>
                                        </form>
                                    </table>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="tab4">
                                <div class="card-body">
                                    <table id="datatables4" class="table table-bordered table-striped table-hover mb-0">
                                        <thead>
                                            <tr class="bg-info">
                                                <th scope="col">ลำดับที่</th>
                                                <th scope="col">รหัสผู้ใช้งาน</th>
                                                <th scope="col">ขื่อ</th>
                                                <th scope="col">หน่วยงาน</th>
                                                <th scope="col">วันที่เบิก</th>
                                                <th scope="col">วันที่จ่าย</th>
                                                <th scope="col">จัดการ</th>
                                                <th scope="col">สถานะ</th>
                                                <th scope="col">อนุมัติ-ไม่อนุมัติ</th>
                                            </tr>
                                        </thead>
                                        <form action="update_status.php" id="form_update" method="post" enctype="multipart/form-data">
                                            <tbody>
                                                <?php
                                                while ($row1 = mysqli_fetch_array($result1)) {
                                                ?>
                                                    <td align="center"><?php echo $row1["o_id"] ?></td>
                                                    <td align="center"><?php echo $row1["user_id"] ?></td>
                                                    <td><?php echo $row1["user_name"] . " " . $row1["user_surname"] ?></td>
                                                    <td><?php echo $row1["a_name"] ?></td>
                                                    <td><?php echo $row1["o_dttm"] ?></td>
                                                    <td align="center"><?php echo $row1["o_time_s"] ?>
                                                        <form action="status.php?o_id=<?php echo $row1["o_id"] ?>" method="post">
                                                            <label for="event_date">วันที่: </label>
                                                            <input type="date" id="event_date" name="event_date" required>
                                                            <button type="submit" class="btn btn-outline-success btn-sm">บันทึก</button>
                                                        </form>
                                                    </td>
                                                    <td align="center">
                                                        <a href='status_detail.php?o_id=<?php echo $row1["o_id"] ?>'><button type="button" class="btn btn-outline-secondary btn-sm">รายการเบิก</button></a>
                                                        <a href='report.php?o_id=<?php echo $row1["o_id"] ?>' target="_blank"><button type="button" class="btn btn-outline-primary btn-sm">รายงานใบเบิก</button></a>
                                                        <?php
                                                        if ($row1['s_id'] == '1') {
                                                            echo  "<a href='receivedQuantity.php?o_id=" . $row1["o_id"] . "' target='_blank'><button type='button' class='btn btn-outline-info btn-sm'>จ่ายพัสดุ</button></a>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php if ($row1['s_id'] == '0') {
                                                            // echo "<button type='button' class='btn btn-warning btn-sm' disabled>รออนุมัติ</button>";
                                                            // echo "<button class='button_2' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-warning'>รออนุมัติ</span>";
                                                        } elseif ($row1['s_id'] == '2') {
                                                            // echo "<button type='button' class='btn btn-danger btn-sm' disabled>ไม่อนุมัติ</button>";
                                                            // echo "<button class='button_1' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-danger'>ไม่อนุมัติ</span>";
                                                        } else {
                                                            // echo "<button type='button' class='btn btn-success btn-sm' disabled>อนุมัติแล้ว</button>";
                                                            // echo "<button class='button_3' disabled></button>";
                                                            echo "<span class='badge badge-pill badge-success'>อนุมัติ</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="update_status.php?Action=Change&o_id=<?php echo $row1['o_id']; ?>" onclick="return confirm('ยืนยันการอนุมัติ')">
                                                            <?php if ($row1['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-success btn-sm'>อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                        <a href="cancel.php?Action=Change&o_id=<?php echo $row1['o_id']; ?>" onclick="return confirm('ยืนยันการยกเลิก')">
                                                            <?php if ($row1['s_id'] == '0') {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } else {
                                                                echo "<button type='button' class='btn btn-outline-danger btn-sm'>ไม่อนุมัติ</button>";
                                                            } ?>
                                                        </a>
                                                    </td>
                                            </tbody>
                                        <?php
                                                }
                                        ?>
                                        </form>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>




</div>
<script type="text/javascript" src="../../assets/DataTables/datatables.min.js"></script>
<script>
    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('c_image_preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables1').DataTable();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables2').DataTable();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables3').DataTable();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables4').DataTable();
    });
</script>

<?php
if (@$_GET['do'] == 'ok') {
    echo '<script type="text/javascript">
          swal("", "เพิ่มข้อมูลแล้ว !!", "success");
          </script>';

    echo '<meta http-equiv="refresh" content="1;url=status.php" />';
}
?>




<?php include '../includes/footer_admin.php'; ?>
<?php mysqli_close($Connection); ?>
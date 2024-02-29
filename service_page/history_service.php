<?php
require_once('../connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
}

$user_id = $_GET['user_id']; //สร้างตัวแปร p_id เพื่อรับค่า

$sql = "SELECT rp.rp_id,
u.user_name,
u.user_surname,
a.a_name,
rp.rp_date,
rp.rp_work_id,
rp.rs_id,
rs.rs_name,
rp.*
FROM rp_repair rp
left join rp_repair_status rs on rs.rs_id = rs.rs_id
left join tb_user u on u.user_id = rp.user_id
left join tb_agency a on a.a_id = u.a_id
WHERE u.user_id = $user_id
GROUP BY rp.rp_id DESC
";

//เรียกข้อมูลมาแสดงทั้งหมด
$result = mysqli_query($Connection, $sql);

?>

<style>
    #textttt {
        color: white;
        border-radius: 4px;
        background: #9ec8ff;
        box-shadow: -5px 5px 0px #3f5066,
            5px -5px 0px #fdffff;
    }

    .button1 {

        border-radius: 4px;
        background: #fe5858;
        box-shadow: -5px 5px 0px #662323,
            5px -5px 0px #ff8d8d;
    }

    .button2 {
        border-radius: 4px;
        background: #fed258;
        box-shadow: -5px 5px 0px #665423,
            5px -5px 0px #ffff8d;
    }

    .button3 {
        border-radius: 4px;
        background: #fed258;
        box-shadow: -5px 5px 0px #665423,
            5px -5px 0px #ffff8d;
    }

    .button4 {
        border-radius: 4px;
        background: #fed258;
        box-shadow: -5px 5px 0px #665423,
            5px -5px 0px #ffff8d;
    }

    .button5 {
        border-radius: 4px;
        background: #fe5858;
        box-shadow: -5px 5px 0px #662323,
            5px -5px 0px #ff8d8d;
    }

    .button6 {
        border-radius: 4px;
        background: #fe5858;
        box-shadow: -5px 5px 0px #662323,
            5px -5px 0px #ff8d8d;
    }

    .button7 {
        color: black;
        border-radius: 4px;
        background: #58fe79;
        box-shadow: -5px 5px 0px #236630,
            5px -5px 0px #8dffc2;
    }
</style>

<?php include_once '../includes/navbar_service_it.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ประวัติแจ้งซ่อม</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</li>
                        <li class="breadcrumb-item active">ประวัติแจ้งซ่อม</li>
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
                            <div class="card-body">
                                <table class="table table-hover table-bordered table-responsive-lg-12 mb-4" id="datatables">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>เลขที่ใบแจ้งซ่อม</th>
                                            <th>ขื่อ</th>
                                            <th>หน่วยงาน</th>
                                            <th>วันที่แจ้งซ่อม</th>
                                            <th>สถานะการซ่อม</th>
                                            <th>ผู้ปฏิบัติงาน</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        ?>
                                            <td><?php echo $row["rp_id"] ?></td>
                                            <td><?php echo $row["user_name"] . " " . $row["user_surname"] ?></td>
                                            <td><?php echo $row["a_name"] ?></td>
                                            <td><?php echo $row["rp_date"] ?></td>
                                            <td align="center">
                                                <?php if ($row['rs_id'] == '1') {
                                                    echo  "<p id='texttt' class='button1'>แจ้งซ่อม</p>";
                                                } elseif ($row['rs_id'] == '2') {
                                                    echo  "<p id='texttt' class='button2'>กำลังดำเนินการ</p>";
                                                } elseif ($row['rs_id'] == '3') {
                                                    echo  "<p id='texttt' class='button3'>รออะไหล่</p>";
                                                } elseif ($row['rs_id'] == '4') {
                                                    echo  "<p id='texttt' class='button4'>ซ่อมสำเร็จ</p>";
                                                } elseif ($row['rs_id'] == '5') {
                                                    echo  "<p id='texttt' class='button5'>ซ่อมไม่สำเร็จ</p>";
                                                } elseif ($row['rs_id'] == '6') {
                                                    echo  "<p id='texttt' class='button6'>ยกเลิกการซ่อม</p>";
                                                } elseif ($row['rs_id'] == '7') {
                                                    echo  "<p id='texttt' class='button7'>ส่งมอบเรียบร้อย</p>";
                                                }

                                                ?>
                                            </td>
                                            <td align="center"><?php if ($row['rp_work_id'] == '1') {
                                                                    echo "<p id='texttt'>" . $result_tb_user["user_name"] . ' ' . $result_tb_user["user_surname"] . "</p>";
                                                                } else {
                                                                }
                                                                ?></td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a href="detail_it.php?rp_id=<?php echo $row["rp_id"] ?>" type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    รายละเอียด
                                                </a>
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
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">รายละเอียดการแจ้งซ่อม</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                45165165651616
                <?php
                while ($row2 = mysqli_fetch_array($result)) {
                ?>
                    <?php echo $row2["rp_name"] ?>
                    <?php echo $row2["rp_detail"] ?>
                    <img src="it_img/<?php echo $row2["rp_img"] ?>" alt="" srcset="">

            </div>
        <?php
                }
        ?>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-primary btn-sm">Understood</button>
        </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer_admin.php'; ?>
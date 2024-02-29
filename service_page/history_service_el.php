<?php
require_once('../connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
}

$user_id = $_GET['user_id']; //สร้างตัวแปร p_id เพื่อรับค่า

$sql = "SELECT * FROM el_leave
WHERE user_id = $user_id
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

<?php include_once '../includes/navbar_service.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ติดตามการยื่นใบลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</li>
                        <li class="breadcrumb-item active">ติดตามการยื่นใบลา</li>
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
                                            <th>เลขที่ใบลา</th>
                                            <th>ขื่อ</th>
                                            <th>รายละเอียด</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        ?>
                                            <td><?php echo $row["el_id"] ?></td>
                                            <td><?php echo $row["user_name_1"] ?></td>
                                            <td><?php echo $row["el_detail"] ?></td>
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

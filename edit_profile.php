<?php
require_once('connections/mysqli.php');

session_start();

if ($_SESSION == NULL) {
    header("location:login.php");
    exit();
}

// รับ user_id ที่ต้องการแก้ไขจากพารามิเตอร์ URL
$user_id = $_GET['user_id'];

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_query = " SELECT * FROM tb_user u
                LEFT JOIN tb_agency a ON a.a_id = u.a_id
                WHERE u.user_id = $user_id";
$user_result = mysqli_query($Connection, $user_query);
$user_data = mysqli_fetch_assoc($user_result);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['user_name'];
    $user_surname = $_POST['user_surname'];
    $user_sex = $_POST['user_sex'];
    $position = $_POST['position'];
    $a_id = $_POST['a_id'];
    $user_email = $_POST['user_email'];

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // อัปเดตข้อมูลผู้ใช้ในฐานข้อมูล
    $update_query = "   UPDATE tb_user SET 
                            user_name = '$username',
                            user_surname = '$user_surname',
                            user_sex = '$user_sex', 
                            position = '$position',
                            a_id = '$a_id', 
                            user_email = '$user_email'
                        WHERE user_id = $user_id";
    $update_result = mysqli_query($Connection, $update_query);

    if ($update_result) {
        echo '<script>alert("อัปเดตผู้ใช้สำเร็จ");window.location="profile.php?user_id=' . $user_id . '";</script>';
    } else {
        echo '<script>alert("เกิดข้อผิดพลาดในการอัปเดตผู้ใช้");window.location="profile.php";</script>';
    }
}

?>
<?php include('includes/navbar_user.php'); ?>

<body class="sidebar-mini layout-fixed" style="height: auto;">
    <div class="wrapper">

        <div class="container-fluid mt-5">
            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <div class="card border-dark mt-4">
                        <div class="card-header bg-info">
                            <h3 class="card-title"><i class="fa fa-address-card fa-lg"></i> ข้อมูลส่วนตัวของฉัน</h5>
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <!-- ID -->
                                <input type="hidden" name="user_id" value="<?php echo $user_data['user_id']; ?>">

                                <!-- FNAME -->
                                <div class="form-group">
                                    <label>ชื่อ</label>
                                    <input type="text" class="form-control" name="user_name" value="<?php echo $user_data['user_name']; ?>" placeholder="Name" required="" />
                                </div>

                                <!-- LNAME -->
                                <div class="form-group">
                                    <label>นามสกุล</label>
                                    <input type="text" class="form-control" name="user_surname" value="<?php echo $user_data['user_surname']; ?>" placeholder="Surname" required="" />
                                </div>

                                <!-- SEX -->
                                <div class="form-group">
                                    <label>เพศ</label>
                                    <select class="form-control" name="user_sex">
                                        <option value="ชาย">ชาย</option>
                                        <option value="หญิง">หญิง</option>
                                    </select>
                                </div>

                                <!-- POSITION -->
                                <div class="form-group">
                                    <label>ตำแหน่ง</label>
                                    <input type="text" class="form-control" name="position" placeholder="Position" value="<?php echo $user_data['position']; ?>" required="" />
                                </div>

                                <!-- AGENCY -->
                                <div class="form-group">
                                    <label>หน่วยงาน</label>
                                    <select class="form-control" name="a_id" required="">
                                        <option value="">เลือกหน่วยงาน</option>
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

                                <!-- EMAIL -->
                                <div class="form-group">
                                    <label>อีเมล์</label>
                                    <input type="email" class="form-control" name="user_email" value="<?php echo $user_data['user_email']; ?>" placeholder="Email" required="" />
                                </div>

                                <button type="submit" class="btn btn-success" name="submit">แก้ไขข้อมูล</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include('includes/footer_user.php'); ?>
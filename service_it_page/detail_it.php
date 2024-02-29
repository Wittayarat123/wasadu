<?php
require_once('../connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
}

$rp_id = $_GET['rp_id']; //สร้างตัวแปร p_id เพื่อรับค่า

$sql = "SELECT
            *
        FROM
            rp_repair r
            LEFT JOIN tb_agency a ON a.a_id = r.a_id
            LEFT JOIN tb_user u ON u.user_id = r.user_id
            LEFT JOIN rp_repair_status s ON s.rs_id = r.rs_id
        WHERE r.rp_id = '$rp_id'
";  //เรียกข้อมูลมาแสดงทั้งหมด
$result = mysqli_query($Connection, $sql);
$objResult = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 600px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
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
                    <h1>รายละเอียดการซ่อม</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</li>
                        <li class="breadcrumb-item active">รายละเอียดการซ่อม</li>
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
                            <h3 class="card-title">รายละเอียดการซ่อม</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <td class="bg-info" style="width: 20%;"><b>ผู้แจ้ง</b></td>
                                    <td><?php echo $objResult["user_name"] . " " . $objResult["user_surname"]; ?></td>
                                </tbody>

                                <tbody>
                                    <td class="bg-info"><b>หน่วยงาน</b></td>
                                    <td><?php echo $objResult["a_name"]; ?></td>
                                </tbody>

                                <tbody>
                                    <td class="bg-info"><b>ชื่อเครื่อง</b></td>
                                    <td><?php echo $objResult["rp_name"]; ?></td>
                                </tbody>

                                <tbody>
                                    <td class="bg-info"><b>ประเภท</b></td>
                                    <td>
                                        <?php if ($objResult['rp_type'] == '1') {
                                            echo  "โปรแกรม";
                                        } elseif ($objResult['rp_type'] == '2') {
                                            echo  "อุปกรณ์คอมพิวเตอร์";
                                        } elseif ($objResult['rp_type'] == '3') {
                                            echo  "อินเตอร์เน็ต";
                                        } elseif ($objResult['rp_type'] == '4') {
                                            echo  "อื่นๆ";
                                        }
                                        ?>
                                    </td>
                                </tbody>

                                <tbody>
                                    <td class="bg-info"><b>รายละเอียดการซ่อม</b></td>
                                    <td><?php echo $objResult["rp_detail"]; ?></td>
                                </tbody>

                                <tbody>
                                    <td class="bg-info"><b>ไฟล์รูป</b></td>
                                    <td><img src="../service_it_page/it_img/<?php echo $objResult["rp_img"]; ?>" alt="" id="myImg"></td>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>

<?php include_once '../includes/footer_admin.php'; ?>
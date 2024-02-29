<?php
require_once('connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
    header("location:index.php");
    exit();
}

if ($_SESSION != NULL) {
    $sql_tb_user = "SELECT * FROM tb_user u  
  LEFT JOIN tb_agency a ON a.a_id = u.a_id
  WHERE user_username = '" . $_SESSION['user_username'] . "'";
    $query_tb_user = mysqli_query($Connection, $sql_tb_user);
    $result_tb_user = mysqli_fetch_array($query_tb_user, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <link href="assets/images/BG.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/main.css">
    <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body {
            /* background-color: #fbfbfb; */
            background-image: url("assets/images/banner.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        #services-2:before {
            position: absolute;
            content: "";
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background: linear-gradient(27deg, rgba(238, 174, 202, 0.4990371148459384) 0%, rgba(148, 187, 233, 0.5018382352941176) 100%);
        }

        .web-service-block {
            text-align: center;
            padding: 35px 25px;
            transition: 0.3s;
            border-radius: 10px;
            border: 10px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 10px;
            color: white;
        }

        .web-service-block:hover {
            background: #fff;
            border-color: transparent;
            color: #4196fa;
        }

        .ribbon {
            position: absolute;
            right: 5px;
            top: -5px;
            z-index: 1;
            overflow: hidden;
            width: 75px;
            height: 75px;
            text-align: right;
        }

        .ribbon span {
            font-size: 10px;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            text-align: center;
            line-height: 20px;
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            width: 100px;
            display: block;
            background: #79A70A;
            background: linear-gradient(#FFF700 0%, #FFB303 100%);
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 19px;
            right: -21px;
        }

        .ribbon span::before {
            content: "";
            position: absolute;
            left: 0px;
            top: 100%;
            z-index: -1;
            border-left: 3px solid #FFB303;
            border-right: 3px solid transparent;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #FFB303;
        }

        .ribbon span::after {
            content: "";
            position: absolute;
            right: 0px;
            top: 100%;
            z-index: -1;
            border-left: 3px solid transparent;
            border-right: 3px solid #FFB303;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #FFB303;
        }

        /* โรงพยาบาลวังเจ้า */
        svg {
            width: 100%;
            height: 100%;
        }

        svg text {
            animation: stroke 3s infinite alternate;
            stroke-width: 2;
            stroke: #ffffff;
            font-size: 64px;
        }

        @keyframes stroke {
            0% {
                fill: rgba(0, 155, 67, 0);
                stroke: #ffffff;
                stroke-dashoffset: 25%;
                stroke-dasharray: 0 50%;
                stroke-width: 2;
            }

            70% {
                fill: rgba(0, 155, 67, 0);
                stroke: #ffffff;
            }

            80% {
                fill: rgba(0, 155, 67, 0);
                stroke: #ffffff;
                stroke-width: 3;
            }

            100% {
                fill: #ffffff;
                stroke: rgba(0, 188, 69, 0);
                stroke-dashoffset: -25%;
                stroke-dasharray: 50% 0;
                stroke-width: 0;
            }
        }
    </style>
</head>

<?php include 'includes/navbar_home.php'; ?>

<body class="default">

    <section class="section mt-5" id="services-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12 text-center">
                    <div class="wrapper">
                        <svg>
                            <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                                โรงพยาบาลวังเจ้า อ.วังเจ้า จ.ตาก
                            </text>
                        </svg>
                    </div>
                    <!-- <div class="section-heading">
                        <h1 class="section-title mb-2 text-white">
                            โรงพยาบาลวังเจ้า อ.วังเจ้า จ.ตาก
                        </h1>
                    </div> -->
                </div>
            </div>

            <div class="container mt-5">
                <div class="animate-bottom">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-md-6">
                            <a href="stock.php">
                                <div class="web-service-block">
                                    <i class="fa fa-th-list mt-3" style="font-size:48px;"></i>
                                    <h3 class="text-1 mt-3">ระบบเบิกพัสดุ</h3>
                                    <p>INVENTORY SERVICE</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-sm-6 col-md-6">
                            <div class="box">
                                <div class="ribbon"><span>กำลังดำเนินการ</span></div>
                                <a href="./service_it_page/index.php">
                                    <div class="web-service-block">
                                        <i class="fa fa-desktop mt-3" style="font-size:48px;"></i>
                                        <h3 class="text-1 mt-3">ระบบแจ้งซ่อมคอมพิวเตอร์</h3>
                                        <p>COMPUTER SERVICE</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-md-6">
                            <div class="ribbon"><span>กำลังดำเนินการ</span></div>
                            <a href="./service_page/index.php">
                                <div class="web-service-block">
                                    <i class="fa fa-wheelchair mt-3" style="font-size:48px;"></i>
                                    <h3 text-white class="text-1 mt-3">ระบบงานการลา</h3>
                                    <p>LEAVE SERVICE</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-md-6">
                        <a href="logout.php">
                            <div class="web-service-block">
                                <i class="fas fa-sign-out-alt mt-3" style="font-size:48px;"></i>
                                <h3 text-white class="text-1 mt-3">ออกจากระบบ</h3>
                                <p>LOG OUT</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

</body>

<script type="text/javascript" src="assets/jquery/jquery-slim.min.js"></script>
<script type="text/javascript" src="assets/popper/popper.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<?php mysqli_close($Connection); ?>


<?php
if (@$_GET['do'] == 'ok') {
    echo '<script type="text/javascript">
    swal("", "ล็อคอินสำเร็จ !!!", "success");
</script>';
}
?>

</html>
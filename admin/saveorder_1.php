<?php
require_once('../connections/mysqli.php');

session_start();
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
</head>

<body class="default">

    <?php include '../includes/navber_admin.php'; ?>

    <!--สร้างตัวแปรสำหรับบันทึกการสั่งซื้อ -->
    <?php
    $pay_head = $_POST["pay_head"];
    $pay_d = $_POST["pay_d"];
    $pay_t = $_POST["pay_t"];
    $pay_time = $_POST["pay_time"];
    $pay_text = $_POST["pay_text"];

    $user_id = $_POST["user_id"];
    $dttm = Date("Y-m-d h:i:s");
    $s_id = "0";
    $pay_spend = "0";
    $pay_time_detail = Date("Y-m-d h:i:s");

    //บันทึกการสั่งซื้อลงใน order_detail
    mysqli_query($Connection, "BEGIN");
    $sql1    = "insert into tb_pay_order values(null, '$pay_time', '$pay_head', '$pay_d', '$pay_t', '$user_id', '$dttm', '$pay_text')";
    $query1    = mysqli_query($Connection, $sql1);

    //ฟังก์ชั่น MAX() จะคืนค่าที่มากที่สุดในคอลัมน์ที่ระบุ ออกมา หรือจะพูดง่ายๆก็ว่า ใช้สำหรับหาค่าที่มากที่สุด นั่นเอง.
    $sql2 = "SELECT max(pay_id) as pay_id FROM tb_pay_order WHERE pay_time_t = '$dttm' ";
    $query2    = mysqli_query($Connection, $sql2);
    $row = mysqli_fetch_array($query2);
    $pay_id = $row["pay_id"];

    //PHP foreach() เป็นคำสั่งเพื่อนำข้อมูลออกมาจากตัวแปลที่เป็นประเภท array โดยสามารถเรียกค่าได้ทั้ง $key และ $value ของ array
    foreach ($_SESSION['cart'] as $w_id => $qty) {
        $sql3    = "select * from tb_wasadu where w_id=$w_id";
        $query3    = mysqli_query($Connection, $sql3);
        $row3    = mysqli_fetch_array($query3);
        $total    = $row3['w_price'] * $qty;

        $sql4	= "insert into tb_pay_detail values(null, '$pay_id', '$w_id', '$qty', '$total', '$pay_spend', '$pay_time_detail')";
        $query4    = mysqli_query($Connection, $sql4);

        // ดึงข้อมูลสต็อกปัจจุบันของพัสดุ
        $current_stock_query = "SELECT w_quantity FROM tb_wasadu WHERE w_id = $w_id";
        $current_stock_result = mysqli_query($Connection, $current_stock_query);
        $current_stock_row = mysqli_fetch_assoc($current_stock_result);
        $current_stock = $current_stock_row['w_quantity'];

        // ตรวจสอบว่าสต็อกเพียงพอหรือไม่
        // if ($current_stock < $qty) {
        //     echo "สต็อกไม่เพียงพอ";
        //     exit;
        // }

        // คำนวณสต็อกใหม่
        $new_stock = $current_stock + $qty;

        // อัปเดตสต็อกใหม่ในฐานข้อมูล
        $update_query = "UPDATE tb_wasadu SET w_quantity = $new_stock WHERE w_id = $w_id";
        $update_result = mysqli_query($Connection, $update_query);
    }

    $sql123 = "	SELECT * FROM tb_user u
				LEFT JOIN tb_agency a ON a.a_id = u.a_id
				WHERE u.user_id = '$user_id'";
    $query123 = mysqli_query($Connection, $sql123);
    $row = mysqli_fetch_array($query123);
    $user_name_1 = $row["user_name"];
    $user_name_2 = $row["user_surname"];

    //แจ้งเตือนผ่านไลน์
    define('LINE_API', "https://notify-api.line.me/api/notify");

    $token = "YfI7SFbHewEQzU9s5NWWYf0Pi8ECBEHPIpHCW1UABSw"; //ใส่Token ที่copy เอาไว้

    $str = "มีการเพิ่มสต๊อกพัสดุใหม่: " . "" . $user_name_1 . "  " . $user_name_2 . "" . "http://172.20.250.202/login/index.php";
    //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร

    $res = notify_message($str, $token);
    //print_r($res);
    function notify_message($message, $token)
    {
        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                    . "Authorization: Bearer " . $token . "\r\n"
                    . "Content-Length: " . strlen($queryData) . "\r\n",
                'content' => $queryData
            ),
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents(LINE_API, FALSE, $context);
        $res = json_decode($result);
        return $res;
    }
    //exit();



    if ($query1 && $query4) {
        mysqli_query($Connection, "COMMIT");
        $msg = "บันทึกข้อมูลเรียบร้อยแล้ว ";
        foreach ($_SESSION['cart'] as $w_id) {
            //unset($_SESSION['cart'][$w_id]);
            unset($_SESSION['cart']);
        }
    } else {
        mysqli_query($Connection, "ROLLBACK");
        $msg = "บันทึกข้อมูลไม่สำเร็จ กรุณาติดต่อเจ้าหน้าที่ค่ะ ";
    }
    ?>
    <script type="text/javascript">
        alert("<?php echo $msg; ?>");
        window.location = 'stock_up.php';
    </script>







    <script type="text/javascript" src="assets/jquery/jquery-slim.min.js"></script>
    <script type="text/javascript" src="assets/popper/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <?php mysqli_close($Connection); ?>
</body>

</html>

<?php include '../includes/footer_admin.php'; ?>
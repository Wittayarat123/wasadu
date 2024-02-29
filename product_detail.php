<?php
require_once('connections/mysqli.php');

session_start();
//connect db
$w_id = $_GET['w_id']; //สร้างตัวแปร p_id เพื่อรับค่า

$sql = "select * from tb_wasadu where w_id=$w_id";  //รับค่าตัวแปร p_id ที่ส่งมา
$result = mysqli_query($Connection, $sql);
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

  <?php include 'includes/navbar.php'; ?>
  <div class="container mt-5">
    <div class="card">
      <div class="card-body mt-4">
        <table width="600" border="0" align="center" class="square">
          <tr>
            <td colspan="3" bgcolor="#CCCCCC"><b>รายละเอียดพัสดุ</b></td>
          </tr>

          <?php
          $row = mysqli_fetch_array($result);
          //แสดงรายละเอียด
          echo "<tr>";
          echo "<td width='85' valign='top'><b>Title</b></td>";
          echo "<td width='279'>" . $row["w_name"] . "</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td valign='top'><b>Detail</b></td>";
          echo "<td>" . $row["w_detail"] . "</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td valign='top'><b>Price</b></td>";
          echo "<td>" . number_format($row["w_price"], 2) . "</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td colspan='2' align='center'>";
          echo "<a type='button' class='btn btn-success' href='cart.php?w_id=$row[w_id]&act=add'> เพิ่มลงตะกร้า </a></td>";
          echo "</tr>";
          ?>
        </table>

        <p>
          <center><a type="button" class="btn btn-secondary" href="product.php">กลับไปหน้ารายการ</a></center>
      </div>
    </div>
  </div>


  <?php include 'includes/footer.php'; ?>
  <script type="text/javascript" src="assets/jquery/jquery-slim.min.js"></script>
  <script type="text/javascript" src="assets/popper/popper.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <?php mysqli_close($Connection); ?>
</body>

</html>
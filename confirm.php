<?php
require_once('connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
  header("location:login.php");
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

<?php include 'includes/navbar_user.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>สรุปการเบิก</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="stock.php">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">สรุปการเบิก</li>
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
              <form id="frmcart" name="frmcart" method="post" action="saveorder.php">
                <table class="table table-bordered table-striped">

                  <tr>
                    <td width="1558" colspan="4" bgcolor="#FFDDBB">
                      <strong>รายการเบิก</strong>
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
                  <!-- <tr>
              <td colspan="2" bgcolor="#CCCCCC">รายละเอียดในการติดต่อ</td>
            </tr>
            <tr>
              <td bgcolor="#EEEEEE">ชื่อ</td>
              <td><input name="name" type="text" id="name"  /></td>
            </tr>
            <tr>
              <td width="22%" bgcolor="#EEEEEE">ที่อยู่</td>
              <td width="78%">
                <textarea name="address" cols="35" rows="5" id="address" ></textarea>
              </td>
            </tr>
            <tr>
              <td bgcolor="#EEEEEE">อีเมล</td>
              <td><input name="email" type="email" id="email"  /></td>
            </tr>
            <tr>
              <td bgcolor="#EEEEEE">เบอร์ติดต่อ</td>
              <td><input name="phone" type="text" id="phone"  /></td>
            </tr>
            <tr> -->
                  <td colspan="2" align="center" bgcolor="#CCCCCC">
                    <input class="btn btn-success" type="submit" name="Submit2" value="สั่งเบิก" />
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



  <?php include 'includes/footer_user.php'; ?>

  <?php mysqli_close($Connection); ?>
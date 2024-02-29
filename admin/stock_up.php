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
//connect db
$sql = "SELECT *,(w.w_quantity)AS qua FROM tb_wasadu w
        LEFT JOIN tb_count c ON w.c_id = c.c_id
        -- WHERE w.w_quantity > '0' 
        ORDER BY w.w_id ASC";  //เรียกข้อมูลมาแสดงทั้งหมด
$result = mysqli_query($Connection, $sql);

if ($_SESSION != NULL) {
  $sql_tb_user = "SELECT * FROM tb_user WHERE user_username = '" . $_SESSION['user_username'] . "'";
  $query_tb_user = mysqli_query($Connection, $sql_tb_user);
  $result_tb_user = mysqli_fetch_array($query_tb_user, MYSQLI_ASSOC);
}

$w_id = $_GET['w_id'];
$act = $_GET['act'];

if ($act == 'add' && !empty($w_id)) {
  if (isset($_SESSION['cart'][$w_id])) {
    $_SESSION['cart'][$w_id]++;
  } else {
    $_SESSION['cart'][$w_id] = 1;
  }
}

if ($act == 'remove' && !empty($w_id))  //ยกเลิกการสั่งซื้อ
{
  unset($_SESSION['cart'][$w_id]);
}

if ($act == 'update') {
  $amount_array = $_POST['amount'];
  foreach ($amount_array as $w_id => $amount) {
    $_SESSION['cart'][$w_id] = $amount;
  }
}

?>
<style>
  img {
    width: 50px;
    height: 50px;
  }
</style>


</head>

<?php include '../includes/navber_admin.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>สต๊อกพัสดุ</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="stock.php">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">สต๊อกพัสดุ</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-7 col-lg-12 col-md-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">รายการพัสดุ</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped" style="width: 100%; height: 200px;">
                <thead>
                  <tr>
                    <th class="col-sm-6">ชื่อพัสดุ</th>
                    <th class="col-sm-1">รูปภาพ</th>
                    <th class="col-sm-1 text-center">ราคา</th>
                    <th class="col-sm-1 text-center">หน่วย</th>
                    <th class="col-sm-1 text-center">จำนวน</th>
                    <th class="col-sm-2 text-center">หมายเหตุ</th>
                    <th class="col-sm-2 text-center">รายละเอียดพัสดุ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                      <td><?php echo $row["w_name"] ?> </td>
                      <td align="center">
                        <?php if ($row['w_img'] == '') {
                          echo "<button class='btn btn-outline-light btn-sm'><img src='../assets/images/noimage.png' alt='Image' class='image-popup' data-bs-toggle='modal' data-bs-target='#imageModal123' data-bs-img-src='../assets/images/noimage.png'></button>";
                          // echo "<button class='btn btn-outline-primary btn-sm' class='img-thumbnail' data-bs-toggle='modal' data-bs-target='#imageModal123' data-bs-img-src='assets/images/noimage.png' > ดูรูปภาพ </button>";
                        } else {
                          echo "<button class='btn btn-outline-light btn-sm'><img src='../assets/img_w/" . $row["w_img"] . "' alt='Image' class='image-popup' data-bs-toggle='modal' data-bs-target='#imageModal' data-bs-img-src='../assets/img_w/" . $row["w_img"] . "'></button>";
                          // echo "<button class='btn btn-outline-primary btn-sm' class='img-thumbnail' data-bs-toggle='modal' data-bs-target='#imageModal' data-bs-img-src='assets/img_w/" . $row["w_img"] . "' >ดูรูปภาพ</button>";
                        }
                        ?>
                        <!-- <button class='btn btn-outline-primary btn-sm" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img-src="./assets/img_w/<?php echo $row["w_img"] ?>">ดูรูปภาพ</button> -->
                        <!-- <img src="./assets/img_w/<?php echo $row["w_img"] ?>" alt="Image 1" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img-src="./assets/img_w/<?php echo $row["w_img"] ?>"> -->
                      </td>
                      <td align="center"><?php echo number_format($row["w_price"], 2) ?> </td>
                      <td align="center"><?php echo $row["c_name"] ?> </td>
                      <td align="center"><?php echo $row["qua"] ?> </td>
                      <td><?php echo $row["w_textcom"] ?> </td>
                      <td align="center">
                        <a href='cart_1.php?w_id=<?php echo $row["w_id"] ?>&act=add'>
                          <button type="button" class="btn btn-outline-primary btn-sm">
                            เพิ่ม
                          </button>
                        </a>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-xl-5 col-lg-12 col-md-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">รายการสต๊อกพัสดุ</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form id="frmcart" name="frmcart" method="post" action="?act=update">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <tr>
                      <td bgcolor="#EAEAEA">พัสดุ</td>
                      <td align="center" bgcolor="#EAEAEA">ราคา</td>
                      <td align="center" bgcolor="#EAEAEA">จำนวน</td>
                      <td align="center" bgcolor="#EAEAEA">รวม(บาท)</td>
                      <td align="center" bgcolor="#EAEAEA">ลบ</td>
                    </tr>
                    <?php
                    $total = 0;
                    if (!empty($_SESSION['cart'])) {
                      foreach ($_SESSION['cart'] as $w_id => $qty) {
                        $sql = "select * from tb_wasadu where w_id=$w_id";
                        $query = mysqli_query($Connection, $sql);
                        $row = mysqli_fetch_array($query);
                        $sum = $row['w_price'] * $qty;
                        $total += $sum;

                        echo "<tr>";
                        echo "<td width='334'>" . $row["w_name"] . "</td>";
                        echo "<td width='46' align='right'></td>";
                        echo "<td width='57' align='center'>";
                        echo "<input type='text' name='amount[$w_id]' value='$qty' size='2'/></td>";
                        echo "<td width='93' align='right'>" . number_format($sum, 1) . "</td>";
                        //remove product
                        echo "<td width='46' align='center'><a type='button' class='btn btn-danger' href='cart_1.php?w_id=$w_id&act=remove'>ลบ</a></td>";
                        echo "</tr>";
                      }
                      echo "<tr>";
                      echo "<td colspan='3' bgcolor='#CEE7FF' align='center'><b>ราคารวม</b></td>";
                      echo "<td align='right' bgcolor='#CEE7FF'>" . "<b>" . number_format($total, 2) . "</b>" . "</td>";
                      echo "<td align='left' bgcolor='#CEE7FF'></td>";
                      echo "</tr>";
                    }
                    ?>
                    <tr>
                      <!-- <br><a href="product.php" type="button" class="btn btn-secondary mt-4">กลับหน้ารายการเบิก</a> -->
                      <td></td>
                      <td colspan="4" align="right">
                        <input type="submit" class="btn btn-warning mt-4" name="button" id="button" value="ปรับปรุง" />
                        <input type="button" class="btn btn-success mt-4" name="Submit2" value="เพิ่ม" onclick="window.location='confirm_1.php';" />
                      </td>
                    </tr>
                  </table>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Modal123 -->
  <div class="modal fade" id="imageModal123" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body" align="center">
          <!-- Image inside modal -->
          <img src="../assets/images/noimage.png" alt="Image" style="width: 500px; height: 500px;">
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    var imageModal = document.getElementById('imageModal123');
    var modalImage = imageModal.querySelector('.modal-body img');

    imageModal.addEventListener('show.bs.modal', function(event) {
      var thumbnail = event.relatedTarget;
      var imageSrc = thumbnail.dataset.bsImgSrc;

      modalImage.src = imageSrc;
    });
  </script>


  <!-- Modal -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body" align="center">
          <img src="" alt="Modal Image" class="img-fluid" style="width: 500px; height: 500px;">
        </div>
      </div>
    </div>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
  var imageModal = document.getElementById('imageModal');
  var modalImage = imageModal.querySelector('.modal-body img');

  imageModal.addEventListener('show.bs.modal', function(event) {
    var thumbnail = event.relatedTarget;
    var imageSrc = thumbnail.dataset.bsImgSrc;

    modalImage.src = imageSrc;
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#datatables').DataTable();
  });
</script>

<script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>

<?php mysqli_close($Connection); ?>

<?php include '../includes/footer_admin.php'; ?>
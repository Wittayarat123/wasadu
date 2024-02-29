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

$w_id = $_GET['w_id'];
$act = $_GET['act'];

if ($act == 'add' && !empty($w_id)) {
	if (isset($_SESSION['cart'][$w_id])) {
		$_SESSION['cart'][$w_id]++;
	} else {
		$_SESSION['cart'][$w_id] = 1;
	}
}

if ($act == 'remove' && !empty($w_id))  //ยกเลิกการสั่งเบิก
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
							<li class="breadcrumb-item"><a href="stock_up.php">หน้าหลัก</a></li>
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
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">สต๊อกพัสดุ</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<form id="frmcart" name="frmcart" method="post" action="?act=update">
									<table width="100%" border="0" align="center" class="table square">
										<tr>
											<td colspan="5" bgcolor="#CCCCCC">
												<b>สต๊อกพัสดุ</span>
											</td>
										</tr>
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
												echo "<td width='46' align='center'><a type='button' class='btn btn-danger' href='cart.php?w_id=$w_id&act=remove'>ลบ</a></td>";
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
											<br>
											<td><a href="stock_up.php" type="button" class="btn btn-secondary mt-4">กลับหน้ารายการสต๊อกพัสดุ</a></td>
											<td colspan="4" align="right">
												<input type="submit" class="btn btn-warning mt-4" name="button" id="button" value="ปรับปรุง" />
												<!-- <input type="button" class="btn btn-success mt-4" name="Submit2" value="เบิก" onclick="window.location='confirm.php';" /> -->
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
	</div>

	
	<?php
    echo "<script>window.location='stock_up.php'</script>";
?>
	<?php include '../includes/footer_admin.php'; ?>


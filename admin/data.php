<?php
include_once '../connections/mysqli.php';
?>
<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<title>wangchao_hos</title>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">

		google.charts.load('current', {
			'packages': ['corechart']
		});
		google.charts.setOnLoadCallback(drawChart);


		function drawChart() {
			var data = google.visualization.arrayToDataTable([

				['ch_name', 'ch_price'],



				<?php
				$query = "	SELECT
								tb_wasadu.w_name,
								order_detail.d_qty 
							FROM
								order_detail
								LEFT JOIN tb_wasadu ON tb_wasadu.w_id = order_detail.w_id";
				$rs = mysqli_query($Connection, $query);
				foreach ($rs as $rs_c) {
					echo "['" . $rs_c['w_name'] . "'," . $rs_c['d_qty'] . "],";
				}
				?>

			]);

			var options = {
				title: 'รายการเบิก'
			};

			var chart = new google.visualization.PieChart(document.getElementById('piechart'));

			chart.draw(data, options);
		}
	</script>


</head>

<body>
	<div class="container-fluid">
		<div id="piechart" style="width: 100%; height: 500px;"></div>
	</div>

</body>

</html>
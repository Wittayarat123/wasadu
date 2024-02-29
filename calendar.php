<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8' />
	<link href='http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css' rel='stylesheet' />
	<link href='http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.print.css' rel='stylesheet' media='print' />

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<style>
		#calendar {
			margin-top: 10px;
		}
	</style>
</head>

<body>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<!-- <h4>Example Fullcalendar Modal With MySQL</h4> -->
							<!-- Button trigger modal New data-->
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#new_calendar_modal">
								เพิ่มข้อมูล
							</button>
							<div id='calendar'></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Button trigger modal Edit data-->
	<span id="trigger_modal" data-toggle="modal" data-target="#calendar_modal"></span>

	<!-- Modal For edit data-->
	<div class="modal fade" id="calendar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Fullcalendar Modal With MySQL</h4>
				</div>
				<div id="get_calendar"></div>
			</div>
		</div>
	</div>


	<!-- Modal For new data-->
	<div class="modal fade" id="new_calendar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">New Fullcalendar Modal With MySQL</h4>
				</div>
				<div class="modal-body">
					<form id="new_calendar">
						<div class="form-group">
							<label>เรื่อง</label>
							<input type="text" class="form-control" name="title" placeholder="">
						</div>
						<div class="form-group">
							<label>วันที่เริมต้น</label>
							<input type="text" class="form-control" name="start" placeholder="">
						</div>
						<div class="form-group">
							<label>วันที่สิ้นสุด</label>
							<input type="text" class="form-control" name="end" placeholder="">
						</div>
						<input type="hidden" name="new_calendar_form">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="return new_calendar();">บันทึกข้อมูล</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>

				</div>
			</div>
		</div>
	</div>

	<!-- Javascript -->
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src='https://fullcalendar.io/js/fullcalendar-2.4.0/lib/moment.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js'></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<!-- นำเข้า script File -->
	<script src='script.js'></script>
</body>

</html>
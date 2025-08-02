<?php
require_once('connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
  header("location:index.php");
  exit();
}

?>

<style>
  .container {
    width: 100%;
    min-height: 92.9vh;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    padding: 15px;
    /* background: #9053c7;
            background: -webkit-linear-gradient(-135deg, #c850c0, #4158d0);
            background: -o-linear-gradient(-135deg, #c850c0, #4158d0);
            background: -moz-linear-gradient(-135deg, #c850c0, #4158d0);
            background: linear-gradient(-135deg, #c850c0, #4158d0);
            background-image: "admin/img/rainbow-vortex.png"; */
    /* background-image: url("assets/images/banner.jpg");
      background-repeat: no-repeat;
      background-size: cover; */
  }

  .wrap-login101 {
    width: 1000px;
    background: rgba(255, 255, 255, 0.6);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(0px);
    -webkit-backdrop-filter: blur(0px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 10px;
    overflow: hidden;

    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 100px 200px 100px 250px;
  }

  .default {
    margin-left: 250px;
    padding: 20px;
  }

  #calendar {
    margin: auto;
    width: 50%;
  }

</style>
<?php include 'includes/navbar_user.php'; ?>

<link href='http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css' rel='stylesheet' />
<link href='http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.print.css' rel='stylesheet' media='print' />

<?php
$date1 = date("Y-m-d");
$sql123 = "SELECT * FROM calendar WHERE ('$date1') >= `start` AND ('$date1') <= `end`";  //เรียกข้อมูลมาแสดงทั้งหมด
$result123 = mysqli_query($Connection, $sql123);
$objResult123 = mysqli_fetch_array($result123, MYSQLI_ASSOC);

if ($date1 >= $objResult123['start'] && $date1 <= $objResult123['end']) {
  echo "<div class='content-wrapper'>";
  echo "<!-- Content Header (Page header) -->";
  echo "<section class='content-header'>";
  echo "   <div class='container-fluid'>";
  echo "     <div class='row mb-2'>";
  echo "      <div class='col-sm-6 mx-auto'>";
  echo "        <h1>ระบบเบิกพัสดุ โรงพยาบาลวังเจ้า</h1>";
  echo "      </div>";
  echo "    </div>";
  echo "  </div><!-- /.container-fluid -->";
  echo "</section>";
} else {
  echo "<div class='content-wrapper'>";
  echo "<section class='content-header'>";
  echo "   <div class='container-fluid'>";
  echo "     <div class='row mb-2'>";
  echo "      <div class='col-sm-3 mx-auto'>";
  echo "        <h1>ระบบเบิกพัสดุ โรงพยาบาลวังเจ้า</h1>";
  echo "      </div>";
  echo "      <div class='col-sm-5 mx-auto'>";
  echo "          <h1 style='color:red'>ยังไม่ถึงกำหนดเบิกพัสดุ</h1>";
  echo "      </div>";
  echo "    </div>";
  echo "  </div><!-- /.container-fluid -->";
  echo "</section>";


  echo "<section class='content'>";
  echo "<div class='container-fluid'>";
  echo "<div class='row'>";
  echo "<div class='col-12'>";
  echo "<div class='card'>";
  echo "<div class='card-header'>";
  echo "<h3 class='card-title'>ปฎิทิน</h3>";
  echo "</div>";
  echo "<div class='card-body'>";
  echo "<div id='calendar' style='margin-top: 10px;'></div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";

  echo "</section>";
}
?>


<!-- Content Wrapper. Contains page content
<div class="content-wrapper">
  Content Header (Page header)
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 mx-auto">
          <h1>ระบบเบิกพัสดุ โรงพยาบาลวังเจ้า</h1>
        </div>
      </div>
    </div>/.container-fluid
  </section> -->

<?php mysqli_close($Connection); ?>
<?php
if (@$_GET['do'] == 'ok') {
  echo '<script type="text/javascript">
    swal("", "ล็อคอินสำเร็จ !!!", "success");
</script>';

  echo '
<meta http-equiv="refresh" content="1;url=stock.php" />';
}
?>

<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#datatables').DataTable();
  });
</script>
<!-- Javascript -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.4.0/lib/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js'></script>

<!-- นำเข้า script File -->
<script src='script.js'></script>

<script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
<?php include 'includes/footer_user.php'; ?>
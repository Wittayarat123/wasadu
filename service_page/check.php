<?php
require_once('../connections/mysqli.php');

session_start();
if ($_SESSION == NULL) {
    header("location:../index.php");
    exit();
}

?>
<?php include_once '../includes/navbar_service.php'; ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>เช็คการลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">หน้าหลัก</li>
                        <li class="breadcrumb-item active">เช็คการลา</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-chart-bar"></i>
                                jQuery Knob Different Sizes
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 col-md-3 text-center">
                                    <div style="display:inline;width:90px;height:90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" value="30" data-width="90" data-height="90" data-fgcolor="#3c8dbc" data-readonly="true" readonly="readonly" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; appearance: none;"></div>

                                    <div class="knob-label">data-width="90"</div>
                                </div>
                                <!-- ./col -->
                                <div class="col-6 col-md-3 text-center">
                                    <div style="display:inline;width:120px;height:120px;"><canvas width="120" height="120"></canvas><input type="text" class="knob" value="30" data-width="120" data-height="120" data-fgcolor="#f56954" style="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px; background: none; font: bold 24px Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; appearance: none;"></div>

                                    <div class="knob-label">data-width="120"</div>
                                </div>
                                <!-- ./col -->
                                <div class="col-6 col-md-3 text-center">
                                    <div style="display:inline;width:90px;height:90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" value="30" data-thickness="0.1" data-width="90" data-height="90" data-fgcolor="#00a65a" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; appearance: none;"></div>

                                    <div class="knob-label">data-thickness="0.1"</div>
                                </div>
                                <!-- ./col -->
                                <div class="col-6 col-md-3 text-center">
                                    <div style="display:inline;width:120px;height:120px;"><canvas width="120" height="120"></canvas><input type="text" class="knob" data-thickness="0.2" data-anglearc="250" data-angleoffset="-125" value="30" data-width="120" data-height="120" data-fgcolor="#00c0ef" style="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px; background: none; font: bold 24px Arial; text-align: center; color: rgb(0, 192, 239); padding: 0px; appearance: none;"></div>

                                    <div class="knob-label">data-angleArc="250"</div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>

</div>


<?php include_once '../includes/footer_service.php'; ?>
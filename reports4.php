<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/25/14
 * Time: 12:58 PM
 */

#including our init.php
require 'core/init.php';
$obj_general->logged_out_protect();
$obj_general->is_admin();


$arr_user = $obj_users->userdata($_SESSION['id']);
$str_full_name = $arr_user['first_name'] . ' ' . $arr_user['last_name'];

$str_page = 'reports';

$str_this_week = $obj_general->this_week_start_and_end_dates();

?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php' ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default reports-summary-panel">
                    <div class="panel-heading">
                        <h4>Reports - Auditorium</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12 no-hr-padding">
                            <div class="col-md-2 no-hr-padding">
                                <select name="report_of" class="form-control inline report-of">
                                    <option value="week" selected>This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="quarter">This Quarter</option>
                                    <option value="year">This Year</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <h6>01 Apr 2014 - 30 April 2014</h6>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="Auditorium">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <select name="which_resource" class="form-control inline">
                                    <option value="all" selected>All Resources</option>
                                    <option value="teachers">Teachers</option>
                                    <option value="rooms">Rooms</option>
                                    <option value="miscellaneous">Miscellaneous</option>
                                    <option value="vehicle">Vehicle</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                        </div>
                        <hr/>
                        <div class="col-md-12 mt30">
                            <div class="col-md-4">
                                <div class="col-md-12 no-hr-padding large-progress-bar">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar"
                                             aria-valuenow="49" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 49%">
                                            <span class="sr-only">49% Utilization</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 no-hr-padding text-center">
                                    <h2 class="mb0">49%</h2>
                                    <span class="utilization text-muted">Utilization</span>
                                </div>
                            </div>
                            <div class="col-md-4 booked-hours">
                                <div class="col-md-12 no-hr-padding">
                                    <div class="col-md-6 no-hr-padding booked">
                                        <h5>98h</h5>
                                        <h6 class="text-muted">BOOKED</h6>
                                    </div>
                                    <div class="col-md-6 no-hr-padding not-booked">
                                        <h5>100h</h5>
                                        <h6 class="text-muted">NOT BOOKED</h6>
                                    </div>
                                </div>
                                <div class="col-md-12 no-hr-padding total-availability">
                                    <h5>198h</h5>
                                    <h6 class="text-muted">TOTAL AVAILABILITY</h6>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="col-md-12 no-hr-padding mt100">
                            <?php include 'partials/resource-list-4.php' ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include 'partials/footer.php' ?>
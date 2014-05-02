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

$arr_user = $obj_users->userdata($_SESSION['id']);
$bln_is_admin = $obj_general->is_admin($arr_user);
$bln_is_moderator = $obj_general->is_moderator($arr_user);
$bln_is_resource = $obj_general->is_resource($arr_user);

$str_full_name = $arr_user['first_name'] . ' ' . $arr_user['last_name'];

$str_page = 'reports';

$arr_this_week = $obj_general->get_week_dates();
$arr_this_month = $obj_general->get_month_dates();
//$arr_this_quarter = $obj_general->get_quarter_dates();

if (isset($_GET['report_timespan'])) {
    $str_time_span = $_GET['report_timespan'];

    if ($str_time_span == 'month') {
        $arr_dates = $arr_this_month;
    } else if ($str_time_span == 'custom') {
        $arr_dates['start'] = $_GET['from'];
        $arr_dates['end'] = $_GET['to'];
    } else {
        $arr_dates = $arr_this_week;
    }

} else {
    $arr_dates = $arr_this_week;
}

if (isset($_GET['resource_id']) || $bln_is_resource) {
    if ($bln_is_resource) {
        $int_resource_id = $arr_user['resource_id'];
        $str_resource_name = $arr_user['first_name'];
    } else {
        $int_resource_id = $_GET['resource_id'];
        $str_resource_name = $_GET['resource_name'];
    }
}

if ($bln_is_moderator) {

    if ($bln_is_resource) {
        $arr_resources_list = $obj_resources->get_booking_details_single_resource($int_resource_id, $arr_dates['start'], $arr_dates['end']);
        $arr_booking_details = $arr_resources_list;
    } else {
        $arr_all_resources = $obj_resources->get_resources();

        if (isset($_GET['resource_type'])) {
            $str_resource_type = $_GET['resource_type'];

            if ($str_resource_type == 'all') {
                $arr_resources_list = $obj_resources->get_booking_details_of_all_resources($arr_dates['start'], $arr_dates['end']);
            } else if ($str_resource_type == 'custom') {
                $arr_resources_list = $obj_resources->get_booking_details_single_resource($int_resource_id, $arr_dates['start'], $arr_dates['end']);
                $arr_booking_details = $arr_resources_list;
            } else {
                $arr_resources_list = $obj_resources->get_booking_details_resource_type($str_resource_type, $arr_dates['start'], $arr_dates['end']);
            }
        } else {
            $arr_resources_list = $obj_resources->get_booking_details_of_all_resources($arr_dates['start'], $arr_dates['end']);
        }
        $arr_resources_utilization_stats = $obj_resources->resources_utilization_stats($arr_resources_list);
    }

} else if ($arr_user['category_id'] == 3) {
    #$arr_resources_list = $obj_resources->get_booking_details_of_all_resources($arr_this_week['start'], $arr_this_week['end']);
}



?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php' ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default reports-summary-panel">
                    <form action="" method="get">
                        <div class="panel-heading">
                            <h4>Reports<?php if (isset($str_resource_name)) echo " - $str_resource_name"; ?></h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12 no-hr-padding">
                                <div class="col-md-2 no-hr-padding">
                                    <select name="report_timespan" class="form-control inline report-of">
                                        <option
                                            value="week" <?php if (isset($str_time_span) && $str_time_span == 'week') echo 'selected'; ?>>
                                            This Week
                                        </option>
                                        <option
                                            value="month" <?php if (isset($str_time_span) && $str_time_span == 'month') echo 'selected'; ?>>
                                            This Month
                                        </option>
                                        <option
                                            value="custom" <?php if (isset($str_time_span) && $str_time_span == 'custom') echo 'selected'; ?>>
                                            Custom
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <h6 class="search-dates"><?php echo $arr_dates['start'] . ' - ' . $arr_dates['end']; ?></h6>

                                    <div class="col-md-12 no-hr-padding search-date-fields">
                                        <div class="col-md-5 hr-padding-5">
                                            <div class="form-group">
                                                <div class="input-group date datetimepicker-date"
                                                     data-date-format="YYYY-MM-DD">
                                                    <input type="text" name="from" class="form-control start-date-field"
                                                           required="true"/>
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-time"></span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 hr-padding-5">
                                            <div class="form-group">
                                                <div class="input-group date datetimepicker-date"
                                                     data-date-format="YYYY-MM-DD">
                                                    <input type="text" name="to" class="form-control end-date-field"
                                                           required="true"/>
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-time"></span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 hr-padding-5">
                                            <button class="btn btn-default" type="submit">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </div>
                                        <div class="hidden start-date"><?php echo $arr_dates['start']; ?></div>
                                        <div class="hidden end-date"><?php echo $arr_dates['end']; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <?php
                                    if ($bln_is_admin) {
                                        ?>
                                        <div class="col-md-12 search-resource">
                                            <div class="input-group">
                                                <input id="autocomplete" name="resource_name" type="text"
                                                       class="form-control resource-name-field"
                                                       placeholder="Search here...">
                                                <input type="hidden" name="resource_id" class="resource-id-field"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default search-resource-submit" type="button">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                            </div>
                                            <div
                                                class="hidden resource-name"><?php if (isset($str_resource_name)) echo $str_resource_name; ?></div>
                                            <div
                                                class="hidden resource-id"><?php if (isset($int_resource_id)) echo $int_resource_id; ?></div>
                                        </div>
                                    <?php

                                    }
                                    ?>

                                </div>
                                <div class="col-md-2 text-right">
                                    <?php
                                    if ($bln_is_admin) {
                                        ?>
                                        <select name="resource_type" class="form-control inline resource_type">
                                            <option
                                                value="all" <?php if (isset($str_resource_type) && $str_resource_type == 'all') echo 'selected'; ?>>
                                                All Resources
                                            </option>
                                            <option
                                                value="human" <?php if (isset($str_resource_type) && $str_resource_type == 'human') echo 'selected'; ?>>
                                                Teachers
                                            </option>
                                            <option
                                                value="room" <?php if (isset($str_resource_type) && $str_resource_type == 'room') echo 'selected'; ?>>
                                                Rooms
                                            </option>
                                            <option
                                                value="miscellaneous" <?php if (isset($str_resource_type) && $str_resource_type == 'miscellaneous') echo 'selected'; ?>>
                                                Miscellaneous
                                            </option>
                                            <option
                                                value="vehicle" <?php if (isset($str_resource_type) && $str_resource_type == 'vehicle') echo 'selected'; ?>>
                                                Vehicle
                                            </option>
                                            <option
                                                value="custom" <?php if (isset($str_resource_type) && $str_resource_type == 'custom') echo 'selected'; ?>>
                                                Custom
                                            </option>
                                        </select>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <hr/>
                            <div class="col-md-12 mt30">
                                <?php
                                if ($bln_is_moderator) {
                                    if (isset($arr_booking_details)) {
                                        include 'partials/single_resource_utilization_graph.php';
                                    } else {
                                        include 'partials/all_resource_utilization_graph.php';
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-md-12 no-hr-padding mt100">
                                <?php
                                if ($bln_is_moderator) {
                                    if (isset($arr_booking_details) || $bln_is_resource) {
                                        include 'partials/single_resource_utilization_report.php';
                                    } else {
                                        include 'partials/all_resource_utilization_report.php';
                                    }
                                } else {
                                    include 'partials/single_resource_utilization_report.php';
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script>
        var report_of = $('.report-of');
        var search_dates = $('.search-dates');
        var search_date_fields = $('.search-date-fields');
        var start_date = $('.start-date').html();
        var end_date = $('.end-date').html();
        var resource_name = $('.resource-name').html();
        var resource_id = $('.resource-id').html();

        var resource_type = $('.resource_type');
        var search_resource = $('.search-resource');
        var search_resource_submit = $('.search-resource-submit');

        function show_custom_date_fields() {
            if (report_of.val() == 'custom') {
                search_dates.hide();
                search_date_fields.fadeIn();
                $('.start-date-field').val(start_date);
                $('.end-date-field').val(end_date);
            }
        }

        show_custom_date_fields();

        function show_custom_search_field() {
            if (resource_type.val() == 'custom') {
                search_resource.fadeIn();
                $('.resource-id-field').val(resource_id);
                $('.resource-name-field').val(resource_name);
            }
        }

        show_custom_search_field();

        report_of.change(function () {
            if (report_of.val() == 'custom') {
                search_dates.hide();
                search_date_fields.fadeIn();
                $('.start-date-field').val(start_date);
                $('.end-date-field').val(end_date);
            }
            else {
                search_date_fields.hide();
                search_dates.fadeIn();

                this.form.submit();

            }
        });

        resource_type.change(function () {

            if (resource_type.val() == 'custom') {
                search_resource.fadeIn();
            }
            else {
                this.form.submit();
            }
        });

        search_resource_submit.on('click', function () {
            this.form.submit();
        });


        $(function () {
            $('.datetimepicker-date').datetimepicker({
                useStrict: true,
                pickTime: false
            });
        });

        var resources = [
            <?php
            if(isset($arr_all_resources)) {
            foreach($arr_all_resources as $arr_single_resource) {
            echo "{ value: '" . $arr_single_resource['name'] . "', id: '" . $arr_single_resource['resource_id'] . "' },";
            }
            }
            ?>
        ];

        $('#autocomplete').autocomplete({
            lookup: resources,
            onSelect: function (suggestion) {
                // Callback to do something...
                $('.resource-id-field').val(suggestion.id);
                $('.resource-name-field').val(suggestion.value);
            }
        });

    </script>
<?php include 'partials/footer.php' ?>
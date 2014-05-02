<?php
#including our init.php
require 'core/init.php';
$obj_general->logged_out_protect();

# Get the resources list
$arr_resources = $obj_resources->get_resources();
$str_page = 'bookings';

if (empty($_POST) === false) {
    $int_booking_id = $obj_bookings->add_booking($arr_current_user['id'], $_POST);

    if ($int_booking_id) {
        # Show a success notification!
    }
}
?>


<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php' ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">

                </div>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

        <div class="row mt50">
            <div class="container">

                <?php
                echo '<ul class="resource-list list-unstyled list-inline col-md-12 mt30">';
                foreach ($arr_resources as $int_index => $arr_resource_details) {
                    if ($int_index % 4 == 0) {
                        echo '</ul>';
                        echo '<ul class="resource-list list-unstyled list-inline col-md-12 mt30">';
                    }

                    $str_name = $arr_resource_details['name'];
                    $str_description = ($arr_resource_details['type'] == 'human') ? $arr_resource_details['job_title'] : $arr_resource_details['type'];
                    echo '<a href="#" data-toggle="modal"
                                      data-target="#reserve_resource_modal"
                                      data-resource-id="' . $arr_resource_details['resource_id'] . '"
                                      data-resource-name="' . $str_name . '">

                        <li class="col-md-3">
                        <div class="col-md-12 single-resource">
                            <div class="col-md-3 no-hr-padding">
                                <img src="images/' . $arr_resource_details['photo'] . '" class="center-block" alt=""/>
                            </div>
                            <div class="col-md-9 hr-padding-5">
                                <h5>' . $str_name . '</h5>
                                <h6>' . $str_description . '</h6>
                            </div>
                        </div>
                        </li>
                      </a>';

                }
                echo '</ul>';
                ?>

                <div class="modal fade" id="reserve_resource_modal" tabindex="-1" role="dialog"
                     aria-labelledby="reserve_resource_modal_label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="" method="post">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="reserve_resource_modal_label">New Booking</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row no-hr-margin">
                                        <div class="col-md-4 text-right"><h5>Resource Name</h5></div>
                                        <div class="col-md-8">
                                            <h5 class="resource-name"></h5>
                                        </div>
                                    </div>
                                    <div class="row no-hr-margin">
                                        <div class="col-md-4 text-right"><h5>Date</h5></div>
                                        <div class="col-md-8 mt10">
                                            <div class="form-group">
                                                <div class="input-group date datetimepicker-date"
                                                     data-date-format="YYYY-MM-DD">
                                                    <input type="text" name="date" class="form-control" required="true"/>
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-time"></span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-hr-margin">
                                        <div class="col-md-4 text-right"><h5>Time</h5></div>
                                        <div class="col-md-8">
                                            <div class="col-md-6 no-hr-padding">
                                                <div class="form-group">
                                                    <div class="input-group date datetimepicker-time">
                                                        <input type="text" name="start_time"
                                                               class="form-control" placeholder="From" required="true"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 no-hr-padding">
                                                <div class="form-group">
                                                    <div class="input-group date datetimepicker-time">
                                                        <input type="text" name="end_time"
                                                               class="form-control" placeholder="To" required="true"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-hr-margin">
                                        <div class="col-md-4 text-right"><h5>Reason</h5></div>
                                        <div class="col-md-8">
                                            <textarea name="details" class="form-control"
                                                      rows="3" required="true"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <input type="hidden" name="resource_id" class="input-resource-id" value=""/>
                                    <input type="submit" class="btn btn-primary" value="Reserve"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->

    <script type="text/javascript">
        $(function () {
            $('.datetimepicker-date').datetimepicker({
                useStrict: false,
                pickTime: false
            });
            $('.datetimepicker-time').datetimepicker({
                pickDate: false,
                minuteStepping: 10
            });
        });


        $('a[data-toggle="modal"]').on('click', function () {
            $('.resource-name').html($(this).data('resource-name'));
            $('.input-resource-id').val($(this).data('resource-id'))
        });
    </script>
<?php include 'partials/footer.php' ?>
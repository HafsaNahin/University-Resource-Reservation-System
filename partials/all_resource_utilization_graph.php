<?php
if (isset($arr_resources_utilization_stats)) {


    ?>
    <div class="col-md-4">
        <div class="col-md-12 no-hr-padding large-progress-bar">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar"
                     aria-valuenow="<?php echo $arr_resources_utilization_stats['utilization_percentage']; ?>"
                     aria-valuemin="0" aria-valuemax="100"
                     style="width: <?php echo $arr_resources_utilization_stats['utilization_percentage']; ?>%">
                                            <span
                                                class="sr-only"><?php echo $arr_resources_utilization_stats['utilization_percentage']; ?>
                                                % Utilization</span>
                </div>
            </div>
        </div>
        <div class="col-md-12 no-hr-padding text-center">
            <h2 class="mb0"><?php echo $arr_resources_utilization_stats['utilization_percentage']; ?>
                %</h2>
            <span class="utilization text-muted">Utilization</span>
        </div>
    </div>
    <div class="col-md-4 booked-hours">
        <div class="col-md-12 no-hr-padding">
            <div class="col-md-6 no-hr-padding booked">
                <h5><?php echo $arr_resources_utilization_stats['total_booked_hours']; ?>h</h5>
                <h6 class="text-muted">BOOKED</h6>
            </div>
            <div class="col-md-6 no-hr-padding not-booked">
                <h5><?php echo $arr_resources_utilization_stats['total_not_booked_hours']; ?>
                    h</h5>
                <h6 class="text-muted">NOT BOOKED</h6>
            </div>
        </div>
        <div class="col-md-12 no-hr-padding total-availability">
            <h5><?php echo $arr_resources_utilization_stats['total_bookable_hours']; ?>h</h5>
            <h6 class="text-muted">TOTAL AVAILABILITY</h6>
        </div>
    </div>
    <div class="col-md-4"></div>


<?php
}
?>

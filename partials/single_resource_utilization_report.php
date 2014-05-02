<?php
if (isset($arr_resources_list)) {

//echo '<pre>';
//    print_r($arr_resources_list);
//    exit();
    ?>

    <table class="table">
        <thead>
        <tr>
            <th>Date</th>
            <th>Booked</th>
            <th>Not Booked</th>
            <th>Total Availability</th>
            <th>Utilization</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($arr_resources_list as $str_date => $arr_resource) {

            $int_not_booked = $arr_resource['bookable_hours'] - $arr_resource['booked_hours'];
            $int_utilization_percent = round(($arr_resource['booked_hours'] * 100) / $arr_resource['bookable_hours'], 0);

            if($arr_resource['booked_hours'] == null) $arr_resource['booked_hours'] = 0;


            echo '<tr>
            <td>' . $str_date . '</td>
            <td>' . $arr_resource['booked_hours'] . 'h</td>
            <td>' . $int_not_booked . 'h</td>
            <td>' . $arr_resource['bookable_hours'] . 'h</td>
            <td>
                <div class="col-md-9 no-hr-padding">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' . $int_utilization_percent . '"
                             aria-valuemin="0"
                             aria-valuemax="100" style="width: ' . $int_utilization_percent . '%">
                            <span class="sr-only">' . $int_utilization_percent . '% Utilization</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 hr-padding-5">
                    <p>' . $int_utilization_percent . '%</p>
                </div>
            </td>
        </tr>';

        }

        ?>
        </tbody>
    </table>

<?php
}
?>

<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 5/1/14
 * Time: 4:34 PM
 */

$arr_appointments = !empty($arr_appointments) ? $arr_appointments : [];

if(!empty($arr_appointments)) {
    echo '<table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Appointment With</th>
                <th>From</th>
                <th>To</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>';

    foreach($arr_appointments as $arr_appointment) {

        $booking_id = $arr_appointment['id'];
        $resource_name = $arr_appointment['name'];
        $date = $arr_appointment['date'];
        $start_time = $arr_appointment['start_time'];
        $end_time = $arr_appointment['end_time'];
        $details = $arr_appointment['details'];
        $booker_name = $arr_appointment['first_name'] . ' ' . $arr_appointment['last_name'];
        $booking_status = $arr_appointment['booking_status'];
        $str_approved = 'approved';
        $str_rejected = 'rejected';

        echo '<tr>
            <td>' . $date . '</td>
            <td>' . $resource_name . '</td>
            <td>' . $start_time . '</td>
            <td>' . $end_time . '</td>
            <td>' . $details . '</td>
          </tr>';
    }
    echo '</tbody></table>';
}
else {
    echo 'No more bookings...';
}
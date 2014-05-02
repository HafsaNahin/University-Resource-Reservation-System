<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/25/14
 * Time: 11:41 PM
 */

$arr_bookings = !empty($arr_bookings) ? $arr_bookings : [];

if(!empty($arr_bookings)) {
    echo '<table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Resource Name</th>
                <th>From</th>
                <th>To</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>';

    foreach($arr_bookings as $arr_booking) {

        $booking_id = $arr_booking['id'];
        $resource_name = $arr_booking['name'];
        $date = $arr_booking['date'];
        $start_time = $arr_booking['start_time'];
        $end_time = $arr_booking['end_time'];
        $details = $arr_booking['details'];
        $booker_name = $arr_booking['first_name'] . ' ' . $arr_booking['last_name'];
        $booking_status = $arr_booking['booking_status'];
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
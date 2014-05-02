<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/25/14
 * Time: 1:42 AM
 */

$arr_bookings = !empty($arr_bookings) ? $arr_bookings : [];

if(!empty($arr_bookings)) {
    echo '<table class="table">
        <thead>
            <tr>
                <th>Resource Name</th>
                <th>Date</th>
                <th>From</th>
                <th>To</th>
                <th>Details</th>
                <th>Booker Name</th>
                <th>Status</th>
                <th>Perform</th>
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
            <td>' . $resource_name . '</td>
            <td>' . $date . '</td>
            <td>' . $start_time . '</td>
            <td>' . $end_time . '</td>
            <td>' . $details . '</td>
            <td>' . $booker_name . '</td>
            <td>' . ucwords($booking_status) . '</td>
            <td>
                <a href="?booking_status=' . $str_approved . '&booking_id=' . $booking_id . '"><button type="button" class="btn btn-success">Approve</button></a>
                <a href="?booking_status=' . $str_rejected . '&booking_id=' . $booking_id . '"><button type="button" class="btn btn-danger">Reject</button></a>
            </td>
          </tr>';
    }
    echo '</tbody></table>';
}
else {
    echo 'No pending request...';
}
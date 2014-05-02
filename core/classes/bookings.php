<?php

/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/25/14
 * Time: 12:45 AM
 */
class Bookings
{
    private $obj_db;

    public function __construct($obj_database)
    {
        $this->obj_db = $obj_database;
    }

    public function add_booking($int_current_user_id, $arr_params)
    {
        $int_end_time = strtotime($arr_params['end_time']);
        $int_start_time = strtotime($arr_params['start_time']);
        $flt_total_hours = round(abs($int_end_time - $int_start_time) / 3600,1);

        $obj_query = $this->obj_db->prepare("INSERT INTO bookings (resource_id, date, start_time, end_time, details, booker_id, total_hours) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $obj_query->bindValue(1, (isset($arr_params['resource_id'])) ? $arr_params['resource_id'] : '');
        $obj_query->bindValue(2, (isset($arr_params['date'])) ? $arr_params['date'] : '');
        $obj_query->bindValue(3, (isset($arr_params['start_time'])) ? $arr_params['start_time'] : '');
        $obj_query->bindValue(4, (isset($arr_params['end_time'])) ? $arr_params['end_time'] : '');
        $obj_query->bindValue(5, (isset($arr_params['details'])) ? $arr_params['details'] : '');
        $obj_query->bindValue(6, (isset($int_current_user_id)) ? $int_current_user_id : '');
        $obj_query->bindValue(7, (isset($flt_total_hours)) ? $flt_total_hours : '');

        try {
            if ($obj_query->execute()) {
                # Do Something...
                # Return Booking ID
                return $this->obj_db->lastInsertId();
            } else {
                return 0;
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function get_all_bookings($str_booking_status)
    {
        # Preparing a statement that will select all the bookings, in Ascending order based on date.
        $obj_query = $this->obj_db->prepare("SELECT A.id, A.resource_id, A.date, A.start_time, A.end_time,
                                             A.details, A.booker_id, A.booking_status, B.first_name, B.last_name, C.name
                                             FROM bookings as A
                                             INNER JOIN users as B ON A.booker_id = B.id
                                             INNER JOIN resource_details as C ON A.resource_id = C.resource_id
                                             WHERE booking_status = ?
                                             ORDER BY A.date ASC");

        $obj_query->bindValue(1, $str_booking_status);

        try {
            $obj_query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $obj_query->fetchAll();
    }

    public function get_user_appointments($int_resource_id, $str_booking_status)
    {
        # Preparing a statement that will select all the appointments, in Ascending order based on date.
        $obj_query = $this->obj_db->prepare("SELECT A.id, A.resource_id, A.date, A.start_time, A.end_time,
                                             A.details, A.booker_id, A.booking_status, B.first_name, B.last_name
                                             FROM bookings as A
                                             INNER JOIN users as B ON A.booker_id = B.id
                                             WHERE A.resource_id = ? AND
                                             booking_status = ?
                                             ORDER BY A.date ASC");

        $obj_query->bindValue(1, $int_resource_id);
        $obj_query->bindValue(2, $str_booking_status);

        try {
            $obj_query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $obj_query->fetchAll();
    }

    public function get_user_booking($int_user_id, $str_booking_status, $str_booking_time_category)
    {

        if ($str_booking_time_category == 'previous') {
            $str_comparator = '<';
        } else if ($str_booking_time_category == 'upcoming') {
            $str_comparator = '>';
        } else {
            $str_comparator = '=';
        }

        # Preparing a statement that will select all the bookings, in Ascending order based on date.
        $obj_query = $this->obj_db->prepare("SELECT A.id, A.resource_id, A.date, A.start_time, A.end_time,
                                             A.details, A.booker_id, A.booking_status, B.first_name, B.last_name, C.name
                                             FROM bookings as A
                                             INNER JOIN users as B ON A.booker_id = B.id
                                             INNER JOIN resource_details as C ON A.resource_id = C.resource_id
                                             WHERE A.booking_status = ?
                                             AND A.booker_id = ?
                                             AND A.date $str_comparator '" . date('Y-m-d') . "'
                                             ORDER BY A.date ASC");

        $obj_query->bindValue(1, $str_booking_status);
        $obj_query->bindValue(2, $int_user_id);

        try {
            $obj_query->execute();

        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $obj_query->fetchAll();
    }


    public function change_booking_status($arr_params)
    {
        $int_booking_id = $arr_params['booking_id'];
        $str_booking_status = $arr_params['booking_status'];

        # Preparing a statement that will update status to approved of a particular booking.
        $obj_query = $this->obj_db->prepare("UPDATE bookings
                                             SET booking_status = ?
                                             WHERE id = ?");

        $obj_query->bindValue(1, $str_booking_status);
        $obj_query->bindValue(2, $int_booking_id);

        try {
            if ($obj_query->execute())
                return true;
            else return false;

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

} 
<?php

/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/19/14
 * Time: 10:12 PM
 */
class Resources
{
    private $obj_db;

    public function __construct($obj_database)
    {
        $this->obj_db = $obj_database;
    }

    public function add_resource($arr_params)
    {
        $str_time = date('Y-m-d h:i:s');
        $int_availability_id = 1;

        if ($arr_params['type'] == 'human') {
            $arr_params['name'] = $arr_params['first_name'] . ' ' . $arr_params['last_name'];
        }


        $obj_query = $this->obj_db->prepare("INSERT INTO resources (type, availability_id, bookable, time) VALUES (?, ?, ?, ?)");

        $obj_query->bindValue(1, (isset($arr_params['type'])) ? $arr_params['type'] : '');
        $obj_query->bindValue(2, (isset($int_availability_id)) ? $int_availability_id : '');
        $obj_query->bindValue(3, (isset($arr_params['bookable'])) ? 1 : 0);
        $obj_query->bindValue(4, (isset($str_time)) ? $str_time : '');

        try {
            if ($obj_query->execute()) {
                // Do Something...
                $int_resource_id = $this->obj_db->lastInsertId();

                # Add Resource Details
                $this->add_resource_details($int_resource_id, $arr_params);
                $this->bind_resource_with_user($arr_params['email']);
            } else {
                return $obj_query->errorCode();
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function add_resource_details($int_resource_id, $arr_params)
    {

        $obj_query = $this->obj_db->prepare("INSERT INTO resource_details (resource_id, name, first_name, last_name, job_title, photo, email, contact_number, note, capacity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


        $obj_query->bindValue(1, (isset($int_resource_id)) ? $int_resource_id : '');
        $obj_query->bindValue(2, (isset($arr_params['name'])) ? $arr_params['name'] : '');
        $obj_query->bindValue(3, (isset($arr_params['first_name'])) ? $arr_params['first_name'] : '');
        $obj_query->bindValue(4, (isset($arr_params['last_name'])) ? $arr_params['last_name'] : '');
        $obj_query->bindValue(5, (isset($arr_params['job_title'])) ? $arr_params['job_title'] : '');
        $obj_query->bindValue(6, (isset($arr_params['photo'])) ? $arr_params['photo'] : 'no-photo.png');
        $obj_query->bindValue(7, (isset($arr_params['email'])) ? $arr_params['email'] : '');
        $obj_query->bindValue(8, (isset($arr_params['contact_number'])) ? $arr_params['contact_number'] : '');
        $obj_query->bindValue(9, (isset($arr_params['note'])) ? $arr_params['note'] : '');
        $obj_query->bindValue(10, (isset($arr_params['capacity'])) ? $arr_params['capacity'] : '');

        try {
            if ($obj_query->execute()) {
                # Do Something...
            } else {
                return $obj_query->errorCode();
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function bind_resource_with_user($str_email)
    {

        $obj_query = $this->obj_db->prepare("SELECT * FROM resources as a INNER JOIN resource_details as b ON a.id = b.resource_id ORDER BY name ASC");

        try {
            $obj_query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function get_resources()
    {
        # Preparing a statement that will select all the resources, in Ascending order.
        $obj_query = $this->obj_db->prepare("SELECT * FROM resources as a INNER JOIN resource_details as b ON a.id = b.resource_id ORDER BY name ASC");

        try {
            $obj_query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $obj_query->fetchAll();
    }

    public function get_resources_by_type($str_resource_type)
    {
        # Preparing a statement that will select all the resources, in Ascending order.
        $obj_query = $this->obj_db->prepare("SELECT * FROM resources as a
                                             INNER JOIN resource_details as b
                                             ON a.id = b.resource_id
                                             WHERE a.type = ?
                                             ORDER BY name ASC");

        $obj_query->bindValue(1, $str_resource_type);

        try {
            $obj_query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $obj_query->fetchAll();
    }


    public function get_booking_details_of_all_resources($str_date_from, $str_date_to)
    {
        $arr_with_booked_and_bookable_hours = array();

        $arr_all_resources = $this->get_resources();

        foreach ($arr_all_resources as $index => $arr_resource) {
            $arr_bookable_hours['bookable_hours'] = $this->get_resource_bookable_hours($arr_resource['resource_id'], $str_date_from, $str_date_to);
            $arr_booked_hours['booked_hours'] = $this->get_resource_booked_hours($arr_resource['resource_id'], $str_date_from, $str_date_to);

            $arr_with_booked_and_bookable_hours[$index] = array_merge((array)$arr_resource, (array)$arr_bookable_hours, (array)$arr_booked_hours['booked_hours']);
        }

        return $arr_with_booked_and_bookable_hours;

//        echo '<pre>';
//        print_r($arr_with_booked_and_bookable_hours);
//        exit();

    }

    public function get_booking_details_single_resource($int_resource_id, $str_date_from, $str_date_to)
    {
        $arr_booking_details = array();

        $date = $str_date_from;

        while ($date != date("Y-m-d", strtotime("+1 day", strtotime($str_date_to)))) {
            $arr_booking_details[$date]['bookable_hours'] = $this->get_resource_bookable_hours($int_resource_id, $date, $date);
            $arr_booking_details[$date]['booked_hours'] = array_shift($this->get_resource_booked_hours($int_resource_id, $date, $date));
            $arr_booking_details[$date]['not_booked_hours'] = $arr_booking_details[$date]['bookable_hours'] - $arr_booking_details[$date]['booked_hours'];
            $arr_booking_details[$date]['utilization_percentage'] = $this->utilization_percentage($arr_booking_details[$date]['bookable_hours'], $arr_booking_details[$date]['booked_hours']);
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

        }
        return $arr_booking_details;
    }

    public function utilization_percentage($int_bookable_hours, $int_booked_hours = 0)
    {
        $int_utilization_percentage = round(($int_booked_hours * 100) / $int_bookable_hours, 0);
        return $int_utilization_percentage;

    }


    public function get_booking_details_resource_type($str_resource_type, $str_date_from, $str_date_to)
    {
        $arr_with_booked_and_bookable_hours = array();

        $arr_all_resources = $this->get_resources_by_type($str_resource_type);

        foreach ($arr_all_resources as $index => $arr_resource) {
            $arr_bookable_hours['bookable_hours'] = $this->get_resource_bookable_hours($arr_resource['resource_id'], $str_date_from, $str_date_to);
            $arr_booked_hours['booked_hours'] = $this->get_resource_booked_hours($arr_resource['resource_id'], $str_date_from, $str_date_to);

            $arr_with_booked_and_bookable_hours[$index] = array_merge((array)$arr_resource, (array)$arr_bookable_hours, (array)$arr_booked_hours['booked_hours']);
        }

        return $arr_with_booked_and_bookable_hours;
    }


    public function resources_utilization_stats($arr_resources_list)
    {
        $arr_resources_utilization_stats['total_booked_hours'] = 0;
        $arr_resources_utilization_stats['total_bookable_hours'] = 0;

        foreach ($arr_resources_list as $arr_resource) {
            $arr_resources_utilization_stats['total_booked_hours'] += $arr_resource['booked_hours'];
            $arr_resources_utilization_stats['total_bookable_hours'] += $arr_resource['bookable_hours'];
        }

        $arr_resources_utilization_stats['total_not_booked_hours'] = $arr_resources_utilization_stats['total_bookable_hours'] - $arr_resources_utilization_stats['total_booked_hours'];
        $arr_resources_utilization_stats['utilization_percentage'] = round(($arr_resources_utilization_stats['total_booked_hours'] * 100) / $arr_resources_utilization_stats['total_bookable_hours'], 0);


        return $arr_resources_utilization_stats;
    }

    public function get_resource_bookable_hours($int_resource_id, $str_date_from, $str_date_to)
    {
        $int_default_bookable_hour_per_day = 9;

        if (strtotime($str_date_from) > strtotime($str_date_to))
            return 0;

        $obj_datetime_from = new DateTime($str_date_from);
        $obj_datetime_to = new DateTime($str_date_to);
        $interval = $obj_datetime_from->diff($obj_datetime_to);

        $int_total_day = $interval->days;
        $int_total_bookable_hours = ($int_total_day + 1) * $int_default_bookable_hour_per_day;

        return $int_total_bookable_hours;
    }

    public function get_resource_booked_hours($int_resource_id, $str_date_from, $str_date_to)
    {

        $obj_query = $this->obj_db->prepare("SELECT SUM(total_hours) as booked_hours
                                             FROM bookings
                                             WHERE resource_id = ?
                                             AND booking_status = ?
                                             AND date BETWEEN ? AND ?");
        $obj_query->bindValue(1, $int_resource_id);
        $obj_query->bindValue(2, 'approved');
        $obj_query->bindValue(3, $str_date_from);
        $obj_query->bindValue(4, $str_date_to);

        try {
            if ($obj_query->execute()) {
                # Do Something...
            } else {
                return $obj_query->errorCode();
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $obj_query->fetch();
    }
}
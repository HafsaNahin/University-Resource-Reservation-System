<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/19/14
 * Time: 9:55 AM
 */
#namespace classes;


class General
{
    #Check if the user is logged in.
    public function logged_in()
    {
        return (isset($_SESSION['id'])) ? true : false;
    }

    #if logged in then redirect to home.php
    public function logged_in_protect()
    {
        if ($this->logged_in() === true) {
            header('Location: dashboard.php');
            exit();
        }
    }

    #if not logged in then redirect to index.php
    public function logged_out_protect()
    {
        if ($this->logged_in() === false) {
            header('Location: login.php');
            exit();
        }
    }

    public function is_admin($arr_user)
    {
        # TODO: Find a better solution
        if ($arr_user['category_id'] == 1)
            return true;
        else
            return false;
    }

    public function is_moderator($arr_user)
    {
        # TODO: Find a better solution
        if ($arr_user['category_id'] == 1 || $arr_user['category_id'] == 2)
            return true;
        else
            return false;
    }

    public function is_resource($arr_user)
    {
        # TODO: Find a better solution
        if ( $arr_user['category_id'] == 2)
            return true;
        else
            return false;
    }

    public function this_week_start_and_end_dates($str_week_start_day = 'sunday', $str_week_end_day = 'thursday')
    {
        $str_week_start_day = 'last ' . $str_week_start_day;
        $str_week_end_day = 'next ' . $str_week_end_day;

        $str_week_start_date = date('d M Y', strtotime($str_week_start_day));
        $str_week_end_date = date('d M Y', strtotime($str_week_end_day));

        return $str_week_start_date . ' - ' . $str_week_end_date;
    }

    public function get_week_dates($str_start_day = 'sunday', $str_end_day = 'thursday')
    {
        $arr_days = array(
            'sunday' => 0,
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6
        );

        $int_start_day_value = $arr_days[$str_start_day];
        $int_end_day_value = $arr_days[$str_end_day];

        $date = "2014-05-01";
        $week = date('W', strtotime($date));
        $year = date('Y', strtotime($date));

        $arr_dates['start'] = date("Y-m-d", strtotime("{$year}-W{$week}-$int_start_day_value"));
        $arr_dates['end'] = date("Y-m-d", strtotime("{$year}-W{$week}-$int_end_day_value")); //Returns the date of sunday in week

        return $arr_dates;
        #echo "Start Date-->".$from."End Date -->".$to;//Output : Start Date-->2012-09-03 End Date-->2012-09-09
    }

    public function get_month_dates()
    {
        $arr_this_month['start'] = date('Y-m-01'); // hard-coded '01' for first day
        $arr_this_month['end'] = date('Y-m-t');

        return $arr_this_month;
    }

//    public function get_quarter_dates()
//    {
//        $arr_this_quarter = array();
//        $current_month = date('m');
//        $current_year = date('Y');
//
//        if ($current_month >= 1 && $current_month <= 3) {
//            $arr_this_quarter['start'] = strtotime('1-January-' . $current_year); // timestamp or 1-Janauray 12:00:00 AM
//            $arr_this_quarter['end'] = strtotime('1-April-' . $current_year); // timestamp or 1-April 12:00:00 AM means end of 31 March
//        } else if ($current_month >= 4 && $current_month <= 6) {
//            $arr_this_quarter['start'] = strtotime('1-April-' . $current_year); // timestamp or 1-April 12:00:00 AM
//            $arr_this_quarter['end'] = strtotime('1-July-' . $current_year); // timestamp or 1-July 12:00:00 AM means end of 30 June
//        } else if ($current_month >= 7 && $current_month <= 9) {
//            $arr_this_quarter['start'] = strtotime('1-July-' . $current_year); // timestamp or 1-July 12:00:00 AM
//            $arr_this_quarter['end'] = strtotime('1-October-' . $current_year); // timestamp or 1-October 12:00:00 AM means end of 30 September
//        } else if ($current_month >= 10 && $current_month <= 12) {
//            $arr_this_quarter['start'] = strtotime('1-October-' . $current_year); // timestamp or 1-October 12:00:00 AM
//            $arr_this_quarter['end'] = strtotime('1-Janauary-' . ($current_year + 1)); // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
//        }
//
//        return $arr_this_quarter;
//    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/19/14
 * Time: 10:08 AM
 */

#starting the users session
session_start();

# date_default_timezone_set('Asia/Dhaka');

ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

require 'connect/database.php';
require 'classes/users.php';
require 'classes/general.php';
require 'classes/resources.php';
require 'classes/bookings.php';
require 'classes/reports.php';

$obj_users = new Users($obj_db);
$obj_general = new General();
$obj_resources = new Resources($obj_db);
$obj_bookings = new Bookings($obj_db);
$obj_reports = new Reports($obj_db);

$arr_errors = array();
$str_time = date('Y-m-d h:i:s');

if ($obj_general->logged_in()) {
    $arr_current_user = $obj_users->get_current_user();
}

<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/19/14
 * Time: 9:56 AM
 */

# We are storing the information in this config array that will be required to connect to the database.
$arr_config = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname' => 'rrs_primary'
);

#connecting to the database by supplying required parameters
$obj_db = new PDO('mysql:host=' . $arr_config['host'] . ';dbname=' . $arr_config['dbname'], $arr_config['username'], $arr_config['password']);

#Setting the error mode of our db object, which is very important for debugging.
$obj_db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
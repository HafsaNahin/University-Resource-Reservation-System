<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/19/14
 * Time: 6:27 PM
 */

session_start();
session_destroy();
header('Location: login.php');
<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/19/14
 * Time: 11:08 AM
 */

require 'core/init.php';
$obj_general->logged_in_protect();

if (isset($_GET['success']) === true && empty ($_GET['success']) === true) {

    echo "<h3>Thank you, we've activated your account. You're free to log in!</h3>";

} else if (isset ($_GET['email'], $_GET['email_code']) === true) {
    $str_email = trim($_GET['email']);
    $str_email_code = trim($_GET['email_code']);

    if ($obj_users->email_exists($str_email) === false) {
        $str_errors[] = 'Sorry, we couldn\'t find that email address.';
    } else if ($obj_users->activate($str_email, $str_email_code) === false) {
        $str_errors[] = 'Sorry, we couldn\'t activate your account.';
    }
    if (empty($str_errors) === false) {
        echo '<p>' . implode('</p><p>', $str_errors) . '</p>';
    } else {
        header('Location: activate.php?success');
        exit();
    }
} else {
    header('Location: dashboard.php');
    exit();
}
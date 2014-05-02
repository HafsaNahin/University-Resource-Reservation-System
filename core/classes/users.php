<?php
/**
 * Created by PhpStorm.
 * User: Hafsa Nahin
 * Date: 4/19/14
 * Time: 9:56 AM
 */
#namespace classes;


class Users
{

    private $obj_db;

    public function __construct($obj_database)
    {
        $this->obj_db = $obj_database;
    }

    public function email_exists($str_email)
    {

        $obj_query = $this->obj_db->prepare("SELECT COUNT(id) FROM users WHERE email= ?");
        $obj_query->bindValue(1, $str_email);

        try {

            $obj_query->execute();
            $rows = $obj_query->fetchColumn();

            if ($rows == 1) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    public function register($str_first_name, $str_last_name, $str_password, $str_email)
    {
        $str_time = date('Y-m-d h:i:s');
        $str_ip = $_SERVER['REMOTE_ADDR'];
        $str_email_code = sha1($str_email + microtime());
        $str_password = md5($str_password);

        $obj_query = $this->obj_db->prepare("INSERT INTO users (first_name, last_name, password, email, ip, time, email_code, confirmed) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");

        $obj_query->bindValue(1, $str_first_name);
        $obj_query->bindValue(2, $str_last_name);
        $obj_query->bindValue(3, $str_password);
        $obj_query->bindValue(4, $str_email);
        $obj_query->bindValue(5, $str_ip);
        $obj_query->bindValue(6, $str_time);
        $obj_query->bindValue(7, $str_email_code);
        $obj_query->bindValue(8, 1);

        try {
            $obj_query->execute();
            #mail($str_email, 'Please activate your account', "Hello " . $username. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.example.com/activate.php?email=" . $str_email . "&email_code=" . $str_email_code . "\r\n\r\n-- Example team");
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function activate($str_email, $str_email_code)
    {
        $obj_query = $this->obj_db->prepare("SELECT COUNT(id) FROM users WHERE email = ? AND email_code = ? AND confirmed = ?");

        $obj_query->bindValue(1, $str_email);
        $obj_query->bindValue(2, $str_email_code);
        $obj_query->bindValue(3, 0);

        try {

            $obj_query->execute();
            $int_rows = $obj_query->fetchColumn();

            if ($int_rows == 1) {
                $obj_query_2 = $this->obj_db->prepare("UPDATE users SET confirmed = ? WHERE email = ?");

                $obj_query_2->bindValue(1, 1);
                $obj_query_2->bindValue(2, $str_email);

                $obj_query_2->execute();
                return true;

            } else {
                return false;
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function login($str_email, $str_password)
    {

        $obj_query = $this->obj_db->prepare("SELECT password, id FROM users WHERE email = ?");
        $obj_query->bindValue(1, $str_email);

        try {
            $obj_query->execute();
            $arr_data = $obj_query->fetch();
            $str_stored_password = $arr_data['password'];
            $int_id = $arr_data['id'];

            #hashing the supplied password and comparing it with the stored hashed password.
            if ($str_stored_password === md5($str_password)) {
                return $int_id;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function get_current_user()
    {
        $arr_current_user = $this->userdata($_SESSION['id']);
        return $arr_current_user;
    }

    public function email_confirmed($str_email)
    {

        $obj_query = $this->obj_db->prepare("SELECT COUNT(id) FROM users WHERE email= ? AND confirmed = ?");
        $obj_query->bindValue(1, $str_email);
        $obj_query->bindValue(2, 1);
        try {
            $obj_query->execute();
            $int_rows = $obj_query->fetchColumn();

            if ($int_rows == 1) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    public function userdata($int_id)
    {

        $obj_query = $this->obj_db->prepare("SELECT * FROM users WHERE id= ?");
        $obj_query->bindValue(1, $int_id);

        try {
            $obj_query->execute();
            return $obj_query->fetch();

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function get_users()
    {

        #preparing a statement that will select all the registered users, with the most recent ones first.
        $obj_query = $this->obj_db->prepare("SELECT * FROM users ORDER BY time DESC");
        try {
            $obj_query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        # We use fetchAll() instead of fetch() to get an array of all the selected records.
        return $obj_query->fetchAll();
    }
} 
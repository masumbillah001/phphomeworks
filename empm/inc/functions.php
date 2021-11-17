<?php
/**
 * All functions here
 */


if (!function_exists('empm_get_var')) {
    /**
     * Return var from anywhere
     *
     * @param $key
     * @param $args
     *
     * @return mixed|string
     */
    function empm_get_var($key, $args = array())
    {

        if (empty($args)) {
            $args = $_SESSION;
        }

        return isset($args[$key]) ? $args[$key] : '';
    }
}

if (!function_exists('empm_user_registration')) {
    /**
     * Register user and return user_id, return error when an error occurs
     *
     * @param $un
     * @param $email
     * @param $pw
     * @return mixed
     */
    function empm_user_registration($un, $email, $pw)
    {
        $conn = empm_get_var('conn');
        $table = empm_get_var('db_tbl_users');
        $password = md5($pw);
        $sql = "INSERT INTO $table (user_name, email_address, password) VALUES ('$un', '$email', '$password')";

        if (!$conn->query($sql)) {
            return $conn->error;
        }

        return $conn->insert_id;
    }
}

if (!function_exists('empm_check_user_login')) {
    /**
     * Check username and password to login a user. Return false if no user found with the given information.
     *
     * @param $un
     * @param $pw
     * @return false|mixed
     */
    function empm_check_user_login($un, $pw)
    {
        $pw = md5($pw);
        $conn = empm_get_var('conn');
        $table = empm_get_var('db_tbl_users');
        $sql = "SELECT (id) FROM $table WHERE `user_name` = '$un' AND `password` = '$pw' LIMIT 1";

        if (!$result = $conn->query($sql)) {
            return false;
        }

        $user_data = $result->fetch_assoc();

        if (is_array($user_data) && isset($user_data['id'])) {
            return $user_data['id'];
        }

        return false;
    }
}

if (!function_exists('empm_current_user_id')) {
    /**
     * If any user logged in then return that user ID, if no return false
     *
     * @return mixed|string
     */
    function empm_current_user_id()
    {
        return empm_get_var('user_logged_in', $_COOKIE);
    }
}
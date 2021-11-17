<?php
/**
 * Database Connection
 */

session_start();

$db_name = 'empm_db';
$db_tbl_users = 'empm_users';
$db_tbl_options = 'empm_options';

$_SESSION['db_tbl_users'] = $db_tbl_users;
$_SESSION['db_tbl_options'] = $db_tbl_options;


// Create connection
$conn = new mysqli('localhost', 'root', '');

$_SESSION['conn'] = $conn;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
if (!mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $db_name")) {
    die("Error creating database: " . mysqli_error($conn));
}

// Select Database
if (!mysqli_select_db($conn, $db_name)) {
    die("Error selecting database");
}

//Create users table
$sql_create_tbl_users = "CREATE TABLE IF NOT EXISTS $db_tbl_users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(255),
        last_name VARCHAR(255),
        user_name VARCHAR(255) UNIQUE NOT NULL,
        email_address VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        phone_number VARCHAR(255),
        designation VARCHAR(255),
        street_address VARCHAR(255),
        city VARCHAR(255),
        zipcode VARCHAR(255),
        country VARCHAR(255),
        gender VARCHAR(255),
        salary VARCHAR(255),
        religion VARCHAR(255),
        status VARCHAR(255),
        user_role VARCHAR(255),
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

if (!$conn->query($sql_create_tbl_users)) {
    die("Error creating table: " . $conn->error);
}

//Create options table
$sql_create_tbl_options = "CREATE TABLE IF NOT EXISTS $db_tbl_options (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        option_key VARCHAR(255) UNIQUE NOT NULL,
        option_value VARCHAR(255),
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

if (!$conn->query($sql_create_tbl_options)) {
    die("Error creating table: " . $conn->error);
}



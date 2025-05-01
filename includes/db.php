<?php
// includes/db.php

// 1) database credentials
$db_host     = 'localhost';     
$db_user     = 'user';
$db_password = 'password';
$db_name     = 'onlinemarketplace';

// 2) MySQLi connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// 3) Error checking
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// 4) Set charset
$conn->set_charset("utf8mb4");

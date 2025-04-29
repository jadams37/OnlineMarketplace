<?php
    $host = "localhost";
    $db = "onlinemarketplace";
    $username = "user";
    $password = "password";

    $mysqli = new mysqli($host, $username, $password, $db);

    if ($mysqli->connect_errno) {
        die("Connection error: " . $mysqli->connect_error);
    }

    return $mysqli;

?>
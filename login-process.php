<?php
    if(empty($_POST["username"])) {
        die("Username is required");
    }

    if(strlen($_POST["password"]) < 8) {
        die("Password must be at least 8 characters long");
    }

    if(!preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }

    if(!preg_match("/[0-9]/i", $_POST["password"])) {
        die("Password must contain at least one number");
    }

    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }

    $user = $_POST["username"];
    $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];
?>
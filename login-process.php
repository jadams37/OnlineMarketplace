<?php
    if(empty($_POST["username"])) {
        die("Username is required");
    }

    if(strlen($_POST["password"]) < 3) {
        die("Password must be at least 3 characters long");
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

    if(!preg_match("/^\d{3}-?\d{3}-?\d{4}$/", $_POST["phone"])) {
        die("Phone number must be valid");
    }

    if(empty($_POST["firstname"])) {
        die("First name is required");
    }

    if(empty($_POST["lastname"])) {
        die("Last name is required");
    }

    $user = $_POST["username"];
    $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];

    $mysqli = require __DIR__ . "\db-connection.php";

    $sql = "INSERT INTO user (user_name, user_password, user_email, user_address, user_phone, user_first_name, user_last_name, user_creation_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE())";

    $stmt = $mysqli->stmt_init();

    if(!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sssssss", $user, $pass, $email, $address, $phone, $fname, $lname);

    if($stmt->execute()) {
        header("Location: home.php");
        exit;
    }

    else {
        die($mysql->error . " " . $mysqli->errorno);
    }

?>
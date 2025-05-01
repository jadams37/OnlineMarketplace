<?php
session_start();
header('Content-Type: application/json');

// connect just in case
require_once 'db-connection.php';

// decoding raw json
$data = json_decode(file_get_contents("php://input"), true);

// making sure user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION["user_id"];

// data validation
if (!$data || !isset($data['name'], $data['email'], $data['location'], $data['phone'], $data['fname'], $data['lname'], $data['role'])) {
    echo json_encode(['success' => false, 'message' => 'Incomplete data']);
    exit;
}


$username = $data['name'];
$email = $data['email'];
$address = $data['location'];
$phone = $data['phone'];
$fname = $data['fname'];
$lname = $data['lname'];
$roleid = $data['role'];

$sql = "UPDATE user SET user_name = ?, user_email = ?, user_address = ?, user_phone = ?, user_first_name = ?, user_last_name = ?, user_role_id = ? WHERE user_id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $mysqli->error]);
    exit;
}

$stmt->bind_param("ssssssii", $username, $email, $address, $phone, $fname, $lname, $roleid, $user_id);

if ($stmt->execute()) {
    $_SESSION["user_role_id"] = $roleid;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
}
?>

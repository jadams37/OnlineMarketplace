<?php
// Start the session to access user data
session_start();
// database connection file
require __DIR__ . '/db-connection.php';

header('Content-Type: application/json');

// Ensure the user is logged in before allowing users add items to cart
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to add items to cart']);
    exit;
}

// Verify a product was provided in the POST request
if (!isset($_POST['listing_id'])) {
    echo json_encode(['success' => false, 'message' => 'No product specified']);
    exit;
}

$userId = $_SESSION['user_id'];
$listingId = (int)$_POST['listing_id'];

// Check if item already in cart
$stmt = $mysqli->prepare("SELECT quantity FROM cart WHERE user_id = ? AND listing_id = ?");
$stmt->bind_param("ii", $userId, $listingId);
$stmt->execute();
$result = $stmt->get_result();

// If the item exists, increase the quantity by 1
if ($result->num_rows > 0) {
    $stmt = $mysqli->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND listing_id = ?");
} else {
    // Add new item
    $stmt = $mysqli->prepare("INSERT INTO cart (user_id, listing_id, quantity) VALUES (?, ?, 1)");
}
// Prepare the statement
$stmt->bind_param("ii", $userId, $listingId);
$success = $stmt->execute();

if ($success) {
    echo json_encode(['success' => true]);
} else {
    // Handle database error
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
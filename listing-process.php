<!DOCTYPE html>
<?php
file_put_contents("debug.txt", file_get_contents("php://input"));
session_start();

$mysqli = require __DIR__ . "\db-connection.php";

// always check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No data received']);
    exit;
}

$required_fields = [
    'product_name', 'product_description', 'product_brand', 'price', 'product_condition', 'product_image',
    'quantity', 'keywords', 'category_id', 'status'
];

$missing_fields = [];
foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
        $missing_fields[] = $field;
    }
}

if (!empty($missing_fields)) {
    echo json_encode(['success' => false, 'message' => 'Missing fields: ' . implode(', ', $missing_fields)]);
    exit;
}

// making sure user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION["user_id"];

// data validation
if (!$data || !isset($data['product_name'], $data['product_description'], $data['product_brand'], $data['price'], $data['product_condition'], $data['product_image'],
 $data['quantity'], $data['keywords'], $data['category_id'], $data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Incomplete data']);
    exit;
}

$product_id = 0;
$user_id = $_SESSION["user_id"];
$listing_price = $data['price'];
$listing_quantity = $data['quantity'];
$listing_keywords = $data['keywords'];
$listing_status = $data['status'];
$listing_date = date('Y-m-d H:i:s');

// db updating
$category_id = $data['category_id'];
$product_name = $data['product_name'];
$product_brand = $data['product_brand'];
$product_description = $data['product_description'];
$product_image = $data['product_image'];
$product_condition = $data['product_condition'];

$sql = "INSERT INTO listing (listing_id, listing_date, product_id, user_id, listing_price, listing_quantity, listing_keywords, listing_status, listing_date)
        VALUES (?, CURDATE(), ?, ?, ?, ?, ?, ?, ?);
        INSERT INTO products (product_id, category_id, product_name, product_brand, product_description, product_image, product_condition)
        VALUES (?, ?, ?, ?, ?, ?, ?)";


$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
}


$stmt->bind_param(
    "iidisss", 
    $product_id, $user_id, $listing_price, $listing_quantity, $listing_keywords, $listing_status, $listing_date
);

if ($stmt->execute()) {
    // gets last product_id
    $product_id = $mysqli->insert_id;

    
    $stmt->bind_param(
        "isssss", 
        $category_id, $product_name, $product_brand, $product_description, $product_image, $product_condition
    );

    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Listing added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error inserting into products: ' . $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error inserting into listing: ' . $stmt->error]);
}

$stmt->close();
$mysqli->close();
?>


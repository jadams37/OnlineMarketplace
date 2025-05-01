<?php
//Start the users session
session_start();
// Connect to the database
require __DIR__ . '/db-connection.php';

// Redirect user to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get cart items
$stmt = $mysqli->prepare("
    SELECT l.listing_id, p.product_name, p.product_image, l.listing_price, c.quantity
    FROM cart c
    JOIN listing l ON c.listing_id = l.listing_id
    JOIN products p ON l.product_id = p.product_id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$cartItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate total cost of items in the cart
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['listing_price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>theMarket – Your Cart</title>
  <link rel="stylesheet" href="css/styleHome.css">
  <link rel="stylesheet" href="css/layout.css">
  <link rel="stylesheet" href="css/cart.css">
</head>
<body>
  <div class="main-wrapper">
    <header>
      <nav id="header">
        <div class="header-left">
          <a id="logo" href="home.php">theMarket</a>
        </div>
        <div class="header-center">
          <a href="home.php" class="home-link">Home</a>
          <a href="results.php" class="back-to-results">Back to Results</a>
        </div>
        <div class="header-right">
          <div class="profile-icon">
            <a href="profile.html">
              <img src="images/profile.png" alt="Profile" />
            </a>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <section class="cart-container">
        <h1>Your Shopping Cart</h1>
        
        <?php if (empty($cartItems)): ?>
          <!-- Alert shown if user cart is empty -->
          <p class="empty-cart">Your cart is empty</p>
        <?php else: ?>
          <!-- List all products in cart -->
          <div class="cart-items">
            <?php foreach ($cartItems as $item): ?>
              <div class="cart-item">
                <img src="images/<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                <div class="item-details">
                  <h3><?= htmlspecialchars($item['product_name']) ?></h3>
                  <p>Price: $<?= number_format($item['listing_price'], 2) ?></p>
                  <p>Quantity: <?= $item['quantity'] ?></p>
                </div>
              </div>
            <?php endforeach; ?>
             <!-- Show total cost and a checkout button -->
            <div class="cart-total">
              <h3>Total: $<?= number_format($total, 2) ?></h3>
              <button onclick="purchase()" class="checkout-btn">Proceed to Checkout</button>
            </div>
          </div>
        <?php endif; ?>
      </section>
    </main>
  </div>
<!-- Footer -->
  <footer>
    <nav id="footer">
      <a href="#">Customer Care</a>
      <a href="#">Legal Use</a>
      <a href="#">Careers</a>
      <a href="#">Follow Us</a>
    </nav>
    <div class="footer-copy">&copy; 2025, Interactive Web Designs</div>
  </footer>

  <script src="scripts/purchaseProduct.js"></script>
</body>
</html>
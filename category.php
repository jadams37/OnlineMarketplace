<?php
session_start();
require __DIR__ . '/includes/db.php';

// 1) Read & validate the category_id from the URL
$catId = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
if (!$catId) {
    header('Location: home.php');
    exit;
}

// 2) Fetch the category name
$stmt = $conn->prepare("SELECT name FROM categories WHERE category_id = ?");
$stmt->bind_param('i', $catId);
$stmt->execute();
$stmt->bind_result($catName);
if (!$stmt->fetch()) {
    // invalid ID
    $stmt->close();
    header('Location: home.php');
    exit;
}
$stmt->close();

// 3) Fetch all active listings in that category
$sql = "
  SELECT 
    l.listing_id, 
    p.product_name, 
    p.product_image, 
    l.listing_price
  FROM listing AS l
  JOIN products AS p ON l.product_id = p.product_id
  WHERE p.category_id = ? 
    AND l.listing_status = 'Active'
";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $catId);
$stmt->execute();
$res = $stmt->get_result();
$products = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>theMarket – <?= htmlspecialchars($catName) ?></title>
  <link href="css/layout.css" rel="stylesheet" type="text/css">
  <link href="css/styleHome.css" rel="stylesheet">
</head>
<body>

  <!-- Header / Nav -->
  <header>
    <nav id="header">
      <a id="logo" href="home.php">theMarket</a>
      <div class="nav-center">
        <a href="home.php" id="home">Home</a>
        <form action="" method="">
          <div class="search">
            <span class="search-icon material-symbols-outlined">search</span>
            <input class="search-input" type="search" placeholder="Search">
          </div>
        </form>
        <a href="cart.php" id="cart">Cart<?php
          // show cart count if any
          $count = 0;
          if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $qty) {
              $count += $qty;
            }
            echo "({$count})";
          }
        ?></a>
      </div>
      <?php if (isset($_SESSION["user_id"])): ?>
        <a href="profile.php" class="profile">
          <img src="images/profile.png" alt="Profile" id="profile">
        </a>
      <?php else: ?>
        <a href="login.php" class="profile">
          <img src="images/profile.png" alt="Profile" id="profile">
        </a>
      <?php endif; ?>
    </nav>
  </header>

  <!-- Main Content -->
  <main>
    <h1 style="text-align:center; margin:2rem 0;">
      Category: <?= htmlspecialchars($catName) ?>
    </h1>

    <div class="product-grid">
      <?php if (count($products) === 0): ?>
        <p style="text-align:center;">No products found in this category.</p>
      <?php else: ?>
        <?php foreach ($products as $prod): ?>
          <div class="product-card">
            <a href="product.php?listing_id=<?= $prod['listing_id'] ?>">
              <img src="images/<?= htmlspecialchars($prod['product_image']) ?>"
                   alt="<?= htmlspecialchars($prod['product_name']) ?>">
              <h3><?= htmlspecialchars($prod['product_name']) ?></h3>
              <p>$<?= number_format($prod['listing_price'], 2) ?></p>
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <nav id="footer">
      <a id="logo" href="home.php">theMarket</a>
      <div class="nav-center">
        <a href="">Customer Care</a>
        <a href="">Legal Use</a>
        <a href="">Careers</a>
        <a href="">Follow Us</a>
      </div>
      <div></div>
    </nav>
    <p id="copyright">&copy; 2025, Interactive Web Designs</p>
  </footer>

</body>
</html>

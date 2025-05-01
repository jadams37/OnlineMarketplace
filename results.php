<?php
// For debugging purpose
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// start the session to access user info 
session_start();
$mysqli = require __DIR__ . '/db-connection.php';

// These will determine how we filter products: by keyword, category, brand, or price.
$query = $_GET['query'] ?? '';
$selectedCats = isset($_GET['category']) ? (array)$_GET['category'] : [];
$selectedBrands = isset($_GET['brand']) ? (array)$_GET['brand'] : [];
$maxPrice = isset($_GET['price']) ? floatval($_GET['price']) : 0.0;

// Build query
$sql = "
  SELECT
    l.listing_id,
    p.product_id,
    p.category_id,
    c.name AS category_name,
    l.listing_price,
    p.product_name,
    p.product_brand,
    p.product_image
  FROM listing AS l
  JOIN products AS p ON l.product_id = p.product_id
  JOIN categories AS c ON p.category_id = c.category_id
  WHERE l.listing_status = 'Active'
";

$params = [];
$types = '';

// search by keyword, descripton, or listing
if (!empty($query)) {
    $sql .= " AND (p.product_name LIKE ? OR p.product_description LIKE ? OR l.listing_keywords LIKE ?)";
    $searchTerm = "%{$query}%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= 'sss';
}

// Category filter
if (!empty($selectedCats)) {
    $placeholders = implode(',', array_fill(0, count($selectedCats), '?'));
    $sql .= " AND p.category_id IN ($placeholders)";
    foreach ($selectedCats as $cat) {
        $params[] = (int)$cat;
        $types .= 'i';
    }
}

// Brand filter
if (!empty($selectedBrands)) {
    $placeholders = implode(',', array_fill(0, count($selectedBrands), '?'));
    $sql .= " AND p.product_brand IN ($placeholders)";
    foreach ($selectedBrands as $brand) {
        $params[] = $brand;
        $types .= 's';
    }
}

// Price filter
if ($maxPrice > 0) {
    $sql .= " AND l.listing_price <= ?";
    $params[] = $maxPrice;
    $types .= 'd';
}

// run query
$stmt = $mysqli->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get sidebar options
$categories = $mysqli->query("SELECT category_id, name FROM categories")->fetch_all(MYSQLI_ASSOC);
$brands = $mysqli->query("SELECT DISTINCT product_brand FROM products ORDER BY product_brand")->fetch_all(MYSQLI_ASSOC);

// Get cart count only if user is logged in
$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    $stmt = $mysqli->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartData = $result->fetch_assoc();
    $cartCount = $cartData['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>theMarket – Search Results</title>

  <link rel="stylesheet" href="css/styleHome.css">
  <link rel="stylesheet" href="css/layout.css">
  <link rel="stylesheet" href="css/results.css">
</head>
<body>
  <!-- sidebr filter -->
  <aside id="sidebar" aria-label="Filters">
    <form id="filter-form" method="get" action="results.php">
      <input type="hidden" name="query" value="<?= htmlspecialchars($query) ?>">
      
      <section>
        <h3>Category</h3>
        <?php foreach($categories as $cat): ?>
          <label>
            <input
              type="checkbox"
              name="category[]"
              value="<?= $cat['category_id'] ?>"
              <?= in_array($cat['category_id'], $selectedCats) ? 'checked' : '' ?>
            >
            <?= htmlspecialchars($cat['name']) ?>
          </label>
        <?php endforeach; ?>
      </section>

      <section>
        <h3>Brand</h3>
        <?php foreach($brands as $b): ?>
          <label>
            <input
              type="checkbox"
              name="brand[]"
              value="<?= htmlspecialchars($b['product_brand']) ?>"
              <?= in_array($b['product_brand'], $selectedBrands) ? 'checked' : '' ?>
            >
            <?= htmlspecialchars($b['product_brand']) ?>
          </label>
        <?php endforeach; ?>
      </section>

      <section>
        <h3>Max Price: <span id="price-value">$<?= $maxPrice ?: '0' ?></span></h3>
        <input
          type="range"
          name="price"
          id="price-range"
          min="0"
          max="500"
          step="1"
          value="<?= $maxPrice ?>"
        >
      </section>

      <button type="submit">Apply Filters</button>
    </form>
  </aside>

  <div class="main-wrapper">
    <!-- headbar with sidebar toggle icon with search bar -->
    <header>
      <nav id="header">
        <div class="header-left">
          <div class="menu-icon" id="menu-icon">
            <span></span><span></span><span></span>
          </div>
          <a id="logo" href="home.php">theMarket</a>
        </div>
        <div class="header-center">
          <a href="home.php" class="home-link">Home</a>
          <form action="results.php" method="get" class="search-bar">
            <input
              type="text"
              name="query"
              placeholder="Search products or keywords…"
              value="<?= htmlspecialchars($query) ?>"
            />
          </form>
          <a href="cart.php" class="cart" id="cart">Cart (<?= $cartCount ?>)</a>
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

    <!-- product result page -->
    <main>
      <section class="products-grid">
        <?php if (empty($products)): ?>
          <p class="no-results">No products found matching your criteria.</p>
        <?php else: ?>
          <?php foreach($products as $p): ?>
            <article class="product-card">
              <a href="product.php?listing=<?= $p['listing_id'] ?>">
                <div
                  class="product-image"
                  style="background-image:url('images/<?= htmlspecialchars($p['product_image']) ?>')"
                ></div>
                <h4 class="product-name"><?= htmlspecialchars($p['product_name']) ?></h4>
                <p class="product-price">$<?= number_format($p['listing_price'], 2) ?></p>
                <p class="product-brand"><?= htmlspecialchars($p['product_brand']) ?></p>
              </a>
              <button class="add-to-cart" onclick="addToCart(<?= $p['listing_id'] ?>)">Add to Cart</button>
            </article>
          <?php endforeach; ?>
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
  <script src="scripts/filter.js"></script>
</body>
</html>
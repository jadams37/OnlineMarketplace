<?php
  session_start();

  // database connection
  require __DIR__ . '/includes/db.php';

  // query to get the most recent active deal
  $sql = "
  SELECT
    l.listing_id,
    p.product_name,
    p.product_image,
    l.listing_price,
    d.discount_percent
  FROM deals d
  JOIN listing l
    ON l.product_id = d.product_id
   AND l.listing_status = 'Active'
  JOIN products p
    ON p.product_id = d.product_id
  WHERE CURDATE() BETWEEN d.start_date AND d.end_date
  ORDER BY d.start_date DESC
";

$res   = $conn->query($sql);
$deals = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>theMarket - Home</title>
  <link href="css/layout.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/styleHome.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search">
  <script src="scripts/purchaseProduct.js"></script>
</head>
<body>

  <header>
    <!-- Navigation Bar -->
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
          <a href="" id="cart">Cart</a>
        </div>
        <?php if(isset($_SESSION["user_id"])): ?>
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

  <article>
    <!-- Deals section -->
    <?php if (count($deals) > 0): ?>
<section class="deals-carousel-container">
  <div class="carousel-left">
    <button id="prevDeal" class="carousel-arrow">&#10094;</button>
    <button id="nextDeal" class="carousel-arrow">&#10095;</button>

    <div id="dealSlides">
    <?php foreach ($deals as $i => $d): 
      $orig  = (float)$d['listing_price'];
      $disc  = $orig * (1 - $d['discount_percent']/100);
    ?>
      <div class="deal-slide"
           data-index="<?= $i ?>"
           data-listingid="<?= $d['listing_id'] ?>"
           data-name="<?= htmlspecialchars($d['product_name']) ?>"
           data-orig="<?= number_format($orig,2) ?>"
           data-disc="<?= number_format($disc,2) ?>"
           style="<?= $i === 0 ? '' : 'display:none;' ?>">
        <div class="discount-badge">-<?= $d['discount_percent'] ?>%</div>
        <img src="images/<?= htmlspecialchars($d['product_image']) ?>"
             alt="<?= htmlspecialchars($d['product_name']) ?>">
      </div>
    <?php endforeach; ?>
    </div>
  </div>

  <div class="carousel-right">
    <h2>Deals</h2>
    <p class="sale-alert">Sale Alert!!!</p>
    <p>Grab these items before they sell out.</p>
    <h3 id="dealName"></h3>
    <p class="price" id="dealPrice"></p>
    <div class="btn-group">
      <a href="#" id="dealPurchase" class="btn btn-purchase">View Item</a>
      <button type="button" id="dealAddCart" class="btn btn-addcart"  onclick="addToCart()">
      Add to Cart
      </button>
    </div>
  </div>
</section>
<?php else: ?>
  <p>No deals right now—check back soon!</p>
<?php endif; ?>

    <!-- Categories Section-->
    <?php
  $catsRs = $conn->query("SELECT category_id, name FROM categories");
  $categories = $catsRs->fetch_all(MYSQLI_ASSOC);
?>
<section class="categories">
  <h2>Categories</h2>
  <div class="categories-list">
    <?php foreach($categories as $cat): ?>
      <div class="category-card">
        <a href="category.php?category_id=<?= $cat['category_id'] ?>">
          <img src="images/<?= strtolower($cat['name']) ?>.png"
               alt="<?= htmlspecialchars($cat['name']) ?>">
          <h3><?= htmlspecialchars($cat['name']) ?></h3>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

    <!-- About Us -->
    <section class="about-section">
      <h2>About Us</h2>
      <p>
        Founded in 2025, theMarket is a fresh take on online shopping—
        fast, seamless, and built for the modern buyer. We connect you with 
        top products, trusted sellers, and best deals, all in one sleek 
        marketplace. Shop smart. Shop modern. Shop theMarket.
      </p>
    </section>
  </article>

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

  <script src="scripts/dealsCarousel.js"></script>
  <script src="scripts/purchaseProduct.js"></script>
  
</body>
</html>

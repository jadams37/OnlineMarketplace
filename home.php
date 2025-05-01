<?php
  session_start();

  // 1) database connection
  require __DIR__ . '/includes/db.php';

  // 2) query to fetch the most recent active deal
  $sql = "
  SELECT
    d.deal_id,
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
    <p>Grab these items before they sell out</p>
    <h3 id="dealName"></h3>
    <p class="price" id="dealPrice"></p>
    <div class="btn-group">
      <a href="#" id="dealPurchase" class="btn btn-purchase">Purchase</a>
      <a href="#" id="dealAddCart" class="btn btn-addcart">Add to Cart</a>
    </div>
  </div>
</section>
<?php else: ?>
  <p>No deals right now—check back soon!</p>
<?php endif; ?>

    <!-- Featured Categories -->
    <section class="featured-categories">
      <h2>Featured Categories</h2>
      <p>Check out these categories picked specially for you.</p>
      <div class="categories-list">
        <!-- Category Card 1 -->
        <div class="category-card">
          <img src="images/sale_icon.png" alt="Sale Icon">
          <h3>Sale</h3>
        </div>

        <!-- Category Card 2 -->
        <div class="category-card">
          <img src="images/trending_icon.png" alt="Trending Icon">
          <h3>Trending</h3>
        </div>

        <!-- Category Card 3 -->
        <div class="category-card">
          <img src="images/last_viewed_icon.png" alt="Last Viewed Icon">
          <h3>Last Viewed</h3>
        </div>
      </div>
    </section>

    <!-- Recently Viewed -->
    <section class="recently-viewed">
      <h2>Recently Viewed</h2>
      <p>Jump back in...</p>
      <div class="recently-items">
        <!-- Item 1 -->
        <div class="recently-card">
          <!-- Replacing "item_placeholder.png" with an actual image once database added -->
          <img src="images/item_placeholder.png" alt="Last Item Viewed">
          <h4>Last Item Viewed</h4>
        </div>

        <!-- Item 2 -->
        <div class="recently-card">
          <img src="images/item_placeholder.png" alt="Recently Viewed Item">
          <h4>Recently Viewed Item</h4>
        </div>

        <!-- Item 3 -->
        <div class="recently-card">
          <img src="images/item_placeholder.png" alt="Recently Viewed Item">
          <h4>Recently Viewed Item</h4>
        </div>
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
    <!-- Contains a secondary navigation bar and the copyright -->
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

  <!-- Link to JavaScript -->
  <!-- Don't have js file yet -->
  <script src="script.js"></script>
  <script>
document.addEventListener('DOMContentLoaded', () => {
  const slides  = document.querySelectorAll('.deal-slide');
  const nameEl  = document.getElementById('dealName');
  const priceEl = document.getElementById('dealPrice');
  let idx = 0;

  function showSlide(i) {
    slides.forEach(s => s.style.display = 'none');
    const s = slides[i];
    s.style.display = 'block';

    const name = s.dataset.name;
    const orig = parseFloat(s.dataset.orig);
    const disc = parseFloat(s.dataset.disc);

    nameEl.textContent = name;
    priceEl.innerHTML  = `<del>$${orig.toFixed(2)}</del> <span>$${disc.toFixed(2)}</span>`;
  }

  document.getElementById('prevDeal').addEventListener('click', () => {
    idx = (idx - 1 + slides.length) % slides.length;
    showSlide(idx);
  });

  document.getElementById('nextDeal').addEventListener('click', () => {
    idx = (idx + 1) % slides.length;
    showSlide(idx);
  });

  showSlide(0);
});
</script>
</body>
</html>

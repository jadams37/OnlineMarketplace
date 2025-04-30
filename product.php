<?php
    session_start();

    $mysqli = require __DIR__ . "\db-connection.php";

    $sql = sprintf("SELECT listing_id, products.product_id, listing_price, product_name, product_brand, product_description, product_image
                    FROM listing
                    JOIN products ON listing.product_id = products.product_id
                    WHERE listing_id = 2");

    $result = $mysqli->query($sql);

    $product = $result->fetch_assoc();

    if($product) {
        $pprice = $product['listing_price'];
        $pname = $product['product_name'];
        $pbrand = $product['product_brand'];
        $pdesc = $product['product_description'];
        $pimage = $product['product_image'];
    }

    $sql = sprintf("SELECT review_listing_id, review_user_id, user_name, review_description
                    FROM review
                    JOIN user ON review.review_user_id = user.user_id
                    WHERE review_listing_id = 2");

    $result = $mysqli->query($sql);

    $reviews = [];

    while($review = $result->fetch_assoc()) {
        $reviews[] = $review;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta information for webpage -->
        <meta name="author" content="Jordan Adams, IWD"/>
        <meta name="keywords" content="Marketplace, Shopping, Store, Product"/>
        <meta name="description" content="Online marketplace to buy and sell goods."/>
        <meta charset="UTF-8"/>
        <title>theMarket - Product</title>
        <!-- External links for .css, .js files, etc. -->
        <link href="css/layout.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search">
        <script src="scripts/purchaseProduct.js"></script>
    </head>
    <body>
        <header>
            <!-- Navigation Bar -->
            <nav id="header">
                <a id="logo" href="home.php">theMarket</a>
                <a href="home.php" id="home">Home</a>
                <form action="" method="">
                    <div class="search">
                        <span class="search-icon material-symbols-outlined">search</span>
                        <input class="search-input" type="search" placeholder="Search">
                    </div>
                </form>
                <a href="" id="cart">Cart</a>
                <?php if(isset($_SESSION["user_id"])): ?>
                    <a href="profile.html" class="profile">
                        <img src="images/profile.png" alt="Profile" id="profile">
                    </a>
                <?php else: ?>
                    <a href="login.php" class="profile">
                        <img src="images/profile.png" alt="Profile" id="profile">
                    </a>
                <?php endif; ?>
            </nav>
        </header>
        <!-- Main content of webpage containing current product, product description,
             reviews, and related products -->
        <article>
            <!-- Div container the current product with its information -->
            <div class="container">
                <div class="product">
                    <img src="<?= sprintf("images/%s", $pimage)?>" alt="Product" id="product">
                </div>
                <div class="description">
                    <h1 id="productName"><?= $pname?></h1>
                    <u><strong><?= $pbrand?></strong></u><br>
                    <strong>$<?= $pprice?> ★★★★☆ (4.5)</strong><br>
                    <hr>
                    <p id="description">
                        <?= $pdesc?>
                    </p>
                </div>
            </div>
            <!-- Buttons to purchase or add current product to cart -->
            <div class="transactions">
                <form action="">
                    <input type="button" class="purchase" value="Purchase" onclick="purchase()">
                    <input type="button" class="addtocart" value="Add to Cart" onclick="addToCart()">
                </form>
            </div>
            <!-- Contains all individual reviews on current product -->
            <div class="reviews">
                <?php if(!empty($reviews)): ?>
                    <?php foreach($reviews as $review): ?>
                        <div class="review">
                            <img src="images/profile.png" alt="user" id="user">
                            <strong><?= htmlspecialchars($review['user_name']) ?> ★★★★☆</strong>
                        </div>
                        <div class="reviewDiscription">
                            <p><?= htmlspecialchars($review['review_description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There are no reviews.</p>
                <?php endif ?>
            </div>
            <!-- Contains related products relevant to the current product -->
            <div class="related">
                <hr>
                <p>Related Products</p>
                <img src="images/profile.png" alt="related product" id="related">
                <img src="images/profile.png" alt="related product" id="related">
                <img src="images/profile.png" alt="related product" id="related">
                <img src="images/profile.png" alt="related product" id="related">
            </div>
        </article>
        <footer>
            <!-- Contains a secondary navigation bar and the copyright -->
            <nav id="footer">
                <a id="logo" href="home.php">theMarket</a>
                <a href="">Customer Care</a>
                <a href="">Legal Use</a>
                <a href="">Careers</a>
                <a href="">Follow Us</a>
            </nav>
            <p id="copyright">&copy; 2025, Interactive Web Designs</p>
        </footer>
    </body>
</html>
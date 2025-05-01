<?php
session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit;
}

$mysqli = require __DIR__ . "/db-connection.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT user_name, user_first_name, user_last_name, user_email, user_phone, user_address, user_role_id, role_name
        FROM user
        JOIN role ON user.user_role_id = role.role_id
        WHERE user_id = ?";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("SQL preparation failed: " . $mysqli->error);
}

$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Christian East" />
  <meta name="description" content="User profile page for marketplace" />
  <title>theMarket - User Profile</title>
  <link href="css/layout.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
<body>
  <header>
    <!-- Navigation Bar -->
    <nav id="header">
        <a id="logo" href="home.php">theMarket</a>
        <div class="nav-center">
          <a href="home.php" id="home">Home</a>
          <form action="results.php">
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
    <div class="container profile-page">
      <!-- Profile Info -->
      <section class="profile-info">
        <img src="images/profile.png" alt="User Profile Picture" class="profile-pic" />
        <!-- Display View -->
        <div id="display-view">
            <h2 id="display-name"><?= htmlspecialchars($user["user_name"]) ?></h2>
            <p id="display-fname">First Name: <?= htmlspecialchars($user["user_first_name"]) ?></p>
            <p id="display-lname">Last Name: <?= htmlspecialchars($user["user_last_name"]) ?></p>
            <a href="logout.php">Logout</a>
            <p id="display-location">Address: <?= htmlspecialchars($user["user_address"]) ?></p>
            <p id="display-role">Role: <?= htmlspecialchars($user["role_name"]) ?></p>
            <p id="display-email">Email: <?= htmlspecialchars($user["user_email"]) ?></p>
            <p id="display-phone">Phone: <?= htmlspecialchars($user["user_phone"]) ?></p>
            <button id="edit-btn">Edit Account</button>
        </div>

        <!-- Edit Form View -->
  <form action="update-profile.php" id="edit-form" method="post" class="hidden">
    <label>
    Username:
    <input type="text" name="username" id="input-name" value="<?= htmlspecialchars($user["user_name"]) ?>" />
    </label>
    <br>
    <label>
    First Name:
    <input type="text" name="firstname" id="input-fname" value="<?= htmlspecialchars($user["user_first_name"]) ?>" />
    </label>
    <br>
    <label>
    Last Name:
    <input type="text" name="lastname" id="input-lname" value="<?= htmlspecialchars($user["user_last_name"]) ?>" />
    </label>
    <br>
    <label>
    Location:
    <input type="text" name="address" id="input-location" value="<?= htmlspecialchars($user["user_address"]) ?>" />
    </label>
    <br>
    <label>
    Phone:
    <input type="tel" name="phone" id="input-phone" value="<?= htmlspecialchars($user["user_phone"]) ?>" />
    </label>
    <br>
    <label>
    Email:
    <input type="email" name="email" id="input-email" value="<?= htmlspecialchars($user["user_email"]) ?>" />
    </label>
    <br>
    <label>
    Role:<br>
    <label for="input-seller">Seller</label>
    <input type="radio" id="input-seller" name="input-role" value= 2 />
    <br>
    <label for="input-buyer">Buyer</label>
    <input type="radio" id="input-buyer" name="input-role" value= 1 />
    </label>
    <br>
    <button type="button" id="save-btn">Save Changes</button>
    <button type="button" id="cancel-btn">Cancel</button>
  </form>
    </section>

    <hr>



    <?php
    require 'db-connection.php';
    $categories_result = $mysqli->query("SELECT * FROM categories");
    if (!$categories_result) {
      die("Query failed: " . $mysqli->error);
}
    $categories = $categories_result->fetch_all(MYSQLI_ASSOC);
    ?>


      <!-- Listings -->
      <section class="user-listings">


        <!-- Add Listing Form -->
        <form action="listing-process.php" method="post" enctype="multipart/form-data" id="listing-form" class="hidden">
        <input type="hidden" name="listing_id" value="" id="listing-id">
  
        <label for="product_name">Product Name:</label>
  <input type="text" name="product_name" id="product_name" required>
  <br>

  <label for="product_description">Description:</label><br>
  <textarea name="product_description" id="product_description" rows="4" cols="50"></textarea>
  <br>

  <label for="product_brand">Brand:</label>
  <input type="text" name="product_brand" id="product_brand">
  <br>
        
        <label for="price">Price ($):</label>
  <input type="number" step="0.01" name="price" id="price" required>
  <br>

  <label>Condition:</label>
  <label><input type="radio" name="product_condition" value="New" checked> New</label>
  <label><input type="radio" name="product_condition" value="Used"> Used</label>
  <br><br>

  <input type="file" name="product_image" id="product_image" accept="image/*">
  <br>

  <label for="quantity">Quantity:</label>
  <input type="number" name="quantity" id="quantity" required>
  <br>

  <label for="keywords">Keywords (comma-separated):</label>
  <input type="text" name="keywords" id="keywords">
  <br>

  <label for="category_id">Category:</label>
  <select name="category_id" id="category_id" required>
    <?php
    foreach ($categories as $category) {
        echo "<option value=\"" . htmlspecialchars($category["category_id"]) . "\">" . htmlspecialchars($category["name"]) . "</option>";
    }
    ?>
  </select>
  <br>

  <label for="status">Status:</label>
  <select name="status" id="status">
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
    <option value="Sold">Sold</option>
  </select>


  <!--stupid submit button iwsnt working the way i want-->
  <button type="submit" name="submit_listing" id="submit_listing">Save Listing</button>
  <button type="button" name="cancel_listing" id="cancel_listing" onclick="document.getElementById('listing-form').classList.add('hidden')">Cancel</button>
</form>


<!--checks if user is a seller-->
<?php if (isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 2): ?>
  <button onclick="document.getElementById('listing-form').classList.remove('hidden')">Add Listing</button>
<?php endif; ?>

      </section>

      <hr>

      <!-- Transaction History -->
      <section class="transaction-history">
        <h3>Transaction History</h3>
        <ul>
          <li>Sold “Gummy Bear Salute Sticker” to Alice — $3.99 on 2025-04-02</li>
          <li>Sold “Fish with Sunglasses Sticker” to Bob — $6.99 on 2025-03-28</li>
        </ul>
      </section>

      <hr>

      <!-- Reviews -->
      <section class="user-reviews">
        <h3>Reviews From Buyers</h3>
        <div class="review">
          <img src="images/profile.png" alt="User Icon" id="user">
          <strong>Alice</strong>
          <p>“Cool Sticker!” ★★★★★</p>
        </div>
        <div class="review">
          <img src="images/profile.png" alt="User Icon" id="user">
          <strong>Bob</strong>
          <p>“Shipping was a little slow, but worth the wait.” ★★★★☆</p>
        </div>
      </section>
    </div>
  </div>

  </article>

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

  <!--Account Settings JS-->
  <script src="scripts/update-profile.js"></script>

  <!-- New Listing JS -->
  <script src="scripts/new-listing.js"></script>


</body>
</html>
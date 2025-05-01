<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta information for webpage -->
        <meta name="author" content="Jordan Adams, IWD"/>
        <meta name="keywords" content="Marketplace, Shopping, Store, Product"/>
        <meta name="description" content="Online marketplace to buy and sell goods."/>
        <meta charset="UTF-8"/>
        <title>theMarket - Signup</title>
        <!-- External links for .css, .js files, etc. -->
        <link href="css/layout.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search">
        <script src="scripts/purchaseProduct.js"></script>
        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
        <script src="scripts/validation.js" defer></script>
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
            <div class="login-panel">
                <form action="login-process.php" method="post" id="signup" novalidate>
                    <h1>Welcome to theMarket!</h1>
                    <div class="login-input">
                        <input type="text" name="username" id="username" placeholder="Username" required>
                    </div>
                    <div class="login-input">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="login-input">
                        <input type="text" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="login-input">
                        <input type="text" name="address" id="address" placeholder="Address" required>
                    </div>
                    <div class="login-input">
                        <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
                    </div>
                    <div class="login-input">
                        <input type="text" name="firstname" id="firstname" placeholder="First Name" required>
                    </div>
                    <div class="login-input">
                        <input type="text" name="lastname" id="lastname" placeholder="Last Name" required>
                    </div>
                    <div class="login-button">
                        <input type="submit" value="Register">
                    </div>
                    <div class="login-register">
                        <p>Already a User?
                        <a href="login.php">Login Here</a></p>
                    </div>
                </form>
            </div>
        </article>
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
    </body>
</html>
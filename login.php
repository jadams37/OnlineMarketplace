<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $mysqli = require __DIR__ . "\db-connection.php";

        $sql = sprintf("SELECT * FROM user
                WHERE user_name = '%s'", $mysqli->real_escape_string($_POST["username"]));

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();
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
        <title>theMarket - Login</title>
        <!-- External links for .css, .js files, etc. -->
        <link href="css/layout.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search">
        <script src="scripts/purchaseProduct.js"></script>
    </head>
    <body>
        <header>
            <!-- Navigation Bar -->
            <nav id="header">
                <a id="logo" href="home.html">theMarket</a>
                <a href="home.html" id="home">Home</a>
                <form action="" method="">
                    <div class="search">
                        <span class="search-icon material-symbols-outlined">search</span>
                        <input class="search-input" type="search" placeholder="Search">
                    </div>
                </form>
                <a href="" id="cart">Cart</a>
                <a href="profile.html" class="profile">
                    <img src="images/profile.png" alt="Profile" id="profile">
                </a>
            </nav>
        </header>
        <article>
            <div class="login-panel">
                <form method="post">
                    <h1>Welcome back to theMarket!</h1>
                    <div class="login-input">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="login-input">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="login-button">
                        <input type="submit" value="Login">
                    </div>
                    <div class="login-register">
                        <p>New User?
                        <a href="signup.html">Create an Account</a></p>
                    </div>
                </form>
            </div>
        </article>
        <footer>
            <!-- Contains a secondary navigation bar and the copyright -->
            <nav id="footer">
                <a id="logo" href="home.html">theMarket</a>
                <a href="">Customer Care</a>
                <a href="">Legal Use</a>
                <a href="">Careers</a>
                <a href="">Follow Us</a>
            </nav>
            <p id="copyright">&copy; 2025, Interactive Web Designs</p>
        </footer>
    </body>
</html>
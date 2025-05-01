<?php
    $is_invalid = false;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $mysqli = require __DIR__ . "\db-connection.php";

        $sql = sprintf("SELECT * FROM user
                WHERE user_name = '%s'", $mysqli->real_escape_string($_POST["username"]));

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();

        if($user) {
            if(password_verify($_POST["password"], $user["user_password"])) {
                session_start();
                $_SESSION["user_id"] = $user["user_id"];
                session_regenerate_id();

                header("Location: home.php");
                exit;
            }
        }

        $is_invalid = true;

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
            <div class="login-panel">
                <form method="post" novalidate>
                    <h1>Welcome back to theMarket!</h1>
                    <div class="login-input">
                        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST["username"] ?? "")?>" required>
                    </div>
                    <div class="login-input">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <?php if($is_invalid): ?>
                        <p style="color:red; font-size:12px; text-align:center">Incorrect Username or Password</p>
                    <?php endif; ?>
                    <div class="login-button">
                        <input type="submit" value="Login">
                    </div>
                    <div class="login-register">
                        <p>New User?
                        <a href="signup.php">Create an Account</a></p>
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
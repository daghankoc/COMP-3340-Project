<?php 
    //session to keep session data
    session_start(); 
?>
<link rel="stylesheet" href="stylesheet_light.css">
<header>
    <div class="header">
        <div class="">
            <!-- always available header items -->
            <a href="store.php" class="header-item">Home</a>
            <a href="help.php" class="header-item">Help</a>
        </div>
        <div class="header-items">
            <?php if ($_SESSION && $_SESSION["userStatus"] == "loggedin") : ?>
                <!-- header items for account and admin -->
                <a href="account.php" class="header-item">Account</a>
                <?php if ($_SESSION["user"]["role"] == "admin") : ?>
                    <a href="admin.php" class="header-item">Admin</a>
                <?php endif; ?>
                <a href="logout.php" class="header-item">Logout</a>
            <?php else : ?>
                <!-- header items for login and signup -->
                <a href="login.php" class="header-item">Login</a>
                <a href="signup.php" class="header-item">Signup</a>
            <?php endif; ?>
        </div>
    </div>
</header>
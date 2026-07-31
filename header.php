<?php 
    //session to keep session data
    session_start(); 

    //themes preset
    $themes = ['light' => 'stylesheet_light.css','red'  => 'stylesheet_red.css', 'green'  => 'stylesheet_green.css'];

    // set theme at the top from the admin page
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select_theme'])) {
        //ffallback to light
        $selectedTheme = $_POST['theme'] ?? 'light';

        //if themes not set before
        if (isset($themes[$selectedTheme])) {
            $_SESSION['theme'] = $selectedTheme;
        }

        // refresh to set theme
        header('Location: admin.php');
        exit;
    }

    $currentTheme = $_SESSION['theme'] ?? 'light';

    if (!isset($themes[$currentTheme])) {
        $currentTheme = 'light';
    }

    //set the current theme
    $themeStylesheet = $themes[$currentTheme];
?>
<link rel="stylesheet" href="<?php echo $themeStylesheet; ?>">
<link rel="icon" href="favicon.ico">
<header>
    <div class="header">
        <div class="">
            <!-- always available header items -->
            <a href="index.php" class="header-item">Store</a>
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
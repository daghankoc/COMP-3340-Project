<?php 
    include 'header.php'; 
    include 'lib/database.php';
    $db = new Database();

    //log in the user if the user is found post 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //get POST form variable
        $username = $_POST["username"];
        $password = $_POST["password"];

        //get the user from db
        $user = $db->getUser($username, $password);
        //if user and is active 
        if ($user && ($user["active"] == TRUE)) {

            //create session
            $_SESSION["user"] = $user;
            $_SESSION["userStatus"] = "loggedin";

            //redirect to store page
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            //no user found
            $error = "Invalid username/password or the user is not active";
            echo $error;
        }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta name="author" content="Daghan Koc">
    <meta charset="UTF-8">
    <meta name="description" content="Login page for the store">
    <meta name="keywords" content="minipc, login, user">
    <meta name="robots" content="noindex">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <div class="login-container">
        <h1 class="login-title">Login</h1>
        <form method="post" action="login.php" class="login-form">
            <p class="login-text">Enter username and password to login.</p>
            <input type="text" name="username" placeholder="Username" class="login-input">
            <input type="password" name="password" placeholder="Password"class="login-input">
            <input type="submit" value="Login" class="login-button">
        </form>
    </div>
  </body>
</html>

<?php 
    include 'footer.php'; 
?>
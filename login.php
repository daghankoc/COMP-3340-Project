<?php 
    include 'header.php'; 
    include 'lib/database.php';
    $db = new Database();

    //log th euser in if the user is found
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user = $db->getUser($username, $password);
        if ($user) {

            $_SESSION["user"] = $user;
            $_SESSION["userStatus"] = "loggedin";
            //redirect to store page
            echo "<script>window.location.href = 'store.php';</script>";
        } else {
            $error = "Invalid username or password";
            echo $error;
        }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta name="author" content="Daghan Koc">
    <link rel="stylesheet" href="stylesheet_light.css">
  </head>
  <body>
    <div class="login-container">
        <h1 class="login-title">Login</h1>
        <form method="post" action="login.php" class="login-form">
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
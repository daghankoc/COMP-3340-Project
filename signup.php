<?php 
    include 'header.php'; 
    include 'lib/database.php';

    //get the user filled that and the sign up the user
    $db = new Database();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $db->signupUser($username, $password);
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Signup</title>
    <meta name="author" content="Daghan Koc">
    <link rel="stylesheet" href="stylesheet_light.css">
  </head>
  <body>
    <div class="signup-container">
      <h1>Signup</h1>
      <div class="signup-form">
        <form method="post" action="signup.php" class="login-form">
          <input type="text" name="username" placeholder="Username" class="login-input">
            <input type="password" name="password" placeholder="Password" class="login-input">
            <input type="password" name="confirm_password" placeholder="Confirm Password" class="login-input">
            <input type="submit" value="Signup" class="login-button">
        </form>
      </div>
    </div>
  </body>
</html>
<?php 
    include 'footer.php'; 
?>
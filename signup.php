<?php 
    include 'header.php'; 
    include 'lib/database.php';

    //get the user filled that and the sign up the user
    $db = new Database();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //get the post form variables
      $username = $_POST['username'];
      $password = $_POST['password'];

      //db call
      $db->signupUser($username, $password);

      //redirect to login
      echo "<script>window.location.href = 'login.php';</script>";
      exit;
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <meta name="author" content="Daghan Koc">
    <meta name="description" content="Signup page for the store">
    <meta name="keywords" content="minipc, user, signup">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <div class="signup-container">
      <h1>Signup</h1>
      <div class="signup-form">
        <form method="post" action="signup.php" class="login-form">
          <p>Enter username and password to signup.</p>
          <input type="text" name="username" placeholder="Username" class="login-input">
          <input type="password" name="password" placeholder="Password" class="login-input">
          <input type="submit" value="Signup" class="login-button">
        </form>
      </div>
    </div>
  </body>
</html>
<?php 
    include 'footer.php'; 
?>
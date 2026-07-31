<?php 
    include 'header.php'; 
    include 'lib/database.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Help - Admin</title>
    <meta charset="UTF-8">
    <meta name="author" content="Daghan Koc">
    <meta name="description" content="Help Admin page for the store">
    <meta name="keywords" content="minipc, store, help">
    <meta name="robots" content="noindex">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <div class="help-container">
        <a href="help.php"> < Go back to Help</a>
        <h1>Admin Wiki</h1>
        <p>Admin users are able to add, delete and edit products.Admin are also able to disable users and answer questions regarding the product.</p>
        <p>Admins are also able to switch the theme of the website.</p>
        <p>Admins are responsible for checking the orders and processing them on the admin page.</p>
        <p>Admins are also able to answer questions regarding products from the admin page</p>
        <p>Monitoring page can also be accessed from here</p>
        <p>Test Admin Login: testadmin password: password12345</p>
        <a href="login.php">Go to Login</a>
        <a href="admin.php">Go to Admin</a>
      </div>
  </body>
</html>

<?php 
    include 'footer.php'; 
?>
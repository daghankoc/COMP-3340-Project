<?php 
    include 'header.php'; 
    include 'lib/database.php';
    // get product detail from database
    $db = new Database();

    //get healtcheck result
    $healthCheck = $db->healthCheck();

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Service Status</title>
    <meta name="author" content="Daghan Koc">
    <meta charset="UTF-8">
    <meta name="description" content="Monitoring page for the store">
    <meta name="keywords" content="minipc, service, monitor">
    <meta name="robots" content="noindex">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    
    <div class="service-status-container">
      <a class="" href="index.php">< Go Back to Store Page</a>
      <h1 class="product-title">Service Status</h1>
      <h2 class="">Database</h2>
      <?php if ($healthCheck != NULL ) : ?>
        <p class="green-text">Online</p>
        <?php else : ?>
            <p class="red-text">Offline</p>
        <?php endif; ?>
      <h2 class="Backend">Backend</h2>
      <?php if ($healthCheck != NULL ) : ?>
        <p class="green-text">Online</p>
        <?php else : ?>
          <p class="red-text">Offline</p>
        <?php endif; ?>
    </div>
  </body>
</html>
<?php 
    include 'footer.php'; 
?>
<?php 
    include 'header.php'; 
    include 'lib/database.php';
    
    //get user orders so they view history and track
    $db = new Database();
    $orders = $db->getUserOrders();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Account</title>
    <meta name="author" content="Daghan Koc">
  </head>
  <body>
    <h1>Account</h1>
    <h2>Orders</h2>
    <ul>
        <?php foreach ($orders as $order) : ?>
            <li><?php $order['order_id']; ?></li>
        <?php endforeach; ?>
    </ul>
  </body>
  <?php include 'cart.php'; ?>
</html>

<?php 
    include 'footer.php'; 
?>
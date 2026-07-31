<?php 
    include 'header.php'; 
    include 'lib/database.php';
    // get products from database
    $db = new Database();
    $items = $db->getCartItems($_SESSION['user']['id']);


    //checkout shopping cart to order
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {

      //get user id
      $userId = $_SESSION['user']['id'];
      $items = $db->getCartItems($_SESSION['user']['id']);

      //create order db call
      $orderId = $db->createOrder($userId, $items);

      //clear cart db call
      $db->clearCart($userId);
      //go to account page(success)
      echo "<script>window.location.href = 'account.php';</script>";
      exit;
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Checkout</title>
    <meta charset="UTF-8">
    <meta name="author" content="Daghan Koc">
    <meta name="description" content="Checkout page for the store">
    <meta name="keywords" content="minipc, store, checkout">
    <meta name="robots" content="noindex">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <?php foreach ($items as $item) : ?>
        <div class="checkout-product">
            <h2><?php echo $item['name']; ?></h2>
            <p>Quantity: <?php echo $item['count']; ?></p>
            <p>Price: <?php echo $item['price']; ?></p>
            <p>Chip:<?php echo $item['chip']; ?></p>
            <p>Region:<?php echo $item['region']; ?></p>
        </div>
    <?php endforeach; ?>
    <div class="checkout-box">
      <form method="post" action="checkout.php">
          <input type="text" name="name" placeholder="Name" required>
          <input type="text" name="card_number" placeholder="Card Number" required>
          <input type="text" name="card_expiry" placeholder="Card Expiry" required>
          <input type="text" name="card_cvv" placeholder="Card CVV" required>
          <button type="submit" class="admin-add-button" name="checkout" value="1">
            Checkout
        </button>
      </form>
    </div>
  </body>
</html>
<?php 
    include 'footer.php'; 
?>
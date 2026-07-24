<?php 
    include 'header.php'; 
    include 'lib/database.php';
    // get products from database
    $db = new Database();
    $items = $db->getCartItems();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Store</title>
    <meta name="author" content="Daghan Koc">
  </head>
  <body>
    <?php foreach ($items as $item) : ?>
        <div class="product">
            <h2><?php echo $item['name']; ?></h2>
            <p><?php echo $item['description']; ?></p>
            <p><?php echo $item['price']; ?></p>
            <a href="product.php?id=<?php echo $item['id']; ?>">View Product</a>
        </div>
    <?php endforeach; ?>
    <div class="checkout-box">
      <form method="post" action="checkout.php">
          <input type="text" name="name" placeholder="Name">
          <input type="text" name="card_number" placeholder="Card Number">
          <input type="text" name="card_expiry" placeholder="Card Expiry">
          <input type="text" name="card_cvv" placeholder="Card CVV">
          <input type="submit" value="Checkout">
      </form>
    </div>
  </body>
</html>
<?php 
    include 'footer.php'; 
?>
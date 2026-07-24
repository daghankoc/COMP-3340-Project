<?php 
    require_once 'lib/database.php';
    // get cart of the user from database
    $items = $db->getCartItems();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Cart</title>
    <meta name="author" content="Daghan Koc">
  </head>
  <body>
    <?php if (count($items) > 0) : ?>
      <div class="cart-floating">
          <h1>Shopping Cart</h1>
          <?php foreach ($items as $item) : ?>
            <div class="product">
              <h2><?php echo $item['name']; ?></h2>
              <p><?php echo $item['description']; ?></p>
              <p><?php echo $item['price']; ?></p>
              <a href="product.php?id=<?php echo $item['id']; ?>">View Product</a>
            </div>
          <?php endforeach; ?>
          <a href="checkout.php">Checkout</a>
      </div>
    <?php endif; ?>
  </body>
</html>
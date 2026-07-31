<?php 
    require_once 'lib/database.php';

    //clear cart logic
    if ($_SERVER['REQUEST_METHOD'] === 'POST' &&isset($_POST['clear_cart'])) {
        //db call
        $db->clearCart($_SESSION['user']['id']);
    }

    //get the cart items of the user
    $items = $db->getCartItems($_SESSION['user']['id']);

    //calculate the total of the cart
    $total = 0;
    
    //cart loop
    foreach ($items as $item) {
        $total += $item['price'] * $item['count'];
    }
   
?>

<?php if (count($items) > 0): ?>
    <div class="cart-floating">
        <h1>Shopping Cart</h1>

        <?php foreach ($items as $item): ?>
            <div class="cart-product">
                <p><?php echo $item['name']; ?></p>
                <p>$<?php echo $item['price']; ?></p>
                <p>x</p>
                <p><?php echo $item['count']; ?></p>
            </div>
        <?php endforeach; ?>

        <div class="cart-product">
            <p>Total: $<?php echo $total; ?></p>
        </div>

        <a href="checkout.php" class="add-product-button">Checkout</a>

        <form method="post">
            <button type="submit" class="add-product-button" name="clear_cart" value="1">
                Clear Cart
            </button>
        </form>
        <a href="help-cart.php">Help(Cart)</a>
    </div>
<?php endif; ?>
<?php 
    include 'header.php'; 
    include 'lib/database.php';

    // get products from database
    $db = new Database();
    $products = $db->getProducts();

    //product search
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $search = $_GET['search'];
        if ($search) {
            $products = $db->searchProducts($search);
        }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Store</title>
    <meta name="author" content="Daghan Koc">
    <link rel="stylesheet" href="stylesheet_light.css">
  </head>
  <body>
    <div class="store-container">
      <h1>Store</h1>
      <form method="get" action="store.php">
          <input type="text" name="search" placeholder="Search">
          <input type="submit" value="Search">
      </form>
      <div class="store-items">
        <?php foreach ($products as $product) : ?>
            <div class="product">
                <h2><?php echo $product['name']; ?></h2>
                <p><?php echo $product['description']; ?></p>
                <p><?php echo $product['price']; ?></p>
                <a href="product.php?id=<?php echo $product['id']; ?>">View Product</a>
                <button class="view-product-button">View Product</button>
            </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php
        // show the cart if the user is logged in
        if ($_SESSION && $_SESSION["userStatus"] == "loggedin") {
            include 'cart.php';
        } 
    ?>
  </body>
</html>
<?php 
    include 'footer.php'; 
?>
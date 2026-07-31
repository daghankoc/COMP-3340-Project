<?php 
    include 'header.php'; 
    include 'lib/database.php';

    // get products from database
    $db = new Database();
    $products = $db->getProducts();

    //product search
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        //get the search from form
        $search = $_GET['search'] ?? '';
        //if search is set search using db call
        if ($search) {
            $products = $db->searchProducts($search);
        }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Store</title>
    <meta charset="UTF-8">
    <meta name="author" content="Daghan Koc">
    <meta name="description" content="Store page for the minipc store">
    <meta name="keywords" content="minipc, store, storefront,marketplace">
    <meta name="robots" content="noindex">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <div class="store-container">
      <h1>HomeLab Store</h1>
      <form method="get" action="index.php">
          <input type="text" name="search" class="search-bar" placeholder="Search">
          <input type="submit" class="search-button" value="Search">
      </form>
      <div class="store-items">
        <?php if (count($products) > 0): ?>
          <?php foreach ($products as $product) : ?>
              <div class="product">
                  <h2><?php echo $product['name']; ?></h2>
                  <p>$<?php echo $product['price']; ?></p>
                  <img class="store-cover-image" src="<?php echo $product['cover_image']; ?>" alt="<?php echo $product['name']; ?>">
                  <a href="product.php?id=<?php echo $product['id']; ?>"><button class="view-product-button">View Product</button></a>
              </div>
          <?php endforeach; ?>
        <?php else : ?>
          <p>No results found.<p>
          <?php endif ; ?>
      </div>
    </div>
    <?php
        // show the cart if the user is logged in
        if (isset($_SESSION["userStatus"]) && $_SESSION["userStatus"] === "loggedin") {
            include 'cart.php';
        }
    ?>
  </body>
</html>
<?php 
    include 'footer.php'; 
?>
<?php 
    include 'header.php'; 
    include 'lib/database.php';
    // get product detail from database
    $db = new Database();
    $product = $db->getProduct($_GET['id']);

    //add to cart logic
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_id = $_POST['id'];
        $count = $_POST['count'];
        $db->addToCart($_SESSION['user']['id'], $product_id, $count);
    }

?>
<script>
  
  function addToCart(product_id, count) {
    if($_SESSION['userStatus'] == 'loggedin') {
      fetch('product.php', {
        method: 'POST',
        body: JSON.stringify({ product_id: product_id, count: count }),
      });
    } else {
      alert('Please login or signup to add to cart');
    }
  }
</script>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $_GET['id']; ?></title>
    <meta name="author" content="Daghan Koc">
  </head>
  <body>
    <div class="product-container">
      <h1 class="product-title"><?php echo $product['name']; ?></h1>
      <img src="<?php echo $product['cover_image']; ?>" class="product-image">
      <p><?php echo $product['description']; ?></p>
      <p><?php echo $product['price']; ?></p>
      <input type="number" name="count" value="1" id="count">
      <button onclick="addToCart(<?php echo $product['id']; ?>, <?php echo $_POST['count']; ?>)"> Add to Cart </button>
      <?php include 'reviews.php'; ?>
      <?php include 'questions.php'; ?>
    </div>
    <?php
        if ($_SESSION && $_SESSION["userStatus"] == "loggedin") {
            include 'cart.php';
        } 
    ?>
  </body>
</html>
<?php 
    include 'footer.php'; 
?>
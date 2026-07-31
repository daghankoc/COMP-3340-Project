<?php
  include 'header.php';
  require_once 'lib/database.php';

  $db = new Database();
  $productId = $_GET['id'] ?? $_POST['product_id'] ?? null;

  //get product
  $product = $db->getProduct($productId);

  //add to cart logic
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_to_cart') {
    //db call
      $db->addToCart($_SESSION['user']['id'], $_POST['id'], $_POST['count'],$_POST['chip'], $_POST['region']);
  }

  //submit question
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'submit_question') {
    //db call to add the question
    $db->addQuestion($_POST['product_id'], $_SESSION['user']['id'], $_POST['question']);
    //refresh
    header('Location: product.php?id=' . $_POST['product_id']);
    $redirectUrl = 'product.php?id=' . urlencode($productId);
    echo '<script>window.location.href = ' . json_encode($redirectUrl) . ';</script>';
  }

  //submit review
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'comment_submit') {
    //get post form variable
      $comment = $_POST['comment'];
      $rating = $_POST['rating'];
      $user_id = $_SESSION['user']['id'];

      //db call add review
      $db->addReview($_POST['product_id'], $user_id, $comment, $rating);
      
      //refresh
      $redirectUrl = 'product.php?id=' . urlencode($productId);
      echo '<script>window.location.href = ' . json_encode($redirectUrl) . ';</script>';
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $product['name']; ?></title>
    <meta name="author" content="Daghan Koc">
    <meta charset="UTF-8">
    <meta name="description" content="Product page for the store">
    <meta name="keywords" content="minipc, store, product">
    <meta name="robots" content="noindex">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <div class="product-container">
      <h1 class="product-title"><?php echo $product['name']; ?></h1>
      <a href="help-product.php">Help(Product)</a>
      <?php include 'carousal.php'; ?>
      
      <p class="product-description"><?php echo $product['description']; ?></p>
      <p>Price: $<?php echo $product['price']; ?></p>
      <p>Rating: <?php echo $product['rating']; ?></p>

      <?php if (
        isset($_SESSION['userStatus']) &&
        $_SESSION['userStatus'] === 'loggedin'
       ): ?>

          <form
              method="post"
              class="add-product-form"
              action="product.php?id=<?php echo $product['id']; ?>"
          >
            <fieldset>
                <legend>Choose chip</legend>
                <label><input type="radio" name="chip" value="AMD" checked required>
                    AMD
                </label>

                <label><input type="radio" name="chip" value="Intel" required>
                    Intel
                </label>
            </fieldset>

            <fieldset>
                <legend>Choose region</legend>
                <label>
                    <input type="radio" name="region" value="EU" required >
                    EU
                </label>

                <label>
                    <input
                        type="radio"
                        name="region"
                        value="NA"
                        checked
                        required
                    >
                    NA
                </label>
            </fieldset>
              <input
                  type="hidden"
                  name="id"
                  value="<?php echo $product['id']; ?>"
              >

              <label for="count">Quantity</label>

              <input
                  type="number"
                  name="count"
                  id="count"
                  value="1"
                  min="1"
                  required
              >

              <button type="submit" class="add-product-button" name="action" value="add_to_cart">
                  Add to Cart
              </button>
          </form>

      <?php else: ?>

          <p>
              Please <a href="login.php">log in</a> or
              <a href="signup.php">sign up</a> to add this product to your cart.
          </p>

      <?php endif; ?>
      <?php include 'reviews.php'; ?>
      <?php include 'questions.php'; ?>
    </div>
    <?php
        //only show cart if user is logged in
        if (isset($_SESSION['userStatus']) && $_SESSION["userStatus"] == "loggedin") {
            include 'cart.php';
        } 
    ?>
  </body>
</html>
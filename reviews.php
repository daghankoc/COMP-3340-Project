<?php 
    require_once 'lib/database.php';
    //get the reviews for the product
    $db = new Database();
    $reviews = $db->getProductReviews($_GET['id']);


    //adding a review
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $comment = $_POST['comment'];
        $rating = $_POST['rating'];
        $user_id = $_SESSION['user']['id'];
        $db->addReview($_GET['id'], $user_id, $comment, $rating);
    }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Reviews</title>
    <meta name="author" content="Daghan Koc">
    <link rel="stylesheet" href="stylesheet_light.css">
  </head>
  <body>
    <div class="reviews-container">
        <h1 class="reviews-title">Reviews</h1>
        <?php if (count($reviews) > 0) : ?>
            <?php foreach ($reviews as $review) : ?>
                <div class="review">
                    <h2><?php echo $review['comment']; ?></h2>
                    <p><?php echo $review['rating']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>0 reviews posted</p>
        <?php endif; ?>
        <?php if ($_SESSION && $_SESSION["userStatus"] == "loggedin") : ?>
            <form method="post" action="reviews.php">
                <input type="text" name="comment" placeholder="Comment">
                <input type="number" name="rating" placeholder="Rating">
                <input type="submit" value="Submit">
            </form>
        <?php else : ?>
            <p>Please login to post a review</p>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        <?php endif; ?>
    </div>
  </body>
</html>

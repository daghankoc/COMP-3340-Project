<?php 
    //get the reviews to show
    $reviews = $db->getProductReviews($productId);
?>
<div class="reviews-container">
    <h1 class="reviews-title">Reviews</h1>
    <?php if (count($reviews) > 0) : ?>
        <?php foreach ($reviews as $review) : ?>
            <div class="review">
                <p><?php echo $review['comment']; ?></h2>
                <p>Rating: <?php echo $review['rating']; ?>/5</p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>0 reviews posted</p>
    <?php endif; ?>
    <?php if (isset($_SESSION['userStatus']) && $_SESSION["userStatus"] == "loggedin") : ?>
        <form method="post" action="product.php?id=<?php echo $product['id']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
            <input type="text" name="comment" placeholder="Comment">
            <input type="number" min=0 value=5 max=5 step=1 name="rating" placeholder="Rating">
            <button type="submit" class="add-product-button" name="action" value="comment_submit">
                Submit
            </button>
        </form>
    <?php else : ?>
        <p>Please login to post a review</p>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
    <?php endif; ?>
</div>


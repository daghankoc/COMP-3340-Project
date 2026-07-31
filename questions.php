<?php
    //get the questions to show
    $questions = $db->getProductQuestions($productId);
?>
<div class="reviews-container">
    <h1 class="reviews-title">Questions</h1>
    <?php if (count($questions) > 0) : ?>
        <?php foreach ($questions as $question) : ?>
            <div class="review">
                <h2>Q: <?php echo $question['question']; ?></h2>
                <?php if ($question['answer'] != NULL) : ?>
                    <p>A: <?php echo $question['answer']; ?></p>
                <?php else: ?>
                    <p>Not answered yet.</p>
                <?php endif;?>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>0 questions posted</p>
    <?php endif; ?>
    <?php if (isset($_SESSION['userStatus']) && $_SESSION["userStatus"] == "loggedin") : ?>
        <form method="post" action="product.php?id=<?php echo $product['id']; ?>" >
            <h2>Submit your question</h2>
            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
            <input type="text" name="question" placeholder="Question">
            <button type="submit" class="add-product-button" name="action" value="submit_question">
                Submit
            </button>
        </form>
    <?php else : ?>
        <p>Please login to ask a question</p>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
    <?php endif; ?>
</div>

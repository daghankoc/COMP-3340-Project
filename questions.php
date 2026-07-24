<?php 
    require_once 'lib/database.php';

    //get the questions for the product
    $db = new Database();
    $questions = $db->getProductQuestions($_GET['id']);

    //ask a question(by user)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $question = $_POST['question'];
        $user_id = $_SESSION['user']['id'];
        $db->addQuestion($_GET['id'], $user_id, $question);
    }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Questions</title>
    <meta name="author" content="Daghan Koc">
    <link rel="stylesheet" href="stylesheet_light.css">
  </head>
  <body>
    <div class="reviews-container">
        <h1 class="reviews-title">Questions</h1>
        <?php if (count($reviews) > 0) : ?>
            <?php foreach ($reviews as $review) : ?>
                <div class="review">
                    <h2><?php echo $question['question']; ?></h2>
                    <p><?php echo $question['answer']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>0 questions posted</p>
        <?php endif; ?>
        <?php if ($_SESSION && $_SESSION["userStatus"] == "loggedin") : ?>
            <form method="post" action="questions.php">
                <input type="text" name="question" placeholder="Question">
                <input type="submit" value="Submit">
            </form>
        <?php else : ?>
            <p>Please login to ask a question</p>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        <?php endif; ?>
    </div>
  </body>
</html>

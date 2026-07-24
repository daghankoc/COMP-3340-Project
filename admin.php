<?php 
    include 'header.php'; 
    include 'lib/database.php';
    $db = new Database();

    //get everything to show a dashboard to admin
    
    $orders = $db->getAllOrders();
    $products = $db->getProducts();
    $users = $db->getUsers();
    $questions = $db->getAllQuestions();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Admin</title>
    <meta name="author" content="Daghan Koc">
  </head>
  <body>
    <h1>Admin</h1>
    <h2>Products</h2>
    <ul>
        <?php foreach ($products as $product) : ?>
            <li><?php echo $product['name']; ?></li>
        <?php endforeach; ?>
    </ul>
    <h2>Users</h2>
    <ul>
        <?php foreach ($users as $user) : ?>
            <li><?php echo $user['username']; ?></li>
        <?php endforeach; ?>
    </ul>
    <h2>Orders</h2>
    <ul>
        <?php foreach ($orders as $order) : ?>
            <li><?php echo $order['order_id']; ?></li>
        <?php endforeach; ?>
    </ul>
    <h2>Questions Received</h2>
    <ul>
        <?php foreach ($questions as $question) : ?>
            <li><?php echo $question['question']; ?></li>
            <li><?php echo $question['answer']; ?></li>
        <?php endforeach; ?>
    </ul>  
  </body>
</html>

<?php 
    include 'footer.php'; 
?>
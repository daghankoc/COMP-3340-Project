<?php 
    include 'header.php'; 
    include 'lib/database.php';
    $db = new Database();

    //get everything to show a dashboard to admin
    $orders = $db->getAllOrders();
    $products = $db->getProducts();
    $users = $db->getUsers();
    $questions = $db->getAllQuestions();

    //auth check
    if ($_SESSION['user']['role'] !== 'admin') {
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }

    //disable user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['disable_user'])) {

        //db call    
        $db->disableUser($_POST['user_id']);
        
        //reload
        $users = $db->getUsers();
    }

    //answer question
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer_question'])) {
        //get the form post variables
        $questionId = $_POST['question_id'];
        $answer = $_POST['answer'];

        //db call
        $db->postQuestionAnswer($questionId, $answer);

        // reload
        $questions = $db->getAllQuestions();
    }

    //process order
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_order'])) {

        //get the form post variables
        $orderId = $_POST['order_id'];

        //db call
        $db->processOrder($orderId);

        // reload
        $orders = $db->getAllOrders();
    }

    //delete product
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {

        //get the form post variables
        $productId = $_POST['product_id'];

        //db call
        $db->deleteProduct($productId);

        // reload
        $products = $db->getProducts();
    }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Admin</title>
    <meta charset="UTF-8">
    <meta name="author" content="Daghan Koc">
    <meta name="description" content="Admin page for the store">
    <meta name="keywords" content="minipc, store, admin">
    <meta name="robots" content="noindex">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <div class="admin-header-container">
        <h1>Admin</h1>

        <a href="monitor.php">Go to Monitor</a>
        <a href="help-admin.php">Help(Admin)</a>

        <form method="post" action="admin.php">
            <label>
                <input type="radio" name="theme" value="light" <?php echo $currentTheme === 'light' ? 'checked' : ''; ?>>Light
            </label>

            <label>
                <input type="radio" name="theme" value="red" <?php echo $currentTheme === 'red' ? 'checked' : ''; ?>>Red
            </label>

            <label>
                <input type="radio" name="theme" value="green" <?php echo $currentTheme === 'green' ? 'checked' : ''; ?>>Green
            </label>

            <button type="submit" name="select_theme" value="1">
                Apply Theme
            </button>
        </form>
    </div>
    <div class="admin-products-container">
        <h2>Products</h2>
        <a class="add-product-button" href="product-add.php">Add Product</a>
        <?php if (count($products) > 0): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Rating</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td>$<?php echo $product['price']; ?></td>
                            <td><?php echo $product['rating']; ?></td>
                            <td>
                                <a href="product-edit.php?id=<?php echo $product['id']; ?>">
                                    Edit
                                </a>
                            </td>
                            <td>

                                <form method="post" action="admin.php">
                                    <input
                                        type="hidden"
                                        name="product_id"
                                        value="<?php echo $product['id']; ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="delete_product"
                                        value="1"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
    <div class="admin-users-container">
        <h2>Users</h2>
        <?php if (count($users) > 0): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td>
                                <?php echo $user['active'] ? 'Yes' : 'No'; ?>
                            </td>
                            <td>
                                <?php if ($user['active']): ?>
                                    <form method="post" action="admin.php">
                                        <input
                                            type="hidden"
                                            name="user_id"
                                            value="<?php echo $user['id']; ?>"
                                        >

                                        <button
                                            type="submit"
                                            name="disable_user"
                                            value="1"
                                        >
                                            Disable
                                        </button>
                                    </form>
                                <?php else: ?>
                                    Disabled
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>
    </div>
    <div class="admin-orders-container">
        <h2>Orders</h2>
        <ul>
            <?php if (count($orders) > 0): ?>
                <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td>$<?php echo $order['total_price']; ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <?php if ($order['status'] === 'pending'): ?>
                                    <form method="post" action="admin.php">
                                        <input
                                            type="hidden"
                                            name="order_id"
                                            value="<?php echo $order['id']; ?>"
                                        >

                                        <button
                                            type="submit"
                                            name="process_order"
                                            value="1"
                                        >
                                            Process
                                        </button>
                                    </form>
                                <?php else: ?>
                                    No action
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No orders yet received.<p>
            <?php endif; ?>
        </ul>
    </div>
    <div class="admin-questions-container">
        <h2>Questions Received</h2>
            <?php if (count($questions) > 0): ?>
                <?php foreach ($questions as $question) : ?>
                    <li>Question: <?php echo $question['question']; ?></li>
                    <?php if ($question['answer'] !== null): ?>
                        <p>
                            Answer:
                            <?php echo $question['answer']; ?>
                        </p>
                    <?php else: ?>
                        <form method="post" action="admin.php">
                            <input
                                type="hidden"
                                name="question_id"
                                value="<?php echo $question['id']; ?>"
                            >

                            <label for="answer-<?php echo $question['id']; ?>">
                                Answer
                            </label>

                            <textarea
                                id="answer-<?php echo $question['id']; ?>"
                                name="answer"
                                placeholder="Enter an answer"
                                required
                            ></textarea>

                            <button type="submit" class="add-product-button" name="answer_question" value="1">
                                Submit Answer
                            </button>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No questions yet asked.<p>
            <?php endif; ?>
    </div>
  </body>
</html>

<?php 
    include 'footer.php'; 
?>
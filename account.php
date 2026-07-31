<?php 
    include 'header.php'; 
    include 'lib/database.php';
    
    //get user orders so they view history and track
    $db = new Database();

    //get user's order
    $orders = $db->getUserOrders();

    //auth check
    if( !isset($_SESSION['user']['role']) || !in_array($_SESSION['user']['role'], ['user', 'admin'], true)) {
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }

    ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Account</title>
    <meta charset="UTF-8">
    <meta name="author" content="Daghan Koc">
    <meta name="description" content="Account page for the store">
    <meta name="keywords" content="minipc, store, account">
    <meta name="robots" content="noindex">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <div class="account-container">
        <h1>Account</h1>
        <h2>Orders</h2>
        <a href="help-user.php">Help(User)</a>
        <?php if (count($orders) > 0): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td>$<?php echo $order['total_price']; ?></td>
                            <td><?php echo $order['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders yet.</p>
        <?php endif; ?>
    </div>
  </body>
  <?php include 'cart.php'; ?>
</html>

<?php 
    include 'footer.php'; 
?>
<?php
class Database {

    //connection instance
    private $pdo;

    public function __construct() {
        try {
            //local db config
            $host = "db";               
            $dbname = "comp3340_store";
            $username = "appuser"; 
            $password = "apppassword";

            //myweb connection details
            //$host = "localhost";               
            //$dbname = "kocd_db";
            //$username = "kocd_user";

            //connection
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

    }
    //db calls for different tables with the connection of the class
    public function getProducts() {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //get user's orders
    public function getUserOrders() {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->execute([$_SESSION["user"]["id"]]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //get all orders for admin
    public function getAllOrders() {
        $stmt = $this->pdo->prepare("SELECT * FROM orders");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //get all user with role user for admin
    public function getUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = 'user'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //get shopping cart items
    public function getCartItems($userId) {
        $stmt = $this->pdo->prepare("SELECT shopping_cart.id AS cart_id, shopping_cart.product_id, shopping_cart.count, shopping_cart.chip,shopping_cart.region, products.name, products.price, products.cover_image
            FROM shopping_cart
            INNER JOIN products
                ON shopping_cart.product_id = products.id
            WHERE shopping_cart.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //add to cart function
    public function addToCart($user_id, $product_id, $count, $chip, $region) {
        $count = max(1, (int) $count);

        $stmt = $this->pdo->prepare("INSERT INTO shopping_cart (user_id, product_id, count, chip, region) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE count = count + VALUES(count)");
        $stmt->execute([$user_id, $product_id, $count, $chip, $region]);
    }

    //clear cart
    public function clearCart($userId) {
        $stmt = $this->pdo->prepare(" DELETE FROM shopping_cart WHERE user_id = ?");
        $stmt->execute([$userId]);
    }

    //create order
    public function createOrder($userId, $items)
    {
        $totalPrice = 0;

        //calculate total price
        foreach ($items as $item) {
            $totalPrice += $item['price'] * $item['count'];
        }

        //create order
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id,total_price) VALUES (?, ?)");

        $stmt->execute([$userId, $totalPrice]);

        //get the last insertions id
        $orderId = $this->pdo->lastInsertId();

        //use the newly created order id to create order items and for the order
        $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id,quantity,price,chip,region) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($items as $item) {
            $stmt->execute([$orderId, $item['product_id'], $item['count'], $item['price'], $item['chip'],$item['region']]);
        }
        return $orderId;
    }
    

    //get user with matching username and password
    public function getUser($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //search product titles only for the received search keyword
    public function searchProducts($search) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE name LIKE ?");
        $stmt->execute(["%$search%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //get product
    public function getProduct($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    //adding product visuals for admin
    public function addProductVisuals($productId, $visuals) {
        $stmt = $this->pdo->prepare("INSERT INTO product_visuals (product_id, src, type) VALUES (?, ?, ?)");

        //insert for each visual
        foreach ($visuals as $visual) {
            $stmt->execute([$productId, $visual['src'], $visual['type']]);
        }
    }

    //deleting product visual for ediiting the product
    public function deleteProductVisual($visualId, $productId) {
        $stmt = $this->pdo->prepare("DELETE FROM product_visuals WHERE id = ? AND product_id = ?");
        $stmt->execute([ $visualId, $productId]);
    }

    //update the product 
    public function updateProduct($id, $name, $description, $price, $coverImage) {
        $stmt = $this->pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, cover_image = ? WHERE id = ?");
        $stmt->execute([$name,$description, $price, $coverImage, $id]);
    }

    //return product visual
    public function getProductVisuals($id) {
        $stmt = $this->pdo->prepare("SELECT id,src,type FROM product_visuals WHERE product_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // reviews system
    public function getProductReviews($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reviews WHERE product_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //add review for product
    public function addReview($product_id, $user_id, $comment, $rating) {
        //insert the review
        $stmt = $this->pdo->prepare("INSERT INTO reviews (product_id, user_id, comment, rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$product_id, $user_id, $comment, $rating]);

        //update product reviews by using sql math
        $stmt = $this->pdo->prepare("UPDATE products SET rating = (SELECT ROUND(AVG(rating)) FROM reviews WHERE product_id = ?) WHERE id = ?");
        $stmt->execute([$product_id, $product_id]);
    }

    // questions system
    public function getAllQuestions() {
        $stmt = $this->pdo->prepare("SELECT * FROM questions");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //post an answer for admin
    public function postQuestionAnswer($question_id, $answer) {
        $stmt = $this->pdo->prepare("UPDATE questions SET answer = ? WHERE id = ?");
        $stmt->execute([$answer, $question_id]);
    }

    //get a product's questions
    public function getProductQuestions($product_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE product_id = ?");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //add question to a product
    public function addQuestion($product_id, $user_id, $question) {
        $stmt = $this->pdo->prepare("INSERT INTO questions (product_id, user_id, question) VALUES (?, ?, ?)");
        $stmt->execute([$product_id, $user_id, $question]);
    }

    //process the order by admin
    public function processOrder($orderId) {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = 'shipped' WHERE id = ?");
        $stmt->execute([$orderId]);
    }

    //db healthcheck
    public function healthCheck(){
        $stmt = $this->pdo->prepare("SELECT 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //signup user
    public function signupUser($username, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
    }

    //admin disable user
    public function disableUser($userId) {
        $stmt = $this->pdo->prepare("UPDATE users SET active = FALSE WHERE id = ?");
        $stmt->execute([$userId]);
    }

    //delete product for admin
    public function deleteProduct($product_id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
    }

    //add product for admin
    public function addProduct($name, $description, $price, $coverImage, $visuals) {
        $stmt = $this->pdo->prepare("INSERT INTO products (name,description,price,cover_image) VALUES (?, ?, ?, ?)");

        //execute the main product sql
        $stmt->execute([$name, $description, $price, $coverImage]);

        //use last insert id to get the last insert
        $productId = $this->pdo->lastInsertId();

        //insert the visuals with the newly products id
        $visualStmt = $this->pdo->prepare("INSERT INTO product_visuals (product_id,src,type) VALUES (?, ?, ?)");

        //execute visual upload with each visual
        foreach ($visuals as $visual) {
            $visualStmt->execute([$productId, $visual['src'], $visual['type']]);
        }
        return $productId;
    }
}
?>
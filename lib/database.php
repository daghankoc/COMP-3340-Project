<?php
class Database {

    //connection instance
    private $pdo;

    public function __construct() {
        try {
            //db config
            $host = "db";               
            $dbname = "comp3340_store";
            $username = "appuser"; 
            $password = "apppassword";
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
    
    public function getUserOrders() {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->execute([$_SESSION["user"]["id"]]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = 'user'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders() {
        $stmt = $this->pdo->prepare("SELECT * FROM orders");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCartItems() {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND status = 'pending'");
        $stmt->execute([$_SESSION["user"]["id"]]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUser($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function searchProducts($search) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
        $stmt->execute(["%$search%", "%$search%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProduct($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addToCart($user_id, $product_id, $count) {
        $stmt = $this->pdo->prepare("INSERT INTO shopping_cart (user_id, product_id, count) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $count]);
    }

    // reviews system
    public function getProductReviews($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reviews WHERE product_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addReview($product_id, $user_id, $comment, $rating) {
        $stmt = $this->pdo->prepare("INSERT INTO reviews (product_id, user_id, comment, rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$product_id, $user_id, $comment, $rating]);
    }

    // questions system
    public function getAllQuestions() {
        $stmt = $this->pdo->prepare("SELECT * FROM questions");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function postQuestionAnswer($question_id, $answer) {
        $stmt = $this->pdo->prepare("UPDATE questions SET answer = ? WHERE id = ?");
        $stmt->execute([$answer, $question_id]);
    }
    public function getProductQuestions($product_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE product_id = ?");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addQuestion($product_id, $user_id, $question) {
        $stmt = $this->pdo->prepare("INSERT INTO questions (product_id, user_id, question) VALUES (?, ?, ?)");
        $stmt->execute([$product_id, $user_id, $question]);
    }

    //signup and login system
    public function signupUser($username, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
    }
}
?>
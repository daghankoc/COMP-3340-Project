# PHP CSS HTML COMP 3340 Project

This is the store php project for the COMP 3340.

Database connection config is in the database lib php file. Seed and table sql is in the docker folder as seed.sql.

Product images and videos are in the prod-asset-data of the submitted zip folder. I ignored them for git. I used the platform the add the products one by one from the admin panel.

test admin login: testadmin
password: password12345

Github: https://github.com/daghankoc/COMP-3340-Project

Live Link: https://kocd.myweb.cs.uwindsor.ca/comp3340-project/index.php

# Local installation

1. Start a mysql db
2. replace the cofig in the lib/database.php file
3. run the seed on the db
4. run the php server index.php is the main store page

# Database Design

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'user',
  active BOOLEAN NOT NULL DEFAULT TRUE
);
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,
  cover_image VARCHAR(255) NOT NULL,
  rating INT(5) NOT NULL DEFAULT 3
);

CREATE TABLE shopping_cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  count INT NOT NULL DEFAULT 1,
  chip ENUM('AMD', 'Intel') NOT NULL,
  region ENUM('EU', 'NA') NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id),

  UNIQUE KEY unique_cart_product (user_id, product_id, chip, region)
);



CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id),
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  rating INT(5) NOT NULL DEFAULT 0,
  comment TEXT NOT NULL
);

CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id),
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  question TEXT NOT NULL,
  answer TEXT DEFAULT NULL
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  total_price DECIMAL(10, 2) NOT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'pending'
);
  
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  product_id INT NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id),
  quantity INT NOT NULL DEFAULT 1,
  price DECIMAL(10, 2) NOT NULL,
  chip ENUM('AMD', 'Intel') NOT NULL,
  region ENUM('EU', 'NA') NOT NULL,

  UNIQUE (order_id, product_id, chip, region)
);


CREATE TABLE product_visuals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  src VARCHAR(255) NOT NULL,
  type ENUM('image', 'video') NOT NULL,

  FOREIGN KEY (product_id)
    REFERENCES products(id)
    ON DELETE CASCADE
);

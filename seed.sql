CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'user'
);
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,
  cover_image VARCHAR(255) NOT NULL,
  rating INT(5) NOT NULL DEFAULT 0
);

CREATE TABLE shopping_cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  count INT NOT NULL DEFAULT 1,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
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
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id),
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  total_price DECIMAL(10, 2) NOT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'pending'
);

INSERT INTO users (username, password) VALUES ('testuser', 'password12345');
INSERT INTO users (username, password, role) VALUES ('testadmin', 'password12345', 'admin');

INSERT INTO products (name, description, price, cover_image, rating) VALUES
  ('Product 1', 'Good Product 1', 9.99, './images/product.jpg', 3),
  ('Product 2', 'Good Product', 19.99, './images/product.jpg', 4);
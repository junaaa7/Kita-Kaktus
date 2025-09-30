-- Buat database
CREATE DATABASE kita_kaktus_db;
USE kita_kaktus_db;

-- Tabel admins
CREATE TABLE admins (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel users
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(225) NOT NULL,
    role ENUM('user','admin') NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel product
CREATE TABLE product (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT(11) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel products
CREATE TABLE products (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT(11) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel orders
CREATE TABLE orders (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending','paid','shipped') NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel order_items
CREATE TABLE order_items (
    id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    quantity INT(11) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO products (name, description, price, image, stock) VALUES
('Kaktus Mini', 'Kaktus kecil perawatan mudah, cocok untuk hiasan meja.', 25000, 'images/kaktus1.jpg', 10),
('Kaktus Bulat', 'Kaktus unik dengan bentuk bulat, tahan lama.', 35000, 'images/kaktus2.jpg', 8),
('Kaktus Bunga', 'Kaktus indah dengan bunga warna-warni.', 50000, 'images/kaktus3.jpg', 5),
('Kaktus Hias Meja', 'Kaktus mini lucu cocok untuk dekorasi kantor.', 20000, 'images/kaktus4.jpg', 20);
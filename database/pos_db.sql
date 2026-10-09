-- IT0049 Midterm Project: The Complete Point-of-Sale System
-- Fresh local setup. Passwords begin as locked, unusable markers; initialize them privately with:
-- php spark auth:set-password --all

CREATE DATABASE IF NOT EXISTS pos_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE pos_db;

DROP TABLE IF EXISTS sales;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS users;

CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    is_archived TINYINT(1) NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    is_archived TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    avatar VARCHAR(255) NULL,
    password VARCHAR(255) NOT NULL,
    is_archived TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL
);

CREATE TABLE sales (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    customer_id INT NULL,
    sold_by INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at DATETIME NOT NULL,
    CONSTRAINT sales_product_id_foreign FOREIGN KEY (product_id) REFERENCES products(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT sales_customer_id_foreign FOREIGN KEY (customer_id) REFERENCES customers(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT sales_sold_by_foreign FOREIGN KEY (sold_by) REFERENCES users(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);

INSERT INTO products (name, price, stock_quantity, is_archived, image, created_at) VALUES
    ('Arabica Coffee Beans', 425.00, 24, 0, NULL, '2026-10-01 09:00:00'),
    ('Ceramic Pour-Over Set', 780.00, 12, 0, NULL, '2026-10-01 09:15:00'),
    ('Insulated Travel Tumbler', 650.00, 18, 0, NULL, '2026-10-01 09:30:00'),
    ('Cold Brew Bottle', 520.00, 8, 0, NULL, '2026-10-01 09:45:00'),
    ('Reusable Filter Pack', 195.00, 30, 0, NULL, '2026-10-01 10:00:00');

INSERT INTO customers (full_name, email, phone, is_archived, created_at) VALUES
    ('Angela Reyes', 'angela.reyes@example.com', '+63 917 245 8103', 0, '2026-09-01 09:15:00'),
    ('Marco Villanueva', 'marco.villanueva@example.com', '+63 918 632 4751', 0, '2026-09-02 10:30:00'),
    ('Sofia Mendoza', 'sofia.mendoza@example.com', '+63 905 381 9264', 0, '2026-09-03 11:45:00'),
    ('Daniel Lim', 'daniel.lim@example.com', '+63 922 714 5386', 0, '2026-09-04 13:20:00'),
    ('Bianca Santos', 'bianca.santos@example.com', '+63 916 849 2075', 0, '2026-09-05 15:10:00');

INSERT INTO users (username, full_name, avatar, password, is_archived, created_at) VALUES
    ('acruz', 'Andrea Cruz', NULL, '!password-not-initialized!', 0, '2026-09-01 08:00:00'),
    ('jnavarro', 'Joshua Navarro', NULL, '!password-not-initialized!', 0, '2026-09-02 08:30:00'),
    ('mpascual', 'Mikaela Pascual', NULL, '!password-not-initialized!', 0, '2026-09-03 09:00:00'),
    ('rgonzales', 'Rafael Gonzales', NULL, '!password-not-initialized!', 0, '2026-09-04 09:30:00'),
    ('tgarcia', 'Trisha Garcia', NULL, '!password-not-initialized!', 0, '2026-09-05 10:00:00');

-- IT0049 Technical Formative Assessment 2
-- Recreates the POS database tables and their sample records.

CREATE DATABASE IF NOT EXISTS pos_db;
USE pos_db;

DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at DATETIME NOT NULL
);

INSERT INTO customers (full_name, email, phone, created_at) VALUES
    ('Angela Reyes', 'angela.reyes@example.com', '+63 917 245 8103', '2026-09-01 09:15:00'),
    ('Marco Villanueva', 'marco.villanueva@example.com', '+63 918 632 4751', '2026-09-02 10:30:00'),
    ('Sofia Mendoza', 'sofia.mendoza@example.com', '+63 905 381 9264', '2026-09-03 11:45:00'),
    ('Daniel Lim', 'daniel.lim@example.com', '+63 922 714 5386', '2026-09-04 13:20:00'),
    ('Bianca Santos', 'bianca.santos@example.com', '+63 916 849 2075', '2026-09-05 15:10:00');

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL
);

INSERT INTO users (username, full_name, created_at) VALUES
    ('acruz', 'Andrea Cruz', '2026-09-01 08:00:00'),
    ('jnavarro', 'Joshua Navarro', '2026-09-02 08:30:00'),
    ('mpascual', 'Mikaela Pascual', '2026-09-03 09:00:00'),
    ('rgonzales', 'Rafael Gonzales', '2026-09-04 09:30:00'),
    ('tgarcia', 'Trisha Garcia', '2026-09-05 10:00:00');

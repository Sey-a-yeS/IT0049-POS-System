-- IT0049 Technical Summative Assessment 1
-- Tasks for Today Management System database setup

CREATE DATABASE IF NOT EXISTS tasks_today_db;
USE tasks_today_db;

DROP TABLE IF EXISTS tasks;
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    task_date DATE NOT NULL,
    created_at DATETIME NOT NULL
);

INSERT INTO tasks (title, status, task_date, created_at) VALUES
    ('Review Web Systems lecture notes', 'completed', DATE_SUB(CURDATE(), INTERVAL 1 DAY), DATE_ADD(DATE_SUB(CURDATE(), INTERVAL 2 DAY), INTERVAL 9 HOUR)),
    ('Organize CodeIgniter reference materials', 'completed', DATE_SUB(CURDATE(), INTERVAL 1 DAY), DATE_ADD(DATE_SUB(CURDATE(), INTERVAL 2 DAY), INTERVAL 10 HOUR)),
    ('Complete the database integration exercise', 'in_progress', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 HOUR)),
    ('Attend the Web System Technologies lecture', 'pending', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 8 HOUR)),
    ('Review the TSA1 requirements', 'completed', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 9 HOUR)),
    ('Test the Tasks for Today pages', 'pending', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 10 HOUR)),
    ('Prepare notes for the next module', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), DATE_ADD(CURDATE(), INTERVAL 11 HOUR)),
    ('Read the next CodeIgniter lesson', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), DATE_ADD(CURDATE(), INTERVAL 12 HOUR)),
    ('Plan the next set of weekly priorities', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), DATE_ADD(CURDATE(), INTERVAL 13 HOUR));

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL
);

INSERT INTO users (username, full_name, email, created_at) VALUES
    ('isaiahvicencio', 'Isaiah Ezekiel P. Vicencio', 'isaiah.vicencio@example.com', DATE_ADD(CURDATE(), INTERVAL 8 HOUR));

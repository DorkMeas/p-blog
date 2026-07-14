CREATE DATABASE pblog_db;
USE pblog_db;

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(100) DEFAULT 'General',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO posts (title, content, category) VALUES
('Welcome to Demo Blog', 'This is a simple blog built with Pure PHP, Bootstrap, AngularJS and MySQL.', 'General'),
('PHP & MySQL Tutorial', 'Learn how to build a basic CMS with PHP.', 'Tutorial'),
('Responsive Design Tips', 'Using Bootstrap 5 to make beautiful responsive websites.', 'Design');

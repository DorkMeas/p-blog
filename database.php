<?php

$host     = "localhost";
$port     = 3306;
$dbname   = "pblog_db";
$charset  = "utf8mb4";
$username = "root";
$password = "Admin#MySQL@123";

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function getAllPosts(PDO $pdo)
{
    $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

function getPostById(PDO $pdo, int $id)
{
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    return $post ?: null;
}

function getCategories(PDO $pdo)
{
    $stmt = $pdo->query("SELECT DISTINCT category FROM posts ORDER BY category ASC");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function createPost(PDO $pdo, string $title, string $content, string $category = 'General')
{
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, category) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $category]);
    return (int)$pdo->lastInsertId();
}

function updatePost(PDO $pdo, int $id, string $title, string $content, string $category)
{
    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, category = ? WHERE id = ?");
    return $stmt->execute([$title, $content, $category, $id]);
}

function deletePost(PDO $pdo, int $id)
{
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    return $stmt->execute([$id]);
}

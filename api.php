<?php
require_once 'database.php';
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $posts = getAllPosts($pdo);
    echo json_encode($posts);
} 
else if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = createPost($pdo, $data['title'], $data['content'], $data['category'] ?? 'General');
    echo json_encode(['success' => true, 'id' => $id]);
} 
else if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $success = updatePost($pdo, $data['id'], $data['title'], $data['content'], $data['category'] ?? 'General');
    echo json_encode(['success' => $success]);
} 
else if ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $success = deletePost($pdo, $id);
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false]);
    }
}

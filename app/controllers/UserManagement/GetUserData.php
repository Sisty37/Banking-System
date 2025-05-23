<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

require_once __DIR__ . '/../../models/UserModel.php';

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $userModel = new UserModel();
    $user = $userModel->getUserById($userId);
    
    if ($user) {
        header('Content-Type: application/json');
        echo json_encode($user);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'User not found']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid user ID']);
}
?>

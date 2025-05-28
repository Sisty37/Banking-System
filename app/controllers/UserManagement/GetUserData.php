<?php
session_start();
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}
<<<<<<< HEAD
require_once __DIR__ . '/../../models/UserModel.php';
=======

require_once __DIR__ . '/../../models/UserModel.php';

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $userModel = new UserModel();
    $user = $userModel->getUserById($userId);
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
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
<<<<<<< HEAD
?> 
=======
?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

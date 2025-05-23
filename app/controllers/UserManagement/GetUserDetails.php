<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    echo '<div class="alert alert-danger">Unauthorized
    echo '<div class="alert alert-danger">Unauthorized access</div>';
    exit;
}

require_once __DIR__ . '/../../models/UserModel.php';

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $userModel = new UserModel();
    $user = $userModel->getUserById($userId);
    
    if ($user) {
        // Format the output
        $html = '<div class="user-details">';
        $html .= '<div class="row mb-3">';
        $html .= '<div class="col-md-4 fw-bold">ID:</div>';
        $html .= '<div class="col-md-8">' . htmlspecialchars($user['user_id']) . '</div>';
        $html .= '</div>';
        
        $html .= '<div class="row mb-3">';
        $html .= '<div class="col-md-4 fw-bold">Name:</div>';
        $html .= '<div class="col-md-8">' . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . '</div>';
        $html .= '</div>';
        
        $html .= '<div class="row mb-3">';
        $html .= '<div class="col-md-4 fw-bold">Email:</div>';
        $html .= '<div class="col-md-8">' . htmlspecialchars($user['email']) . '</div>';
        $html .= '</div>';
        
        $html .= '<div class="row mb-3">';
        $html .= '<div class="col-md-4 fw-bold">Date of Birth:</div>';
        $html .= '<div class="col-md-8">' . htmlspecialchars($user['date_of_birth']) . '</div>';
        $html .= '</div>';
        
        $html .= '<div class="row mb-3">';
        $html .= '<div class="col-md-4 fw-bold">Role:</div>';
        $html .= '<div class="col-md-8">' . htmlspecialchars($user['role_name'] ?? 'No Role') . '</div>';
        $html .= '</div>';
        
        $html .= '<div class="row mb-3">';
        $html .= '<div class="col-md-4 fw-bold">Status:</div>';
        $html .= '<div class="col-md-8">' . ($user['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>') . '</div>';
        $html .= '</div>';
        
        $html .= '<div class="row mb-3">';
        $html .= '<div class="col-md-4 fw-bold">Created:</div>';
        $html .= '<div class="col-md-8">' . htmlspecialchars(date('Y-m-d H:i:s', strtotime($user['created_at']))) . '</div>';
        $html .= '</div>';
        
        if (!empty($user['last_login'])) {
            $html .= '<div class="row mb-3">';
            $html .= '<div class="col-md-4 fw-bold">Last Login:</div>';
            $html .= '<div class="col-md-8">' . htmlspecialchars(date('Y-m-d H:i:s', strtotime($user['last_login']))) . '</div>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        echo $html;
    } else {
        echo '<div class="alert alert-warning">User not found</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid user ID</div>';
}
?> 
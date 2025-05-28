<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: ../../../app/views/UserAuthentication/Login.php");
    exit;
}
require_once __DIR__ . '/../../models/UserModel.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? '';
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $roleId = $_POST['role_id'] ?? '';
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $errors = [];
    if (empty($userId)) {
        $errors[] = "User ID is required";
    }
    if (empty($firstName)) {
        $errors[] = "First name is required";
    }
    if (empty($lastName)) {
        $errors[] = "Last name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($dob)) {
        $errors[] = "Date of birth is required";
    }
    if (empty($errors)) {
        $userModel = new UserModel();
        $result = $userModel->updateUser($userId, $firstName, $lastName, $email, $dob, $roleId, $isActive);
        if ($result['success']) {
            $_SESSION['message'] = "User updated successfully";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = $result['message'];
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = implode("<br>", $errors);
        $_SESSION['message_type'] = "danger";
    }
    header("Location: ../../../app/views/Dashboard/user_management.php");
    exit;
} else {
    header("Location: ../../../app/views/Dashboard/user_management.php");
    exit;
}
?> 
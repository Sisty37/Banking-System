<?php
session_start();
require_once __DIR__ . '/../AuthController.php';

$authController = new AuthController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    $result = $authController->register($firstName, $lastName, $email, $dob, $password, $confirmPassword);
    
    if ($result["success"]) {
        $_SESSION['success'] = $result["message"];
        header("Location: ../../../app/views/UserAuthentication/Login.php");
        exit;
    } else {
        $_SESSION['error'] = $result["message"];
        header("Location: ../../../app/views/UserAuthentication/Signup.php");
        exit;
    }
} else {
    header("Location: ../../../app/views/UserAuthentication/Signup.php");
    exit;
}
?>

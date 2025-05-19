<?php
session_start();
require_once __DIR__ . '/../../Controllers/AuthController.php';

// Create an instance of the Auth Controller
$authController = new AuthController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = $authController->login($email, $password);
    
    if ($result["success"]) {
        // Redirect to dashboard or welcome page
        header("Location: ./Welcome.php");
        exit;
    } else {
        // Redirect back to login with error message
        $_SESSION['error'] = $result["message"];
        header("Location: ../../View/UserAuthentication/Login.php");
        exit;
    }
} else {
    // If not a POST request, redirect to login page
    header("Location: ../../View/UserAuthentication/Login.php");
    exit;
}
?>

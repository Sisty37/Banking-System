<?php
session_start();
require_once __DIR__ . '/../../Controllers/AuthController.php';

// Create an instance of the Auth Controller
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
        // Set success message and redirect to login
        $_SESSION['success'] = $result["message"];
        header("Location: ../../View/UserAuthentication/Login.php");
        exit;
    } else {
        // Set error message and redirect back to signup
        $_SESSION['error'] = $result["message"];
        header("Location: ../../View/UserAuthentication/Signup.php");
        exit;
    }
} else {
    // If not a POST request, redirect to signup page
    header("Location: ../../View/UserAuthentication/Signup.php");
    exit;
}
?>

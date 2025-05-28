<?php
session_start();
require_once __DIR__ . '/../AuthController.php';
<<<<<<< HEAD
$authController = new AuthController();
=======

$authController = new AuthController();

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember_me']);
<<<<<<< HEAD
    $result = $authController->login($email, $password, $rememberMe);
=======
    
    $result = $authController->login($email, $password, $rememberMe);
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    if ($result["success"]) {
        header("Location: " . $result["redirect"]);
        exit;
    } else {
        $_SESSION['error'] = $result["message"];
        header("Location: ../../../app/views/UserAuthentication/Login.php");
        exit;
    }
} else {
    if (isset($_COOKIE['remember_user'])) {
        $cookieData = json_decode($_COOKIE['remember_user'], true);
<<<<<<< HEAD
        if ($cookieData && isset($cookieData['email']) && isset($cookieData['token'])) {
            $result = $authController->loginWithCookie($cookieData['email'], $cookieData['token']);
=======
        
        if ($cookieData && isset($cookieData['email']) && isset($cookieData['token'])) {
            $result = $authController->loginWithCookie($cookieData['email'], $cookieData['token']);
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if ($result["success"]) {
                header("Location: " . $result["redirect"]);
                exit;
            }
        }
    }
    header("Location: ../../../app/views/UserAuthentication/Login.php");
    exit;
}
?>

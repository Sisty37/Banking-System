<?php
session_start();
require_once __DIR__ . '/../AuthController.php';
$authController = new AuthController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember_me']);
    $result = $authController->login($email, $password, $rememberMe);
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
        if ($cookieData && isset($cookieData['email']) && isset($cookieData['token'])) {
            $result = $authController->loginWithCookie($cookieData['email'], $cookieData['token']);
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

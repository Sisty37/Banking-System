<?php
session_start();
require_once __DIR__ . '/../AuthController.php';
$authController = new AuthController();
setcookie('remember_user', '', time() - 3600, '/');
$result = $authController->logout();
$_SESSION['success'] = "You have been successfully logged out";
header("Location: ../../../app/views/UserAuthentication/Login.php");
exit;
?> 
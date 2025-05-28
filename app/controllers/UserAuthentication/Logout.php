<?php
session_start();
require_once __DIR__ . '/../AuthController.php';
<<<<<<< HEAD
$authController = new AuthController();
setcookie('remember_user', '', time() - 3600, '/');
$result = $authController->logout();
=======

 
$authController = new AuthController();

 
setcookie('remember_user', '', time() - 3600, '/');

 
$result = $authController->logout();
 
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
$_SESSION['success'] = "You have been successfully logged out";
header("Location: ../../../app/views/UserAuthentication/Login.php");
exit;
?> 
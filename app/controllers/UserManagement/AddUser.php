<?php
session_start();
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: ../../../app/views/UserAuthentication/Login.php");
    exit;
}
<<<<<<< HEAD
require_once __DIR__ . '/../../models/UserModel.php';
=======

require_once __DIR__ . '/../../models/UserModel.php';

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
<<<<<<< HEAD
    $roleId = $_POST['role_id'] ?? 6; 
    $errors = [];
    if (empty($firstName)) {
        $errors[] = "First name is required";
    }
    if (empty($lastName)) {
        $errors[] = "Last name is required";
    }
=======
    $roleId = $_POST['role_id'] ?? 6;
    
    $errors = [];
    
    if (empty($firstName)) {
        $errors[] = "First name is required";
    }
    
    if (empty($lastName)) {
        $errors[] = "Last name is required";
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
<<<<<<< HEAD
    if (empty($dob)) {
        $errors[] = "Date of birth is required";
    }
=======
    
    if (empty($dob)) {
        $errors[] = "Date of birth is required";
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
<<<<<<< HEAD
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    if (empty($errors)) {
        $userModel = new UserModel();
        $result = $userModel->createUser($firstName, $lastName, $email, $dob, $password, $roleId);
=======
    
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    
    if (empty($errors)) {
        $userModel = new UserModel();
        $result = $userModel->createUser($firstName, $lastName, $email, $dob, $password, $roleId);
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        if ($result['success']) {
            $_SESSION['message'] = "User created successfully";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = $result['message'];
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = implode("<br>", $errors);
        $_SESSION['message_type'] = "danger";
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    header("Location: ../../../app/views/Dashboard/user_management.php");
    exit;
} else {
    header("Location: ../../../app/views/Dashboard/user_management.php");
    exit;
}
<<<<<<< HEAD
?> 
=======
?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

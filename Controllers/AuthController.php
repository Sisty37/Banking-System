<?php
require_once __DIR__ . '/../Models/UserModel.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function login($email, $password) {
        // Validate inputs
        if (empty($email) || empty($password)) {
            return ["success" => false, "message" => "Email and password are required"];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        
        // Attempt to login
        $user = $this->userModel->login($email, $password);
        
        if ($user) {
            // Start session and store user data
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            
            return ["success" => true, "message" => "Login successful"];
        } else {
            return ["success" => false, "message" => "Invalid email or password"];
        }
    }
    
    public function register($firstName, $lastName, $email, $dob, $password, $confirmPassword) {
        // Validate inputs
        if (empty($firstName) || empty($lastName) || empty($email) || empty($dob) || empty($password) || empty($confirmPassword)) {
            return ["success" => false, "message" => "All fields are required"];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        
        if ($password !== $confirmPassword) {
            return ["success" => false, "message" => "Passwords do not match"];
        }
        
        // Password strength validation
        if (strlen($password) < 8) {
            return ["success" => false, "message" => "Password must be at least 8 characters long"];
        }
        
        // Register the user
        return $this->userModel->register($firstName, $lastName, $email, $dob, $password);
    }
    
    public function resetPassword($email, $newPassword) {
        if (empty($email) || empty($newPassword)) {
            return ["success" => false, "message" => "Email and new password are required"];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        
        if (strlen($newPassword) < 8) {
            return ["success" => false, "message" => "Password must be at least 8 characters long"];
        }
        
        $result = $this->userModel->resetPassword($email, $newPassword);
        
        if ($result) {
            return ["success" => true, "message" => "Password reset successful"];
        } else {
            return ["success" => false, "message" => "Password reset failed"];
        }
    }
    
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        
        return ["success" => true, "message" => "Logout successful"];
    }
}
?> 
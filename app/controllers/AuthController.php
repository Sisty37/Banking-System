<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../helpers/validation_helper.php';

class AuthController extends Controller {
    public function __construct() {
        // Check for remember me cookie and auto-login if not already logged in
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
            $userModel = $this->model('User');
            $user = $userModel->findByRememberToken($_COOKIE['remember_user']);
            
            if ($user) {
                // Auto-login the user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
            } else {
                // Invalid remember token, clear the cookie
                setcookie('remember_user', '', [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $errors = [];
            
            // Validate email and password
            if (empty($email) || !isValidEmail($email)) {
                $errors[] = "Invalid email format.";
            }
            
            if (empty($password)) {
                $errors[] = "Password is required.";
            }
            
            if (count($errors) > 0) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = ['email' => $email];
                header('Location: ' . APP_URL . '/login');
                exit();
            }
            
            // Check if user exists and verify password
            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);
            
            if (!$user || !password_verify($password, $user['password'])) {
                $errors[] = "Invalid email or password.";
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = ['email' => $email];
                header('Location: ' . APP_URL . '/login');
                exit();
            }
            
            // User authenticated, set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            // Handle "Remember Me" functionality
            if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                // Generate a secure remember token
                $remember_token = bin2hex(random_bytes(32));
                
                // Store the remember token in the database
                $userModel->updateRememberToken($user['id'], $remember_token);
                
                // Set remember me cookie that expires in 30 days
                setcookie(
                    'remember_user',
                    $remember_token,
                    [
                        'expires' => time() + (30 * 24 * 60 * 60),
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'Strict'
                    ]
                );
            }
            
            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: ' . APP_URL . '/admin');
            } else {
                header('Location: ' . APP_URL . '/dashboard');
            }
            exit();
        } else {
            // Display login form
            $this->view('auth/login');
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $dob = $_POST['dob'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $errors = [];

            // Validation
            if (empty($firstName) || !isValidName($firstName)) {
                $errors[] = "First Name is invalid or empty.";
            }
            if (empty($lastName) || !isValidName($lastName)) {
                $errors[] = "Last Name is invalid or empty.";
            }
            if (empty($email) || !isValidEmail($email)) {
                $errors[] = "Invalid email format.";
            }
            
            // Check if email already exists in DB
            $userModel = $this->model('User');
            if ($userModel->findByEmail($email)) {
                $errors[] = "Email already registered.";
            }

            if (empty($dob) || !isValidDateOfBirth($dob)) {
                $errors[] = "Invalid date of birth.";
            }
            if (empty($password) || strlen($password) < 8 || !hasStrongPassword($password)) {
                $errors[] = "Password must be at least 8 characters, with uppercase, lowercase, number, and special character.";
            }
            if ($password !== $confirmPassword) {
                $errors[] = "Passwords do not match.";
            }

            if (count($errors) > 0) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = $_POST;
                header('Location: ' . APP_URL . '/register');
                exit();
            }

            // If validation passes, process registration
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if ($userModel->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'date_of_birth' => $dob,
                'password' => $hashedPassword,
                'role' => 'user'
            ])) {
                // Registration successful
                $this->setFlashMessage('success', "Registration successful! Please login.");
                header('Location: ' . APP_URL . '/login');
                exit();
            } else {
                $errors[] = "Registration failed. Please try again.";
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = $_POST;
                header('Location: ' . APP_URL . '/register');
                exit();
            }
        } else {
            // Display the registration form
            $this->view('auth/register');
        }
    }
    
    public function logout() {
        // Clear remember token in database if user is logged in
        if (isset($_SESSION['user_id'])) {
            $userModel = $this->model('User');
            $userModel->updateRememberToken($_SESSION['user_id'], null);
        }

        // Clear remember me cookie
        setcookie('remember_user', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        // Destroy session and redirect to home
        session_unset();
        session_destroy();
        
        // Start a new session for flash messages
        session_start();
        $this->setFlashMessage('success', 'You have been logged out successfully.');
        
        header('Location: ' . APP_URL . '/');
        exit();
    }
    
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            $errors = [];
            
            if (empty($email) || !isValidEmail($email)) {
                $errors[] = "Invalid email format.";
            }
            
            if (count($errors) > 0) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = ['email' => $email];
                header('Location: ' . APP_URL . '/forgot-password');
                exit();
            }
            
            // Check if user exists
            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);
            
            if (!$user) {
                // For security, don't reveal that the email doesn't exist
                $errors[] = "We couldn't find an account with that email address.";
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = ['email' => $email];
                header('Location: ' . APP_URL . '/forgot-password');
                exit();
            }
            
            // If the email exists, set session variables to show the password reset form
            $_SESSION['email_verified'] = true;
            $_SESSION['verified_email'] = $email;
            
            // Redirect back to the forgot password page
            header('Location: ' . APP_URL . '/forgot-password');
            exit();
        } else {
            // Display forgot password form
            $this->view('auth/forgot_password');
        }
    }
    
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            $errors = [];
            
            // Validate inputs
            if (empty($email) || !isValidEmail($email)) {
                $errors[] = "Invalid email address.";
            }
            
            if (empty($password) || strlen($password) < 8 || !hasStrongPassword($password)) {
                $errors[] = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character.";
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = "Passwords do not match.";
            }
            
            if (count($errors) > 0) {
                $_SESSION['errors'] = $errors;
                $_SESSION['email_verified'] = true;
                $_SESSION['verified_email'] = $email;
                header('Location: ' . APP_URL . '/forgot-password');
                exit();
            }
            
            // Check if user exists
            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);
            
            if (!$user) {
                $errors[] = "We couldn't find an account with that email address.";
                $_SESSION['errors'] = $errors;
                header('Location: ' . APP_URL . '/forgot-password');
                exit();
            }
            
            // Hash the new password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Update the password in the database
            if ($userModel->updatePassword($user['id'], $hashedPassword)) {
                $this->setFlashMessage('success', "Your password has been reset successfully. Please login with your new password.");
                header('Location: ' . APP_URL . '/login');
                exit();
            } else {
                $errors[] = "Failed to update password. Please try again.";
                $_SESSION['errors'] = $errors;
                $_SESSION['email_verified'] = true;
                $_SESSION['verified_email'] = $email;
                header('Location: ' . APP_URL . '/forgot-password');
                exit();
            }
        } else {
            // Redirect to forgot password page if accessed directly
            header('Location: ' . APP_URL . '/forgot-password');
            exit();
        }
    }
}
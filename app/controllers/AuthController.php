<?php
require_once __DIR__ . '/../Models/UserModel.php';
<<<<<<< HEAD
class AuthController {
    private $userModel;
    public function __construct() {
        $this->userModel = new UserModel();
    }
=======

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function login($email, $password, $rememberMe = false) {
        if (empty($email) || empty($password)) {
            return ["success" => false, "message" => "Email and password are required"];
        }
<<<<<<< HEAD
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        $user = $this->userModel->login($email, $password);
=======
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        
        $user = $this->userModel->login($email, $password);
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        if ($user) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
<<<<<<< HEAD
            $_SESSION['role'] = $user['role_name'] ?? 'Customer'; 
            if ($rememberMe) {
                $this->setRememberMeCookie($user['email'], 30); 
            } else {
                $this->setRememberMeCookie($user['email'], 7); 
            }
            ini_set('session.gc_maxlifetime', 86400); 
            session_set_cookie_params(86400); 
            $dashboardPath = $this->getDashboardPathByRole($_SESSION['role']);
=======
            $_SESSION['role'] = $user['role_name'] ?? 'Customer';
            
            if ($rememberMe) {
                $this->setRememberMeCookie($user['email'], 30);
            } else {
                $this->setRememberMeCookie($user['email'], 7);
            }
            
            ini_set('session.gc_maxlifetime', 86400);
            session_set_cookie_params(86400);
            
            $dashboardPath = $this->getDashboardPathByRole($_SESSION['role']);
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return [
                "success" => true, 
                "message" => "Login successful", 
                "redirect" => $dashboardPath
            ];
        } else {
            return ["success" => false, "message" => "Invalid email or password"];
        }
    }
<<<<<<< HEAD
    public function loginWithCookie($email, $token) {
        $user = $this->userModel->getUserByEmail($email);
        if (!$user) {
            return ["success" => false, "message" => "Invalid cookie"];
        }
        $expectedToken = hash('sha256', $user['email'] . $user['password'] . $_SERVER['HTTP_USER_AGENT']);
=======
    
    public function loginWithCookie($email, $token) {
        $user = $this->userModel->getUserByEmail($email);
        
        if (!$user) {
            return ["success" => false, "message" => "Invalid cookie"];
        }
        
        $expectedToken = hash('sha256', $user['email'] . $user['password'] . $_SERVER['HTTP_USER_AGENT']);
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        if ($token !== $expectedToken) {
            setcookie('remember_user', '', time() - 3600, '/');
            return ["success" => false, "message" => "Invalid cookie token"];
        }
<<<<<<< HEAD
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
=======
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['email'] = $user['email'];
<<<<<<< HEAD
        $_SESSION['role'] = $user['role_name'] ?? 'Customer'; 
        ini_set('session.gc_maxlifetime', 86400); 
        session_set_cookie_params(86400); 
        $this->setRememberMeCookie($user['email'], 30);
        $dashboardPath = $this->getDashboardPathByRole($_SESSION['role']);
=======
        $_SESSION['role'] = $user['role_name'] ?? 'Customer';
        
        ini_set('session.gc_maxlifetime', 86400);
        session_set_cookie_params(86400);
        
        $this->setRememberMeCookie($user['email'], 30);
        
        $dashboardPath = $this->getDashboardPathByRole($_SESSION['role']);
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        return [
            "success" => true, 
            "message" => "Auto-login successful", 
            "redirect" => $dashboardPath
        ];
    }
<<<<<<< HEAD
    private function setRememberMeCookie($email, $days) {
        $user = $this->userModel->getUserByEmail($email);
        if ($user) {
            $token = hash('sha256', $user['email'] . $user['password'] . $_SERVER['HTTP_USER_AGENT']);
=======
    
    private function setRememberMeCookie($email, $days) {
        $user = $this->userModel->getUserByEmail($email);
        
        if ($user) {
            $token = hash('sha256', $user['email'] . $user['password'] . $_SERVER['HTTP_USER_AGENT']);
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $cookieData = [
                'email' => $email,
                'token' => $token
            ];
<<<<<<< HEAD
            $expiry = time() + (86400 * $days); 
            setcookie('remember_user', json_encode($cookieData), $expiry, '/', '', false, true);
        }
    }
=======
            
            $expiry = time() + (86400 * $days);
            setcookie('remember_user', json_encode($cookieData), $expiry, '/', '', false, true);
        }
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function register($firstName, $lastName, $email, $dob, $password, $confirmPassword) {
        if (empty($firstName) || empty($lastName) || empty($email) || empty($dob) || empty($password) || empty($confirmPassword)) {
            return ["success" => false, "message" => "All fields are required"];
        }
<<<<<<< HEAD
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        if ($password !== $confirmPassword) {
            return ["success" => false, "message" => "Passwords do not match"];
        }
        if (strlen($password) < 8) {
            return ["success" => false, "message" => "Password must be at least 8 characters long"];
        }
        $result = $this->userModel->register($firstName, $lastName, $email, $dob, $password);
        return $result;
    }
=======
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        
        if ($password !== $confirmPassword) {
            return ["success" => false, "message" => "Passwords do not match"];
        }
        
        if (strlen($password) < 8) {
            return ["success" => false, "message" => "Password must be at least 8 characters long"];
        }
        
        $result = $this->userModel->register($firstName, $lastName, $email, $dob, $password);
        
        return $result;
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function resetPassword($email, $newPassword) {
        if (empty($email) || empty($newPassword)) {
            return ["success" => false, "message" => "Email and new password are required"];
        }
<<<<<<< HEAD
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        if (strlen($newPassword) < 8) {
            return ["success" => false, "message" => "Password must be at least 8 characters long"];
        }
        $result = $this->userModel->resetPassword($email, $newPassword);
=======
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        
        if (strlen($newPassword) < 8) {
            return ["success" => false, "message" => "Password must be at least 8 characters long"];
        }
        
        $result = $this->userModel->resetPassword($email, $newPassword);
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        if ($result) {
            return ["success" => true, "message" => "Password reset successful"];
        } else {
            return ["success" => false, "message" => "Password reset failed"];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
<<<<<<< HEAD
        return ["success" => true, "message" => "Logout successful"];
    }
=======
        
        return ["success" => true, "message" => "Logout successful"];
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    private function getDashboardPathByRole($role) {
        switch ($role) {
            case 'Administrator':
                return '../../../app/views/Dashboard/admin_dashboard.php';
            case 'Manager':
                return '../../../app/views/Dashboard/manager_dashboard.php';
            case 'Customer Service':
                return '../../../app/views/Dashboard/cs_dashboard.php';
            case 'Teller':
                return '../../../app/views/Dashboard/teller_dashboard.php';
            case 'Auditor':
                return '../../../app/views/Dashboard/auditor_dashboard.php';
            case 'Customer':
            default:
                return '../../../app/views/Dashboard/customer_dashboard.php';
        }
    }
}
<<<<<<< HEAD
?> 
=======
?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

<?php
require_once __DIR__ . '/../core/Controller.php';

class ProfileController extends Controller {
    public function __construct() {
        // Require login for all profile actions
        $this->requireLogin();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Get user data
        $userModel = $this->model('User');
        $user = $userModel->findById($userId);
        
        if (!$user) {
            $this->setFlashMessage('error', 'User not found.');
            $this->redirect('/dashboard');
            return;
        }
        
        // Prepare data for view
        $data = [
            'user' => $user,
            'success' => $_SESSION['flash_message']['message'] ?? '',
            'login_history' => [], // You can implement login history later
            'title' => 'My Profile'
        ];
        
        // Clear flash message after displaying
        if (isset($_SESSION['flash_message'])) {
            unset($_SESSION['flash_message']);
        }
        
        // Load profile view
        $this->view('profile/index', $data);
    }
    
    public function edit() {
        $userId = $_SESSION['user_id'];
        
        // Get user data
        $userModel = $this->model('User');
        $user = $userModel->findById($userId);
        
        if (!$user) {
            $this->setFlashMessage('error', 'User not found.');
            $this->redirect('/profile');
            return;
        }
        
        // Prepare data for view
        $data = [
            'user' => $user,
            'title' => 'Edit Profile'
        ];
        
        // Load edit profile view
        $this->view('profile/edit_profile', $data);
    }
    
    public function update() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/profile');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        
        // Get form data
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $addressLine1 = $_POST['address_line1'] ?? '';
        $addressLine2 = $_POST['address_line2'] ?? '';
        $city = $_POST['city'] ?? '';
        $state = $_POST['state'] ?? '';
        $postalCode = $_POST['postal_code'] ?? '';
        $country = $_POST['country'] ?? '';
        
        // Validate data
        $errors = [];
        
        if (empty($firstName)) {
            $errors[] = "First name is required.";
        }
        
        if (empty($lastName)) {
            $errors[] = "Last name is required.";
        }
        
        // If there are errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/profile');
            return;
        }
        
        // Update user data
        try {
            $userModel = $this->model('User');
            
            // Format the address as a single string
            $address = '';
            if (!empty($addressLine1)) {
                $address .= $addressLine1;
            }
            if (!empty($addressLine2)) {
                $address .= "\n" . $addressLine2;
            }
            if (!empty($city) || !empty($state) || !empty($postalCode)) {
                $address .= "\n" . trim($city . ', ' . $state . ' ' . $postalCode);
            }
            if (!empty($country)) {
                $address .= "\n" . $country;
            }
            
            $userData = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $phone,
                'date_of_birth' => date('Y-m-d'), // We should get this from the user record but using a default for now
                'address' => $address
            ];
            
            $success = $userModel->updateProfile($userId, $userData);
            
            if (!$success) {
                throw new Exception("Failed to update profile.");
            }
            
            // Set success message
            $this->setFlashMessage('success', 'Profile updated successfully.');
            
            // Redirect to profile page
            $this->redirect('/profile');
            
        } catch (Exception $e) {
            // Set error message and redirect back
            $this->setFlashMessage('error', 'Profile update failed: ' . $e->getMessage());
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/profile');
        }
    }
    
    public function changePassword() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/profile');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        
        // Get form data
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate data
        $errors = [];
        
        if (empty($currentPassword)) {
            $errors[] = "Current password is required.";
        }
        
        if (empty($newPassword)) {
            $errors[] = "New password is required.";
        } elseif (strlen($newPassword) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        
        if ($newPassword !== $confirmPassword) {
            $errors[] = "New password and confirmation do not match.";
        }
        
        // If there are errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect('/profile');
            return;
        }
        
        // Change password
        try {
            $userModel = $this->model('User');
            $user = $userModel->findById($userId);
            
            // Verify current password
            if (!password_verify($currentPassword, $user['password'])) {
                throw new Exception("Current password is incorrect.");
            }
            
            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // Update password
            $success = $userModel->updatePassword($userId, $hashedPassword);
            
            if (!$success) {
                throw new Exception("Failed to change password.");
            }
            
            // Set success message
            $this->setFlashMessage('success', 'Password changed successfully.');
            
            // Redirect to profile page
            $this->redirect('/profile');
            
        } catch (Exception $e) {
            // Set error message and redirect back
            $this->setFlashMessage('error', 'Password change failed: ' . $e->getMessage());
            $this->redirect('/profile');
        }
    }
}

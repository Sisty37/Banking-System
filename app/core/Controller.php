<?php
/**
 * Base Controller
 * Loads the models and views
 */
class Controller {
    // Load model
    public function model($model) {
        // Require model file
        if (file_exists(__DIR__ . '/../models/' . $model . '.php')) {
            require_once __DIR__ . '/../models/' . $model . '.php';
            // Instantiate model
            return new $model();
        } else {
            die("Model {$model} not found");
        }
    }

    // Load view
    public function view($view, $data = []) {
        // Check for view file
        if (file_exists(__DIR__ . '/../views/' . $view . '.php')) {
            // Extract data to make it available in the view
            extract($data);
            
            // Include view file
            require_once __DIR__ . '/../views/' . $view . '.php';
        } else {
            // View does not exist
            die("View {$view} not found");
        }
    }
    
    // Redirect helper
    public function redirect($url) {
        // If URL doesn't already contain the APP_URL and doesn't start with http, add APP_URL
        if (strpos($url, 'http') !== 0 && strpos($url, APP_URL) !== 0) {
            // Remove leading slash if present to avoid double slashes
            $url = ltrim($url, '/');
            $url = APP_URL . '/' . $url;
        }
        
        header('Location: ' . $url);
        exit();
    }
    
    // Flash message helper
    public function setFlashMessage($type, $message) {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    // Check if user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Check if user is admin
    public function isAdmin() {
        return $this->isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
    
    // Get current user data
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            $userModel = $this->model('User');
            return $userModel->findById($_SESSION['user_id']);
        }
        
        return null;
    }
    
    // Require login
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->setFlashMessage('error', 'You must be logged in to access this page');
            $this->redirect('/login');
        }
    }
    
    // Require admin
    public function requireAdmin() {
        $this->requireLogin();
        
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'You do not have permission to access this page');
            $this->redirect('/dashboard');
        }
    }
}


<?php
require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller {
    public function index() {
        // Check if user is logged in
        if (isset($_SESSION['user_id'])) {
            // Redirect to dashboard if logged in
            header('Location: ' . APP_URL . '/dashboard');
            exit();
        }
        
        // Display the home page for non-logged in users
        $this->view('home', [
            'title' => 'Welcome to Banking System',
            'description' => 'A secure and convenient way to manage your finances.'
        ]);
    }
}

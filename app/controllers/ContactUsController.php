<?php
require_once __DIR__ . '/../core/Controller.php';

class ContactUsController extends Controller {
    
    public function index() {
        $data = [
            'title' => 'Contact Us',
            'errors' => $_SESSION['errors'] ?? [],
            'success' => $_SESSION['flash_message']['message'] ?? '',
            'old_input' => $_SESSION['old_input'] ?? []
        ];
        
        // Clear session data
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
        
        if (isset($_SESSION['flash_message'])) {
            unset($_SESSION['flash_message']);
        }
        
        if (isset($_SESSION['old_input'])) {
            unset($_SESSION['old_input']);
        }
        
        $this->view('contact/index', $data);
    }
    
    public function submit() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contact-us');
            return;
        }
        
        // Get form data
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';
        
        // Validate data
        $errors = [];
        
        if (empty($name)) {
            $errors[] = "Name is required.";
        }
        
        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
        
        if (empty($subject)) {
            $errors[] = "Subject is required.";
        }
        
        if (empty($message)) {
            $errors[] = "Message is required.";
        }
        
        // If there are errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/contact-us');
            return;
        }
        
        // Process the contact form (could save to database or send email)
        try {
            // Example: Save to database
            $contactModel = $this->model('Contact');
            $success = $contactModel->create([
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message
            ]);
            
            if (!$success) {
                throw new Exception("Failed to submit contact form.");
            }
            
            // Set success message
            $this->setFlashMessage('success', 'Your message has been sent successfully. We will get back to you soon.');
            
            // Redirect to contact page
            $this->redirect('/contact-us');
            
        } catch (Exception $e) {
            // Log the error (you can implement a proper logging system)
            error_log($e->getMessage());
            
            // Set error message and redirect back
            $this->setFlashMessage('error', 'Failed to submit contact form: ' . $e->getMessage());
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/contact-us');
        }
    }
}

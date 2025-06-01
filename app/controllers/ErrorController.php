<?php
require_once __DIR__ . '/../core/Controller.php';

class ErrorController extends Controller {
    public function notFound($message = '') {
        http_response_code(404);
        $this->view('errors/404', [
            'title' => '404 Not Found',
            'message' => $message
        ]);
    }
    
    public function forbidden($message = '') {
        http_response_code(403);
        $this->view('errors/403', [
            'title' => '403 Forbidden',
            'message' => $message
        ]);
    }
    
    public function serverError($message = '') {
        http_response_code(500);
        $this->view('errors/500', [
            'title' => '500 Server Error',
            'message' => $message
        ]);
    }
} 
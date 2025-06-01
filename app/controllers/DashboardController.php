<?php
require_once __DIR__ . '/../core/Controller.php';

class DashboardController extends Controller {
    public function __construct() {
        // Require login for all dashboard actions
        $this->requireLogin();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Initialize default values
        $accounts = [];
        $recentTransactions = [];
        $pendingBills = [];
        $unreadNotificationsCount = 0;
        
        try {
            // Get user accounts
            $accountModel = $this->model('Account');
            $accounts = $accountModel->getAccountsByUserId($userId);
            
            // Get recent transactions (if accounts exist)
            if (!empty($accounts)) {
                $transactionModel = $this->model('Transaction');
                $recentTransactions = $transactionModel->getTransactionsByUserId($userId, 5, 0);
                
                // Get pending bills
                $billModel = $this->model('Bill');
                $pendingBills = $billModel->getPendingBillsByUserId($userId);
            }
            
            // Get unread notifications count
            $notificationModel = $this->model('Notification');
            $unreadNotificationsCount = $notificationModel->countUnreadNotifications($userId);
        } catch (Exception $e) {
            // Log the error
            error_log('Dashboard Error: ' . $e->getMessage());
            
            // Set flash message
            $this->setFlashMessage('error', 'There was an error loading your dashboard. Please try again later.');
        }
        
        // Prepare data for view
        $data = [
            'accounts' => $accounts,
            'recentTransactions' => $recentTransactions,
            'pendingBills' => $pendingBills,
            'unreadNotificationsCount' => $unreadNotificationsCount,
            'user' => $this->getCurrentUser()
        ];
        
        // Load dashboard view
        $this->view('dashboard/index', $data);
    }
}


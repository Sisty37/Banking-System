<?php
require_once __DIR__ . '/../core/Controller.php';

class AdminController extends Controller {
    
    protected $userModel;
    protected $accountModel;
    protected $transactionModel;
    
    public function __construct() {
        // Initialize models
        $this->userModel = $this->model('User');
        $this->accountModel = $this->model('Account');
        $this->transactionModel = $this->model('Transaction');
        
        // Require admin access
        $this->requireAdmin();
    }
    
    /**
     * Admin dashboard home
     */
    public function index() {
        // Get dashboard statistics
        $totalUsers = $this->userModel->getTotalUsers();
        $totalAccounts = $this->accountModel->getTotalAccounts();
        $totalTransactions = $this->transactionModel->getTotalTransactions();
        $totalBalance = $this->accountModel->getTotalBalance();
        
        // Get recent users
        $recentUsers = $this->userModel->getRecentUsers(5);
        
        // Get recent accounts
        $recentAccounts = $this->accountModel->getRecentAccounts(5);
        
        // Get recent transactions
        $recentTransactions = $this->transactionModel->getRecentTransactions(5);
        
        // Load dashboard view
        $this->view('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'totalAccounts' => $totalAccounts,
            'totalTransactions' => $totalTransactions,
            'totalBalance' => $totalBalance,
            'recentUsers' => $recentUsers ?? [],
            'recentAccounts' => $recentAccounts ?? [],
            'recentTransactions' => $recentTransactions ?? []
        ]);
    }
    
    /**
     * Manage users
     */
    public function users() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Get total user count for pagination
        $totalUsers = $this->userModel->getTotalUsers();
        $totalPages = ceil($totalUsers / $limit);
        
        // Get users with pagination
        $users = $this->userModel->getAllUsers($limit, $offset);
        
        $this->view('admin/users', [
            'users' => $users ?? [],
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_records' => $totalUsers
            ]
        ]);
    }
    
    /**
     * Manage accounts
     */
    public function accounts() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Get total account count for pagination
        $totalAccounts = $this->accountModel->getTotalAccounts();
        $totalPages = ceil($totalAccounts / $limit);
        
        // Get accounts with pagination
        $accounts = $this->accountModel->getAllAccounts($limit, $offset);
        
        $this->view('admin/accounts', [
            'accounts' => $accounts ?? [],
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_records' => $totalAccounts
            ]
        ]);
    }
    
    /**
     * Manage transactions
     */
    public function transactions() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Apply filters if provided
        $filters = [];
        if (isset($_GET['type']) && $_GET['type'] !== '') {
            $filters['type'] = $_GET['type'];
        }
        if (isset($_GET['status']) && $_GET['status'] !== '') {
            $filters['status'] = $_GET['status'];
        }
        if (isset($_GET['date_from']) && $_GET['date_from'] !== '') {
            $filters['date_from'] = $_GET['date_from'];
        }
        if (isset($_GET['date_to']) && $_GET['date_to'] !== '') {
            $filters['date_to'] = $_GET['date_to'];
        }
        
        // Get total transaction count for pagination
        $totalTransactions = $this->transactionModel->getTotalTransactionsFiltered($filters);
        $totalPages = ceil($totalTransactions / $limit);
        
        // Get transactions with pagination and filters
        $transactions = $this->transactionModel->getFilteredTransactions($filters, $limit, $offset);
        
        $this->view('admin/transactions', [
            'transactions' => $transactions ?? [],
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_records' => $totalTransactions
            ]
        ]);
    }
 
    
}

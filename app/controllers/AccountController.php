<?php
require_once __DIR__ . '/../core/Controller.php';

class AccountController extends Controller {
    public function __construct() {
        // Require login for all account-related actions
        $this->requireLogin();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Get user accounts
        $accountModel = $this->model('Account');
        $accounts = $accountModel->getAccountsByUserId($userId);
        
        // Prepare data for view
        $data = [
            'accounts' => $accounts,
            'user' => $this->getCurrentUser()
        ];
        
        // Load accounts view
        $this->view('accounts/index', $data);
    }
    
    public function create() {
        // Prepare data for view
        $data = [
            'user' => $this->getCurrentUser()
        ];
        
        // Load create account view
        $this->view('accounts/create', $data);
    }
    
    public function store() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/accounts');
            return;
        }
        
        // Get form data
        $accountType = $_POST['account_type'] ?? '';
        $initialDeposit = $_POST['initial_deposit'] ?? 0;
        
        // Validate data
        $errors = [];
        
        if (empty($accountType)) {
            $errors[] = "Account type is required.";
        }
        
        if (empty($initialDeposit) || !is_numeric($initialDeposit) || $initialDeposit < 0) {
            $errors[] = "Valid initial deposit amount is required.";
        }
        
        // If there are errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/accounts/create');
            return;
        }
        
        // Process account creation
        try {
            $accountModel = $this->model('Account');
            $transactionModel = $this->model('Transaction');
            $notificationModel = $this->model('Notification');
            
            // Generate account number
            $accountNumber = $accountModel->generateAccountNumber();
            
            // Prepare account data
            $accountData = [
                'user_id' => $_SESSION['user_id'],
                'account_number' => $accountNumber,
                'account_type' => $accountType,
                'balance' => $initialDeposit,
                'status' => 'active'
            ];
            
            // Create the account
            $accountId = $accountModel->create($accountData);
            
            if (!$accountId) {
                throw new Exception("Failed to create account.");
            }
            
            // If initial deposit is greater than 0, create a deposit transaction
            if ($initialDeposit > 0) {
                // Generate reference number
                $referenceNumber = $transactionModel->generateReferenceNumber();
                
                // Create transaction record
                $transactionData = [
                    'account_id' => $accountId,
                    'user_id' => $_SESSION['user_id'],
                    'transaction_type' => 'deposit',
                    'amount' => $initialDeposit,
                    'description' => "Initial deposit for new {$accountType} account",
                    'reference_number' => $referenceNumber,
                    'status' => 'completed'
                ];
                
                $transactionId = $transactionModel->create($transactionData);
                
                if (!$transactionId) {
                    throw new Exception("Failed to create initial deposit transaction.");
                }
            }
            
            // Create notification
            $notificationModel->createAccountOpenNotification(
                $_SESSION['user_id'],
                $accountType,
                $accountNumber
            );
            
            // Set success message
            $this->setFlashMessage('success', 'Account created successfully.');
            
            // Redirect to accounts page
            $this->redirect('/accounts');
            
        } catch (Exception $e) {
            // Set error message and redirect back
            $this->setFlashMessage('error', 'Account creation failed: ' . $e->getMessage());
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/accounts/create');
        }
    }
    
    public function viewAccount() {
        $accountId = $_GET['id'] ?? '';
        
        if (empty($accountId)) {
            $this->redirect('/accounts');
            return;
        }
        
        // Get account details
        $accountModel = $this->model('Account');
        $account = $accountModel->getAccountById($accountId);
        
        // Check if account exists and belongs to the user
        if (!$account || $account['user_id'] != $_SESSION['user_id']) {
            $this->setFlashMessage('error', 'Account not found or you do not have permission to view it.');
            $this->redirect('/accounts');
            return;
        }
        
        // Get recent transactions for this account
        $transactionModel = $this->model('Transaction');
        $recentTransactions = $transactionModel->getRecentTransactionsByAccountId($accountId, 5);
        
        // Prepare data for view
        $data = [
            'account' => (object)$account, // Convert to object for easier view access
            'recentTransactions' => $recentTransactions,
            'user' => $this->getCurrentUser()
        ];
        
        // Load account details view
        $this->view('accounts/show', $data);
    }
} 
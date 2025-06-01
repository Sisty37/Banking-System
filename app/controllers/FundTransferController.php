<?php
require_once __DIR__ . '/../core/Controller.php';

class FundTransferController extends Controller {
    public function __construct() {
        // Require login for all fund transfer actions
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
        
        // Load fund transfer view
        $this->view('fund_transfer/index', $data);
    }
    
    public function process() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $fromAccountId = $_POST['from_account_id'] ?? '';
            $toAccountId = $_POST['to_account_id'] ?? '';
            $amount = $_POST['amount'] ?? '';
            $description = $_POST['description'] ?? 'Fund Transfer';
            $transferType = $_POST['transfer_type'] ?? 'internal';
            $recipientName = $_POST['recipient_name'] ?? '';
            $recipientBank = $_POST['recipient_bank'] ?? '';
            
            // Validate data
            $errors = [];
            
            if (empty($fromAccountId)) {
                $errors[] = "Source account is required.";
            }
            
            if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
                $errors[] = "Valid amount is required.";
            }
            
            if ($transferType === 'internal' && empty($toAccountId)) {
                $errors[] = "Destination account is required for internal transfers.";
            }
            
            if ($transferType === 'external') {
                if (empty($recipientName)) {
                    $errors[] = "Recipient name is required for external transfers.";
                }
                
                if (empty($recipientBank)) {
                    $errors[] = "Recipient bank is required for external transfers.";
                }
            }
            
            // If there are errors, redirect back with errors
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = $_POST;
                $this->redirect('/fund-transfer');
                return;
            }
            
            // Start transaction process
            try {
                $accountModel = $this->model('Account');
                $transactionModel = $this->model('Transaction');
                $transferModel = $this->model('FundTransfer');
                $notificationModel = $this->model('Notification');
                
                // Get source account details
                $fromAccount = $accountModel->getAccountById($fromAccountId);
                
                // Check if source account exists and belongs to user
                if (!$fromAccount || $fromAccount['user_id'] != $_SESSION['user_id']) {
                    throw new Exception("Invalid source account.");
                }
                
                // Check if source account has sufficient balance
                if ($fromAccount['balance'] < $amount) {
                    throw new Exception("Insufficient balance in source account.");
                }
                
                // Generate reference number
                $referenceNumber = $transactionModel->generateReferenceNumber();
                
                // Begin database transaction
                $transferModel->beginTransaction();
                
                // Create transaction record
                $transactionData = [
                    'account_id' => $fromAccountId,
                    'user_id' => $_SESSION['user_id'],
                    'transaction_type' => 'transfer',
                    'amount' => $amount,
                    'fee' => 0.00, // You can set a fee if needed
                    'description' => $description,
                    'reference_number' => $referenceNumber,
                    'status' => 'completed'
                ];
                
                // For internal transfers, add recipient account ID
                if ($transferType === 'internal') {
                    $toAccount = $accountModel->getAccountById($toAccountId);
                    
                    // Verify destination account
                    if (!$toAccount) {
                        throw new Exception("Invalid destination account.");
                    }
                    
                    $transactionData['recipient_account_id'] = $toAccountId;
                } else {
                    // For external transfers
                    $transactionData['recipient_name'] = $recipientName;
                    $transactionData['recipient_bank'] = $recipientBank;
                }
                
                // Create transaction
                $transactionId = $transactionModel->create($transactionData);
                
                if (!$transactionId) {
                    throw new Exception("Failed to create transaction record.");
                }
                
                // Update source account balance (subtract amount)
                $success = $accountModel->updateBalance($fromAccountId, -$amount);
                
                if (!$success) {
                    throw new Exception("Failed to update source account balance.");
                }
                
                // For internal transfers, update destination account balance (add amount)
                if ($transferType === 'internal' && $toAccount) {
                    $success = $accountModel->updateBalance($toAccountId, $amount);
                    
                    if (!$success) {
                        throw new Exception("Failed to update destination account balance.");
                    }
                    
                    // Create fund transfer record
                    $transferData = [
                        'transaction_id' => $transactionId,
                        'from_account_id' => $fromAccountId,
                        'to_account_id' => $toAccountId,
                        'amount' => $amount,
                        'transfer_type' => $transferType,
                        'description' => $description
                    ];
                    
                    $transferId = $transferModel->create($transferData);
                    
                    if (!$transferId) {
                        throw new Exception("Failed to create transfer record.");
                    }
                    
                    // Create notification for recipient if it's another user
                    if ($toAccount['user_id'] != $_SESSION['user_id']) {
                        $notificationModel->createTransactionNotification(
                            $toAccount['user_id'],
                            'deposit',
                            $amount,
                            $toAccount['account_number']
                        );
                    }
                }
                
                // Create notification for sender
                $notificationModel->createTransactionNotification(
                    $_SESSION['user_id'],
                    'transfer',
                    $amount,
                    $fromAccount['account_number']
                );
                
                // Commit transaction
                $transferModel->commit();
                
                // Set success message and redirect
                $this->setFlashMessage('success', 'Fund transfer completed successfully.');
                $this->redirect('/transactions');
                
            } catch (Exception $e) {
                // Rollback transaction if an error occurred
                if (isset($transferModel)) {
                    $transferModel->rollback();
                }
                
                // Set error message and redirect back
                $this->setFlashMessage('error', 'Fund transfer failed: ' . $e->getMessage());
                $_SESSION['old_input'] = $_POST;
                $this->redirect('/fund-transfer');
            }
        } else {
            // Not a POST request, redirect to index
            $this->redirect('/fund-transfer');
        }
    }
    
    // Helper method to check if user is logged in
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->setFlashMessage('error', 'Please login to access this page');
            $this->redirect('/login');
        }
    }
}

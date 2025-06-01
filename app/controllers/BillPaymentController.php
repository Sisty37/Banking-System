<?php
require_once __DIR__ . '/../core/Controller.php';

class BillPaymentController extends Controller {
    public function __construct() {
        // Require login for all bill payment actions
        $this->requireLogin();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Get user accounts
        $accountModel = $this->model('Account');
        $accounts = $accountModel->getAccountsByUserId($userId);
        
        // Get pending bills
        $billModel = $this->model('Bill');
        $pendingBills = $billModel->getPendingBillsByUserId($userId);
        
        // Prepare data for view
        $data = [
            'accounts' => $accounts,
            'pendingBills' => $pendingBills,
            'user' => $this->getCurrentUser()
        ];
        
        // Load bill payment view
        $this->view('bill_payment/index', $data);
    }
    
    public function process() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/bill-payment');
            return;
        }
        
        // Get form data
        $billId = $_POST['bill_id'] ?? '';
        $accountId = $_POST['account_id'] ?? '';
        $amount = $_POST['amount'] ?? '';
        
        // Validate data
        $errors = [];
        
        if (empty($billId)) {
            $errors[] = "Bill information is required.";
        }
        
        if (empty($accountId)) {
            $errors[] = "Account is required.";
        }
        
        if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
            $errors[] = "Valid amount is required.";
        }
        
        // If there are errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/bill-payment');
            return;
        }
        
        // Process bill payment
        try {
            $billModel = $this->model('Bill');
            $accountModel = $this->model('Account');
            $transactionModel = $this->model('Transaction');
            $notificationModel = $this->model('Notification');
            
            // Get bill details
            $bill = $billModel->getBillById($billId);
            
            if (!$bill) {
                throw new Exception("Bill not found.");
            }
            
            // Get account details
            $account = $accountModel->getAccountById($accountId);
            
            if (!$account) {
                throw new Exception("Account not found.");
            }
            
            // Check if account belongs to user
            if ($account['user_id'] != $_SESSION['user_id']) {
                throw new Exception("Invalid account.");
            }
            
            // Check if account has sufficient balance
            if ($account['balance'] < $amount) {
                throw new Exception("Insufficient balance in the account.");
            }
            
            // Begin transaction
            $db = new Database();
            $db->beginTransaction();
            
            // Generate reference number
            $referenceNumber = $transactionModel->generateReferenceNumber();
            
            // Create transaction record
            $transactionData = [
                'account_id' => $accountId,
                'user_id' => $_SESSION['user_id'],
                'transaction_type' => 'bill_payment',
                'amount' => $amount,
                'description' => "Payment for " . $bill['biller_name'] . " - " . $bill['bill_number'],
                'reference_number' => $referenceNumber,
                'status' => 'completed'
            ];
            
            $transactionId = $transactionModel->create($transactionData);
            
            if (!$transactionId) {
                throw new Exception("Failed to create transaction record.");
            }
            
            // Update account balance
            $success = $accountModel->updateBalance($accountId, -$amount);
            
            if (!$success) {
                throw new Exception("Failed to update account balance.");
            }
            
            // Update bill status to paid
            $success = $billModel->updateStatus($billId, 'completed');
            
            if (!$success) {
                throw new Exception("Failed to update bill status.");
            }
            
            // Record payment date and transaction ID
            $query = "UPDATE {$billModel->table} SET 
                        transaction_id = :transaction_id,
                        payment_date = NOW(), 
                        updated_at = NOW() 
                      WHERE id = :bill_id";
            
            $params = [
                ':transaction_id' => $transactionId,
                ':bill_id' => $billId
            ];
            
            $success = $db->execute($query, $params);
            
            if (!$success) {
                throw new Exception("Failed to record payment details.");
            }
            
            // Create notification
            $notificationModel->createBillPaymentNotification(
                $_SESSION['user_id'],
                $bill['biller_name'],
                $amount,
                $account['account_number']
            );
            
            // Commit transaction
            $db->commit();
            
            // Set success message
            $this->setFlashMessage('success', 'Bill payment processed successfully.');
            
            // Redirect to success page
            $this->redirect('/bill-payment/success?id=' . $transactionId);
            
        } catch (Exception $e) {
            // Rollback transaction if an error occurred
            if (isset($db)) {
                $db->rollback();
            }
            
            // Set error message and redirect back
            $this->setFlashMessage('error', 'Bill payment failed: ' . $e->getMessage());
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/bill-payment');
        }
    }
    
    public function success() {
        $transactionId = $_GET['id'] ?? '';
        
        if (empty($transactionId)) {
            $this->redirect('/bill-payment');
            return;
        }
        
        // Get transaction details
        $transactionModel = $this->model('Transaction');
        $transaction = $transactionModel->getTransactionById($transactionId);
        
        if (!$transaction || $transaction['transaction_type'] !== 'bill_payment') {
            $this->setFlashMessage('error', 'Invalid transaction.');
            $this->redirect('/bill-payment');
            return;
        }
        
        // Get account details
        $accountModel = $this->model('Account');
        $account = $accountModel->getAccountById($transaction['account_id']);
        
        // Get bill details
        $billModel = $this->model('Bill');
        $bill = $billModel->getBillByTransactionId($transactionId);
        
        // Prepare data for view
        $data = [
            'transaction' => $transaction,
            'account' => $account,
            'bill' => $bill,
            'user' => $this->getCurrentUser()
        ];
        
        // Load bill payment success view
        $this->view('bill_payment/bill_success', $data);
    }
}

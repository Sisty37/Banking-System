<?php
require_once __DIR__ . '/../core/Controller.php';

class TransactionController extends Controller {
    public function __construct() {
        // Require login for all transaction actions
        $this->requireLogin();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Get user's transactions
        $transactionModel = $this->model('Transaction');
        $transactions = $transactionModel->getTransactionsByUserId($userId, 20, 0);
        
        // Prepare data for view
        $data = [
            'transactions' => $transactions,
            'user' => $this->getCurrentUser()
        ];
        
        // Load transactions view
        $this->view('transaction/index', $data);
    }
    
    public function details() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $this->setFlashMessage('error', 'Transaction ID is required');
            $this->redirect('/transactions');
            return;
        }
        
        $id = $_GET['id'];
        $userId = $_SESSION['user_id'];
        
        // Get transaction details
        $transactionModel = $this->model('Transaction');
        $transaction = $transactionModel->getTransactionById($id);
        
        // Check if transaction exists and belongs to the user
        if (!$transaction) {
            $this->setFlashMessage('error', 'Transaction not found');
            $this->redirect('/transactions');
            return;
        }
        
        // Get account details to verify user ownership
        $accountModel = $this->model('Account');
        $account = $accountModel->getAccountById($transaction['account_id']);
        
        if (!$account || $account['user_id'] != $userId) {
            // If not admin and not the owner, deny access
            if (!$this->isAdmin()) {
                $this->setFlashMessage('error', 'You do not have permission to view this transaction');
                $this->redirect('/transactions');
                return;
            }
        }
        
        // Load transaction details
        $data = [
            'transaction' => $transaction,
            'account' => $account,
            'user' => $this->getCurrentUser()
        ];
        
        // If it's a transfer transaction, load related transfer data
        if ($transaction['transaction_type'] === 'transfer' && $transaction['recipient_account_id']) {
            $transferModel = $this->model('FundTransfer');
            $transfers = $transferModel->getTransfersByTransactionId($transaction['id']);
            $data['transfers'] = $transfers;
        }
        
        // Load transaction details view
        $this->view('transaction/details', $data);
    }
    
    public function search() {
        $search = $_GET['search'] ?? '';
        $userId = $_SESSION['user_id'];
        
        if (empty($search)) {
            $this->redirect('/transactions');
            return;
        }
        
        // Search transactions
        $transactionModel = $this->model('Transaction');
        $transactions = $transactionModel->searchTransactions($search, $userId, 20, 0);
        
        // Prepare data for view
        $data = [
            'transactions' => $transactions,
            'search' => $search,
            'user' => $this->getCurrentUser()
        ];
        
        // Load transactions view
        $this->view('transaction/index', $data);
    }
    
    public function export() {
        $userId = $_SESSION['user_id'];
        $format = $_GET['format'] ?? 'csv';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        
        // Get transactions
        $transactionModel = $this->model('Transaction');
        $transactions = $transactionModel->getTransactionsByUserIdAndDateRange($userId, $startDate, $endDate);
        
        if ($format === 'pdf') {
            // Export as PDF
            // Implementation would depend on PDF library
            $this->setFlashMessage('info', 'PDF export is not implemented yet');
            $this->redirect('/transactions');
            return;
        } else {
            // Default to CSV
            $this->exportToCsv($transactions);
        }
    }
    
    private function exportToCsv($transactions) {
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="transactions.csv"');
        
        // Open output stream
        $output = fopen('php://output', 'w');
        
        // Add CSV header row
        fputcsv($output, [
            'Transaction ID',
            'Date',
            'Type',
            'Amount',
            'Fee',
            'Description',
            'Reference Number',
            'Status'
        ]);
        
        // Add transaction data
        foreach ($transactions as $transaction) {
            fputcsv($output, [
                $transaction['id'],
                $transaction['created_at'],
                $transaction['transaction_type'],
                $transaction['amount'],
                $transaction['fee'],
                $transaction['description'],
                $transaction['reference_number'],
                $transaction['status']
            ]);
        }
        
        // Close output stream
        fclose($output);
        exit;
    }
}

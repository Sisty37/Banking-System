<?php
require_once __DIR__ . '/../Models/UserModel.php';

class AccountController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function getUserAccounts($userId) {
        return $this->userModel->getUserAccounts($userId);
    }
    
    public function getAccountDetails($accountId) {
        return $this->userModel->getAccountDetails($accountId);
    }
    
    public function getRecentTransactions($accountId, $limit = 5) {
        return $this->userModel->getRecentTransactions($accountId, $limit);
    }
    
    public function createAccount($userId, $accountType, $initialBalance = 0.00) {
        if (!$this->hasAccountManagementPermission()) {
            return [
                "success" => false, 
                "message" => "You don't have permission to create accounts"
            ];
        }
        $accountNumber = $this->generateUniqueAccountNumber();
        return $this->userModel->createAccount($userId, $accountNumber, $accountType, $initialBalance);
    }
    
    public function generateUniqueAccountNumber() {
        return $this->userModel->generateUniqueAccountNumber();
    }
    
    public function getAllUsers() {
        if (!$this->hasAccountManagementPermission()) {
            return [];
        }
        return $this->userModel->getAllUsers();
    }
    
    public function hasAccountManagementPermission() {
        if (!isset($_SESSION['role'])) {
            return false;
        }
        $role = $_SESSION['role'];
        return ($role === 'Administrator' || $role === 'Manager');
    }
    
    public function formatCurrency($amount) {
        return '$' . number_format($amount, 2);
    }
    
    public function formatDate($date) {
        return date('M d, Y', strtotime($date));
    }
    
    public function getAccountStatusBadge($isActive) {
        if ($isActive) {
            return '<span class="badge bg-success">Active</span>';
        } else {
            return '<span class="badge bg-danger">Inactive</span>';
        }
    }
    
    public function getTransactionTypeBadge($type) {
        switch (strtolower($type)) {
            case 'deposit':
                return '<span class="badge bg-success">Deposit</span>';
            case 'withdrawal':
                return '<span class="badge bg-danger">Withdrawal</span>';
            case 'transfer':
                return '<span class="badge bg-primary">Transfer</span>';
            case 'payment':
                return '<span class="badge bg-warning">Payment</span>';
            default:
                return '<span class="badge bg-secondary">' . ucfirst($type) . '</span>';
        }
    }
    
    public function getAccountTypes() {
        return [
            'Savings' => 'Savings Account',
            'Checking' => 'Checking Account',
            'Money Market' => 'Money Market Account',
            'Certificate of Deposit' => 'Certificate of Deposit (CD)',
            'IRA' => 'Individual Retirement Account (IRA)'
        ];
    }
    
    public function transferBetweenAccounts($fromAccountId, $toAccountId, $amount, $description = 'Fund Transfer') {
        $fromAccount = $this->userModel->getAccountDetails($fromAccountId);
        $toAccount = $this->userModel->getAccountDetails($toAccountId);
        
        if (!$fromAccount || !$toAccount) {
            return [
                "success" => false,
                "message" => "One or both accounts could not be found."
            ];
        }
        
        if ($fromAccount['user_id'] !== $_SESSION['user_id']) {
            return [
                "success" => false,
                "message" => "You do not have permission to transfer from this account."
            ];
        }
        
        if ($fromAccount['account_id'] === $toAccount['account_id']) {
            return [
                "success" => false,
                "message" => "Cannot transfer to the same account."
            ];
        }
        
        if ($fromAccount['balance'] < $amount) {
            return [
                "success" => false,
                "message" => "Insufficient funds in source account."
            ];
        }
        
        return $this->userModel->transferFunds($fromAccountId, $toAccountId, $amount, $description);
    }
    
    public function transferToExternalAccount($fromAccountId, $toAccountNumber, $amount, $description = 'Fund Transfer') {
        $fromAccount = $this->userModel->getAccountDetails($fromAccountId);
        
        if (!$fromAccount) {
            return [
                "success" => false,
                "message" => "Source account could not be found."
            ];
        }
        
        if ($fromAccount['user_id'] !== $_SESSION['user_id']) {
            return [
                "success" => false,
                "message" => "You do not have permission to transfer from this account."
            ];
        }
        
        if ($fromAccount['balance'] < $amount) {
            return [
                "success" => false,
                "message" => "Insufficient funds in source account."
            ];
        }
        
        $toAccount = $this->userModel->getAccountByNumber($toAccountNumber);
        
        if (!$toAccount) {
            return [
                "success" => false,
                "message" => "Destination account not found. Please verify the account number."
            ];
        }
        
        if ($fromAccount['account_id'] === $toAccount['account_id']) {
            return [
                "success" => false,
                "message" => "Cannot transfer to the same account."
            ];
        }
        
        return $this->userModel->transferFunds($fromAccountId, $toAccount['account_id'], $amount, $description);
    }
}
?> 

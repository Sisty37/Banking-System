<?php
require_once __DIR__ . '/../core/Database.php';

class Transaction {
    private $db;
    private $table = 'transactions';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($data) {
        $query = "INSERT INTO {$this->table} 
                  (account_id, user_id, transaction_type, amount, fee, description, 
                   reference_number, status, recipient_account_id, recipient_name, recipient_bank, created_at)
                  VALUES 
                  (:account_id, :user_id, :transaction_type, :amount, :fee, :description, 
                   :reference_number, :status, :recipient_account_id, :recipient_name, :recipient_bank, NOW())";
        
        $params = [
            ':account_id' => $data['account_id'],
            ':user_id' => $data['user_id'] ?? $_SESSION['user_id'] ?? null,
            ':transaction_type' => $data['transaction_type'],
            ':amount' => $data['amount'],
            ':fee' => $data['fee'] ?? 0.00,
            ':description' => $data['description'],
            ':reference_number' => $data['reference_number'],
            ':status' => $data['status'] ?? 'completed',
            ':recipient_account_id' => $data['recipient_account_id'] ?? null,
            ':recipient_name' => $data['recipient_name'] ?? null,
            ':recipient_bank' => $data['recipient_bank'] ?? null
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function getTransactionsByUserId($userId, $limit = 10, $offset = 0) {
        try {
            // Direct query using user_id from transactions table
            $query = "SELECT t.*, a.account_number 
                      FROM {$this->table} t
                      LEFT JOIN accounts a ON t.account_id = a.id
                      WHERE t.user_id = :user_id
                      ORDER BY t.created_at DESC
                      LIMIT :limit OFFSET :offset";
            
            $params = [
                ':user_id' => $userId,
                ':limit' => $limit,
                ':offset' => $offset
            ];
            
            return $this->db->fetchAll($query, $params);
        } catch (PDOException $e) {
            // If first query fails, try the original join query
            try {
                $query = "SELECT t.*, a.account_number 
                          FROM {$this->table} t
                          JOIN accounts a ON t.account_id = a.id
                          WHERE a.user_id = :user_id
                          ORDER BY t.created_at DESC
                          LIMIT :limit OFFSET :offset";
                
                $params = [
                    ':user_id' => $userId,
                    ':limit' => $limit,
                    ':offset' => $offset
                ];
                
                return $this->db->fetchAll($query, $params);
            } catch (PDOException $e) {
                // Return empty array if both queries fail
                error_log("Transaction query error: " . $e->getMessage());
                return [];
            }
        }
    }
    
    public function getTransactionsByAccountId($accountId, $limit = 10, $offset = 0) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE account_id = :account_id OR recipient_account_id = :recipient_account_id
                  ORDER BY created_at DESC
                  LIMIT :limit OFFSET :offset";
        
        $params = [
            ':account_id' => $accountId,
            ':recipient_account_id' => $accountId,
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function getTransactionById($id) {
        $query = "SELECT t.*, 
                  a1.account_number as source_account_number,
                  a2.account_number as recipient_account_number
                  FROM {$this->table} t
                  LEFT JOIN accounts a1 ON t.account_id = a1.id
                  LEFT JOIN accounts a2 ON t.recipient_account_id = a2.id
                  WHERE t.id = :id
                  LIMIT 1";
        
        $params = [':id' => $id];
        
        return $this->db->fetchRow($query, $params);
    }
    
    public function updateStatus($id, $status) {
        $query = "UPDATE {$this->table} 
                  SET status = :status, 
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':status' => $status
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function approveTransaction($id) {
        $transaction = $this->getTransactionById($id);
        if (!$transaction || $transaction['status'] !== 'pending') {
            return false;
        }
        
        // First update the transaction status
        $statusUpdate = $this->updateStatus($id, 'completed');
        
        if (!$statusUpdate) {
            return false;
        }
        
        // Then update account balance if needed
        require_once __DIR__ . '/Account.php';
        $accountModel = new Account();
        
        // Based on transaction type, update the appropriate account(s)
        switch ($transaction['transaction_type']) {
            case 'deposit':
                return $accountModel->updateBalance($transaction['account_id'], $transaction['amount']);
                
            case 'withdrawal':
                return $accountModel->updateBalance($transaction['account_id'], -$transaction['amount']);
                
            case 'transfer':
                // Update source account (deduct amount)
                $sourceUpdate = $accountModel->updateBalance($transaction['account_id'], -$transaction['amount']);
                
                // Update recipient account (add amount) if it exists in our system
                if ($transaction['recipient_account_id']) {
                    $recipientUpdate = $accountModel->updateBalance($transaction['recipient_account_id'], $transaction['amount']);
                    return $sourceUpdate && $recipientUpdate;
                }
                
                return $sourceUpdate;
                
            default:
                return true;
        }
    }
    
    public function rejectTransaction($id) {
        $transaction = $this->getTransactionById($id);
        if (!$transaction || $transaction['status'] !== 'pending') {
            return false;
        }
        
        return $this->updateStatus($id, 'failed');
    }
    
    public function countTransactions() {
        $query = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->fetchRow($query);
        
        return $result ? $result['count'] : 0;
    }
    
    public function getTotalTransactions() {
        return $this->countTransactions();
    }
    
    public function getTotalTransactionsFiltered($filters = []) {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE 1=1";
        $params = [];
        
        if (!empty($filters)) {
            if (isset($filters['type']) && $filters['type'] !== '') {
                $query .= " AND transaction_type = :type";
                $params[':type'] = $filters['type'];
            }
            
            if (isset($filters['status']) && $filters['status'] !== '') {
                $query .= " AND status = :status";
                $params[':status'] = $filters['status'];
            }
            
            if (isset($filters['date_from']) && $filters['date_from'] !== '') {
                $query .= " AND DATE(created_at) >= :date_from";
                $params[':date_from'] = $filters['date_from'];
            }
            
            if (isset($filters['date_to']) && $filters['date_to'] !== '') {
                $query .= " AND DATE(created_at) <= :date_to";
                $params[':date_to'] = $filters['date_to'];
            }
        }
        
        $result = $this->db->fetchRow($query, $params);
        return $result ? $result['count'] : 0;
    }
    
    public function getFilteredTransactions($filters = [], $limit = 10, $offset = 0) {
        $query = "SELECT t.*, 
                  a.account_number,
                  CONCAT(u.first_name, ' ', u.last_name) as user_name
                  FROM {$this->table} t
                  LEFT JOIN accounts a ON t.account_id = a.id
                  LEFT JOIN users u ON t.user_id = u.id
                  WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters)) {
            if (isset($filters['type']) && $filters['type'] !== '') {
                $query .= " AND t.transaction_type = :type";
                $params[':type'] = $filters['type'];
            }
            
            if (isset($filters['status']) && $filters['status'] !== '') {
                $query .= " AND t.status = :status";
                $params[':status'] = $filters['status'];
            }
            
            if (isset($filters['date_from']) && $filters['date_from'] !== '') {
                $query .= " AND DATE(t.created_at) >= :date_from";
                $params[':date_from'] = $filters['date_from'];
            }
            
            if (isset($filters['date_to']) && $filters['date_to'] !== '') {
                $query .= " AND DATE(t.created_at) <= :date_to";
                $params[':date_to'] = $filters['date_to'];
            }
        }
        
        $query .= " ORDER BY t.created_at DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function generateReferenceNumber() {
        // Generate a unique reference number (timestamp + random)
        $timestamp = time();
        $random = mt_rand(1000, 9999);
        return "TXN-{$timestamp}-{$random}";
    }
    
    public function getAllTransactions($limit = 10, $offset = 0) {
        $query = "SELECT t.*, 
                  CONCAT(u.first_name, ' ', u.last_name) as user_name,
                  a.account_number
                  FROM {$this->table} t
                  JOIN accounts a ON t.account_id = a.id
                  JOIN users u ON a.user_id = u.id
                  ORDER BY t.created_at DESC
                  LIMIT :limit OFFSET :offset";
        
        $params = [
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function searchTransactions($searchTerm, $limit = 10, $offset = 0) {
        $query = "SELECT t.*, 
                  CONCAT(u.first_name, ' ', u.last_name) as user_name,
                  a.account_number
                  FROM {$this->table} t
                  JOIN accounts a ON t.account_id = a.id
                  JOIN users u ON a.user_id = u.id
                  WHERE t.reference_number LIKE :search
                  OR t.description LIKE :search
                  OR a.account_number LIKE :search
                  ORDER BY t.created_at DESC
                  LIMIT :limit OFFSET :offset";
        
        $params = [
            ':search' => "%{$searchTerm}%",
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function countSearchResults($query) {
        $searchQuery = "SELECT COUNT(*) as count 
                        FROM {$this->table} t
                        JOIN accounts a ON t.account_id = a.id
                        JOIN users u ON a.user_id = u.id
                        WHERE t.reference_number LIKE :query
                        OR t.description LIKE :query
                        OR a.account_number LIKE :query";
        
        $params = [':query' => "%{$query}%"];
        $result = $this->db->fetchRow($searchQuery, $params);
        
        return $result ? $result['count'] : 0;
    }
    
    public function getTransactionsByUserIdAndDateRange($userId, $startDate = '', $endDate = '', $limit = 1000) {
        try {
            $query = "SELECT t.*, a.account_number 
                      FROM {$this->table} t
                      JOIN accounts a ON t.account_id = a.id
                      WHERE t.user_id = :user_id";
            
            $params = [':user_id' => $userId];
            
            if (!empty($startDate)) {
                $query .= " AND DATE(t.created_at) >= :start_date";
                $params[':start_date'] = $startDate;
            }
            
            if (!empty($endDate)) {
                $query .= " AND DATE(t.created_at) <= :end_date";
                $params[':end_date'] = $endDate;
            }
            
            $query .= " ORDER BY t.created_at DESC LIMIT :limit";
            $params[':limit'] = $limit;
            
            return $this->db->fetchAll($query, $params);
        } catch (PDOException $e) {
            error_log("Transaction getTransactionsByUserIdAndDateRange error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getRecentTransactionsByAccountId($accountId, $limit = 5) {
        $query = "SELECT t.*, 
                  a1.account_number as source_account_number,
                  a2.account_number as recipient_account_number
                  FROM {$this->table} t
                  LEFT JOIN accounts a1 ON t.account_id = a1.id
                  LEFT JOIN accounts a2 ON t.recipient_account_id = a2.id
                  WHERE t.account_id = :account_id OR t.recipient_account_id = :recipient_account_id
                  ORDER BY t.created_at DESC
                  LIMIT :limit";
        
        $params = [
            ':account_id' => $accountId,
            ':recipient_account_id' => $accountId,
            ':limit' => $limit
        ];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function getRecentTransactions($limit = 5) {
        $query = "SELECT t.*, 
                  a.account_number,
                  CONCAT(u.first_name, ' ', u.last_name) as user_name
                  FROM {$this->table} t
                  JOIN accounts a ON t.account_id = a.id
                  JOIN users u ON t.user_id = u.id
                  ORDER BY t.created_at DESC
                  LIMIT :limit";
        
        $params = [':limit' => $limit];
        
        return $this->db->fetchAll($query, $params);
    }
}

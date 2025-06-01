<?php
require_once __DIR__ . '/../core/Database.php';

class Account {
    private $db;
    private $table = 'accounts';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($data) {
        $query = "INSERT INTO {$this->table} (user_id, account_number, account_type, balance, status, created_at)
                  VALUES (:user_id, :account_number, :account_type, :balance, :status, NOW())";
        
        $params = [
            ':user_id' => $data['user_id'],
            ':account_number' => $data['account_number'],
            ':account_type' => $data['account_type'],
            ':balance' => $data['balance'] ?? 0,
            ':status' => $data['status'] ?? 'active'
        ];
        
        if($this->db->execute($query, $params)) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    public function getAccountsByUserId($userId) {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC";
        $params = [':user_id' => $userId];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function getAccountById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $params = [':id' => $id];
        
        return $this->db->fetchRow($query, $params);
    }
    
    public function getAccountByNumber($accountNumber) {
        $query = "SELECT * FROM {$this->table} WHERE account_number = :account_number LIMIT 1";
        $params = [':account_number' => $accountNumber];
        
        return $this->db->fetchRow($query, $params);
    }
    
    public function updateBalance($id, $amount) {
        // First get the current balance
        $account = $this->getAccountById($id);
        if (!$account) {
            return false;
        }
        
        // Calculate the new balance
        $newBalance = $account['balance'] + $amount;
        
        $query = "UPDATE {$this->table} 
                  SET balance = :balance, 
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':balance' => $newBalance
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function changeStatus($id, $status) {
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
    
    public function updateAccount($id, $data) {
        $query = "UPDATE {$this->table} 
                  SET account_type = :type, 
                      status = :status, 
                      balance = :balance,
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':type' => $data['type'],
            ':status' => $data['status'],
            ':balance' => $data['balance']
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function updateAccountStatus($id, $status) {
        return $this->changeStatus($id, $status);
    }
    
    public function getAllAccounts($limit = 10, $offset = 0) {
        $query = "SELECT a.*, CONCAT(u.first_name, ' ', u.last_name) as owner_name
                  FROM {$this->table} a
                  JOIN users u ON a.user_id = u.id
                  ORDER BY a.created_at DESC
                  LIMIT :limit OFFSET :offset";
        
        $params = [
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function countAccounts() {
        $query = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->fetchRow($query);
        
        return $result ? $result['count'] : 0;
    }
    
    public function getTotalAccounts() {
        return $this->countAccounts();
    }
    
    public function getTotalBalance() {
        $query = "SELECT SUM(balance) as total FROM {$this->table} WHERE status = 'active'";
        $result = $this->db->fetchRow($query);
        
        return $result ? floatval($result['total']) : 0;
    }
    
    public function getRecentAccounts($limit = 5) {
        $query = "SELECT a.*, CONCAT(u.first_name, ' ', u.last_name) as user_name
                  FROM {$this->table} a
                  JOIN users u ON a.user_id = u.id
                  ORDER BY a.created_at DESC
                  LIMIT :limit";
        
        $params = [':limit' => $limit];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function generateAccountNumber() {
        // Generate a random 10-digit account number
        $accountNumber = mt_rand(1000000000, 9999999999);
        
        // Check if it already exists
        if ($this->getAccountByNumber($accountNumber)) {
            // Try again if it exists
            return $this->generateAccountNumber();
        }
        
        return $accountNumber;
    }
    
    public function searchAccounts($query, $limit = 10, $offset = 0) {
        $searchQuery = "SELECT a.*, CONCAT(u.first_name, ' ', u.last_name) as owner_name
                        FROM {$this->table} a
                        JOIN users u ON a.user_id = u.id
                        WHERE a.account_number LIKE :query 
                        OR a.account_type LIKE :query 
                        OR CONCAT(u.first_name, ' ', u.last_name) LIKE :query
                        ORDER BY a.created_at DESC 
                        LIMIT :limit OFFSET :offset";
        
        $params = [
            ':query' => "%{$query}%",
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        return $this->db->fetchAll($searchQuery, $params);
    }
    
    public function countSearchResults($query) {
        $searchQuery = "SELECT COUNT(*) as count 
                        FROM {$this->table} a
                        JOIN users u ON a.user_id = u.id
                        WHERE a.account_number LIKE :query 
                        OR a.account_type LIKE :query 
                        OR CONCAT(u.first_name, ' ', u.last_name) LIKE :query";
        
        $params = [':query' => "%{$query}%"];
        $result = $this->db->fetchRow($searchQuery, $params);
        
        return $result ? $result['count'] : 0;
    }
}

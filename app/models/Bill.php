<?php
require_once __DIR__ . '/../core/Database.php';

class Bill {
    private $db;
    public $table = 'bill_payments';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($data) {
        $query = "INSERT INTO {$this->table} 
                  (transaction_id, account_id, biller_name, bill_type, bill_number, amount, due_date, status, created_at)
                  VALUES 
                  (:transaction_id, :account_id, :biller_name, :bill_type, :bill_number, :amount, :due_date, :status, NOW())";
        
        $params = [
            ':transaction_id' => $data['transaction_id'],
            ':account_id' => $data['account_id'],
            ':biller_name' => $data['biller_name'],
            ':bill_type' => $data['bill_type'],
            ':bill_number' => $data['bill_number'],
            ':amount' => $data['amount'],
            ':due_date' => $data['due_date'],
            ':status' => $data['status'] ?? 'pending'
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function getBillsByUserId($userId, $limit = 10, $offset = 0) {
        $query = "SELECT b.*, a.account_number 
                  FROM {$this->table} b
                  JOIN accounts a ON b.account_id = a.id
                  WHERE a.user_id = :user_id
                  ORDER BY b.due_date ASC
                  LIMIT :limit OFFSET :offset";
        
        $params = [
            ':user_id' => $userId,
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function getPendingBillsByUserId($userId) {
        try {
            $query = "SELECT b.*, a.account_number 
                      FROM {$this->table} b
                      JOIN accounts a ON b.account_id = a.id
                      WHERE a.user_id = :user_id AND b.status = 'pending' AND b.due_date >= CURDATE()
                      ORDER BY b.due_date ASC";
            
            $params = [':user_id' => $userId];
            
            return $this->db->fetchAll($query, $params);
        } catch (PDOException $e) {
            // If the table doesn't exist yet, just return an empty array
            return [];
        }
    }
    
    public function getBillById($id) {
        $query = "SELECT b.*, a.account_number
                  FROM {$this->table} b
                  JOIN accounts a ON b.account_id = a.id
                  WHERE b.id = :id
                  LIMIT 1";
        
        $params = [':id' => $id];
        
        return $this->db->fetchRow($query, $params);
    }
    
    public function updateStatus($id, $status) {
        $query = "UPDATE {$this->table} 
                  SET status = :status, 
                      payment_date = IF(:status = 'completed', NOW(), NULL),
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':status' => $status
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function countBills() {
        $query = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->fetchRow($query);
        
        return $result ? $result['count'] : 0;
    }
    
    public function getAllBills($limit = 10, $offset = 0) {
        $query = "SELECT b.*, 
                  CONCAT(u.first_name, ' ', u.last_name) as user_name,
                  a.account_number
                  FROM {$this->table} b
                  JOIN accounts a ON b.account_id = a.id
                  JOIN users u ON a.user_id = u.id
                  ORDER BY b.due_date ASC
                  LIMIT :limit OFFSET :offset";
        
        $params = [
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function getUpcomingBills($userId, $days = 7) {
        $query = "SELECT b.*, a.account_number 
                  FROM {$this->table} b
                  JOIN accounts a ON b.account_id = a.id
                  WHERE a.user_id = :user_id 
                  AND b.status = 'pending' 
                  AND b.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL :days DAY)
                  ORDER BY b.due_date ASC";
        
        $params = [
            ':user_id' => $userId,
            ':days' => $days
        ];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function getBillByTransactionId($transactionId) {
        $query = "SELECT b.*, a.account_number
                  FROM {$this->table} b
                  JOIN accounts a ON b.account_id = a.id
                  WHERE b.transaction_id = :transaction_id
                  LIMIT 1";
        
        $params = [':transaction_id' => $transactionId];
        
        return $this->db->fetchRow($query, $params);
    }
}

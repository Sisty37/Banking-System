<?php
require_once __DIR__ . '/../core/Database.php';

class FundTransfer {
    private $db;
    private $table = 'fund_transfers';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($data) {
        try {
            $query = "INSERT INTO {$this->table} 
                      (transaction_id, from_account_id, to_account_id, amount, transfer_type, status, description, created_at)
                      VALUES 
                      (:transaction_id, :from_account_id, :to_account_id, :amount, :transfer_type, :status, :description, NOW())";
            
            $params = [
                ':transaction_id' => $data['transaction_id'],
                ':from_account_id' => $data['from_account_id'],
                ':to_account_id' => $data['to_account_id'],
                ':amount' => $data['amount'],
                ':transfer_type' => $data['transfer_type'],
                ':status' => $data['status'] ?? 'completed',
                ':description' => $data['description'] ?? ''
            ];
            
            $this->db->execute($query, $params);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("FundTransfer create error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getTransferById($id) {
        try {
            $query = "SELECT ft.*, 
                      a1.account_number as from_account_number,
                      a2.account_number as to_account_number,
                      t.reference_number
                      FROM {$this->table} ft
                      JOIN transactions t ON ft.transaction_id = t.id
                      JOIN accounts a1 ON ft.from_account_id = a1.id
                      JOIN accounts a2 ON ft.to_account_id = a2.id
                      WHERE ft.id = :id
                      LIMIT 1";
            
            $params = [':id' => $id];
            
            return $this->db->fetchRow($query, $params);
        } catch (PDOException $e) {
            error_log("FundTransfer getTransferById error: " . $e->getMessage());
            return null;
        }
    }
    
    public function getTransfersByUserId($userId, $limit = 10, $offset = 0) {
        try {
            $query = "SELECT ft.*, 
                      a1.account_number as from_account_number,
                      a2.account_number as to_account_number,
                      t.reference_number, t.created_at
                      FROM {$this->table} ft
                      JOIN transactions t ON ft.transaction_id = t.id
                      JOIN accounts a1 ON ft.from_account_id = a1.id
                      JOIN accounts a2 ON ft.to_account_id = a2.id
                      WHERE a1.user_id = :user_id OR a2.user_id = :user_id
                      ORDER BY ft.created_at DESC
                      LIMIT :limit OFFSET :offset";
            
            $params = [
                ':user_id' => $userId,
                ':limit' => $limit,
                ':offset' => $offset
            ];
            
            return $this->db->fetchAll($query, $params);
        } catch (PDOException $e) {
            error_log("FundTransfer getTransfersByUserId error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getTransfersByTransactionId($transactionId) {
        try {
            $query = "SELECT ft.*, 
                      a1.account_number as from_account_number,
                      a2.account_number as to_account_number
                      FROM {$this->table} ft
                      JOIN accounts a1 ON ft.from_account_id = a1.id
                      JOIN accounts a2 ON ft.to_account_id = a2.id
                      WHERE ft.transaction_id = :transaction_id";
            
            $params = [':transaction_id' => $transactionId];
            
            return $this->db->fetchAll($query, $params);
        } catch (PDOException $e) {
            error_log("FundTransfer getTransfersByTransactionId error: " . $e->getMessage());
            return [];
        }
    }
    
    public function beginTransaction() {
        return $this->db->beginTransaction();
    }
    
    public function commit() {
        return $this->db->commit();
    }
    
    public function rollback() {
        return $this->db->rollback();
    }
} 
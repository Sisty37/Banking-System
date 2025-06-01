<?php
require_once __DIR__ . '/../core/Database.php';

class ContactMessage {
    private $db;
    private $table = 'contact_messages';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($data) {
        try {
            $query = "INSERT INTO {$this->table} 
                      (name, email, subject, message, user_id, status, created_at)
                      VALUES 
                      (:name, :email, :subject, :message, :user_id, :status, NOW())";
            
            $params = [
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':subject' => $data['subject'],
                ':message' => $data['message'],
                ':user_id' => $data['user_id'] ?? null,
                ':status' => $data['status'] ?? 'unread'
            ];
            
            return $this->db->execute($query, $params);
        } catch (PDOException $e) {
            error_log("ContactMessage create error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getMessageById($id) {
        try {
            $query = "SELECT * FROM {$this->table} 
                      WHERE id = :id
                      LIMIT 1";
            
            $params = [':id' => $id];
            
            return $this->db->fetchRow($query, $params);
        } catch (PDOException $e) {
            error_log("ContactMessage getMessageById error: " . $e->getMessage());
            return null;
        }
    }
    
    public function getMessagesByUserId($userId) {
        try {
            $query = "SELECT * FROM {$this->table} 
                      WHERE user_id = :user_id
                      ORDER BY created_at DESC";
            
            $params = [':user_id' => $userId];
            
            return $this->db->fetchAll($query, $params);
        } catch (PDOException $e) {
            error_log("ContactMessage getMessagesByUserId error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getAllMessages($limit = 10, $offset = 0) {
        try {
            $query = "SELECT * FROM {$this->table} 
                      ORDER BY created_at DESC
                      LIMIT :limit OFFSET :offset";
            
            $params = [
                ':limit' => $limit,
                ':offset' => $offset
            ];
            
            return $this->db->fetchAll($query, $params);
        } catch (PDOException $e) {
            error_log("ContactMessage getAllMessages error: " . $e->getMessage());
            return [];
        }
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
    
    public function deleteMessage($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = [':id' => $id];
        
        return $this->db->execute($query, $params);
    }
    
    public function countUnreadMessages() {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'unread'";
        $result = $this->db->fetchRow($query);
        
        return $result ? $result['count'] : 0;
    }
    
    public function countTotalMessages() {
        $query = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->fetchRow($query);
        
        return $result ? $result['count'] : 0;
    }
    
    public function saveResponse($id, $response) {
        $query = "UPDATE {$this->table} 
                  SET response = :response, 
                      status = 'responded',
                      response_date = NOW(),
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':response' => $response
        ];
        
        return $this->db->execute($query, $params);
    }
}

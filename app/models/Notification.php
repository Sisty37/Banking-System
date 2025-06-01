<?php
require_once __DIR__ . '/../core/Database.php';

class Notification {
    private $db;
    private $table = 'notifications';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($data) {
        $query = "INSERT INTO {$this->table} 
                  (user_id, title, message, notification_type, is_read, created_at)
                  VALUES 
                  (:user_id, :title, :message, :notification_type, :is_read, NOW())";
        
        $params = [
            ':user_id' => $data['user_id'],
            ':title' => $data['title'],
            ':message' => $data['message'],
            ':notification_type' => $data['notification_type'],
            ':is_read' => $data['is_read'] ?? 0
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function getNotificationsByUserId($userId, $limit = 10, $offset = 0) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE user_id = :user_id
                  ORDER BY created_at DESC
                  LIMIT :limit OFFSET :offset";
        
        $params = [
            ':user_id' => $userId,
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function getUnreadNotifications($userId) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE user_id = :user_id AND is_read = 0
                  ORDER BY created_at DESC";
        
        $params = [':user_id' => $userId];
        
        return $this->db->fetchAll($query, $params);
    }
    
    public function getNotificationById($id) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE id = :id
                  LIMIT 1";
        
        $params = [':id' => $id];
        
        return $this->db->fetchRow($query, $params);
    }
    
    public function markAsRead($id) {
        $query = "UPDATE {$this->table} 
                  SET is_read = 1, 
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [':id' => $id];
        
        return $this->db->execute($query, $params);
    }
    
    public function markAllAsRead($userId) {
        $query = "UPDATE {$this->table} 
                  SET is_read = 1, 
                      updated_at = NOW()
                  WHERE user_id = :user_id AND is_read = 0";
        
        $params = [':user_id' => $userId];
        
        return $this->db->execute($query, $params);
    }
    
    public function deleteNotification($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = [':id' => $id];
        
        return $this->db->execute($query, $params);
    }
    
    public function countUnreadNotifications($userId) {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = :user_id AND is_read = 0";
        $params = [':user_id' => $userId];
        
        $result = $this->db->fetchRow($query, $params);
        
        return $result ? $result['count'] : 0;
    }
    
    // Helper methods for creating specific notification types
    public function createTransactionNotification($userId, $transactionType, $amount, $accountNumber) {
        $title = "New " . ucfirst($transactionType);
        $message = "A new {$transactionType} transaction of $" . number_format($amount, 2) . " has been processed on account {$accountNumber}.";
        
        return $this->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'notification_type' => 'transaction',
            'is_read' => 0
        ]);
    }
    
    public function createBillPaymentNotification($userId, $billerName, $amount, $accountNumber) {
        $title = "Bill Payment Processed";
        $message = "Your payment of $" . number_format($amount, 2) . " to {$billerName} has been processed from account {$accountNumber}.";
        
        return $this->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'notification_type' => 'transaction',
            'is_read' => 0
        ]);
    }
    
    public function createAccountNotification($userId, $action, $accountType, $accountNumber) {
        $title = "Account " . ucfirst($action);
        $message = "Your {$accountType} account ({$accountNumber}) has been {$action}.";
        
        return $this->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'notification_type' => 'general',
            'is_read' => 0
        ]);
    }
    
    public function createSecurityNotification($userId, $action, $details) {
        $title = "Security Alert";
        $message = "Security alert: {$action}. {$details}";
        
        return $this->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'notification_type' => 'security',
            'is_read' => 0
        ]);
    }
    
    public function createAccountOpenNotification($userId, $accountType, $accountNumber) {
        $title = "New Account Created";
        $message = "Your new {$accountType} account ({$accountNumber}) has been successfully opened.";
        
        return $this->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'notification_type' => 'account',
            'is_read' => 0
        ]);
    }
}

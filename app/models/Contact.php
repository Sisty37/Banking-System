<?php
require_once __DIR__ . '/../core/Database.php';

class Contact {
    private $db;
    private $table = 'contact_messages';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($data) {
        $query = "INSERT INTO {$this->table} (name, email, subject, message, created_at)
                  VALUES (:name, :email, :subject, :message, NOW())";
        
        $params = [
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':subject' => $data['subject'],
            ':message' => $data['message']
        ];
        
        try {
            return $this->db->execute($query, $params);
        } catch (PDOException $e) {
            // If table doesn't exist, create it first
            if ($e->getCode() == '42S02') { // Table not found error code
                $this->createContactTable();
                // Try again
                return $this->db->execute($query, $params);
            }
            throw $e;
        }
    }
    
    public function getAll($limit = 10, $offset = 0) {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $params = [
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        try {
            return $this->db->fetchAll($query, $params);
        } catch (PDOException $e) {
            // If table doesn't exist, return empty array
            if ($e->getCode() == '42S02') { // Table not found error code
                $this->createContactTable();
                return [];
            }
            throw $e;
        }
    }
    
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = [':id' => $id];
        
        try {
            return $this->db->fetchRow($query, $params);
        } catch (PDOException $e) {
            // If table doesn't exist, return null
            if ($e->getCode() == '42S02') { // Table not found error code
                $this->createContactTable();
                return null;
            }
            throw $e;
        }
    }
    
    private function createContactTable() {
        $query = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            status ENUM('new', 'read', 'responded') DEFAULT 'new',
            created_at DATETIME NOT NULL,
            updated_at DATETIME NULL
        )";
        
        return $this->db->execute($query);
    }
} 
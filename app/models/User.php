<?php
require_once __DIR__ . '/../core/Database.php';

class User {
    private $db;
    private $table = 'users';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($data) {
        $query = "INSERT INTO {$this->table} (first_name, last_name, email, date_of_birth, password, role, email_verified, created_at)
                  VALUES (:first_name, :last_name, :email, :date_of_birth, :password, :role, :email_verified, NOW())";
        
        $params = [
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':date_of_birth' => $data['date_of_birth'],
            ':password' => $data['password'],
            ':role' => $data['role'] ?? 'user',
            ':email_verified' => $data['email_verified'] ?? 1
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function findByEmail($email) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $params = [':email' => $email];
        
        $user = $this->db->fetchRow($query, $params);
        
        // Set default value for is_active if it doesn't exist
        if ($user && !isset($user['is_active'])) {
            $user['is_active'] = 1; // Default to active
        }
        
        return $user;
    }
    
    public function findById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $params = [':id' => $id];
        
        $user = $this->db->fetchRow($query, $params);
        
        // Set default value for is_active if it doesn't exist
        if ($user && !isset($user['is_active'])) {
            $user['is_active'] = 1; // Default to active
        }
        
        return $user;
    }
    
    public function getUserById($id) {
        return $this->findById($id);
    }
    
    public function updateProfile($id, $data) {
        $query = "UPDATE {$this->table} 
                  SET first_name = :first_name, 
                      last_name = :last_name, 
                      date_of_birth = :date_of_birth, 
                      phone = :phone, 
                      address = :address,
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':date_of_birth' => $data['date_of_birth'],
            ':phone' => $data['phone'] ?? null,
            ':address' => $data['address'] ?? null
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function updatePassword($id, $password) {
        $query = "UPDATE {$this->table} 
                  SET password = :password, 
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':password' => $password
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function updateUser($id, $data) {
        $query = "UPDATE {$this->table} 
                  SET name = :name, 
                      email = :email, 
                      is_admin = :is_admin, 
                      is_active = :is_active,
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':is_admin' => $data['is_admin'],
            ':is_active' => $data['is_active']
        ];
        
        return $this->db->execute($query, $params);
    }
    
    public function deleteUser($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = [':id' => $id];
        
        return $this->db->execute($query, $params);
    }
    
    public function getAllUsers($limit = 10, $offset = 0) {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $params = [
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        $users = $this->db->fetchAll($query, $params);
        
        // Set default value for is_active for each user if it doesn't exist
        foreach ($users as &$user) {
            if (!isset($user['is_active'])) {
                $user['is_active'] = 1; // Default to active
            }
        }
        
        return $users;
    }
    
    public function countUsers() {
        $query = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->fetchRow($query);
        
        return $result ? $result['count'] : 0;
    }
    
    public function getTotalUsers() {
        return $this->countUsers();
    }
    
    public function getRecentUsers($limit = 5) {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit";
        $params = [':limit' => $limit];
        
        $users = $this->db->fetchAll($query, $params);
        
        // Set default value for is_active for each user if it doesn't exist
        foreach ($users as &$user) {
            if (!isset($user['is_active'])) {
                $user['is_active'] = 1; // Default to active
            }
        }
        
        return $users;
    }
    
    public function searchUsers($query, $limit = 10, $offset = 0) {
        $searchQuery = "SELECT * FROM {$this->table} 
                        WHERE name LIKE :query 
                        OR email LIKE :query 
                        ORDER BY id DESC 
                        LIMIT :limit OFFSET :offset";
        
        $params = [
            ':query' => "%{$query}%",
            ':limit' => $limit,
            ':offset' => $offset
        ];
        
        $users = $this->db->fetchAll($searchQuery, $params);
        
        // Set default value for is_active for each user if it doesn't exist
        foreach ($users as &$user) {
            if (!isset($user['is_active'])) {
                $user['is_active'] = 1; // Default to active
            }
        }
        
        return $users;
    }
    
    public function countSearchResults($query) {
        $searchQuery = "SELECT COUNT(*) as count FROM {$this->table} 
                        WHERE name LIKE :query 
                        OR email LIKE :query";
        
        $params = [':query' => "%{$query}%"];
        
        $result = $this->db->fetchRow($searchQuery, $params);
        return $result ? $result['count'] : 0;
    }

    public function updateRememberToken($userId, $token = null) {
        $query = "UPDATE {$this->table} 
                  SET remember_token = :remember_token,
                      updated_at = NOW()
                  WHERE id = :id";
        
        $params = [
            ':id' => $userId,
            ':remember_token' => $token
        ];
        
        return $this->db->execute($query, $params);
    }

    public function findByRememberToken($token) {
        if (empty($token)) {
            return null;
        }

        $query = "SELECT * FROM {$this->table} WHERE remember_token = :token LIMIT 1";
        $params = [':token' => $token];
        
        return $this->db->fetchRow($query, $params);
    }
}


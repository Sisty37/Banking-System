<?php
require_once __DIR__ . '/../config/config.php';

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $stmt;
    private $error;
    
    public function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        
        // Set options
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        
        // Create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            
            // Ensure required columns exist in tables
            $this->ensureRequiredColumns();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log('Database Error: ' . $this->error);
            die('Database connection failed. Please try again later.');
        }
    }
    
    /**
     * Ensure required columns exist in database tables
     */
    private function ensureRequiredColumns() {
        try {
            // Check and add is_active column to users table if it doesn't exist
            $this->dbh->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS is_active TINYINT(1) NOT NULL DEFAULT 1");
        } catch (PDOException $e) {
            // Suppress specific errors like column already exists
            if (strpos($e->getMessage(), '1060') === false) { // 1060 is MySQL error code for duplicate column
                error_log('Column creation error: ' . $e->getMessage());
            }
        }
    }
    
    // Prepare statement with query
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }
    
    // Bind values
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        
        $this->stmt->bindValue($param, $value, $type);
    }
    
    // Execute the prepared statement
    public function execute($query = null, $params = []) {
        if ($query) {
            $this->query($query);
        }
        
        if (!empty($params)) {
            foreach ($params as $param => $value) {
                $this->bind($param, $value);
            }
        }
        
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log('Query Error: ' . $this->error);
            throw $e; // Re-throw to allow models to handle specific errors
        }
    }
    
    // Get result set as array of objects
    public function fetchAll($query = null, $params = []) {
        try {
            if ($query) {
                $this->query($query);
                
                if (!empty($params)) {
                    foreach ($params as $param => $value) {
                        $this->bind($param, $value);
                    }
                }
                
                $this->stmt->execute();
            }
            
            return $this->stmt->fetchAll();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log('FetchAll Error: ' . $this->error);
            throw $e; // Re-throw to allow models to handle specific errors
        }
    }
    
    // Get single record as object
    public function fetchRow($query = null, $params = []) {
        try {
            if ($query) {
                $this->query($query);
                
                if (!empty($params)) {
                    foreach ($params as $param => $value) {
                        $this->bind($param, $value);
                    }
                }
                
                $this->stmt->execute();
            }
            
            return $this->stmt->fetch();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log('FetchRow Error: ' . $this->error);
            throw $e; // Re-throw to allow models to handle specific errors
        }
    }
    
    // Get row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }
    
    // Get last inserted ID
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
    
    // Begin a transaction
    public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }
    
    // Commit a transaction
    public function commit() {
        return $this->dbh->commit();
    }
    
    // Rollback a transaction
    public function rollback() {
        return $this->dbh->rollBack();
    }
}

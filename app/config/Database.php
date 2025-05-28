<?php
class Database {
    private $host = "localhost";
<<<<<<< HEAD
    private $db_name = "banking_system";
    private $username = "root";
    private $password = "";
    private $conn;
    public function getConnection() {
        $this->conn = null;
=======
    private $db_name = "banking_system
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
<<<<<<< HEAD
        return $this->conn;
    }
}
?> 
=======

        return $this->conn;
    }
}
?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

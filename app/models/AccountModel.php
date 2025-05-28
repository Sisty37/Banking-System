<?php
class AccountModel {
    private $db;
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function __construct() {
        require_once __DIR__ . '/../config/Database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserAccounts($userId) {
        $query = "SELECT * FROM accounts WHERE user_id = :user_id ORDER BY account_type";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAccountById($accountId) {
        $query = "SELECT * FROM accounts WHERE account_id = :account_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_id', $accountId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAccountByNumber($accountNumber) {
        $query = "SELECT * FROM accounts WHERE account_number = :account_number";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_number', $accountNumber);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function createAccount($data) {
        $query = "INSERT INTO accounts 
                  (user_id, account_number, account_type, balance, currency, interest_rate, credit_limit) 
                  VALUES 
                  (:user_id, :account_number, :account_type, :balance, :currency, :interest_rate, :credit_limit)";
<<<<<<< HEAD
=======
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':account_number', $data['account_number']);
        $stmt->bindParam(':account_type', $data['account_type']);
        $stmt->bindParam(':balance', $data['balance']);
        $stmt->bindParam(':currency', $data['currency']);
        $stmt->bindParam(':interest_rate', $data['interest_rate']);
        $stmt->bindParam(':credit_limit', $data['credit_limit']);
<<<<<<< HEAD
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    public function updateAccount($accountId, $data) {
        $updateFields = [];
        $params = [':account_id' => $accountId];
=======
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    public function updateAccount($accountId, $data) {
        $updateFields = [];
        $params = [':account_id' => $accountId];
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        foreach ($data as $key => $value) {
            if ($key !== 'account_id') {
                $updateFields[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }
<<<<<<< HEAD
        if (empty($updateFields)) {
            return false; 
        }
        $query = "UPDATE accounts SET " . implode(', ', $updateFields) . " WHERE account_id = :account_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
    public function updateBalance($accountId, $amount) {
        $this->db->beginTransaction();
=======
        
        if (empty($updateFields)) {
            return false;
        }
        
        $query = "UPDATE accounts SET " . implode(', ', $updateFields) . " WHERE account_id = :account_id";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute($params);
    }

    public function updateBalance($accountId, $amount) {
        $this->db->beginTransaction();
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        try {
            $query = "SELECT balance FROM accounts WHERE account_id = :account_id FOR UPDATE";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':account_id', $accountId);
            $stmt->execute();
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if (!$account) {
                $this->db->rollBack();
                return false;
            }
<<<<<<< HEAD
            $newBalance = $account['balance'] + $amount;
=======
            
            $newBalance = $account['balance'] + $amount;
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "UPDATE accounts SET balance = :balance, updated_at = CURRENT_TIMESTAMP WHERE account_id = :account_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':balance', $newBalance);
            $stmt->bindParam(':account_id', $accountId);
            $stmt->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $transactionType = $amount > 0 ? 'Deposit' : 'Withdrawal';
            $query = "INSERT INTO transactions 
                      (account_id, transaction_type, amount, balance_after, description) 
                      VALUES 
                      (:account_id, :transaction_type, :amount, :balance_after, :description)";
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':account_id', $accountId);
            $stmt->bindParam(':transaction_type', $transactionType);
            $stmt->bindParam(':amount', abs($amount));
            $stmt->bindParam(':balance_after', $newBalance);
            $description = $amount > 0 ? 'Deposit to account' : 'Withdrawal from account';
            $stmt->bindParam(':description', $description);
            $stmt->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function closeAccount($accountId) {
        $query = "UPDATE accounts SET is_active = 0, updated_at = CURRENT_TIMESTAMP WHERE account_id = :account_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_id', $accountId);
        return $stmt->execute();
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAccountTransactions($accountId, $limit = 10, $offset = 0) {
        $query = "SELECT * FROM transactions 
                  WHERE account_id = :account_id AND is_visible = 1
                  ORDER BY transaction_date DESC
                  LIMIT :limit OFFSET :offset";
<<<<<<< HEAD
=======
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_id', $accountId);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAccountBalance($accountId) {
        $query = "SELECT balance FROM accounts WHERE account_id = :account_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_id', $accountId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['balance'] : 0;
    }
<<<<<<< HEAD
    public function generateAccountNumber() {
        $accountNumber = mt_rand(1000000000, 9999999999);
=======

    public function generateAccountNumber() {
        $accountNumber = mt_rand(1000000000, 9999999999);
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $query = "SELECT COUNT(*) as count FROM accounts WHERE account_number = :account_number";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_number', $accountNumber);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
<<<<<<< HEAD
        if ($result['count'] > 0) {
            return $this->generateAccountNumber();
        }
        return $accountNumber;
    }
} 
=======
        
        if ($result['count'] > 0) {
            return $this->generateAccountNumber();
        }
        
        return $accountNumber;
    }
}
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

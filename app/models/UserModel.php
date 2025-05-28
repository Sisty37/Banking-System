<?php
class UserModel {
    private $db;
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=banking_system", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function login($email, $password) {
        $query = "SELECT u.*, r.role_name 
                 FROM users u
                 LEFT JOIN user_roles ur ON u.user_id = ur.user_id
                 LEFT JOIN roles r ON ur.role_id = r.role_id
                 WHERE u.email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
<<<<<<< HEAD
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
=======
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function register($firstName, $lastName, $email, $dob, $password) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
<<<<<<< HEAD
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Email already exists"];
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO users (first_name, last_name, email, date_of_birth, password) 
                    VALUES (:firstName, :lastName, :email, :dob, :password)";
=======
        
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Email already exists"];
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->beginTransaction();
        
        try {
            $query = "INSERT INTO users (first_name, last_name, email, date_of_birth, password) 
                    VALUES (:firstName, :lastName, :email, :dob, :password)";
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();
<<<<<<< HEAD
            $userId = $this->db->lastInsertId();
=======
            
            $userId = $this->db->lastInsertId();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "INSERT INTO user_roles (user_id, role_id) VALUES (:userId, 6)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
<<<<<<< HEAD
            $accountNumber = $this->generateUniqueAccountNumber();
=======
            
            $accountNumber = $this->generateUniqueAccountNumber();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "INSERT INTO accounts (user_id, account_number, account_type, balance, is_active) 
                    VALUES (:userId, :accountNumber, 'Savings', 0.00, 1)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':accountNumber', $accountNumber);
            $stmt->execute();
<<<<<<< HEAD
            $this->db->commit();
=======
            
            $this->db->commit();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return ["success" => true, "message" => "Registration successful. Your account number is " . $accountNumber];
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ["success" => false, "message" => "Registration failed: " . $e->getMessage()];
        }
    }
<<<<<<< HEAD
    public function generateUniqueAccountNumber() {
        $isUnique = false;
        $accountNumber = '';
=======
    
    public function generateUniqueAccountNumber() {
        $isUnique = false;
        $accountNumber = '';
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        while (!$isUnique) {
            $accountNumber = '10' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            $query = "SELECT COUNT(*) FROM accounts WHERE account_number = :accountNumber";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':accountNumber', $accountNumber);
            $stmt->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if ($stmt->fetchColumn() == 0) {
                $isUnique = true;
            }
        }
<<<<<<< HEAD
        return $accountNumber;
    }
    public function resetPassword($email, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
=======
        
        return $accountNumber;
    }
    
    public function resetPassword($email, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $query = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
<<<<<<< HEAD
        return $stmt->execute();
    }
=======
        
        return $stmt->execute();
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserRole($userId) {
        $query = "SELECT r.role_name 
                 FROM roles r
                 JOIN user_roles ur ON r.role_id = ur.role_id
                 WHERE ur.user_id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
<<<<<<< HEAD
        return $stmt->fetchColumn();
    }
=======
        
        return $stmt->fetchColumn();
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAllUsers() {
        $query = "SELECT u.*, r.role_name 
                 FROM users u
                 LEFT JOIN user_roles ur ON u.user_id = ur.user_id
                 LEFT JOIN roles r ON ur.role_id = r.role_id
                 ORDER BY u.user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
<<<<<<< HEAD
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
=======
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserById($userId) {
        $query = "SELECT u.*, r.role_id, r.role_name 
                 FROM users u
                 LEFT JOIN user_roles ur ON u.user_id = ur.user_id
                 LEFT JOIN roles r ON ur.role_id = r.role_id
                 WHERE u.user_id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
<<<<<<< HEAD
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
=======
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAllRoles() {
        $query = "SELECT * FROM roles ORDER BY role_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
<<<<<<< HEAD
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
=======
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function updateUserRole($userId, $roleId) {
        $query = "SELECT * FROM user_roles WHERE user_id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
<<<<<<< HEAD
=======
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        if ($stmt->rowCount() > 0) {
            $query = "UPDATE user_roles SET role_id = :roleId WHERE user_id = :userId";
        } else {
            $query = "INSERT INTO user_roles (user_id, role_id) VALUES (:userId, :roleId)";
        }
<<<<<<< HEAD
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':roleId', $roleId);
        return $stmt->execute();
    }
    public function deleteUser($userId) {
        $this->db->beginTransaction();
=======
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':roleId', $roleId);
        
        return $stmt->execute();
    }
    
    public function deleteUser($userId) {
        $this->db->beginTransaction();
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        try {
            $query = "DELETE FROM user_roles WHERE user_id = :userId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "DELETE FROM users WHERE user_id = :userId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
<<<<<<< HEAD
            $this->db->commit();
=======
            
            $this->db->commit();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function createUser($firstName, $lastName, $email, $dob, $password, $roleId) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
<<<<<<< HEAD
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Email already exists"];
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO users (first_name, last_name, email, date_of_birth, password, is_active) 
                    VALUES (:firstName, :lastName, :email, :dob, :password, 1)";
=======
        
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Email already exists"];
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->beginTransaction();
        
        try {
            $query = "INSERT INTO users (first_name, last_name, email, date_of_birth, password, is_active) 
                    VALUES (:firstName, :lastName, :email, :dob, :password, 1)";
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();
<<<<<<< HEAD
            $userId = $this->db->lastInsertId();
=======
            
            $userId = $this->db->lastInsertId();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "INSERT INTO user_roles (user_id, role_id) VALUES (:userId, :roleId)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':roleId', $roleId);
            $stmt->execute();
<<<<<<< HEAD
            $this->db->commit();
=======
            
            $this->db->commit();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return ["success" => true, "message" => "User created successfully"];
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ["success" => false, "message" => "User creation failed: " . $e->getMessage()];
        }
    }
<<<<<<< HEAD
    public function updateUser($userId, $firstName, $lastName, $email, $dob, $roleId, $isActive) {
        $this->db->beginTransaction();
=======
    
    public function updateUser($userId, $firstName, $lastName, $email, $dob, $roleId, $isActive) {
        $this->db->beginTransaction();
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        try {
            $query = "UPDATE users SET 
                    first_name = :firstName, 
                    last_name = :lastName, 
                    email = :email, 
                    date_of_birth = :dob, 
                    is_active = :isActive 
                    WHERE user_id = :userId";
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':isActive', $isActive, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
<<<<<<< HEAD
            if ($roleId) {
                $this->updateUserRole($userId, $roleId);
            }
            $this->db->commit();
=======
            
            if ($roleId) {
                $this->updateUserRole($userId, $roleId);
            }
            
            $this->db->commit();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return ["success" => true, "message" => "User updated successfully"];
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ["success" => false, "message" => "User update failed: " . $e->getMessage()];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserAccounts($userId) {
        $query = "SELECT * FROM accounts WHERE user_id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
<<<<<<< HEAD
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAccountDetails($accountId) {
        $query = "SELECT a.*, u.first_name, u.last_name, u.email 
                 FROM accounts a
=======
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAccountDetails($accountId) {
        $query = "SELECT a.*, u.first_name, u.last_name, u.email 
                 FROM accounts a17:40
                 
                 
                 
                 2
                 
                 
                 
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                 JOIN users u ON a.user_id = u.user_id
                 WHERE a.account_id = :accountId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':accountId', $accountId);
        $stmt->execute();
<<<<<<< HEAD
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
=======
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getRecentTransactions($accountId, $limit = 5) {
        $query = "SELECT * FROM transactions 
                 WHERE account_id = :accountId 
                 ORDER BY transaction_date DESC 
                 LIMIT :limit";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':accountId', $accountId);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
<<<<<<< HEAD
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
=======
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function createAccount($userId, $accountNumber, $accountType, $initialBalance = 0.00) {
        try {
            $query = "SELECT * FROM users WHERE user_id = :userId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
<<<<<<< HEAD
            if ($stmt->rowCount() == 0) {
                return ["success" => false, "message" => "User not found"];
            }
=======
            
            if ($stmt->rowCount() == 0) {
                return ["success" => false, "message" => "User not found"];
            }
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "INSERT INTO accounts (user_id, account_number, account_type, balance, is_active) 
                    VALUES (:userId, :accountNumber, :accountType, :balance, 1)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':accountNumber', $accountNumber);
            $stmt->bindParam(':accountType', $accountType);
            $stmt->bindParam(':balance', $initialBalance);
            $stmt->execute();
<<<<<<< HEAD
            $accountId = $this->db->lastInsertId();
=======
            
            $accountId = $this->db->lastInsertId();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if ($initialBalance > 0) {
                $query = "INSERT INTO transactions (account_id, transaction_type, amount, description, balance_after) 
                        VALUES (:accountId, 'deposit', :amount, 'Initial deposit', :balance)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':accountId', $accountId);
                $stmt->bindParam(':amount', $initialBalance);
                $stmt->bindParam(':balance', $initialBalance);
                $stmt->execute();
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return [
                "success" => true, 
                "message" => "Account created successfully", 
                "account_id" => $accountId,
                "account_number" => $accountNumber
            ];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error creating account: " . $e->getMessage()];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAccountByNumber($accountNumber) {
        $query = "SELECT * FROM accounts WHERE account_number = :accountNumber";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':accountNumber', $accountNumber);
        $stmt->execute();
<<<<<<< HEAD
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function transferFunds($fromAccountId, $toAccountId, $amount, $description = 'Fund Transfer') {
        $this->db->beginTransaction();
=======
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function transferFunds($fromAccountId, $toAccountId, $amount, $description = 'Fund Transfer') {
        $this->db->beginTransaction();
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        try {
            $queryFrom = "SELECT * FROM accounts WHERE account_id = :accountId";
            $stmtFrom = $this->db->prepare($queryFrom);
            $stmtFrom->bindParam(':accountId', $fromAccountId);
            $stmtFrom->execute();
            $fromAccount = $stmtFrom->fetch(PDO::FETCH_ASSOC);
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $queryTo = "SELECT * FROM accounts WHERE account_id = :accountId";
            $stmtTo = $this->db->prepare($queryTo);
            $stmtTo->bindParam(':accountId', $toAccountId);
            $stmtTo->execute();
            $toAccount = $stmtTo->fetch(PDO::FETCH_ASSOC);
<<<<<<< HEAD
            $newFromBalance = $fromAccount['balance'] - $amount;
            $newToBalance = $toAccount['balance'] + $amount;
=======
            
            $newFromBalance = $fromAccount['balance'] - $amount;
            $newToBalance = $toAccount['balance'] + $amount;
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $updateFrom = "UPDATE accounts SET balance = :balance WHERE account_id = :accountId";
            $stmtUpdateFrom = $this->db->prepare($updateFrom);
            $stmtUpdateFrom->bindParam(':balance', $newFromBalance);
            $stmtUpdateFrom->bindParam(':accountId', $fromAccountId);
            $stmtUpdateFrom->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $updateTo = "UPDATE accounts SET balance = :balance WHERE account_id = :accountId";
            $stmtUpdateTo = $this->db->prepare($updateTo);
            $stmtUpdateTo->bindParam(':balance', $newToBalance);
            $stmtUpdateTo->bindParam(':accountId', $toAccountId);
            $stmtUpdateTo->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $insertWithdrawal = "INSERT INTO transactions (account_id, transaction_type, amount, description, balance_after) 
                               VALUES (:accountId, 'withdrawal', :amount, :description, :balanceAfter)";
            $stmtWithdrawal = $this->db->prepare($insertWithdrawal);
            $stmtWithdrawal->bindParam(':accountId', $fromAccountId);
            $stmtWithdrawal->bindParam(':amount', $amount);
            $stmtWithdrawal->bindParam(':description', $description);
            $stmtWithdrawal->bindParam(':balanceAfter', $newFromBalance);
            $stmtWithdrawal->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $insertDeposit = "INSERT INTO transactions (account_id, transaction_type, amount, description, balance_after) 
                            VALUES (:accountId, 'deposit', :amount, :description, :balanceAfter)";
            $stmtDeposit = $this->db->prepare($insertDeposit);
            $stmtDeposit->bindParam(':accountId', $toAccountId);
            $stmtDeposit->bindParam(':amount', $amount);
            $stmtDeposit->bindParam(':description', $description);
            $stmtDeposit->bindParam(':balanceAfter', $newToBalance);
            $stmtDeposit->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $insertTransfer = "INSERT INTO fund_transfers (from_account_id, to_account_id, amount, description) 
                             VALUES (:fromAccountId, :toAccountId, :amount, :description)";
            $stmtTransfer = $this->db->prepare($insertTransfer);
            $stmtTransfer->bindParam(':fromAccountId', $fromAccountId);
            $stmtTransfer->bindParam(':toAccountId', $toAccountId);
            $stmtTransfer->bindParam(':amount', $amount);
            $stmtTransfer->bindParam(':description', $description);
            $stmtTransfer->execute();
<<<<<<< HEAD
            $this->db->commit();
=======
            
            $this->db->commit();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return [
                "success" => true,
                "message" => "Transfer completed successfully.",
                "amount" => $amount,
                "fromAccount" => $fromAccount['account_number'],
                "toAccount" => $toAccount['account_number'],
                "newFromBalance" => $newFromBalance,
                "newToBalance" => $newToBalance
            ];
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ["success" => false, "message" => "Transfer failed: " . $e->getMessage()];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserByEmail($email) {
        $query = "SELECT u.*, r.role_name 
                 FROM users u
                 LEFT JOIN user_roles ur ON u.user_id = ur.user_id
                 LEFT JOIN roles r ON ur.role_id = r.role_id
                 WHERE u.email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
<<<<<<< HEAD
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
=======
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getTotalUsersCount() {
        try {
            $query = "SELECT COUNT(*) as total FROM users";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Database Error (getTotalUsersCount): " . $e->getMessage());
            return 0;
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getTotalAccountsCount() {
        try {
            $query = "SELECT COUNT(*) as total FROM accounts";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Database Error (getTotalAccountsCount): " . $e->getMessage());
            return 0;
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getTodayTransactionsCount() {
        try {
            $query = "SELECT COUNT(*) as total FROM transactions WHERE DATE(transaction_date) = CURDATE()";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Database Error (getTodayTransactionsCount): " . $e->getMessage());
            return 0;
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getNewUsersTodayCount() {
        try {
            $query = "SELECT COUNT(*) as total FROM users WHERE DATE(created_at) = CURDATE()";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Database Error (getNewUsersTodayCount): " . $e->getMessage());
            return 0;
        }
    }
<<<<<<< HEAD
    public function getRecentSystemActivity($limit = 5) {
        try {
            $activities = [];
=======
    
    public function getRecentSystemActivity($limit = 5) {
        try {
            $activities = [];
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "SELECT 'New User Registration' as title, 
                             CONCAT(first_name, ' ', last_name, ' registered a new account') as description,
                             created_at as timestamp
                      FROM users
                      ORDER BY created_at DESC
                      LIMIT :limit";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
            $statement->execute();
            $userRegistrations = $statement->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "SELECT 
                        CASE 
                            WHEN t.transaction_type = 'deposit' THEN 'Deposit'
                            WHEN t.transaction_type = 'withdrawal' THEN 'Withdrawal'
                            WHEN t.transaction_type = 'transfer' THEN 'Transfer'
                            ELSE 'Transaction'
                        END as title,
                        CONCAT('$', FORMAT(t.amount, 2), ' ', t.transaction_type, ' for account #', a.account_number) as description,
                        t.transaction_date as timestamp
                      FROM transactions t
                      JOIN accounts a ON t.account_id = a.account_id
                      ORDER BY t.transaction_date DESC
                      LIMIT :limit";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
            $statement->execute();
            $recentTransactions = $statement->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD
            $activities = array_merge($userRegistrations, $recentTransactions);
            usort($activities, function($a, $b) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
            });
=======
            
            $activities = array_merge($userRegistrations, $recentTransactions);
            
            usort($activities, function($a, $b) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
            });
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            foreach ($activities as &$activity) {
                $timestamp = strtotime($activity['timestamp']);
                $now = time();
                $diff = $now - $timestamp;
<<<<<<< HEAD
=======
                
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                if ($diff < 60) {
                    $activity['timestamp'] = 'Just now';
                } elseif ($diff < 3600) {
                    $mins = floor($diff / 60);
                    $activity['timestamp'] = $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
                } elseif ($diff < 86400) {
                    $hours = floor($diff / 3600);
                    $activity['timestamp'] = $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
                } elseif ($diff < 172800) {
                    $activity['timestamp'] = 'Yesterday';
                } else {
                    $activity['timestamp'] = date('M d, Y', $timestamp);
                }
            }
<<<<<<< HEAD
            return array_slice($activities, 0, $limit);
=======
            
            return array_slice($activities, 0, $limit);
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        } catch (PDOException $e) {
            error_log("Database Error (getRecentSystemActivity): " . $e->getMessage());
            return [];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAllTransactions($filters = [], $page = 1, $limit = 20) {
        try {
            $query = "SELECT t.*, a.account_number, CONCAT(u.first_name, ' ', u.last_name) as account_holder 
                     FROM transactions t
                     JOIN accounts a ON t.account_id = a.account_id
                     JOIN users u ON a.user_id = u.user_id
                     WHERE 1=1";
<<<<<<< HEAD
            $params = [];
=======
            
            $params = [];
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if (!empty($filters['date_from'])) {
                $query .= " AND DATE(t.transaction_date) >= :dateFrom";
                $params[':dateFrom'] = $filters['date_from'];
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if (!empty($filters['date_to'])) {
                $query .= " AND DATE(t.transaction_date) <= :dateTo";
                $params[':dateTo'] = $filters['date_to'];
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if (!empty($filters['transaction_type'])) {
                $query .= " AND t.transaction_type = :transactionType";
                $params[':transactionType'] = $filters['transaction_type'];
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if (!empty($filters['account_id'])) {
                $query .= " AND t.account_id = :accountId";
                $params[':accountId'] = $filters['account_id'];
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if (isset($filters['min_amount']) && $filters['min_amount'] !== '') {
                $query .= " AND t.amount >= :minAmount";
                $params[':minAmount'] = $filters['min_amount'];
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if (isset($filters['max_amount']) && $filters['max_amount'] !== '') {
                $query .= " AND t.amount <= :maxAmount";
                $params[':maxAmount'] = $filters['max_amount'];
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if (!empty($filters['search'])) {
                $query .= " AND (a.account_number LIKE :search OR t.description LIKE :search)";
                $params[':search'] = "%" . $filters['search'] . "%";
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $countQuery = str_replace("SELECT t.*, a.account_number, CONCAT(u.first_name, ' ', u.last_name) as account_holder", "SELECT COUNT(*) as total", $query);
            $stmt = $this->db->prepare($countQuery);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
<<<<<<< HEAD
            $totalPages = ceil($total / $limit);
            $offset = ($page - 1) * $limit;
            $query .= " ORDER BY t.transaction_date DESC LIMIT :offset, :limit";
            $params[':offset'] = $offset;
            $params[':limit'] = $limit;
=======
            
            $totalPages = ceil($total / $limit);
            $offset = ($page - 1) * $limit;
            
            $query .= " ORDER BY t.transaction_date DESC LIMIT :offset, :limit";
            $params[':offset'] = $offset;
            $params[':limit'] = $limit;
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $stmt = $this->db->prepare($query);
            foreach ($params as $key => $value) {
                if ($key == ':offset' || $key == ':limit') {
                    $stmt->bindValue($key, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($key, $value);
                }
            }
            $stmt->execute();
            $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return [
                'transactions' => $transactions,
                'pagination' => [
                    'total' => $total,
                    'per_page' => $limit,
                    'current_page' => $page,
                    'total_pages' => $totalPages
                ]
            ];
        } catch (PDOException $e) {
            error_log("Database Error (getAllTransactions): " . $e->getMessage());
            return [
                'transactions' => [],
                'pagination' => [
                    'total' => 0,
                    'per_page' => $limit,
                    'current_page' => $page,
                    'total_pages' => 0
                ]
            ];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAccountsForDropdown() {
        try {
            $query = "SELECT a.account_id, 
                            CONCAT(a.account_number, ' (', u.first_name, ' ', u.last_name, ')') as display_name 
                     FROM accounts a
                     JOIN users u ON a.user_id = u.user_id
                     ORDER BY u.last_name, u.first_name";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error (getAccountsForDropdown): " . $e->getMessage());
            return [];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getTransactionStats($period = 'monthly', $limit = 6) {
        try {
            $intervalFormat = '';
            $groupFormat = '';
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            switch ($period) {
                case 'daily':
                    $intervalFormat = 'DAY';
                    $groupFormat = '%Y-%m-%d';
                    break;
                case 'weekly':
                    $intervalFormat = 'WEEK';
<<<<<<< HEAD
                    $groupFormat = '%Y-%u'; 
=======
                    $groupFormat = '%Y-%u';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                    break;
                case 'monthly':
                    $intervalFormat = 'MONTH';
                    $groupFormat = '%Y-%m';
                    break;
                case 'yearly':
                    $intervalFormat = 'YEAR';
                    $groupFormat = '%Y';
                    break;
                default:
                    $intervalFormat = 'MONTH';
                    $groupFormat = '%Y-%m';
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "SELECT 
                        DATE_FORMAT(transaction_date, :groupFormat) as period,
                        COUNT(*) as total_count,
                        SUM(CASE WHEN transaction_type = 'deposit' THEN 1 ELSE 0 END) as deposits,
                        SUM(CASE WHEN transaction_type = 'withdrawal' THEN 1 ELSE 0 END) as withdrawals,
                        SUM(CASE WHEN transaction_type = 'transfer' THEN 1 ELSE 0 END) as transfers,
                        SUM(CASE WHEN transaction_type = 'payment' THEN 1 ELSE 0 END) as payments,
<<<<<<< HEAD
                        SUM(CASE WHEN transaction_type = 'deposit' THEN amount ELSE 0 END) as deposit_amount,
=======
                        SUM(CASE WHEN transaction_type = 'deposit' THEN amount ELSE 0 END) as deposit_amount,17:35
                        
                        
                        
                        2
                        
                        
                        MIRZA SAIKAT AHMMED
                        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                        SUM(CASE WHEN transaction_type = 'withdrawal' THEN amount ELSE 0 END) as withdrawal_amount,
                        SUM(CASE WHEN transaction_type = 'transfer' THEN amount ELSE 0 END) as transfer_amount,
                        SUM(CASE WHEN transaction_type = 'payment' THEN amount ELSE 0 END) as payment_amount
                     FROM transactions
                     GROUP BY period
                     ORDER BY MIN(transaction_date) DESC
                     LIMIT :limit";
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':groupFormat', $groupFormat);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_reverse($result);
        } catch (PDOException $e) {
            error_log("Database Error (getTransactionStats): " . $e->getMessage());
            return [];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserGrowthStats($period = 'monthly', $limit = 6) {
        try {
            $intervalFormat = '';
            $groupFormat = '';
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            switch ($period) {
                case 'daily':
                    $intervalFormat = 'DAY';
                    $groupFormat = '%Y-%m-%d';
                    break;
                case 'weekly':
                    $intervalFormat = 'WEEK';
<<<<<<< HEAD
                    $groupFormat = '%Y-%u'; 
=======
                    $groupFormat = '%Y-%u';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                    break;
                case 'monthly':
                    $intervalFormat = 'MONTH';
                    $groupFormat = '%Y-%m';
                    break;
                case 'yearly':
                    $intervalFormat = 'YEAR';
                    $groupFormat = '%Y';
                    break;
                default:
                    $intervalFormat = 'MONTH';
                    $groupFormat = '%Y-%m';
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $query = "SELECT 
                        DATE_FORMAT(created_at, :groupFormat) as period,
                        COUNT(*) as new_users
                     FROM users
                     GROUP BY period
                     ORDER BY MIN(created_at) DESC
                     LIMIT :limit";
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':groupFormat', $groupFormat);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_reverse($result);
        } catch (PDOException $e) {
            error_log("Database Error (getUserGrowthStats): " . $e->getMessage());
            return [];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getAccountTypeDistribution() {
        try {
            $query = "SELECT 
                        account_type,
                        COUNT(*) as count,
                        SUM(balance) as total_balance
                     FROM accounts
                     GROUP BY account_type
                     ORDER BY COUNT(*) DESC";
<<<<<<< HEAD
            $stmt = $this->db->prepare($query);
            $stmt->execute();
=======
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error (getAccountTypeDistribution): " . $e->getMessage());
            return [];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getSystemSettings() {
        try {
            $query = "SELECT * FROM system_settings ORDER BY setting_name";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $settings = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $settings[$row['setting_name']] = $row['setting_value'];
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return $settings;
        } catch (PDOException $e) {
            error_log("Database Error (getSystemSettings): " . $e->getMessage());
            return [];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function updateSystemSetting($settingName, $settingValue) {
        try {
            $query = "SELECT COUNT(*) FROM system_settings WHERE setting_name = :name";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $settingName);
            $stmt->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            if ($stmt->fetchColumn() > 0) {
                $query = "UPDATE system_settings SET setting_value = :value WHERE setting_name = :name";
            } else {
                $query = "INSERT INTO system_settings (setting_name, setting_value) VALUES (:name, :value)";
            }
<<<<<<< HEAD
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $settingName);
            $stmt->bindParam(':value', $settingValue);
=======
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $settingName);
            $stmt->bindParam(':value', $settingValue);
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error (updateSystemSetting): " . $e->getMessage());
            return false;
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getDefaultSystemSettings() {
        return [
            'bank_name' => 'Modern Banking System',
            'support_email' => 'support@bankingsystem.com',
            'support_phone' => '+1 (555) 123-4567',
            'transaction_fee_percentage' => '1.5',
            'minimum_balance' => '100.00',
            'interest_rate_savings' => '2.5',
            'interest_rate_checking' => '0.5',
            'maintenance_mode' => 'off',
            'maintenance_message' => 'The system is currently undergoing scheduled maintenance. Please try again later.',
            'enable_new_registrations' => 'on',
            'max_login_attempts' => '5',
            'password_expiry_days' => '90',
            'session_timeout_minutes' => '30',
            'enable_2fa' => 'off',
            'notification_emails_enabled' => 'on',
            'notification_sms_enabled' => 'off',
            'system_theme' => 'default',
            'logo_url' => '../../../public/images/logo.png',
            'favicon_url' => '../../../public/images/favicon.ico',
            'currency_symbol' => '$',
            'date_format' => 'M d, Y',
            'time_format' => 'H:i:s',
            'timezone' => 'America/New_York',
            'decimal_places' => '2',
            'allow_password_reset' => 'on',
            'welcome_message' => 'Welcome to our Banking System',
            'terms_and_conditions' => 'Standard terms and conditions apply.',
            'privacy_policy' => 'We protect your privacy according to industry standards.',
            'footer_text' => '© 2023 Banking System. All rights reserved.'
        ];
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserNotifications($userId, $limit = 5) {
        try {
            $query = "SELECT * FROM notifications 
                     WHERE user_id = :userId 
                     ORDER BY created_at DESC 
                     LIMIT :limit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
<<<<<<< HEAD
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
=======
            
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            foreach ($notifications as &$notification) {
                $timestamp = strtotime($notification['created_at']);
                $now = time();
                $diff = $now - $timestamp;
<<<<<<< HEAD
=======
                
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                if ($diff < 60) {
                    $notification['time_ago'] = 'Just now';
                } elseif ($diff < 3600) {
                    $mins = floor($diff / 60);
                    $notification['time_ago'] = $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
                } elseif ($diff < 86400) {
                    $hours = floor($diff / 3600);
                    $notification['time_ago'] = $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
                } elseif ($diff < 172800) {
                    $notification['time_ago'] = 'Yesterday';
                } else {
                    $notification['time_ago'] = date('M d, Y', $timestamp);
                }
            }
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            return $notifications;
        } catch (PDOException $e) {
            error_log("Database Error (getUserNotifications): " . $e->getMessage());
            return [];
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function markNotificationAsRead($notificationId) {
        try {
            $query = "UPDATE notifications 
                     SET is_read = 1 
                     WHERE notification_id = :notificationId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':notificationId', $notificationId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error (markNotificationAsRead): " . $e->getMessage());
            return false;
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUnreadNotificationCount($userId) {
        try {
            $query = "SELECT COUNT(*) as count 
                     FROM notifications 
                     WHERE user_id = :userId AND is_read = 0";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
<<<<<<< HEAD
=======
            
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Database Error (getUnreadNotificationCount): " . $e->getMessage());
            return 0;
        }
    }
}
<<<<<<< HEAD
?> 
=======
?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

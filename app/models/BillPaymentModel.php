<?php
class BillPaymentModel {
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
    public function getBillCategories() {
        $query = "SELECT * FROM bill_categories ORDER BY category_name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getBillCategoryById($categoryId) {
        $query = "SELECT * FROM bill_categories WHERE category_id = :category_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getBillersByCategory($categoryId) {
        $query = "SELECT * FROM billers WHERE category_id = :category_id ORDER BY biller_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getBillerById($billerId) {
        $query = "SELECT * FROM billers WHERE biller_id = :biller_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':biller_id', $billerId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function addSavedBiller($data) {
        $query = "INSERT INTO saved_billers 
                  (user_id, biller_id, account_nickname, account_number) 
                  VALUES 
                  (:user_id, :biller_id, :account_nickname, :account_number)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':biller_id', $data['biller_id']);
        $stmt->bindParam(':account_nickname', $data['account_nickname']);
        $stmt->bindParam(':account_number', $data['account_number']);
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserSavedBillers($userId) {
        $query = "SELECT sb.*, b.biller_name, bc.category_name 
                  FROM saved_billers sb
                  JOIN billers b ON sb.biller_id = b.biller_id
                  JOIN bill_categories bc ON b.category_id = bc.category_id
                  WHERE sb.user_id = :user_id
                  ORDER BY b.biller_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getSavedBillerById($savedBillerId) {
        $query = "SELECT sb.*, b.biller_name, bc.category_name 
                  FROM saved_billers sb
                  JOIN billers b ON sb.biller_id = b.biller_id
                  JOIN bill_categories bc ON b.category_id = bc.category_id
                  WHERE sb.saved_biller_id = :saved_biller_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':saved_biller_id', $savedBillerId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function updateSavedBiller($data) {
        $query = "UPDATE saved_billers 
                  SET account_nickname = :account_nickname, 
                      account_number = :account_number
                  WHERE saved_biller_id = :saved_biller_id 
                  AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_nickname', $data['account_nickname']);
        $stmt->bindParam(':account_number', $data['account_number']);
        $stmt->bindParam(':saved_biller_id', $data['saved_biller_id']);
        $stmt->bindParam(':user_id', $data['user_id']);
        return $stmt->execute();
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function deleteSavedBiller($savedBillerId, $userId) {
        $query = "DELETE FROM saved_billers 
                  WHERE saved_biller_id = :saved_biller_id 
                  AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':saved_biller_id', $savedBillerId);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function makeBillPayment($data) {
        $this->db->beginTransaction();
        try {
            $referenceNumber = $this->generateReferenceNumber();
            $query = "INSERT INTO bill_payments 
                      (user_id, biller_id, account_number, amount, source_account_id, reference_number, payment_date, description) 
                      VALUES 
                      (:user_id, :biller_id, :account_number, :amount, :source_account_id, :reference_number, NOW(), :description)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':biller_id', $data['biller_id']);
            $stmt->bindParam(':account_number', $data['account_number']);
            $stmt->bindParam(':amount', $data['amount']);
            $stmt->bindParam(':source_account_id', $data['source_account_id']);
            $stmt->bindParam(':reference_number', $referenceNumber);
            $stmt->bindParam(':description', $data['description']);
            $stmt->execute();
            $paymentId = $this->db->lastInsertId();
            $query = "UPDATE accounts 
                      SET balance = balance - :amount 
                      WHERE account_id = :account_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':amount', $data['amount']);
            $stmt->bindParam(':account_id', $data['source_account_id']);
            $stmt->execute();
            $query = "INSERT INTO transactions 
                      (account_id, transaction_type, amount, description, reference_number, transaction_date) 
                      VALUES 
                      (:account_id, 'Bill Payment', :amount, :description, :reference_number, NOW())";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':account_id', $data['source_account_id']);
            $stmt->bindParam(':amount', $data['amount']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':reference_number', $referenceNumber);
            $stmt->execute();
            $this->db->commit();
            return $paymentId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserBillPaymentHistory($userId) {
        $query = "SELECT bp.*, b.biller_name, bc.category_name, a.account_number as source_account_number
                  FROM bill_payments bp
                  JOIN billers b ON bp.biller_id = b.biller_id
                  JOIN bill_categories bc ON b.category_id = bc.category_id
                  JOIN accounts a ON bp.source_account_id = a.account_id
                  WHERE bp.user_id = :user_id
                  ORDER BY bp.payment_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getBillPaymentById($paymentId) {
        $query = "SELECT bp.*, b.biller_name, bc.category_name, a.account_number as source_account_number
                  FROM bill_payments bp
                  JOIN billers b ON bp.biller_id = b.biller_id
                  JOIN bill_categories bc ON b.category_id = bc.category_id
                  JOIN accounts a ON bp.source_account_id = a.account_id
                  WHERE bp.payment_id = :payment_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':payment_id', $paymentId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getBillPaymentByReference($referenceNumber) {
        $query = "SELECT bp.*, b.biller_name, bc.category_name, a.account_number as source_account_number
                  FROM bill_payments bp
                  JOIN billers b ON bp.biller_id = b.biller_id
                  JOIN bill_categories bc ON b.category_id = bc.category_id
                  JOIN accounts a ON bp.source_account_id = a.account_id
                  WHERE bp.reference_number = :reference_number";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':reference_number', $referenceNumber);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    private function generateReferenceNumber() {
        $prefix = 'BP';
        $timestamp = date('YmdHis');
        $random = mt_rand(1000, 9999);
        return $prefix . $timestamp . $random;
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function schedulePayment($data) {
        $query = "INSERT INTO scheduled_payments 
                  (user_id, biller_id, account_number, amount, source_account_id, scheduled_date, recurring, frequency, description) 
                  VALUES 
                  (:user_id, :biller_id, :account_number, :amount, :source_account_id, :scheduled_date, :recurring, :frequency, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':biller_id', $data['biller_id']);
        $stmt->bindParam(':account_number', $data['account_number']);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':source_account_id', $data['source_account_id']);
        $stmt->bindParam(':scheduled_date', $data['scheduled_date']);
        $stmt->bindParam(':recurring', $data['recurring']);
        $stmt->bindParam(':frequency', $data['frequency']);
        $stmt->bindParam(':description', $data['description']);
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserScheduledPayments($userId) {
        $query = "SELECT sp.*, b.biller_name, bc.category_name, a.account_number as source_account_number
                  FROM scheduled_payments sp
                  JOIN billers b ON sp.biller_id = b.biller_id
                  JOIN bill_categories bc ON b.category_id = bc.category_id
                  JOIN accounts a ON sp.source_account_id = a.account_id
                  WHERE sp.user_id = :user_id
                  ORDER BY sp.scheduled_date ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function cancelScheduledPayment($scheduledPaymentId, $userId) {
        $query = "DELETE FROM scheduled_payments 
                  WHERE scheduled_payment_id = :scheduled_payment_id 
                  AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':scheduled_payment_id', $scheduledPaymentId);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getUserBillPaymentStatistics($userId) {
        $stats = [];
        $query = "SELECT SUM(amount) as total_paid
                  FROM bill_payments
                  WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $stats['total_paid'] = $stmt->fetchColumn() ?: 0;
        $query = "SELECT COUNT(*) as payment_count
                  FROM bill_payments
                  WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $stats['payment_count'] = $stmt->fetchColumn() ?: 0;
        $query = "SELECT bc.category_name, COUNT(*) as count, SUM(bp.amount) as total
                  FROM bill_payments bp
                  JOIN billers b ON bp.biller_id = b.biller_id
                  JOIN bill_categories bc ON b.category_id = bc.category_id
                  WHERE bp.user_id = :user_id
                  GROUP BY bc.category_id
                  ORDER BY total DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $stats['payments_by_category'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $query = "SELECT DATE_FORMAT(payment_date, '%Y-%m') as month, 
                  SUM(amount) as total
                  FROM bill_payments
                  WHERE user_id = :user_id
                  AND payment_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)
                  GROUP BY DATE_FORMAT(payment_date, '%Y-%m')
                  ORDER BY month ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $stats['monthly_trends'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stats;
    }
}
<<<<<<< HEAD
?> 
=======
?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

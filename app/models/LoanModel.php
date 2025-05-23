<?php
class LoanModel {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../config/Database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getLoanTypes() {
        $query = "SELECT * FROM loan_types ORDER BY type_name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLoanTypeById($loanTypeId) {
        $query = "SELECT * FROM loan_types WHERE loan_type_id = :loan_type_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':loan_type_id', $loanTypeId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function submitLoanApplication($data) {
        $query = "INSERT INTO loan_applications 
                  (user_id, loan_type_id, loan_amount, loan_term_years, purpose, deposit_account_id) 
                  VALUES 
                  (:user_id, :loan_type_id, :loan_amount, :loan_term_years, :purpose, :deposit_account_id)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':loan_type_id', $data['loan_type_id']);
        $stmt->bindParam(':loan_amount', $data['loan_amount']);
        $stmt->bindParam(':loan_term_years', $data['loan_term_years']);
        $stmt->bindParam(':purpose', $data['purpose']);
        $stmt->bindParam(':deposit_account_id', $data['deposit_account_id']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    public function getUserLoanApplications($userId) {
        $query = "SELECT la.*, lt.type_name 
                  FROM loan_applications la
                  JOIN loan_types lt ON la.loan_type_id = lt.loan_type_id
                  WHERE la.user_id = :user_id
                  ORDER BY la.application_date DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserActiveLoans($userId) {
        $query = "SELECT l.*, lt.type_name 
                  FROM loans l
                  JOIN loan_types lt ON l.loan_type_id = lt.loan_type_id
                  WHERE l.user_id = :user_id AND l.status = 'Active'
                  ORDER BY l.next_payment_date ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLoanById($loanId) {
        $query = "SELECT l.*, lt.type_name 
                  FROM loans l
                  JOIN loan_types lt ON l.loan_type_id = lt.loan_type_id
                  WHERE l.loan_id = :loan_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':loan_id', $loanId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLoanByReference($loanReference) {
        $query = "SELECT l.*, lt.type_name 
                  FROM loans l
                  JOIN loan_types lt ON l.loan_type_id = lt.loan_type_id
                  WHERE l.loan_reference = :loan_reference";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':loan_reference', $loanReference);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLoanPaymentHistory($loanId) {
        $query = "SELECT * FROM loan_payments 
                  WHERE loan_id = :loan_id 
                  ORDER BY payment_date DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':loan_id', $loanId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function makeLoanPayment($data) {
        $this->db->beginTransaction();
        
        try {
            $query = "INSERT INTO loan_payments 
                      (loan_id, payment_amount, principal_amount, interest_amount, source_account_id, extra_principal, remaining_balance) 
                      VALUES 
                      (:loan_id, :payment_amount, :principal_amount, :interest_amount, :source_account_id, :extra_principal, :remaining_balance)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':loan_id', $data['loan_id']);
            $stmt->bindParam(':payment_amount', $data['payment_amount']);
            $stmt->bindParam(':principal_amount', $data['principal_amount']);
            $stmt->bindParam(':interest_amount', $data['interest_amount']);
            $stmt->bindParam(':source_account_id', $data['source_account_id']);
            $stmt->bindParam(':extra_principal', $data['extra_principal']);
            $stmt->bindParam(':remaining_balance', $data['remaining_balance']);
            $stmt->execute();
            
            $query = "UPDATE loans 
                      SET remaining_balance = :remaining_balance, 
                          next_payment_date = DATE_ADD(next_payment_date, INTERVAL 1 MONTH),
                          updated_at = CURRENT_TIMESTAMP
                      WHERE loan_id = :loan_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':remaining_balance', $data['remaining_balance']);
            $stmt->bindParam(':loan_id', $data['loan_id']);
            $stmt->execute();
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function calculateLoanPayment($loanAmount, $interestRate, $termYears) {
        $monthlyRate = ($interestRate / 100) / 12;
        $numPayments = $termYears * 12;
        $monthlyPayment = ($loanAmount * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$numPayments));
        $totalPayment = $monthlyPayment * $numPayments;
        $totalInterest = $totalPayment - $loanAmount;
        
        return [
            'monthly_payment' => $monthlyPayment,
            'total_payment' => $totalPayment,
            'total_interest' => $totalInterest,
            'num_payments' => $numPayments
        ];
    }

    public function generateAmortizationSchedule($loanAmount, $interestRate, $termYears) {
        $monthlyRate = ($interestRate / 100) / 12;
        $numPayments = $termYears * 12;
        $monthlyPayment = ($loanAmount * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$numPayments));
        
        $schedule = [];
        $balance = $loanAmount;
        $today = new DateTime();
        
        for ($i = 1; $i <= $numPayments; $i++) {
            $interestPayment = $balance * $monthlyRate;
            $principalPayment = $monthlyPayment - $interestPayment;
            $balance -= $principalPayment;
            if ($balance < 0) {
                $balance = 0;
            }
            $paymentDate = clone $today;
            $paymentDate->modify("+$i month");
            $schedule[] = [
                'payment_number' => $i,
                'payment_date' => $paymentDate->format('Y-m-d'),
                          next_payment_date = DATE_ADD(next_payment_date, INTERVAL 1 MONTH),
                          updated_at = CURRENT_TIMESTAMP
                      WHERE loan_id = :loan_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':remaining_balance', $data['remaining_balance']);
            $stmt->bindParam(':loan_id', $data['loan_id']);
            $stmt->execute();
            
            // Commit the transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Roll back the transaction on error
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Calculate loan payment details
     * @param float $loanAmount Loan amount
     * @param float $interestRate Annual interest rate (percentage)
     * @param int $termYears Loan term in years
     * @return array Payment details
     */
    public function calculateLoanPayment($loanAmount, $interestRate, $termYears) {
        $monthlyRate = ($interestRate / 100) / 12;
        $numPayments = $termYears * 12;
        $monthlyPayment = ($loanAmount * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$numPayments));
        $totalPayment = $monthlyPayment * $numPayments;
        $totalInterest = $totalPayment - $loanAmount;
        
        return [
            'monthly_payment' => $monthlyPayment,
            'total_payment' => $totalPayment,
            'total_interest' => $totalInterest,
            'num_payments' => $numPayments
        ];
    }

    /**
     * Generate amortization schedule
     * @param float $loanAmount Loan amount
     * @param float $interestRate Annual interest rate (percentage)
     * @param int $termYears Loan term in years
     * @return array Amortization schedule
     */
    public function generateAmortizationSchedule($loanAmount, $interestRate, $termYears) {
        $monthlyRate = ($interestRate / 100) / 12;
        $numPayments = $termYears * 12;
        $monthlyPayment = ($loanAmount * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$numPayments));
        
        $schedule = [];
        $balance = $loanAmount;
        $today = new DateTime();
        
        for ($i = 1; $i <= $numPayments; $i++) {
            $interestPayment = $balance * $monthlyRate;
            $principalPayment = $monthlyPayment - $interestPayment;
            $balance -= $principalPayment;
            
            // Ensure balance doesn't go below zero due to rounding
            if ($balance < 0) {
                $balance = 0;
            }
            
            $paymentDate = clone $today;
            $paymentDate->modify("+$i month");
            
            $schedule[] = [
                'payment_number' => $i,
                'payment_date' => $paymentDate->format('Y-m-d'),
                'payment_amount' => $monthlyPayment,
                'principal' => $principalPayment,
                'interest' => $interestPayment,
                'balance' => $balance
            ];
        }
        
        return $schedule;
    }

    /**
     * Get loan statistics for a user
     * @param int $userId User ID
     * @return array Loan statistics
     */
    public function getUserLoanStatistics($userId) {
        $query = "SELECT 
                    SUM(loan_amount) as total_loan_amount, 
                    COUNT(*) as total_loans,
                    SUM(monthly_payment) as total_monthly_payment,
                    AVG(interest_rate) as avg_interest_rate
                  FROM loans 
                  WHERE user_id = :user_id AND status = 'Active'";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 
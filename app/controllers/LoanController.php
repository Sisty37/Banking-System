<?php
class LoanController {
    private $loanModel;
    private $accountModel;
    public function __construct() {
        require_once __DIR__ . '/../models/LoanModel.php';
        require_once __DIR__ . '/../models/AccountModel.php';
        $this->loanModel = new LoanModel();
        $this->accountModel = new AccountModel();
    }
    public function getLoanTypes() {
        return $this->loanModel->getLoanTypes();
    }
    public function getLoanTypeById($loanTypeId) {
        return $this->loanModel->getLoanTypeById($loanTypeId);
    }
    public function submitLoanApplication($userId, $loanTypeId, $loanAmount, $loanTerm, $purpose, $accountId) {
        if (empty($userId) || empty($loanTypeId) || empty($loanAmount) || empty($loanTerm) || empty($purpose) || empty($accountId)) {
            return [
                'success' => false,
                'message' => 'All fields are required'
            ];
        }
        if ($loanAmount < 1000) {
            return [
                'success' => false,
                'message' => 'Loan amount must be at least $1,000'
            ];
        }
        $loanType = $this->getLoanTypeById($loanTypeId);
        if (!$loanType) {
            return [
                'success' => false,
                'message' => 'Invalid loan type selected'
            ];
        }
        $account = $this->accountModel->getAccountById($accountId);
        if (!$account || $account['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Invalid account selected'
            ];
        }
        $applicationData = [
            'user_id' => $userId,
            'loan_type_id' => $loanTypeId,
            'loan_amount' => $loanAmount,
            'loan_term_years' => $loanTerm,
            'purpose' => $purpose,
            'deposit_account_id' => $accountId
        ];
        $applicationId = $this->loanModel->submitLoanApplication($applicationData);
        if ($applicationId) {
            $referenceNumber = 'LN' . str_pad($applicationId, 6, '0', STR_PAD_LEFT);
            return [
                'success' => true,
                'message' => "Your loan application for $" . number_format($loanAmount, 2) . " has been submitted successfully.",
                'reference' => $referenceNumber,
                'application_id' => $applicationId
            ];
        } else {
            return [
                'success' => false,
                'message' => 'An error occurred while submitting your application. Please try again.'
            ];
        }
    }
    public function getUserLoanApplications($userId) {
        return $this->loanModel->getUserLoanApplications($userId);
    }
    public function getUserActiveLoans($userId) {
        return $this->loanModel->getUserActiveLoans($userId);
    }
    public function calculateLoanPayment($loanAmount, $interestRate, $termYears) {
        return $this->loanModel->calculateLoanPayment($loanAmount, $interestRate, $termYears);
    }
    public function getLoanPaymentHistory($loanId, $userId) {
        $loan = $this->loanModel->getLoanById($loanId);
        if (!$loan || $loan['user_id'] != $userId) {
            return false;
        }
        return $this->loanModel->getLoanPaymentHistory($loanId);
    }
    public function makeLoanPayment($loanId, $userId, $paymentAmount, $sourceAccountId, $extraPrincipal = 0) {
        $loan = $this->loanModel->getLoanById($loanId);
        if (!$loan || $loan['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Unauthorized access to loan'
            ];
        }
        $account = $this->accountModel->getAccountById($sourceAccountId);
        if (!$account || $account['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Unauthorized access to account'
            ];
        }
        if ($account['balance'] < $paymentAmount + $extraPrincipal) {
            return [
                'success' => false,
                'message' => 'Insufficient funds in the selected account'
            ];
        }
        $monthlyRate = ($loan['interest_rate'] / 100) / 12;
        $interestAmount = $loan['remaining_balance'] * $monthlyRate;
        $principalAmount = $paymentAmount - $interestAmount;
        $newBalance = $loan['remaining_balance'] - $principalAmount - $extraPrincipal;
        $paymentData = [
            'loan_id' => $loanId,
            'payment_amount' => $paymentAmount,
            'principal_amount' => $principalAmount,
            'interest_amount' => $interestAmount,
            'source_account_id' => $sourceAccountId,
            'extra_principal' => $extraPrincipal,
            'remaining_balance' => $newBalance
        ];
        $success = $this->loanModel->makeLoanPayment($paymentData);
        if ($success) {
            $this->accountModel->updateBalance($sourceAccountId, -($paymentAmount + $extraPrincipal));
            return [
                'success' => true,
                'message' => 'Payment processed successfully',
                'payment_details' => [
                    'principal' => $principalAmount,
                    'interest' => $interestAmount,
                    'extra_principal' => $extraPrincipal,
                    'new_balance' => $newBalance
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => 'An error occurred while processing your payment. Please try again.'
            ];
        }
    }
    public function getUserLoanStatistics($userId) {
        return $this->loanModel->getUserLoanStatistics($userId);
    }
} 
<?php
class LoanController {
    private $loanModel;
    private $accountModel;
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function __construct() {
        require_once __DIR__ . '/../models/LoanModel.php';
        require_once __DIR__ . '/../models/AccountModel.php';
        $this->loanModel = new LoanModel();
        $this->accountModel = new AccountModel();
    }
<<<<<<< HEAD
    public function getLoanTypes() {
        return $this->loanModel->getLoanTypes();
    }
    public function getLoanTypeById($loanTypeId) {
        return $this->loanModel->getLoanTypeById($loanTypeId);
    }
=======

    public function getLoanTypes() {
        return $this->loanModel->getLoanTypes();
    }

    public function getLoanTypeById($loanTypeId) {
        return $this->loanModel->getLoanTypeById($loanTypeId);
    }

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function submitLoanApplication($userId, $loanTypeId, $loanAmount, $loanTerm, $purpose, $accountId) {
        if (empty($userId) || empty($loanTypeId) || empty($loanAmount) || empty($loanTerm) || empty($purpose) || empty($accountId)) {
            return [
                'success' => false,
                'message' => 'All fields are required'
            ];
        }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        if ($loanAmount < 1000) {
            return [
                'success' => false,
                'message' => 'Loan amount must be at least $1,000'
            ];
        }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $loanType = $this->getLoanTypeById($loanTypeId);
        if (!$loanType) {
            return [
                'success' => false,
                'message' => 'Invalid loan type selected'
            ];
        }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $account = $this->accountModel->getAccountById($accountId);
        if (!$account || $account['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Invalid account selected'
            ];
        }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $applicationData = [
            'user_id' => $userId,
            'loan_type_id' => $loanTypeId,
            'loan_amount' => $loanAmount,
            'loan_term_years' => $loanTerm,
            'purpose' => $purpose,
            'deposit_account_id' => $accountId
        ];
<<<<<<< HEAD
        $applicationId = $this->loanModel->submitLoanApplication($applicationData);
=======

        $applicationId = $this->loanModel->submitLoanApplication($applicationData);

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
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
<<<<<<< HEAD
    public function getUserLoanApplications($userId) {
        return $this->loanModel->getUserLoanApplications($userId);
    }
    public function getUserActiveLoans($userId) {
        return $this->loanModel->getUserActiveLoans($userId);
    }
    public function calculateLoanPayment($loanAmount, $interestRate, $termYears) {
        return $this->loanModel->calculateLoanPayment($loanAmount, $interestRate, $termYears);
    }
=======

    public function getUserLoanApplications($userId) {
        return $this->loanModel->getUserLoanApplications($userId);
    }

    public function getUserActiveLoans($userId) {
        return $this->loanModel->getUserActiveLoans($userId);
    }

    public function calculateLoanPayment($loanAmount, $interestRate, $termYears) {
        return $this->loanModel->calculateLoanPayment($loanAmount, $interestRate, $termYears);
    }

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getLoanPaymentHistory($loanId, $userId) {
        $loan = $this->loanModel->getLoanById($loanId);
        if (!$loan || $loan['user_id'] != $userId) {
            return false;
        }
        return $this->loanModel->getLoanPaymentHistory($loanId);
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function makeLoanPayment($loanId, $userId, $paymentAmount, $sourceAccountId, $extraPrincipal = 0) {
        $loan = $this->loanModel->getLoanById($loanId);
        if (!$loan || $loan['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Unauthorized access to loan'
            ];
        }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $account = $this->accountModel->getAccountById($sourceAccountId);
        if (!$account || $account['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Unauthorized access to account'
            ];
        }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        if ($account['balance'] < $paymentAmount + $extraPrincipal) {
            return [
                'success' => false,
                'message' => 'Insufficient funds in the selected account'
            ];
        }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $monthlyRate = ($loan['interest_rate'] / 100) / 12;
        $interestAmount = $loan['remaining_balance'] * $monthlyRate;
        $principalAmount = $paymentAmount - $interestAmount;
        $newBalance = $loan['remaining_balance'] - $principalAmount - $extraPrincipal;
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $paymentData = [
            'loan_id' => $loanId,
            'payment_amount' => $paymentAmount,
            'principal_amount' => $principalAmount,
            'interest_amount' => $interestAmount,
            'source_account_id' => $sourceAccountId,
            'extra_principal' => $extraPrincipal,
            'remaining_balance' => $newBalance
        ];
<<<<<<< HEAD
        $success = $this->loanModel->makeLoanPayment($paymentData);
=======

        $success = $this->loanModel->makeLoanPayment($paymentData);

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
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
<<<<<<< HEAD
    public function getUserLoanStatistics($userId) {
        return $this->loanModel->getUserLoanStatistics($userId);
    }
} 
=======

    public function getUserLoanStatistics($userId) {
        return $this->loanModel->getUserLoanStatistics($userId);
    }
}
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

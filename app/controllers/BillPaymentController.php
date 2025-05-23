<?php
class BillPaymentController {
    private $billPaymentModel;
    private $accountModel;

    public function __construct() {
        require_once __DIR__ . '/../models/BillPaymentModel.php';
        require_once __DIR__ . '/../models/AccountModel.php';
        $this->billPaymentModel = new BillPaymentModel();
        $this->accountModel = new AccountModel();
    }

    public function getBillCategories() {
        return $this->billPaymentModel->getBillCategories();
    }

    public function getBillersByCategory($categoryId) {
        return $this->billPaymentModel->getBillersByCategory($categoryId);
    }

    public function getBillerById($billerId) {
        return $this->billPaymentModel->getBillerById($billerId);
    }

    public function addSavedBiller($userId, $billerId, $accountNickname, $accountNumber) {
        if (empty($userId) || empty($billerId) || empty($accountNickname) || empty($accountNumber)) {
            return [
                'success' => false,
                'message' => 'All fields are required'
            ];
        }
        $biller = $this->getBillerById($billerId);
        if (!$biller) {
            return [
                'success' => false,
                'message' => 'Invalid biller selected'
            ];
        }
        $data = [
            'user_id' => $userId,
            'biller_id' => $billerId,
            'account_nickname' => $accountNickname,
            'account_number' => $accountNumber
        ];
        $savedBillerId = $this->billPaymentModel->addSavedBiller($data);
        if ($savedBillerId) {
            return [
                'success' => true,
                'message' => 'Biller saved successfully',
                'saved_biller_id' => $savedBillerId
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to save biller'
            ];
        }
    }

    public function getUserSavedBillers($userId) {
        return $this->billPaymentModel->getUserSavedBillers($userId);
    }

    public function updateSavedBiller($savedBillerId, $userId, $accountNickname, $accountNumber) {
        if (empty($savedBillerId) || empty($userId) || empty($accountNickname) || empty($accountNumber)) {
            return [
                'success' => false,
                'message' => 'All fields are required'
            ];
        }
        $savedBiller = $this->billPaymentModel->getSavedBillerById($savedBillerId);
        if (!$savedBiller || $savedBiller['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Invalid saved biller'
            ];
        }
        $data = [
            'saved_biller_id' => $savedBillerId,
            'user_id' => $userId,
            'account_nickname' => $accountNickname,
            'account_number' => $accountNumber
        ];
        $result = $this->billPaymentModel->updateSavedBiller($data);
        if ($result) {
            return [
                'success' => true,
                'message' => 'Biller updated successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to update biller'
            ];
        }
    }

    public function deleteSavedBiller($savedBillerId, $userId) {
        if (empty($savedBillerId) || empty($userId)) {
            return [
                'success' => false,
                'message' => 'Invalid request'
            ];
        }
        $savedBiller = $this->billPaymentModel->getSavedBillerById($savedBillerId);
        if (!$savedBiller || $savedBiller['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Invalid saved biller'
            ];
        }
        $result = $this->billPaymentModel->deleteSavedBiller($savedBillerId, $userId);
        if ($result) {
            return [
                'success' => true,
                'message' => 'Biller deleted successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to delete biller'
            ];
        }
    }

    public function makeBillPayment($userId, $billerId, $accountNumber, $amount, $sourceAccountId, $description = '') {
        if (empty($userId) || empty($billerId) || empty($accountNumber) || empty($amount) || empty($sourceAccountId)) {
            return [
                'success' => false,
                'message' => 'All fields are required'
            ];
        }
        if (!is_numeric($amount) || $amount <= 0) {
            return [
                'success' => false,
                'message' => 'Please enter a valid amount'
            ];
        }
        $biller = $this->getBillerById($billerId);
        if (!$biller) {
            return [
                'success' => false,
                'message' => 'Invalid biller selected'
            ];
        }
        $account = $this->accountModel->getAccountById($sourceAccountId);
        if (!$account || $account['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Invalid source account'
            ];
        }
        if ($account['balance'] < $amount) {
            return [
                'success' => false,
                'message' => 'Insufficient funds in your account'
            ];
        }
        $data = [
            'user_id' => $userId,
            'biller_id' => $billerId,
            'account_number' => $accountNumber,
            'amount' => $amount,
            'source_account_id' => $sourceAccountId,
            'description' => $description ?: 'Bill payment to ' . $biller['biller_name']
        ];
        $paymentId = $this->billPaymentModel->makeBillPayment($data);
        if ($paymentId) {
            $payment = $this->billPaymentModel->getBillPaymentById($paymentId);
            return [
                'success' => true,
                'message' => 'Payment successful',
                'payment_id' => $paymentId,
                'reference' => $payment['reference_number']
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Payment failed. Please try again later.'
            ];
        }
    }

    public function getBillPaymentHistory($userId) {
        return $this->billPaymentModel->getBillPaymentHistory($userId);
    }

    public function schedulePayment($userId, $billerId, $accountNumber, $amount, $sourceAccountId, $scheduledDate, $recurring = false, $frequency = '', $description = '') {
        if (empty($userId) || empty($billerId) || empty($accountNumber) || empty($amount) || empty($sourceAccountId) || empty($scheduledDate)) {
            return [
                'success' => false,
                'message' => 'All required fields must be filled'
            ];
        }
        if (!is_numeric($amount) || $amount <= 0) {
            return [
                'success' => false,
                'message' => 'Please enter a valid amount'
            ];
        }
        $currentDate = date('Y-m-d');
        if (strtotime($scheduledDate) < strtotime($currentDate)) {
            return [
                'success' => false,
                'message' => 'Scheduled date cannot be in the past'
            ];
        }
        $biller = $this->getBillerById($billerId);
        if (!$biller) {
            return [
                'success' => false,
                'message' => 'Invalid biller selected'
            ];
        }
        $account = $this->accountModel->getAccountById($sourceAccountId);
        if (!$account || $account['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Invalid source account'
            ];
        }
        if ($recurring && empty($frequency)) {
            return [
                'success' => false,
                'message' => 'Please select a frequency for recurring payments'
            ];
        }
        $data = [
            'user_id' => $userId,
            'biller_id' => $billerId,
            'account_number' => $accountNumber,
            'amount' => $amount,
            'source_account_id' => $sourceAccountId,
            'scheduled_date' => $scheduledDate,
            'recurring' => $recurring ? 1 : 0,
            'frequency' => $frequency,
            'description' => $description ?: 'Scheduled payment to ' . $biller['biller_name']
        ];
        $scheduledPaymentId = $this->billPaymentModel->schedulePayment($data);
        if ($scheduledPaymentId) {
            return [
                'success' => true,
                'message' => 'Payment scheduled successfully',
                'scheduled_payment_id' => $scheduledPaymentId
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to schedule payment'
            ];
        }
    }

    public function getScheduledPayments($userId) {
        return $this->billPaymentModel->getScheduledPayments($userId);
    }

    public function cancelScheduledPayment($scheduledPaymentId, $userId) {
        if (empty($scheduledPaymentId) || empty($userId)) {
            return [
                'success' => false,
                'message' => 'Invalid request'
            ];
        }
        $result = $this->billPaymentModel->cancelScheduledPayment($scheduledPaymentId, $userId);
        if ($result) {
            return [
                'success' => true,
                'message' => 'Scheduled payment cancelled successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to cancel scheduled payment'
            ];
        }
    }

    public function getBillPaymentStatistics($userId) {
        return $this->billPaymentModel->getBillPaymentStatistics($userId);
    }
}
?>

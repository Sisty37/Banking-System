<?php
require_once __DIR__ . '/../models/UserModel.php';
<<<<<<< HEAD
class AdminController {
    private $userModel;
    public function __construct() {
        $this->userModel = new UserModel();
    }
=======

class AdminController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getSystemOverview() {
        return [
            'total_users' => $this->userModel->getTotalUsersCount(),
            'total_accounts' => $this->userModel->getTotalAccountsCount(),
            'transactions_today' => $this->userModel->getTodayTransactionsCount(),
            'new_users_today' => $this->userModel->getNewUsersTodayCount()
        ];
    }
<<<<<<< HEAD
    public function getRecentSystemActivity($limit = 5) {
        return $this->userModel->getRecentSystemActivity($limit);
    }
    public function formatCurrency($amount) {
        return '$' . number_format($amount, 2, '.', ',');
    }
    public function formatDate($date) {
        return date('M d, Y', strtotime($date));
    }
    public function getTransactions($filters = [], $page = 1, $limit = 20) {
        return $this->userModel->getAllTransactions($filters, $page, $limit);
    }
    public function getAccountsForFilter() {
        return $this->userModel->getAccountsForDropdown();
    }
    public function getTransactionTypeBadge($type) {
        $badgeClass = 'secondary';
=======

    public function getRecentSystemActivity($limit = 5) {
        return $this->userModel->getRecentSystemActivity($limit);
    }

    public function formatCurrency($amount) {
        return '$' . number_format($amount, 2, '.', ',');
    }

    public function formatDate($date) {
        return date('M d, Y', strtotime($date));
    }

    public function getTransactions($filters = [], $page = 1, $limit = 20) {
        return $this->userModel->getAllTransactions($filters, $page, $limit);
    }

    public function getAccountsForFilter() {
        return $this->userModel->getAccountsForDropdown();
    }

    public function getTransactionTypeBadge($type) {
        $badgeClass = 'secondary';

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        switch (strtolower($type)) {
            case 'deposit':
                $badgeClass = 'success';
                break;
            case 'withdrawal':
                $badgeClass = 'danger';
                break;
            case 'transfer':
                $badgeClass = 'primary';
                break;
            case 'payment':
                $badgeClass = 'warning';
                break;
        }
<<<<<<< HEAD
        return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($type) . '</span>';
    }
    public function getTransactionStats($period = 'monthly', $limit = 6) {
        return $this->userModel->getTransactionStats($period, $limit);
    }
    public function getUserGrowthStats($period = 'monthly', $limit = 6) {
        return $this->userModel->getUserGrowthStats($period, $limit);
    }
    public function getAccountTypeDistribution() {
        return $this->userModel->getAccountTypeDistribution();
    }
=======

        return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($type) . '</span>';
    }

    public function getTransactionStats($period = 'monthly', $limit = 6) {
        return $this->userModel->getTransactionStats($period, $limit);
    }

    public function getUserGrowthStats($period = 'monthly', $limit = 6) {
        return $this->userModel->getUserGrowthStats($period, $limit);
    }

    public function getAccountTypeDistribution() {
        return $this->userModel->getAccountTypeDistribution();
    }

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function formatPeriodLabel($period, $periodType = 'monthly') {
        switch ($periodType) {
            case 'daily':
                return date('M d', strtotime($period));
            case 'weekly':
                list($year, $week) = explode('-', $period);
                return "Week $week, $year";
            case 'monthly':
                return date('M Y', strtotime($period . '-01'));
            case 'yearly':
                return $period;
            default:
                return $period;
        }
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getSystemSettings() {
        $settings = $this->userModel->getSystemSettings();
        if (empty($settings)) {
            $settings = $this->userModel->getDefaultSystemSettings();
        }
        return $settings;
    }
<<<<<<< HEAD
    public function updateSystemSettings($settings) {
        $success = true;
        $message = "Settings updated successfully";
=======

    public function updateSystemSettings($settings) {
        $success = true;
        $message = "Settings updated successfully";

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        try {
            foreach ($settings as $name => $value) {
                if (empty($name)) continue;
                $result = $this->userModel->updateSystemSetting($name, $value);
                if (!$result) {
                    throw new Exception("Failed to update setting: " . $name);
                }
            }
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        return [
            'success' => $success,
            'message' => $message
        ];
    }
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function getSettingsByCategory($category) {
        $allSettings = $this->getSystemSettings();
        $categorizedSettings = [
            'general' => [
                'bank_name', 'support_email', 'support_phone', 'currency_symbol',
                'date_format', 'time_format', 'timezone', 'decimal_places',
                'welcome_message', 'footer_text'
            ],
            'appearance' => [
                'system_theme', 'logo_url', 'favicon_url'
            ],
            'security' => [
                'maintenance_mode', 'maintenance_message', 'enable_new_registrations',
                'max_login_attempts', 'password_expiry_days', 'session_timeout_minutes',
                'enable_2fa', 'allow_password_reset'
            ],
            'financial' => [
                'transaction_fee_percentage', 'minimum_balance', 
                'interest_rate_savings', 'interest_rate_checking'
            ],
            'notifications' => [
                'notification_emails_enabled', 'notification_sms_enabled'
            ],
            'legal' => [
                'terms_and_conditions', 'privacy_policy'
            ]
        ];
<<<<<<< HEAD
        if (!isset($categorizedSettings[$category])) {
            return [];
        }
=======

        if (!isset($categorizedSettings[$category])) {
            return [];
        }

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        $result = [];
        foreach ($categorizedSettings[$category] as $settingName) {
            if (isset($allSettings[$settingName])) {
                $result[$settingName] = $allSettings[$settingName];
            }
        }
<<<<<<< HEAD
        return $result;
    }
    public function getUserNotifications($userId, $limit = 5) {
        return $this->userModel->getUserNotifications($userId, $limit);
    }
    public function getUnreadNotificationCount($userId) {
        return $this->userModel->getUnreadNotificationCount($userId);
    }
=======

        return $result;
    }

    public function getUserNotifications($userId, $limit = 5) {
        return $this->userModel->getUserNotifications($userId, $limit);
    }

    public function getUnreadNotificationCount($userId) {
        return $this->userModel->getUnreadNotificationCount($userId);
    }

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    public function markNotificationAsRead($notificationId) {
        return $this->userModel->markNotificationAsRead($notificationId);
    }
}
<<<<<<< HEAD
?> 
=======
?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

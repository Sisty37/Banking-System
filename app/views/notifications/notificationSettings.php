<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../controllers/AdminController.php';
if (!isLoggedIn()) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
$userId = $_SESSION['user_id'] ?? 0;
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$userRole = $_SESSION['role_name'] ?? 'Customer';
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    $emailNotifications = isset($_POST['email_notifications']) ? 1 : 0;
    $pushNotifications = isset($_POST['push_notifications']) ? 1 : 0;
    $transactionAlerts = isset($_POST['transaction_alerts']) ? 1 : 0;
    $securityAlerts = isset($_POST['security_alerts']) ? 1 : 0;
    $marketingMessages = isset($_POST['marketing_messages']) ? 1 : 0;
    $message = 'Notification settings have been saved successfully!';
    $messageType = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Settings - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/<?php echo $userRole === 'Administrator' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../AccountDashboard/dd.php">
                                <i class="fas fa-money-check-alt me-2"></i> Account Management
                            </a>
                        </li>
                        <?php if ($userRole === 'Administrator'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/user_management.php">
                                <i class="fas fa-users me-2"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../RoleBasedAccess/PermissionSettings.php">
                                <i class="fas fa-user-shield me-2"></i> Roles & Permissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/transaction_log.php">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Log
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/system_settings.php">
                                <i class="fas fa-cogs me-2"></i> System Settings
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="notificationCenter.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../ProfileManagement/profile.php">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link text-white" href="../../controllers/UserAuthentication/Logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Notification Settings</h1>
                    <div class="d-flex align-items-center">
                        <div class="notification-dropdown me-4">
                            <div class="notification-icon">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge">3</span>
                            </div>
                            <div class="notification-dropdown-content">
                                <div class="notification-header">
                                    <h6 class="notification-title">Notifications</h6>
                                    <a href="notificationCenter.php" class="text-decoration-none">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </div>
                                <ul class="notification-list">
                                </ul>
                                <div class="notification-footer">
                                    <a href="notificationCenter.php">View All Notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <a href="notificationCenter.php" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Notifications
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Notification Preferences</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="notificationSettings.php">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Delivery Methods</h5>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" checked>
                                        <label class="form-check-label" for="email_notifications">
                                            <i class="fas fa-envelope me-2"></i>Email Notifications
                                        </label>
                                        <div class="form-text">Receive notifications via email</div>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="push_notifications" name="push_notifications" checked>
                                        <label class="form-check-label" for="push_notifications">
                                            <i class="fas fa-bell me-2"></i>In-App Notifications
                                        </label>
                                        <div class="form-text">Receive notifications in the app</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5>Notification Types</h5>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="transaction_alerts" name="transaction_alerts" checked>
                                        <label class="form-check-label" for="transaction_alerts">
                                            <i class="fas fa-exchange-alt me-2"></i>Transaction Alerts
                                        </label>
                                        <div class="form-text">Deposits, withdrawals, transfers, etc.</div>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="security_alerts" name="security_alerts" checked>
                                        <label class="form-check-label" for="security_alerts">
                                            <i class="fas fa-shield-alt me-2"></i>Security Alerts
                                        </label>
                                        <div class="form-text">Login attempts, password changes, etc.</div>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="marketing_messages" name="marketing_messages">
                                        <label class="form-check-label" for="marketing_messages">
                                            <i class="fas fa-tag me-2"></i>Marketing Messages
                                        </label>
                                        <div class="form-text">Promotions, new features, etc.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Email Frequency</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="email_frequency" id="immediate" value="immediate" checked>
                                        <label class="form-check-label" for="immediate">
                                            Immediate - Send emails as events occur
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="email_frequency" id="daily" value="daily">
                                        <label class="form-check-label" for="daily">
                                            Daily Summary - Send a daily digest of all notifications
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="email_frequency" id="weekly" value="weekly">
                                        <label class="form-check-label" for="weekly">
                                            Weekly Summary - Send a weekly digest of all notifications
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" name="save_settings" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/js/notification.js"></script>
</body>
</html>

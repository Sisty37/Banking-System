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
$adminController = new AdminController();
$notifications = $adminController->getUserNotifications($userId, 20);
$unreadCount = $adminController->getUnreadNotificationCount($userId);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read']) && isset($_POST['notification_id'])) {
    $notificationId = intval($_POST['notification_id']);
    $adminController->markNotificationAsRead($notificationId);
    header("Location: notificationCenter.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Center - Banking System</title>
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
                            <a class="nav-link active text-white" href="#">
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
                    <h1 class="h2">Notification Center</h1>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="badge bg-danger"><?php echo $unreadCount; ?> Unread</span>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <a href="../Dashboard/<?php echo $userRole === 'Administrator' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>" class="btn btn-sm btn-outline-secondary">Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Your Notifications</h5>
                        <a href="notificationSettings.php" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-cog me-1"></i> Notification Settings
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($notifications)): ?>
                        <div class="p-4 text-center">
                            <i class="fas fa-bell-slash fa-3x mb-3 text-muted"></i>
                            <p class="lead">You don't have any notifications yet.</p>
                            <p class="text-muted">Notifications about your account activity will appear here.</p>
                        </div>
                        <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($notifications as $notification): ?>
                            <div class="list-group-item list-group-item-action <?php echo $notification['is_read'] ? '' : 'unread'; ?> d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center">
                                        <?php if (!$notification['is_read']): ?>
                                        <span class="badge bg-primary rounded-pill me-2">New</span>
                                        <?php endif; ?>
                                        <h6 class="mb-1"><?php echo htmlspecialchars($notification['title']); ?></h6>
                                    </div>
                                    <p class="mb-1"><?php echo htmlspecialchars($notification['message']); ?></p>
                                    <small class="text-muted"><?php echo htmlspecialchars($notification['time_ago']); ?></small>
                                </div>
                                <?php if (!$notification['is_read']): ?>
                                <form method="POST" action="notificationCenter.php">
                                    <input type="hidden" name="notification_id" value="<?php echo $notification['notification_id']; ?>">
                                    <button type="submit" name="mark_read" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-check me-1"></i> Mark as Read
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Notification Preferences</h5>
                    </div>
                    <div class="card-body">
                        <p>Manage how you receive notifications and what types of activities you want to be notified about.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-envelope me-2"></i>Email Notifications</h6>
                                        <p class="card-text">Receive important updates via email.</p>
                                        <a href="notificationSettings.php" class="btn btn-sm btn-primary">Configure</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-bell me-2"></i>In-App Notifications</h6>
                                        <p class="card-text">Control which notifications appear in your dashboard.</p>
                                        <a href="notificationSettings.php" class="btn btn-sm btn-primary">Configure</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/js/notification.js"></script>
</body>
</html>

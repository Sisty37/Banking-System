<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
<<<<<<< HEAD
require_once __DIR__ . '/../../appInitializer.php';
=======
require_once __DIR__ . '/../../bootstrap.php';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
require_once __DIR__ . '/../../controllers/AdminController.php';
if (!isLoggedIn() || !hasRole('Administrator')) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$adminController = new AdminController();
$systemOverview = $adminController->getSystemOverview();
$recentActivity = $adminController->getRecentSystemActivity(4);
?>
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
</head>
<body>
    <div class="container-fluid">
        <div class="row">
<<<<<<< HEAD
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-header">
                    <h4 class="text-white">Banking System</h4>
                    <p class="text-white-50">Administration Portal</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/dd.php">
                            <span class="nav-icon">💳</span> Account Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_management.php">
                            <span class="nav-icon">👥</span> User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../RoleBasedAccess/PermissionSettings.php">
                            <span class="nav-icon">🔒</span> Roles & Permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transaction_log.php">
                            <span class="nav-icon">↔️</span> Transaction Log
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="system_analytics.php">
                            <span class="nav-icon">📈</span> System Analytics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="system_settings.php">
                            <span class="nav-icon">⚙️</span> System Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../DataExport/exportWizard.php">
                            <span class="nav-icon">📤</span> Data Export
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <a class="nav-link" href="../../controllers/UserAuthentication/Logout.php">
                            <span class="nav-icon">🚪</span> Logout
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main content -->
            <div class="main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-primary me-3 d-md-none toggle-sidebar">
                            <span class="nav-icon">☰</span>
                        </button>
                        <h1 class="h2 mb-0">Administrator Dashboard</h1>
                    </div>
                    <div class="d-flex align-items-center">
                        <!-- Notification Dropdown -->
                        <div class="notification-dropdown me-3">
                            <div class="notification-icon">
                                <span class="nav-icon">🔔</span>
=======
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../AccountDashboard/dd.php">
                                <i class="fas fa-money-check-alt me-2"></i> Account Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="user_management.php">
                                <i class="fas fa-users me-2"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../RoleBasedAccess/PermissionSettings.php">
                                <i class="fas fa-user-shield me-2"></i> Roles & Permissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="transaction_log.php">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Log
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="system_analytics.php">
                                <i class="fas fa-chart-line me-2"></i> System Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="system_settings.php">
                                <i class="fas fa-cogs me-2"></i> System Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../notifications/notificationCenter.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../DataExport/exportWizard.php">
                                <i class="fas fa-file-export me-2"></i> Data Export
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
                    <h1 class="h2">Administrator Dashboard</h1>
                    <div class="d-flex align-items-center">
                        <div class="notification-dropdown me-4">
                            <div class="notification-icon">
                                <i class="fas fa-bell"></i>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                <span class="notification-badge">3</span>
                            </div>
                            <div class="notification-dropdown-content">
                                <div class="notification-header">
                                    <h6 class="notification-title">Notifications</h6>
                                    <a href="../notifications/notificationCenter.php" class="text-decoration-none">
<<<<<<< HEAD
                                        <span class="nav-icon">⚙️</span>
                                    </a>
                                </div>
                                <ul class="notification-list">
                                    <li class="notification-list-item unread">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="icon text-success">👤</span>
                                            </div>
                                            <div>
                                                <p class="mb-1">New user registration</p>
                                                <span class="notification-time">2 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="notification-list-item unread">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="icon text-warning">⚠️</span>
                                            </div>
                                            <div>
                                                <p class="mb-1">Failed login attempt</p>
                                                <span class="notification-time">10 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="notification-list-item unread">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="icon text-info">🖥️</span>
                                            </div>
                                            <div>
                                                <p class="mb-1">Server update completed</p>
                                                <span class="notification-time">1 hour ago</span>
                                            </div>
                                        </div>
                                    </li>
=======
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </div>
                                <ul class="notification-list">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                </ul>
                                <div class="notification-footer">
                                    <a href="../notifications/notificationCenter.php">View All Notifications</a>
                                </div>
                            </div>
                        </div>
<<<<<<< HEAD
                        
                        <!-- User Dropdown -->
                        <div class="user-dropdown">
                            <div class="user-info">
                                <div class="user-avatar" data-name="<?php echo htmlspecialchars($fullName); ?>"></div>
                                <div class="d-none d-md-block">
                                    <div class="fw-bold"><?php echo htmlspecialchars($fullName); ?></div>
                                    <div class="small text-muted">Administrator</div>
                                </div>
                                <span class="nav-icon ms-2 d-none d-md-block">▼</span>
                            </div>
                            <div class="user-dropdown-content">
                                <a href="../ProfileManagement/ViewProfile.php" class="user-dropdown-item">
                                    <span class="nav-icon">👤</span> My Profile
                                </a>
                                <a href="../ProfileManagement/EditProfile.php" class="user-dropdown-item">
                                    <span class="nav-icon">✏️</span> Edit Profile
                                </a>
                                <a href="../ProfileManagement/UpdatePassword.php" class="user-dropdown-item">
                                    <span class="nav-icon">🔑</span> Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="../../controllers/UserAuthentication/Logout.php" class="user-dropdown-item">
                                    <span class="nav-icon">🚪</span> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Links -->
=======
                        <span class="badge bg-danger me-2">Administrator</span>
                        <span>Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
<<<<<<< HEAD
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <a href="../AccountDashboard/create_account.php" class="text-decoration-none">
                                            <div class="card bg-primary text-white quick-action-card">
                                                <div class="card-body text-center py-4">
                                                    <span class="icon-large mb-3">➕</span>
=======
                                    <div class="col-md-3 mb-3">
                                        <a href="../AccountDashboard/create_account.php" class="text-decoration-none">
                                            <div class="card text-center bg-primary text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-plus-circle fa-3x mb-3"></i>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                    <h5 class="card-title">Create Account</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
<<<<<<< HEAD
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <a href="user_management.php" class="text-decoration-none">
                                            <div class="card bg-success text-white quick-action-card">
                                                <div class="card-body text-center py-4">
                                                    <span class="icon-large mb-3">👥</span>
=======
                                    <div class="col-md-3 mb-3">
                                        <a href="user_management.php" class="text-decoration-none">
                                            <div class="card text-center bg-success text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-user-plus fa-3x mb-3"></i>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                    <h5 class="card-title">Manage Users</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
<<<<<<< HEAD
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <a href="../RoleBasedAccess/PermissionSettings.php" class="text-decoration-none">
                                            <div class="card bg-info text-white quick-action-card">
                                                <div class="card-body text-center py-4">
                                                    <span class="icon-large mb-3">🔒</span>
=======
                                    <div class="col-md-3 mb-3">
                                        <a href="../RoleBasedAccess/PermissionSettings.php" class="text-decoration-none">
                                            <div class="card text-center bg-info text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-user-shield fa-3x mb-3"></i>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                    <h5 class="card-title">Manage Roles</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
<<<<<<< HEAD
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <a href="system_analytics.php" class="text-decoration-none">
                                            <div class="card bg-warning text-white quick-action-card">
                                                <div class="card-body text-center py-4">
                                                    <span class="icon-large mb-3">📊</span>
=======
                                    <div class="col-md-3 mb-3">
                                        <a href="#" class="text-decoration-none">
                                            <div class="card text-center bg-warning text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-chart-bar fa-3x mb-3"></i>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                    <h5 class="card-title">View Reports</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- System Overview -->
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">System Overview</h5>
<<<<<<< HEAD
                                <span class="text-muted">Today's statistics</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="stats-card">
                                            <div class="stats-icon">
                                                <span class="nav-icon">👥</span>
                                            </div>
                                            <div class="stats-value"><?php echo $systemOverview['total_users']; ?></div>
                                            <div class="stats-label">Total Users</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="stats-card">
                                            <div class="stats-icon">
                                                <span class="nav-icon">💳</span>
                                            </div>
                                            <div class="stats-value"><?php echo $systemOverview['total_accounts']; ?></div>
                                            <div class="stats-label">Total Accounts</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="stats-card">
                                            <div class="stats-icon">
                                                <span class="nav-icon">↔️</span>
                                            </div>
                                            <div class="stats-value"><?php echo $systemOverview['transactions_today']; ?></div>
                                            <div class="stats-label">Transactions Today</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="stats-card">
                                            <div class="stats-icon">
                                                <span class="nav-icon">➕</span>
                                            </div>
                                            <div class="stats-value"><?php echo $systemOverview['new_users_today']; ?></div>
                                            <div class="stats-label">New Users Today</div>
=======
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['total_users']; ?></h1>
                                                <p class="card-text">Total Users</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['total_accounts']; ?></h1>
                                                <p class="card-text">Total Accounts</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['transactions_today']; ?></h1>
                                                <p class="card-text">Transactions Today</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['new_users_today']; ?></h1>
                                                <p class="card-text">New Users Today</p>
                                            </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Recent Activity and System Health -->
                <div class="row mb-4">
                    <!-- Recent Activity -->
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <div class="card h-100">
=======
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent System Activity</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="card-body">
<<<<<<< HEAD
                                <?php foreach ($recentActivity as $activity): ?>
                                <div class="activity-item">
                                    <div class="activity-icon bg-<?php echo getActivityIconClass($activity['type'] ?? 'info'); ?>">
                                        <span class="nav-icon"><?php echo getActivityIcon($activity['type'] ?? 'info'); ?></span>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title"><?php echo htmlspecialchars($activity['title']); ?></div>
                                        <p class="mb-1"><?php echo htmlspecialchars($activity['description']); ?></p>
                                        <div class="activity-time"><?php echo htmlspecialchars($activity['timestamp']); ?></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- System Health -->
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">System Health</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>CPU Usage</span>
                                        <span>65%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Memory Usage</span>
                                        <span>45%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Disk Usage</span>
                                        <span>78%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Network Load</span>
                                        <span>32%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 32%" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
=======
                                <div class="list-group">
                                    <?php foreach ($recentActivity as $activity): ?>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1"><?php echo htmlspecialchars($activity['title']); ?></h6>
                                            <small class="text-muted"><?php echo htmlspecialchars($activity['timestamp']); ?></small>
                                        </div>
                                        <p class="mb-1"><?php echo htmlspecialchars($activity['description']); ?></p>
                                    </a>
                                    <?php endforeach; ?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    
    <!-- Dark Mode Toggle -->
    <div class="dark-mode-toggle" data-tooltip="Toggle Dark Mode">
        <span class="nav-icon">🌙</span>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/js/notification.js"></script>
    <script src="../../../public/js/custom-design.js"></script>
</body>
</html>

<?php
function getActivityIcon($type) {
    switch ($type) {
        case 'user':
            return '👤';
        case 'security':
            return '🔒';
        case 'transaction':
            return '↔️';
        case 'system':
            return '🖥️';
        default:
            return 'ℹ️';
    }
}

function getActivityIconClass($type) {
    switch ($type) {
        case 'user':
            return 'primary';
        case 'security':
            return 'warning';
        case 'transaction':
            return 'success';
        case 'system':
            return 'info';
        default:
            return 'secondary';
    }
}
?> 
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/js/notification.js"></script>
</body>
</html>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

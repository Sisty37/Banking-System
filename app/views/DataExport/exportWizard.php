<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
<<<<<<< HEAD
require_once __DIR__ . '/../../appInitializer.php';
=======
require_once __DIR__ . '/../../bootstrap.php';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
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
$unreadCount = $adminController->getUnreadNotificationCount($userId);
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_report'])) {
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';
    $format = $_POST['format'] ?? '';
    $dataType = $_POST['data_type'] ?? '';
    if (empty($startDate) || empty($endDate) || empty($format) || empty($dataType)) {
        $message = 'Please fill in all required fields.';
        $messageType = 'danger';
    } else {
        $message = "Your $dataType data has been exported as $format. The file is being downloaded.";
        $messageType = 'success';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_export'])) {
    $frequency = $_POST['frequency'] ?? '';
    $dataType = $_POST['schedule_data_type'] ?? '';
    $format = $_POST['schedule_format'] ?? '';
    if (empty($frequency) || empty($dataType) || empty($format)) {
        $message = 'Please fill in all scheduling fields.';
        $messageType = 'danger';
    } else {
        $message = "Your $dataType export has been scheduled to run $frequency. You will receive the $format file by email.";
        $messageType = 'success';
    }
}
?>
<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Wizard - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Export wizard specific styles */
        .export-card {
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .export-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        
        .export-card-primary .export-card-header {
            background-color: var(--primary-color);
            color: white;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
        }
        
        .export-card-success .export-card-header {
            background-color: var(--success-color);
            color: white;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
        }
        
        .export-card-body {
            padding: 20px;
            background-color: var(--card-bg);
            border-bottom-left-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
        }
        
        .export-form-group {
            margin-bottom: 20px;
        }
        
        .export-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .export-form-select, .export-form-input {
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .export-form-check {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .export-form-check-input {
            margin-right: 10px;
        }
        
        .export-form-text {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-top: 5px;
        }
        
        .export-btn {
            width: 100%;
            padding: 10px 15px;
            border-radius: var(--border-radius);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .export-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .export-btn-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .export-btn:hover {
            opacity: 0.9;
        }
        
        .export-badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 4px;
            margin-right: 5px;
        }
        
        .badge-pdf {
            background-color: var(--danger-color);
            color: white;
        }
        
        .badge-csv {
            background-color: var(--primary-color);
            color: white;
        }
        
        .badge-excel {
            background-color: var(--success-color);
            color: white;
        }
        
        .badge-completed {
            background-color: var(--success-color);
            color: white;
        }
        
        .export-history-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .export-history-table th,
        .export-history-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .export-history-table th {
            background-color: var(--header-bg);
            font-weight: 600;
        }
        
        .export-history-table tr:hover {
            background-color: var(--hover-color);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
=======

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Wizard - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
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
                        <a class="nav-link" href="../Dashboard/<?php echo $userRole === 'Administrator' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/dd.php">
                            <span class="nav-icon">💳</span> Account Management
                        </a>
                    </li>
                    <?php if ($userRole === 'Administrator'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/user_management.php">
                            <span class="nav-icon">👥</span> User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../RoleBasedAccess/PermissionSettings.php">
                            <span class="nav-icon">🔒</span> Roles & Permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/transaction_log.php">
                            <span class="nav-icon">↔️</span> Transaction Log
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/system_analytics.php">
                            <span class="nav-icon">📈</span> System Analytics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/system_settings.php">
                            <span class="nav-icon">⚙️</span> System Settings
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
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
                        <h1 class="h2 mb-0">Data Export Wizard</h1>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="user-dropdown">
                        <div class="user-info">
                            <div class="user-avatar" data-name="<?php echo htmlspecialchars($fullName); ?>"></div>
                            <div class="d-none d-md-block">
                                <div class="fw-bold"><?php echo htmlspecialchars($fullName); ?></div>
                                <div class="small text-muted"><?php echo htmlspecialchars($userRole); ?></div>
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
                
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                </div>
                <?php endif; ?>
                
                <div class="row">
                    <!-- One-Time Export -->
                    <div class="col-md-6 mb-4">
                        <div class="export-card export-card-primary">
                            <div class="export-card-header">
                                <span class="nav-icon me-2">📥</span> One-Time Export
                            </div>
                            <div class="export-card-body">
                                <form method="POST" action="exportWizard.php">
                                    <div class="export-form-group">
                                        <label for="data_type" class="export-form-label">Data Type</label>
                                        <select class="export-form-select" id="data_type" name="data_type" required>
=======
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
                            <a class="nav-link text-white" href="../notifications/notificationCenter.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
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
                    <h1 class="h2">Data Export Wizard</h1>
                    <div class="d-flex align-items-center">
                        <div class="notification-dropdown me-4">
                            <div class="notification-icon">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge"><?php echo $unreadCount; ?></span>
                            </div>
                            <div class="notification-dropdown-content">
                                <div class="notification-header">
                                    <h6 class="notification-title">Notifications</h6>
                                    <a href="../notifications/notificationCenter.php" class="text-decoration-none">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </div>
                                <ul class="notification-list">
                                </ul>
                                <div class="notification-footer">
                                    <a href="../notifications/notificationCenter.php">View All Notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <a href="../Dashboard/<?php echo $userRole === 'Administrator' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
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
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-download me-2"></i>One-Time Export</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="exportWizard.php">
                                    <div class="mb-3">
                                        <label for="data_type" class="form-label">Data Type</label>
                                        <select class="form-select" id="data_type" name="data_type" required>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            <option value="">-- Select Data Type --</option>
                                            <option value="transactions">Transaction History</option>
                                            <option value="account_statements">Account Statements</option>
                                            <option value="user_activity">User Activity Log</option>
                                            <?php if ($userRole === 'Administrator'): ?>
                                            <option value="system_logs">System Logs</option>
                                            <option value="user_list">User List</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="row">
<<<<<<< HEAD
                                        <div class="col-md-6">
                                            <div class="export-form-group">
                                                <label for="start_date" class="export-form-label">Start Date</label>
                                                <input type="date" class="export-form-input" id="start_date" name="start_date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="export-form-group">
                                                <label for="end_date" class="export-form-label">End Date</label>
                                                <input type="date" class="export-form-input" id="end_date" name="end_date" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="export-form-group">
                                        <label for="format" class="export-form-label">Export Format</label>
                                        <select class="export-form-select" id="format" name="format" required>
=======
                                        <div class="col-md-6 mb-3">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="format" class="form-label">Export Format</label>
                                        <select class="form-select" id="format" name="format" required>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            <option value="">-- Select Format --</option>
                                            <option value="pdf">PDF Document</option>
                                            <option value="csv">CSV Spreadsheet</option>
                                            <option value="excel">Excel Spreadsheet</option>
                                            <option value="json">JSON Data</option>
                                        </select>
<<<<<<< HEAD
                                        <div class="export-form-text">
                                            <span class="nav-icon me-1">ℹ️</span> PDF is best for printing, CSV/Excel for data analysis
                                        </div>
                                    </div>
                                    <button type="submit" name="download_report" class="export-btn export-btn-primary">
                                        <span class="nav-icon me-2">📥</span> Generate and Download
                                    </button>
=======
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i> PDF is best for printing, CSV/Excel for data analysis
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="download_report" class="btn btn-primary">
                                            <i class="fas fa-file-export me-2"></i>Generate and Download
                                        </button>
                                    </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                </form>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD
                    
                    <!-- Scheduled Export -->
                    <div class="col-md-6 mb-4">
                        <div class="export-card export-card-success">
                            <div class="export-card-header">
                                <span class="nav-icon me-2">🗓️</span> Scheduled Exports
                            </div>
                            <div class="export-card-body">
                                <form method="POST" action="exportWizard.php">
                                    <div class="export-form-group">
                                        <label for="schedule_data_type" class="export-form-label">Data Type</label>
                                        <select class="export-form-select" id="schedule_data_type" name="schedule_data_type" required>
=======
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Scheduled Exports</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="exportWizard.php">
                                    <div class="mb-3">
                                        <label for="schedule_data_type" class="form-label">Data Type</label>
                                        <select class="form-select" id="schedule_data_type" name="schedule_data_type" required>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            <option value="">-- Select Data Type --</option>
                                            <option value="transactions">Transaction History</option>
                                            <option value="account_statements">Account Statements</option>
                                            <option value="user_activity">User Activity Log</option>
                                            <?php if ($userRole === 'Administrator'): ?>
                                            <option value="system_logs">System Logs</option>
                                            <option value="user_list">User List</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
<<<<<<< HEAD
                                    <div class="export-form-group">
                                        <label for="frequency" class="export-form-label">Frequency</label>
                                        <select class="export-form-select" id="frequency" name="frequency" required>
=======
                                    <div class="mb-3">
                                        <label for="frequency" class="form-label">Frequency</label>
                                        <select class="form-select" id="frequency" name="frequency" required>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            <option value="">-- Select Frequency --</option>
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="quarterly">Quarterly</option>
                                        </select>
                                    </div>
<<<<<<< HEAD
                                    <div class="export-form-group">
                                        <label for="schedule_format" class="export-form-label">Export Format</label>
                                        <select class="export-form-select" id="schedule_format" name="schedule_format" required>
=======
                                    <div class="mb-3">
                                        <label for="schedule_format" class="form-label">Export Format</label>
                                        <select class="form-select" id="schedule_format" name="schedule_format" required>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            <option value="">-- Select Format --</option>
                                            <option value="pdf">PDF Document</option>
                                            <option value="csv">CSV Spreadsheet</option>
                                            <option value="excel">Excel Spreadsheet</option>
<<<<<<< HEAD
                                        </select>
                                    </div>
                                    <div class="export-form-check">
                                        <input type="checkbox" class="export-form-check-input" id="email_delivery" name="email_delivery" checked>
                                        <label class="export-form-label" for="email_delivery">Deliver to my email</label>
                                    </div>
                                    <div class="export-form-text mb-3">
                                        <span class="nav-icon me-1">📧</span> Reports will be sent to: <?php echo htmlspecialchars($_SESSION['email'] ?? 'your registered email'); ?>
                                    </div>
                                    <button type="submit" name="schedule_export" class="export-btn export-btn-success">
                                        <span class="nav-icon me-2">🗓️</span> Schedule Export
                                    </button>
=======
  </select>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="email_delivery" name="email_delivery" checked>
                                        <label class="form-check-label" for="email_delivery">Deliver to my email</label>
                                        <div class="form-text">
                                            <i class="fas fa-envelope me-1"></i> Reports will be sent to: <?php echo htmlspecialchars($_SESSION['email'] ?? 'your registered email'); ?>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="schedule_export" class="btn btn-success">
                                            <i class="fas fa-calendar-plus me-2"></i>Schedule Export
                                        </button>
                                    </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Export History -->
                <div class="export-card mb-4">
                    <div class="export-card-header">
                        <span class="nav-icon me-2">📜</span> Export History
                    </div>
                    <div class="export-card-body">
                        <div class="table-responsive">
                            <table class="export-history-table">
=======
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Export History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Data Type</th>
                                        <th>Format</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime('-2 days')); ?></td>
                                        <td>Transaction History</td>
<<<<<<< HEAD
                                        <td><span class="export-badge badge-pdf">PDF</span></td>
                                        <td><span class="export-badge badge-completed">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">
                                                <span class="nav-icon me-1">📥</span> Download
                                            </button>
=======
                                        <td><span class="badge bg-danger">PDF</span></td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-download me-1"></i>Download</button>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime('-1 week')); ?></td>
                                        <td>Account Statement</td>
<<<<<<< HEAD
                                        <td><span class="export-badge badge-csv">CSV</span></td>
                                        <td><span class="export-badge badge-completed">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">
                                                <span class="nav-icon me-1">📥</span> Download
                                            </button>
=======
                                        <td><span class="badge bg-primary">CSV</span></td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-download me-1"></i>Download</button>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime('-1 month')); ?></td>
                                        <td>User Activity</td>
<<<<<<< HEAD
                                        <td><span class="export-badge badge-excel">Excel</span></td>
                                        <td><span class="export-badge badge-completed">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">
                                                <span class="nav-icon me-1">📥</span> Download
                                            </button>
=======
                                        <td><span class="badge bg-success">Excel</span></td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-download me-1"></i>Download</button>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
<<<<<<< HEAD
        </div>
    </div>
    
    <!-- Dark Mode Toggle -->
    <div class="dark-mode-toggle" data-tooltip="Toggle Dark Mode">
        <span class="nav-icon">🌙</span>
    </div>
    
    <script src="../../../public/js/custom-design.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize user avatar with initials
            const userAvatars = document.querySelectorAll('.user-avatar');
            userAvatars.forEach(avatar => {
                const name = avatar.getAttribute('data-name');
                if (name) {
                    const nameParts = name.split(' ');
                    let initials = '';
                    if (nameParts.length >= 2) {
                        initials = nameParts[0].charAt(0) + nameParts[1].charAt(0);
                    } else if (nameParts.length === 1) {
                        initials = nameParts[0].charAt(0);
                    }
                    avatar.innerText = initials.toUpperCase();
                }
            });
            
            // Date validation
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            if (startDateInput && endDateInput) {
                const today = new Date();
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                
                // Format dates to YYYY-MM-DD for input
                const formatDate = (date) => {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                };
                
                startDateInput.value = formatDate(firstDay);
                endDateInput.value = formatDate(today);
                
                endDateInput.addEventListener('change', function() {
                    if (startDateInput.value && this.value) {
                        const startDate = new Date(startDateInput.value);
                        const endDate = new Date(this.value);
                        
                        if (endDate < startDate) {
                            alert('End date must be after start date');
                            this.value = formatDate(today);
                        }
                    }
                });
                
                startDateInput.addEventListener('change', function() {
                    if (endDateInput.value && this.value) {
                        const startDate = new Date(this.value);
                        const endDate = new Date(endDateInput.value);
                        
                        if (endDate < startDate) {
                            alert('Start date must be before end date');
                            this.value = formatDate(firstDay);
                        }
                    }
                });
            }
            
            // Alert dismissal
            const alertCloseButton = document.querySelector('.alert .btn-close');
            if (alertCloseButton) {
                alertCloseButton.addEventListener('click', function() {
                    this.parentElement.style.display = 'none';
                });
            }
=======
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/js/notification.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            if (startDateInput && endDateInput) {
                const today = new Date();
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                startDateInput.valueAsDate = firstDay;
                endDateInput.valueAsDate = today;
                endDateInput.addEventListener('change', function() {
                    if (startDateInput.value && this.value && new Date(this.value) < new Date(startDateInput.value)) {
                        alert('End date must be after start date');
                        this.valueAsDate = today;
                    }
                });
                startDateInput.addEventListener('change', function() {
                    if (endDateInput.value && this.value && new Date(endDateInput.value) < new Date(this.value)) {
                        alert('Start date must be before end date');
                        this.valueAsDate = firstDay;
                    }
                });
            }
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        });
    </script>
</body>
</html>

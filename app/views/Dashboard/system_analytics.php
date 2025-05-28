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
$period = isset($_GET['period']) ? $_GET['period'] : 'monthly';
if (!in_array($period, ['daily', 'weekly', 'monthly', 'yearly'])) {
    $period = 'monthly';
}
$transactionStats = $adminController->getTransactionStats($period);
$userGrowthStats = $adminController->getUserGrowthStats($period);
$accountTypeDistribution = $adminController->getAccountTypeDistribution();
$systemOverview = $adminController->getSystemOverview();
?>
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Analytics - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Analytics specific styles */
        .key-metric {
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            height: 100%;
            color: white;
            text-align: center;
            padding: 20px;
        }
        
        .key-metric:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .key-metric.users {
            background: var(--primary-color);
            background: linear-gradient(135deg, var(--primary-color) 0%, #4dabf7 100%);
        }
        
        .key-metric.accounts {
            background: var(--success-color);
            background: linear-gradient(135deg, var(--success-color) 0%, #69db7c 100%);
        }
        
        .key-metric.transactions {
            background: var(--info-color);
            background: linear-gradient(135deg, var(--info-color) 0%, #4dc9f6 100%);
        }
        
        .key-metric.new-users {
            background: var(--warning-color);
            background: linear-gradient(135deg, var(--warning-color) 0%, #ffd43b 100%);
        }
        
        .metric-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }
        
        .metric-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }
        
        .metric-label {
            font-size: 1rem;
            opacity: 0.8;
            margin-top: 5px;
        }
        
        /* Period selection */
        .period-selector {
            display: flex;
            gap: 5px;
        }
        
        .period-btn {
            padding: 8px 16px;
            border-radius: 4px;
            border: 1px solid var(--primary-color);
            background-color: transparent;
            color: var(--primary-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .period-btn:hover {
            background-color: rgba(var(--primary-rgb), 0.1);
        }
        
        .period-btn.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Chart containers */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        /* Custom chart styles for no-CDN version */
        .chart-placeholder {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .chart-bars {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            height: 200px;
            width: 100%;
            padding: 0 20px;
        }
        
        .chart-bar {
            width: 30px;
            background-color: var(--primary-color);
            border-radius: 4px 4px 0 0;
            position: relative;
            transition: height 0.5s ease;
        }
        
        .chart-bar:hover {
            opacity: 0.8;
        }
        
        .chart-bar::after {
            content: attr(data-value);
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            white-space: nowrap;
        }
        
        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .chart-legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
        }
        
        /* Custom pie/donut chart using CSS */
        .donut-chart {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: conic-gradient(
                var(--primary-color) 0%,
                var(--success-color) 25%,
                var(--info-color) 50%,
                var(--warning-color) 75%
            );
            position: relative;
        }
        
        .donut-hole {
            width: 120px;
            height: 120px;
            background: var(--body-bg);
            border-radius: 50%;
            position: absolute;
            top: 40px;
            left: 40px;
        }
        
        /* Analytics table */
        .analytics-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .analytics-table th,
        .analytics-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .analytics-table thead th {
            background-color: var(--card-bg);
            font-weight: 600;
            text-align: left;
        }
        
        .analytics-table tbody tr:hover {
            background-color: var(--hover-bg);
        }
        
        /* Action buttons */
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 4px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .action-btn:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        
        .action-btn.primary {
            background-color: var(--primary-color);
        }
        
        .action-btn.primary:hover {
            background-color: #0069d9;
        }
        
        /* Export dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            min-width: 120px;
            background-color: var(--card-bg);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 4px;
            z-index: 10;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        .dropdown-item {
            display: block;
            padding: 8px 16px;
            text-decoration: none;
            color: var(--text-color);
            transition: background-color 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: var(--hover-bg);
        }
    </style>
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <a class="nav-link" href="admin_dashboard.php">
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
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">📈</span> System Analytics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
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
                        <h1 class="h2 mb-0">System Analytics</h1>
                    </div>
                    
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
                <!-- Period Selection -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 d-flex align-items-center">
                            <span class="nav-icon me-2">📅</span> Analytics Period
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="period-selector">
                                <a href="?period=daily" class="period-btn <?php echo $period === 'daily' ? 'active' : ''; ?>">Daily</a>
                                <a href="?period=weekly" class="period-btn <?php echo $period === 'weekly' ? 'active' : ''; ?>">Weekly</a>
                                <a href="?period=monthly" class="period-btn <?php echo $period === 'monthly' ? 'active' : ''; ?>">Monthly</a>
                                <a href="?period=yearly" class="period-btn <?php echo $period === 'yearly' ? 'active' : ''; ?>">Yearly</a>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="action-btn" id="printBtn">
                                    <span class="nav-icon">🖨️</span> Print Report
                                </button>
                                <div class="dropdown">
                                    <button class="action-btn">
                                        <span class="nav-icon">📥</span> Export <span class="nav-icon">▼</span>
                                    </button>
                                    <div class="dropdown-content">
                                        <a href="#" class="dropdown-item">PDF</a>
                                        <a href="#" class="dropdown-item">Excel</a>
                                        <a href="#" class="dropdown-item">CSV</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Key Metrics Overview -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">📌</span> Key Metrics
                                </h5>
=======
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="admin_dashboard.php">
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
                            <a class="nav-link active text-white" href="#">
                                <i class="fas fa-chart-line me-2"></i> System Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
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
                    <h1 class="h2">System Analytics</h1>
                    <div>
                        <span class="badge bg-danger">Administrator</span>
                        <span class="ms-2">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Analytics Period</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="system_analytics.php" class="row">
                            <div class="col-md-8">
                                <div class="btn-group" role="group">
                                    <a href="?period=daily" class="btn btn<?php echo $period === 'daily' ? '-primary' : '-outline-primary'; ?>">Daily</a>
                                    <a href="?period=weekly" class="btn btn<?php echo $period === 'weekly' ? '-primary' : '-outline-primary'; ?>">Weekly</a>
                                    <a href="?period=monthly" class="btn btn<?php echo $period === 'monthly' ? '-primary' : '-outline-primary'; ?>">Monthly</a>
                                    <a href="?period=yearly" class="btn btn<?php echo $period === 'yearly' ? '-primary' : '-outline-primary'; ?>">Yearly</a>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button type="button" class="btn btn-outline-secondary" id="printBtn">
                                    <i class="fas fa-print me-1"></i> Print Report
                                </button>
                                <div class="btn-group ms-2">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-download me-1"></i> Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">PDF</a></li>
                                        <li><a class="dropdown-item" href="#">Excel</a></li>
                                        <li><a class="dropdown-item" href="#">CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Key Metrics</h5>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
<<<<<<< HEAD
                                        <div class="key-metric users">
                                            <span class="metric-icon">👥</span>
                                            <p class="metric-value"><?php echo $systemOverview['total_users']; ?></p>
                                            <p class="metric-label">Total Users</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="key-metric accounts">
                                            <span class="metric-icon">💳</span>
                                            <p class="metric-value"><?php echo $systemOverview['total_accounts']; ?></p>
                                            <p class="metric-label">Active Accounts</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="key-metric transactions">
                                            <span class="metric-icon">🔄</span>
                                            <p class="metric-value"><?php echo $systemOverview['transactions_today']; ?></p>
                                            <p class="metric-label">Today's Transactions</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="key-metric new-users">
                                            <span class="metric-icon">➕</span>
                                            <p class="metric-value"><?php echo $systemOverview['new_users_today']; ?></p>
                                            <p class="metric-label">New Users Today</p>
=======
                                        <div class="card bg-primary text-white h-100">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['total_users']; ?></h1>
                                                <p class="card-text">Total Users</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-success text-white h-100">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['total_accounts']; ?></h1>
                                                <p class="card-text">Active Accounts</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-info text-white h-100">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['transactions_today']; ?></h1>
                                                <p class="card-text">Today's Transactions</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-warning text-white h-100">
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
                <!-- Transaction Trends -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">📉</span> Transaction Trends
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <?php if (!empty($transactionStats)): ?>
                                        <div class="chart-placeholder">
                                            <div class="chart-bars">
                                                <?php 
                                                $maxCount = 0;
                                                foreach ($transactionStats as $stat) {
                                                    $maxCount = max($maxCount, $stat['total_count']);
                                                }
                                                
                                                foreach ($transactionStats as $index => $stat): 
                                                    $height = $maxCount > 0 ? ($stat['total_count'] / $maxCount * 100) : 0;
                                                    $formattedPeriod = $adminController->formatPeriodLabel($stat['period'], $period);
                                                ?>
                                                    <div class="chart-bar" 
                                                         style="height: <?php echo $height; ?>%; background-color: var(--primary-color);" 
                                                         data-value="<?php echo $stat['total_count']; ?>"
                                                         title="<?php echo $formattedPeriod; ?>: <?php echo $stat['total_count']; ?> transactions">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="chart-legend mt-4">
                                                <?php 
                                                $periods = [];
                                                foreach ($transactionStats as $stat) {
                                                    $periods[] = $adminController->formatPeriodLabel($stat['period'], $period);
                                                }
                                                foreach ($periods as $index => $periodLabel): 
                                                ?>
                                                    <div class="chart-legend-item">
                                                        <div class="legend-color" style="background-color: var(--primary-color);"></div>
                                                        <span><?php echo $periodLabel; ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <span class="nav-icon me-2">ℹ️</span> No transaction data available for this period.
                                        </div>
                                    <?php endif; ?>
                                </div>
=======
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Transaction Trends</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="transactionTrendsChart" height="250"></canvas>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Transaction Volumes and Types -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">💰</span> Transaction Volumes
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <?php if (!empty($transactionStats)): ?>
                                        <div class="chart-placeholder">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <table class="analytics-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Period</th>
                                                            <th>Deposits</th>
                                                            <th>Withdrawals</th>
                                                            <th>Transfers</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($transactionStats as $stat): ?>
                                                            <?php $formattedPeriod = $adminController->formatPeriodLabel($stat['period'], $period); ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($formattedPeriod); ?></td>
                                                                <td><?php echo $adminController->formatCurrency($stat['deposit_amount']); ?></td>
                                                                <td><?php echo $adminController->formatCurrency($stat['withdrawal_amount']); ?></td>
                                                                <td><?php echo $adminController->formatCurrency($stat['transfer_amount']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <span class="nav-icon me-2">ℹ️</span> No transaction data available for this period.
                                        </div>
                                    <?php endif; ?>
                                </div>
=======
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Transaction Volumes</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="transactionVolumeChart" height="300"></canvas>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
<<<<<<< HEAD
                            <div class="card-header">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">🔄</span> Transaction Types
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $totalDeposits = array_sum(array_column($transactionStats, 'deposits'));
                                $totalWithdrawals = array_sum(array_column($transactionStats, 'withdrawals'));
                                $totalTransfers = array_sum(array_column($transactionStats, 'transfers'));
                                $totalPayments = array_sum(array_column($transactionStats, 'payments'));
                                $allTotal = $totalDeposits + $totalWithdrawals + $totalTransfers + $totalPayments;
                                
                                // Calculate percentages for the chart
                                $depositPercentage = $allTotal > 0 ? ($totalDeposits / $allTotal) * 100 : 0;
                                $withdrawalPercentage = $allTotal > 0 ? ($totalWithdrawals / $allTotal) * 100 : 0;
                                $transferPercentage = $allTotal > 0 ? ($totalTransfers / $allTotal) * 100 : 0;
                                $paymentPercentage = $allTotal > 0 ? ($totalPayments / $allTotal) * 100 : 0;
                                ?>
                                <div class="chart-container">
                                    <?php if ($allTotal > 0): ?>
                                        <div class="chart-placeholder">
                                            <div class="donut-chart" style="background: conic-gradient(
                                                var(--primary-color) 0% <?php echo $depositPercentage; ?>%, 
                                                var(--danger-color) <?php echo $depositPercentage; ?>% <?php echo $depositPercentage + $withdrawalPercentage; ?>%, 
                                                var(--info-color) <?php echo $depositPercentage + $withdrawalPercentage; ?>% <?php echo $depositPercentage + $withdrawalPercentage + $transferPercentage; ?>%,
                                                var(--warning-color) <?php echo $depositPercentage + $withdrawalPercentage + $transferPercentage; ?>% 100%)">
                                                <div class="donut-hole"></div>
                                            </div>
                                            <div class="chart-legend mt-4">
                                                <div class="chart-legend-item">
                                                    <div class="legend-color" style="background-color: var(--primary-color);"></div>
                                                    <span>Deposits (<?php echo round($depositPercentage); ?>%)</span>
                                                </div>
                                                <div class="chart-legend-item">
                                                    <div class="legend-color" style="background-color: var(--danger-color);"></div>
                                                    <span>Withdrawals (<?php echo round($withdrawalPercentage); ?>%)</span>
                                                </div>
                                                <div class="chart-legend-item">
                                                    <div class="legend-color" style="background-color: var(--info-color);"></div>
                                                    <span>Transfers (<?php echo round($transferPercentage); ?>%)</span>
                                                </div>
                                                <div class="chart-legend-item">
                                                    <div class="legend-color" style="background-color: var(--warning-color);"></div>
                                                    <span>Payments (<?php echo round($paymentPercentage); ?>%)</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <span class="nav-icon me-2">ℹ️</span> No transaction data available for this period.
                                        </div>
                                    <?php endif; ?>
                                </div>
=======
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Transaction Types</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="transactionTypeChart" height="300"></canvas>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                <!-- User Growth and Account Distribution -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">👥</span> User Growth
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <?php if (!empty($userGrowthStats)): ?>
                                        <div class="chart-placeholder">
                                            <div class="chart-bars">
                                                <?php 
                                                $maxNewUsers = 0;
                                                foreach ($userGrowthStats as $stat) {
                                                    $maxNewUsers = max($maxNewUsers, $stat['new_users']);
                                                }
                                                
                                                foreach ($userGrowthStats as $index => $stat): 
                                                    $height = $maxNewUsers > 0 ? ($stat['new_users'] / $maxNewUsers * 100) : 0;
                                                    $formattedPeriod = $adminController->formatPeriodLabel($stat['period'], $period);
                                                ?>
                                                    <div class="chart-bar" 
                                                         style="height: <?php echo $height; ?>%; background-color: var(--success-color);" 
                                                         data-value="<?php echo $stat['new_users']; ?>"
                                                         title="<?php echo $formattedPeriod; ?>: <?php echo $stat['new_users']; ?> new users">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="chart-legend mt-4">
                                                <div class="chart-legend-item">
                                                    <div class="legend-color" style="background-color: var(--success-color);"></div>
                                                    <span>New Users</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <span class="nav-icon me-2">ℹ️</span> No user growth data available for this period.
                                        </div>
                                    <?php endif; ?>
                                </div>
=======
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">User Growth</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="userGrowthChart" height="300"></canvas>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
<<<<<<< HEAD
                            <div class="card-header">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">📊</span> Account Distribution
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <?php if (!empty($accountTypeDistribution)): ?>
                                        <div class="chart-placeholder">
                                            <?php
                                            $totalAccounts = array_sum(array_column($accountTypeDistribution, 'count'));
                                            $colors = [
                                                'var(--primary-color)',
                                                'var(--success-color)',
                                                'var(--info-color)',
                                                'var(--warning-color)',
                                                'var(--danger-color)'
                                            ];
                                            
                                            // Create conic gradient string
                                            $conicGradient = "background: conic-gradient(";
                                            $currentPercentage = 0;
                                            
                                            foreach ($accountTypeDistribution as $index => $distribution) {
                                                $percentage = $totalAccounts > 0 ? ($distribution['count'] / $totalAccounts * 100) : 0;
                                                $colorIndex = $index % count($colors);
                                                
                                                $conicGradient .= $colors[$colorIndex] . " " . $currentPercentage . "% " . ($currentPercentage + $percentage) . "%";
                                                
                                                if ($index < count($accountTypeDistribution) - 1) {
                                                    $conicGradient .= ", ";
                                                }
                                                
                                                $currentPercentage += $percentage;
                                            }
                                            
                                            $conicGradient .= ");";
                                            ?>
                                            
                                            <div class="donut-chart" style="<?php echo $conicGradient; ?>">
                                                <div class="donut-hole"></div>
                                            </div>
                                            <div class="chart-legend mt-4">
                                                <?php foreach ($accountTypeDistribution as $index => $distribution): 
                                                    $percentage = $totalAccounts > 0 ? ($distribution['count'] / $totalAccounts * 100) : 0;
                                                    $colorIndex = $index % count($colors);
                                                ?>
                                                    <div class="chart-legend-item">
                                                        <div class="legend-color" style="background-color: <?php echo $colors[$colorIndex]; ?>;"></div>
                                                        <span><?php echo htmlspecialchars($distribution['account_type']); ?> (<?php echo round($percentage); ?>%)</span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <span class="nav-icon me-2">ℹ️</span> No account distribution data available.
                                        </div>
                                    <?php endif; ?>
                                </div>
=======
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Account Distribution</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="accountDistributionChart" height="300"></canvas>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                <!-- Detailed Transaction Data -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 d-flex align-items-center">
                            <span class="nav-icon me-2">📋</span> Detailed Transaction Data
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="analytics-table">
=======
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Detailed Transaction Data</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th>Total Transactions</th>
                                        <th>Deposits</th>
                                        <th>Withdrawals</th>
                                        <th>Transfers</th>
                                        <th>Payments</th>
                                        <th>Total Volume</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactionStats as $stat): ?>
                                        <?php
                                            $totalVolume = $stat['deposit_amount'] + $stat['withdrawal_amount'] + $stat['transfer_amount'] + $stat['payment_amount'];
                                            $formattedPeriod = $adminController->formatPeriodLabel($stat['period'], $period);
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($formattedPeriod); ?></td>
                                            <td><?php echo number_format($stat['total_count']); ?></td>
                                            <td><?php echo number_format($stat['deposits']); ?></td>
                                            <td><?php echo number_format($stat['withdrawals']); ?></td>
                                            <td><?php echo number_format($stat['transfers']); ?></td>
                                            <td><?php echo number_format($stat['payments']); ?></td>
                                            <td><?php echo $adminController->formatCurrency($totalVolume); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
    
    <script src="../../../public/js/custom-design.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Print report functionality
            document.getElementById('printBtn').addEventListener('click', function() {
                window.print();
            });
            
            // Export dropdown functionality
            const dropdownBtn = document.querySelector('.dropdown button');
            const dropdownContent = document.querySelector('.dropdown-content');
            
            if (dropdownBtn && dropdownContent) {
                dropdownBtn.addEventListener('click', function() {
                    dropdownContent.classList.toggle('show');
                });
                
                // Close the dropdown when clicking outside
                window.addEventListener('click', function(event) {
                    if (!event.target.matches('.dropdown button') && !event.target.closest('.dropdown button')) {
                        if (dropdownContent.classList.contains('show')) {
                            dropdownContent.classList.remove('show');
                        }
                    }
                });
            }
            
            // Add hover effect to chart bars for better UX
            const chartBars = document.querySelectorAll('.chart-bar');
            chartBars.forEach(bar => {
                // Create tooltip element
                const tooltip = document.createElement('div');
                tooltip.className = 'chart-tooltip';
                tooltip.style.position = 'absolute';
                tooltip.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                tooltip.style.color = 'white';
                tooltip.style.padding = '5px 10px';
                tooltip.style.borderRadius = '4px';
                tooltip.style.fontSize = '12px';
                tooltip.style.zIndex = '10';
                tooltip.style.opacity = '0';
                tooltip.style.transition = 'opacity 0.3s ease';
                tooltip.textContent = bar.getAttribute('title');
                
                bar.appendChild(tooltip);
                
                bar.addEventListener('mouseenter', function() {
                    tooltip.style.opacity = '1';
                    tooltip.style.top = '-35px';
                    tooltip.style.left = '50%';
                    tooltip.style.transform = 'translateX(-50%)';
                });
                
                bar.addEventListener('mouseleave', function() {
                    tooltip.style.opacity = '0';
                });
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Segoe UI', 'Helvetica Neue', 'Arial', sans-serif";
            Chart.defaults.font.size = 12;
            Chart.defaults.color = '#666';
            const transactionTrendsCtx = document.getElementById('transactionTrendsChart').getContext('2d');
            <?php
            $periods = [];
            $depositCounts = [];
            $withdrawalCounts = [];
            $transferCounts = [];
            $paymentCounts = [];
            foreach ($transactionStats as $stat) {
                $periods[] = $adminController->formatPeriodLabel($stat['period'], $period);
                $depositCounts[] = $stat['deposits'];
                $withdrawalCounts[] = $stat['withdrawals'];
                $transferCounts[] = $stat['transfers'];
                $paymentCounts[] = $stat['payments'];
            }
            ?>
            const transactionTrendsChart = new Chart(transactionTrendsCtx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($periods); ?>,
                    datasets: [
                        {
                            label: 'Deposits',
                            data: <?php echo json_encode($depositCounts); ?>,
                            borderColor: '#36a2eb',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            tension: 0.1,
                            fill: true
                        },
                        {
                            label: 'Withdrawals',
                            data: <?php echo json_encode($withdrawalCounts); ?>,
                            borderColor: '#ff6384',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            tension: 0.1,
                            fill: true
                        },
                        {
                            label: 'Transfers',
                            data: <?php echo json_encode($transferCounts); ?>,
                            borderColor: '#4bc0c0',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.1,
                            fill: true
                        },
                        {
                            label: 'Payments',
                            data: <?php echo json_encode($paymentCounts); ?>,
                            borderColor: '#ffcd56',
                            backgroundColor: 'rgba(255, 205, 86, 0.2)',
                            tension: 0.1,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Transaction Count Trends'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        },
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Transactions'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Period'
                            }
                        }
                    }
                }
            });
            const transactionVolumeCtx = document.getElementById('transactionVolumeChart').getContext('2d');
            <?php
            $depositAmounts = [];
            $withdrawalAmounts = [];
            $transferAmounts = [];
            $paymentAmounts = [];
            foreach ($transactionStats as $stat) {
                $depositAmounts[] = $stat['deposit_amount'];
                $withdrawalAmounts[] = $stat['withdrawal_amount'];
                $transferAmounts[] = $stat['transfer_amount'];
                $paymentAmounts[] = $stat['payment_amount'];
            }
            ?>
            const transactionVolumeChart = new Chart(transactionVolumeCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($periods); ?>,
                    datasets: [
                        {
                            label: 'Deposits',
                            data: <?php echo json_encode($depositAmounts); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        },
                        {
                            label: 'Withdrawals',
                            data: <?php echo json_encode($withdrawalAmounts); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        },
                        {
                            label: 'Transfers',
                            data: <?php echo json_encode($transferAmounts); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        },
                        {
                            label: 'Payments',
                            data: <?php echo json_encode($paymentAmounts); ?>,
                            backgroundColor: 'rgba(255, 205, 86, 0.7)',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Transaction Volume by Type'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-US', {
                                            style: 'currency',
                                            currency: 'USD'
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount ($)'
                            },
                            ticks: {
                                callback: function(value, index, values) {
                                    return new Intl.NumberFormat('en-US', {
                                        style: 'currency',
                                        currency: 'USD',
                                        minimumFractionDigits: 0
                                    }).format(value);
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Period'
                            }
                        }
                    }
                }
            });
            const transactionTypeCtx = document.getElementById('transactionTypeChart').getContext('2d');
            <?php
            $totalDeposits = array_sum($depositCounts);
            $totalWithdrawals = array_sum($withdrawalCounts);
            $totalTransfers = array_sum($transferCounts);
            $totalPayments = array_sum($paymentCounts);
            ?>
            const transactionTypeChart = new Chart(transactionTypeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Deposits', 'Withdrawals', 'Transfers', 'Payments'],
                    datasets: [{
                        data: [
                            <?php echo $totalDeposits; ?>,
                            <?php echo $totalWithdrawals; ?>,
                            <?php echo $totalTransfers; ?>,
                            <?php echo $totalPayments; ?>
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 205, 86, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Transaction Type Distribution'
                        },
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const dataset = tooltipItem.dataset;
                                    const total = dataset.data.reduce((acc, data) => acc + data, 0);
                                    const currentValue = dataset.data[tooltipItem.dataIndex];
                                    const percentage = Math.round((currentValue / total) * 100);
                                    return `${tooltipItem.label}: ${currentValue} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            <?php
            $userPeriods = [];
            $newUsers = [];
            $cumulativeUsers = [];
            $cumulativeCount = 0;
            foreach ($userGrowthStats as $stat) {
                $userPeriods[] = $adminController->formatPeriodLabel($stat['period'], $period);
                $newUsers[] = $stat['new_users'];
                $cumulativeCount += $stat['new_users'];
                $cumulativeUsers[] = $cumulativeCount;
            }
            ?>
            const userGrowthChart = new Chart(userGrowthCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($userPeriods); ?>,
                    datasets: [
                        {
                            label: 'New Users',
                            data: <?php echo json_encode($newUsers); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            order: 2
                        },
                        {
                            label: 'Cumulative Users',
                            data: <?php echo json_encode($cumulativeUsers); ?>,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            type: 'line',
                            order: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'User Growth Trend'
                        },
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Users'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Period'
                            }
                        }
                    }
                }
            });
            const accountDistributionCtx = document.getElementById('accountDistributionChart').getContext('2d');
            <?php
            $accountTypes = [];
            $accountCounts = [];
            $accountBalances = [];
            foreach ($accountTypeDistribution as $distribution) {
                $accountTypes[] = $distribution['account_type'];
                $accountCounts[] = $distribution['count'];
                $accountBalances[] = $distribution['total_balance'];
            }
            ?>
            const accountDistributionChart = new Chart(accountDistributionCtx, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($accountTypes); ?>,
                    datasets: [{
                        data: <?php echo json_encode($accountCounts); ?>,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 205, 86, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Account Type Distribution'
                        },
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const dataset = tooltipItem.dataset;
                                    const total = dataset.data.reduce((acc, data) => acc + data, 0);
                                    const currentValue = dataset.data[tooltipItem.dataIndex];
                                    const percentage = Math.round((currentValue / total) * 100);
                                    return `${tooltipItem.label}: ${currentValue} accounts (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            document.getElementById('printBtn').addEventListener('click', function() {
                window.print();
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            });
        });
    </script>
</body>
<<<<<<< HEAD
</html> 
=======
</html>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
<<<<<<< HEAD
require_once __DIR__ . '/../../appInitializer.php';
=======
require_once __DIR__ . '/../../bootstrap.php';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
require_once __DIR__ . '/../../controllers/AdminController.php';
if (!isLoggedIn() || !(hasRole('Administrator') || hasRole('Manager'))) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$userRole = $_SESSION['role_name'] ?? '';
$adminController = new AdminController();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
if ($page < 1) $page = 1;
if ($limit < 1 || $limit > 100) $limit = 20;
$filters = [
    'date_from' => $_GET['date_from'] ?? '',
    'date_to' => $_GET['date_to'] ?? '',
    'transaction_type' => $_GET['transaction_type'] ?? '',
    'account_id' => $_GET['account_id'] ?? '',
    'min_amount' => $_GET['min_amount'] ?? '',
    'max_amount' => $_GET['max_amount'] ?? '',
    'search' => $_GET['search'] ?? ''
];
$result = $adminController->getTransactions($filters, $page, $limit);
$transactions = $result['transactions'];
$pagination = $result['pagination'];
$accounts = $adminController->getAccountsForFilter();
?>
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Log - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Transaction log specific styles */
        .filter-card {
            margin-bottom: 20px;
            border-radius: var(--border-radius);
        }
        
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .transaction-table th,
        .transaction-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .transaction-table th {
            background-color: var(--header-bg);
            font-weight: 600;
        }
        
        .transaction-table tr:hover {
            background-color: var(--hover-color);
        }
        
        .transaction-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-deposit {
            background-color: var(--success-color);
            color: white;
        }
        
        .badge-withdrawal {
            background-color: var(--danger-color);
            color: white;
        }
        
        .badge-transfer {
            background-color: var(--info-color);
            color: white;
        }
        
        .badge-payment {
            background-color: var(--warning-color);
            color: white;
        }
        
        .datepicker-input {
            position: relative;
        }
        
        .datepicker-input input {
            padding-right: 30px;
        }
        
        .datepicker-input:after {
            content: "📅";
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
        
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 20px 0;
            justify-content: center;
        }
        
        .pagination-item {
            margin: 0 5px;
        }
        
        .pagination-link {
            display: block;
            padding: 8px 12px;
            border-radius: var(--border-radius);
            text-decoration: none;
            color: var(--text-color);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }
        
        .pagination-link:hover {
            background-color: var(--hover-color);
        }
        
        .pagination-link.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .pagination-link.disabled {
            color: var(--text-secondary);
            pointer-events: none;
            background-color: var(--disabled-bg);
        }
        
        .export-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .export-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            min-width: 120px;
            background-color: var(--card-bg);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: var(--border-radius);
            z-index: 10;
        }
        
        .export-dropdown:hover .export-dropdown-content {
            display: block;
        }
        
        .export-dropdown-item {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .export-dropdown-item:hover {
            background-color: var(--hover-color);
        }
    </style>
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                        <a class="nav-link" href="<?php echo hasRole('Administrator') ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/dd.php">
                            <span class="nav-icon">💳</span> Account Management
                        </a>
                    </li>
                    <?php if (hasRole('Administrator')): ?>
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
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">↔️</span> Transaction Log
                        </a>
                    </li>
                    <?php if (hasRole('Administrator')): ?>
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
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <?php if (hasRole('Administrator')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../DataExport/exportWizard.php">
                            <span class="nav-icon">📤</span> Data Export
                        </a>
                    </li>
                    <?php endif; ?>
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
                        <h1 class="h2 mb-0">Transaction Log</h1>
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
                <!-- Filter Panel -->
                <div class="card filter-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 d-flex align-items-center">
                            <span class="nav-icon me-2">🔍</span> Filter Transactions
                        </h5>
=======
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php echo hasRole('Administrator') ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../AccountDashboard/dd.php">
                                <i class="fas fa-money-check-alt me-2"></i> Account Management
                            </a>
                        </li>
                        <?php if (hasRole('Administrator')): ?>
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
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Log
                            </a>
                        </li>
                        <?php if (hasRole('Administrator')): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-chart-line me-2"></i> System Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-cogs me-2"></i> System Settings
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../notifications/notificationCenter.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <?php if (hasRole('Administrator')): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../DataExport/exportWizard.php">
                                <i class="fas fa-file-export me-2"></i> Data Export
                            </a>
                        </li>
                        <?php endif; ?>
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
                    <h1 class="h2">Transaction Log</h1>
                    <div>
                        <span class="badge bg-<?php echo hasRole('Administrator') ? 'danger' : 'primary'; ?>"><?php echo htmlspecialchars($userRole); ?></span>
                        <span class="ms-2">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Filter Transactions</h5>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                    </div>
                    <div class="card-body">
                        <form method="GET" action="transaction_log.php">
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="date_from" class="form-label">Date From</label>
<<<<<<< HEAD
                                        <div class="datepicker-input">
                                            <input type="text" class="form-control" id="date_from" name="date_from" value="<?php echo htmlspecialchars($filters['date_from']); ?>" placeholder="YYYY-MM-DD">
                                        </div>
=======
                                        <input type="text" class="form-control datepicker" id="date_from" name="date_from" value="<?php echo htmlspecialchars($filters['date_from']); ?>" placeholder="YYYY-MM-DD">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="date_to" class="form-label">Date To</label>
<<<<<<< HEAD
                                        <div class="datepicker-input">
                                            <input type="text" class="form-control" id="date_to" name="date_to" value="<?php echo htmlspecialchars($filters['date_to']); ?>" placeholder="YYYY-MM-DD">
                                        </div>
=======
                                        <input type="text" class="form-control datepicker" id="date_to" name="date_to" value="<?php echo htmlspecialchars($filters['date_to']); ?>" placeholder="YYYY-MM-DD">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="transaction_type" class="form-label">Transaction Type</label>
                                        <select class="form-select" id="transaction_type" name="transaction_type">
                                            <option value="">All Types</option>
                                            <option value="deposit" <?php echo $filters['transaction_type'] === 'deposit' ? 'selected' : ''; ?>>Deposit</option>
                                            <option value="withdrawal" <?php echo $filters['transaction_type'] === 'withdrawal' ? 'selected' : ''; ?>>Withdrawal</option>
                                            <option value="transfer" <?php echo $filters['transaction_type'] === 'transfer' ? 'selected' : ''; ?>>Transfer</option>
                                            <option value="payment" <?php echo $filters['transaction_type'] === 'payment' ? 'selected' : ''; ?>>Payment</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="account_id" class="form-label">Account</label>
                                        <select class="form-select" id="account_id" name="account_id">
                                            <option value="">All Accounts</option>
                                            <?php foreach ($accounts as $account): ?>
                                                <option value="<?php echo $account['account_id']; ?>" <?php echo $filters['account_id'] == $account['account_id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($account['display_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="min_amount" class="form-label">Min Amount</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="min_amount" name="min_amount" value="<?php echo htmlspecialchars($filters['min_amount']); ?>" placeholder="Min $">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="max_amount" class="form-label">Max Amount</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="max_amount" name="max_amount" value="<?php echo htmlspecialchars($filters['max_amount']); ?>" placeholder="Max $">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="search" class="form-label">Search</label>
                                        <input type="text" class="form-control" id="search" name="search" value="<?php echo htmlspecialchars($filters['search']); ?>" placeholder="Account # or Description">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 d-flex align-items-end">
                                    <div class="form-group w-100">
<<<<<<< HEAD
                                        <button type="submit" class="btn btn-primary me-2">
                                            <span class="nav-icon">🔍</span> Apply Filters
                                        </button>
                                        <a href="transaction_log.php" class="btn btn-secondary">
                                            <span class="nav-icon">🔄</span> Reset
                                        </a>
=======
                                        <button type="submit" class="btn btn-primary me-2">Apply Filters</button>
                                        <a href="transaction_log.php" class="btn btn-secondary">Reset</a>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
<<<<<<< HEAD
                <!-- Transactions Table -->
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 d-flex align-items-center">
                                <span class="nav-icon me-2">📋</span> Transaction Records
                            </h5>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-secondary me-3">Total: <?php echo number_format($pagination['total']); ?></span>
                                <div class="export-dropdown">
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <span class="nav-icon">📤</span> Export <span class="nav-icon">▼</span>
                                    </button>
                                    <div class="export-dropdown-content">
                                        <a href="#" class="export-dropdown-item">
                                            <span class="nav-icon">📄</span> CSV
                                        </a>
                                        <a href="#" class="export-dropdown-item">
                                            <span class="nav-icon">📑</span> PDF
                                        </a>
                                        <a href="#" class="export-dropdown-item">
                                            <span class="nav-icon">📊</span> Excel
                                        </a>
                                    </div>
                                </div>
=======
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Transaction Records</h5>
                        <div>
                            <span class="badge bg-secondary">Total: <?php echo number_format($pagination['total']); ?></span>
                            <div class="btn-group ms-2">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">CSV</a></li>
                                    <li><a class="dropdown-item" href="#">PDF</a></li>
                                    <li><a class="dropdown-item" href="#">Excel</a></li>
                                </ul>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
<<<<<<< HEAD
                            <table class="transaction-table">
=======
                            <table class="table table-striped table-hover" id="transactionTable">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date & Time</th>
                                        <th>Account</th>
                                        <th>Account Holder</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Balance After</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($transactions)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No transactions found</td>
                                        </tr>
                                    <?php else: ?>
<<<<<<< HEAD
                                        <?php foreach ($transactions as $transaction): 
                                            $typeClass = 'badge-' . $transaction['transaction_type'];
                                        ?>
=======
                                        <?php foreach ($transactions as $transaction): ?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            <tr>
                                                <td><?php echo $transaction['transaction_id']; ?></td>
                                                <td><?php echo $adminController->formatDate($transaction['transaction_date']); ?></td>
                                                <td><?php echo htmlspecialchars($transaction['account_number']); ?></td>
                                                <td><?php echo htmlspecialchars($transaction['account_holder']); ?></td>
<<<<<<< HEAD
                                                <td>
                                                    <span class="transaction-badge <?php echo $typeClass; ?>">
                                                        <?php echo ucfirst($transaction['transaction_type']); ?>
                                                    </span>
                                                </td>
=======
                                                <td><?php echo $adminController->getTransactionTypeBadge($transaction['transaction_type']); ?></td>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                <td><?php echo $adminController->formatCurrency($transaction['amount']); ?></td>
                                                <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                                                <td><?php echo $adminController->formatCurrency($transaction['balance_after']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php if ($pagination['total_pages'] > 1): ?>
                            <nav>
<<<<<<< HEAD
                                <ul class="pagination">
=======
                                <ul class="pagination justify-content-center">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    <?php
                                        $queryParams = $_GET;
                                        if ($page > 1) {
                                            $queryParams['page'] = $page - 1;
                                            $prevUrl = 'transaction_log.php?' . http_build_query($queryParams);
<<<<<<< HEAD
                                            echo '<li class="pagination-item"><a class="pagination-link" href="' . $prevUrl . '">&laquo; Previous</a></li>';
                                        } else {
                                            echo '<li class="pagination-item"><span class="pagination-link disabled">&laquo; Previous</span></li>';
=======
                                            echo '<li class="page-item"><a class="page-link" href="' . $prevUrl . '">&laquo; Previous</a></li>';
                                        } else {
                                            echo '<li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        }
                                        $startPage = max(1, $page - 2);
                                        $endPage = min($pagination['total_pages'], $page + 2);
                                        for ($i = $startPage; $i <= $endPage; $i++) {
                                            $queryParams['page'] = $i;
                                            $url = 'transaction_log.php?' . http_build_query($queryParams);
                                            if ($i == $page) {
<<<<<<< HEAD
                                                echo '<li class="pagination-item"><span class="pagination-link active">' . $i . '</span></li>';
                                            } else {
                                                echo '<li class="pagination-item"><a class="pagination-link" href="' . $url . '">' . $i . '</a></li>';
=======
                                                echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="' . $url . '">' . $i . '</a></li>';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            }
                                        }
                                        if ($page < $pagination['total_pages']) {
                                            $queryParams['page'] = $page + 1;
                                            $nextUrl = 'transaction_log.php?' . http_build_query($queryParams);
<<<<<<< HEAD
                                            echo '<li class="pagination-item"><a class="pagination-link" href="' . $nextUrl . '">Next &raquo;</a></li>';
                                        } else {
                                            echo '<li class="pagination-item"><span class="pagination-link disabled">Next &raquo;</span></li>';
=======
                                            echo '<li class="page-item"><a class="page-link" href="' . $nextUrl . '">Next &raquo;</a></li>';
                                        } else {
                                            echo '<li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        }
                                    ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
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
            
            // Initialize datepicker inputs with a simple date validator
            const dateInputs = document.querySelectorAll('.datepicker-input input');
            dateInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const dateValue = this.value;
                    if (dateValue && !/^\d{4}-\d{2}-\d{2}$/.test(dateValue)) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
            });
            
            // Make table rows clickable for details (if needed)
            const tableRows = document.querySelectorAll('.transaction-table tbody tr');
            tableRows.forEach(row => {
                row.style.cursor = 'pointer';
                row.addEventListener('click', function() {
                    // You can implement a detailed view action here
                    const transactionId = this.querySelector('td:first-child').textContent;
                    console.log('Transaction details for ID:', transactionId);
                });
            });
        });
    </script>
</body>
</html> 
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            allowInput: true
        });
    </script>
</body>
</html>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

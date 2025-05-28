<?php
session_start();
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
<<<<<<< HEAD
require_once __DIR__ . '/../../controllers/AccountController.php';
$accountController = new AccountController();
=======

require_once __DIR__ . '/../../controllers/AccountController.php';
$accountController = new AccountController();

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
$userId = $_SESSION['user_id'];
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
<<<<<<< HEAD
$accounts = $accountController->getUserAccounts($userId);
?>
=======

$accounts = $accountController->getUserAccounts($userId);
?>

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Dashboard specific styles */
        .quick-link-card {
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            height: 100%;
            color: white;
            text-align: center;
            padding: 20px;
        }
        
        .quick-link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .quick-link-card.accounts {
            background: var(--primary-color);
            background: linear-gradient(135deg, var(--primary-color) 0%, #4dabf7 100%);
        }
        
        .quick-link-card.transfers {
            background: var(--success-color);
            background: linear-gradient(135deg, var(--success-color) 0%, #69db7c 100%);
        }
        
        .quick-link-card.bills {
            background: var(--info-color);
            background: linear-gradient(135deg, var(--info-color) 0%, #4dc9f6 100%);
        }
        
        .quick-link-card.loans {
            background: var(--warning-color);
            background: linear-gradient(135deg, var(--warning-color) 0%, #ffd43b 100%);
        }
        
        .quick-link-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }
        
        /* Account table styles */
        .accounts-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .accounts-table th,
        .accounts-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .accounts-table thead th {
            background-color: var(--card-bg);
            font-weight: 600;
            text-align: left;
        }
        
        .accounts-table tbody tr:hover {
            background-color: var(--hover-bg);
        }
        
        /* Activity list styles */
        .activity-item {
            border-radius: 8px;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-color);
            margin-bottom: 10px;
            padding: 15px;
            display: block;
            text-decoration: none;
            color: inherit;
        }
        
        .activity-item:hover {
            background-color: var(--hover-bg);
            transform: translateX(5px);
        }
        
        .activity-item.deposit {
            border-left-color: var(--success-color);
        }
        
        .activity-item.payment {
            border-left-color: var(--danger-color);
        }
        
        .activity-item.transfer {
            border-left-color: var(--info-color);
        }
        
        .activity-item .activity-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 5px;
        }
        
        .activity-item .activity-amount {
            font-weight: 600;
        }
        
        .activity-amount.deposit {
            color: var(--success-color);
        }
        
        .activity-amount.payment {
            color: var(--danger-color);
        }
        
        .activity-amount.transfer {
            color: var(--info-color);
        }
        
        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-badge.active {
            background-color: rgba(var(--success-rgb), 0.2);
            color: var(--success-color);
        }
        
        .status-badge.inactive {
            background-color: rgba(var(--danger-rgb), 0.2);
            color: var(--danger-color);
        }
        
        /* Chart container */
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
        
        /* Placeholder for chart when no CDN is used */
        .chart-placeholder {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
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
        
        /* Custom donut chart using CSS */
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
        
        .details-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 4px;
            background-color: var(--info-color);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .details-btn:hover {
            background-color: #0dcaf0;
            transform: translateY(-2px);
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
                    <p class="text-white-50">Customer Portal</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/dd.php">
                            <span class="nav-icon">💳</span> My Accounts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../FundTransfers/transfer.php">
                            <span class="nav-icon">↔️</span> Fund Transfers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../LoanManagement/LoanApplication.php">
                            <span class="nav-icon">💰</span> Loans
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../BillPayments/PayBill.php">
                            <span class="nav-icon">💸</span> Bill Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../ProfileManagement/ViewProfile.php">
                            <span class="nav-icon">👤</span> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transaction_log.php">
                            <span class="nav-icon">🕒</span> Transaction History
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
                        <h1 class="h2 mb-0">Dashboard</h1>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="user-dropdown">
                        <div class="user-info">
                            <div class="user-avatar" data-name="<?php echo htmlspecialchars($fullName); ?>"></div>
                            <div class="d-none d-md-block">
                                <div class="fw-bold"><?php echo htmlspecialchars($fullName); ?></div>
                                <div class="small text-muted">Customer</div>
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
                
                <!-- Quick Links -->
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
                                <i class="fas fa-money-check-alt me-2"></i> My Accounts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../FundTransfers/transfer.php">
                                <i class="fas fa-exchange-alt me-2"></i> Fund Transfers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../LoanManagement/LoanApplication.php">
                                <i class="fas fa-hand-holding-usd me-2"></i> Loans
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../BillPayments/PayBill.php">
                                <i class="fas fa-file-invoice-dollar me-2"></i> Bill Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../notifications/notificationCenter.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../ProfileManagement/ViewProfile.php">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="transaction_log.php">
                                <i class="fas fa-history me-2"></i> Transaction History
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
                    <h1 class="h2">Dashboard</h1>
                    <div>
                        <span class="badge bg-primary">Customer</span>
                        <span class="ms-2">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
<<<<<<< HEAD
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">⚡</span> Quick Links
                                </h5>
=======
                                <h5 class="mb-0">Quick Links</h5>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <a href="../AccountDashboard/dd.php" class="text-decoration-none">
<<<<<<< HEAD
                                            <div class="quick-link-card accounts">
                                                <span class="quick-link-icon">💳</span>
                                                <h5 class="card-title">View Accounts</h5>
=======
                                            <div class="card text-center bg-primary text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-money-check-alt fa-3x mb-3"></i>
                                                    <h5 class="card-title">View Accounts</h5>
                                                </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="../FundTransfers/TransferWizerd.php" class="text-decoration-none">
<<<<<<< HEAD
                                            <div class="quick-link-card transfers">
                                                <span class="quick-link-icon">↔️</span>
                                                <h5 class="card-title">Transfer Funds</h5>
=======
                                            <div class="card text-center bg-success text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-exchange-alt fa-3x mb-3"></i>
                                                    <h5 class="card-title">Transfer Funds</h5>
                                                </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="../BillPayments/PayBill.php" class="text-decoration-none">
<<<<<<< HEAD
                                            <div class="quick-link-card bills">
                                                <span class="quick-link-icon">💸</span>
                                                <h5 class="card-title">Pay Bills</h5>
=======
                                            <div class="card text-center bg-info text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                                                    <h5 class="card-title">Pay Bills</h5>
                                                </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="../LoanManagement/LoanApplication.php" class="text-decoration-none">
<<<<<<< HEAD
                                            <div class="quick-link-card loans">
                                                <span class="quick-link-icon">💰</span>
                                                <h5 class="card-title">Apply for Loan</h5>
=======
                                            <div class="card text-center bg-warning text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-hand-holding-usd fa-3x mb-3"></i>
                                                    <h5 class="card-title">Apply for Loan</h5>
                                                </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Account Summary -->
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
<<<<<<< HEAD
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">📝</span> Account Summary
                                </h5>
                                <a href="../AccountDashboard/dd.php" class="btn btn-primary">View All Accounts</a>
=======
                                <h5 class="mb-0">Account Summary</h5>
                                <a href="../AccountDashboard/dd.php" class="btn btn-sm btn-primary">View All Accounts</a>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                            <div class="card-body">
                                <?php if (!empty($accounts)): ?>
                                    <div class="table-responsive">
<<<<<<< HEAD
                                        <table class="accounts-table">
=======
                                        <table class="table table-striped">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            <thead>
                                                <tr>
                                                    <th>Account Type</th>
                                                    <th>Account Number</th>
                                                    <th>Balance</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($accounts as $account): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($account['account_type']); ?></td>
                                                        <td><?php echo htmlspecialchars($account['account_number']); ?></td>
                                                        <td><?php echo $accountController->formatCurrency($account['balance']); ?></td>
<<<<<<< HEAD
                                                        <td>
                                                            <span class="status-badge <?php echo $account['is_active'] ? 'active' : 'inactive'; ?>">
                                                                <?php echo $account['is_active'] ? 'Active' : 'Inactive'; ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="../AccountDashboard/account_details.php?account_id=<?php echo $account['account_id']; ?>" class="details-btn">
                                                                <span class="nav-icon">👁️</span> Details
=======
                                                        <td><?php echo $accountController->getAccountStatusBadge($account['is_active']); ?></td>
                                                        <td>
                                                            <a href="../AccountDashboard/account_details.php?account_id=<?php echo $account['account_id']; ?>" class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i> Details
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
<<<<<<< HEAD
                                        <span class="nav-icon me-2">ℹ️</span>
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        You don't have any accounts yet. Please contact customer service.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Financial Overview -->
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
<<<<<<< HEAD
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">📈</span> Balance Overview
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <?php if (!empty($accounts)): ?>
                                        <div class="chart-placeholder">
                                            <div class="donut-chart">
                                                <div class="donut-hole"></div>
                                            </div>
                                            <div class="chart-legend">
                                                <?php 
                                                $colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];
                                                foreach ($accounts as $index => $account): 
                                                    $colorIndex = $index % count($colors);
                                                ?>
                                                    <div class="chart-legend-item">
                                                        <div class="legend-color" style="background-color: <?php echo $colors[$colorIndex]; ?>"></div>
                                                        <span><?php echo htmlspecialchars($account['account_type']); ?>: <?php echo $accountController->formatCurrency($account['balance']); ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="chart-placeholder">
                                            <span class="nav-icon" style="font-size: 3rem;">📊</span>
                                            <p class="mt-3">No account data available</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
=======
                                <h5 class="mb-0">Balance Overview</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="balanceChart"></canvas>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
<<<<<<< HEAD
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">🕒</span> Recent Activity
                                </h5>
                            </div>
                            <div class="card-body">
                                <a href="#" class="activity-item deposit">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="activity-title">
                                            <span class="nav-icon me-2">⬆️</span> Deposit
                                        </div>
                                        <small class="text-muted">3 days ago</small>
                                    </div>
                                    <p class="mb-1">Deposit to Savings Account</p>
                                    <div class="activity-amount deposit">+$500.00</div>
                                </a>
                                <a href="#" class="activity-item payment">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="activity-title">
                                            <span class="nav-icon me-2">📄</span> Bill Payment
                                        </div>
                                        <small class="text-muted">1 week ago</small>
                                    </div>
                                    <p class="mb-1">Utility Bill Payment</p>
                                    <div class="activity-amount payment">-$120.50</div>
                                </a>
                                <a href="#" class="activity-item transfer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="activity-title">
                                            <span class="nav-icon me-2">↔️</span> Transfer
                                        </div>
                                        <small class="text-muted">2 weeks ago</small>
                                    </div>
                                    <p class="mb-1">Transfer to Checking Account</p>
                                    <div class="activity-amount transfer">$300.00</div>
                                </a>
=======
                                <h5 class="mb-0">Recent Activity</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Deposit</h6>
                                            <small class="text-muted">3 days ago</small>
                                        </div>
                                        <p class="mb-1">Deposit to Savings Account</p>
                                        <small class="text-success">+$500.00</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Bill Payment</h6>
                                            <small class="text-muted">1 week ago</small>
                                        </div>
                                        <p class="mb-1">Utility Bill Payment</p>
                                        <small class="text-danger">-$120.50</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Transfer</h6>
                                            <small class="text-muted">2 weeks ago</small>
                                        </div>
                                        <p class="mb-1">Transfer to Checking Account</p>
                                        <small class="text-primary">$300.00</small>
                                    </a>
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
    
    <!-- Dark Mode Toggle -->
    <div class="dark-mode-toggle" data-tooltip="Toggle Dark Mode">
        <span class="nav-icon">🌙</span>
    </div>
    
    <script src="../../../public/js/custom-design.js"></script>
</body>
</html> 
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('balanceChart').getContext('2d');
            <?php
            $accountLabels = [];
            $balanceData = [];
            $backgroundColors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];
            if (!empty($accounts)) {
                foreach ($accounts as $index => $account) {
                    $accountLabels[] = $account['account_type'];
                    $balanceData[] = $account['balance'];
                }
            }
            ?>
            const accountLabels = <?php echo json_encode($accountLabels); ?>;
            const balanceData = <?php echo json_encode($balanceData); ?>;
            const backgroundColors = <?php echo json_encode($backgroundColors); ?>;
            if (accountLabels.length > 0) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: accountLabels,
                        datasets: [{
                            data: balanceData,
                            backgroundColor: backgroundColors,
                            hoverBackgroundColor: backgroundColors,
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    return data.labels[tooltipItem.index] + ': $' + 
                                           parseFloat(data.datasets[0].data[tooltipItem.index]).toFixed(2);
                                }
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    },
                });
            } else {
                document.getElementById('balanceChart').parentNode.innerHTML = 
                    '<div class="text-center py-4">No account data available</div>';
            }
        });
    </script>
</body>
</html>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

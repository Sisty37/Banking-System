<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
require_once __DIR__ . '/../../controllers/AccountController.php';
$accountController = new AccountController();
$userId = $_SESSION['user_id'];
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$accounts = $accountController->getUserAccounts($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
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
</head>
<body>
    <div class="container-fluid">
        <div class="row">
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
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">⚡</span> Quick Links
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <a href="../AccountDashboard/dd.php" class="text-decoration-none">
                                            <div class="quick-link-card accounts">
                                                <span class="quick-link-icon">💳</span>
                                                <h5 class="card-title">View Accounts</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="../FundTransfers/TransferWizerd.php" class="text-decoration-none">
                                            <div class="quick-link-card transfers">
                                                <span class="quick-link-icon">↔️</span>
                                                <h5 class="card-title">Transfer Funds</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="../BillPayments/PayBill.php" class="text-decoration-none">
                                            <div class="quick-link-card bills">
                                                <span class="quick-link-icon">💸</span>
                                                <h5 class="card-title">Pay Bills</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="../LoanManagement/LoanApplication.php" class="text-decoration-none">
                                            <div class="quick-link-card loans">
                                                <span class="quick-link-icon">💰</span>
                                                <h5 class="card-title">Apply for Loan</h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Account Summary -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">📝</span> Account Summary
                                </h5>
                                <a href="../AccountDashboard/dd.php" class="btn btn-primary">View All Accounts</a>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($accounts)): ?>
                                    <div class="table-responsive">
                                        <table class="accounts-table">
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
                                                        <td>
                                                            <span class="status-badge <?php echo $account['is_active'] ? 'active' : 'inactive'; ?>">
                                                                <?php echo $account['is_active'] ? 'Active' : 'Inactive'; ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="../AccountDashboard/account_details.php?account_id=<?php echo $account['account_id']; ?>" class="details-btn">
                                                                <span class="nav-icon">👁️</span> Details
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <span class="nav-icon me-2">ℹ️</span>
                                        You don't have any accounts yet. Please contact customer service.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Financial Overview -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
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
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dark Mode Toggle -->
    <div class="dark-mode-toggle" data-tooltip="Toggle Dark Mode">
        <span class="nav-icon">🌙</span>
    </div>
    
    <script src="../../../public/js/custom-design.js"></script>
</body>
</html> 
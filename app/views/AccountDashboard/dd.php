<?php
<<<<<<< HEAD
require_once __DIR__ . '/../../appInitializer.php';
=======
require_once __DIR__ . '/../../bootstrap.php';

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (!isLoggedIn()) {
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
$role = $_SESSION['role'] ?? 'Customer';
<<<<<<< HEAD
$accounts = $accountController->getUserAccounts($userId);
$totalBalance = 0;
$savingsBalance = 0;
$checkingBalance = 0;
=======

$accounts = $accountController->getUserAccounts($userId);

$totalBalance = 0;
$savingsBalance = 0;
$checkingBalance = 0;

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (!empty($accounts)) {
    foreach ($accounts as $account) {
        $totalBalance += $account['balance'];
        if (strtolower($account['account_type']) === 'savings') {
            $savingsBalance += $account['balance'];
        } elseif (strtolower($account['account_type']) === 'checking') {
            $checkingBalance += $account['balance'];
        }
    }
}
?>
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Overview - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Account card styles */
        .account-card {
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            height: 100%;
            color: white;
        }
        
        .account-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .account-card.total {
            background: var(--primary-color);
            background: linear-gradient(135deg, var(--primary-color) 0%, #4dabf7 100%);
        }
        
        .account-card.savings {
            background: var(--success-color);
            background: linear-gradient(135deg, var(--success-color) 0%, #69db7c 100%);
        }
        
        .account-card.checking {
            background: var(--info-color);
            background: linear-gradient(135deg, var(--info-color) 0%, #4dc9f6 100%);
        }
        
        .card-amount {
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0;
        }
        
        /* Account list item styles */
        .account-item {
            border-radius: 8px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            margin-bottom: 10px;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }
        
        .account-item:hover {
            background-color: var(--hover-bg);
            border-left-color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .account-item.savings {
            border-left-color: var(--success-color);
        }
        
        .account-item.checking {
            border-left-color: var(--info-color);
        }
        
        .account-item .account-details {
            flex: 1;
        }
        
        .account-item .balance-info {
            text-align: right;
        }
        
        /* Quick action buttons */
        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            text-decoration: none;
            color: inherit;
            gap: 10px;
            min-width: 120px;
        }
        
        .action-btn:hover {
            background-color: var(--hover-bg);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .action-btn .icon {
            font-size: 24px;
        }
        
        /* Tip cards */
        .tip-card {
            border-radius: 8px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .tip-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .tip-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
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
        
        /* User welcome bar */
        .welcome-bar {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .user-role {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            font-size: 0.85rem;
        }
    </style>
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
                    <p class="text-white-50">Customer Portal</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/customer_dashboard.php">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">💳</span> My Accounts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../FundTransfers/TransferWizerd.php">
                            <span class="nav-icon">↔️</span> Fund Transfers
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
                        <h1 class="h2 mb-0">Account Overview</h1>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="user-dropdown">
                        <div class="user-info">
                            <div class="user-avatar" data-name="<?php echo htmlspecialchars($fullName); ?>"></div>
                            <div class="d-none d-md-block">
                                <div class="fw-bold"><?php echo htmlspecialchars($fullName); ?></div>
                                <div class="small text-muted"><?php echo htmlspecialchars($role); ?></div>
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
                
                <!-- Summary Section -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="account-card total">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <span class="icon-large me-3">💰</span>
                                    <h5 class="card-title mb-0">Total Balance</h5>
                                </div>
                                <div class="card-amount"><?php echo $accountController->formatCurrency($totalBalance); ?></div>
                                <p class="card-text opacity-75">All accounts combined</p>
=======
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/customer_dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
                                <i class="fas fa-money-check-alt me-2"></i> My Accounts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../FundTransfers/TransferWizerd.php">
                                <i class="fas fa-exchange-alt me-2"></i> Fund Transfers
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
                    <h1 class="h2">Account Overview</h1>
                    <div>
                        <span class="badge bg-primary"><?php echo htmlspecialchars($role); ?></span>
                        <span class="ms-2">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Total Balance</h5>
                                <h2 class="display-6"><?php echo $accountController->formatCurrency($totalBalance); ?></h2>
                                <p class="card-text">All accounts combined</p>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
<<<<<<< HEAD
                        <div class="account-card savings">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <span class="icon-large me-3">🏦</span>
                                    <h5 class="card-title mb-0">Savings</h5>
                                </div>
                                <div class="card-amount"><?php echo $accountController->formatCurrency($savingsBalance); ?></div>
                                <p class="card-text opacity-75">Total savings balance</p>
=======
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Savings</h5>
                                <h2 class="display-6"><?php echo $accountController->formatCurrency($savingsBalance); ?></h2>
                                <p class="card-text">Total savings balance</p>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
<<<<<<< HEAD
                        <div class="account-card checking">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <span class="icon-large me-3">📝</span>
                                    <h5 class="card-title mb-0">Checking</h5>
                                </div>
                                <div class="card-amount"><?php echo $accountController->formatCurrency($checkingBalance); ?></div>
                                <p class="card-text opacity-75">Total checking balance</p>
=======
                        <div class="card bg-info text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Checking</h5>
                                <h2 class="display-6"><?php echo $accountController->formatCurrency($checkingBalance); ?></h2>
                                <p class="card-text">Total checking balance</p>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Quick Actions -->
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-center gap-3">
<<<<<<< HEAD
                                    <a href="../FundTransfers/TransferWizerd.php" class="action-btn">
                                        <span class="icon">↔️</span>
                                        <span>Transfer Funds</span>
                                    </a>
                                    <a href="#" class="action-btn">
                                        <span class="icon">💸</span>
                                        <span>Pay Bills</span>
                                    </a>
                                    <a href="account_details.php" class="action-btn">
                                        <span class="icon">🔍</span>
                                        <span>Account Details</span>
                                    </a>
                                    <a href="#" class="action-btn">
                                        <span class="icon">📥</span>
                                        <span>Download Statement</span>
=======
                                    <a href="../FundTransfers/TransferWizerd.php" class="btn btn-primary">
                                        <i class="fas fa-exchange-alt me-2"></i> Transfer Funds
                                    </a>
                                    <a href="#" class="btn btn-success">
                                        <i class="fas fa-file-invoice-dollar me-2"></i> Pay Bills
                                    </a>
                                    <a href="account_details.php" class="btn btn-info">
                                        <i class="fas fa-search-dollar me-2"></i> View Account Details
                                    </a>
                                    <a href="#" class="btn btn-warning">
                                        <i class="fas fa-file-download me-2"></i> Download Statement
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Account List -->
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Your Accounts</h5>
                                <?php if ($accountController->hasAccountManagementPermission()): ?>
<<<<<<< HEAD
                                <a href="create_account.php" class="btn btn-primary">
                                    <span class="nav-icon">➕</span> Create Account
                                </a>
                                <?php else: ?>
                                <a href="#" class="btn btn-outline-primary">Open New Account</a>
=======
                                <a href="create_account.php" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> Create Account
                                </a>
                                <?php else: ?>
                                <a href="#" class="btn btn-sm btn-outline-primary">Open New Account</a>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($accounts)): ?>
<<<<<<< HEAD
                                    <div class="account-list">
                                        <?php foreach ($accounts as $account): ?>
                                            <?php 
                                            $accountClass = strtolower($account['account_type']);
                                            $accountIcon = $accountClass === 'savings' ? '🏦' : ($accountClass === 'checking' ? '📝' : '💳');
                                            ?>
                                            <a href="account_details.php?account_id=<?php echo $account['account_id']; ?>" 
                                               class="account-item <?php echo $accountClass; ?>">
                                                <div class="account-details">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="nav-icon me-2"><?php echo $accountIcon; ?></span>
                                                        <h5 class="mb-0"><?php echo htmlspecialchars($account['account_type']); ?> Account</h5>
                                                    </div>
                                                    <p class="mb-1">Account #: <?php echo htmlspecialchars($account['account_number']); ?></p>
                                                    <div class="status-badge <?php echo $account['is_active'] ? 'active' : 'inactive'; ?>">
                                                        <?php echo $account['is_active'] ? 'Active' : 'Inactive'; ?>
                                                    </div>
                                                </div>
                                                <div class="balance-info">
                                                    <h5 class="mb-1"><?php echo $accountController->formatCurrency($account['balance']); ?></h5>
                                                    <small class="text-muted">Available Balance</small>
                                                </div>
=======
                                    <div class="list-group">
                                        <?php foreach ($accounts as $account): ?>
                                            <a href="account_details.php?account_id=<?php echo $account['account_id']; ?>" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between align-items-center">
                                                    <div>
                                                        <h5 class="mb-1"><?php echo htmlspecialchars($account['account_type']); ?> Account</h5>
                                                        <p class="mb-1">Account #: <?php echo htmlspecialchars($account['account_number']); ?></p>
                                                        <small><?php echo $accountController->getAccountStatusBadge($account['is_active']); ?></small>
                                                    </div>
                                                    <div class="text-end">
                                                        <h5 class="mb-1"><?php echo $accountController->formatCurrency($account['balance']); ?></h5>
                                                        <small class="text-muted">Available Balance</small>
                                                    </div>
                                                </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
<<<<<<< HEAD
                                        <span class="nav-icon me-2">ℹ️</span>
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        You don't have any accounts yet. Please contact customer service to open an account.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Financial Tips -->
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Financial Tips</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
<<<<<<< HEAD
                                        <div class="tip-card card">
                                            <div class="card-body">
                                                <h5 class="card-title"><span class="nav-icon">🧰</span> Emergency Fund</h5>
=======
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">Emergency Fund</h5>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                <p class="card-text">Aim to save 3-6 months of expenses in an emergency fund for unexpected costs.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
<<<<<<< HEAD
                                        <div class="tip-card card">
                                            <div class="card-body">
                                                <h5 class="card-title"><span class="nav-icon">🎯</span> Savings Goal</h5>
=======
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">Savings Goal</h5>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                <p class="card-text">Set up automatic transfers to your savings account to reach your financial goals faster.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
<<<<<<< HEAD
                                        <div class="tip-card card">
                                            <div class="card-body">
                                                <h5 class="card-title"><span class="nav-icon">📊</span> Budget Planning</h5>
=======
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">Budget Planning</h5>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                <p class="card-text">Track your spending and create a monthly budget to improve your financial health.</p>
                                            </div>
                                        </div>
                                    </div>
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
    
    <script src="../../../public/js/custom-design.js"></script>
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
</body>
</html>

<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
<<<<<<< HEAD
require_once __DIR__ . '/../../appInitializer.php';
=======
require_once __DIR__ . '/../../bootstrap.php';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (!isLoggedIn()) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
require_once __DIR__ . '/../../controllers/LoanController.php';
$loanController = new LoanController();
$userId = $_SESSION['user_id'] ?? 0;
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$userRole = $_SESSION['role_name'] ?? 'Customer';
$loanTypes = $loanController->getLoanTypes();
<<<<<<< HEAD

// Check if getLoanStatistics method exists and provide a fallback if it doesn't
$loanStats = [];
if (method_exists($loanController, 'getLoanStatistics')) {
    $loanStats = $loanController->getLoanStatistics($userId);
} else {
    // Fallback data if the method doesn't exist
    $loanStats = [
        'total_loans' => 0,
        'active_loans' => 0,
        'total_borrowed' => 0,
        'outstanding_balance' => 0
    ];
}
?>
=======
$loanStats = $loanController->getLoanStatistics($userId);
?>

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Management - Banking System</title>
<<<<<<< HEAD
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Loan Management specific styles */
        .loan-card {
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            height: 100%;
        }
        
        .loan-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            font-weight: 600;
            background-color: var(--primary-color);
            color: white;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
        }
        
        .loan-card-header.success {
            background-color: var(--success-color);
        }
        
        .loan-card-header.info {
            background-color: var(--info-color);
        }
        
        .loan-card-header.warning {
            background-color: var(--warning-color);
            color: var(--text-color);
        }
        
        .loan-card-header.secondary {
            background-color: var(--secondary-color);
        }
        
        .loan-card-body {
            padding: 20px;
            color: var(--text-color);
        }
        
        .loan-card-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom-left-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
        }
        
        .stat-card-title {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .stat-card-value {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
        }
        
        .loan-option-card {
            height: 100%;
        }
        
        .loan-option-header {
            padding: 12px 15px;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
        }
        
        .loan-option-body {
            padding: 15px;
        }
        
        .loan-option-body p {
            margin-bottom: 8px;
        }
        
        .loan-form-group {
            margin-bottom: 20px;
        }
        
        .loan-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        .loan-form-input,
        .loan-form-select {
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .loan-form-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
        }
        
        .loan-form-input:focus,
        .loan-form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        .loan-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }
        
        .loan-btn-block {
            width: 100%;
        }
        
        .loan-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .loan-btn-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .loan-btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .loan-btn:hover {
            opacity: 0.9;
        }
        
        .calculation-result {
            margin-bottom: 15px;
        }
        
        .calculation-result-title {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 5px;
        }
        
        .calculation-result-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }
        
        .progress-container {
            height: 25px;
            background-color: var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .progress-bar {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
            transition: width 0.6s ease;
        }
        
        .progress-bar-primary {
            background-color: var(--primary-color);
        }
        
        .progress-bar-warning {
            background-color: var(--warning-color);
            color: var(--text-color);
        }
        
        .placeholder-content {
            text-align: center;
            padding: 40px 0;
            color: var(--text-secondary);
        }
        
        .placeholder-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        .placeholder-text {
            font-size: 1.1rem;
            opacity: 0.7;
        }
        
        /* FAQ Accordion Styles */
        .faq-accordion {
            margin-bottom: 15px;
        }
        
        .faq-accordion-item {
            margin-bottom: 10px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        
        .faq-accordion-header {
            background-color: var(--card-bg);
            border: none;
            width: 100%;
            text-align: left;
            padding: 15px 20px;
            font-weight: 600;
            color: var(--text-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition);
        }
        
        .faq-accordion-header:hover {
            background-color: var(--hover-color);
        }
        
        .faq-accordion-header:after {
            content: '▼';
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }
        
        .faq-accordion-header.active:after {
            transform: rotate(180deg);
        }
        
        .faq-accordion-body {
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            background-color: var(--card-bg);
        }
        
        .faq-accordion-body-inner {
            padding: 15px 20px;
            color: var(--text-color);
        }
        
        .faq-accordion-body.active {
            max-height: 300px;
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
                        <a class="nav-link" href="../Dashboard/<?php echo $userRole === 'Administrator' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/dd.php">
                            <span class="nav-icon">💳</span> Account Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../FundTransfers/TransferWizerd.php">
                            <span class="nav-icon">💸</span> Fund Transfers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">💰</span> Loan Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/PayBill.php">
                            <span class="nav-icon">📄</span> Bill Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../DataExport/exportWizard.php">
                            <span class="nav-icon">📤</span> Export Data
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <a class="nav-link" href="../../controllers/UserAuthentication/Logout.php">
                            <span class="nav-icon">🚪</span> Logout
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <div class="content-header">
                    <h1>Loan Management</h1>
                    <div class="header-actions">
                        <a href="LoanApplication.php" class="loan-btn loan-btn-primary">
                            <span>➕</span> Apply for Loan
                        </a>
                        <a href="LoanStatus.php" class="loan-btn loan-btn-outline ms-2">
                            <span>📋</span> My Loans
                        </a>
                    </div>
                </div>
                
                <!-- User Dropdown in Header -->
                <div class="user-dropdown">
                    <button class="user-dropdown-btn" id="userDropdownBtn">
                        <div class="user-avatar" id="userAvatar"></div>
                        <span><?php echo htmlspecialchars($fullName); ?></span>
                        <span class="dropdown-arrow">▼</span>
                    </button>
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <a href="../Profile/ViewProfile.php">
                            <span class="dropdown-icon">👤</span> View Profile
                        </a>
                        <a href="../Profile/EditProfile.php">
                            <span class="dropdown-icon">✏️</span> Edit Profile
                        </a>
                        <a href="../Profile/ChangePassword.php">
                            <span class="dropdown-icon">🔒</span> Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="../../controllers/UserAuthentication/Logout.php">
                            <span class="dropdown-icon">🚪</span> Logout
                        </a>
                    </div>
                </div>

                <!-- Toggle for mobile -->
                <button id="sidebarToggle" class="sidebar-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
                <!-- Dark Mode Toggle -->
                <button id="darkModeToggle" class="dark-mode-toggle">
                    <span class="light-icon">☀️</span>
                    <span class="dark-icon">🌙</span>
                </button>
                
                <!-- Loan Statistics -->
                <div class="stats-grid">
                    <div class="loan-card">
                        <div class="loan-card-header">
                            <span class="card-icon">📊</span> Total Loans
                        </div>
                        <div class="loan-card-body text-center">
                            <h3 class="stat-card-value"><?php echo $loanStats['total_loans'] ?? 0; ?></h3>
                        </div>
                    </div>
                    
                    <div class="loan-card">
                        <div class="loan-card-header success">
                            <span class="card-icon">✅</span> Active Loans
                        </div>
                        <div class="loan-card-body text-center">
                            <h3 class="stat-card-value"><?php echo $loanStats['active_loans'] ?? 0; ?></h3>
                        </div>
                    </div>
                    
                    <div class="loan-card">
                        <div class="loan-card-header info">
                            <span class="card-icon">💵</span> Total Borrowed
                        </div>
                        <div class="loan-card-body text-center">
                            <h3 class="stat-card-value">$<?php echo number_format($loanStats['total_borrowed'] ?? 0, 2); ?></h3>
                        </div>
                    </div>
                    
                    <div class="loan-card">
                        <div class="loan-card-header warning">
                            <span class="card-icon">⚠️</span> Outstanding Balance
                        </div>
                        <div class="loan-card-body text-center">
                            <h3 class="stat-card-value">$<?php echo number_format($loanStats['outstanding_balance'] ?? 0, 2); ?></h3>
                        </div>
                    </div>
                </div>
                
                <!-- Loan Options -->
                <div class="content-section">
                    <div class="loan-card">
                        <div class="loan-card-header">
                            <span class="card-icon">💰</span> Loan Options
                        </div>
                        <div class="loan-card-body">
                            <div class="loan-options-grid">
                                <?php foreach ($loanTypes as $loanType): ?>
                                    <div class="loan-option-item">
                                        <div class="loan-card loan-option-card">
                                            <div class="loan-option-header">
                                                <h5><?php echo htmlspecialchars($loanType['type_name']); ?></h5>
                                            </div>
                                            <div class="loan-option-body">
                                                <p><strong>Interest Rate:</strong> <?php echo $loanType['interest_rate_min']; ?>% - <?php echo $loanType['interest_rate_max']; ?>%</p>
                                                <p><strong>Max Amount:</strong> $<?php echo number_format($loanType['max_amount'], 2); ?></p>
                                                <p><strong>Processing Fee:</strong> <?php echo $loanType['processing_fee']; ?>%</p>
                                                <p><?php echo htmlspecialchars($loanType['description']); ?></p>
                                            </div>
                                            <div class="loan-card-footer">
                                                <a href="LoanApplication.php?loan_type=<?php echo $loanType['loan_type_id']; ?>" class="loan-btn loan-btn-primary loan-btn-block">Apply Now</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="sidebar-header mb-4 text-center text-white">
                        <h4>Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/customer_dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../AccountManagement/account_management.php">
                                <i class="fas fa-user-circle me-2"></i> Account Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../FundTransfer/fund_transfer.php">
                                <i class="fas fa-exchange-alt me-2"></i> Fund Transfers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="LoanManagement.php">
                                <i class="fas fa-hand-holding-usd me-2"></i> Loan Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../BillPayment/bill_payment.php">
                                <i class="fas fa-file-invoice-dollar me-2"></i> Bill Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Notifications/notifications.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link text-white" href="../UserAuthentication/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Loan Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="LoanApplication.php" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-plus me-1"></i> Apply for Loan
                        </a>
                        <a href="LoanStatus.php" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-list me-1"></i> My Loans
                        </a>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Loans</h5>
                                <h3><?php echo $loanStats['total_loans']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Active Loans</h5>
                                <h3><?php echo $loanStats['active_loans']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Borrowed</h5>
                                <h3>$<?php echo number_format($loanStats['total_borrowed'], 2); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <h5 class="card-title">Outstanding Balance</h5>
                                <h3>$<?php echo number_format($loanStats['outstanding_balance'], 2); ?></h3>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Loan Calculator -->
                <div class="content-section">
                    <div class="grid-container">
                        <div class="grid-item">
                            <div class="loan-card">
                                <div class="loan-card-header info">
                                    <span class="card-icon">🧮</span> Loan Calculator
                                </div>
                                <div class="loan-card-body">
                                    <form id="loan-calculator-form">
                                        <div class="loan-form-group">
                                            <label for="loan-amount" class="loan-form-label">Loan Amount ($)</label>
                                            <input type="number" class="loan-form-input" id="loan-amount" min="1000" step="1000" value="10000" required>
                                        </div>
                                        <div class="loan-form-group">
                                            <label for="interest-rate" class="loan-form-label">Interest Rate (%)</label>
                                            <input type="number" class="loan-form-input" id="interest-rate" min="1" max="30" step="0.1" value="5.5" required>
                                        </div>
                                        <div class="loan-form-group">
                                            <label for="loan-term" class="loan-form-label">Loan Term (Years)</label>
                                            <select class="loan-form-select" id="loan-term" required>
                                                <option value="1">1 Year</option>
                                                <option value="2">2 Years</option>
                                                <option value="3">3 Years</option>
                                                <option value="5">5 Years</option>
                                                <option value="10" selected>10 Years</option>
                                                <option value="15">15 Years</option>
                                                <option value="20">20 Years</option>
                                                <option value="30">30 Years</option>
                                            </select>
                                        </div>
                                        <button type="button" id="calculate-loan-btn" class="loan-btn loan-btn-primary loan-btn-block">Calculate</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid-item">
                            <div class="loan-card">
                                <div class="loan-card-header success">
                                    <span class="card-icon">📈</span> Calculation Results
                                </div>
                                <div class="loan-card-body">
                                    <div id="calculator-results" style="display: none;">
                                        <div class="results-grid">
                                            <div class="calculation-result">
                                                <div class="calculation-result-title">Monthly Payment</div>
                                                <div class="calculation-result-value" id="monthly-payment">$0.00</div>
                                            </div>
                                            <div class="calculation-result">
                                                <div class="calculation-result-title">Total Payment</div>
                                                <div class="calculation-result-value" id="total-payment">$0.00</div>
                                            </div>
                                            <div class="calculation-result">
                                                <div class="calculation-result-title">Total Interest</div>
                                                <div class="calculation-result-value" id="total-interest">$0.00</div>
                                            </div>
                                            <div class="calculation-result">
                                                <div class="calculation-result-title">Interest Percentage</div>
                                                <div class="calculation-result-value" id="interest-percentage">0%</div>
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        
                                        <h6>Payment Breakdown</h6>
                                        <div class="progress-container">
                                            <div id="principal-bar" class="progress-bar progress-bar-primary" style="width: 0%">
                                                Principal
                                            </div>
                                            <div id="interest-bar" class="progress-bar progress-bar-warning" style="width: 0%">
                                                Interest
                                            </div>
                                        </div>
                                        
                                        <div class="text-center mt-4">
                                            <a href="LoanApplication.php" class="loan-btn loan-btn-success loan-btn-block">Apply for This Loan</a>
                                        </div>
                                    </div>
                                    
                                    <div id="calculator-placeholder" class="placeholder-content">
                                        <div class="placeholder-icon">📊</div>
                                        <p class="placeholder-text">Enter loan details and click "Calculate" to see results</p>
                                    </div>
=======
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-hand-holding-usd me-2"></i>Loan Options</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($loanTypes as $loanType): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header">
                                                    <h5 class="mb-0"><?php echo htmlspecialchars($loanType['type_name']); ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <p><strong>Interest Rate:</strong> <?php echo $loanType['interest_rate_min']; ?>% - <?php echo $loanType['interest_rate_max']; ?>%</p>
                                                    <p><strong>Max Amount:</strong> $<?php echo number_format($loanType['max_amount'], 2); ?></p>
                                                    <p><strong>Processing Fee:</strong> <?php echo $loanType['processing_fee']; ?>%</p>
                                                    <p><?php echo htmlspecialchars($loanType['description']); ?></p>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="LoanApplication.php?loan_type=<?php echo $loanType['loan_type_id']; ?>" class="btn btn-primary">Apply Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <!-- Loan FAQ -->
                <div class="content-section">
                    <div class="loan-card">
                        <div class="loan-card-header secondary">
                            <span class="card-icon">❓</span> Frequently Asked Questions
                        </div>
                        <div class="loan-card-body">
                            <div class="faq-accordion" id="loanFaqAccordion">
                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-header active" data-target="faq1">
                                        What documents do I need to apply for a loan?
                                    </button>
                                    <div class="faq-accordion-body active" id="faq1">
                                        <div class="faq-accordion-body-inner">
                                            To apply for a loan, you'll typically need proof of identity (government-issued ID), proof of income (pay stubs, tax returns), proof of address (utility bills, lease agreement), and information about your existing debts and assets. Specific requirements may vary based on the loan type and amount.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-header" data-target="faq2">
                                        How long does the loan approval process take?
                                    </button>
                                    <div class="faq-accordion-body" id="faq2">
                                        <div class="faq-accordion-body-inner">
                                            The loan approval process typically takes 1-7 business days, depending on the loan type and amount. Personal loans may be approved within 1-3 business days, while home loans can take 30-45 days to process. Once approved, funds are usually disbursed within 24-48 hours.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-header" data-target="faq3">
                                        Can I pay off my loan early?
                                    </button>
                                    <div class="faq-accordion-body" id="faq3">
                                        <div class="faq-accordion-body-inner">
                                            Yes, you can pay off your loan early without any prepayment penalties. Early repayment can save you money on interest over the life of the loan. You can make extra payments toward the principal at any time or pay off the entire remaining balance in one lump sum.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-header" data-target="faq4">
                                        What factors affect my loan interest rate?
                                    </button>
                                    <div class="faq-accordion-body" id="faq4">
                                        <div class="faq-accordion-body-inner">
                                            Several factors affect your loan interest rate, including your credit score, income, debt-to-income ratio, loan amount, loan term, loan type, and current market conditions. A higher credit score and lower debt-to-income ratio typically result in lower interest rates.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-header" data-target="faq5">
                                        What happens if I miss a loan payment?
                                    </button>
                                    <div class="faq-accordion-body" id="faq5">
                                        <div class="faq-accordion-body-inner">
                                            If you miss a loan payment, you may be charged a late fee, and it could negatively impact your credit score. Multiple missed payments could result in default, which may lead to collection actions. If you anticipate difficulty making a payment, contact us immediately to discuss possible solutions.
=======
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Loan Calculator</h5>
                            </div>
                            <div class="card-body">
                                <form id="loan-calculator-form">
                                    <div class="mb-3">
                                        <label for="loan-amount" class="form-label">Loan Amount ($)</label>
                                        <input type="number" class="form-control" id="loan-amount" min="1000" step="1000" value="10000" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="interest-rate" class="form-label">Interest Rate (%)</label>
                                        <input type="number" class="form-control" id="interest-rate" min="1" max="30" step="0.1" value="5.5" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="loan-term" class="form-label">Loan Term (Years)</label>
                                        <select class="form-select" id="loan-term" required>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="5">5 Years</option>
                                            <option value="10" selected>10 Years</option>
                                            <option value="15">15 Years</option>
                                            <option value="20">20 Years</option>
                                            <option value="30">30 Years</option>
                                        </select>
                                    </div>
                                    <div class="d-grid">
                                        <button type="button" id="calculate-loan-btn" class="btn btn-primary">Calculate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Calculation Results</h5>
                            </div>
                            <div class="card-body">
                                <div id="calculator-results" class="d-none">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h6>Monthly Payment</h6>
                                            <h3 id="monthly-payment">$0.00</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Total Payment</h6>
                                            <h3 id="total-payment">$0.00</h3>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h6>Total Interest</h6>
                                            <h3 id="total-interest">$0.00</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Interest Percentage</h6>
                                            <h3 id="interest-percentage">0%</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <h6>Payment Breakdown</h6>
                                    <div class="progress mb-3" style="height: 25px;">
                                        <div id="principal-bar" class="progress-bar bg-primary" style="width: 0%">
                                            Principal
                                        </div>
                                        <div id="interest-bar" class="progress-bar bg-warning" style="width: 0%">
                                            Interest
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <a href="LoanApplication.php" class="btn btn-success">Apply for This Loan</a>
                                    </div>
                                </div>
                                <div id="calculator-placeholder" class="text-center py-5">
                                    <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                                    <p class="lead text-muted">Enter loan details and click "Calculate" to see results</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="fas fa-question-circle me-2"></i>Frequently Asked Questions</h5>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="loanFaqAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                What documents do I need to apply for a loan?
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                To apply for a loan, you'll typically need proof of identity (government-issued ID), proof of income (pay stubs, tax returns), proof of address (utility bills, lease agreement), and information about your existing debts and assets. Specific requirements may vary based on the loan type and amount.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                How long does the loan approval process take?
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                The loan approval process typically takes 1-7 business days, depending on the loan type and amount. Personal loans may be approved within 1-3 business days, while home loans can take 30-45 days to process. Once approved, funds are usually disbursed within 24-48 hours.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Can I pay off my loan early?
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                Yes, you can pay off your loan early without any prepayment penalties. Early repayment can save you money on interest over the life of the loan. You can make extra payments toward the principal at any time or pay off the entire remaining balance in one lump sum.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                What factors affect my loan interest rate?
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                Several factors affect your loan interest rate, including your credit score, income, debt-to-income ratio, loan amount, loan term, loan type, and current market conditions. A higher credit score and lower debt-to-income ratio typically result in lower interest rates.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFive">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                What happens if I miss a loan payment?
                                            </button>
                                        </h2>
                                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#loanFaqAccordion">
                                            <div class="accordion-body">
                                                If you miss a loan payment, you may be charged a late fee, and it could negatively impact your credit score. Multiple missed payments could result in default, which may lead to collection actions. If you anticipate difficulty making a payment, contact us immediately to discuss possible solutions.
                                            </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize user avatar
            const userAvatar = document.getElementById('userAvatar');
            const fullName = "<?php echo $fullName; ?>";
            if (userAvatar && fullName) {
                const nameParts = fullName.split(' ');
                let initials = '';
                if (nameParts.length >= 2) {
                    initials = nameParts[0].charAt(0) + nameParts[1].charAt(0);
                } else if (nameParts.length === 1) {
                    initials = nameParts[0].charAt(0);
                }
                userAvatar.textContent = initials.toUpperCase();
            }
            
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarToggle.classList.toggle('active');
                });
            }
            
            // User dropdown toggle
            const userDropdownBtn = document.getElementById('userDropdownBtn');
            const userDropdownMenu = document.getElementById('userDropdownMenu');
            if (userDropdownBtn && userDropdownMenu) {
                userDropdownBtn.addEventListener('click', function() {
                    userDropdownMenu.classList.toggle('show');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!userDropdownBtn.contains(event.target) && !userDropdownMenu.contains(event.target)) {
                        userDropdownMenu.classList.remove('show');
                    }
                });
            }
            
            // Dark mode toggle
            const darkModeToggle = document.getElementById('darkModeToggle');
            if (darkModeToggle) {
                // Check for saved dark mode preference
                const isDarkMode = localStorage.getItem('darkMode') === 'true';
                if (isDarkMode) {
                    document.body.classList.add('dark-mode');
                    darkModeToggle.classList.add('active');
                }
                
                darkModeToggle.addEventListener('click', function() {
                    document.body.classList.toggle('dark-mode');
                    darkModeToggle.classList.toggle('active');
                    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
                });
            }
            
            // Loan calculator functionality
            const calculateBtn = document.getElementById('calculate-loan-btn');
            const resultsDiv = document.getElementById('calculator-results');
            const placeholderDiv = document.getElementById('calculator-placeholder');
            
            if (calculateBtn && resultsDiv && placeholderDiv) {
                calculateBtn.addEventListener('click', function() {
                    const loanAmount = parseFloat(document.getElementById('loan-amount').value);
                    const interestRate = parseFloat(document.getElementById('interest-rate').value);
                    const loanTerm = parseInt(document.getElementById('loan-term').value);
                    
                    if (isNaN(loanAmount) || isNaN(interestRate) || isNaN(loanTerm)) {
                        alert('Please enter valid values for all fields');
                        return;
                    }
                    
                    const monthlyRate = interestRate / 100 / 12;
                    const totalPayments = loanTerm * 12;
                    const monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -totalPayments));
                    const totalPayment = monthlyPayment * totalPayments;
                    const totalInterest = totalPayment - loanAmount;
                    const interestPercentage = (totalInterest / loanAmount) * 100;
                    
                    document.getElementById('monthly-payment').textContent = '$' + monthlyPayment.toFixed(2);
                    document.getElementById('total-payment').textContent = '$' + totalPayment.toFixed(2);
                    document.getElementById('total-interest').textContent = '$' + totalInterest.toFixed(2);
                    document.getElementById('interest-percentage').textContent = interestPercentage.toFixed(1) + '%';
                    
                    const principalPercentage = (loanAmount / totalPayment) * 100;
                    const interestPercentage2 = (totalInterest / totalPayment) * 100;
                    
                    document.getElementById('principal-bar').style.width = principalPercentage + '%';
                    document.getElementById('principal-bar').textContent = 'Principal: ' + principalPercentage.toFixed(1) + '%';
                    document.getElementById('interest-bar').style.width = interestPercentage2 + '%';
                    document.getElementById('interest-bar').textContent = 'Interest: ' + interestPercentage2.toFixed(1) + '%';
                    
                    resultsDiv.style.display = 'block';
                    placeholderDiv.style.display = 'none';
                });
            }
            
            // FAQ Accordion functionality
            const faqHeaders = document.querySelectorAll('.faq-accordion-header');
            if (faqHeaders.length > 0) {
                faqHeaders.forEach(header => {
                    header.addEventListener('click', function() {
                        this.classList.toggle('active');
                        const target = this.getAttribute('data-target');
                        const body = document.getElementById(target);
                        
                        if (body) {
                            body.classList.toggle('active');
                            body.style.maxHeight = body.classList.contains('active') ? 
                                body.scrollHeight + 'px' : '0';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html> 
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calculateBtn = document.getElementById('calculate-loan-btn');
            const resultsDiv = document.getElementById('calculator-results');
            const placeholderDiv = document.getElementById('calculator-placeholder');
            calculateBtn.addEventListener('click', function() {
                const loanAmount = parseFloat(document.getElementById('loan-amount').value);
                const interestRate = parseFloat(document.getElementById('interest-rate').value);
                const loanTerm = parseInt(document.getElementById('loan-term').value);
                if (isNaN(loanAmount) || isNaN(interestRate) || isNaN(loanTerm)) {
                    alert('Please enter valid values for all fields');
                    return;
                }
                const monthlyRate = interestRate / 100 / 12;
                const totalPayments = loanTerm * 12;
                const monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -totalPayments));
                const totalPayment = monthlyPayment * totalPayments;
                const totalInterest = totalPayment - loanAmount;
                const interestPercentage = (totalInterest / loanAmount) * 100;
                document.getElementById('monthly-payment').textContent = '$' + monthlyPayment.toFixed(2);
                document.getElementById('total-payment').textContent = '$' + totalPayment.toFixed(2);
                document.getElementById('total-interest').textContent = '$' + totalInterest.toFixed(2);
                document.getElementById('interest-percentage').textContent = interestPercentage.toFixed(1) + '%';
                const principalPercentage = (loanAmount / totalPayment) * 100;
                const interestPercentage2 = (totalInterest / totalPayment) * 100;
                document.getElementById('principal-bar').style.width = principalPercentage + '%';
                document.getElementById('principal-bar').textContent = 'Principal: ' + principalPercentage.toFixed(1) + '%';
                document.getElementById('interest-bar').style.width = interestPercentage2 + '%';
                document.getElementById('interest-bar').textContent = 'Interest: ' + interestPercentage2.toFixed(1) + '%';
                resultsDiv.classList.remove('d-none');
                placeholderDiv.classList.add('d-none');
            });
        });
    </script>
</body>
</html>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

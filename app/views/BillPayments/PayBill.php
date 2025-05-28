<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../appInitializer.php';
if (!isLoggedIn()) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
require_once __DIR__ . '/../../controllers/AccountController.php';
$accountController = new AccountController();
$userId = $_SESSION['user_id'] ?? 0;
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$userRole = $_SESSION['role_name'] ?? 'Customer';
$accounts = $accountController->getUserAccounts($userId);
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_bill'])) {
    $billType = $_POST['bill_type'] ?? '';
    $billerId = $_POST['biller_id'] ?? '';
    $accountNumber = $_POST['account_number'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $sourceAccountId = $_POST['source_account_id'] ?? 0;
    if (empty($billType) || empty($billerId) || empty($accountNumber) || empty($amount) || empty($sourceAccountId)) {
        $message = 'Please fill in all required fields.';
        $messageType = 'danger';
    } else {
        $message = "Your payment of $" . number_format($amount, 2) . " to $billerId has been processed successfully. Reference #: BP" . rand(100000, 999999);
        $messageType = 'success';
    }
}
$savedBillers = [
    [
        'id' => 'ELEC001',
        'name' => 'City Power & Electric',
        'type' => 'utility',
        'account_number' => '87654321',
        'last_payment' => 125.45,
        'last_payment_date' => date('Y-m-d', strtotime('-1 month'))
    ],
    [
        'id' => 'WATER002',
        'name' => 'Municipal Water Services',
        'type' => 'utility',
        'account_number' => '12345678',
        'last_payment' => 78.90,
        'last_payment_date' => date('Y-m-d', strtotime('-1 month'))
    ],
    [
        'id' => 'CELL003',
        'name' => 'MobileNet Wireless',
        'type' => 'telecom',
        'account_number' => 'MN9876543',
        'last_payment' => 95.00,
        'last_payment_date' => date('Y-m-d', strtotime('-1 month'))
    ],
    [
        'id' => 'CABLE004',
        'name' => 'Global Cable & Internet',
        'type' => 'telecom',
        'account_number' => 'GC123456789',
        'last_payment' => 135.50,
        'last_payment_date' => date('Y-m-d', strtotime('-1 month'))
    ],
    [
        'id' => 'INS005',
        'name' => 'Secure Insurance Co.',
        'type' => 'insurance',
        'account_number' => 'POL987654321',
        'last_payment' => 210.75,
        'last_payment_date' => date('Y-m-d', strtotime('-1 month'))
    ]
];
$recentPayments = [
    [
        'id' => 'BP123456',
        'biller_name' => 'City Power & Electric',
        'amount' => 125.45,
        'payment_date' => date('Y-m-d', strtotime('-1 month')),
        'status' => 'Completed'
    ],
    [
        'id' => 'BP234567',
        'biller_name' => 'Municipal Water Services',
        'amount' => 78.90,
        'payment_date' => date('Y-m-d', strtotime('-1 month')),
        'status' => 'Completed'
    ],
    [
        'id' => 'BP345678',
        'biller_name' => 'MobileNet Wireless',
        'amount' => 95.00,
        'payment_date' => date('Y-m-d', strtotime('-1 month')),
        'status' => 'Completed'
    ],
    [
        'id' => 'BP456789',
        'biller_name' => 'Global Cable & Internet',
        'amount' => 135.50,
        'payment_date' => date('Y-m-d', strtotime('-1 month')),
        'status' => 'Completed'
    ],
    [
        'id' => 'BP567890',
        'biller_name' => 'Secure Insurance Co.',
        'amount' => 210.75,
        'payment_date' => date('Y-m-d', strtotime('-1 month')),
        'status' => 'Completed'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Payments - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Bill payment specific styles */
        .biller-item {
            border-radius: 8px;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-color);
            margin-bottom: 10px;
            padding: 15px;
            display: block;
            text-decoration: none;
            color: inherit;
        }
        
        .biller-item:hover {
            background-color: var(--hover-bg);
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .biller-item.utility {
            border-left-color: var(--primary-color);
        }
        
        .biller-item.telecom {
            border-left-color: var(--info-color);
        }
        
        .biller-item.insurance {
            border-left-color: var(--warning-color);
        }
        
        .payment-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .payment-table th,
        .payment-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .payment-table thead th {
            background-color: var(--card-bg);
            font-weight: 600;
            text-align: left;
        }
        
        .payment-table tbody tr:hover {
            background-color: var(--hover-bg);
        }
        
        .receipt-btn {
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
        
        .receipt-btn:hover {
            background-color: #0dcaf0;
            transform: translateY(-2px);
        }
        
        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: var(--primary-color);
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-badge.completed {
            background-color: rgba(var(--success-rgb), 0.2);
            color: var(--success-color);
        }
        
        .status-badge.pending {
            background-color: rgba(var(--warning-rgb), 0.2);
            color: var(--warning-color);
        }
        
        .status-badge.failed {
            background-color: rgba(var(--danger-rgb), 0.2);
            color: var(--danger-color);
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: auto;
            padding: 50px 0;
        }
        
        .modal.show {
            display: block;
        }
        
        .modal-dialog {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .modal-content {
            background-color: var(--body-bg);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .modal-header {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-footer {
            padding: 15px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .btn-close {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-color);
        }
        
        .receipt-success {
            font-size: 3rem;
            color: var(--success-color);
            margin-bottom: 15px;
        }
        
        .receipt-table {
            width: 100%;
        }
        
        .receipt-table th {
            text-align: left;
            padding: 8px 0;
            font-weight: 600;
        }
        
        .receipt-table td {
            padding: 8px 0;
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
                        <a class="nav-link" href="../FundTransfers/transfer.php">
                            <span class="nav-icon">↔️</span> Fund Transfers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../LoanManagement/LoanApplication.php">
                            <span class="nav-icon">💰</span> Loan Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">💸</span> Bill Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
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
                        <h1 class="h2 mb-0">Bill Payments</h1>
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
                
                <div class="d-flex justify-content-end mb-3">
                    <a href="ManageBillers.php" class="btn btn-outline-primary">
                        <span class="nav-icon">⚙️</span> Manage Billers
                    </a>
                </div>
                
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <span class="nav-icon me-2">
                            <?php echo $messageType === 'success' ? '✅' : '⚠️'; ?>
                        </span>
                        <?php echo $message; ?>
                    </div>
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">×</button>
                </div>
                <?php endif; ?>
                
                <div class="row">
                    <!-- Pay Bill Form -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">💸</span> Pay a Bill
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="PayBill.php">
                                    <div class="mb-3">
                                        <label for="bill_type" class="form-label">Bill Type</label>
                                        <select class="form-select" id="bill_type" name="bill_type" required>
                                            <option value="">-- Select Bill Type --</option>
                                            <option value="utility">Utility Bill</option>
                                            <option value="telecom">Telecom/Internet</option>
                                            <option value="credit_card">Credit Card</option>
                                            <option value="insurance">Insurance</option>
                                            <option value="tax">Tax Payment</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="biller_id" class="form-label">Select Biller</label>
                                        <select class="form-select" id="biller_id" name="biller_id">
                                            <option value="">-- Select Biller --</option>
                                            <?php foreach ($savedBillers as $biller): ?>
                                                <option value="<?php echo htmlspecialchars($biller['id']); ?>" data-type="<?php echo htmlspecialchars($biller['type']); ?>" data-account="<?php echo htmlspecialchars($biller['account_number']); ?>" data-amount="<?php echo htmlspecialchars($biller['last_payment']); ?>">
                                                    <?php echo htmlspecialchars($biller['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                            <option value="new">+ Add New Biller</option>
                                        </select>
                                    </div>
                                    <div id="new_biller_fields" class="d-none">
                                        <div class="mb-3">
                                            <label for="new_biller_name" class="form-label">Biller Name</label>
                                            <input type="text" class="form-control" id="new_biller_name" name="new_biller_name">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="account_number" class="form-label">Account/Reference Number</label>
                                        <input type="text" class="form-control" id="account_number" name="account_number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Amount ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="amount" name="amount" min="0.01" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="source_account_id" class="form-label">Pay From Account</label>
                                        <select class="form-select" id="source_account_id" name="source_account_id" required>
                                            <option value="">-- Select Account --</option>
                                            <?php foreach ($accounts as $account): ?>
                                                <option value="<?php echo $account['account_id']; ?>">
                                                    <?php echo htmlspecialchars($account['account_type'] . ' - ' . $account['account_number'] . ' ($' . number_format($account['balance'], 2) . ')'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="payment_date" class="form-label">Payment Date</label>
                                        <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                                        <div class="form-text">
                                            <span class="nav-icon me-1">ℹ️</span> Select today for immediate payment or a future date to schedule
                                        </div>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="save_biller" name="save_biller" checked>
                                        <label class="form-check-label" for="save_biller">Save this biller for future payments</label>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="pay_bill" class="btn btn-primary">
                                            <span class="nav-icon me-2">📤</span> Pay Bill
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Saved Billers -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <span class="nav-icon me-2">📋</span> Saved Billers
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($savedBillers)): ?>
                                    <div class="biller-list">
                                        <?php foreach ($savedBillers as $biller): ?>
                                            <a href="#" class="biller-item <?php echo htmlspecialchars($biller['type']); ?> select-biller" 
                                               data-id="<?php echo htmlspecialchars($biller['id']); ?>"
                                               data-name="<?php echo htmlspecialchars($biller['name']); ?>"
                                               data-type="<?php echo htmlspecialchars($biller['type']); ?>"
                                               data-account="<?php echo htmlspecialchars($biller['account_number']); ?>"
                                               data-amount="<?php echo htmlspecialchars($biller['last_payment']); ?>">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($biller['name']); ?></h6>
                                                    <small class="text-muted">Last paid: <?php echo date('M d, Y', strtotime($biller['last_payment_date'])); ?></small>
                                                </div>
                                                <p class="mb-1">Account: <?php echo htmlspecialchars($biller['account_number']); ?></p>
                                                <small class="text-muted">Last amount: $<?php echo number_format($biller['last_payment'], 2); ?></small>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <span class="nav-icon me-2">ℹ️</span> You don't have any saved billers yet.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Payments -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 d-flex align-items-center">
                            <span class="nav-icon me-2">🕒</span> Recent Payments
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recentPayments)): ?>
                            <div class="table-responsive">
                                <table class="payment-table">
                                    <thead>
                                        <tr>
                                            <th>Reference #</th>
                                            <th>Biller</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentPayments as $payment): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($payment['id']); ?></td>
                                                <td><?php echo htmlspecialchars($payment['biller_name']); ?></td>
                                                <td>$<?php echo number_format($payment['amount'], 2); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($payment['payment_date'])); ?></td>
                                                <td>
                                                    <span class="status-badge completed"><?php echo htmlspecialchars($payment['status']); ?></span>
                                                </td>
                                                <td>
                                                    <button class="receipt-btn" onclick="showReceipt('<?php echo htmlspecialchars($payment['id']); ?>', '<?php echo htmlspecialchars($payment['biller_name']); ?>', '<?php echo number_format($payment['amount'], 2); ?>', '<?php echo date('M d, Y', strtotime($payment['payment_date'])); ?>')">
                                                        <span class="nav-icon">🧾</span> Receipt
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <span class="nav-icon me-2">ℹ️</span> You don't have any recent bill payments.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Scheduled Payments -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 d-flex align-items-center">
                            <span class="nav-icon me-2">📅</span> Scheduled Payments
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <span class="nav-icon me-2">ℹ️</span> You don't have any scheduled payments.
                        </div>
                        <div class="text-center mt-3">
                            <a href="SchedulePayment.php" class="btn btn-primary">
                                <span class="nav-icon me-2">➕</span> Schedule a Payment
                            </a>
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
    
    <!-- Receipt Modal -->
    <div class="modal" id="receiptModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Receipt</h5>
                    <button type="button" class="btn-close" onclick="closeModal()">×</button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="receipt-success">✅</div>
                        <h4 class="mt-3">Payment Successful</h4>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="receipt-table">
                                <tr>
                                    <th>Reference Number:</th>
                                    <td id="receipt_id">BP123456</td>
                                </tr>
                                <tr>
                                    <th>Biller:</th>
                                    <td id="receipt_biller">City Power & Electric</td>
                                </tr>
                                <tr>
                                    <th>Amount:</th>
                                    <td id="receipt_amount">$125.45</td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td id="receipt_date"><?php echo date('M d, Y', strtotime('-1 month')); ?></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td><span class="status-badge completed">Completed</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary">
                        <span class="nav-icon me-1">📥</span> Download Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../../public/js/custom-design.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alert dismissal
            const alerts = document.querySelectorAll('.alert .btn-close');
            alerts.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.alert').style.display = 'none';
                });
            });
            
            // Biller selection logic
            const billerSelect = document.getElementById('biller_id');
            const billTypeSelect = document.getElementById('bill_type');
            const accountNumberInput = document.getElementById('account_number');
            const amountInput = document.getElementById('amount');
            const newBillerFields = document.getElementById('new_biller_fields');
            
            if (billerSelect) {
                billerSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (this.value === 'new') {
                        newBillerFields.classList.remove('d-none');
                        accountNumberInput.value = '';
                        amountInput.value = '';
                    } else {
                        newBillerFields.classList.add('d-none');
                        if (this.value !== '') {
                            const billType = selectedOption.getAttribute('data-type');
                            const accountNumber = selectedOption.getAttribute('data-account');
                            const lastAmount = selectedOption.getAttribute('data-amount');
                            billTypeSelect.value = billType;
                            accountNumberInput.value = accountNumber;
                            amountInput.value = lastAmount;
                        }
                    }
                });
            }
            
            // Saved biller selection
            const savedBillers = document.querySelectorAll('.select-biller');
            savedBillers.forEach(biller => {
                biller.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    const account = this.getAttribute('data-account');
                    const amount = this.getAttribute('data-amount');
                    billTypeSelect.value = type;
                    billerSelect.value = id;
                    accountNumberInput.value = account;
                    amountInput.value = amount;
                    document.querySelector('.card-header.bg-primary').scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
        
        // Modal functions
        function showReceipt(id, biller, amount, date) {
            document.getElementById('receipt_id').textContent = id;
            document.getElementById('receipt_biller').textContent = biller;
            document.getElementById('receipt_amount').textContent = '$' + amount;
            document.getElementById('receipt_date').textContent = date;
            document.getElementById('receiptModal').classList.add('show');
        }
        
        function closeModal() {
            document.getElementById('receiptModal').classList.remove('show');
        }
        
        // Validate bill payment
        function validateBillPayment() {
            const amount = document.getElementById('amount').value;
            const sourceAccount = document.getElementById('source_account_id').value;
            if (!amount || !sourceAccount) {
                alert('Please fill in all required fields.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html> 
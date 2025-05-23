<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../bootstrap.php';
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
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../FundTransfers/transfer.php">
                                <i class="fas fa-exchange-alt me-2"></i> Fund Transfers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../LoanManagement/LoanApplication.php">
                                <i class="fas fa-hand-holding-usd me-2"></i> Loan Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
                                <i class="fas fa-file-invoice-dollar me-2"></i> Bill Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../notifications/notificationCenter.php">
                                <i class="fas fa-bell me-2"></i> Notifications
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
                    <h1 class="h2">Bill Payments</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="ManageBillers.php" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-cog me-1"></i> Manage Billers
                            </a>
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
                                <h5 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i>Pay a Bill</h5>
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
                                        <input type="number" class="form-control" id="amount" name="amount" min="0.01" step="0.01" required>
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
                                            <i class="fas fa-info-circle me-1"></i> Select today for immediate payment or a future date to schedule
                                        </div>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="save_biller" name="save_biller" checked>
                                        <label class="form-check-label" for="save_biller">Save this biller for future payments</label>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="pay_bill" class="btn btn-primary" onclick="return validateBillPayment()">
                                            <i class="fas fa-paper-plane me-2"></i>Pay Bill
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-bookmark me-2"></i>Saved Billers</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($savedBillers)): ?>
                                    <div class="list-group">
                                        <?php foreach ($savedBillers as $biller): ?>
                                            <a href="#" class="list-group-item list-group-item-action select-biller" 
                                               data-id="<?php echo htmlspecialchars($biller['id']); ?>"
                                               data-name="<?php echo htmlspecialchars($biller['name']); ?>"
                                               data-type="<?php echo htmlspecialchars($biller['type']); ?>"
                                               data-account="<?php echo htmlspecialchars($biller['account_number']); ?>"
                                               data-amount="<?php echo htmlspecialchars($biller['last_payment']); ?>">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($biller['name']); ?></h6>
                                                    <small class="text-muted">Last paid: <?php echo date('M d, Y', strtotime($biller['last_payment_date'])); ?></small>
                                                </div>
                                                <p class="mb-1">Account: <?php echo htmlspecialchars($biller['account_number']); ?></p>
                                                <small class="text-muted">Last amount: $<?php echo number_format($biller['last_payment'], 2); ?></small>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i> You don't have any saved billers yet.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Payments</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recentPayments)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
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
                                                    <span class="badge bg-success"><?php echo htmlspecialchars($payment['status']); ?></span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#receiptModal" data-id="<?php echo htmlspecialchars($payment['id']); ?>">
                                                        <i class="fas fa-receipt me-1"></i> Receipt
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> You don't have any recent bill payments.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Scheduled Payments</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> You don't have any scheduled payments.
                        </div>
                        <div class="text-center mt-3">
                            <a href="SchedulePayment.php" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Schedule a Payment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Payment Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle text-success fa-4x"></i>
                        <h4 class="mt-3">Payment Successful</h4>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-borderless">
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
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Download Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/js/loanAndBillPayment.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            const receiptModal = document.getElementById('receiptModal');
            if (receiptModal) {
                receiptModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    document.getElementById('receipt_id').textContent = id;
                });
            }
        });
    </script>
</body>
</html>

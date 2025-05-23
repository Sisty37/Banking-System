<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../bootstrap.php';
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
$loanApplications = $loanController->getUserLoanApplications($userId);
$activeLoans = $loanController->getActiveLoans($userId);
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['make_payment'])) {
    $loanId = $_POST['loan_id'] ?? 0;
    $amount = $_POST['amount'] ?? 0;
    $accountId = $_POST['account_id'] ?? 0;
    $result = $loanController->makeLoanPayment($loanId, $userId, $accountId, $amount);
    if ($result['success']) {
        $message = $result['message'];
        $messageType = 'success';
        $activeLoans = $loanController->getActiveLoans($userId);
    } else {
        $message = $result['message'];
        $messageType = 'danger';
    }
}
$loanStats = $loanController->getLoanStatistics($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Status - Banking System</title>
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
                    <h1 class="h2">Loan Status</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="LoanApplication.php" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i> Apply for Loan
                        </a>
                    </div>
                </div>
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-money-check-alt me-2"></i>Active Loans</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($activeLoans) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Loan ID</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Balance</th>
                                            <th>Interest Rate</th>
                                            <th>Monthly Payment</th>
                                            <th>Next Payment</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($activeLoans as $loan): ?>
                                            <tr>
                                                <td><?php echo $loan['loan_id']; ?></td>
                                                <td><?php echo htmlspecialchars($loan['type_name']); ?></td>
                                                <td>$<?php echo number_format($loan['loan_amount'], 2); ?></td>
                                                <td>$<?php echo number_format($loan['remaining_balance'], 2); ?></td>
                                                <td><?php echo $loan['interest_rate']; ?>%</td>
                                                <td>$<?php echo number_format($loan['monthly_payment'], 2); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($loan['next_payment_date'])); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal<?php echo $loan['loan_id']; ?>">
                                                        <i class="fas fa-money-bill-wave"></i> Pay
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo $loan['loan_id']; ?>">
                                                        <i class="fas fa-info-circle"></i> Details
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="paymentModal<?php echo $loan['loan_id']; ?>" tabindex="-1" aria-labelledby="paymentModalLabel<?php echo $loan['loan_id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="paymentModalLabel<?php echo $loan['loan_id']; ?>">Make Loan Payment</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" action="LoanStatus.php">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="loan_id" value="<?php echo $loan['loan_id']; ?>">
                                                                <div class="mb-3">
                                                                    <label for="amount" class="form-label">Payment Amount ($)</label>
                                                                    <input type="number" class="form-control" id="amount" name="amount" min="1" step="0.01" value="<?php echo $loan['monthly_payment']; ?>" required>
                                                                    <div class="form-text">Monthly payment amount: $<?php echo number_format($loan['monthly_payment'], 2); ?></div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="account_id" class="form-label">From Account</label>
                                                                    <select class="form-select" id="account_id" name="account_id" required>
                                                                        <?php 
                                                                        require_once __DIR__ . '/../../controllers/AccountController.php';
                                                                        $accountController = new AccountController();
                                                                        $accounts = $accountController->getUserAccounts($userId);
                                                                        foreach ($accounts as $account): 
                                                                        ?>
                                                                            <option value="<?php echo $account['account_id']; ?>">
                                                                                <?php echo htmlspecialchars($account['account_type'] . ' - ' . $account['account_number'] . ' ($' . number_format($account['balance'], 2) . ')'); ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" name="make_payment" class="btn btn-primary">Make Payment</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="detailsModal<?php echo $loan['loan_id']; ?>" tabindex="-1" aria-labelledby="detailsModalLabel<?php echo $loan['loan_id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailsModalLabel<?php echo $loan['loan_id']; ?>">Loan Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><strong>Loan ID:</strong> <?php echo $loan['loan_id']; ?></p>
                                                                    <p><strong>Loan Type:</strong> <?php echo htmlspecialchars($loan['type_name']); ?></p>
                                                                    <p><strong>Principal Amount:</strong> $<?php echo number_format($loan['loan_amount'], 2); ?></p>
                                                                    <p><strong>Interest Rate:</strong> <?php echo $loan['interest_rate']; ?>%</p>
                                                                    <p><strong>Loan Term:</strong> <?php echo $loan['loan_term']; ?> years</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Remaining Balance:</strong> $<?php echo number_format($loan['remaining_balance'], 2); ?></p>
                                                                    <p><strong>Monthly Payment:</strong> $<?php echo number_format($loan['monthly_payment'], 2); ?></p>
                                                                    <p><strong>Start Date:</strong> <?php echo date('M d, Y', strtotime($loan['start_date'])); ?></p>
                                                                    <p><strong>End Date:</strong> <?php echo date('M d, Y', strtotime($loan['end_date'])); ?></p>
                                                                    <p><strong>Next Payment:</strong> <?php echo date('M d, Y', strtotime($loan['next_payment_date'])); ?></p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <h6>Payment History</h6>
                                                            <?php 
                                                            $paymentHistory = $loanController->getLoanPaymentHistory($loan['loan_id']);
                                                            if (count($paymentHistory) > 0): 
                                                            ?>
                                                                <div class="table-responsive">
                                                                    <table class="table table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>Amount</th>
                                                                                <th>Principal</th>
                                                                                <th>Interest</th>
                                                                                <th>Remaining Balance</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($paymentHistory as $payment): ?>
                                                                                <tr>
                                                                                    <td><?php echo date('M d, Y', strtotime($payment['payment_date'])); ?></td>
                                                                                    <td>$<?php echo number_format($payment['amount'], 2); ?></td>
                                                                                    <td>$<?php echo number_format($payment['principal_amount'], 2); ?></td>
                                                                                    <td>$<?php echo number_format($payment['interest_amount'], 2); ?></td>
                                                                                    <td>$<?php echo number_format($payment['remaining_balance'], 2); ?></td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            <?php else: ?>
                                                                <p class="text-muted">No payment history available.</p>
                                                            <?php endif; ?>
                                                            <hr>
                                                            <h6>Amortization Schedule</h6>
                                                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                                                <table class="table table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Date</th>
                                                                            <th>Payment</th>
                                                                            <th>Principal</th>
                                                                            <th>Interest</th>
                                                                            <th>Balance</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        $schedule = $loanController->getAmortizationSchedule(
                                                                            $loan['loan_amount'], 
                                                                            $loan['interest_rate'], 
                                                                            $loan['loan_term'],
                                                                            $loan['start_date']
                                                                        );
                                                                        foreach ($schedule as $index => $payment): 
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $index + 1; ?></td>
                                                                                <td><?php echo date('M d, Y', strtotime($payment['date'])); ?></td>
                                                                                <td>$<?php echo number_format($payment['payment'], 2); ?></td>
                                                                                <td>$<?php echo number_format($payment['principal'], 2); ?></td>
                                                                                <td>$<?php echo number_format($payment['interest'], 2); ?></td>
                                                                                <td>$<?php echo number_format($payment['balance'], 2); ?></td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> You don't have any active loans.
                                <a href="LoanApplication.php" class="alert-link">Apply for a loan</a> to get started.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Loan Applications</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($loanApplications) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Reference</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Term</th>
                                            <th>Status</th>
                                            <th>Applied Date</th>
                                            <th>Last Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($loanApplications as $application): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($application['reference_number']); ?></td>
                                                <td><?php echo htmlspecialchars($application['type_name']); ?></td>
                                                <td>$<?php echo number_format($application['loan_amount'], 2); ?></td>
                                                <td><?php echo $application['loan_term']; ?> years</td>
                                                <td>
                                                    <?php 
                                                    $statusClass = '';
                                                    switch ($application['status']) {
                                                        case 'Pending':
                                                            $statusClass = 'bg-warning text-dark';
                                                            break;
                                                        case 'Approved':
                                                            $statusClass = 'bg-success';
                                                            break;
                                                        case 'Rejected':
                                                            $statusClass = 'bg-danger';
                                                            break;
                                                        case 'Under Review':
                                                            $statusClass = 'bg-info';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $statusClass; ?>">
                                                        <?php echo htmlspecialchars($application['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M d, Y', strtotime($application['application_date'])); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($application['last_updated'])); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> You don't have any loan applications.
                                <a href="LoanApplication.php" class="alert-link">Apply for a loan</a> to get started.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

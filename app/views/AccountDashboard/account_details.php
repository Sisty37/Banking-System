<?php
session_start();
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (!isset($_SESSION['user_id'])) {
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
$selectedAccountId = isset($_GET['account_id']) ? $_GET['account_id'] : null;
if (!$selectedAccountId && !empty($accounts)) {
    $selectedAccountId = $accounts[0]['account_id'];
}
=======

$accounts = $accountController->getUserAccounts($userId);

$selectedAccountId = isset($_GET['account_id']) ? $_GET['account_id'] : null;

if (!$selectedAccountId && !empty($accounts)) {
    $selectedAccountId = $accounts[0]['account_id'];
}

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
$accountDetails = null;
$recentTransactions = [];
if ($selectedAccountId) {
    $accountDetails = $accountController->getAccountDetails($selectedAccountId);
    $recentTransactions = $accountController->getRecentTransactions($selectedAccountId, 10);
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
    <title>Account Details - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
<<<<<<< HEAD
    <!-- Add Bootstrap CSS -->
    <link href="https:
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https:
    <!-- Add DataTables CSS -->
    <link rel="stylesheet" href="https:
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
</head>
<body>
    <div class="container-fluid">
        <div class="row">
<<<<<<< HEAD
            <!-- Sidebar -->
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
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
<<<<<<< HEAD
            <!-- Main content -->
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Account Details</h1>
                    <div>
                        <span class="badge bg-primary"><?php echo htmlspecialchars($role); ?></span>
                        <span class="ms-2">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
<<<<<<< HEAD
                <!-- Account Selection -->
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Select Account</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php if (!empty($accounts)): ?>
                                        <?php foreach ($accounts as $account): ?>
                                            <div class="col-md-4 mb-3">
                                                <div class="card <?php echo ($selectedAccountId == $account['account_id']) ? 'border-primary' : ''; ?>">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo htmlspecialchars($account['account_type']); ?> Account</h5>
                                                        <h6 class="card-subtitle mb-2 text-muted">Account #: <?php echo htmlspecialchars($account['account_number']); ?></h6>
                                                        <p class="card-text">Balance: <?php echo $accountController->formatCurrency($account['balance']); ?></p>
                                                        <a href="?account_id=<?php echo $account['account_id']; ?>" class="btn btn-sm <?php echo ($selectedAccountId == $account['account_id']) ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                                            <?php echo ($selectedAccountId == $account['account_id']) ? 'Selected' : 'Select'; ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                You don't have any accounts yet. Please contact customer service.
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                <?php if ($accountDetails): ?>
                <!-- Account Details -->
=======

                <?php if ($accountDetails): ?>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Account Information</h5>
                                <div>
                                    <?php echo $accountController->getAccountStatusBadge($accountDetails['is_active']); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tr>
                                                <th>Account Number:</th>
                                                <td><?php echo htmlspecialchars($accountDetails['account_number']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Account Type:</th>
                                                <td><?php echo htmlspecialchars($accountDetails['account_type']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Account Holder:</th>
                                                <td><?php echo htmlspecialchars($accountDetails['first_name'] . ' ' . $accountDetails['last_name']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td><?php echo htmlspecialchars($accountDetails['email']); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6 class="card-subtitle mb-2 text-muted">Current Balance</h6>
                                                <h2 class="card-title text-primary"><?php echo $accountController->formatCurrency($accountDetails['balance']); ?></h2>
                                                <p class="card-text">As of <?php echo date('F j, Y, g:i a'); ?></p>
                                                <div class="mt-3">
                                                    <a href="../FundTransfers/TransferWizerd.php?from_account=<?php echo $accountDetails['account_id']; ?>" class="btn btn-primary me-2">
                                                        <i class="fas fa-paper-plane"></i> Transfer Funds
                                                    </a>
                                                    <a href="#" class="btn btn-outline-secondary">
                                                        <i class="fas fa-file-alt"></i> Statement
                                                    </a>
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
                <!-- Recent Transactions -->
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Transactions</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="transactionsTable" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($recentTransactions)): ?>
                                                <?php foreach ($recentTransactions as $transaction): ?>
                                                    <tr>
                                                        <td><?php echo $accountController->formatDate($transaction['transaction_date']); ?></td>
                                                        <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                                                        <td><?php echo $accountController->getTransactionTypeBadge($transaction['transaction_type']); ?></td>
                                                        <td>
                                                            <?php
                                                            $amountClass = '';
                                                            if (strtolower($transaction['transaction_type']) == 'deposit') {
                                                                $amountClass = 'text-success';
                                                                $amountPrefix = '+';
                                                            } elseif (strtolower($transaction['transaction_type']) == 'withdrawal' || strtolower($transaction['transaction_type']) == 'payment') {
                                                                $amountClass = 'text-danger';
                                                                $amountPrefix = '-';
                                                            } else {
                                                                $amountPrefix = '';
                                                            }
                                                            ?>
                                                            <span class="<?php echo $amountClass; ?>">
                                                                <?php echo $amountPrefix . $accountController->formatCurrency($transaction['amount']); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo $accountController->formatCurrency($transaction['balance_after']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No recent transactions</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https:
    <!-- jQuery -->
    <script src="https:
    <!-- DataTables JS -->
    <script src="https:
    <script src="https:
=======

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    <script>
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                "order": [[0, "desc"]],
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50],
                "language": {
                    "emptyTable": "No transactions available"
                }
            });
        });
    </script>
</body>
<<<<<<< HEAD
</html> 
=======
</html> 
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

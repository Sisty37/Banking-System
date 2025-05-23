<?php
require_once __DIR__ . '/../../bootstrap.php';

if (!isLoggedIn()) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}

require_once __DIR__ . '/../../controllers/AccountController.php';
$accountController = new AccountController();

$userId = $_SESSION['user_id'];
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$role = $_SESSION['role'] ?? 'Customer';

$accounts = $accountController->getUserAccounts($userId);

$totalBalance = 0;
$savingsBalance = 0;
$checkingBalance = 0;

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Overview - Banking System</title>
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
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Savings</h5>
                                <h2 class="display-6"><?php echo $accountController->formatCurrency($savingsBalance); ?></h2>
                                <p class="card-text">Total savings balance</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-info text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Checking</h5>
                                <h2 class="display-6"><?php echo $accountController->formatCurrency($checkingBalance); ?></h2>
                                <p class="card-text">Total checking balance</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-center gap-3">
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
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Your Accounts</h5>
                                <?php if ($accountController->hasAccountManagementPermission()): ?>
                                <a href="create_account.php" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> Create Account
                                </a>
                                <?php else: ?>
                                <a href="#" class="btn btn-sm btn-outline-primary">Open New Account</a>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($accounts)): ?>
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
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        You don't have any accounts yet. Please contact customer service to open an account.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Financial Tips</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">Emergency Fund</h5>
                                                <p class="card-text">Aim to save 3-6 months of expenses in an emergency fund for unexpected costs.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">Savings Goal</h5>
                                                <p class="card-text">Set up automatic transfers to your savings account to reach your financial goals faster.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">Budget Planning</h5>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

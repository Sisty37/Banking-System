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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Links</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <a href="../AccountDashboard/dd.php" class="text-decoration-none">
                                            <div class="card text-center bg-primary text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-money-check-alt fa-3x mb-3"></i>
                                                    <h5 class="card-title">View Accounts</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="../FundTransfers/TransferWizerd.php" class="text-decoration-none">
                                            <div class="card text-center bg-success text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-exchange-alt fa-3x mb-3"></i>
                                                    <h5 class="card-title">Transfer Funds</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="../BillPayments/PayBill.php" class="text-decoration-none">
                                            <div class="card text-center bg-info text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                                                    <h5 class="card-title">Pay Bills</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="../LoanManagement/LoanApplication.php" class="text-decoration-none">
                                            <div class="card text-center bg-warning text-white">
                                                <div class="card-body">
                                                    <i class="fas fa-hand-holding-usd fa-3x mb-3"></i>
                                                    <h5 class="card-title">Apply for Loan</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Account Summary</h5>
                                <a href="../AccountDashboard/dd.php" class="btn btn-sm btn-primary">View All Accounts</a>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($accounts)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
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
                                                        <td><?php echo $accountController->getAccountStatusBadge($account['is_active']); ?></td>
                                                        <td>
                                                            <a href="../AccountDashboard/account_details.php?account_id=<?php echo $account['account_id']; ?>" class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i> Details
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        You don't have any accounts yet. Please contact customer service.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Balance Overview</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="balanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

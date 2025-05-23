<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../controllers/AdminController.php';
if (!isLoggedIn() || !hasRole('Administrator')) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$adminController = new AdminController();
$period = isset($_GET['period']) ? $_GET['period'] : 'monthly';
if (!in_array($period, ['daily', 'weekly', 'monthly', 'yearly'])) {
    $period = 'monthly';
}
$transactionStats = $adminController->getTransactionStats($period);
$userGrowthStats = $adminController->getUserGrowthStats($period);
$accountTypeDistribution = $adminController->getAccountTypeDistribution();
$systemOverview = $adminController->getSystemOverview();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Analytics - Banking System</title>
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
                            <a class="nav-link text-white" href="admin_dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../AccountDashboard/dd.php">
                                <i class="fas fa-money-check-alt me-2"></i> Account Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="user_management.php">
                                <i class="fas fa-users me-2"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../RoleBasedAccess/PermissionSettings.php">
                                <i class="fas fa-user-shield me-2"></i> Roles & Permissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="transaction_log.php">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Log
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
                                <i class="fas fa-chart-line me-2"></i> System Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-cogs me-2"></i> System Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../notifications/notificationCenter.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../DataExport/exportWizard.php">
                                <i class="fas fa-file-export me-2"></i> Data Export
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
                    <h1 class="h2">System Analytics</h1>
                    <div>
                        <span class="badge bg-danger">Administrator</span>
                        <span class="ms-2">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Analytics Period</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="system_analytics.php" class="row">
                            <div class="col-md-8">
                                <div class="btn-group" role="group">
                                    <a href="?period=daily" class="btn btn<?php echo $period === 'daily' ? '-primary' : '-outline-primary'; ?>">Daily</a>
                                    <a href="?period=weekly" class="btn btn<?php echo $period === 'weekly' ? '-primary' : '-outline-primary'; ?>">Weekly</a>
                                    <a href="?period=monthly" class="btn btn<?php echo $period === 'monthly' ? '-primary' : '-outline-primary'; ?>">Monthly</a>
                                    <a href="?period=yearly" class="btn btn<?php echo $period === 'yearly' ? '-primary' : '-outline-primary'; ?>">Yearly</a>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button type="button" class="btn btn-outline-secondary" id="printBtn">
                                    <i class="fas fa-print me-1"></i> Print Report
                                </button>
                                <div class="btn-group ms-2">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-download me-1"></i> Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">PDF</a></li>
                                        <li><a class="dropdown-item" href="#">Excel</a></li>
                                        <li><a class="dropdown-item" href="#">CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Key Metrics</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-primary text-white h-100">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['total_users']; ?></h1>
                                                <p class="card-text">Total Users</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-success text-white h-100">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['total_accounts']; ?></h1>
                                                <p class="card-text">Active Accounts</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-info text-white h-100">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['transactions_today']; ?></h1>
                                                <p class="card-text">Today's Transactions</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-warning text-white h-100">
                                            <div class="card-body text-center">
                                                <h1 class="display-4"><?php echo $systemOverview['new_users_today']; ?></h1>
                                                <p class="card-text">New Users Today</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Transaction Trends</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="transactionTrendsChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Transaction Volumes</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="transactionVolumeChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Transaction Types</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="transactionTypeChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">User Growth</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="userGrowthChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Account Distribution</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="accountDistributionChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Detailed Transaction Data</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th>Total Transactions</th>
                                        <th>Deposits</th>
                                        <th>Withdrawals</th>
                                        <th>Transfers</th>
                                        <th>Payments</th>
                                        <th>Total Volume</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactionStats as $stat): ?>
                                        <?php
                                            $totalVolume = $stat['deposit_amount'] + $stat['withdrawal_amount'] + $stat['transfer_amount'] + $stat['payment_amount'];
                                            $formattedPeriod = $adminController->formatPeriodLabel($stat['period'], $period);
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($formattedPeriod); ?></td>
                                            <td><?php echo number_format($stat['total_count']); ?></td>
                                            <td><?php echo number_format($stat['deposits']); ?></td>
                                            <td><?php echo number_format($stat['withdrawals']); ?></td>
                                            <td><?php echo number_format($stat['transfers']); ?></td>
                                            <td><?php echo number_format($stat['payments']); ?></td>
                                            <td><?php echo $adminController->formatCurrency($totalVolume); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Segoe UI', 'Helvetica Neue', 'Arial', sans-serif";
            Chart.defaults.font.size = 12;
            Chart.defaults.color = '#666';
            const transactionTrendsCtx = document.getElementById('transactionTrendsChart').getContext('2d');
            <?php
            $periods = [];
            $depositCounts = [];
            $withdrawalCounts = [];
            $transferCounts = [];
            $paymentCounts = [];
            foreach ($transactionStats as $stat) {
                $periods[] = $adminController->formatPeriodLabel($stat['period'], $period);
                $depositCounts[] = $stat['deposits'];
                $withdrawalCounts[] = $stat['withdrawals'];
                $transferCounts[] = $stat['transfers'];
                $paymentCounts[] = $stat['payments'];
            }
            ?>
            const transactionTrendsChart = new Chart(transactionTrendsCtx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($periods); ?>,
                    datasets: [
                        {
                            label: 'Deposits',
                            data: <?php echo json_encode($depositCounts); ?>,
                            borderColor: '#36a2eb',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            tension: 0.1,
                            fill: true
                        },
                        {
                            label: 'Withdrawals',
                            data: <?php echo json_encode($withdrawalCounts); ?>,
                            borderColor: '#ff6384',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            tension: 0.1,
                            fill: true
                        },
                        {
                            label: 'Transfers',
                            data: <?php echo json_encode($transferCounts); ?>,
                            borderColor: '#4bc0c0',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.1,
                            fill: true
                        },
                        {
                            label: 'Payments',
                            data: <?php echo json_encode($paymentCounts); ?>,
                            borderColor: '#ffcd56',
                            backgroundColor: 'rgba(255, 205, 86, 0.2)',
                            tension: 0.1,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Transaction Count Trends'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        },
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Transactions'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Period'
                            }
                        }
                    }
                }
            });
            const transactionVolumeCtx = document.getElementById('transactionVolumeChart').getContext('2d');
            <?php
            $depositAmounts = [];
            $withdrawalAmounts = [];
            $transferAmounts = [];
            $paymentAmounts = [];
            foreach ($transactionStats as $stat) {
                $depositAmounts[] = $stat['deposit_amount'];
                $withdrawalAmounts[] = $stat['withdrawal_amount'];
                $transferAmounts[] = $stat['transfer_amount'];
                $paymentAmounts[] = $stat['payment_amount'];
            }
            ?>
            const transactionVolumeChart = new Chart(transactionVolumeCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($periods); ?>,
                    datasets: [
                        {
                            label: 'Deposits',
                            data: <?php echo json_encode($depositAmounts); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        },
                        {
                            label: 'Withdrawals',
                            data: <?php echo json_encode($withdrawalAmounts); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        },
                        {
                            label: 'Transfers',
                            data: <?php echo json_encode($transferAmounts); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        },
                        {
                            label: 'Payments',
                            data: <?php echo json_encode($paymentAmounts); ?>,
                            backgroundColor: 'rgba(255, 205, 86, 0.7)',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Transaction Volume by Type'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-US', {
                                            style: 'currency',
                                            currency: 'USD'
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount ($)'
                            },
                            ticks: {
                                callback: function(value, index, values) {
                                    return new Intl.NumberFormat('en-US', {
                                        style: 'currency',
                                        currency: 'USD',
                                        minimumFractionDigits: 0
                                    }).format(value);
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Period'
                            }
                        }
                    }
                }
            });
            const transactionTypeCtx = document.getElementById('transactionTypeChart').getContext('2d');
            <?php
            $totalDeposits = array_sum($depositCounts);
            $totalWithdrawals = array_sum($withdrawalCounts);
            $totalTransfers = array_sum($transferCounts);
            $totalPayments = array_sum($paymentCounts);
            ?>
            const transactionTypeChart = new Chart(transactionTypeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Deposits', 'Withdrawals', 'Transfers', 'Payments'],
                    datasets: [{
                        data: [
                            <?php echo $totalDeposits; ?>,
                            <?php echo $totalWithdrawals; ?>,
                            <?php echo $totalTransfers; ?>,
                            <?php echo $totalPayments; ?>
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 205, 86, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Transaction Type Distribution'
                        },
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const dataset = tooltipItem.dataset;
                                    const total = dataset.data.reduce((acc, data) => acc + data, 0);
                                    const currentValue = dataset.data[tooltipItem.dataIndex];
                                    const percentage = Math.round((currentValue / total) * 100);
                                    return `${tooltipItem.label}: ${currentValue} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            <?php
            $userPeriods = [];
            $newUsers = [];
            $cumulativeUsers = [];
            $cumulativeCount = 0;
            foreach ($userGrowthStats as $stat) {
                $userPeriods[] = $adminController->formatPeriodLabel($stat['period'], $period);
                $newUsers[] = $stat['new_users'];
                $cumulativeCount += $stat['new_users'];
                $cumulativeUsers[] = $cumulativeCount;
            }
            ?>
            const userGrowthChart = new Chart(userGrowthCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($userPeriods); ?>,
                    datasets: [
                        {
                            label: 'New Users',
                            data: <?php echo json_encode($newUsers); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            order: 2
                        },
                        {
                            label: 'Cumulative Users',
                            data: <?php echo json_encode($cumulativeUsers); ?>,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            type: 'line',
                            order: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'User Growth Trend'
                        },
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Users'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Period'
                            }
                        }
                    }
                }
            });
            const accountDistributionCtx = document.getElementById('accountDistributionChart').getContext('2d');
            <?php
            $accountTypes = [];
            $accountCounts = [];
            $accountBalances = [];
            foreach ($accountTypeDistribution as $distribution) {
                $accountTypes[] = $distribution['account_type'];
                $accountCounts[] = $distribution['count'];
                $accountBalances[] = $distribution['total_balance'];
            }
            ?>
            const accountDistributionChart = new Chart(accountDistributionCtx, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($accountTypes); ?>,
                    datasets: [{
                        data: <?php echo json_encode($accountCounts); ?>,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 205, 86, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Account Type Distribution'
                        },
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const dataset = tooltipItem.dataset;
                                    const total = dataset.data.reduce((acc, data) => acc + data, 0);
                                    const currentValue = dataset.data[tooltipItem.dataIndex];
                                    const percentage = Math.round((currentValue / total) * 100);
                                    return `${tooltipItem.label}: ${currentValue} accounts (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            document.getElementById('printBtn').addEventListener('click', function() {
                window.print();
            });
        });
    </script>
</body>
</html>

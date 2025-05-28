<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../appInitializer.php';
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
    <!-- Bootstrap CSS -->
    <link href="https:
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https:
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../../public/css/style.css">
    <style>
        .loan-form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        /* Details grid layout */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .details-column p {
            margin-bottom: 10px;
            color: var(--text-color);
        }
        
        .details-column strong {
            font-weight: 600;
        }
        
        .text-muted {
            color: var(--text-secondary);
        }
        
        hr {
            border: 0;
            border-top: 1px solid var(--border-color);
            margin: 20px 0;
        }
        
        h6 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--text-color);
        }
    </style>
</head>
<body class="bg-light">
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
                        <a class="nav-link active" href="LoanManagement.php">
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
                    <h1>Loan Status</h1>
                    <div class="header-actions">
                        <a href="LoanApplication.php" class="loan-btn loan-btn-primary">
                            <span>➕</span> Apply for Loan
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
                
                <?php if ($message): ?>
                    <div class="loan-alert <?php echo $messageType; ?>" id="alertMessage">
                        <?php echo $message; ?>
                        <button type="button" class="loan-alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                    </div>
                <?php endif; ?>
                
                <!-- Loan Statistics -->
                <div class="loan-stats-grid">
                    <div class="loan-stat-card primary">
                        <div class="loan-stat-title">Total Loans</div>
                        <div class="loan-stat-value"><?php echo $loanStats['total_loans']; ?></div>
                    </div>
                    
                    <div class="loan-stat-card success">
                        <div class="loan-stat-title">Active Loans</div>
                        <div class="loan-stat-value"><?php echo $loanStats['active_loans']; ?></div>
                    </div>
                    
                    <div class="loan-stat-card info">
                        <div class="loan-stat-title">Total Borrowed</div>
                        <div class="loan-stat-value">$<?php echo number_format($loanStats['total_borrowed'], 2); ?></div>
                    </div>
                    
                    <div class="loan-stat-card warning">
                        <div class="loan-stat-title">Outstanding Balance</div>
                        <div class="loan-stat-value">$<?php echo number_format($loanStats['outstanding_balance'], 2); ?></div>
                    </div>
                </div>
                <!-- Active Loans -->
                <div class="loan-status-card">
                    <div class="loan-status-card-header success">
                        <span class="card-icon">💰</span> Active Loans
                    </div>
                    <div class="loan-status-card-body">
                        <?php if (count($activeLoans) > 0): ?>
                            <div class="loan-table-responsive">
                                <table class="loan-table">
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
                                                    <button type="button" class="loan-btn loan-btn-primary loan-btn-sm" onclick="openModal('paymentModal<?php echo $loan['loan_id']; ?>')">
                                                        <span>💵</span> Pay
                                                    </button>
                                                    <button type="button" class="loan-btn loan-btn-info loan-btn-sm" onclick="openModal('detailsModal<?php echo $loan['loan_id']; ?>')">
                                                        <span>ℹ️</span> Details
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="loan-alert info">
                                <span>ℹ️</span> You don't have any active loans.
                                <a href="LoanApplication.php" class="loan-alert-link">Apply for a loan</a> to get started.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Loan Applications -->
                <div class="loan-status-card">
                    <div class="loan-status-card-header primary">
                        <span class="card-icon">📝</span> Loan Applications
                    </div>
                    <div class="loan-status-card-body">
                        <?php if (count($loanApplications) > 0): ?>
                            <div class="loan-table-responsive">
                                <table class="loan-table">
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
                                                            $statusClass = 'pending';
                                                            break;
                                                        case 'Approved':
                                                            $statusClass = 'approved';
                                                            break;
                                                        case 'Rejected':
                                                            $statusClass = 'rejected';
                                                            break;
                                                        case 'Under Review':
                                                            $statusClass = 'review';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="loan-status-badge <?php echo $statusClass; ?>">
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
                            <div class="loan-alert info">
                                <span>ℹ️</span> You don't have any loan applications.
                                <a href="LoanApplication.php" class="loan-alert-link">Apply for a loan</a> to get started.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https:
    <!-- Payment Modal Templates -->
    <?php foreach ($activeLoans as $loan): ?>
    <!-- Payment Modal -->
    <div id="paymentModal<?php echo $loan['loan_id']; ?>" class="loan-modal">
        <div class="loan-modal-dialog">
            <div class="loan-modal-content">
                <div class="loan-modal-header">
                    <h5 class="loan-modal-title">Make Loan Payment</h5>
                    <button type="button" class="loan-modal-close" onclick="closeModal('paymentModal<?php echo $loan['loan_id']; ?>')">&times;</button>
                </div>
                <form method="POST" action="LoanStatus.php">
                    <div class="loan-modal-body">
                        <input type="hidden" name="loan_id" value="<?php echo $loan['loan_id']; ?>">
                        <div class="loan-form-group">
                            <label for="amount" class="loan-form-label">Payment Amount ($)</label>
                            <input type="number" class="loan-form-input" id="amount" name="amount" min="1" step="0.01" value="<?php echo $loan['monthly_payment']; ?>" required>
                            <div class="loan-form-text">Monthly payment amount: $<?php echo number_format($loan['monthly_payment'], 2); ?></div>
                        </div>
                        <div class="loan-form-group">
                            <label for="account_id" class="loan-form-label">From Account</label>
                            <select class="loan-form-select" id="account_id" name="account_id" required>
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
                    <div class="loan-modal-footer">
                        <button type="button" class="loan-btn loan-btn-secondary" onclick="closeModal('paymentModal<?php echo $loan['loan_id']; ?>')">Cancel</button>
                        <button type="submit" name="make_payment" class="loan-btn loan-btn-primary">Make Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <!-- Loan Details Modal Templates -->
    <?php foreach ($activeLoans as $loan): ?>
    <!-- Details Modal -->
    <div id="detailsModal<?php echo $loan['loan_id']; ?>" class="loan-modal">
        <div class="loan-modal-dialog modal-lg">
            <div class="loan-modal-content">
                <div class="loan-modal-header">
                    <h5 class="loan-modal-title">Loan Details</h5>
                    <button type="button" class="loan-modal-close" onclick="closeModal('detailsModal<?php echo $loan['loan_id']; ?>')">&times;</button>
                </div>
                <div class="loan-modal-body">
                    <div class="details-grid">
                        <div class="details-column">
                            <p><strong>Loan ID:</strong> <?php echo $loan['loan_id']; ?></p>
                            <p><strong>Loan Type:</strong> <?php echo htmlspecialchars($loan['type_name']); ?></p>
                            <p><strong>Principal Amount:</strong> $<?php echo number_format($loan['loan_amount'], 2); ?></p>
                            <p><strong>Interest Rate:</strong> <?php echo $loan['interest_rate']; ?>%</p>
                            <p><strong>Loan Term:</strong> <?php echo $loan['loan_term']; ?> years</p>
                        </div>
                        <div class="details-column">
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
                        <div class="loan-table-responsive">
                            <table class="loan-table">
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
                    <div class="loan-table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="loan-table">
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
                <div class="loan-modal-footer">
                    <button type="button" class="loan-btn loan-btn-secondary" onclick="closeModal('detailsModal<?php echo $loan['loan_id']; ?>')">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
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
            
            // Auto-dismiss alert after 5 seconds
            const alertMessage = document.getElementById('alertMessage');
            if (alertMessage) {
                setTimeout(function() {
                    alertMessage.style.display = 'none';
                }, 5000);
            }
        });
        
        // Modal functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        }
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('loan-modal')) {
                closeModal(event.target.id);
            }
        });
    </script>
</body>
</html> 
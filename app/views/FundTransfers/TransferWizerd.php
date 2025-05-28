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
$selectedFromAccountId = isset($_GET['from_account']) ? $_GET['from_account'] : null;
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fromAccountId = $_POST['from_account'] ?? '';
    $transferType = $_POST['transfer_type'] ?? '';
    $toAccountId = $_POST['to_account'] ?? '';
    $toAccountNumber = $_POST['to_account_number'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $description = $_POST['description'] ?? 'Fund Transfer';
    if (empty($fromAccountId) || empty($amount) || $amount <= 0) {
        $message = "Please select a source account and enter a valid amount.";
        $messageType = "danger";
    } else if ($transferType === 'own' && empty($toAccountId)) {
        $message = "Please select a destination account.";
        $messageType = "danger";
    } else if ($transferType === 'other' && empty($toAccountNumber)) {
        $message = "Please enter a valid destination account number.";
        $messageType = "danger";
    } else {
        if ($transferType === 'own') {
            $result = $accountController->transferBetweenAccounts($fromAccountId, $toAccountId, $amount, $description);
        } else {
            $result = $accountController->transferToExternalAccount($fromAccountId, $toAccountNumber, $amount, $description);
        }
        if ($result['success']) {
            $message = $result['message'];
            $messageType = "success";
        } else {
            $message = $result['message'];
            $messageType = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fund Transfer - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Transfer Wizard specific styles */
        .transfer-card {
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
        }
        
        .transfer-card-header {
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
        
        .transfer-card-body {
            padding: 25px;
        }
        
        .step-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--text-color);
            display: flex;
            align-items: center;
        }
        
        .account-card {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            margin-bottom: 15px;
            transition: var(--transition);
            cursor: pointer;
            background-color: var(--card-bg);
        }
        
        .account-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .account-card.selected {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 1px var(--primary-color);
        }
        
        .account-card-body {
            padding: 15px;
            display: flex;
            align-items: center;
        }
        
        .account-radio {
            margin-right: 15px;
        }
        
        .account-info {
            flex: 1;
        }
        
        .account-type {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-color);
        }
        
        .account-number, .account-balance {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 3px;
        }
        
        .transfer-form-group {
            margin-bottom: 20px;
        }
        
        .transfer-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        .transfer-form-input {
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .transfer-form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        .transfer-radio-group {
            margin-bottom: 15px;
        }
        
        .transfer-radio-label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            cursor: pointer;
            color: var(--text-color);
        }
        
        .transfer-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            margin-top: 20px;
        }
        
        .transfer-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .transfer-btn:hover {
            opacity: 0.9;
        }
        
        .amount-input-group {
            display: flex;
            align-items: center;
        }
        
        .amount-input-prefix {
            padding: 10px 15px;
            background-color: var(--border-color);
            border: 1px solid var(--border-color);
            border-right: none;
            border-top-left-radius: var(--border-radius);
            border-bottom-left-radius: var(--border-radius);
            color: var(--text-color);
        }
        
        .amount-input {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        
        .recent-transfers {
            margin-top: 30px;
        }
        
        .transfer-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .transfer-table th, .transfer-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .transfer-table th {
            font-weight: 600;
            color: var(--text-color);
            background-color: var(--table-header-bg);
        }
        
        .transfer-table tbody tr:hover {
            background-color: var(--hover-color);
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-badge-success {
            background-color: rgba(var(--success-color-rgb), 0.2);
            color: var(--success-color);
        }
        
        .view-all-link {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border: 1px solid var(--primary-color);
            border-radius: var(--border-radius);
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.85rem;
            transition: var(--transition);
        }
        
        .view-all-link:hover {
            background-color: var(--primary-color);
            color: white;
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
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">💸</span> Fund Transfers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="BeneficiaryManager.php">
                            <span class="nav-icon">👥</span> Beneficiary Manager
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ScheduleTool.php">
                            <span class="nav-icon">🗓️</span> Schedule Transfer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/PayBill.php">
                            <span class="nav-icon">📄</span> Pay Bills
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
            
            <!-- Main content -->
            <div class="main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-primary me-3 d-md-none toggle-sidebar">
                            <span class="nav-icon">☰</span>
                        </button>
                        <h1 class="h2 mb-0">Fund Transfer</h1>
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
                
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <!-- Transfer Form Card -->
                        <div class="transfer-card mb-4">
                            <div class="transfer-card-header">
                                <span class="nav-icon me-2">💸</span> Transfer Funds
                            </div>
                            <div class="transfer-card-body">
                                <form method="post" action="" id="transferForm">
                                    <!-- Step 1: Select source account -->
                                    <div class="mb-4">
                                        <h6 class="step-title"><span class="nav-icon me-2">1️⃣</span> Select Source Account</h6>
                                        <div class="row">
                                            <?php if (!empty($accounts)): ?>
                                                <?php foreach ($accounts as $account): ?>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="account-card <?php echo ($selectedFromAccountId == $account['account_id']) ? 'selected' : ''; ?>" 
                                                             onclick="document.getElementById('account<?php echo $account['account_id']; ?>').checked = true;">
                                                            <div class="account-card-body">
                                                                <div class="account-radio">
                                                                    <input type="radio" name="from_account" 
                                                                        id="account<?php echo $account['account_id']; ?>" 
                                                                        value="<?php echo $account['account_id']; ?>"
                                                                        <?php echo ($selectedFromAccountId == $account['account_id']) ? 'checked' : ''; ?>>
                                                                </div>
                                                                <div class="account-info">
                                                                    <div class="account-type"><?php echo htmlspecialchars($account['account_type']); ?> Account</div>
                                                                    <div class="account-number">Account #: <?php echo htmlspecialchars($account['account_number']); ?></div>
                                                                    <div class="account-balance">Available Balance: <?php echo $accountController->formatCurrency($account['balance']); ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="col-12">
                                                    <div class="alert alert-info">
                                                        You don't have any accounts. Please contact customer service to open an account.
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- Step 2: Select transfer type -->
                                    <div class="mb-4">
                                        <h6 class="step-title"><span class="nav-icon me-2">2️⃣</span> Select Transfer Type</h6>
                                        <div class="transfer-radio-group">
                                            <label class="transfer-radio-label">
                                                <input type="radio" name="transfer_type" value="own" checked> 
                                                <span class="ms-2">Transfer between my accounts</span>
                                            </label>
                                            <label class="transfer-radio-label">
                                                <input type="radio" name="transfer_type" value="other"> 
                                                <span class="ms-2">Transfer to another account</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Step 3: Select destination (changes based on transfer type) -->
                                    <div class="mb-4">
                                        <h6 class="step-title"><span class="nav-icon me-2">3️⃣</span> Select Destination</h6>
                                        <!-- Own accounts selection (shown when transferTypeOwn is selected) -->
                                        <div id="ownAccountsSection">
                                            <div class="row">
                                                <?php if (count($accounts) > 1): ?>
                                                    <?php foreach ($accounts as $account): ?>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="account-card destination-account" data-account-id="<?php echo $account['account_id']; ?>"
                                                                 onclick="document.getElementById('toAccount<?php echo $account['account_id']; ?>').checked = true;">
                                                                <div class="account-card-body">
                                                                    <div class="account-radio">
                                                                        <input type="radio" name="to_account" class="to-account"
                                                                            id="toAccount<?php echo $account['account_id']; ?>" 
                                                                            value="<?php echo $account['account_id']; ?>">
                                                                    </div>
                                                                    <div class="account-info">
                                                                        <div class="account-type"><?php echo htmlspecialchars($account['account_type']); ?> Account</div>
                                                                        <div class="account-number">Account #: <?php echo htmlspecialchars($account['account_number']); ?></div>
                                                                        <div class="account-balance">Current Balance: <?php echo $accountController->formatCurrency($account['balance']); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="col-12">
                                                        <div class="alert alert-info">
                                                            You need at least two accounts to transfer between your own accounts.
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <!-- External account input (shown when transferTypeOther is selected) -->
                                        <div id="externalAccountSection" style="display: none;">
                                            <div class="transfer-form-group">
                                                <label for="toAccountNumber" class="transfer-form-label">Recipient Account Number</label>
                                                <input type="text" class="transfer-form-input" id="toAccountNumber" name="to_account_number" placeholder="Enter 10-digit account number">
                                            </div>
                                            <div class="transfer-form-group">
                                                <label for="recipientName" class="transfer-form-label">Recipient Name (Optional)</label>
                                                <input type="text" class="transfer-form-input" id="recipientName" name="recipient_name" placeholder="Enter recipient's name">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Step 4: Enter amount and description -->
                                    <div class="mb-4">
                                        <h6 class="step-title"><span class="nav-icon me-2">4️⃣</span> Enter Amount and Details</h6>
                                        <div class="transfer-form-group">
                                            <label for="amount" class="transfer-form-label">Amount</label>
                                            <div class="amount-input-group">
                                                <span class="amount-input-prefix">$</span>
                                                <input type="number" class="transfer-form-input amount-input" id="amount" name="amount" step="0.01" min="0.01" required>
                                            </div>
                                        </div>
                                        <div class="transfer-form-group">
                                            <label for="description" class="transfer-form-label">Description (Optional)</label>
                                            <input type="text" class="transfer-form-input" id="description" name="description" placeholder="Enter transfer description">
                                        </div>
                                    </div>
                                    <button type="submit" class="transfer-btn transfer-btn-primary">
                                        <span class="nav-icon me-2">📤</span> Transfer Funds
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Recent Transfers -->
                        <div class="transfer-card recent-transfers">
                            <div class="transfer-card-header d-flex justify-content-between align-items-center">
                                <div><span class="nav-icon me-2">📝</span> Recent Transfers</div>
                                <a href="#" class="view-all-link">View All</a>
                            </div>
                            <div class="transfer-card-body">
                                <div class="table-responsive">
                                    <table class="transfer-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>2023-05-15</td>
                                                <td>Checking Account (****1234)</td>
                                                <td>Savings Account (****5678)</td>
                                                <td>$500.00</td>
                                                <td><span class="status-badge status-badge-success">Completed</span></td>
                                            </tr>
                                            <tr>
                                                <td>2023-05-10</td>
                                                <td>Savings Account (****5678)</td>
                                                <td>John Doe (****9012)</td>
                                                <td>$250.00</td>
                                                <td><span class="status-badge status-badge-success">Completed</span></td>
                                            </tr>
                                            <tr>
                                                <td>2023-05-05</td>
                                                <td>Checking Account (****1234)</td>
                                                <td>Jane Smith (****3456)</td>
                                                <td>$100.00</td>
                                                <td><span class="status-badge status-badge-success">Completed</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
    
    <script src="../../../public/js/custom-design.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize user avatar with initials
            const userAvatars = document.querySelectorAll('.user-avatar');
            userAvatars.forEach(avatar => {
                const name = avatar.getAttribute('data-name');
                if (name) {
                    const nameParts = name.split(' ');
                    let initials = '';
                    if (nameParts.length >= 2) {
                        initials = nameParts[0].charAt(0) + nameParts[1].charAt(0);
                    } else if (nameParts.length === 1) {
                        initials = nameParts[0].charAt(0);
                    }
                    avatar.innerText = initials.toUpperCase();
                }
            });
            
            // Mobile sidebar toggle
            const sidebarToggle = document.querySelector('.toggle-sidebar');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.toggle('show-sidebar');
                });
            }
            
            // Alert dismissal
            const alertCloseButton = document.querySelector('.alert .btn-close');
            if (alertCloseButton) {
                alertCloseButton.addEventListener('click', function() {
                    this.parentElement.style.display = 'none';
                });
            }
            
            // Transfer type toggle
            const transferTypeRadios = document.querySelectorAll('input[name="transfer_type"]');
            transferTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'own') {
                        document.getElementById('ownAccountsSection').style.display = 'block';
                        document.getElementById('externalAccountSection').style.display = 'none';
                    } else {
                        document.getElementById('ownAccountsSection').style.display = 'none';
                        document.getElementById('externalAccountSection').style.display = 'block';
                    }
                });
            });
            
            // Account selection
            const sourceAccounts = document.querySelectorAll('input[name="from_account"]');
            sourceAccounts.forEach(radio => {
                radio.addEventListener('change', function() {
                    const selectedAccountId = this.value;
                    
                    // Enable all destination accounts
                    document.querySelectorAll('.destination-account').forEach(card => {
                        card.classList.remove('disabled');
                        const accountId = card.getAttribute('data-account-id');
                        const radioInput = document.getElementById('toAccount' + accountId);
                        if (radioInput) {
                            radioInput.disabled = false;
                        }
                    });
                    
                    // Disable the selected source account in destination options
                    const selectedDestinationCard = document.querySelector(`.destination-account[data-account-id="${selectedAccountId}"]`);
                    if (selectedDestinationCard) {
                        selectedDestinationCard.classList.add('disabled');
                        const radioInput = document.getElementById('toAccount' + selectedAccountId);
                        if (radioInput) {
                            radioInput.disabled = true;
                            if (radioInput.checked) {
                                radioInput.checked = false;
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>

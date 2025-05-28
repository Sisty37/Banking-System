<?php
session_start();
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'Administrator' && $_SESSION['role'] !== 'Manager')) {
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
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$role = $_SESSION['role'] ?? '';
<<<<<<< HEAD
$users = $accountController->getAllUsers();
$accountTypes = $accountController->getAccountTypes();
$message = '';
$messageType = '';
=======

$users = $accountController->getAllUsers();
$accountTypes = $accountController->getAccountTypes();

$message = '';
$messageType = '';

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? '';
    $accountType = $_POST['account_type'] ?? '';
    $initialBalance = floatval($_POST['initial_balance'] ?? 0);
<<<<<<< HEAD
=======
    
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    if (empty($userId) || empty($accountType)) {
        $message = "Please select a user and account type.";
        $messageType = "danger";
    } else {
        $result = $accountController->createAccount($userId, $accountType, $initialBalance);
<<<<<<< HEAD
=======
        
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        if ($result['success']) {
            $message = $result['message'] . " Account number: " . $result['account_number'];
            $messageType = "success";
        } else {
            $message = $result['message'];
            $messageType = "danger";
        }
    }
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
    <title>Create Account - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Custom select styling to replace Select2 */
        .custom-select {
            position: relative;
            width: 100%;
        }
        
        .custom-select select {
            width: 100%;
            padding: 12px 15px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg fill='gray' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px;
        }
        
        .custom-select select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.25);
            outline: 0;
        }
        
        /* Account type badges */
        .account-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
        }
        
        .account-badge.savings {
            background-color: var(--primary-color);
        }
        
        .account-badge.checking {
            background-color: var(--success-color);
        }
        
        .account-badge.money-market {
            background-color: var(--info-color);
        }
        
        .account-badge.cd {
            background-color: var(--warning-color);
        }
        
        .account-badge.ira {
            background-color: var(--secondary-color);
        }
    </style>
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
</head>
<body>
    <div class="container-fluid">
        <div class="row">
<<<<<<< HEAD
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-header">
                    <h4 class="text-white">Banking System</h4>
                    <p class="text-white-50">Administration Portal</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/admin_dashboard.php">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">💳</span> Account Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/user_management.php">
                            <span class="nav-icon">👥</span> User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../RoleBasedAccess/PermissionSettings.php">
                            <span class="nav-icon">🔒</span> Roles & Permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-icon">↔️</span> Transaction Log
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
                        <h1 class="h2 mb-0">Create Bank Account</h1>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="user-dropdown">
                        <div class="user-info">
                            <div class="user-avatar" data-name="<?php echo htmlspecialchars($fullName); ?>"></div>
                            <div class="d-none d-md-block">
                                <div class="fw-bold"><?php echo htmlspecialchars($fullName); ?></div>
                                <div class="small text-muted"><?php echo htmlspecialchars($role); ?></div>
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
                
=======
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/admin_dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
                                <i class="fas fa-money-check-alt me-2"></i> Account Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/user_management.php">
                                <i class="fas fa-users me-2"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../RoleBasedAccess/PermissionSettings.php">
                                <i class="fas fa-user-shield me-2"></i> Roles & Permissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Log
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
                    <h1 class="h2">Create Bank Account</h1>
                    <div>
                        <span class="badge bg-danger"><?php echo htmlspecialchars($role); ?></span>
                        <span class="ms-2">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
<<<<<<< HEAD
                
=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Create New Bank Account</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="">
                                    <div class="row mb-3">
<<<<<<< HEAD
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label for="user_id" class="form-label">Select User</label>
                                            <div class="custom-select">
                                                <select class="form-select" id="user_id" name="user_id" required>
                                                    <option value="">-- Select User --</option>
                                                    <?php foreach ($users as $user): ?>
                                                        <option value="<?php echo $user['user_id']; ?>">
                                                            <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'] . ' (' . $user['email'] . ')'); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="account_type" class="form-label">Account Type</label>
                                            <div class="custom-select">
                                                <select class="form-select" id="account_type" name="account_type" required>
                                                    <option value="">-- Select Account Type --</option>
                                                    <?php foreach ($accountTypes as $value => $label): ?>
                                                        <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
=======
                                        <div class="col-md-6">
                                            <label for="user_id" class="form-label">Select User</label>
                                            <select class="form-select select2" id="user_id" name="user_id" required>
                                                <option value="">-- Select User --</option>
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?php echo $user['user_id']; ?>">
                                                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'] . ' (' . $user['email'] . ')'); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="account_type" class="form-label">Account Type</label>
                                            <select class="form-select" id="account_type" name="account_type" required>
                                                <option value="">-- Select Account Type --</option>
                                                <?php foreach ($accountTypes as $value => $label): ?>
                                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                                <?php endforeach; ?>
                                            </select>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="initial_balance" class="form-label">Initial Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="initial_balance" name="initial_balance" step="0.01" min="0" value="0.00">
                                        </div>
                                        <div class="form-text">Optional: Set an initial deposit amount for this account.</div>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
<<<<<<< HEAD
                                            <span class="nav-icon">➕</span> Create Account
=======
                                            <i class="fas fa-plus-circle me-2"></i> Create Account
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Account Management Instructions</h5>
                                <span class="badge bg-info">Guide</span>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h5 class="d-flex align-items-center">
                                        <span class="nav-icon">ℹ️</span> Important Information
                                    </h5>
=======
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Account Management Instructions</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h5><i class="fas fa-info-circle me-2"></i> Important Information</h5>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    <p>When creating a new bank account:</p>
                                    <ul>
                                        <li>Each account will be assigned a unique 10-digit account number automatically.</li>
                                        <li>The account will be created with an "Active" status by default.</li>
                                        <li>If you specify an initial balance, a deposit transaction will be created automatically.</li>
                                        <li>The user will be able to see their new account immediately in their dashboard.</li>
                                    </ul>
                                </div>
<<<<<<< HEAD
                                
                                <div class="mt-4">
                                    <h5 class="mb-3">Available Account Types</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Account Type</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span class="account-badge savings">Savings Account</span></td>
                                                    <td>A basic interest-bearing account for saving money.</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="account-badge checking">Checking Account</span></td>
                                                    <td>A transactional account for day-to-day expenses.</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="account-badge money-market">Money Market Account</span></td>
                                                    <td>A high-interest account with limited check-writing privileges.</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="account-badge cd">Certificate of Deposit (CD)</span></td>
                                                    <td>A time deposit account with a fixed term and interest rate.</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="account-badge ira">Individual Retirement Account (IRA)</span></td>
                                                    <td>A tax-advantaged retirement savings account.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
=======
                                <div class="mt-4">
                                    <h5>Available Account Types</h5>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Account Type</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Savings Account</td>
                                                <td>A basic interest-bearing account for saving money.</td>
                                            </tr>
                                            <tr>
                                                <td>Checking Account</td>
                                                <td>A transactional account for day-to-day expenses.</td>
                                            </tr>
                                            <tr>
                                                <td>Money Market Account</td>
                                                <td>A high-interest account with limited check-writing privileges.</td>
                                            </tr>
                                            <tr>
                                                <td>Certificate of Deposit (CD)</td>
                                                <td>A time deposit account with a fixed term and interest rate.</td>
                                            </tr>
                                            <tr>
                                                <td>Individual Retirement Account (IRA)</td>
                                                <td>A tax-advantaged retirement savings account.</td>
                                            </tr>
                                        </tbody>
                                    </table>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    
    <!-- Dark Mode Toggle -->
    <div class="dark-mode-toggle" data-tooltip="Toggle Dark Mode">
        <span class="nav-icon">🌙</span>
    </div>
    
    <!-- Custom JavaScript without external dependencies -->
    <script src="../../../public/js/custom-design.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Custom dropdown for close button functionality
            document.querySelectorAll('.alert .btn-close').forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('.alert').style.display = 'none';
                });
            });

            // Additional page-specific JavaScript can be added here
            document.querySelectorAll('select').forEach(function(select) {
                select.addEventListener('change', function() {
                    if (this.value) {
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                    }
                });
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "Select a user",
                allowClear: true
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            });
        });
    </script>
</body>
<<<<<<< HEAD
</html> 
=======
</html>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

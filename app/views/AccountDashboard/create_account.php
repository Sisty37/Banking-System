<?php
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'Administrator' && $_SESSION['role'] !== 'Manager')) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}

require_once __DIR__ . '/../../controllers/AccountController.php';
$accountController = new AccountController();

$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$role = $_SESSION['role'] ?? '';

$users = $accountController->getAllUsers();
$accountTypes = $accountController->getAccountTypes();

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? '';
    $accountType = $_POST['account_type'] ?? '';
    $initialBalance = floatval($_POST['initial_balance'] ?? 0);
    
    if (empty($userId) || empty($accountType)) {
        $message = "Please select a user and account type.";
        $messageType = "danger";
    } else {
        $result = $accountController->createAccount($userId, $accountType, $initialBalance);
        
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
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
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Create New Bank Account</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="">
                                    <div class="row mb-3">
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
                                            <i class="fas fa-plus-circle me-2"></i> Create Account
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Account Management Instructions</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h5><i class="fas fa-info-circle me-2"></i> Important Information</h5>
                                    <p>When creating a new bank account:</p>
                                    <ul>
                                        <li>Each account will be assigned a unique 10-digit account number automatically.</li>
                                        <li>The account will be created with an "Active" status by default.</li>
                                        <li>If you specify an initial balance, a deposit transaction will be created automatically.</li>
                                        <li>The user will be able to see their new account immediately in their dashboard.</li>
                                    </ul>
                                </div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "Select a user",
                allowClear: true
            });
        });
    </script>
</body>
</html>

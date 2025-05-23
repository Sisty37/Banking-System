<?php
session_start();

if (!isset($_SESSION['user_id'])) {
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
                            <a class="nav-link text-white" href="../AccountDashboard/dd.php">
                                <i class="fas fa-money-check-alt me-2"></i> My Accounts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
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
                    <h1 class="h2">Fund Transfer</h1>
                    <div>
                        <span class="badge bg-primary"><?php echo htmlspecialchars($role); ?></span>
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
                                <h5 class="mb-0">Transfer Funds</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="" id="transferForm">
                                    <div class="mb-4">
                                        <h6 class="fw-bold">Step 1: Select Source Account</h6>
                                        <div class="row">
                                            <?php if (!empty($accounts)): ?>
                                                <?php foreach ($accounts as $account): ?>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card <?php echo ($selectedFromAccountId == $account['account_id']) ? 'border-primary' : ''; ?>">
                                                            <div class="card-body">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="from_account" 
                                                                        id="account<?php echo $account['account_id']; ?>" 
                                                                        value="<?php echo $account['account_id']; ?>"
                                                                        <?php echo ($selectedFromAccountId == $account['account_id']) ? 'checked' : ''; ?>>
                                                                    <label class="form-check-label" for="account<?php echo $account['account_id']; ?>">
                                                                        <div>
                                                                            <strong><?php echo htmlspecialchars($account['account_type']); ?> Account</strong>
                                                                            <p class="mb-0">Account #: <?php echo htmlspecialchars($account['account_number']); ?></p>
                                                                            <p class="mb-0">Available Balance: <?php echo $accountController->formatCurrency($account['balance']); ?></p>
                                                                        </div>
                                                                    </label>
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

                                    <div class="mb-4">
                                        <h6 class="fw-bold">Step 2: Select Transfer Type</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="transfer_type" id="transferTypeOwn" value="own" checked>
                                            <label class="form-check-label" for="transferTypeOwn">
                                                Transfer between my accounts
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="transfer_type" id="transferTypeOther" value="other">
                                            <label class="form-check-label" for="transferTypeOther">
                                                Transfer to another account
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6 class="fw-bold">Step 3: Select Destination</h6>
                                        <div id="ownAccountsSection">
                                            <div class="row">
                                                <?php if (count($accounts) > 1): ?>
                                                    <?php foreach ($accounts as $account): ?>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input to-account" type="radio" name="to_account" 
                                                                            id="toAccount<?php echo $account['account_id']; ?>" 
                                                                            value="<?php echo $account['account_id']; ?>">
                                                                        <label class="form-check-label" for="toAccount<?php echo $account['account_id']; ?>">
                                                                            <div>
                                                                                <strong><?php echo htmlspecialchars($account['account_type']); ?> Account</strong>
                                                                                <p class="mb-0">Account #: <?php echo htmlspecialchars($account['account_number']); ?></p>
                                                                                <p class="mb-0">Current Balance: <?php echo $accountController->formatCurrency($account['balance']); ?></p>
                                                                            </div>
                                                                        </label>
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
                                        <div id="externalAccountSection" style="display: none;">
                                            <div class="mb-3">
                                                <label for="toAccountNumber" class="form-label">Recipient Account Number</label>
                                                <input type="text" class="form-control" id="toAccountNumber" name="to_account_number" placeholder="Enter 10-digit account number">
                                            </div>
                                            <div class="mb-3">
                                                <label for="recipientName" class="form-label">Recipient Name (Optional)</label>
                                                <input type="text" class="form-control" id="recipientName" name="recipient_name" placeholder="Enter recipient's name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6 class="fw-bold">Step 4: Enter Amount and Details</h6>
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Amount</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0.01" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description (Optional)</label>
                                            <input type="text" class="form-control" id="description" name="description" placeholder="Enter transfer description">
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i> Transfer Funds
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
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Transfers</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
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
                                                <td><span class="badge bg-success">Completed</span></td>
                                            </tr>
                                            <tr>
                                                <td>2023-05-10</td>
                                                <td>Savings Account (****5678)</td>
                                                <td>John Doe (****9012)</td>
                                                <td>$250.00</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                            </tr>
                                            <tr>
                                                <td>2023-05-05</td>
                                                <td>Checking Account (****1234)</td>
                                                <td>Jane Smith (****3456)</td>
                                                <td>$100.00</td>
                                                <td><span class="badge bg-success">Completed</span></td>
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
    
    <script>
        $(document).ready(function() {
            $('input[name="transfer_type"]').change(function() {
                if ($(this).val() === 'own') {
                    $('#ownAccountsSection').show();
                    $('#externalAccountSection').hide();
                } else {
                    $('#ownAccountsSection').hide();
                    $('#externalAccountSection').show();
                }
            });
            
            $('.from-account').change(function() {
                const selectedAccountId = $(this).val();
                $('.to-account').prop('disabled', false);
                $('#toAccount' + selectedAccountId).prop('disabled', true);
            });
        });
    </script>
</body>
</html>

<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../controllers/AdminController.php';
if (!isLoggedIn()) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
$userId = $_SESSION['user_id'] ?? 0;
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$userRole = $_SESSION['role_name'] ?? 'Customer';
$adminController = new AdminController();
$unreadCount = $adminController->getUnreadNotificationCount($userId);
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_report'])) {
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';
    $format = $_POST['format'] ?? '';
    $dataType = $_POST['data_type'] ?? '';
    if (empty($startDate) || empty($endDate) || empty($format) || empty($dataType)) {
        $message = 'Please fill in all required fields.';
        $messageType = 'danger';
    } else {
        $message = "Your $dataType data has been exported as $format. The file is being downloaded.";
        $messageType = 'success';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_export'])) {
    $frequency = $_POST['frequency'] ?? '';
    $dataType = $_POST['schedule_data_type'] ?? '';
    $format = $_POST['schedule_format'] ?? '';
    if (empty($frequency) || empty($dataType) || empty($format)) {
        $message = 'Please fill in all scheduling fields.';
        $messageType = 'danger';
    } else {
        $message = "Your $dataType export has been scheduled to run $frequency. You will receive the $format file by email.";
        $messageType = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Wizard - Banking System</title>
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
                            <a class="nav-link text-white" href="../Dashboard/<?php echo $userRole === 'Administrator' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../AccountDashboard/dd.php">
                                <i class="fas fa-money-check-alt me-2"></i> Account Management
                            </a>
                        </li>
                        <?php if ($userRole === 'Administrator'): ?>
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
                            <a class="nav-link text-white" href="../Dashboard/transaction_log.php">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Log
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/system_settings.php">
                                <i class="fas fa-cogs me-2"></i> System Settings
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../notifications/notificationCenter.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
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
                    <h1 class="h2">Data Export Wizard</h1>
                    <div class="d-flex align-items-center">
                        <div class="notification-dropdown me-4">
                            <div class="notification-icon">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge"><?php echo $unreadCount; ?></span>
                            </div>
                            <div class="notification-dropdown-content">
                                <div class="notification-header">
                                    <h6 class="notification-title">Notifications</h6>
                                    <a href="../notifications/notificationCenter.php" class="text-decoration-none">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </div>
                                <ul class="notification-list">
                                </ul>
                                <div class="notification-footer">
                                    <a href="../notifications/notificationCenter.php">View All Notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <a href="../Dashboard/<?php echo $userRole === 'Administrator' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-download me-2"></i>One-Time Export</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="exportWizard.php">
                                    <div class="mb-3">
                                        <label for="data_type" class="form-label">Data Type</label>
                                        <select class="form-select" id="data_type" name="data_type" required>
                                            <option value="">-- Select Data Type --</option>
                                            <option value="transactions">Transaction History</option>
                                            <option value="account_statements">Account Statements</option>
                                            <option value="user_activity">User Activity Log</option>
                                            <?php if ($userRole === 'Administrator'): ?>
                                            <option value="system_logs">System Logs</option>
                                            <option value="user_list">User List</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="format" class="form-label">Export Format</label>
                                        <select class="form-select" id="format" name="format" required>
                                            <option value="">-- Select Format --</option>
                                            <option value="pdf">PDF Document</option>
                                            <option value="csv">CSV Spreadsheet</option>
                                            <option value="excel">Excel Spreadsheet</option>
                                            <option value="json">JSON Data</option>
                                        </select>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i> PDF is best for printing, CSV/Excel for data analysis
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="download_report" class="btn btn-primary">
                                            <i class="fas fa-file-export me-2"></i>Generate and Download
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Scheduled Exports</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="exportWizard.php">
                                    <div class="mb-3">
                                        <label for="schedule_data_type" class="form-label">Data Type</label>
                                        <select class="form-select" id="schedule_data_type" name="schedule_data_type" required>
                                            <option value="">-- Select Data Type --</option>
                                            <option value="transactions">Transaction History</option>
                                            <option value="account_statements">Account Statements</option>
                                            <option value="user_activity">User Activity Log</option>
                                            <?php if ($userRole === 'Administrator'): ?>
                                            <option value="system_logs">System Logs</option>
                                            <option value="user_list">User List</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="frequency" class="form-label">Frequency</label>
                                        <select class="form-select" id="frequency" name="frequency" required>
                                            <option value="">-- Select Frequency --</option>
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="quarterly">Quarterly</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="schedule_format" class="form-label">Export Format</label>
                                        <select class="form-select" id="schedule_format" name="schedule_format" required>
                                            <option value="">-- Select Format --</option>
                                            <option value="pdf">PDF Document</option>
                                            <option value="csv">CSV Spreadsheet</option>
                                            <option value="excel">Excel Spreadsheet</option>
  </select>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="email_delivery" name="email_delivery" checked>
                                        <label class="form-check-label" for="email_delivery">Deliver to my email</label>
                                        <div class="form-text">
                                            <i class="fas fa-envelope me-1"></i> Reports will be sent to: <?php echo htmlspecialchars($_SESSION['email'] ?? 'your registered email'); ?>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="schedule_export" class="btn btn-success">
                                            <i class="fas fa-calendar-plus me-2"></i>Schedule Export
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Export History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Data Type</th>
                                        <th>Format</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime('-2 days')); ?></td>
                                        <td>Transaction History</td>
                                        <td><span class="badge bg-danger">PDF</span></td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-download me-1"></i>Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime('-1 week')); ?></td>
                                        <td>Account Statement</td>
                                        <td><span class="badge bg-primary">CSV</span></td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-download me-1"></i>Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime('-1 month')); ?></td>
                                        <td>User Activity</td>
                                        <td><span class="badge bg-success">Excel</span></td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-download me-1"></i>Download</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/js/notification.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            if (startDateInput && endDateInput) {
                const today = new Date();
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                startDateInput.valueAsDate = firstDay;
                endDateInput.valueAsDate = today;
                endDateInput.addEventListener('change', function() {
                    if (startDateInput.value && this.value && new Date(this.value) < new Date(startDateInput.value)) {
                        alert('End date must be after start date');
                        this.valueAsDate = today;
                    }
                });
                startDateInput.addEventListener('change', function() {
                    if (endDateInput.value && this.value && new Date(endDateInput.value) < new Date(this.value)) {
                        alert('Start date must be before end date');
                        this.valueAsDate = firstDay;
                    }
                });
            }
        });
    </script>
</body>
</html>

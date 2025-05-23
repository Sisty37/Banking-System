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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Format Options - Banking System</title>
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
                            <a class="nav-link active text-white" href="exportWizard.php">
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
                    <h1 class="h2">Export Format Options</h1>
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
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Available Export Formats</h5>
                            </div>
                            <div class="card-body">
                                <p class="lead text-center mb-4">Choose your preferred export format based on your needs:</p>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-danger">
                                            <div class="card-header bg-danger text-white">
                                                <h5 class="mb-0"><i class="fas fa-file-pdf me-2"></i>PDF Document</h5>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-muted">Best for:</h6>
                                                <ul>
                                                    <li>Printing physical copies</li>
                                                    <li>Official documentation</li>
                                                    <li>Sharing with external parties</li>
                                                    <li>Preserving formatting and layout</li>
                                                </ul>
                                                <p class="card-text">PDF files maintain consistent appearance across all devices and are excellent for archiving.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-primary">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0"><i class="fas fa-file-csv me-2"></i>CSV Spreadsheet</h5>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-muted">Best for:</h6>
                                                <ul>
                                                    <li>Data analysis and manipulation</li>
                                                    <li>Importing into other systems</li>
                                                    <li>Working with large datasets</li>
                                                    <li>Custom calculations and filtering</li>
                                                </ul>
                                                <p class="card-text">CSV files are compatible with all spreadsheet applications and data analysis tools.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-success">
                                            <div class="card-header bg-success text-white">
                                                <h5 class="mb-0"><i class="fas fa-file-excel me-2"></i>Excel Spreadsheet</h5>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-muted">Best for:</h6>
                                                <ul>
                                                    <li>Advanced data analysis</li>
                                                    <li>Creating charts and visualizations</li>
                                                    <li>Applying formatting to data</li>
                                                    <li>Using formulas and macros</li>
                                                </ul>
                                                <p class="card-text">Excel files include formatting and allow for complex calculations and pivot tables.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-warning">
                                            <div class="card-header bg-warning text-dark">
                                                <h5 class="mb-0"><i class="fas fa-file-code me-2"></i>JSON Data</h5>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-muted">Best for:</h6>
                                                <ul>
                                                    <li>Developer integrations</li>
                                                    <li>Web applications</li>
                                                    <li>API consumption</li>
                                                    <li>Data transfer between systems</li>
                                                </ul>
                                                <p class="card-text">JSON is lightweight and easy to parse, making it ideal for programmatic use.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-2">
                                    <a href="exportWizard.php" class="btn btn-primary btn-lg">
                                        <i class="fas fa-arrow-right me-2"></i>Proceed to Export Wizard
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
    <script src="../../../public/js/notification.js"></script>
</body>
</html>

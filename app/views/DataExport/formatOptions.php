<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../appInitializer.php';
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
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Format options specific styles */
        .format-card {
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            height: 100%;
            transition: transform 0.3s ease;
            border: 1px solid var(--border-color);
        }
        
        .format-card:hover {
            transform: translateY(-5px);
        }
        
        .format-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            font-weight: 600;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
        }
        
        .format-card-pdf .format-card-header {
            background-color: var(--danger-color);
            color: white;
        }
        
        .format-card-csv .format-card-header {
            background-color: var(--primary-color);
            color: white;
        }
        
        .format-card-excel .format-card-header {
            background-color: var(--success-color);
            color: white;
        }
        
        .format-card-json .format-card-header {
            background-color: var(--warning-color);
            color: var(--text-color);
        }
        
        .format-card-body {
            padding: 20px;
            background-color: var(--card-bg);
        }
        
        .format-subtitle {
            color: var(--text-secondary);
            margin-bottom: 15px;
            font-weight: 500;
        }
        
        .format-list {
            padding-left: 20px;
            margin-bottom: 15px;
        }
        
        .format-list li {
            margin-bottom: 8px;
            color: var(--text-color);
        }
        
        .format-text {
            color: var(--text-color);
            font-size: 0.9rem;
        }
        
        .proceed-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            margin-top: 20px;
        }
        
        .proceed-btn:hover {
            opacity: 0.9;
        }
        
        .format-icon {
            font-size: 1.2rem;
            margin-right: 10px;
        }
        
        .format-main-title {
            color: var(--text-color);
            text-align: center;
            margin-bottom: 25px;
            font-weight: 300;
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
                    <p class="text-white-50">Administration Portal</p>
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
                    <?php if ($userRole === 'Administrator'): ?>
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
                        <a class="nav-link" href="../Dashboard/transaction_log.php">
                            <span class="nav-icon">↔️</span> Transaction Log
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/system_analytics.php">
                            <span class="nav-icon">📈</span> System Analytics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/system_settings.php">
                            <span class="nav-icon">⚙️</span> System Settings
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="exportWizard.php">
                            <span class="nav-icon">📤</span> Data Export
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
                        <h1 class="h2 mb-0">Export Format Options</h1>
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
                
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <div class="card mb-4">
                            <div class="card-header d-flex align-items-center">
                                <span class="nav-icon me-2">📄</span> Available Export Formats
                            </div>
                            <div class="card-body">
                                <p class="format-main-title">Choose your preferred export format based on your needs:</p>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="format-card format-card-pdf">
                                            <div class="format-card-header">
                                                <span class="format-icon">📕</span> PDF Document
                                            </div>
                                            <div class="format-card-body">
                                                <h6 class="format-subtitle">Best for:</h6>
                                                <ul class="format-list">
                                                    <li>Printing physical copies</li>
                                                    <li>Official documentation</li>
                                                    <li>Sharing with external parties</li>
                                                    <li>Preserving formatting and layout</li>
                                                </ul>
                                                <p class="format-text">PDF files maintain consistent appearance across all devices and are excellent for archiving.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <div class="format-card format-card-csv">
                                            <div class="format-card-header">
                                                <span class="format-icon">📊</span> CSV Spreadsheet
                                            </div>
                                            <div class="format-card-body">
                                                <h6 class="format-subtitle">Best for:</h6>
                                                <ul class="format-list">
                                                    <li>Data analysis and manipulation</li>
                                                    <li>Importing into other systems</li>
                                                    <li>Working with large datasets</li>
                                                    <li>Custom calculations and filtering</li>
                                                </ul>
                                                <p class="format-text">CSV files are compatible with all spreadsheet applications and data analysis tools.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <div class="format-card format-card-excel">
                                            <div class="format-card-header">
                                                <span class="format-icon">📗</span> Excel Spreadsheet
                                            </div>
                                            <div class="format-card-body">
                                                <h6 class="format-subtitle">Best for:</h6>
                                                <ul class="format-list">
                                                    <li>Advanced data analysis</li>
                                                    <li>Creating charts and visualizations</li>
                                                    <li>Applying formatting to data</li>
                                                    <li>Using formulas and macros</li>
                                                </ul>
                                                <p class="format-text">Excel files include formatting and allow for complex calculations and pivot tables.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <div class="format-card format-card-json">
                                            <div class="format-card-header">
                                                <span class="format-icon">📓</span> JSON Data
                                            </div>
                                            <div class="format-card-body">
                                                <h6 class="format-subtitle">Best for:</h6>
                                                <ul class="format-list">
                                                    <li>Developer integrations</li>
                                                    <li>Web applications</li>
                                                    <li>API consumption</li>
                                                    <li>Data transfer between systems</li>
                                                </ul>
                                                <p class="format-text">JSON is lightweight and easy to parse, making it ideal for programmatic use.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <a href="exportWizard.php" class="proceed-btn">
                                        <span class="nav-icon me-2">➡️</span> Proceed to Export Wizard
                                    </a>
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
            
            // Format cards hover effect
            const formatCards = document.querySelectorAll('.format-card');
            formatCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>

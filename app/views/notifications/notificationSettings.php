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
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    $emailNotifications = isset($_POST['email_notifications']) ? 1 : 0;
    $pushNotifications = isset($_POST['push_notifications']) ? 1 : 0;
    $transactionAlerts = isset($_POST['transaction_alerts']) ? 1 : 0;
    $securityAlerts = isset($_POST['security_alerts']) ? 1 : 0;
    $marketingMessages = isset($_POST['marketing_messages']) ? 1 : 0;
    $message = 'Notification settings have been saved successfully!';
    $messageType = 'success';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Settings - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Notification Settings specific styles */
        .settings-heading {
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: var(--text-color-primary);
        }
        
        .settings-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }
        
        .settings-card-header {
            padding: 15px 20px;
            background-color: var(--card-header-bg);
            border-bottom: 1px solid var(--border-color);
        }
        
        .settings-card-header h5, .settings-card-header h6 {
            margin: 0;
            font-weight: 600;
            color: var(--text-color-primary);
            display: flex;
            align-items: center;
        }
        
        .settings-card-body {
            padding: 20px;
        }
        
        .settings-section {
            margin-bottom: 1rem;
        }
        
        .settings-section h5 {
            margin-bottom: 1rem;
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-color-primary);
        }
        
        .settings-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            outline: none;
            font-size: 0.95rem;
        }
        
        .settings-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .settings-btn-primary:hover {
            background-color: var(--primary-color-hover);
        }
        
        .settings-btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }
        
        .settings-btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .settings-icon {
            margin-right: 8px;
            font-size: 1.1em;
        }
        
        .settings-alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            border-left: 4px solid transparent;
        }
        
        .settings-alert.success {
            background-color: rgba(var(--success-color-rgb), 0.1);
            border-color: var(--success-color);
            color: var(--success-color);
        }
        
        .settings-alert.danger {
            background-color: rgba(var(--danger-color-rgb), 0.1);
            border-color: var(--danger-color);
            color: var(--danger-color);
        }
        
        .settings-alert-close {
            float: right;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            color: inherit;
            background: transparent;
            border: 0;
            cursor: pointer;
            opacity: 0.5;
        }
        
        .settings-alert-close:hover {
            opacity: 1;
        }
        
        .settings-form-group {
            margin-bottom: 15px;
        }
        
        .settings-switch-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .settings-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin-right: 15px;
        }
        
        .settings-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .settings-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .settings-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .settings-slider {
            background-color: var(--primary-color);
        }
        
        input:focus + .settings-slider {
            box-shadow: 0 0 1px var(--primary-color);
        }
        
        input:checked + .settings-slider:before {
            transform: translateX(26px);
        }
        
        .settings-switch-label {
            font-weight: 500;
            color: var(--text-color-primary);
            margin-bottom: 0.2rem;
            display: block;
        }
        
        .settings-switch-description {
            font-size: 0.85rem;
            color: var(--text-color-secondary);
            display: block;
        }
        
        .settings-radio-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .settings-radio {
            display: flex;
            align-items: center;
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            font-weight: 400;
            margin: 0;
            color: var(--text-color-primary);
        }
        
        .settings-radio input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .settings-radio-mark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .settings-radio:hover input ~ .settings-radio-mark {
            background-color: #ccc;
        }
        
        .settings-radio input:checked ~ .settings-radio-mark {
            background-color: var(--primary-color);
        }
        
        .settings-radio-mark:after {
            content: "";
            position: absolute;
            display: none;
        }
        
        .settings-radio input:checked ~ .settings-radio-mark:after {
            display: block;
        }
        
        .settings-radio .settings-radio-mark:after {
            top: 6px;
            left: 6px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }
        
        .settings-input-label {
            font-weight: 500;
            color: var(--text-color-primary);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .settings-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            background-color: var(--input-bg);
            color: var(--text-color-primary);
            transition: all 0.3s ease;
        }
        
        .settings-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        .days-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }
        
        .day-button {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        
        .day-button input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .day-button span {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color-secondary);
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .day-button input:checked + span {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .dark-mode .settings-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .dark-mode .settings-slider {
            background-color: #555;
        }
        
        .dark-mode .settings-radio-mark {
            background-color: #555;
        }
        
        .dark-mode .settings-radio:hover input ~ .settings-radio-mark {
            background-color: #777;
        }
        
        @media (max-width: 768px) {
            .grid-2-columns {
                grid-template-columns: 1fr;
            }
            
            .days-buttons {
                justify-content: space-between;
            }
            
            .day-button span {
                padding: 5px 8px;
                font-size: 0.8rem;
            }
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
                    <?php if ($userRole === 'Administrator'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/user_management.php">
                            <span class="nav-icon">👥</span> User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../RoleBasedAccess/PermissionSettings.php">
                            <span class="nav-icon">🔐</span> Roles & Permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/transaction_log.php">
                            <span class="nav-icon">📝</span> Transaction Log
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/system_settings.php">
                            <span class="nav-icon">⚙️</span> System Settings
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../ProfileManagement/profile.php">
                            <span class="nav-icon">👤</span> Profile
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
                <div class="content-header">
                    <h1>Notification Settings</h1>
                    <div class="header-actions">
                        <a href="notificationCenter.php" class="settings-btn settings-btn-outline">
                            <span class="settings-icon">◀️</span> Back to Notifications
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
                
                <?php if (!empty($message)): ?>
                <div class="settings-alert <?php echo $messageType; ?>" id="alertMessage">
                    <?php echo $message; ?>
                    <button type="button" class="settings-alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
                <?php endif; ?>
                
                <!-- Notification Settings Form -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5><span class="settings-icon">⚙️</span> Notification Preferences</h5>
                    </div>
                    <div class="settings-card-body">
                        <form method="POST" action="notificationSettings.php">
                            <div class="grid-2-columns">
                                <div class="settings-section">
                                    <h5>Delivery Methods</h5>
                                    <div class="settings-switch-wrapper">
                                        <label class="settings-switch">
                                            <input type="checkbox" id="email_notifications" name="email_notifications" checked>
                                            <span class="settings-slider"></span>
                                        </label>
                                        <div>
                                            <label class="settings-switch-label" for="email_notifications">
                                                <span class="settings-icon">📧</span> Email Notifications
                                            </label>
                                            <span class="settings-switch-description">Receive notifications via email</span>
                                        </div>
                                    </div>
                                    <div class="settings-switch-wrapper">
                                        <label class="settings-switch">
                                            <input type="checkbox" id="push_notifications" name="push_notifications" checked>
                                            <span class="settings-slider"></span>
                                        </label>
                                        <div>
                                            <label class="settings-switch-label" for="push_notifications">
                                                <span class="settings-icon">🔔</span> In-App Notifications
                                            </label>
                                            <span class="settings-switch-description">Receive notifications in the app</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="settings-section">
                                    <h5>Notification Types</h5>
                                    <div class="settings-switch-wrapper">
                                        <label class="settings-switch">
                                            <input type="checkbox" id="transaction_alerts" name="transaction_alerts" checked>
                                            <span class="settings-slider"></span>
                                        </label>
                                        <div>
                                            <label class="settings-switch-label" for="transaction_alerts">
                                                <span class="settings-icon">💸</span> Transaction Alerts
                                            </label>
                                            <span class="settings-switch-description">Deposits, withdrawals, transfers, etc.</span>
                                        </div>
                                    </div>
                                    <div class="settings-switch-wrapper">
                                        <label class="settings-switch">
                                            <input type="checkbox" id="security_alerts" name="security_alerts" checked>
                                            <span class="settings-slider"></span>
                                        </label>
                                        <div>
                                            <label class="settings-switch-label" for="security_alerts">
                                                <span class="settings-icon">🔒</span> Security Alerts
                                            </label>
                                            <span class="settings-switch-description">Login attempts, password changes, etc.</span>
                                        </div>
                                    </div>
                                    <div class="settings-switch-wrapper">
                                        <label class="settings-switch">
                                            <input type="checkbox" id="marketing_messages" name="marketing_messages">
                                            <span class="settings-slider"></span>
                                        </label>
                                        <div>
                                            <label class="settings-switch-label" for="marketing_messages">
                                                <span class="settings-icon">🏷️</span> Marketing Messages
                                            </label>
                                            <span class="settings-switch-description">Promotions, new features, etc.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="settings-card" style="margin-top: 25px;">
                                <div class="settings-card-header">
                                    <h6>Email Frequency</h6>
                                </div>
                                <div class="settings-card-body">
                                    <div class="settings-radio-group">
                                        <label class="settings-radio">
                                            <input type="radio" name="email_frequency" id="immediate" value="immediate" checked>
                                            <span class="settings-radio-mark"></span>
                                            Immediate - Send emails as events occur
                                        </label>
                                        <label class="settings-radio">
                                            <input type="radio" name="email_frequency" id="daily" value="daily">
                                            <span class="settings-radio-mark"></span>
                                            Daily Summary - Send a daily digest of all notifications
                                        </label>
                                        <label class="settings-radio">
                                            <input type="radio" name="email_frequency" id="weekly" value="weekly">
                                            <span class="settings-radio-mark"></span>
                                            Weekly Summary - Send a weekly digest of all notifications
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="settings-card" style="margin-top: 25px;">
                                <div class="settings-card-header">
                                    <h6><span class="settings-icon">🔕</span> Quiet Hours</h6>
                                </div>
                                <div class="settings-card-body">
                                    <div class="settings-switch-wrapper">
                                        <label class="settings-switch">
                                            <input type="checkbox" id="enable_quiet_hours" name="enable_quiet_hours">
                                            <span class="settings-slider"></span>
                                        </label>
                                        <div>
                                            <label class="settings-switch-label" for="enable_quiet_hours">
                                                Enable Quiet Hours
                                            </label>
                                            <span class="settings-switch-description">Silence notifications during specified hours</span>
                                        </div>
                                    </div>
                                    
                                    <div class="quiet-hours-settings" id="quiet_hours_settings" style="margin-top: 15px; display: none;">
                                        <div class="grid-2-columns">
                                            <div class="form-group">
                                                <label class="settings-input-label">Start Time</label>
                                                <input type="time" class="settings-input" id="quiet_start" name="quiet_start" value="22:00">
                                            </div>
                                            <div class="form-group">
                                                <label class="settings-input-label">End Time</label>
                                                <input type="time" class="settings-input" id="quiet_end" name="quiet_end" value="07:00">
                                            </div>
                                        </div>
                                        
                                        <div class="days-selector" style="margin-top: 15px;">
                                            <label class="settings-input-label">Apply to days:</label>
                                            <div class="days-buttons">
                                                <label class="day-button">
                                                    <input type="checkbox" name="quiet_days[]" value="mon" checked>
                                                    <span>Mon</span>
                                                </label>
                                                <label class="day-button">
                                                    <input type="checkbox" name="quiet_days[]" value="tue" checked>
                                                    <span>Tue</span>
                                                </label>
                                                <label class="day-button">
                                                    <input type="checkbox" name="quiet_days[]" value="wed" checked>
                                                    <span>Wed</span>
                                                </label>
                                                <label class="day-button">
                                                    <input type="checkbox" name="quiet_days[]" value="thu" checked>
                                                    <span>Thu</span>
                                                </label>
                                                <label class="day-button">
                                                    <input type="checkbox" name="quiet_days[]" value="fri" checked>
                                                    <span>Fri</span>
                                                </label>
                                                <label class="day-button">
                                                    <input type="checkbox" name="quiet_days[]" value="sat" checked>
                                                    <span>Sat</span>
                                                </label>
                                                <label class="day-button">
                                                    <input type="checkbox" name="quiet_days[]" value="sun" checked>
                                                    <span>Sun</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end" style="margin-top: 25px;">
                                <button type="submit" name="save_settings" class="settings-btn settings-btn-primary">
                                    <span class="settings-icon">💾</span> Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- JavaScript for handling notification settings -->
                <script>
                    // Toggle quiet hours settings visibility based on checkbox
                    document.addEventListener('DOMContentLoaded', function() {
                        const quietHoursToggle = document.getElementById('enable_quiet_hours');
                        const quietHoursSettings = document.getElementById('quiet_hours_settings');
                        
                        // Initial state
                        if (quietHoursToggle && quietHoursSettings) {
                            quietHoursSettings.style.display = quietHoursToggle.checked ? 'block' : 'none';
                            
                            // Add event listener for toggle changes
                            quietHoursToggle.addEventListener('change', function() {
                                quietHoursSettings.style.display = this.checked ? 'block' : 'none';
                            });
                        }
                        
                        // Initialize dark mode if user preference exists
                        const darkModeToggle = document.getElementById('dark-mode-toggle');
                        const htmlElement = document.documentElement;
                        
                        if (darkModeToggle) {
                            // Check for saved user preference
                            const isDarkMode = localStorage.getItem('darkMode') === 'true';
                            
                            // Set initial state
                            if (isDarkMode) {
                                htmlElement.classList.add('dark-mode');
                                darkModeToggle.classList.add('active');
                            }
                            
                            // Add event listener for dark mode toggle
                            darkModeToggle.addEventListener('click', function() {
                                htmlElement.classList.toggle('dark-mode');
                                const isDarkModeNow = htmlElement.classList.contains('dark-mode');
                                localStorage.setItem('darkMode', isDarkModeNow);
                                this.classList.toggle('active', isDarkModeNow);
                            });
                        }
                        
                        // Handle alert dismissal
                        const alertCloseButtons = document.querySelectorAll('.alert-close');
                        alertCloseButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const alert = this.closest('.alert');
                                if (alert) {
                                    alert.style.display = 'none';
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https:
    <!-- Notification JS -->
  <script src="../../../public/js/notification.js"></script>
</body>
</html>

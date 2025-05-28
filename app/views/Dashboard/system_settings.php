<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
<<<<<<< HEAD
require_once __DIR__ . '/../../appInitializer.php';
=======
require_once __DIR__ . '/../../bootstrap.php';
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
require_once __DIR__ . '/../../controllers/AdminController.php';
if (!isLoggedIn() || !hasRole('Administrator')) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$adminController = new AdminController();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    $category = $_POST['category'] ?? 'general';
    $settings = $_POST;
    unset($settings['category']);
    unset($settings['update_settings']);
    $result = $adminController->updateSystemSettings($settings);
    $message = $result['message'];
    $messageType = $result['success'] ? 'success' : 'danger';
}
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
if (!in_array($activeTab, ['general', 'appearance', 'security', 'financial', 'notifications', 'legal'])) {
    $activeTab = 'general';
}
$settings = $adminController->getSettingsByCategory($activeTab);
?>
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Settings specific styles */
        .settings-card {
            margin-bottom: 20px;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
        }
        
        .settings-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }
        
        .settings-tab {
            padding: 10px 15px;
            border-radius: var(--border-radius);
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .settings-tab:hover {
            background-color: var(--hover-color);
        }
        
        .settings-tab.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        
        .setting-description {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-top: 5px;
        }
        
        .form-switch {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-bottom: 10px;
        }
        
        .switch-toggle {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin-right: 10px;
        }
        
        .switch-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        
        .slider:before {
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
        
        input:checked + .slider {
            background-color: var(--primary-color);
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        .input-group {
            display: flex;
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        
        .input-group-text {
            display: flex;
            align-items: center;
            padding: 0 15px;
            background-color: var(--secondary-color);
            color: white;
            border: 1px solid var(--border-color);
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .settings-card {
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .nav-tabs .nav-link {
            color: #495057;
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
            color: #0d6efd;
        }
        .form-label {
            font-weight: 500;
        }
        .setting-description {
            font-size: 0.85rem;
            color: #6c757d;
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
        }
    </style>
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
                        <a class="nav-link" href="admin_dashboard.php">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/dd.php">
                            <span class="nav-icon">💳</span> Account Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_management.php">
                            <span class="nav-icon">👥</span> User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../RoleBasedAccess/PermissionSettings.php">
                            <span class="nav-icon">🔒</span> Roles & Permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transaction_log.php">
                            <span class="nav-icon">↔️</span> Transaction Log
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="system_analytics.php">
                            <span class="nav-icon">📈</span> System Analytics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">⚙️</span> System Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../DataExport/exportWizard.php">
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
                        <h1 class="h2 mb-0">System Settings</h1>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="user-dropdown">
                        <div class="user-info">
                            <div class="user-avatar" data-name="<?php echo htmlspecialchars($fullName); ?>"></div>
                            <div class="d-none d-md-block">
                                <div class="fw-bold"><?php echo htmlspecialchars($fullName); ?></div>
                                <div class="small text-muted">Administrator</div>
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
                
                <?php if (isset($message) && !empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <span class="nav-icon"><?php echo $messageType === 'success' ? '✅' : '⚠️'; ?></span>
                    <?php echo $message; ?>
                </div>
                <?php endif; ?>
                <!-- Settings Navigation Tabs -->
                <div class="settings-tabs">
                    <a href="?tab=general" class="settings-tab <?php echo $activeTab === 'general' ? 'active' : ''; ?>">
                        <span class="nav-icon">⚙️</span> General
                    </a>
                    <a href="?tab=appearance" class="settings-tab <?php echo $activeTab === 'appearance' ? 'active' : ''; ?>">
                        <span class="nav-icon">🎨</span> Appearance
                    </a>
                    <a href="?tab=security" class="settings-tab <?php echo $activeTab === 'security' ? 'active' : ''; ?>">
                        <span class="nav-icon">🔒</span> Security
                    </a>
                    <a href="?tab=financial" class="settings-tab <?php echo $activeTab === 'financial' ? 'active' : ''; ?>">
                        <span class="nav-icon">💰</span> Financial
                    </a>
                    <a href="?tab=notifications" class="settings-tab <?php echo $activeTab === 'notifications' ? 'active' : ''; ?>">
                        <span class="nav-icon">🔔</span> Notifications
                    </a>
                    <a href="?tab=legal" class="settings-tab <?php echo $activeTab === 'legal' ? 'active' : ''; ?>">
                        <span class="nav-icon">📜</span> Legal
                    </a>
                </div>
                <!-- Settings Form -->
                <div class="card settings-card">
                    <div class="card-header">
                        <?php
                        $tabIcons = [
                            'general' => '⚙️',
                            'appearance' => '🎨',
                            'security' => '🔒',
                            'financial' => '💰',
                            'notifications' => '🔔',
                            'legal' => '📜'
=======
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-4 mt-2">
                            <a class="navbar-brand text-white" href="#">
                                <i class="fas fa-university me-2"></i>Banking System
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="admin_dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="transaction_log.php">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Log
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="user_management.php">
                                <i class="fas fa-users me-2"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="system_analytics.php">
                                <i class="fas fa-chart-line me-2"></i> System Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="system_settings.php">
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
                    <h1 class="h2">System Settings</h1>
                    <div class="d-flex align-items-center">
                        <div class="notification-dropdown me-4">
                            <div class="notification-icon">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge">3</span>
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
                                <a href="admin_dashboard.php" class="btn btn-sm btn-outline-secondary">Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (isset($message) && !empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $activeTab === 'general' ? 'active' : ''; ?>" href="?tab=general">
                            <i class="fas fa-sliders-h me-1"></i> General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $activeTab === 'appearance' ? 'active' : ''; ?>" href="?tab=appearance">
                            <i class="fas fa-palette me-1"></i> Appearance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $activeTab === 'security' ? 'active' : ''; ?>" href="?tab=security">
                            <i class="fas fa-shield-alt me-1"></i> Security
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $activeTab === 'financial' ? 'active' : ''; ?>" href="?tab=financial">
                            <i class="fas fa-dollar-sign me-1"></i> Financial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $activeTab === 'notifications' ? 'active' : ''; ?>" href="?tab=notifications">
                            <i class="fas fa-bell me-1"></i> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $activeTab === 'legal' ? 'active' : ''; ?>" href="?tab=legal">
                            <i class="fas fa-gavel me-1"></i> Legal
                        </a>
                    </li>
                </ul>
                <div class="card settings-card">
                    <div class="card-header bg-primary text-white">
                        <?php
                        $tabIcons = [
                            'general' => 'sliders-h',
                            'appearance' => 'palette',
                            'security' => 'shield-alt',
                            'financial' => 'dollar-sign',
                            'notifications' => 'bell',
                            'legal' => 'gavel'
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                        ];
                        $tabTitles = [
                            'general' => 'General Settings',
                            'appearance' => 'Appearance Settings',
                            'security' => 'Security Settings',
                            'financial' => 'Financial Settings',
                            'notifications' => 'Notification Settings',
                            'legal' => 'Legal Documents'
                        ];
                        ?>
<<<<<<< HEAD
                        <h5 class="mb-0 d-flex align-items-center">
                            <span class="nav-icon me-2"><?php echo $tabIcons[$activeTab]; ?></span> <?php echo $tabTitles[$activeTab]; ?>
                        </h5>
=======
                        <h5><i class="fas fa-<?php echo $tabIcons[$activeTab]; ?> me-2"></i> <?php echo $tabTitles[$activeTab]; ?></h5>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                    </div>
                    <div class="card-body">
                        <form method="POST" action="system_settings.php?tab=<?php echo $activeTab; ?>">
                            <input type="hidden" name="category" value="<?php echo $activeTab; ?>">
                            <?php if ($activeTab === 'general'): ?>
                                <div class="mb-3">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo htmlspecialchars($settings['bank_name'] ?? ''); ?>">
                                    <div class="setting-description">The name of your banking institution.</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="support_email" class="form-label">Support Email</label>
                                            <input type="email" class="form-control" id="support_email" name="support_email" value="<?php echo htmlspecialchars($settings['support_email'] ?? ''); ?>">
                                            <div class="setting-description">Primary customer support email address.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="support_phone" class="form-label">Support Phone</label>
                                            <input type="text" class="form-control" id="support_phone" name="support_phone" value="<?php echo htmlspecialchars($settings['support_phone'] ?? ''); ?>">
                                            <div class="setting-description">Customer support phone number.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="currency_symbol" class="form-label">Currency Symbol</label>
                                            <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" value="<?php echo htmlspecialchars($settings['currency_symbol'] ?? '$'); ?>">
                                            <div class="setting-description">Symbol displayed before amounts.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="date_format" class="form-label">Date Format</label>
                                            <input type="text" class="form-control" id="date_format" name="date_format" value="<?php echo htmlspecialchars($settings['date_format'] ?? 'M d, Y'); ?>">
                                            <div class="setting-description">PHP date format for display.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="time_format" class="form-label">Time Format</label>
                                            <input type="text" class="form-control" id="time_format" name="time_format" value="<?php echo htmlspecialchars($settings['time_format'] ?? 'H:i:s'); ?>">
                                            <div class="setting-description">PHP time format for display.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="timezone" class="form-label">Timezone</label>
                                            <select class="form-select" id="timezone" name="timezone">
                                                <?php
                                                $timezones = DateTimeZone::listIdentifiers();
                                                $currentTimezone = $settings['timezone'] ?? 'America/New_York';
                                                foreach ($timezones as $tz) {
                                                    echo '<option value="' . $tz . '" ' . ($tz === $currentTimezone ? 'selected' : '') . '>' . $tz . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <div class="setting-description">System timezone for date/time functions.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="decimal_places" class="form-label">Decimal Places</label>
                                            <select class="form-select" id="decimal_places" name="decimal_places">
                                                <?php
                                                $currentDecimalPlaces = $settings['decimal_places'] ?? '2';
                                                for ($i = 0; $i <= 4; $i++) {
                                                    echo '<option value="' . $i . '" ' . ($i === (int)$currentDecimalPlaces ? 'selected' : '') . '>' . $i . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <div class="setting-description">Number of decimal places for currency display.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="welcome_message" class="form-label">Welcome Message</label>
                                    <textarea class="form-control" id="welcome_message" name="welcome_message" rows="2"><?php echo htmlspecialchars($settings['welcome_message'] ?? ''); ?></textarea>
                                    <div class="setting-description">Message displayed on user dashboard.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="footer_text" class="form-label">Footer Text</label>
                                    <input type="text" class="form-control" id="footer_text" name="footer_text" value="<?php echo htmlspecialchars($settings['footer_text'] ?? ''); ?>">
                                    <div class="setting-description">Text displayed in the footer of all pages.</div>
                                </div>
                            <?php elseif ($activeTab === 'appearance'): ?>
                                <div class="mb-3">
                                    <label for="system_theme" class="form-label">System Theme</label>
                                    <select class="form-select" id="system_theme" name="system_theme">
                                        <option value="default" <?php echo ($settings['system_theme'] ?? 'default') === 'default' ? 'selected' : ''; ?>>Default</option>
                                        <option value="dark" <?php echo ($settings['system_theme'] ?? '') === 'dark' ? 'selected' : ''; ?>>Dark</option>
                                        <option value="light" <?php echo ($settings['system_theme'] ?? '') === 'light' ? 'selected' : ''; ?>>Light</option>
                                        <option value="blue" <?php echo ($settings['system_theme'] ?? '') === 'blue' ? 'selected' : ''; ?>>Blue</option>
                                        <option value="green" <?php echo ($settings['system_theme'] ?? '') === 'green' ? 'selected' : ''; ?>>Green</option>
                                    </select>
                                    <div class="setting-description">Visual theme for the application interface.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="logo_url" class="form-label">Logo URL</label>
                                    <input type="text" class="form-control" id="logo_url" name="logo_url" value="<?php echo htmlspecialchars($settings['logo_url'] ?? ''); ?>">
                                    <div class="setting-description">Path to the bank logo image.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="favicon_url" class="form-label">Favicon URL</label>
                                    <input type="text" class="form-control" id="favicon_url" name="favicon_url" value="<?php echo htmlspecialchars($settings['favicon_url'] ?? ''); ?>">
                                    <div class="setting-description">Path to the favicon image for browser tabs.</div>
                                </div>
                            <?php elseif ($activeTab === 'security'): ?>
                                <div class="mb-3">
<<<<<<< HEAD
                                    <div class="form-switch">
                                        <label class="switch-toggle">
                                            <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="on" <?php echo ($settings['maintenance_mode'] ?? 'off') === 'on' ? 'checked' : ''; ?>>
                                            <span class="slider"></span>
                                        </label>
                                        <label for="maintenance_mode">Maintenance Mode</label>
=======
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" value="on" <?php echo ($settings['maintenance_mode'] ?? 'off') === 'on' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="maintenance_mode">Maintenance Mode</label>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </div>
                                    <div class="setting-description">When enabled, only administrators can access the system.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="maintenance_message" class="form-label">Maintenance Message</label>
                                    <textarea class="form-control" id="maintenance_message" name="maintenance_message" rows="2"><?php echo htmlspecialchars($settings['maintenance_message'] ?? ''); ?></textarea>
                                    <div class="setting-description">Message displayed to users when in maintenance mode.</div>
                                </div>
                                <div class="mb-3">
<<<<<<< HEAD
                                    <div class="form-switch">
                                        <label class="switch-toggle">
                                            <input type="checkbox" id="enable_new_registrations" name="enable_new_registrations" value="on" <?php echo ($settings['enable_new_registrations'] ?? 'on') === 'on' ? 'checked' : ''; ?>>
                                            <span class="slider"></span>
                                        </label>
                                        <label for="enable_new_registrations">Enable New Registrations</label>
=======
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="enable_new_registrations" name="enable_new_registrations" value="on" <?php echo ($settings['enable_new_registrations'] ?? 'on') === 'on' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="enable_new_registrations">Enable New Registrations</label>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </div>
                                    <div class="setting-description">Allow new users to register for accounts.</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="max_login_attempts" class="form-label">Max Login Attempts</label>
                                            <input type="number" class="form-control" id="max_login_attempts" name="max_login_attempts" min="1" max="10" value="<?php echo htmlspecialchars($settings['max_login_attempts'] ?? '5'); ?>">
                                            <div class="setting-description">Number of failed attempts before lockout.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="password_expiry_days" class="form-label">Password Expiry (Days)</label>
                                            <input type="number" class="form-control" id="password_expiry_days" name="password_expiry_days" min="0" value="<?php echo htmlspecialchars($settings['password_expiry_days'] ?? '90'); ?>">
                                            <div class="setting-description">Days before password change required (0 = never).</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="session_timeout_minutes" class="form-label">Session Timeout (Minutes)</label>
                                            <input type="number" class="form-control" id="session_timeout_minutes" name="session_timeout_minutes" min="1" max="1440" value="<?php echo htmlspecialchars($settings['session_timeout_minutes'] ?? '30'); ?>">
                                            <div class="setting-description">Minutes of inactivity before session expires.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
<<<<<<< HEAD
                                    <div class="form-switch">
                                        <label class="switch-toggle">
                                            <input type="checkbox" id="enable_2fa" name="enable_2fa" value="on" <?php echo ($settings['enable_2fa'] ?? 'off') === 'on' ? 'checked' : ''; ?>>
                                            <span class="slider"></span>
                                        </label>
                                        <label for="enable_2fa">Enable Two-Factor Authentication</label>
=======
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="enable_2fa" name="enable_2fa" value="on" <?php echo ($settings['enable_2fa'] ?? 'off') === 'on' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="enable_2fa">Enable Two-Factor Authentication</label>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </div>
                                    <div class="setting-description">Require 2FA for all user logins.</div>
                                </div>
                                <div class="mb-3">
<<<<<<< HEAD
                                    <div class="form-switch">
                                        <label class="switch-toggle">
                                            <input type="checkbox" id="allow_password_reset" name="allow_password_reset" value="on" <?php echo ($settings['allow_password_reset'] ?? 'on') === 'on' ? 'checked' : ''; ?>>
                                            <span class="slider"></span>
                                        </label>
                                        <label for="allow_password_reset">Allow Password Reset</label>
=======
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="allow_password_reset" name="allow_password_reset" value="on" <?php echo ($settings['allow_password_reset'] ?? 'on') === 'on' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="allow_password_reset">Allow Password Reset</label>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </div>
                                    <div class="setting-description">Allow users to reset passwords via email.</div>
                                </div>
                            <?php elseif ($activeTab === 'financial'): ?>
                                <div class="mb-3">
                                    <label for="transaction_fee_percentage" class="form-label">Transaction Fee Percentage</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="transaction_fee_percentage" name="transaction_fee_percentage" step="0.01" min="0" max="100" value="<?php echo htmlspecialchars($settings['transaction_fee_percentage'] ?? '1.5'); ?>">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <div class="setting-description">Fee percentage for transactions (0 = no fee).</div>
                                </div>
                                <div class="mb-3">
                                    <label for="minimum_balance" class="form-label">Minimum Balance</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="minimum_balance" name="minimum_balance" step="0.01" min="0" value="<?php echo htmlspecialchars($settings['minimum_balance'] ?? '100.00'); ?>">
                                    </div>
                                    <div class="setting-description">Minimum balance required for accounts.</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="interest_rate_savings" class="form-label">Savings Account Interest Rate</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="interest_rate_savings" name="interest_rate_savings" step="0.01" min="0" max="100" value="<?php echo htmlspecialchars($settings['interest_rate_savings'] ?? '2.5'); ?>">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <div class="setting-description">Annual interest rate for savings accounts.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="interest_rate_checking" class="form-label">Checking Account Interest Rate</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="interest_rate_checking" name="interest_rate_checking" step="0.01" min="0" max="100" value="<?php echo htmlspecialchars($settings['interest_rate_checking'] ?? '0.5'); ?>">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <div class="setting-description">Annual interest rate for checking accounts.</div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif ($activeTab === 'notifications'): ?>
                                <div class="mb-3">
<<<<<<< HEAD
                                    <div class="form-switch">
                                        <label class="switch-toggle">
                                            <input type="checkbox" id="notification_emails_enabled" name="notification_emails_enabled" value="on" <?php echo ($settings['notification_emails_enabled'] ?? 'on') === 'on' ? 'checked' : ''; ?>>
                                            <span class="slider"></span>
                                        </label>
                                        <label for="notification_emails_enabled">Enable Email Notifications</label>
=======
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notification_emails_enabled" name="notification_emails_enabled" value="on" <?php echo ($settings['notification_emails_enabled'] ?? 'on') === 'on' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="notification_emails_enabled">Enable Email Notifications</label>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </div>
                                    <div class="setting-description">Send users email notifications for important events.</div>
                                </div>
                                <div class="mb-3">
<<<<<<< HEAD
                                    <div class="form-switch">
                                        <label class="switch-toggle">
                                            <input type="checkbox" id="notification_sms_enabled" name="notification_sms_enabled" value="on" <?php echo ($settings['notification_sms_enabled'] ?? 'off') === 'on' ? 'checked' : ''; ?>>
                                            <span class="slider"></span>
                                        </label>
                                        <label for="notification_sms_enabled">Enable SMS Notifications</label>
=======
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notification_sms_enabled" name="notification_sms_enabled" value="on" <?php echo ($settings['notification_sms_enabled'] ?? 'off') === 'on' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="notification_sms_enabled">Enable SMS Notifications</label>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                    </div>
                                    <div class="setting-description">Send users SMS notifications for important events.</div>
                                </div>
                            <?php elseif ($activeTab === 'legal'): ?>
                                <div class="mb-3">
                                    <label for="terms_and_conditions" class="form-label">Terms and Conditions</label>
                                    <textarea class="form-control" id="terms_and_conditions" name="terms_and_conditions" rows="10"><?php echo htmlspecialchars($settings['terms_and_conditions'] ?? ''); ?></textarea>
                                    <div class="setting-description">Terms and conditions for using the banking system.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="privacy_policy" class="form-label">Privacy Policy</label>
                                    <textarea class="form-control" id="privacy_policy" name="privacy_policy" rows="10"><?php echo htmlspecialchars($settings['privacy_policy'] ?? ''); ?></textarea>
                                    <div class="setting-description">Privacy policy for user data handling.</div>
                                </div>
                            <?php endif; ?>
                            <div class="mt-4 text-end">
                                <button type="submit" name="update_settings" class="btn btn-primary">
<<<<<<< HEAD
                                    <span class="nav-icon">💾</span> Save Settings
=======
                                    <i class="fas fa-save me-2"></i> Save Settings
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                </button>
                            </div>
                        </form>
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
    
    <script src="../../../public/js/custom-design.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the switch toggles functionality
            const switchToggles = document.querySelectorAll('.form-switch input[type="checkbox"]');
            switchToggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const slider = this.nextElementSibling;
                    if (this.checked) {
                        slider.style.backgroundColor = 'var(--primary-color)';
                    } else {
                        slider.style.backgroundColor = '#ccc';
                    }
                });
            });
            
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
        });
    </script>
</body>
</html> 
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/js/notification.js"></script>
</body>
</html>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

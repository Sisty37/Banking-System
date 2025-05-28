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
$notifications = $adminController->getUserNotifications($userId, 20); 
$unreadCount = $adminController->getUnreadNotificationCount($userId);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read']) && isset($_POST['notification_id'])) {
    $notificationId = intval($_POST['notification_id']);
    $adminController->markNotificationAsRead($notificationId);
    header("Location: notificationCenter.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Center - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Notification specific styles */
        .notification-card {
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }
        
        .notification-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--card-header-bg);
        }
        
        .notification-card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
        }
        
        .notification-card-body {
            padding: 0;
        }
        
        .notification-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }
        
        .notification-item:hover {
            background-color: var(--hover-color);
        }
        
        .notification-item.unread {
            background-color: rgba(var(--primary-color-rgb), 0.05);
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-color);
            display: flex;
            align-items: center;
        }
        
        .notification-message {
            margin-bottom: 5px;
            color: var(--text-color);
        }
        
        .notification-time {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        
        .notification-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 8px;
        }
        
        .notification-badge.new {
            background-color: var(--primary-color);
            color: white;
        }
        
        .notification-badge.unread-count {
            background-color: var(--danger-color);
            color: white;
        }
        
        .notification-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: var(--border-radius);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            margin-left: 10px;
        }
        
        .notification-btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }
        
        .notification-btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .notification-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .notification-btn-primary:hover {
            opacity: 0.9;
        }
        
        .notification-btn-sm {
            padding: 4px 8px;
            font-size: 0.85rem;
        }
        
        .notification-icon {
            margin-right: 8px;
        }
        
        .notification-empty {
            padding: 40px 20px;
            text-align: center;
            color: var(--text-secondary);
        }
        
        .notification-empty-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        .notification-empty-text {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        
        .notification-empty-subtext {
            font-size: 0.9rem;
            opacity: 0.7;
        }
        
        .preference-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }
        
        .preference-card {
            padding: 15px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
        }
        
        .preference-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-color);
            display: flex;
            align-items: center;
        }
        
        .preference-text {
            color: var(--text-color);
            margin-bottom: 15px;
            font-size: 0.9rem;
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
                        <a class="nav-link active" href="#">
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
                    <h1>Notification Center</h1>
                    <div class="header-actions">
                        <span class="notification-badge unread-count"><?php echo $unreadCount; ?> Unread</span>
                        <a href="../Dashboard/<?php echo $userRole === 'Administrator' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>" class="notification-btn notification-btn-outline">
                            Back to Dashboard
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
                
                <!-- Notification List -->
                <div class="notification-card">
                    <div class="notification-card-header">
                        <h5><span class="notification-icon">🔔</span>Your Notifications</h5>
                        <a href="notificationSettings.php" class="notification-btn notification-btn-outline notification-btn-sm">
                            <span class="notification-icon">⚙️</span> Notification Settings
                        </a>
                    </div>
                    <div class="notification-card-body">
                        <?php if (empty($notifications)): ?>
                        <div class="notification-empty">
                            <div class="notification-empty-icon">🔕</div>
                            <p class="notification-empty-text">You don't have any notifications yet.</p>
                            <p class="notification-empty-subtext">Notifications about your account activity will appear here.</p>
                        </div>
                        <?php else: ?>
                        <ul class="notification-list">
                            <?php foreach ($notifications as $notification): ?>
                            <li class="notification-item <?php echo $notification['is_read'] ? '' : 'unread'; ?>">
                                <div class="notification-content">
                                    <div class="notification-title">
                                        <?php if (!$notification['is_read']): ?>
                                        <span class="notification-badge new">New</span>
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($notification['title']); ?>
                                    </div>
                                    <div class="notification-message"><?php echo htmlspecialchars($notification['message']); ?></div>
                                    <div class="notification-time"><?php echo htmlspecialchars($notification['time_ago']); ?></div>
                                </div>
                                <?php if (!$notification['is_read']): ?>
                                <form method="POST" action="notificationCenter.php">
                                    <input type="hidden" name="notification_id" value="<?php echo $notification['notification_id']; ?>">
                                    <button type="submit" name="mark_read" class="notification-btn notification-btn-outline notification-btn-sm">
                                        <span class="notification-icon">✓</span> Mark as Read
                                    </button>
                                </form>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Notification Settings Preview -->
                <div class="notification-card">
                    <div class="notification-card-header">
                        <h5><span class="notification-icon">⚙️</span>Notification Preferences</h5>
                    </div>
                    <div class="notification-card-body">
                        <div style="padding: 20px;">
                            <p>Manage how you receive notifications and what types of activities you want to be notified about.</p>
                            <div class="preference-grid">
                                <div class="preference-card">
                                    <div class="preference-title">
                                        <span class="notification-icon">📧</span> Email Notifications
                                    </div>
                                    <p class="preference-text">Receive important updates via email.</p>
                                    <a href="notificationSettings.php" class="notification-btn notification-btn-primary notification-btn-sm">Configure</a>
                                </div>
                                <div class="preference-card">
                                    <div class="preference-title">
                                        <span class="notification-icon">🔔</span> In-App Notifications
                                    </div>
                                    <p class="preference-text">Control which notifications appear in your dashboard.</p>
                                    <a href="notificationSettings.php" class="notification-btn notification-btn-primary notification-btn-sm">Configure</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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
        });
    </script>
</body>
</html>

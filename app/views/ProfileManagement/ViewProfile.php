<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}

$userId = $_SESSION['user_id'] ?? 0;
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$email = $_SESSION['email'] ?? '';
$userRole = $_SESSION['role_name'] ?? 'Customer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Profile specific styles */
        .profile-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }
        
        .profile-card-header {
            padding: 15px 20px;
            background-color: var(--card-header-bg);
            border-bottom: 1px solid var(--border-color);
        }
        
        .profile-card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-color-primary);
            display: flex;
            align-items: center;
        }
        
        .profile-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .profile-details {
            width: 100%;
            max-width: 500px;
        }
        
        .profile-detail-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .profile-detail-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .profile-detail-label {
            font-weight: 600;
            color: var(--text-color-secondary);
            margin-bottom: 5px;
            display: block;
        }
        
        .profile-detail-value {
            font-size: 1.1rem;
            color: var(--text-color-primary);
        }
        
        .profile-btn {
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
            margin-right: 10px;
            text-decoration: none;
        }
        
        .profile-btn:last-child {
            margin-right: 0;
        }
        
        .profile-btn:hover {
            transform: scale(1.05);
        }
        
        .profile-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .profile-btn-primary:hover {
            background-color: var(--primary-color-hover);
        }
        
        .profile-btn-warning {
            background-color: var(--warning-color);
            color: white;
        }
        
        .profile-btn-warning:hover {
            background-color: var(--warning-color-hover);
        }
        
        .profile-actions {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        
        .profile-icon {
            margin-right: 8px;
            font-size: 1.1em;
        }
        
        /* Dark mode overrides */
        .dark-mode .profile-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        @media (max-width: 768px) {
            .profile-card-body {
                padding: 15px;
            }
            
            .profile-avatar {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }
            
            .profile-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .profile-btn {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
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
                    <p class="text-white-50"><?php echo $userRole; ?> Portal</p>
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
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php">
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
                    <h1>My Profile</h1>
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
                
                <!-- Profile Content -->
                <div class="profile-card">
                    <div class="profile-card-header">
                        <h5><span class="profile-icon">👤</span> Personal Information</h5>
                    </div>
                    <div class="profile-card-body">
                        <div class="profile-avatar" id="userAvatar"></div>
                        
                        <div class="profile-details">
                            <div class="profile-detail-item">
                                <span class="profile-detail-label">Full Name</span>
                                <div class="profile-detail-value"><?php echo htmlspecialchars($fullName); ?></div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <span class="profile-detail-label">Email Address</span>
                                <div class="profile-detail-value"><?php echo htmlspecialchars($email); ?></div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <span class="profile-detail-label">Role</span>
                                <div class="profile-detail-value"><?php echo htmlspecialchars($userRole); ?></div>
                            </div>
                            
                            <div class="profile-actions">
                                <a href="EditProfile.php" class="profile-btn profile-btn-primary">
                                    <span class="profile-icon">✏️</span> Edit Profile
                                </a>
                                <a href="ChangePassword.php" class="profile-btn profile-btn-warning">
                                    <span class="profile-icon">🔒</span> Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize user avatar with initials
            const userAvatar = document.getElementById('userAvatar');
            if (userAvatar) {
                const fullName = '<?php echo $fullName; ?>';
                const initials = fullName.split(' ').map(name => name.charAt(0)).join('').toUpperCase();
                userAvatar.textContent = initials;
                
                // Generate consistent color based on name
                const hue = Math.abs(fullName.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0) % 360);
                userAvatar.style.backgroundColor = `hsl(${hue}, 70%, 60%)`;
            }
            
            // Initialize dark mode if user preference exists
            const darkModeToggle = document.getElementById('darkModeToggle');
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
            
            // Toggle sidebar for mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.toggle('show');
                });
            }
        });
    </script>
</body>
</html>

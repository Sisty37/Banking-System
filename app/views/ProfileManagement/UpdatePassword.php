<<<<<<< HEAD
﻿<?php
session_start();
if (!isset($_SESSION['user_id'])) {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle password update logic here (to be implemented)
    // For now, just show a success message
    $message = "Password updated successfully!";
    $messageType = "success";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Password update specific styles */
        .password-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }
        
        .password-card-header {
            padding: 15px 20px;
            background-color: var(--card-header-bg);
            border-bottom: 1px solid var(--border-color);
        }
        
        .password-card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-color-primary);
            display: flex;
            align-items: center;
        }
        
        .password-card-body {
            padding: 20px;
        }
        
        .password-form-group {
            margin-bottom: 1.5rem;
        }
        
        .password-form-label {
            display: block;
            font-weight: 600;
            color: var(--text-color-secondary);
            margin-bottom: 0.5rem;
        }
        
        .password-form-control {
            width: 100%;
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color-primary);
            transition: all 0.3s ease;
        }
        
        .password-form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        .password-form-text {
            display: block;
            font-size: 0.85rem;
            color: var(--text-color-secondary);
            margin-top: 0.5rem;
        }
        
        .password-btn {
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
        
        .password-btn:last-child {
            margin-right: 0;
        }
        
        .password-btn:hover {
            transform: scale(1.05);
        }
        
        .password-btn-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .password-btn-success:hover {
            background-color: var(--success-color-hover);
        }
        
        .password-btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .password-btn-secondary:hover {
            background-color: var(--secondary-color-hover);
        }
        
        .password-btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color-primary);
        }
        
        .password-btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .password-icon {
            margin-right: 8px;
            font-size: 1.1em;
        }
        
        .password-alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            border-left: 4px solid transparent;
            position: relative;
        }
        
        .password-alert.success {
            background-color: rgba(var(--success-color-rgb), 0.1);
            border-color: var(--success-color);
            color: var(--success-color);
        }
        
        .password-alert.danger {
            background-color: rgba(var(--danger-color-rgb), 0.1);
            border-color: var(--danger-color);
            color: var(--danger-color);
        }
        
        .password-alert-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            color: inherit;
            background: transparent;
            border: 0;
            cursor: pointer;
            opacity: 0.5;
        }
        
        .password-alert-close:hover {
            opacity: 1;
        }
        
        /* Dark mode overrides */
        .dark-mode .password-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .password-requirements {
            margin-top: 1rem;
            padding: 1rem;
            background-color: var(--card-bg);
            border-radius: 5px;
            border-left: 4px solid var(--info-color);
        }
        
        .password-requirements h6 {
            margin-top: 0;
            margin-bottom: 0.5rem;
            color: var(--text-color-primary);
            font-weight: 600;
        }
        
        .password-requirements ul {
            margin: 0;
            padding-left: 1.5rem;
            color: var(--text-color-secondary);
        }
        
        .password-requirements li {
            margin-bottom: 0.25rem;
        }
        
        .password-requirements li:last-child {
            margin-bottom: 0;
        }
        
        @media (max-width: 768px) {
            .password-card-body {
                padding: 15px;
            }
            
            .password-form-group {
                margin-bottom: 1rem;
            }
            
            .password-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .password-btn {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
            }
            
            .password-btn:last-child {
                margin-bottom: 0;
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
                        <a class="nav-link active" href="ViewProfile.php">
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
                    <h1>Change Password</h1>
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
                <div class="password-alert <?php echo $messageType; ?>" id="alertMessage">
                    <?php echo $message; ?>
                    <button type="button" class="password-alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
                <?php endif; ?>
                
                <!-- Password Update Form -->
                <div class="password-card">
                    <div class="password-card-header">
                        <h5><span class="password-icon">🔒</span> Update Your Password</h5>
                    </div>
                    <div class="password-card-body">
                        <form method="POST" id="passwordForm">
                            <div class="password-form-group">
                                <label for="currentPassword" class="password-form-label">Current Password</label>
                                <input type="password" class="password-form-control" id="currentPassword" name="currentPassword" required>
                            </div>
                            
                            <div class="password-form-group">
                                <label for="newPassword" class="password-form-label">New Password</label>
                                <input type="password" class="password-form-control" id="newPassword" name="newPassword" required>
                                <span class="password-form-text">Password must be at least 8 characters long</span>
                            </div>
                            
                            <div class="password-form-group">
                                <label for="confirmPassword" class="password-form-label">Confirm New Password</label>
                                <input type="password" class="password-form-control" id="confirmPassword" name="confirmPassword" required>
                            </div>
                            
                            <div class="password-requirements">
                                <h6><span class="password-icon">ℹ️</span> Password Requirements</h6>
                                <ul>
                                    <li>At least 8 characters long</li>
                                    <li>At least one uppercase letter</li>
                                    <li>At least one lowercase letter</li>
                                    <li>At least one number</li>
                                    <li>At least one special character (!@#$%^&*)</li>
                                </ul>
                            </div>
                            
                            <div class="password-actions" style="margin-top: 20px; text-align: right;">
                                <a href="ViewProfile.php" class="password-btn password-btn-outline">
                                    <span class="password-icon">◀️</span> Cancel
                                </a>
                                <button type="submit" class="password-btn password-btn-success">
                                    <span class="password-icon">💾</span> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize form validation
            const passwordForm = document.getElementById('passwordForm');
            const newPassword = document.getElementById('newPassword');
            const confirmPassword = document.getElementById('confirmPassword');
            
            passwordForm.addEventListener('submit', function(event) {
                // Validate password match
                if (newPassword.value !== confirmPassword.value) {
                    event.preventDefault();
                    alert('Passwords do not match!');
                    return false;
                }
                
                // Validate password strength
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
                if (!passwordRegex.test(newPassword.value)) {
                    event.preventDefault();
                    alert('Password does not meet the requirements!');
                    return false;
                }
                
                return true;
            });
            
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
=======
﻿<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Password</title>
  <link rel="stylesheet" href="../../../public/css/ProfileManagement/UpdatePassword.css">
</head>
<body>
<div class="container mt-5">
  <h2>Change Password</h2>
  <form>
    <div class="mb-3">
      <label for="currentPassword" class="form-label">Current Password</label>
      <input type="password" class="form-control" id="currentPassword">
    </div>
    <div class="mb-3">
      <label for="newPassword" class="form-label">New Password</label>
      <input type="password" class="form-control" id="newPassword">
    </div>
    <div class="mb-3">
      <label for="confirmPassword" class="form-label">Confirm New Password</label>
      <input type="password" class="form-control" id="confirmPassword">
    </div>
    <button type="submit" class="btn btn-success">Update Password</button>
    <a href="../../../app/views/ProfileManagement/ViewProfile.php" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
<script src="../../../public/js/ProfileManagement.js" ></script>
</body>
</html>

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

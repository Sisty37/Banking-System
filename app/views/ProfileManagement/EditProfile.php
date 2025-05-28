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

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle profile update logic here (to be implemented)
    // For now, just show a success message
    $message = "Profile updated successfully!";
    $messageType = "success";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Profile edit specific styles */
        .profile-edit-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }
        
        .profile-edit-card-header {
            padding: 15px 20px;
            background-color: var(--card-header-bg);
            border-bottom: 1px solid var(--border-color);
        }
        
        .profile-edit-card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-color-primary);
            display: flex;
            align-items: center;
        }
        
        .profile-edit-card-body {
            padding: 20px;
        }
        
        .profile-edit-form-group {
            margin-bottom: 1.5rem;
        }
        
        .profile-edit-form-label {
            display: block;
            font-weight: 600;
            color: var(--text-color-secondary);
            margin-bottom: 0.5rem;
        }
        
        .profile-edit-form-control {
            width: 100%;
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color-primary);
            transition: all 0.3s ease;
        }
        
        .profile-edit-form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        .profile-edit-form-text {
            display: block;
            font-size: 0.85rem;
            color: var(--text-color-secondary);
            margin-top: 0.5rem;
        }
        
        .profile-edit-btn {
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
        
        .profile-edit-btn:last-child {
            margin-right: 0;
        }
        
        .profile-edit-btn:hover {
            transform: scale(1.05);
        }
        
        .profile-edit-btn-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .profile-edit-btn-success:hover {
            background-color: var(--success-color-hover);
        }
        
        .profile-edit-btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .profile-edit-btn-secondary:hover {
            background-color: var(--secondary-color-hover);
        }
        
        .profile-edit-btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color-primary);
        }
        
        .profile-edit-btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .profile-edit-icon {
            margin-right: 8px;
            font-size: 1.1em;
        }
        
        .profile-edit-alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            border-left: 4px solid transparent;
            position: relative;
        }
        
        .profile-edit-alert.success {
            background-color: rgba(var(--success-color-rgb), 0.1);
            border-color: var(--success-color);
            color: var(--success-color);
        }
        
        .profile-edit-alert.danger {
            background-color: rgba(var(--danger-color-rgb), 0.1);
            border-color: var(--danger-color);
            color: var(--danger-color);
        }
        
        .profile-edit-alert-close {
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
        
        .profile-edit-alert-close:hover {
            opacity: 1;
        }
        
        .profile-edit-avatar-preview {
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
            margin: 0 auto 20px;
        }
        
        /* Dark mode overrides */
        .dark-mode .profile-edit-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        @media (max-width: 768px) {
            .profile-edit-card-body {
                padding: 15px;
            }
            
            .profile-edit-form-group {
                margin-bottom: 1rem;
            }
            
            .profile-edit-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .profile-edit-btn {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
            }
            
            .profile-edit-btn:last-child {
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
                    <h1>Edit Profile</h1>
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
                <div class="profile-edit-alert <?php echo $messageType; ?>" id="alertMessage">
                    <?php echo $message; ?>
                    <button type="button" class="profile-edit-alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
                <?php endif; ?>
                
                <!-- Profile Edit Form -->
                <div class="profile-edit-card">
                    <div class="profile-edit-card-header">
                        <h5><span class="profile-edit-icon">✏️</span> Edit Your Profile</h5>
                    </div>
                    <div class="profile-edit-card-body">
                        <div class="profile-edit-avatar-preview" id="userAvatar"></div>
                        
                        <form method="POST" id="profileEditForm">
                            <div class="profile-edit-form-group">
                                <label for="firstName" class="profile-edit-form-label">First Name</label>
                                <input type="text" class="profile-edit-form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>" required>
                            </div>
                            
                            <div class="profile-edit-form-group">
                                <label for="lastName" class="profile-edit-form-label">Last Name</label>
                                <input type="text" class="profile-edit-form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>" required>
                            </div>
                            
                            <div class="profile-edit-form-group">
                                <label for="email" class="profile-edit-form-label">Email Address</label>
                                <input type="email" class="profile-edit-form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                                <span class="profile-edit-form-text">We'll never share your email with anyone else.</span>
                            </div>
                            
                            <div class="profile-edit-actions" style="margin-top: 20px; text-align: right;">
                                <a href="ViewProfile.php" class="profile-edit-btn profile-edit-btn-outline">
                                    <span class="profile-edit-icon">◀️</span> Cancel
                                </a>
                                <a href="UpdatePassword.php" class="profile-edit-btn profile-edit-btn-secondary">
                                    <span class="profile-edit-icon">🔒</span> Change Password
                                </a>
                                <button type="submit" class="profile-edit-btn profile-edit-btn-success">
                                    <span class="profile-edit-icon">💾</span> Save Changes
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
            // Initialize user avatar with initials
            const userAvatar = document.getElementById('userAvatar');
            if (userAvatar) {
                const firstName = '<?php echo $firstName; ?>';
                const lastName = '<?php echo $lastName; ?>';
                const initials = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
                userAvatar.textContent = initials;
                
                // Generate consistent color based on name
                const fullName = firstName + ' ' + lastName;
                const hue = Math.abs(fullName.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0) % 360);
                userAvatar.style.backgroundColor = `hsl(${hue}, 70%, 60%)`;
            }
            
            // Form validation
            const profileEditForm = document.getElementById('profileEditForm');
            const emailInput = document.getElementById('email');
            
            profileEditForm.addEventListener('submit', function(event) {
                // Basic email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailInput.value)) {
                    event.preventDefault();
                    alert('Please enter a valid email address');
                    emailInput.focus();
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

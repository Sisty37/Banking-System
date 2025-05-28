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
    // Handle avatar upload logic here (to be implemented)
    // For now, just show a success message
    $message = "Avatar updated successfully!";
    $messageType = "success";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Avatar - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Avatar change specific styles */
        .avatar-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }
        
        .avatar-card-header {
            padding: 15px 20px;
            background-color: var(--card-header-bg);
            border-bottom: 1px solid var(--border-color);
        }
        
        .avatar-card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-color-primary);
            display: flex;
            align-items: center;
        }
        
        .avatar-card-body {
            padding: 20px;
        }
        
        .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            font-weight: 600;
            margin: 0 auto 30px;
            position: relative;
            overflow: hidden;
        }
        
        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        
        .avatar-form-group {
            margin-bottom: 1.5rem;
        }
        
        .avatar-form-label {
            display: block;
            font-weight: 600;
            color: var(--text-color-secondary);
            margin-bottom: 0.5rem;
        }
        
        .avatar-file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .avatar-file-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .avatar-file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            background-color: var(--input-bg);
            border: 1px dashed var(--border-color);
            border-radius: 5px;
            color: var(--text-color-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 60px;
        }
        
        .avatar-file-input-label:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .avatar-file-input-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }
        
        .avatar-form-text {
            display: block;
            font-size: 0.85rem;
            color: var(--text-color-secondary);
            margin-top: 0.5rem;
        }
        
        .avatar-btn {
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
        
        .avatar-btn:last-child {
            margin-right: 0;
        }
        
        .avatar-btn:hover {
            transform: scale(1.05);
        }
        
        .avatar-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .avatar-btn-primary:hover {
            background-color: var(--primary-color-hover);
        }
        
        .avatar-btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color-primary);
        }
        
        .avatar-btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .avatar-icon {
            margin-right: 8px;
            font-size: 1.1em;
        }
        
        .avatar-alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            border-left: 4px solid transparent;
            position: relative;
        }
        
        .avatar-alert.success {
            background-color: rgba(var(--success-color-rgb), 0.1);
            border-color: var(--success-color);
            color: var(--success-color);
        }
        
        .avatar-alert.danger {
            background-color: rgba(var(--danger-color-rgb), 0.1);
            border-color: var(--danger-color);
            color: var(--danger-color);
        }
        
        .avatar-alert-close {
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
        
        .avatar-alert-close:hover {
            opacity: 1;
        }
        
        /* Dark mode overrides */
        .dark-mode .avatar-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        @media (max-width: 768px) {
            .avatar-card-body {
                padding: 15px;
            }
            
            .avatar-preview {
                width: 120px;
                height: 120px;
                font-size: 3rem;
            }
            
            .avatar-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .avatar-btn {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
            }
            
            .avatar-btn:last-child {
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
                    <h1>Change Avatar</h1>
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
                <div class="avatar-alert <?php echo $messageType; ?>" id="alertMessage">
                    <?php echo $message; ?>
                    <button type="button" class="avatar-alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
                <?php endif; ?>
                
                <!-- Avatar Update Form -->
                <div class="avatar-card">
                    <div class="avatar-card-header">
                        <h5><span class="avatar-icon">🖼️</span> Change Your Avatar</h5>
                    </div>
                    <div class="avatar-card-body">
                        <div class="avatar-preview" id="avatarPreview"></div>
                        
                        <form method="POST" id="avatarForm" enctype="multipart/form-data">
                            <div class="avatar-form-group">
                                <label class="avatar-form-label">Upload New Avatar</label>
                                <div class="avatar-file-input-wrapper">
                                    <input type="file" class="avatar-file-input" id="avatarUpload" name="avatarUpload" accept="image/*">
                                    <div class="avatar-file-input-label" id="fileInputLabel">
                                        <span class="avatar-file-input-icon">📤</span>
                                        <span>Drag your image here or click to browse</span>
                                    </div>
                                </div>
                                <span class="avatar-form-text">Allowed formats: JPG, PNG, GIF. Max size: 2MB.</span>
                            </div>
                            
                            <div class="avatar-actions" style="margin-top: 20px; text-align: right;">
                                <a href="EditProfile.php" class="avatar-btn avatar-btn-outline">
                                    <span class="avatar-icon">◀️</span> Back to Profile
                                </a>
                                <button type="submit" class="avatar-btn avatar-btn-primary">
                                    <span class="avatar-icon">💾</span> Upload Avatar
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
            // Initialize avatar preview with initials
            const avatarPreview = document.getElementById('avatarPreview');
            const avatarUpload = document.getElementById('avatarUpload');
            const fileInputLabel = document.getElementById('fileInputLabel');
            
            if (avatarPreview) {
                const firstName = '<?php echo $firstName; ?>';
                const lastName = '<?php echo $lastName; ?>';
                const initials = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
                avatarPreview.textContent = initials;
                
                // Generate consistent color based on name
                const fullName = firstName + ' ' + lastName;
                const hue = Math.abs(fullName.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0) % 360);
                avatarPreview.style.backgroundColor = `hsl(${hue}, 70%, 60%)`;
                
                // Create image element for preview
                const imgPreview = document.createElement('img');
                imgPreview.id = 'imgPreview';
                avatarPreview.appendChild(imgPreview);
            }
            
            // Handle file input change
            if (avatarUpload) {
                avatarUpload.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Update file input label
                        fileInputLabel.innerHTML = `<span class="avatar-file-input-icon">📄</span> ${file.name}`;
                        
                        // Check file size (max 2MB)
                        if (file.size > 2 * 1024 * 1024) {
                            alert('File size exceeds 2MB limit. Please choose a smaller file.');
                            avatarUpload.value = '';
                            fileInputLabel.innerHTML = `<span class="avatar-file-input-icon">📤</span> Drag your image here or click to browse`;
                            return;
                        }
                        
                        // Display image preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imgPreview = document.getElementById('imgPreview');
                            if (imgPreview) {
                                imgPreview.src = e.target.result;
                                imgPreview.style.display = 'block';
                                avatarPreview.textContent = '';
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
            
            // Form validation
            const avatarForm = document.getElementById('avatarForm');
            avatarForm.addEventListener('submit', function(event) {
                if (!avatarUpload.files || avatarUpload.files.length === 0) {
                    event.preventDefault();
                    alert('Please select a file to upload');
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
  <title>Change Avatar</title>
   <link rel="stylesheet" href="../../../public/css/ProfileManagement/ChangeAvator.css">
</head>
<body>
<div class="container mt-5">
  <h2>Change Avatar</h2>
  <form enctype="multipart/form-data">
    <div class="mb-3">
      <label for="avatarUpload" class="form-label">Upload New Avatar</label>
      <input type="file" class="form-control" id="avatarUpload">
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
    <a href="../../../app/views/ProfileManagement/EditProfile.php" class="btn btn-outline-secondary">Back</a>
  </form>
</div>
<script src="../../../public/js/ProfileManagement.js" ></script>
</body>
</html>

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc

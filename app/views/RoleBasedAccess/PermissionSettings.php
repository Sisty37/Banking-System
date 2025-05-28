<?php
session_start();
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
<<<<<<< HEAD
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
require_once __DIR__ . '/../../models/RoleModel.php';
$roleModel = new RoleModel();
$roles = $roleModel->getAllRoles();
$permissions = $roleModel->getAllPermissions();
$rolePermissions = $roleModel->getAllRolePermissions();
$message = '';
$messageType = '';
=======

$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;

require_once __DIR__ . '/../../models/RoleModel.php';
$roleModel = new RoleModel();

$roles = $roleModel->getAllRoles();
$permissions = $roleModel->getAllPermissions();
$rolePermissions = $roleModel->getAllRolePermissions();

$message = '';
$messageType = '';

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_role':
                $roleName = $_POST['role_name'] ?? '';
                $description = $_POST['description'] ?? '';
<<<<<<< HEAD
=======
                
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                if (!empty($roleName)) {
                    $result = $roleModel->createRole($roleName, $description);
                    if ($result['success']) {
                        $message = "Role created successfully.";
                        $messageType = "success";
                        $roles = $roleModel->getAllRoles();
                    } else {
                        $message = $result['message'];
                        $messageType = "danger";
                    }
                } else {
                    $message = "Role name is required.";
                    $messageType = "danger";
                }
                break;
<<<<<<< HEAD
=======
                
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
            case 'update_role':
                $roleId = $_POST['role_id'] ?? '';
                $roleName = $_POST['role_name'] ?? '';
                $description = $_POST['description'] ?? '';
<<<<<<< HEAD
=======
                
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                if (!empty($roleId) && !empty($roleName)) {
                    $result = $roleModel->updateRole($roleId, $roleName, $description);
                    if ($result['success']) {
                        $message = "Role updated successfully.";
                        $messageType = "success";
                        $roles = $roleModel->getAllRoles();
                    } else {
                        $message = $result['message'];
                        $messageType = "danger";
                    }
                } else {
                    $message = "Role ID and name are required.";
                    $messageType = "danger";
                }
                break;
<<<<<<< HEAD
            case 'delete_role':
                $roleId = $_POST['role_id'] ?? '';
=======
                
            case 'delete_role':
                $roleId = $_POST['role_id'] ?? '';
                
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                if (!empty($roleId)) {
                    if ($roleId <= 6) {
                        $message = "Cannot delete default system roles.";
                        $messageType = "warning";
                    } else {
                        $result = $roleModel->deleteRole($roleId);
                        if ($result) {
                            $message = "Role deleted successfully.";
                            $messageType = "success";
                            $roles = $roleModel->getAllRoles();
                        } else {
                            $message = "Failed to delete role.";
                            $messageType = "danger";
                        }
                    }
                } else {
                    $message = "Role ID is required.";
                    $messageType = "danger";
                }
                break;
<<<<<<< HEAD
            case 'update_permissions':
                $roleId = $_POST['role_id'] ?? '';
                $permissionIds = $_POST['permissions'] ?? [];
=======
                
            case 'update_permissions':
                $roleId = $_POST['role_id'] ?? '';
                $permissionIds = $_POST['permissions'] ?? [];
                
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                if (!empty($roleId)) {
                    $result = $roleModel->updateRolePermissions($roleId, $permissionIds);
                    if ($result) {
                        $message = "Permissions updated successfully.";
                        $messageType = "success";
                        $rolePermissions = $roleModel->getAllRolePermissions();
                    } else {
                        $message = "Failed to update permissions.";
                        $messageType = "danger";
                    }
                } else {
                    $message = "Role ID is required.";
                    $messageType = "danger";
                }
                break;
<<<<<<< HEAD
            case 'add_permission':
                $permissionName = $_POST['permission_name'] ?? '';
                $description = $_POST['description'] ?? '';
=======
                
            case 'add_permission':
                $permissionName = $_POST['permission_name'] ?? '';
                $description = $_POST['description'] ?? '';
                
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                if (!empty($permissionName)) {
                    $result = $roleModel->createPermission($permissionName, $description);
                    if ($result['success']) {
                        $message = "Permission created successfully.";
                        $messageType = "success";
                        $permissions = $roleModel->getAllPermissions();
                    } else {
                        $message = $result['message'];
                        $messageType = "danger";
                    }
                } else {
                    $message = "Permission name is required.";
                    $messageType = "danger";
                }
                break;
<<<<<<< HEAD
            case 'delete_permission':
                $permissionId = $_POST['permission_id'] ?? '';
=======
                
            case 'delete_permission':
                $permissionId = $_POST['permission_id'] ?? '';
                
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                if (!empty($permissionId)) {
                    $result = $roleModel->deletePermission($permissionId);
                    if ($result) {
                        $message = "Permission deleted successfully.";
                        $messageType = "success";
                        $permissions = $roleModel->getAllPermissions();
                        $rolePermissions = $roleModel->getAllRolePermissions();
                    } else {
                        $message = "Failed to delete permission.";
                        $messageType = "danger";
                    }
                } else {
                    $message = "Permission ID is required.";
                    $messageType = "danger";
                }
                break;
        }
    }
}
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
$formattedRolePermissions = [];
foreach ($rolePermissions as $rp) {
    $formattedRolePermissions[$rp['role_id']][] = $rp['permission_id'];
}
?>
<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role & Permission Management - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Permission Settings specific styles */
        .permission-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }
        
        .permission-card-header {
            padding: 15px 20px;
            background-color: var(--card-header-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .permission-card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-color-primary);
            display: flex;
            align-items: center;
        }
        
        .permission-card-body {
            padding: 20px;
        }
        
        .permission-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .permission-table th {
            background-color: var(--table-header-bg);
            color: var(--text-color-primary);
            font-weight: 600;
            text-align: left;
            padding: 12px 15px;
            border-bottom: 2px solid var(--border-color);
        }
        
        .permission-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color-primary);
        }
        
        .permission-table tr:hover {
            background-color: var(--table-hover-bg);
        }
        
        .permission-table tr:last-child td {
            border-bottom: none;
        }
        
        .permission-table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .permission-btn {
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
            margin-right: 5px;
        }
        
        .permission-btn:last-child {
            margin-right: 0;
        }
        
        .permission-btn:hover {
            transform: scale(1.05);
        }
        
        .permission-btn:active {
            transform: scale(0.95);
        }
        
        .permission-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .permission-btn-primary:hover {
            background-color: var(--primary-color-hover);
        }
        
        .permission-btn-info {
            background-color: var(--info-color);
            color: white;
        }
        
        .permission-btn-info:hover {
            background-color: var(--info-color-hover);
        }
        
        .permission-btn-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        .permission-btn-danger:hover {
            background-color: var(--danger-color-hover);
        }
        
        .permission-btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .permission-btn-secondary:hover {
            background-color: var(--secondary-color-hover);
        }
        
        .permission-icon {
            margin-right: 8px;
            font-size: 1.1em;
        }
        
        .permission-alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            border-left: 4px solid transparent;
            position: relative;
        }
        
        .permission-alert.success {
            background-color: rgba(var(--success-color-rgb), 0.1);
            border-color: var(--success-color);
            color: var(--success-color);
        }
        
        .permission-alert.danger {
            background-color: rgba(var(--danger-color-rgb), 0.1);
            border-color: var(--danger-color);
            color: var(--danger-color);
        }
        
        .permission-alert.warning {
            background-color: rgba(var(--warning-color-rgb), 0.1);
            border-color: var(--warning-color);
            color: var(--warning-color);
        }
        
        .permission-alert-close {
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
        
        .permission-alert-close:hover {
            opacity: 1;
        }
        
        .permission-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .permission-badge-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        /* Modal styles */
        .permission-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: auto;
            backdrop-filter: blur(3px);
        }
        
        .permission-modal.show {
            display: block;
        }
        
        .permission-modal-dialog {
            max-width: 500px;
            margin: 50px auto;
            position: relative;
        }
        
        .permission-modal-dialog.modal-lg {
            max-width: 800px;
        }
        
        .permission-modal-content {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }
        
        .permission-modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--card-header-bg);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .permission-modal-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-color-primary);
        }
        
        .permission-modal-body {
            padding: 20px;
            color: var(--text-color-primary);
        }
        
        .permission-modal-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .permission-modal-close {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            color: var(--text-color-secondary);
            background: transparent;
            border: 0;
            cursor: pointer;
            padding: 0;
            margin: 0;
        }
        
        .permission-modal-close:hover {
            color: var(--text-color-primary);
        }
        
        /* Form styles */
        .permission-form-group {
            margin-bottom: 1rem;
        }
        
        .permission-form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-color-primary);
        }
        
        .permission-form-control {
            width: 100%;
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color-primary);
            transition: all 0.3s ease;
        }
        
        .permission-form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        .permission-form-text {
            font-size: 0.85rem;
            color: var(--text-color-secondary);
            margin-top: 0.25rem;
        }
        
        .permission-form-check {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .permission-checkbox {
            position: relative;
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        
        .permission-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .permission-checkbox-mark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 3px;
            transition: all 0.2s ease;
        }
        
        .permission-checkbox input:checked ~ .permission-checkbox-mark {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .permission-checkbox-mark:after {
            content: "";
            position: absolute;
            display: none;
        }
        
        .permission-checkbox input:checked ~ .permission-checkbox-mark:after {
            display: block;
        }
        
        .permission-checkbox .permission-checkbox-mark:after {
            left: 7px;
            top: 3px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .permission-checkbox-label {
            font-weight: 400;
            color: var(--text-color-primary);
        }
        
        /* Utility classes */
        .fw-bold {
            font-weight: 600;
        }
        
        .deletion-highlight {
            background-color: rgba(var(--danger-color-rgb), 0.1) !important;
            transition: background-color 0.3s ease;
            border-left: 4px solid var(--danger-color) !important;
        }
        
        .permission-btn-danger-flash {
            animation: permission-danger-flash 1s infinite;
        }
        
        @keyframes permission-danger-flash {
            0% { background-color: var(--danger-color); }
            50% { background-color: var(--danger-color-hover); }
            100% { background-color: var(--danger-color); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; height: 0; padding: 0; }
        }
        
        .row-deleting {
            animation: fadeOut 0.5s forwards;
        }
        
        /* Dark mode overrides */
        .dark-mode .permission-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .dark-mode .permission-modal-content {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
        }
        
        /* Grid System */
        .permission-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        
        .permission-col {
            flex: 1 0 0%;
            padding-right: 15px;
            padding-left: 15px;
            max-width: 100%;
        }
        
        .permission-col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding-right: 15px;
            padding-left: 15px;
        }
        
        .permission-col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }
        
        @media (max-width: 768px) {
            .permission-col-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .permission-modal-dialog {
                margin: 20px;
            }
        }
    </style>
=======

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role & Permission Management - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
</head>
<body>
    <div class="container-fluid">
        <div class="row">
<<<<<<< HEAD
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-header">
                    <h4 class="text-white">Banking System</h4>
                    <p class="text-white-50">Admin Portal</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/admin_dashboard.php">
                            <span class="nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Dashboard/user_management.php">
                            <span class="nav-icon">👥</span> User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">🔐</span> Roles & Permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-icon">📝</span> Transaction Log
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-icon">📈</span> System Analytics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
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
                <div class="content-header">
                    <h1>Role & Permission Management</h1>
                    <div class="user-badge">
                        <span class="permission-badge permission-badge-danger">Administrator</span>
                        <span class="user-name">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
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
                <div class="permission-alert <?php echo $messageType; ?>" id="alertMessage">
                    <?php echo $message; ?>
                    <button type="button" class="permission-alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
                <?php endif; ?>
                <!-- Role Management Section -->
                <div class="permission-row">
                    <div class="permission-col-12">
                        <div class="permission-card">
                            <div class="permission-card-header">
                                <h5><span class="permission-icon">🔐</span> Role Management</h5>
                                <button type="button" class="permission-btn permission-btn-primary" onclick="openModal('addRoleModal')">
                                    <span class="permission-icon">➕</span> Add New Role
                                </button>
                            </div>
                            <div class="permission-card-body">
                                <div class="permission-table-responsive">
                                    <table id="rolesTable" class="permission-table">
=======
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/admin_dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/user_management.php">
                                <i class="fas fa-users me-2"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
                                <i class="fas fa-user-shield me-2"></i> Roles & Permissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Log
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-chart-line me-2"></i> System Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
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
                    <h1 class="h2">Role & Permission Management</h1>
                    <div>
                        <span class="badge bg-danger">Administrator</span>
                        <span class="ms-2">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Role Management</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                                    <i class="fas fa-plus"></i> Add New Role
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="rolesTable" class="table table-striped table-hover">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Role Name</th>
                                                <th>Description</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($roles): ?>
                                                <?php foreach ($roles as $role): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($role['role_id']); ?></td>
                                                        <td><?php echo htmlspecialchars($role['role_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($role['description'] ?? ''); ?></td>
                                                        <td><?php echo date('Y-m-d', strtotime($role['created_at'])); ?></td>
                                                        <td>
<<<<<<< HEAD
                                                            <div class="btn-actions">
                                                                <button type="button" class="permission-btn permission-btn-info" 
                                                                    onclick="editRole(<?php echo $role['role_id']; ?>, '<?php echo htmlspecialchars(addslashes($role['role_name'])); ?>', '<?php echo htmlspecialchars(addslashes($role['description'] ?? '')); ?>')">
                                                                    <span class="permission-icon">✏️</span>
                                                                </button>
                                                                <button type="button" class="permission-btn permission-btn-primary" 
                                                                    onclick="managePermissions(<?php echo $role['role_id']; ?>, '<?php echo htmlspecialchars(addslashes($role['role_name'])); ?>')">
                                                                    <span class="permission-icon">🔑</span>
                                                                </button>
                                                                <?php if ($role['role_id'] > 6): ?>
                                                                    <button type="button" class="permission-btn permission-btn-danger" 
                                                                        onclick="deleteRole(<?php echo $role['role_id']; ?>, '<?php echo htmlspecialchars(addslashes($role['role_name'])); ?>')">
                                                                        <span class="permission-icon">🗑️</span>
=======
                                                            <div class="btn-group btn-group-sm">
                                                                <button type="button" class="btn btn-info edit-role" data-bs-toggle="modal" data-bs-target="#editRoleModal" 
                                                                    data-role-id="<?php echo $role['role_id']; ?>"
                                                                    data-role-name="<?php echo htmlspecialchars($role['role_name']); ?>"
                                                                    data-description="<?php echo htmlspecialchars($role['description'] ?? ''); ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary manage-permissions" data-bs-toggle="modal" data-bs-target="#managePermissionsModal"
                                                                    data-role-id="<?php echo $role['role_id']; ?>"
                                                                    data-role-name="<?php echo htmlspecialchars($role['role_name']); ?>">
                                                                    <i class="fas fa-key"></i>
                                                                </button>
                                                                <?php if ($role['role_id'] > 6): ?>
                                                                    <button type="button" class="btn btn-danger delete-role" data-bs-toggle="modal" data-bs-target="#deleteRoleModal"
                                                                        data-role-id="<?php echo $role['role_id']; ?>"
                                                                        data-role-name="<?php echo htmlspecialchars($role['role_name']); ?>">
                                                                        <i class="fas fa-trash"></i>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No roles found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                <!-- Permission Management Section -->
                <div class="permission-row">
                    <div class="permission-col-12">
                        <div class="permission-card">
                            <div class="permission-card-header">
                                <h5><span class="permission-icon">🔑</span> Permission Management</h5>
                                <button type="button" class="permission-btn permission-btn-primary" onclick="openModal('addPermissionModal')">
                                    <span class="permission-icon">➕</span> Add New Permission
                                </button>
                            </div>
                            <div class="permission-card-body">
                                <div class="permission-table-responsive">
                                    <table id="permissionsTable" class="permission-table">
=======
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Permission Management</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                                    <i class="fas fa-plus"></i> Add New Permission
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="permissionsTable" class="table table-striped table-hover">
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Permission Name</th>
                                                <th>Description</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($permissions): ?>
                                                <?php foreach ($permissions as $permission): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($permission['permission_id']); ?></td>
                                                        <td><?php echo htmlspecialchars($permission['permission_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($permission['description'] ?? ''); ?></td>
                                                        <td><?php echo date('Y-m-d', strtotime($permission['created_at'])); ?></td>
                                                        <td>
<<<<<<< HEAD
                                                            <div class="btn-actions">
                                                                <button type="button" class="permission-btn permission-btn-danger" 
                                                                    onclick="deletePermission(<?php echo $permission['permission_id']; ?>, '<?php echo htmlspecialchars(addslashes($permission['permission_name'])); ?>')">
                                                                    <span class="permission-icon">🗑️</span>
=======
                                                            <div class="btn-group btn-group-sm">
                                                                <button type="button" class="btn btn-danger delete-permission" data-bs-toggle="modal" data-bs-target="#deletePermissionModal"
                                                                    data-permission-id="<?php echo $permission['permission_id']; ?>"
                                                                    data-permission-name="<?php echo htmlspecialchars($permission['permission_name']); ?>">
                                                                    <i class="fas fa-trash"></i>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No permissions found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    <!-- Add Role Modal -->
    <div class="permission-modal" id="addRoleModal">
        <div class="permission-modal-dialog">
            <div class="permission-modal-content">
                <div class="permission-modal-header">
                    <h5 class="permission-modal-title">Add New Role</h5>
                    <button type="button" class="permission-modal-close" onclick="closeModal('addRoleModal')">&times;</button>
                </div>
                <form method="post">
                    <div class="permission-modal-body">
                        <input type="hidden" name="action" value="add_role">
                        <div class="permission-form-group">
                            <label for="roleName" class="permission-form-label">Role Name</label>
                            <input type="text" class="permission-form-control" id="roleName" name="role_name" required>
                        </div>
                        <div class="permission-form-group">
                            <label for="roleDescription" class="permission-form-label">Description</label>
                            <textarea class="permission-form-control" id="roleDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="permission-modal-footer">
                        <button type="button" class="permission-btn permission-btn-secondary" onclick="closeModal('addRoleModal')">Cancel</button>
                        <button type="submit" class="permission-btn permission-btn-primary">Add Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Role Modal -->
    <div class="permission-modal" id="editRoleModal">
        <div class="permission-modal-dialog">
            <div class="permission-modal-content">
                <div class="permission-modal-header">
                    <h5 class="permission-modal-title">Edit Role</h5>
                    <button type="button" class="permission-modal-close" onclick="closeModal('editRoleModal')">&times;</button>
                </div>
                <form method="post">
                    <div class="permission-modal-body">
                        <input type="hidden" name="action" value="update_role">
                        <input type="hidden" name="role_id" id="editRoleId">
                        <div class="permission-form-group">
                            <label for="editRoleName" class="permission-form-label">Role Name</label>
                            <input type="text" class="permission-form-control" id="editRoleName" name="role_name" required>
                        </div>
                        <div class="permission-form-group">
                            <label for="editRoleDescription" class="permission-form-label">Description</label>
                            <textarea class="permission-form-control" id="editRoleDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="permission-modal-footer">
                        <button type="button" class="permission-btn permission-btn-secondary" onclick="closeModal('editRoleModal')">Cancel</button>
                        <button type="submit" class="permission-btn permission-btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Role Modal -->
    <div class="modal" id="deleteRoleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Role</h5>
                    <button type="button" class="btn-close" onclick="closeModal('deleteRoleModal')"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the role <span id="deleteRoleName" class="fw-bold"></span>?</p>
                    <p class="text-danger">This will also remove all permissions associated with this role.</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i> This action cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="post" id="deleteRoleForm">
                        <input type="hidden" name="action" value="delete_role">
                        <input type="hidden" name="role_id" id="deleteRoleId">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('deleteRoleModal')">Cancel</button>
                        <button type="button" class="btn btn-danger" id="deleteRoleConfirmBtn" onclick="confirmDelete('deleteRole')">Delete</button>
                        <button type="submit" class="btn btn-danger" id="deleteRoleSubmitBtn" style="display: none;">Delete</button>
=======
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_role">
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="roleName" name="role_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="roleDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="roleDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update_role">
                        <input type="hidden" name="role_id" id="editRoleId">
                        <div class="mb-3">
                            <label for="editRoleName" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="editRoleName" name="role_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRoleDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editRoleDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoleModalLabel">Delete Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the role <span id="deleteRoleName"></span>?</p>
                    <p class="text-danger">This will also remove all permissions associated with this role.</p>
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="action" value="delete_role">
                        <input type="hidden" name="role_id" id="deleteRoleId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                    </form>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    <!-- Manage Permissions Modal -->
    <div class="modal" id="managePermissionsModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Permissions for <span id="permissionRoleName"></span></h5>
                    <button type="button" class="btn-close" onclick="closeModal('managePermissionsModal')"></button>
=======
    <div class="modal fade" id="managePermissionsModal" tabindex="-1" aria-labelledby="managePermissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="managePermissionsModalLabel">Manage Permissions for <span id="permissionRoleName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update_permissions">
                        <input type="hidden" name="role_id" id="permissionRoleId">
                        <div class="row">
                            <?php if ($permissions): ?>
                                <?php foreach ($permissions as $permission): ?>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox" type="checkbox" 
                                                   name="permissions[]" 
                                                   value="<?php echo $permission['permission_id']; ?>" 
                                                   id="permission<?php echo $permission['permission_id']; ?>">
                                            <label class="form-check-label" for="permission<?php echo $permission['permission_id']; ?>">
                                                <?php echo htmlspecialchars($permission['permission_name']); ?>
                                                <?php if (!empty($permission['description'])): ?>
                                                    <small class="text-muted d-block"><?php echo htmlspecialchars($permission['description']); ?></small>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <p class="text-center">No permissions available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
<<<<<<< HEAD
                        <button type="button" class="btn btn-secondary" onclick="closeModal('managePermissionsModal')">Cancel</button>
=======
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                        <button type="submit" class="btn btn-primary">Save Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    <!-- Add Permission Modal -->
    <div class="modal" id="addPermissionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Permission</h5>
                    <button type="button" class="btn-close" onclick="closeModal('addPermissionModal')"></button>
=======
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPermissionModalLabel">Add New Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_permission">
                        <div class="mb-3">
                            <label for="permissionName" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" id="permissionName" name="permission_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="permissionDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="permissionDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
<<<<<<< HEAD
                        <button type="button" class="btn btn-secondary" onclick="closeModal('addPermissionModal')">Cancel</button>
=======
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
                        <button type="submit" class="btn btn-primary">Add Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    <!-- Delete Permission Modal -->
    <div class="modal" id="deletePermissionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Permission</h5>
                    <button type="button" class="btn-close" onclick="closeModal('deletePermissionModal')"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the permission <span id="deletePermissionName" class="fw-bold"></span>?</p>
                    <p class="text-danger">This will remove this permission from all roles.</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i> This action cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="post" id="deletePermissionForm">
                        <input type="hidden" name="action" value="delete_permission">
                        <input type="hidden" name="permission_id" id="deletePermissionId">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('deletePermissionModal')">Cancel</button>
                        <button type="button" class="btn btn-danger" id="deletePermissionConfirmBtn" onclick="confirmDelete('deletePermission')">Delete</button>
                        <button type="submit" class="btn btn-danger" id="deletePermissionSubmitBtn" style="display: none;">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../public/js/dashboard.js"></script>
=======
    <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePermissionModalLabel">Delete Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the permission <span id="deletePermissionName"></span>?</p>
                    <p class="text-danger">This will remove this permission from all roles.</p>
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="action" value="delete_permission">
                        <input type="hidden" name="permission_id" id="deletePermissionId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#rolesTable').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 10
            });
            $('#permissionsTable').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 10
            });
            $('.edit-role').click(function() {
                const roleId = $(this).data('role-id');
                const roleName = $(this).data('role-name');
                const description = $(this).data('description');
                $('#editRoleId').val(roleId);
                $('#editRoleName').val(roleName);
                $('#editRoleDescription').val(description);
            });
            $('.delete-role').click(function() {
                const roleId = $(this).data('role-id');
                const roleName = $(this).data('role-name');
                $('#deleteRoleId').val(roleId);
                $('#deleteRoleName').text(roleName);
            });
            $('.manage-permissions').click(function() {
                const roleId = $(this).data('role-id');
                const roleName = $(this).data('role-name');
                $('#permissionRoleId').val(roleId);
                $('#permissionRoleName').text(roleName);
                $('.permission-checkbox').prop('checked', false);
                const rolePermissions = <?php echo json_encode($formattedRolePermissions); ?>;
                if (rolePermissions[roleId]) {
                    rolePermissions[roleId].forEach(function(permissionId) {
                        $('#permission' + permissionId).prop('checked', true);
                    });
                }
            });
            $('.delete-permission').click(function() {
                const permissionId = $(this).data('permission-id');
                const permissionName = $(this).data('permission-name');
                $('#deletePermissionId').val(permissionId);
                $('#deletePermissionName').text(permissionName);
            });
        });
    </script>
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
require_once __DIR__ . '/../../models/UserModel.php';
$userModel = new UserModel();
$users = $userModel->getAllUsers();
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete':
                if (isset($_POST['user_id']) && $_POST['user_id'] != $_SESSION['user_id']) {
                    if ($userModel->deleteUser($_POST['user_id'])) {
                        $message = "User deleted successfully.";
                        $messageType = "success";
                        $users = $userModel->getAllUsers();
                    } else {
                        $message = "Failed to delete user.";
                        $messageType = "danger";
                    }
                } else {
                    $message = "Cannot delete your own account.";
                    $messageType = "warning";
                }
                break;
            case 'update_role':
                if (isset($_POST['user_id']) && isset($_POST['role_id'])) {
                    if ($userModel->updateUserRole($_POST['user_id'], $_POST['role_id'])) {
                        $message = "User role updated successfully.";
                        $messageType = "success";
                        $users = $userModel->getAllUsers();
                    } else {
                        $message = "Failed to update user role.";
                        $messageType = "danger";
                    }
                }
                break;
        }
    }
}
$roles = $userModel->getAllRoles();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* User management specific styles */
        .user-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .user-table th,
        .user-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .user-table th {
            background-color: var(--header-bg);
            font-weight: 600;
        }
        
        .user-table tr:hover {
            background-color: var(--hover-color);
        }
        
        .role-select {
            width: 100%;
            padding: 6px 10px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .user-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-active {
            background-color: var(--success-color);
            color: white;
        }
        
        .badge-inactive {
            background-color: var(--text-secondary);
            color: white;
        }
        
        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: var(--border-radius);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            margin-right: 5px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .action-view {
            background-color: var(--info-color);
            color: white;
        }
        
        .action-edit {
            background-color: var(--warning-color);
            color: white;
        }
        
        .action-delete {
            background-color: var(--danger-color);
            color: white;
        }
        
        .action-button:hover {
            opacity: 0.9;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }
        
        .modal-visible {
            display: block;
        }
        
        .modal-dialog {
            margin: 10% auto;
            width: 90%;
            max-width: 500px;
        }
        
        .modal-content {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
        }
        
        .btn-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-color);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .form-check {
            display: flex;
            align-items: center;
        }
        
        .form-check-input {
            margin-right: 8px;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 3px solid var(--border-color);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        .search-box {
            position: relative;
            margin-bottom: 20px;
        }
        
        .search-input {
            width: 100%;
            padding: 8px 12px 8px 35px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 20px 0;
            justify-content: center;
        }
        
        .pagination-item {
            margin: 0 5px;
        }
        
        .pagination-link {
            display: block;
            padding: 8px 12px;
            border-radius: var(--border-radius);
            text-decoration: none;
            color: var(--text-color);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }
        
        .pagination-link:hover {
            background-color: var(--hover-color);
        }
        
        .pagination-link.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .pagination-link.disabled {
            color: var(--text-secondary);
            pointer-events: none;
            background-color: var(--disabled-bg);
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
                        <a class="nav-link active" href="#">
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
                        <a class="nav-link" href="system_settings.php">
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
                        <h1 class="h2 mb-0">User Management</h1>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="user-dropdown">
                        <div class="user-info">
                            <div class="user-avatar" data-name="<?php echo htmlspecialchars($fullName); ?>"></div>
                            <div class="d-none d-md-block">
                                <div class="fw-bold"><?php echo htmlspecialchars($fullName); ?></div>
                                <div class="small text-muted"><?php echo htmlspecialchars($_SESSION['role'] ?? ''); ?></div>
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
                
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                </div>
                <?php endif; ?>

                <!-- User Management Tools -->
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 d-flex align-items-center">
                                <span class="nav-icon me-2">👥</span> User List
                            </h5>
                            <button type="button" class="btn btn-primary" id="addUserBtn">
                                <span class="nav-icon">➕</span> Add New User
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="search-box mb-3">
                            <span class="search-icon">🔍</span>
                            <input type="text" id="userSearchInput" class="search-input" placeholder="Search users...">
                        </div>
                        <div class="table-responsive">
                            <table id="usersTable" class="user-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($users): ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr data-user-name="<?php echo htmlspecialchars(strtolower($user['first_name'] . ' ' . $user['last_name'])); ?>" 
                                                data-user-email="<?php echo htmlspecialchars(strtolower($user['email'])); ?>">
                                                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                                <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td>
                                                    <form method="post" class="role-form">
                                                        <input type="hidden" name="action" value="update_role">
                                                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                        <select name="role_id" class="role-select" <?php echo ($user['user_id'] == $_SESSION['user_id']) ? 'disabled' : ''; ?>>
                                                            <?php foreach ($roles as $role): ?>
                                                                <option value="<?php echo $role['role_id']; ?>" <?php echo ($user['role_name'] == $role['role_name']) ? 'selected' : ''; ?>>
                                                                    <?php echo htmlspecialchars($role['role_name']); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td>
                                                    <?php if ($user['is_active']): ?>
                                                        <span class="user-badge badge-active">Active</span>
                                                    <?php else: ?>
                                                        <span class="user-badge badge-inactive">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo date('Y-m-d', strtotime($user['created_at'])); ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <button type="button" class="action-button action-view view-user" 
                                                                data-user-id="<?php echo $user['user_id']; ?>">
                                                            👁️
                                                        </button>
                                                        <button type="button" class="action-button action-edit edit-user" 
                                                                data-user-id="<?php echo $user['user_id']; ?>">
                                                            ✏️
                                                        </button>
                                                        <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                                                            <button type="button" class="action-button action-delete delete-user" 
                                                                    data-user-id="<?php echo $user['user_id']; ?>" 
                                                                    data-user-name="<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>">
                                                                🗑️
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No users found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination" class="mt-4">
                            <ul class="pagination">
                                <li class="pagination-item">
                                    <a href="#" class="pagination-link" id="prevPage">«</a>
                                </li>
                                <li class="pagination-item">
                                    <span class="pagination-link active" id="currentPage">1</span>
                                </li>
                                <li class="pagination-item">
                                    <a href="#" class="pagination-link" id="nextPage">»</a>
                                </li>
                            </ul>
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

    <!-- Add User Modal -->
    <div class="modal" id="addUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" id="addUserCloseBtn">×</button>
                </div>
                <form action="../../controllers/UserManagement/AddUser.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role_id" required>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['role_id']; ?>"><?php echo htmlspecialchars($role['role_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="addUserCancelBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal" id="viewUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="btn-close" id="viewUserCloseBtn">×</button>
                </div>
                <div class="modal-body">
                    <div id="userDetails">
                        <!-- User details will be loaded here -->
                        <div class="text-center">
                            <div class="loading-spinner"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="viewUserCancelBtn">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="editUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" id="editUserCloseBtn">×</button>
                </div>
                <form action="../../controllers/UserManagement/UpdateUser.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="edit-user-id">
                        <div class="form-group">
                            <label for="editFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="editLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editDob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="editDob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-control" id="editRole" name="role_id" required>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['role_id']; ?>"><?php echo htmlspecialchars($role['role_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="editActive" name="is_active" value="1">
                            <label class="form-check-label" for="editActive">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="editUserCancelBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal" id="deleteUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                    <button type="button" class="btn-close" id="deleteUserCloseBtn">×</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <span id="delete-user-name"></span>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="user_id" id="delete-user-id">
                        <button type="button" class="btn btn-secondary" id="deleteUserCancelBtn">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
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

            // Custom search functionality
            const searchInput = document.getElementById('userSearchInput');
            const tableRows = document.querySelectorAll('#usersTable tbody tr');
            
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                tableRows.forEach(row => {
                    const userName = row.getAttribute('data-user-name');
                    const userEmail = row.getAttribute('data-user-email');
                    
                    if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            // Modal functionality
            const modals = document.querySelectorAll('.modal');
            
            // Add User Modal
            const addUserBtn = document.getElementById('addUserBtn');
            const addUserModal = document.getElementById('addUserModal');
            const addUserCloseBtn = document.getElementById('addUserCloseBtn');
            const addUserCancelBtn = document.getElementById('addUserCancelBtn');
            
            addUserBtn.addEventListener('click', function() {
                addUserModal.classList.add('modal-visible');
            });
            
            addUserCloseBtn.addEventListener('click', function() {
                addUserModal.classList.remove('modal-visible');
            });
            
            addUserCancelBtn.addEventListener('click', function() {
                addUserModal.classList.remove('modal-visible');
            });
            
            // View User Modal
            const viewUserBtns = document.querySelectorAll('.view-user');
            const viewUserModal = document.getElementById('viewUserModal');
            const viewUserCloseBtn = document.getElementById('viewUserCloseBtn');
            const viewUserCancelBtn = document.getElementById('viewUserCancelBtn');
            const userDetails = document.getElementById('userDetails');
            
            viewUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    userDetails.innerHTML = '<div class="text-center"><div class="loading-spinner"></div></div>';
                    viewUserModal.classList.add('modal-visible');
                    
                    // Fetch user details
                    fetch(`../../controllers/UserManagement/GetUserDetails.php?user_id=${userId}`)
                        .then(response => response.text())
                        .then(html => {
                            userDetails.innerHTML = html;
                        })
                        .catch(error => {
                            userDetails.innerHTML = '<div class="alert alert-danger">Error loading user details</div>';
                        });
                });
            });
            
            viewUserCloseBtn.addEventListener('click', function() {
                viewUserModal.classList.remove('modal-visible');
            });
            
            viewUserCancelBtn.addEventListener('click', function() {
                viewUserModal.classList.remove('modal-visible');
            });
            
            // Edit User Modal
            const editUserBtns = document.querySelectorAll('.edit-user');
            const editUserModal = document.getElementById('editUserModal');
            const editUserCloseBtn = document.getElementById('editUserCloseBtn');
            const editUserCancelBtn = document.getElementById('editUserCancelBtn');
            
            editUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    editUserModal.classList.add('modal-visible');
                    
                    // Fetch user data
                    fetch(`../../controllers/UserManagement/GetUserData.php?user_id=${userId}`)
                        .then(response => response.json())
                        .then(user => {
                            document.getElementById('edit-user-id').value = user.user_id;
                            document.getElementById('editFirstName').value = user.first_name;
                            document.getElementById('editLastName').value = user.last_name;
                            document.getElementById('editEmail').value = user.email;
                            document.getElementById('editDob').value = user.date_of_birth;
                            document.getElementById('editRole').value = user.role_id;
                            document.getElementById('editActive').checked = user.is_active == 1;
                        })
                        .catch(error => {
                            alert('Error loading user data');
                        });
                });
            });
            
            editUserCloseBtn.addEventListener('click', function() {
                editUserModal.classList.remove('modal-visible');
            });
            
            editUserCancelBtn.addEventListener('click', function() {
                editUserModal.classList.remove('modal-visible');
            });
            
            // Delete User Modal
            const deleteUserBtns = document.querySelectorAll('.delete-user');
            const deleteUserModal = document.getElementById('deleteUserModal');
            const deleteUserCloseBtn = document.getElementById('deleteUserCloseBtn');
            const deleteUserCancelBtn = document.getElementById('deleteUserCancelBtn');
            
            deleteUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const userName = this.getAttribute('data-user-name');
                    
                    document.getElementById('delete-user-id').value = userId;
                    document.getElementById('delete-user-name').textContent = userName;
                    deleteUserModal.classList.add('modal-visible');
                });
            });
            
            deleteUserCloseBtn.addEventListener('click', function() {
                deleteUserModal.classList.remove('modal-visible');
            });
            
            deleteUserCancelBtn.addEventListener('click', function() {
                deleteUserModal.classList.remove('modal-visible');
            });
            
            // Role select change
            const roleSelects = document.querySelectorAll('.role-select');
            roleSelects.forEach(select => {
                select.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            });
            
            // Close modals when clicking outside
            window.addEventListener('click', function(event) {
                modals.forEach(modal => {
                    if (event.target === modal) {
                        modal.classList.remove('modal-visible');
                    }
                });
            });

            // Pagination functionality
            const rowsPerPage = 10;
            let currentPage = 1;
            const totalRows = tableRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            
            const prevPageBtn = document.getElementById('prevPage');
            const nextPageBtn = document.getElementById('nextPage');
            const currentPageSpan = document.getElementById('currentPage');
            
            function updatePagination() {
                currentPageSpan.textContent = currentPage;
                
                if (currentPage === 1) {
                    prevPageBtn.classList.add('disabled');
                } else {
                    prevPageBtn.classList.remove('disabled');
                }
                
                if (currentPage === totalPages) {
                    nextPageBtn.classList.add('disabled');
                } else {
                    nextPageBtn.classList.remove('disabled');
                }
                
                // Show relevant rows
                tableRows.forEach((row, index) => {
                    if (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            
            prevPageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                }
            });
            
            nextPageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                }
            });
            
            // Initialize pagination
            updatePagination();
        });
    </script>
</body>
</html> 
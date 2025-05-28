<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once __DIR__ . '/../../appInitializer.php';
if (!isLoggedIn()) {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}
$userId = $_SESSION['user_id'] ?? 0;
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;
$userRole = $_SESSION['role_name'] ?? 'Customer';

// Dummy data for beneficiaries - in a real app, this would come from a database
$beneficiaries = [
    ['name' => 'Jane Doe', 'account' => '222334455'],
    ['name' => 'John Smith', 'account' => '554433221']
];

// Handle form submission (in a real app, this would save to a database)
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_beneficiary'])) {
    $name = $_POST['beneficiary_name'] ?? '';
    $account = $_POST['beneficiary_account'] ?? '';
    
    if (empty($name) || empty($account)) {
        $message = 'Please fill in all required fields.';
        $messageType = 'danger';
    } else {
        $message = "Beneficiary $name has been added successfully.";
        $messageType = 'success';
        // In a real app, this would insert into the database
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiary Manager - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Beneficiary Manager specific styles */
        .beneficiary-card {
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .beneficiary-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            font-weight: 600;
            background-color: var(--primary-color);
            color: white;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
        }
        
        .beneficiary-card-body {
            padding: 20px;
            background-color: var(--card-bg);
            border-bottom-left-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
        }
        
        .beneficiary-form-group {
            margin-bottom: 20px;
        }
        
        .beneficiary-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        .beneficiary-form-input {
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .beneficiary-form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        .beneficiary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .beneficiary-btn-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .beneficiary-btn-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        .beneficiary-btn:hover {
            opacity: 0.9;
        }
        
        .beneficiary-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .beneficiary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
        }
        
        .beneficiary-item:last-child {
            border-bottom: none;
        }
        
        .beneficiary-item:hover {
            background-color: var(--hover-color);
        }
        
        .beneficiary-details {
            display: flex;
            align-items: center;
        }
        
        .beneficiary-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            font-size: 18px;
            margin-right: 12px;
        }
        
        .beneficiary-name {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .beneficiary-account {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        
        .no-beneficiaries {
            padding: 20px;
            text-align: center;
            color: var(--text-secondary);
            font-style: italic;
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
                    <li class="nav-item">
                        <a class="nav-link" href="../FundTransfers/TransferFunds.php">
                            <span class="nav-icon">💸</span> Transfer Funds
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">👥</span> Beneficiary Manager
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../AccountDashboard/PayBill.php">
                            <span class="nav-icon">📄</span> Pay Bills
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../notifications/notificationCenter.php">
                            <span class="nav-icon">🔔</span> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../DataExport/exportWizard.php">
                            <span class="nav-icon">📤</span> Export Data
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
                        <h1 class="h2 mb-0">Beneficiary Manager</h1>
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
                
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <!-- Add Beneficiary Form -->
                        <div class="beneficiary-card mb-4">
                            <div class="beneficiary-card-header">
                                <span class="nav-icon me-2">➕</span> Add New Beneficiary
                            </div>
                            <div class="beneficiary-card-body">
                                <form method="POST" action="">
                                    <div class="beneficiary-form-group">
                                        <label for="beneficiary_name" class="beneficiary-form-label">Beneficiary Name</label>
                                        <input type="text" class="beneficiary-form-input" id="beneficiary_name" name="beneficiary_name" required>
                                    </div>
                                    <div class="beneficiary-form-group">
                                        <label for="beneficiary_account" class="beneficiary-form-label">Account Number</label>
                                        <input type="text" class="beneficiary-form-input" id="beneficiary_account" name="beneficiary_account" required>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" name="add_beneficiary" class="beneficiary-btn beneficiary-btn-success">
                                            <span class="nav-icon me-2">✅</span> Add Beneficiary
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Beneficiary List -->
                        <div class="beneficiary-card">
                            <div class="beneficiary-card-header">
                                <span class="nav-icon me-2">👥</span> Saved Beneficiaries
                            </div>
                            <div class="beneficiary-card-body">
                                <?php if (empty($beneficiaries)): ?>
                                <div class="no-beneficiaries">
                                    You haven't added any beneficiaries yet.
                                </div>
                                <?php else: ?>
                                <ul class="beneficiary-list">
                                    <?php foreach ($beneficiaries as $beneficiary): ?>
                                    <li class="beneficiary-item">
                                        <div class="beneficiary-details">
                                            <div class="beneficiary-icon">
                                                <?php echo substr($beneficiary['name'], 0, 1); ?>
                                            </div>
                                            <div>
                                                <div class="beneficiary-name"><?php echo htmlspecialchars($beneficiary['name']); ?></div>
                                                <div class="beneficiary-account"><?php echo htmlspecialchars($beneficiary['account']); ?></div>
                                            </div>
                                        </div>
                                        <button type="button" class="beneficiary-btn beneficiary-btn-danger">
                                            <span class="nav-icon">🗑️</span>
                                        </button>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
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
            
            // Alert dismissal
            const alertCloseButton = document.querySelector('.alert .btn-close');
            if (alertCloseButton) {
                alertCloseButton.addEventListener('click', function() {
                    this.parentElement.style.display = 'none';
                });
            }
            
            // Remove beneficiary functionality
            const removeButtons = document.querySelectorAll('.beneficiary-btn-danger');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove this beneficiary?')) {
                        const listItem = this.closest('.beneficiary-item');
                        const beneficiaryName = listItem.querySelector('.beneficiary-name').textContent;
                        
                        // In a real app, this would send an AJAX request to remove from database
                        // For this demo, we'll just remove from DOM
                        listItem.remove();
                        
                        // Show a temporary alert message
                        const alertHtml = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Beneficiary ${beneficiaryName} has been removed successfully.
                                <button type="button" class="btn-close" onclick="this.parentElement.remove();">×</button>
                            </div>
                        `;
                        document.querySelector('.main-content').insertAdjacentHTML('afterbegin', alertHtml);
                        
                        // If no beneficiaries left, show empty message
                        const remainingItems = document.querySelectorAll('.beneficiary-item');
                        if (remainingItems.length === 0) {
                            const beneficiaryList = document.querySelector('.beneficiary-list');
                            beneficiaryList.innerHTML = `
                                <div class="no-beneficiaries">
                                    You haven't added any beneficiaries yet.
                                </div>
                            `;
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>

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

// Handle form submission
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_transfer'])) {
    $startDate = $_POST['start_date'] ?? '';
    $frequency = $_POST['frequency'] ?? '';
    $endDate = $_POST['end_date'] ?? '';
    
    if (empty($startDate) || empty($frequency)) {
        $message = 'Please fill in all required fields.';
        $messageType = 'danger';
    } else {
        $message = "Transfer has been scheduled successfully starting from $startDate.";
        $messageType = 'success';
        // In a real app, this would save to database
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Transfer - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../../public/css/custom.css">
    <link rel="stylesheet" href="../../../public/css/dark-mode.css">
    <style>
        /* Schedule Tool specific styles */
        .schedule-card {
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
        }
        
        .schedule-card-header {
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
        
        .schedule-card-body {
            padding: 25px;
        }
        
        .schedule-form-group {
            margin-bottom: 20px;
        }
        
        .schedule-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        .schedule-form-input {
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
        }
        
        .schedule-form-select {
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            color: var(--text-color);
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
        }
        
        .schedule-form-input:focus,
        .schedule-form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        }
        
        .schedule-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .schedule-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .schedule-btn:hover {
            opacity: 0.9;
        }
        
        .schedule-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
        
        .schedule-info {
            margin-top: 25px;
            padding: 15px;
            border-radius: var(--border-radius);
            background-color: rgba(var(--info-color-rgb), 0.1);
            border-left: 4px solid var(--info-color);
        }
        
        .schedule-info-title {
            font-weight: 600;
            color: var(--info-color);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        
        .schedule-info-text {
            color: var(--text-color);
            font-size: 0.9rem;
            margin-bottom: 0;
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
                        <a class="nav-link" href="BeneficiaryManager.php">
                            <span class="nav-icon">👥</span> Beneficiary Manager
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span class="nav-icon">🗓️</span> Schedule Transfer
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
                        <h1 class="h2 mb-0">Schedule a Transfer</h1>
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
                        <!-- Schedule Transfer Form -->
                        <div class="schedule-card mb-4">
                            <div class="schedule-card-header">
                                <span class="nav-icon me-2">🗓️</span> Schedule Transfer Details
                            </div>
                            <div class="schedule-card-body">
                                <form method="POST" action="">
                                    <div class="schedule-form-group">
                                        <label for="start_date" class="schedule-form-label">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" class="schedule-form-input" id="start_date" name="start_date" required min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    
                                    <div class="schedule-form-group">
                                        <label for="frequency" class="schedule-form-label">Frequency <span class="text-danger">*</span></label>
                                        <select class="schedule-form-select" id="frequency" name="frequency" required>
                                            <option value="">Select Frequency</option>
                                            <option value="once">One Time</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="biweekly">Bi-weekly</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="quarterly">Quarterly</option>
                                            <option value="annually">Annually</option>
                                        </select>
                                    </div>
                                    
                                    <div class="schedule-form-group">
                                        <label for="end_date" class="schedule-form-label">End Date <small class="text-muted">(Optional for recurring transfers)</small></label>
                                        <input type="date" class="schedule-form-input" id="end_date" name="end_date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                                    </div>
                                    
                                    <div class="schedule-info">
                                        <div class="schedule-info-title">
                                            <span class="nav-icon me-2">ℹ️</span> Important Information
                                        </div>
                                        <p class="schedule-info-text">
                                            Scheduled transfers will process automatically on the specified dates. 
                                            Ensure sufficient funds are available in your account to avoid failed transfers. 
                                            You can view and manage all scheduled transfers from your Dashboard.
                                        </p>
                                    </div>
                                    
                                    <div class="schedule-actions">
                                        <button type="submit" name="schedule_transfer" class="schedule-btn schedule-btn-primary">
                                            <span class="nav-icon me-2">✅</span> Schedule Transfer
                                        </button>
                                    </div>
                                </form>
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
            
            // Date validation
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            if (startDateInput && endDateInput) {
                startDateInput.addEventListener('change', function() {
                    const startDate = new Date(this.value);
                    const nextDay = new Date(startDate);
                    nextDay.setDate(nextDay.getDate() + 1);
                    
                    // Format as YYYY-MM-DD
                    const year = nextDay.getFullYear();
                    const month = String(nextDay.getMonth() + 1).padStart(2, '0');
                    const day = String(nextDay.getDate()).padStart(2, '0');
                    
                    endDateInput.min = `${year}-${month}-${day}`;
                    
                    // If end date is before new start date + 1, clear it
                    if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
                        endDateInput.value = '';
                    }
                });
                
                // Frequency change handler
                const frequencySelect = document.getElementById('frequency');
                if (frequencySelect) {
                    frequencySelect.addEventListener('change', function() {
                        const selectedValue = this.value;
                        const endDateGroup = endDateInput.closest('.schedule-form-group');
                        
                        if (selectedValue === 'once') {
                            endDateInput.value = '';
                            endDateGroup.style.display = 'none';
                        } else {
                            endDateGroup.style.display = 'block';
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>

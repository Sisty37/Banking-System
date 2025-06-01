<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - Admin Panel - ' . APP_NAME : 'Admin Panel - ' . APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/layout.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/components.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/modules.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-panel">
    <header class="admin-header">
        <div class="container">
            <div class="logo">
                <a href="<?php echo APP_URL; ?>/admin">
                    <h1><?php echo APP_NAME; ?> Admin</h1>
                </a>
            </div>
            <nav>
                <ul class="admin-nav">
                    <li><a href="<?php echo APP_URL; ?>/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/users"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/accounts"><i class="fas fa-university"></i> Accounts</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/transactions"><i class="fas fa-exchange-alt"></i> Transactions</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/reports"><i class="fas fa-chart-bar"></i> Reports</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/settings"><i class="fas fa-cogs"></i> Settings</a></li>
                    
                    <!-- User dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">
                            <i class="fas fa-user-shield"></i> <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?> <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo APP_URL; ?>/profile"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a href="<?php echo APP_URL; ?>/logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="admin-container">
        <aside class="admin-sidebar">
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="<?php echo APP_URL; ?>/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/users"><i class="fas fa-users"></i> Manage Users</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/accounts"><i class="fas fa-university"></i> Manage Accounts</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/transactions"><i class="fas fa-exchange-alt"></i> Transactions</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/bills"><i class="fas fa-file-invoice-dollar"></i> Bill Payments</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/reports"><i class="fas fa-chart-bar"></i> Reports</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/logs"><i class="fas fa-list"></i> System Logs</a></li>
                    <li><a href="<?php echo APP_URL; ?>/admin/settings"><i class="fas fa-cogs"></i> System Settings</a></li>
                </ul>
            </nav>
        </aside>
        
        <main class="admin-content">
            <div class="admin-content-container">
                <?php if (isset($_SESSION['flash_message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?>">
                        <?php echo $_SESSION['flash_message']['message']; ?>
                        <span class="close-btn">&times;</span>
                    </div>
                    <?php unset($_SESSION['flash_message']); ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>

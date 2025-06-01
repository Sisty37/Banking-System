<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="admin-panel">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="logo-container">
            <a href="<?php echo APP_URL; ?>/admin" class="logo">Banking System</a>
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="<?php echo APP_URL; ?>/admin" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo APP_URL; ?>/admin/users" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a href="<?php echo APP_URL; ?>/admin/accounts" class="nav-link">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Accounts</span>
                </a>
            </li>
            <li>
                <a href="<?php echo APP_URL; ?>/admin/transactions" class="nav-link">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transactions</span>
                </a>
            </li>
            <li>
                <a href="<?php echo APP_URL; ?>/dashboard" class="nav-link">
                    <i class="fas fa-user"></i>
                    <span>User Area</span>
                </a>
            </li>
            <li>
                <a href="<?php echo APP_URL; ?>/logout" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div class="left-section">
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h2>Admin Dashboard</h2>
            </div>
            <div class="user-profile">
                <div class="user-avatar">
                    <?php
                    // Get admin initials
                    $names = explode(' ', $_SESSION['user_name']);
                    $initials = '';
                    foreach ($names as $name) {
                        $initials .= !empty($name) ? $name[0] : '';
                    }
                    echo strtoupper(substr($initials, 0, 2));
                    ?>
                </div>
                <div class="user-info">
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <span class="user-role">Admin</span>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="admin-content">
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?>">
                    <?php echo $_SESSION['flash_message']['message']; ?>
                    <button class="close-btn">&times;</button>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>

            <!-- System Alert -->
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Welcome to the admin dashboard. Here you can manage all aspects of the banking system.
            </div>

            <!-- System Overview -->
            <section class="system-overview">
                <h2>System Overview</h2>
                <div class="stat-grid">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-value"><?php echo $totalUsers ?? 0; ?></div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-money-check-alt"></i></div>
                        <div class="stat-value"><?php echo $totalAccounts ?? 0; ?></div>
                        <div class="stat-label">Total Accounts</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-exchange-alt"></i></div>
                        <div class="stat-value"><?php echo $totalTransactions ?? 0; ?></div>
                        <div class="stat-label">Total Transactions</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                        <div class="stat-value">$<?php echo number_format($totalBalance ?? 0, 2); ?></div>
                        <div class="stat-label">Total Balance</div>
                    </div>
                </div>
            </section>
        
    </main>
</div>

 
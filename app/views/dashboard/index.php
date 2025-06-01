<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="dashboard-container">
    <!-- Dashboard Sidebar -->
    <div class="dashboard-sidebar">
        <div class="logo-container">
            <a href="<?php echo APP_URL; ?>" class="logo">Banking System</a>
        </div>
        
        <div class="sidebar-content">
            <ul class="sidebar-nav">
                <li>
                    <a href="<?php echo APP_URL; ?>/dashboard" class="nav-link active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo APP_URL; ?>/accounts" class="nav-link">
                        <i class="fas fa-university"></i>
                        <span>Accounts</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo APP_URL; ?>/transactions" class="nav-link">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Transactions</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo APP_URL; ?>/fund-transfer" class="nav-link">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Transfer</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo APP_URL; ?>/bill-payment" class="nav-link">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Bill Pay</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo APP_URL; ?>/profile" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo APP_URL; ?>/logout" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Dashboard Main Content -->
    <div class="dashboard-main">
        <div class="dashboard-header">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="user-profile">
                <div class="notifications-badge">
                    <a href="#" class="notifications-trigger">
                        <i class="fas fa-bell"></i>
                        <?php if (isset($unreadNotificationsCount) && $unreadNotificationsCount > 0): ?>
                            <span class="badge badge-danger"><?php echo $unreadNotificationsCount; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                
                <?php
                // Get user initials
                $names = explode(' ', $user['first_name'] . ' ' . $user['last_name']);
                $initials = '';
                foreach ($names as $name) {
                    $initials .= !empty($name) ? $name[0] : '';
                }
                $initials = strtoupper(substr($initials, 0, 2));
                ?>
                
                <div class="user-avatar">
                    <?php echo $initials; ?>
                </div>
                
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></div>
                    <div class="user-role">Personal Banking</div>
                </div>
            </div>
        </div>
        
        <div class="dashboard-content">
            <div class="container">
                <!-- Welcome Message -->
                <div class="widget">
                    <div class="widget-header">
                        <h1 class="widget-title">Welcome, <?php echo htmlspecialchars($user['first_name']); ?></h1>
                     </div>
                    <div class="widget-body">
                        <div class="stats-grid">
                            <div class="stat-box">
                                <div class="stat-value">
                                    <?php 
                                        $totalBalance = 0;
                                        foreach ($accounts as $account) {
                                            $totalBalance += $account['balance'];
                                        }
                                        echo '$' . number_format($totalBalance, 2);
                                    ?>
                                </div>
                                <div class="stat-label">TOTAL BALANCE</div>
                            </div>
                            
                            <div class="stat-box">
                                <div class="stat-value"><?php echo count($accounts); ?></div>
                                <div class="stat-label">ACTIVE ACCOUNTS</div>
                            </div>
                            
                            <div class="stat-box">
                                <div class="stat-value">
                                    <?php echo isset($pendingBills) ? count($pendingBills) : 0; ?>
                                </div>
                                <div class="stat-label">PENDING BILLS</div>
                            </div>
                            
                            <div class="stat-box">
                                <div class="stat-value">
                                    <?php echo isset($recentTransactions) ? count($recentTransactions) : 0; ?>
                                </div>
                                <div class="stat-label">RECENT TRANSACTIONS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
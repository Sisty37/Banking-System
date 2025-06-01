<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="admin-panel">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="logo-container">
            <a href="<?php echo APP_URL; ?>/admin" class="logo">Banking System</a>
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="<?php echo APP_URL; ?>/admin" class="nav-link">
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
                <a href="<?php echo APP_URL; ?>/admin/transactions" class="nav-link active">
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
                <h2>Manage Transactions</h2>
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

            <!-- Page Header -->
            <div class="page-header">
                <h1>Transaction Management</h1>
            </div>

             
            <!-- Transactions Table -->
            <div class="widget">
                <div class="widget-header">
                    <h3 class="widget-title">All Transactions</h3>
                </div>
                <div class="widget-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Reference</th>
                                    <th>Account</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($transactions) && !empty($transactions)): ?>
                                    <?php foreach ($transactions as $transaction): ?>
                                        <tr>
                                            <td><?php echo $transaction['id']; ?></td>
                                            <td><?php echo $transaction['reference_number']; ?></td>
                                            <td><?php echo $transaction['account_number'] ?? 'N/A'; ?></td>
                                            <td><?php echo ucfirst($transaction['transaction_type']); ?></td>
                                            <td class="<?php echo $transaction['transaction_type'] === 'deposit' ? 'text-success' : ($transaction['transaction_type'] === 'withdrawal' ? 'text-danger' : ''); ?>">
                                                $<?php echo number_format($transaction['amount'], 2); ?>
                                            </td>
                                            <td><?php echo date('M d, Y H:i', strtotime($transaction['created_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
 
                </div>
            </div>
        </div>

      
<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="account-details">
    <div class="container">
        <div class="details-header">
            <h1>Account Details</h1>
            <div class="details-actions">
                <a href="<?php echo APP_URL; ?>/accounts" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Accounts</a>
            </div>
        </div>
        
        <?php if (isset($account) && $account): 
            // Convert account type to lowercase and replace spaces with hyphens for CSS class
            $accountTypeClass = strtolower(str_replace(' ', '-', $account->account_type));
        ?>
            <div class="account-header <?php echo $accountTypeClass; ?>">
                <div class="account-type">
                    <h2><?php echo htmlspecialchars($account->account_type); ?> Account</h2>
                    <span class="status <?php echo strtolower($account->status); ?>"><?php echo htmlspecialchars($account->status); ?></span>
                </div>
                <div class="account-number">
                    <span>Account Number</span>
                    <h3><?php echo htmlspecialchars($account->account_number); ?></h3>
                </div>
            </div>
                
            <div class="account-info">
                <div class="info-item balance">
                    <span class="label">Current Balance</span>
                    <span class="value">$<?php echo number_format($account->balance, 2); ?></span>
                </div>
                <div class="info-item available">
                    <span class="label">Available Balance</span>
                    <span class="value available">$<?php echo number_format($account->balance, 2); ?></span>
                </div>
                <div class="info-item date">
                    <span class="label">Date Opened</span>
                    <span class="value"><?php echo date('F j, Y', strtotime($account->created_at)); ?></span>
                </div>
            </div>
                
            <div class="quick-actions">
                <a href="<?php echo APP_URL; ?>/fund-transfer?from=<?php echo $account->id; ?>" class="action-btn">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transfer Funds</span>
                </a>
                <a href="<?php echo APP_URL; ?>/transactions?account_id=<?php echo $account->id; ?>" class="action-btn">
                    <i class="fas fa-history"></i>
                    <span>Transaction History</span>
                </a>
                <a href="<?php echo APP_URL; ?>/accounts/statement/<?php echo $account->id; ?>" class="action-btn">
                    <i class="fas fa-file-invoice"></i>
                    <span>Generate Statement</span>
                </a>
            </div>
            
            <div class="recent-activity">
                <h2>Recent Activity</h2>
                <?php if (isset($recentTransactions) && !empty($recentTransactions)): ?>
                    <div class="transaction-list">
                        <?php foreach ($recentTransactions as $transaction): ?>
                            <div class="transaction-item">
                                <div class="transaction-icon <?php echo ($transaction['transaction_type'] === 'deposit' || ($transaction['transaction_type'] === 'transfer' && $transaction['recipient_account_id'] == $account->id)) ? 'income' : 'expense'; ?>">
                                    <?php if ($transaction['transaction_type'] === 'deposit'): ?>
                                        <i class="fas fa-arrow-down"></i>
                                    <?php elseif ($transaction['transaction_type'] === 'withdrawal'): ?>
                                        <i class="fas fa-arrow-up"></i>
                                    <?php elseif ($transaction['transaction_type'] === 'transfer'): ?>
                                        <i class="fas fa-exchange-alt"></i>
                                    <?php else: ?>
                                        <i class="fas fa-dot-circle"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="transaction-details">
                                    <div class="transaction-title">
                                        <h4><?php echo htmlspecialchars($transaction['description']); ?></h4>
                                        <span class="transaction-date"><?php echo date('M j, Y', strtotime($transaction['created_at'])); ?></span>
                                    </div>
                                    <div class="transaction-amount <?php echo ($transaction['transaction_type'] === 'deposit' || ($transaction['transaction_type'] === 'transfer' && $transaction['recipient_account_id'] == $account->id)) ? 'income' : 'expense'; ?>">
                                        <?php if ($transaction['transaction_type'] === 'deposit' || ($transaction['transaction_type'] === 'transfer' && $transaction['recipient_account_id'] == $account->id)): ?>
                                            +$<?php echo number_format($transaction['amount'], 2); ?>
                                        <?php else: ?>
                                            -$<?php echo number_format($transaction['amount'], 2); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="view-all">
                        <a href="<?php echo APP_URL; ?>/transactions?account_id=<?php echo $account->id; ?>" class="btn btn-outline">View All Transactions</a>
                    </div>
                <?php else: ?>
                    <div class="no-transactions">
                        <i class="fas fa-receipt"></i>
                        <p>No recent transactions found for this account.</p>
                        <a href="<?php echo APP_URL; ?>/deposit?account_id=<?php echo $account->id; ?>" class="btn btn-primary">Make a Deposit</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="error-message">
                <p>Account not found or you don't have permission to view this account.</p>
                <a href="<?php echo APP_URL; ?>/accounts" class="btn btn-primary">Go to Your Accounts</a>
            </div>
        <?php endif; ?>
    </div>
</section>

 
<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="page-container">
    <div class="page-header">
        <div class="page-title">Your Accounts</div>
        <a href="<?php echo APP_URL; ?>/accounts/create" class="btn btn-primary">Open New Account</a>
    </div>

    <?php if (!empty($accounts)): ?>
        <div class="row">
            <?php foreach ($accounts as $account): 
                // Convert account type to lowercase and replace spaces with hyphens for CSS class
                $accountTypeClass = strtolower(str_replace(' ', '-', $account['account_type']));
            ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="account-card <?php echo $accountTypeClass; ?>">
                        <div class="account-status <?php echo $account['status']; ?>">
                            <?php echo ucfirst($account['status']); ?>
                        </div>
                        
                        <div class="account-icon">
                            <?php if (strtolower($account['account_type']) === 'savings'): ?>
                                <i class="fas fa-piggy-bank"></i>
                            <?php elseif (strtolower($account['account_type']) === 'checking'): ?>
                                <i class="fas fa-money-check-alt"></i>
                            <?php elseif (strtolower($account['account_type']) === 'fixed deposit'): ?>
                                <i class="fas fa-lock"></i>
                            <?php elseif (strtolower($account['account_type']) === 'money market'): ?>
                                <i class="fas fa-chart-line"></i>
                            <?php else: ?>
                                <i class="fas fa-university"></i>
                            <?php endif; ?>
                        </div>
                        
                        <div class="account-title">
                            <?php echo htmlspecialchars($account['account_type']); ?> Account
                        </div>
                        
                        <div class="account-number">
                            <?php echo htmlspecialchars($account['account_number']); ?>
                        </div>
                        
                        <div class="account-balance">
                            $<?php echo number_format($account['balance'], 2); ?>
                        </div>
                        
                        <div class="account-footer">
                            <div class="account-date">
                                Opened: <?php echo date('M d, Y', strtotime($account['created_at'])); ?>
                            </div>
                            
                            <div class="btn-group">
                                <a href="<?php echo APP_URL; ?>/accounts/view?id=<?php echo $account['id']; ?>" class="btn btn-sm btn-outline-primary">Details</a>
                                <a href="<?php echo APP_URL; ?>/transactions?account_id=<?php echo $account['id']; ?>" class="btn btn-sm btn-outline-primary">Transactions</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-university fa-3x mb-3 text-muted"></i>
                <p class="mb-4">You don't have any accounts yet.</p>
                <a href="<?php echo APP_URL; ?>/accounts/create" class="btn btn-primary">Open an Account</a>
            </div>
        </div>
    <?php endif; ?>
</section>
 
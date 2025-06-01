<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Transaction History</h1>
        <p>View all your account transactions</p>
    </div>

    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?>">
            <?php echo htmlspecialchars($_SESSION['flash_message']['message']); ?>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5>Your Transactions</h5>
                </div>
               
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($transactions)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Type</th>
                                <th>Account</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td><?php echo date('M d, Y', strtotime($transaction['created_at'])); ?></td>
                                    <td><?php echo htmlspecialchars($transaction['reference_number']); ?></td>
                                    <td>
                                        <?php 
                                            $typeClass = '';
                                            switch ($transaction['transaction_type']) {
                                                case 'deposit':
                                                    $typeClass = 'badge-success';
                                                    break;
                                                case 'withdrawal':
                                                    $typeClass = 'badge-danger';
                                                    break;
                                                case 'transfer':
                                                    $typeClass = 'badge-primary';
                                                    break;
                                                case 'bill_payment':
                                                    $typeClass = 'badge-warning';
                                                    break;
                                                default:
                                                    $typeClass = 'badge-secondary';
                                            }
                                        ?>
                                        <span class="badge <?php echo $typeClass; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $transaction['transaction_type'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($transaction['account_number'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                                    <td class="<?php echo $transaction['transaction_type'] === 'deposit' ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo $transaction['transaction_type'] === 'deposit' ? '+' : '-'; ?>
                                        $<?php echo number_format($transaction['amount'], 2); ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $statusClass = '';
                                            switch ($transaction['status']) {
                                                case 'completed':
                                                    $statusClass = 'badge-success';
                                                    break;
                                                case 'pending':
                                                    $statusClass = 'badge-warning';
                                                    break;
                                                case 'failed':
                                                    $statusClass = 'badge-danger';
                                                    break;
                                                default:
                                                    $statusClass = 'badge-secondary';
                                            }
                                        ?>
                                        <span class="badge <?php echo $statusClass; ?>">
                                            <?php echo ucfirst($transaction['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo APP_URL; ?>/transactions/details?id=<?php echo $transaction['id']; ?>" class="btn btn-sm btn-info">Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <a href="<?php echo APP_URL; ?>/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            
        </div>
    </div>
</div>
 
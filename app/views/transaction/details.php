<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Transaction Details</h1>
        <p>View details for transaction: <?php echo htmlspecialchars($transaction['reference_number']); ?></p>
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
                    <h5>
                        <?php 
                            echo ucfirst(str_replace('_', ' ', $transaction['transaction_type']));
                            echo ' - ';
                            echo ucfirst($transaction['status']);
                        ?>
                    </h5>
                </div>
                <div class="col-md-6 text-right">
                    <h5 class="<?php echo $transaction['transaction_type'] === 'deposit' ? 'text-success' : 'text-danger'; ?>">
                        <?php echo $transaction['transaction_type'] === 'deposit' ? '+' : '-'; ?>
                        $<?php echo number_format($transaction['amount'], 2); ?>
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3">Transaction Information</h6>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Reference Number</th>
                            <td><?php echo htmlspecialchars($transaction['reference_number']); ?></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td><?php echo date('M d, Y H:i:s', strtotime($transaction['created_at'])); ?></td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td><?php echo ucfirst(str_replace('_', ' ', $transaction['transaction_type'])); ?></td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>$<?php echo number_format($transaction['amount'], 2); ?></td>
                        </tr>
                        <?php if ($transaction['fee'] > 0): ?>
                            <tr>
                                <th>Fee</th>
                                <td>$<?php echo number_format($transaction['fee'], 2); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Status</th>
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
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3">Account Information</h6>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Account</th>
                            <td>
                                <?php echo htmlspecialchars($account['account_type'] . ' - ' . $account['account_number']); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Current Balance</th>
                            <td>$<?php echo number_format($account['balance'], 2); ?></td>
                        </tr>
                        <?php if ($transaction['transaction_type'] === 'transfer'): ?>
                            <?php if (!empty($transaction['recipient_account_id'])): ?>
                                <tr>
                                    <th>Recipient Account</th>
                                    <td>
                                        <?php 
                                            if (isset($transaction['recipient_account_number'])) {
                                                echo htmlspecialchars($transaction['recipient_account_number']);
                                            } else {
                                                echo 'Internal Account';
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($transaction['recipient_name'])): ?>
                                <tr>
                                    <th>Recipient Name</th>
                                    <td><?php echo htmlspecialchars($transaction['recipient_name']); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($transaction['recipient_bank'])): ?>
                                <tr>
                                    <th>Recipient Bank</th>
                                    <td><?php echo htmlspecialchars($transaction['recipient_bank']); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <?php if ($transaction['transaction_type'] === 'transfer' && isset($transfers) && !empty($transfers)): ?>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h6 class="mb-3">Transfer Details</h6>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>From Account</th>
                                    <th>To Account</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transfers as $transfer): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($transfer['from_account_number']); ?></td>
                                        <td><?php echo htmlspecialchars($transfer['to_account_number']); ?></td>
                                        <td>$<?php echo number_format($transfer['amount'], 2); ?></td>
                                        <td><?php echo ucfirst($transfer['transfer_type']); ?></td>
                                        <td>
                                            <?php 
                                                $statusClass = '';
                                                switch ($transfer['status']) {
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
                                                <?php echo ucfirst($transfer['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <a href="<?php echo APP_URL; ?>/transactions" class="btn btn-secondary">Back to Transactions</a>
            <a href="<?php echo APP_URL; ?>/dashboard" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
</div>

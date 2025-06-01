<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="page-container">
    <div class="page-header">
        <div class="page-title">Bill Payment</div>
        <div class="page-subtitle">Pay your bills easily from your accounts</div>
    </div>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?>">
            <?php echo htmlspecialchars($_SESSION['flash_message']['message']); ?>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

     

        <!-- Payment Form -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Payment Details</div>
                </div>
                <div class="card-body">
                    <form id="paymentForm" action="<?php echo APP_URL; ?>/bill-payment/process" method="POST">
                        <input type="hidden" id="bill_id" name="bill_id">
                        
                        <div class="form-group">
                            <label for="bill_info" class="form-label">Selected Bill</label>
                            <div id="bill_info" class="card p-3 mb-3 bg-light">
                                <p class="mb-0">Please select a bill from the list</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="account_id" class="form-label">Pay From Account</label>
                            <select class="form-control" id="account_id" name="account_id" required>
                                <option value="">Select Account</option>
                                <?php foreach ($accounts as $account): ?>
                                    <option value="<?php echo $account['id']; ?>" data-balance="<?php echo $account['balance']; ?>">
                                        <?php echo htmlspecialchars($account['account_type'] . ' - ' . $account['account_number'] . ' ($' . number_format($account['balance'], 2) . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Available Balance: <span id="available_balance">$0.00</span></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="amount" class="form-label">Payment Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0.01" placeholder="Enter payment amount" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary" id="payButton" disabled>Pay Now</button>
                            <a href="<?php echo APP_URL; ?>/dashboard" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .bills-list {
        max-height: 500px;
        overflow-y: auto;
    }
    
    .transaction-item {
        display: flex;
        padding: 15px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .transaction-item:hover {
        background-color: #f8f9fa;
    }
    
    .transaction-icon {
        margin-right: 15px;
        font-size: 24px;
        color: #6c757d;
    }
    
    .transaction-details {
        flex: 1;
    }
    
    .transaction-title {
        margin-bottom: 5px;
    }
    
    .transaction-meta {
        font-size: 12px;
        color: #6c757d;
    }
    
    .transaction-amount {
        display: flex;
        align-items: center;
        font-size: 16px;
    }
    
    .selected-bill {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .selected-bill h5 {
        margin-bottom: 10px;
        color: #007bff;
    }
    
    .selected-bill p {
        margin-bottom: 5px;
    }
</style>

 
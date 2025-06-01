<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="page-container">
    <div class="page-header">
        <div class="page-title">Fund Transfer</div>
        <div class="page-subtitle">Transfer money between your accounts or to other accounts</div>
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

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['success']); ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Transfer Details</div>
        </div>
        <div class="card-body">
            <form action="<?php echo APP_URL; ?>/fund-transfer/process" method="POST">
                <div class="form-group">
                    <label for="transfer_type" class="form-label">Transfer Type</label>
                    <select class="form-control" id="transfer_type" name="transfer_type" required>
                        <option value="internal" selected>Internal Transfer (Between My Accounts)</option>
                        <option value="external">External Transfer (To Another Bank)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="from_account_id" class="form-label">From Account</label>
                    <select class="form-control" id="from_account_id" name="from_account_id" required>
                        <option value="">Select Source Account</option>
                        <?php foreach ($accounts as $account): ?>
                            <option value="<?php echo $account['id']; ?>" 
                                    data-balance="<?php echo $account['balance']; ?>"
                                    data-number="<?php echo $account['account_number']; ?>">
                                <?php echo htmlspecialchars($account['account_type'] . ' - ' . $account['account_number'] . ' ($' . number_format($account['balance'], 2) . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Available Balance: <span id="available_balance">$0.00</span></div>
                </div>

                <div id="internal_transfer" class="transfer-section">
                    <div class="form-group">
                        <label for="to_account_id" class="form-label">To Account</label>
                        <select class="form-control" id="to_account_id" name="to_account_id">
                            <option value="">Select Destination Account</option>
                            <?php foreach ($accounts as $account): ?>
                                <option value="<?php echo $account['id']; ?>">
                                    <?php echo htmlspecialchars($account['account_type'] . ' - ' . $account['account_number']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div id="external_transfer" class="transfer-section" style="display: none;">
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="recipient_name" class="form-label">Recipient Name</label>
                                <input type="text" class="form-control" id="recipient_name" name="recipient_name" placeholder="Enter recipient name">
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="recipient_bank" class="form-label">Recipient Bank</label>
                                <input type="text" class="form-control" id="recipient_bank" name="recipient_bank" placeholder="Enter recipient bank">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="recipient_account" class="form-label">Recipient Account Number</label>
                        <input type="text" class="form-control" id="recipient_account" name="recipient_account" placeholder="Enter recipient account number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="amount" class="form-label">Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0.01" placeholder="Enter transfer amount" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="2" placeholder="Enter transfer description (optional)"></textarea>
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">Submit Transfer</button>
                    <a href="<?php echo APP_URL; ?>/dashboard" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Transfer type toggle
        const transferTypeSelect = document.getElementById('transfer_type');
        const internalTransferDiv = document.getElementById('internal_transfer');
        const externalTransferDiv = document.getElementById('external_transfer');
        const toAccountSelect = document.getElementById('to_account_id');
        const recipientNameInput = document.getElementById('recipient_name');
        const recipientBankInput = document.getElementById('recipient_bank');
        const recipientAccountInput = document.getElementById('recipient_account');
        
        transferTypeSelect.addEventListener('change', function() {
            if (this.value === 'internal') {
                internalTransferDiv.style.display = 'block';
                externalTransferDiv.style.display = 'none';
                toAccountSelect.setAttribute('required', 'required');
                recipientNameInput.removeAttribute('required');
                recipientBankInput.removeAttribute('required');
                recipientAccountInput.removeAttribute('required');
            } else {
                internalTransferDiv.style.display = 'none';
                externalTransferDiv.style.display = 'block';
                toAccountSelect.removeAttribute('required');
                recipientNameInput.setAttribute('required', 'required');
                recipientBankInput.setAttribute('required', 'required');
                recipientAccountInput.setAttribute('required', 'required');
            }
        });
        
        // Update available balance
        const fromAccountSelect = document.getElementById('from_account_id');
        const availableBalanceSpan = document.getElementById('available_balance');
        
        fromAccountSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const balance = selectedOption.getAttribute('data-balance') || 0;
            availableBalanceSpan.textContent = '$' + parseFloat(balance).toFixed(2);
        });
        
        // Prevent transferring to the same account
        fromAccountSelect.addEventListener('change', function() {
            const fromAccountId = this.value;
            
            for (let i = 0; i < toAccountSelect.options.length; i++) {
                if (toAccountSelect.options[i].value === fromAccountId) {
                    toAccountSelect.options[i].disabled = true;
                } else if (toAccountSelect.options[i].value !== '') {
                    toAccountSelect.options[i].disabled = false;
                }
            }
            
            // If current selection is now disabled, reset selection
            if (toAccountSelect.options[toAccountSelect.selectedIndex].disabled) {
                toAccountSelect.value = '';
            }
        });
    });
</script>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?> 
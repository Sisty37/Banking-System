<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="transfer-form">
    <div class="container">
        <div class="form-container">
            <h1>Transfer Funds</h1>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <p><?php echo htmlspecialchars($success); ?></p>
                </div>
            <?php endif; ?>
            
            <form action="/transfers/process" method="POST" id="transferForm">
                <div class="form-grid">
                    <div class="form-section">
                        <h3>Transfer Details</h3>
                        
                        <div class="form-group">
                            <label for="from_account_id">From Account</label>
                            <select id="from_account_id" name="from_account_id" required>
                                <option value="">Select Account</option>
                                <?php if (isset($accounts) && is_array($accounts)): ?>
                                    <?php foreach ($accounts as $account): ?>
                                        <option value="<?php echo $account->id; ?>" 
                                            data-balance="<?php echo $account->balance; ?>"
                                            <?php echo (isset($_GET['from_account']) && $_GET['from_account'] == $account->id) || 
                                                (isset($old_input['from_account_id']) && $old_input['from_account_id'] == $account->id) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($account->account_type . ' - ' . $account->account_number . ' ($' . number_format($account->balance, 2) . ')'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <span class="error-message" id="from_account_id-error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label>Transfer Type</label>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="transfer_type" value="internal" checked> 
                                    <span>Transfer to My Account</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="transfer_type" value="external"> 
                                    <span>Transfer to Another Account</span>
                                </label>
                            </div>
                        </div>
                        
                        <div id="internal-transfer-section">
                            <div class="form-group">
                                <label for="to_account_id">To Account</label>
                                <select id="to_account_id" name="to_account_id">
                                    <option value="">Select Account</option>
                                    <?php if (isset($accounts) && is_array($accounts)): ?>
                                        <?php foreach ($accounts as $account): ?>
                                            <option value="<?php echo $account->id; ?>" 
                                                <?php echo (isset($old_input['to_account_id']) && $old_input['to_account_id'] == $account->id) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($account->account_type . ' - ' . $account->account_number); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="error-message" id="to_account_id-error"></span>
                            </div>
                        </div>
                        
                        <div id="external-transfer-section" style="display:none;">
                            <div class="form-group">
                                <label for="recipient_account_number">Recipient Account Number</label>
                                <input type="text" id="recipient_account_number" name="recipient_account_number" value="<?php echo isset($old_input['recipient_account_number']) ? htmlspecialchars($old_input['recipient_account_number']) : ''; ?>">
                                <span class="error-message" id="recipient_account_number-error"></span>
                            </div>
                            
                            <div class="form-group">
                                <label for="recipient_name">Recipient Name</label>
                                <input type="text" id="recipient_name" name="recipient_name" value="<?php echo isset($old_input['recipient_name']) ? htmlspecialchars($old_input['recipient_name']) : ''; ?>">
                                <span class="error-message" id="recipient_name-error"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="amount">Amount ($)</label>
                            <input type="number" id="amount" name="amount" step="0.01" min="0.01" value="<?php echo isset($old_input['amount']) ? htmlspecialchars($old_input['amount']) : ''; ?>" required>
                            <div class="balance-info" id="balance-info">Available Balance: <span id="available-balance">$0.00</span></div>
                            <span class="error-message" id="amount-error"></span>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>Additional Information</h3>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description" value="<?php echo isset($old_input['description']) ? htmlspecialchars($old_input['description']) : 'Fund Transfer'; ?>">
                            <span class="error-message" id="description-error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3"><?php echo isset($old_input['notes']) ? htmlspecialchars($old_input['notes']) : ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="schedule_transfer">Schedule Transfer</label>
                            <select id="schedule_transfer" name="schedule_transfer">
                                <option value="now" selected>Transfer Now</option>
                                <option value="later" <?php echo (isset($old_input['schedule_transfer']) && $old_input['schedule_transfer'] === 'later') ? 'selected' : ''; ?>>Schedule for Later</option>
                            </select>
                        </div>
                        
                        <div id="schedule-date-section" style="display:none;">
                            <div class="form-group">
                                <label for="scheduled_date">Transfer Date</label>
                                <input type="date" id="scheduled_date" name="scheduled_date" value="<?php echo isset($old_input['scheduled_date']) ? htmlspecialchars($old_input['scheduled_date']) : ''; ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                                <span class="error-message" id="scheduled_date-error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="transfer-summary" id="transfer-summary">
                    <h3>Transfer Summary</h3>
                    <div class="summary-items">
                        <div class="summary-item">
                            <span class="label">Transfer Amount:</span>
                            <span class="value" id="summary-amount">$0.00</span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Fee:</span>
                            <span class="value" id="summary-fee">$0.00</span>
                        </div>
                        <div class="summary-item total">
                            <span class="label">Total Amount:</span>
                            <span class="value" id="summary-total">$0.00</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submit-transfer">Process Transfer</button>
                    <a href="/dashboard" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get elements
        const transferTypeRadios = document.querySelectorAll('input[name="transfer_type"]');
        const internalSection = document.getElementById('internal-transfer-section');
        const externalSection = document.getElementById('external-transfer-section');
        const scheduleSelect = document.getElementById('schedule_transfer');
        const scheduleDateSection = document.getElementById('schedule-date-section');
        const fromAccountSelect = document.getElementById('from_account_id');
        const toAccountSelect = document.getElementById('to_account_id');
        const amountInput = document.getElementById('amount');
        const availableBalance = document.getElementById('available-balance');
        const summaryAmount = document.getElementById('summary-amount');
        const summaryFee = document.getElementById('summary-fee');
        const summaryTotal = document.getElementById('summary-total');
        
        // Handle transfer type change
        transferTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'internal') {
                    internalSection.style.display = 'block';
                    externalSection.style.display = 'none';
                } else {
                    internalSection.style.display = 'none';
                    externalSection.style.display = 'block';
                }
                updateSummary();
            });
        });
        
        // Handle schedule change
        scheduleSelect.addEventListener('change', function() {
            if (this.value === 'later') {
                scheduleDateSection.style.display = 'block';
            } else {
                scheduleDateSection.style.display = 'none';
            }
        });
        
        // Handle from account change
        fromAccountSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const balance = selectedOption ? parseFloat(selectedOption.dataset.balance) : 0;
            availableBalance.textContent = '$' + balance.toFixed(2);
            
            // Remove the selected account from to account options
            const selectedValue = this.value;
            for (let i = 0; i < toAccountSelect.options.length; i++) {
                if (toAccountSelect.options[i].value === selectedValue) {
                    toAccountSelect.options[i].disabled = true;
                } else {
                    toAccountSelect.options[i].disabled = false;
                }
            }
            
            updateSummary();
        });
        
        // Handle amount change
        amountInput.addEventListener('input', updateSummary);
        
        // Update summary
        function updateSummary() {
            const amount = parseFloat(amountInput.value) || 0;
            const transferType = document.querySelector('input[name="transfer_type"]:checked').value;
            
            // Calculate fee (example: external transfers have a $2.50 fee)
            const fee = transferType === 'external' ? 2.50 : 0;
            
            summaryAmount.textContent = '$' + amount.toFixed(2);
            summaryFee.textContent = '$' + fee.toFixed(2);
            summaryTotal.textContent = '$' + (amount + fee).toFixed(2);
        }
        
        // Form validation
        document.getElementById('transferForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => {
                el.textContent = '';
            });
            
            // Validate from account
            if (!fromAccountSelect.value) {
                document.getElementById('from_account_id-error').textContent = 'Please select an account to transfer from';
                isValid = false;
            }
            
            // Validate amount
            if (!amountInput.value || parseFloat(amountInput.value) <= 0) {
                document.getElementById('amount-error').textContent = 'Please enter a valid amount';
                isValid = false;
            } else {
                // Check if amount exceeds available balance
                const selectedOption = fromAccountSelect.options[fromAccountSelect.selectedIndex];
                const balance = selectedOption ? parseFloat(selectedOption.dataset.balance) : 0;
                
                if (parseFloat(amountInput.value) > balance) {
                    document.getElementById('amount-error').textContent = 'Amount exceeds available balance';
                    isValid = false;
                }
            }
            
            // Validate transfer destination
            const transferType = document.querySelector('input[name="transfer_type"]:checked').value;
            if (transferType === 'internal') {
                if (!toAccountSelect.value) {
                    document.getElementById('to_account_id-error').textContent = 'Please select a destination account';
                    isValid = false;
                } else if (toAccountSelect.value === fromAccountSelect.value) {
                    document.getElementById('to_account_id-error').textContent = 'Cannot transfer to the same account';
                    isValid = false;
                }
            } else {
                if (!document.getElementById('recipient_account_number').value) {
                    document.getElementById('recipient_account_number-error').textContent = 'Please enter recipient account number';
                    isValid = false;
                }
                if (!document.getElementById('recipient_name').value) {
                    document.getElementById('recipient_name-error').textContent = 'Please enter recipient name';
                    isValid = false;
                }
            }
            
            // Validate scheduled date if applicable
            if (scheduleSelect.value === 'later') {
                const scheduledDate = document.getElementById('scheduled_date').value;
                if (!scheduledDate) {
                    document.getElementById('scheduled_date-error').textContent = 'Please select a date for the scheduled transfer';
                    isValid = false;
                } else {
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const selectedDate = new Date(scheduledDate);
                    if (selectedDate <= today) {
                        document.getElementById('scheduled_date-error').textContent = 'Scheduled date must be in the future';
                        isValid = false;
                    }
                }
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        // Initialize the form
        if (fromAccountSelect.value) {
            const event = new Event('change');
            fromAccountSelect.dispatchEvent(event);
        }
        
        if (scheduleSelect.value === 'later') {
            scheduleDateSection.style.display = 'block';
        }
        
        // Initialize the transfer type
        const selectedTransferType = document.querySelector('input[name="transfer_type"]:checked');
        if (selectedTransferType) {
            if (selectedTransferType.value === 'internal') {
                internalSection.style.display = 'block';
                externalSection.style.display = 'none';
            } else {
                internalSection.style.display = 'none';
                externalSection.style.display = 'block';
            }
        }
        
        updateSummary();
    });
</script>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
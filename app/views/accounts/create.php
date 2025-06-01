<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="account-form">
    <div class="container">
        <div class="form-container">
            <h1>Open a New Account</h1>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form action="<?php echo APP_URL; ?>/accounts/store" method="POST">
                <div class="form-group">
                    <label for="account_type">Account Type</label>
                    <select id="account_type" name="account_type" required>
                        <option value="">Select Account Type</option>
                        <option value="Savings" <?php echo isset($old_input['account_type']) && $old_input['account_type'] === 'Savings' ? 'selected' : ''; ?>>Savings Account</option>
                        <option value="Checking" <?php echo isset($old_input['account_type']) && $old_input['account_type'] === 'Checking' ? 'selected' : ''; ?>>Checking Account</option>
                        <option value="Fixed Deposit" <?php echo isset($old_input['account_type']) && $old_input['account_type'] === 'Fixed Deposit' ? 'selected' : ''; ?>>Fixed Deposit</option>
                        <option value="Money Market" <?php echo isset($old_input['account_type']) && $old_input['account_type'] === 'Money Market' ? 'selected' : ''; ?>>Money Market</option>
                    </select>
                    <span class="error-message" id="account_type-error"></span>
                </div>
                
                <div class="form-group">
                    <label for="initial_deposit">Initial Deposit (USD)</label>
                    <input type="number" id="initial_deposit" name="initial_deposit" step="0.01" min="0" value="<?php echo isset($old_input['initial_deposit']) ? htmlspecialchars($old_input['initial_deposit']) : '0.00'; ?>" required>
                    <span class="error-message" id="initial_deposit-error"></span>
                </div>
                
                <div class="account-requirements">
                    <h3>Account Requirements</h3>
                    <div class="requirements-grid">
                        <div class="requirement-item savings" id="savings-requirements">
                            <h4>Savings Account</h4>
                            <ul>
                                <li>Minimum deposit: $100</li>
                                <li>No monthly fee</li>
                                <li>Interest rate: 0.5% annually</li>
                                <li>Unlimited withdrawals and deposits</li>
                            </ul>
                        </div>
                        
                        <div class="requirement-item checking" id="checking-requirements">
                            <h4>Checking Account</h4>
                            <ul>
                                <li>Minimum deposit: $50</li>
                                <li>Monthly fee: $5 (waived with $500+ balance)</li>
                                <li>No interest</li>
                                <li>Unlimited transactions</li>
                                <li>Debit card included</li>
                            </ul>
                        </div>
                        
                        <div class="requirement-item fixed-deposit" id="fixed-deposit-requirements">
                            <h4>Fixed Deposit</h4>
                            <ul>
                                <li>Minimum deposit: $1,000</li>
                                <li>Term: 6, 12, 24, or 36 months</li>
                                <li>Interest rate: 1.5% - 3% annually</li>
                                <li>Early withdrawal penalty applies</li>
                            </ul>
                        </div>
                        
                        <div class="requirement-item money-market" id="money-market-requirements">
                            <h4>Money Market</h4>
                            <ul>
                                <li>Minimum deposit: $500</li>
                                <li>Monthly fee: $10 (waived with $1,000+ balance)</li>
                                <li>Interest rate: 0.8% annually</li>
                                <li>Limited to 6 withdrawals per month</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="agreement-terms">
                    <label for="terms_agreement" class="checkbox-label">
                        <input type="checkbox" id="terms_agreement" name="terms_agreement" required>
                        I agree to the <a href="<?php echo APP_URL; ?>/terms" target="_blank">Terms and Conditions</a>
                    </label>
                    <span class="error-message" id="terms_agreement-error"></span>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Open Account</button>
                    <a href="<?php echo APP_URL; ?>/accounts" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Show/hide requirements based on selected account type
    document.addEventListener('DOMContentLoaded', function() {
        const accountTypeSelect = document.getElementById('account_type');
        const requirementItems = document.querySelectorAll('.requirement-item');
        
        function showRelevantRequirements() {
            const selectedValue = accountTypeSelect.value.toLowerCase().replace(' ', '-');
            
            requirementItems.forEach(item => {
                item.style.display = 'none';
            });
            
            if (selectedValue) {
                const targetElement = document.getElementById(selectedValue + '-requirements');
                if (targetElement) {
                    targetElement.style.display = 'block';
                }
            }
        }
        
        // Initial call to set up display
        showRelevantRequirements();
        
        // Event listener for changes
        accountTypeSelect.addEventListener('change', showRelevantRequirements);
    });
</script>

 
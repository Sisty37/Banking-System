<?php
// Assume $errors is an array that might be passed from the controller
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);

// If email verification was successful, this will be set
$email_verified = $_SESSION['email_verified'] ?? false;
unset($_SESSION['email_verified']);

// Email that was verified (if any)
$verified_email = $_SESSION['verified_email'] ?? '';
unset($_SESSION['verified_email']);
?>

<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-brand">
            <h1>Banking System</h1>
            <p>Reset your password</p>
        </div>

        <div class="auth-card">
            <div class="auth-card-header">
                <h2>Forgot Password</h2>
                <p><?php echo $email_verified ? 'Create a new password' : 'Enter your email to reset your password'; ?></p>
            </div>

            <div class="auth-card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!$email_verified): ?>
                    <!-- Email verification form -->
                    <form action="<?php echo APP_URL; ?>/forgot-password" method="POST" id="forgotPasswordForm">
                        <div class="auth-form-group">
                            <label for="email" class="auth-form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="auth-form-control" value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" required>
                        </div>
                        
                        <button type="submit" class="auth-btn auth-btn-primary">Verify Email</button>
                    </form>
                <?php else: ?>
                    <!-- New password form -->
                    <form action="<?php echo APP_URL; ?>/reset-password" method="POST" id="resetPasswordForm">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($verified_email); ?>">
                        
                        <div class="auth-form-group">
                            <label for="password" class="auth-form-label">New Password</label>
                            <input type="password" id="password" name="password" class="auth-form-control" required>
                            <div class="password-strength-meter">
                                <div class="password-strength-value" id="password-strength"></div>
                            </div>
                            <div class="password-strength-text" id="password-strength-text"></div>
                        </div>

                        <div class="auth-form-group">
                            <label for="confirm_password" class="auth-form-label">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="auth-form-control" required>
                        </div>
                        
                        <button type="submit" class="auth-btn auth-btn-primary">Reset Password</button>
                    </form>
                <?php endif; ?>

                <div class="auth-divider">
                    <span>OR</span>
                </div>

                <div class="login-footer">
                    <p>Remember your password? <a href="<?php echo APP_URL; ?>/login">Back to Login</a></p>
                </div>
            </div>
        </div>

        <div class="auth-footer">
            <p>&copy; <?php echo date('Y'); ?> Banking System. All rights reserved.</p>
        </div>
    </div>
</div>

<?php if ($email_verified): ?>
<script>
    // Password strength meter
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthMeter = document.getElementById('password-strength');
        const strengthText = document.getElementById('password-strength-text');
        
        // Remove all classes
        strengthMeter.className = 'password-strength-value';
        strengthText.className = 'password-strength-text';
        
        if (password.length === 0) {
            strengthMeter.style.width = '0';
            strengthText.textContent = '';
            return;
        }
        
        // Calculate strength
        let strength = 0;
        
        // Length check
        if (password.length >= 8) strength += 1;
        if (password.length >= 12) strength += 1;
        
        // Complexity checks
        if (/[a-z]/.test(password)) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
        
        // Update UI based on strength
        if (strength <= 2) {
            strengthMeter.classList.add('weak');
            strengthText.classList.add('weak');
            strengthText.textContent = 'Weak';
        } else if (strength <= 4) {
            strengthMeter.classList.add('medium');
            strengthText.classList.add('medium');
            strengthText.textContent = 'Medium';
        } else if (strength <= 6) {
            strengthMeter.classList.add('strong');
            strengthText.classList.add('strong');
            strengthText.textContent = 'Strong';
        } else {
            strengthMeter.classList.add('very-strong');
            strengthText.classList.add('very-strong');
            strengthText.textContent = 'Very Strong';
        }
    });
</script>
<?php endif; ?>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
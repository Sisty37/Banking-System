<?php
// Assume $errors is an array that might be passed from the controller
// containing validation errors after a form submission attempt.
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']); // Clear errors after displaying them

// Assume $old_input is an array with previously submitted data
// to pre-fill the form fields.
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']); // Clear old input after displaying
?>

<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-brand">
            <h1>Banking System</h1>
            <p>Create a new account</p>
        </div>

        <div class="auth-card">
            <div class="auth-card-header">
                <h2>Register</h2>
                <p>Fill in the form below to create your account</p>
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

                <form action="<?php echo APP_URL; ?>/register" method="POST" id="registrationForm">
                    <div class="auth-form-group">
                        <label for="first_name" class="auth-form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="auth-form-control" value="<?php echo htmlspecialchars($old_input['first_name'] ?? ''); ?>" required>
                    </div>

                    <div class="auth-form-group">
                        <label for="last_name" class="auth-form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="auth-form-control" value="<?php echo htmlspecialchars($old_input['last_name'] ?? ''); ?>" required>
                    </div>

                    <div class="auth-form-group">
                        <label for="email" class="auth-form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="auth-form-control" value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" required>
                    </div>

                    <div class="auth-form-group">
                        <label for="dob" class="auth-form-label">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="auth-form-control" value="<?php echo htmlspecialchars($old_input['dob'] ?? ''); ?>" required>
                    </div>

                    <div class="auth-form-group">
                        <label for="password" class="auth-form-label">Password</label>
                        <input type="password" id="password" name="password" class="auth-form-control" required>
                        <div class="password-strength-meter">
                            <div class="password-strength-value" id="password-strength"></div>
                        </div>
                        <div class="password-strength-text" id="password-strength-text"></div>
                    </div>

                    <div class="auth-form-group">
                        <label for="confirm_password" class="auth-form-label">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="auth-form-control" required>
                    </div>

                    <div class="auth-form-check">
                        <input type="checkbox" id="terms" name="terms" class="auth-form-check-input" required>
                        <label for="terms" class="auth-form-check-label">I agree to the <a href="<?php echo APP_URL; ?>/terms-and-conditions">Terms and Conditions</a> and <a href="<?php echo APP_URL; ?>/privacy-policy">Privacy Policy</a></label>
                    </div>

                    <button type="submit" class="auth-btn auth-btn-primary">Create Account</button>
                </form>

                <div class="auth-divider">
                    <span>OR</span>
                </div>

                <div class="login-footer">
                    <p>Already have an account? <a href="<?php echo APP_URL; ?>/login">Sign in</a></p>
                </div>
            </div>
        </div>

        <div class="auth-footer">
            <p>&copy; <?php echo date('Y'); ?> Banking System. All rights reserved.</p>
        </div>
    </div>
</div>

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


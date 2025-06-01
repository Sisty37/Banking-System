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
            <p>Sign in to your account</p>
        </div>

        <div class="auth-card">
            <div class="auth-card-header">
                <h2>Login</h2>
                <p>Enter your credentials to access your account</p>
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

                <form action="<?php echo APP_URL; ?>/login" method="POST" id="loginForm">
                    <div class="auth-form-group">
                        <label for="email" class="auth-form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="auth-form-control" value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" required>
                    </div>

                    <div class="auth-form-group">
                        <label for="password" class="auth-form-label">Password</label>
                        <input type="password" id="password" name="password" class="auth-form-control" required>
                    </div>

                    <div class="login-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="<?php echo APP_URL; ?>/forgot-password" class="auth-forgot-password">Forgot Password?</a>
                    </div>

                    <button type="submit" class="auth-btn auth-btn-primary">Sign In</button>
                </form>

                <div class="auth-divider">
                    <span>OR</span>
                </div>

                <div class="login-footer">
                    <p>Don't have an account? <a href="<?php echo APP_URL; ?>/register">Create an account</a></p>
                </div>
            </div>
        </div>

        <div class="auth-footer">
            <p>&copy; <?php echo date('Y'); ?> Banking System. All rights reserved.</p>
        </div>
    </div>
</div>

 
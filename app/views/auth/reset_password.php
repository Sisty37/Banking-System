<?php
// Assume $errors is an array that might be passed from the controller
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$token = $_GET['token'] ?? '';
?>

<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
    <h2>Reset Password</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo APP_URL; ?>/reset-password" method="POST" class="auth-form" id="resetPasswordForm">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
            <span class="error-message" id="password-error"></span>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span class="error-message" id="confirm_password-error"></span>
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
    <p>Remember your password? <a href="<?php echo APP_URL; ?>/login">Login here</a>.</p>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?> 
<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="error-container">
    <div class="error-content">
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Page Not Found</h2>
        <p class="error-message">
            <?php echo !empty($message) ? htmlspecialchars($message) : 'The page you are looking for does not exist or has been moved.'; ?>
        </p>
        <div class="error-actions">
            <a href="<?php echo APP_URL; ?>/" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:history.back()" class="btn btn-outline">Go Back</a>
        </div>
    </div>
</div>

 

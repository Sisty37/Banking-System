<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="error-container">
    <div class="error-content">
        <h1 class="error-code">403</h1>
        <h2 class="error-title">Access Forbidden</h2>
        <p class="error-message">
            <?php echo !empty($message) ? htmlspecialchars($message) : 'You do not have permission to access this page.'; ?>
        </p>
        <div class="error-actions">
            <a href="/" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:history.back()" class="btn btn-outline">Go Back</a>
        </div>
    </div>
</div>

 
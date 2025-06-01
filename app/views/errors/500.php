<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="error-container">
    <div class="error-content">
        <h1 class="error-code">500</h1>
        <h2 class="error-title">Server Error</h2>
        <p class="error-message">
            <?php echo !empty($message) ? htmlspecialchars($message) : 'Something went wrong on our servers. Please try again later.'; ?>
        </p>
        <div class="error-actions">
            <a href="/" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:history.back()" class="btn btn-outline">Go Back</a>
        </div>
    </div>
</div>

 
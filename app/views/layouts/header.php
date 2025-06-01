<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) . ' | ' : ''; ?>Banking System</title>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/variables.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/layout.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/pageStyles.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/modules.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/accounts.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/components.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/dashboard.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/auth.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/userDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<?php 
// Check if current page is admin area
$isAdminPage = strpos($_SERVER['REQUEST_URI'], '/admin') !== false;
$isLoggedIn = isset($_SESSION['user_id']);

// Determine body classes
$bodyClasses = [];
if ($isAdminPage) $bodyClasses[] = 'admin-page';
if ($isLoggedIn) $bodyClasses[] = 'logged-in';
$bodyClassString = !empty($bodyClasses) ? ' class="' . implode(' ', $bodyClasses) . '"' : '';
?>
<body<?php echo $bodyClassString; ?>>
    <?php 
    // Only show header on public pages (not admin area and not logged in)
    if (!$isAdminPage && !$isLoggedIn): 
    ?>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="<?php echo APP_URL; ?>" class="brand">Banking System</a>
                
                <div class="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                
                <nav class="nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="<?php echo APP_URL; ?>" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/' ? 'active' : ''; ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo APP_URL; ?>/contact-us" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/contact-us') !== false ? 'active' : ''; ?>">Contact</a>
                        </li>
                    </ul>
                    
                    <div class="auth-buttons">
                        <a href="<?php echo APP_URL; ?>/login" class="btn btn-outline">Login</a>
                        <a href="<?php echo APP_URL; ?>/register" class="btn btn-primary">Register</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <?php endif; ?>
    
    <?php if (!$isLoggedIn && !$isAdminPage): ?>
    <!-- Main content container for non-logged-in users -->
    <div class="container main-content">
    <?php endif; ?>
    
    <?php if (isset($_SESSION['flash_message'])): ?>
        <?php if ($isLoggedIn && !$isAdminPage): ?>
        <div class="flash-container">
        <?php endif; ?>
            <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?>">
                <?php echo $_SESSION['flash_message']['message']; ?>
                <button class="close-btn">&times;</button>
            </div>
        <?php if ($isLoggedIn && !$isAdminPage): ?>
        </div>
        <?php endif; ?>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>
    
    <?php if (!$isLoggedIn && !$isAdminPage): ?>
    <!-- This div closes the main-content container for non-logged in users -->
    </div>
    <?php endif; ?>

<script>
    // User dropdown toggle
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuTrigger = document.getElementById('userTrigger');
        const userDropdown = document.getElementById('userDropdown');
        
        if (userMenuTrigger && userDropdown) {
            userMenuTrigger.addEventListener('click', function() {
                userDropdown.classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userMenuTrigger.contains(event.target) && !userDropdown.contains(event.target)) {
                    userDropdown.classList.remove('active');
                }
            });
        }
        
        // Mobile menu toggle
        const menuToggle = document.querySelector('.menu-toggle');
        const navList = document.querySelector('.nav-list');
        
        if (menuToggle && navList) {
            menuToggle.addEventListener('click', function() {
                menuToggle.classList.toggle('active');
                navList.classList.toggle('active');
            });
        }
        
        // Alert close button
        const alertCloseButtons = document.querySelectorAll('.alert .close-btn');
        alertCloseButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                this.parentElement.style.display = 'none';
            });
        });
    });
</script> 
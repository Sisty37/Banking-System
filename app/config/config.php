<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'banking_system');

// App Configuration
define('APP_NAME', 'Banking System');
define('APP_URL', 'http://localhost/Banking-System');
define('APP_ROOT', dirname(dirname(__DIR__)));

// Session Configuration
define('SESSION_LIFETIME', 1800); // 30 minutes
define('SESSION_NAME', 'banking_session');

// Security Configuration
define('PASSWORD_HASH_COST', 12); // bcrypt cost factor

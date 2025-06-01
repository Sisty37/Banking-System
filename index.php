<?php
/**
 * Banking System
 * 
 * Main entry point for the application
 */

// Start session
session_start();

// Load configuration
require_once __DIR__ . '/app/config/config.php';

// Load core files
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/core/Controller.php';

// Load helpers
require_once __DIR__ . '/app/helpers/validation_helper.php';

// Include the Router class
require_once __DIR__ . '/app/core/Router.php';

// Initialize router
$router = new Router();

// Process the request
$router->dispatch(); 
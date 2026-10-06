<?php

/**
 * Bike Rental System - Application Entry Point
 * 
 * This file is the main entry point for all requests to the application.
 * It loads the Composer autoloader and initializes the routing system.
 */

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load configuration
$config = require __DIR__ . '/../config/app.php';

// Set error reporting based on environment
if ($config['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Set headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

// Load routes
require_once __DIR__ . '/../routes/api.php';


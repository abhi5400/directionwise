<?php
/**
 * Configuration File
 * Loads environment variables and sets up application configuration
 */

// Load environment variables from .env file
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load .env file
loadEnv(__DIR__ . '/../.env');

// Application Configuration
define('APP_ENV', getenv('APP_ENV') ?: 'development');
define('APP_DEBUG', filter_var(getenv('APP_DEBUG') ?: 'true', FILTER_VALIDATE_BOOLEAN));
define('APP_URL', getenv('APP_URL') ?: 'http://localhost:8000');
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost:8000');

// Database Configuration
define('USE_DB', filter_var(getenv('USE_DB') ?: 'false', FILTER_VALIDATE_BOOLEAN));
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'directionwise');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// Admin Configuration
define('ADMIN_USERNAME', getenv('ADMIN_USERNAME') ?: 'admin');
define('ADMIN_PASSWORD', getenv('ADMIN_PASSWORD') ?: 'changeme');

// Email Configuration
define('SMTP_ENABLED', filter_var(getenv('SMTP_ENABLED') ?: 'false', FILTER_VALIDATE_BOOLEAN));
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.gmail.com');
define('SMTP_PORT', (int)(getenv('SMTP_PORT') ?: 587));
define('SMTP_USER', getenv('SMTP_USER') ?: '');
define('SMTP_PASS', getenv('SMTP_PASS') ?: '');
define('SMTP_FROM', getenv('SMTP_FROM') ?: 'info@directionwisetourism.com');

// Paths
define('ROOT_PATH', dirname(__DIR__));
define('PHP_PATH', __DIR__);
define('DATA_PATH', __DIR__ . '/data');
define('LOGS_PATH', __DIR__ . '/logs');
define('VIEWS_PATH', __DIR__ . '/views');
define('ASSETS_PATH', ROOT_PATH . '/assets');

// Ensure directories exist
if (!is_dir(DATA_PATH)) {
    mkdir(DATA_PATH, 0755, true);
}
if (!is_dir(LOGS_PATH)) {
    mkdir(LOGS_PATH, 0755, true);
}

// Error Reporting
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', LOGS_PATH . '/php-errors.log');
}

// Timezone
date_default_timezone_set('Asia/Dubai');

// Session Configuration
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');
if (!APP_DEBUG) {
    ini_set('session.cookie_secure', '1');
}


<?php
/**
 * Front Controller
 * Entry point for all requests
 */

// Start output buffering for better performance
ob_start();

// Load configuration
require_once __DIR__ . '/php/config.php';

// Load router
require_once __DIR__ . '/php/router.php';

// Flush output
ob_end_flush();


<?php
/**
 * Simple Logger
 * Logs messages to file with rotation
 */

class Logger {
    private $logFile;
    private $maxSize = 10485760; // 10MB

    public function __construct($logFile = null) {
        $this->logFile = $logFile ?: LOGS_PATH . '/app.log';
        
        // Ensure log directory exists
        $dir = dirname($this->logFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    /**
     * Log a message
     */
    public function log($level, $message, $context = []) {
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context) : '';
        $logMessage = "[{$timestamp}] [{$level}] {$message}{$contextStr}" . PHP_EOL;
        
        // Rotate if needed
        if (file_exists($this->logFile) && filesize($this->logFile) > $this->maxSize) {
            $this->rotate();
        }
        
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }

    /**
     * Log info message
     */
    public function info($message, $context = []) {
        $this->log('INFO', $message, $context);
    }

    /**
     * Log error message
     */
    public function error($message, $context = []) {
        $this->log('ERROR', $message, $context);
    }

    /**
     * Log warning message
     */
    public function warning($message, $context = []) {
        $this->log('WARNING', $message, $context);
    }

    /**
     * Rotate log file
     */
    private function rotate() {
        $backup = $this->logFile . '.' . date('Y-m-d');
        if (file_exists($this->logFile)) {
            rename($this->logFile, $backup);
        }
    }
}


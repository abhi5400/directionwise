<?php
/**
 * Simple Rate Limiter
 * Prevents abuse by limiting requests per IP address
 */

class RateLimiter {
    private $limit;
    private $window;
    private $storagePath;

    public function __construct($limit = 10, $window = 60) {
        $this->limit = $limit;
        $this->window = $window; // seconds
        $this->storagePath = sys_get_temp_dir() . '/rate_limit_' . md5(__FILE__);
    }

    /**
     * Check if request is allowed
     */
    public function isAllowed($identifier = null) {
        $identifier = $identifier ?: ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        $key = md5($identifier);
        
        $data = $this->loadData();
        $now = time();
        
        // Clean old entries
        $data = array_filter($data, function($entry) use ($now) {
            return ($now - $entry['time']) < $this->window;
        });
        
        // Count requests in window
        $count = isset($data[$key]) ? count($data[$key]['requests']) : 0;
        
        if ($count >= $this->limit) {
            return false;
        }
        
        // Record this request
        if (!isset($data[$key])) {
            $data[$key] = ['time' => $now, 'requests' => []];
        }
        $data[$key]['requests'][] = $now;
        
        $this->saveData($data);
        return true;
    }

    /**
     * Get remaining requests
     */
    public function getRemaining($identifier = null) {
        $identifier = $identifier ?: ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        $key = md5($identifier);
        
        $data = $this->loadData();
        $now = time();
        
        if (!isset($data[$key])) {
            return $this->limit;
        }
        
        // Clean old requests
        $data[$key]['requests'] = array_filter($data[$key]['requests'], function($time) use ($now) {
            return ($now - $time) < $this->window;
        });
        
        return max(0, $this->limit - count($data[$key]['requests']));
    }

    private function loadData() {
        if (!file_exists($this->storagePath)) {
            return [];
        }
        $content = file_get_contents($this->storagePath);
        return json_decode($content, true) ?: [];
    }

    private function saveData($data) {
        file_put_contents($this->storagePath, json_encode($data));
    }
}


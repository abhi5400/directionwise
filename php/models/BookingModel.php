<?php
/**
 * Booking Model
 * Handles booking data operations (JSON and MySQL support)
 */

class BookingModel {
    private $db = null;
    private $useDb = false;
    private $dataFile;

    public function __construct() {
        $this->useDb = USE_DB;
        $this->dataFile = DATA_PATH . '/bookings.json';

        if ($this->useDb) {
            $this->connectDb();
        }
    }

    /**
     * Connect to MySQL database
     */
    private function connectDb() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->db = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            $this->useDb = false; // Fallback to JSON
        }
    }

    /**
     * Create a new booking
     */
    public function create($data) {
        if ($this->useDb && $this->db) {
            return $this->createInDb($data);
        }
        return $this->createInJson($data);
    }

    /**
     * Get booking by ID
     */
    public function getById($id) {
        if ($this->useDb && $this->db) {
            return $this->getByIdFromDb($id);
        }
        return $this->getByIdFromJson($id);
    }

    /**
     * Get all bookings (admin only)
     */
    public function getAll() {
        if ($this->useDb && $this->db) {
            return $this->getAllFromDb();
        }
        return $this->getAllFromJson();
    }

    // JSON Methods
    private function createInJson($data) {
        $bookings = $this->getAllFromJson();
        
        $booking = [
            'id' => $this->generateId(),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'tour_id' => $data['tour_id'] ?? null,
            'tour_title' => $data['tour_title'] ?? '',
            'date' => $data['date'],
            'guests' => $data['guests'] ?? 1,
            'message' => $data['message'] ?? '',
            'status' => 'pending',
            'created_at' => date('c'),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? ''
        ];

        $bookings[] = $booking;
        file_put_contents($this->dataFile, json_encode($bookings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        
        return $booking;
    }

    private function getAllFromJson() {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        $content = file_get_contents($this->dataFile);
        $bookings = json_decode($content, true);
        return $bookings ?: [];
    }

    private function getByIdFromJson($id) {
        $bookings = $this->getAllFromJson();
        foreach ($bookings as $booking) {
            if (isset($booking['id']) && $booking['id'] === $id) {
                return $booking;
            }
        }
        return null;
    }

    private function generateId() {
        return 'BK' . date('Ymd') . strtoupper(substr(uniqid(), -6));
    }

    // Database Methods
    private function createInDb($data) {
        $bookingId = $this->generateId();
        $stmt = $this->db->prepare("
            INSERT INTO bookings (id, name, email, phone, tour_id, tour_title, 
                date, guests, message, status, ip_address, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, NOW())
        ");
        $stmt->execute([
            $bookingId,
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['tour_id'] ?? null,
            $data['tour_title'] ?? '',
            $data['date'],
            $data['guests'] ?? 1,
            $data['message'] ?? '',
            $_SERVER['REMOTE_ADDR'] ?? ''
        ]);
        
        return $this->getByIdFromDb($bookingId);
    }

    private function getAllFromDb() {
        $stmt = $this->db->query("SELECT * FROM bookings ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    private function getByIdFromDb($id) {
        $stmt = $this->db->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}


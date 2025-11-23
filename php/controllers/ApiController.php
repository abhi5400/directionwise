<?php
/**
 * API Controller
 * Handles API endpoints (booking, etc.)
 */

require_once PHP_PATH . '/models/BookingModel.php';
require_once PHP_PATH . '/models/TourModel.php';
require_once PHP_PATH . '/utils/Logger.php';
require_once PHP_PATH . '/utils/RateLimiter.php';

class ApiController {
    private $bookingModel;
    private $tourModel;
    private $logger;
    private $rateLimiter;

    public function __construct() {
        $this->bookingModel = new BookingModel();
        $this->tourModel = new TourModel();
        $this->logger = new Logger();
        $this->rateLimiter = new RateLimiter(5, 60); // 5 requests per minute
    }

    /**
     * Handle booking submission
     */
    public function book() {
        header('Content-Type: application/json');
        
        // Rate limiting
        if (!$this->rateLimiter->isAllowed()) {
            http_response_code(429);
            echo json_encode([
                'success' => false,
                'message' => 'Too many requests. Please try again later.'
            ]);
            return;
        }
        
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid JSON data'
            ]);
            return;
        }
        
        // Validate required fields
        $errors = $this->validateBooking($input);
        
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'errors' => $errors
            ]);
            return;
        }
        
        // Get tour details if tour_id provided
        $tourTitle = '';
        if (!empty($input['tour_id'])) {
            $tour = $this->tourModel->getById($input['tour_id']);
            if ($tour) {
                $tourTitle = $tour['title'];
            }
        }
        
        // Create booking
        try {
            $booking = $this->bookingModel->create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'tour_id' => $input['tour_id'] ?? null,
                'tour_title' => $tourTitle,
                'date' => $input['date'],
                'guests' => $input['guests'] ?? 1,
                'message' => $input['message'] ?? ''
            ]);
            
            $this->logger->info('Booking created', [
                'booking_id' => $booking['id'],
                'email' => $input['email']
            ]);
            
            // Send email notification if enabled
            if (SMTP_ENABLED) {
                $this->sendBookingEmail($booking);
            }
            
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'booking_id' => $booking['id'],
                'message' => 'Booking submitted successfully. We will contact you soon.'
            ]);
            
        } catch (Exception $e) {
            $this->logger->error('Booking creation failed', [
                'error' => $e->getMessage()
            ]);
            
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }

    /**
     * Validate booking data
     */
    private function validateBooking($data) {
        $errors = [];
        
        if (empty($data['name']) || strlen(trim($data['name'])) < 2) {
            $errors['name'] = 'Name must be at least 2 characters';
        }
        
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Valid email is required';
        }
        
        if (empty($data['phone']) || strlen(trim($data['phone'])) < 10) {
            $errors['phone'] = 'Valid phone number is required';
        }
        
        if (empty($data['date'])) {
            $errors['date'] = 'Date is required';
        } else {
            // Validate date format
            $date = DateTime::createFromFormat('Y-m-d', $data['date']);
            if (!$date || $date->format('Y-m-d') !== $data['date']) {
                $errors['date'] = 'Invalid date format. Use YYYY-MM-DD';
            } else {
                // Check if date is in the future
                $today = new DateTime();
                if ($date < $today) {
                    $errors['date'] = 'Date must be in the future';
                }
            }
        }
        
        if (isset($data['guests']) && (!is_numeric($data['guests']) || $data['guests'] < 1)) {
            $errors['guests'] = 'Number of guests must be at least 1';
        }
        
        return $errors;
    }

    /**
     * Send booking email notification
     */
    private function sendBookingEmail($booking) {
        // Basic email sending (can be enhanced with PHPMailer)
        $to = SMTP_FROM;
        $subject = 'New Booking: ' . $booking['tour_title'];
        $message = "New booking received:\n\n";
        $message .= "Booking ID: " . $booking['id'] . "\n";
        $message .= "Name: " . $booking['name'] . "\n";
        $message .= "Email: " . $booking['email'] . "\n";
        $message .= "Phone: " . $booking['phone'] . "\n";
        $message .= "Tour: " . $booking['tour_title'] . "\n";
        $message .= "Date: " . $booking['date'] . "\n";
        $message .= "Guests: " . $booking['guests'] . "\n";
        if (!empty($booking['message'])) {
            $message .= "Message: " . $booking['message'] . "\n";
        }
        
        $headers = "From: " . SMTP_FROM . "\r\n";
        $headers .= "Reply-To: " . $booking['email'] . "\r\n";
        
        @mail($to, $subject, $message, $headers);
    }
}


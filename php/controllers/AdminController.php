<?php
/**
 * Admin Controller
 * Handles admin panel (optional feature)
 */

require_once PHP_PATH . '/models/TourModel.php';
require_once PHP_PATH . '/models/BookingModel.php';

class AdminController {
    private $tourModel;
    private $bookingModel;

    public function __construct() {
        $this->tourModel = new TourModel();
        $this->bookingModel = new BookingModel();
        $this->checkAuth();
    }

    /**
     * Check authentication
     */
    private function checkAuth() {
        session_start();
        
        // Allow access to login page
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (strpos($currentPath, '/admin/login') !== false || strpos($currentPath, '/admin/logout') !== false) {
            return;
        }
        
        // Check if logged in
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            $this->redirectToLogin();
        }
    }

    /**
     * Admin dashboard
     */
    public function index() {
        $bookings = $this->bookingModel->getAll();
        $tours = $this->tourModel->getAll();
        
        $data = [
            'title' => 'Admin Dashboard - Direction Wise Tourism',
            'bookings' => array_slice($bookings, 0, 10), // Latest 10
            'toursCount' => count($tours),
            'bookingsCount' => count($bookings)
        ];
        
        $this->render('admin', $data);
    }

    /**
     * Login page
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
                session_start();
                $_SESSION['admin_logged_in'] = true;
                header('Location: /admin');
                exit;
            } else {
                $error = 'Invalid credentials';
            }
        }
        
        $data = [
            'title' => 'Admin Login - Direction Wise Tourism',
            'error' => $error ?? null
        ];
        
        $this->render('admin-login', $data);
    }

    /**
     * Logout
     */
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /admin/login');
        exit;
    }

    /**
     * Tours management
     */
    public function tours() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->saveTour();
        }
        
        $tours = $this->tourModel->getAll();
        $tour = null;
        
        if (isset($_GET['id'])) {
            $tour = $this->tourModel->getById($_GET['id']);
        }
        
        $data = [
            'title' => 'Manage Tours - Admin',
            'tours' => $tours,
            'tour' => $tour
        ];
        
        $this->render('admin-tours', $data);
    }

    /**
     * Save tour (create or update)
     */
    private function saveTour() {
        header('Content-Type: application/json');
        
        $tour = [
            'id' => $_POST['id'] ?? null,
            'slug' => $this->slugify($_POST['title'] ?? ''),
            'title' => $_POST['title'] ?? '',
            'excerpt' => $_POST['excerpt'] ?? '',
            'description' => $_POST['description'] ?? '',
            'duration' => $_POST['duration'] ?? '',
            'price_from' => floatval($_POST['price_from'] ?? 0),
            'currency' => $_POST['currency'] ?? 'USD',
            'image' => $_POST['image'] ?? '',
            'image_webp' => $_POST['image_webp'] ?? '',
            'images' => !empty($_POST['images']) ? explode(',', $_POST['images']) : [],
            'tags' => !empty($_POST['tags']) ? explode(',', $_POST['tags']) : []
        ];
        
        if (empty($tour['title'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Title is required']);
            return;
        }
        
        $this->tourModel->save($tour);
        
        echo json_encode(['success' => true, 'message' => 'Tour saved successfully']);
    }

    /**
     * Generate URL-friendly slug
     */
    private function slugify($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        return $text;
    }

    /**
     * Redirect to login
     */
    private function redirectToLogin() {
        header('Location: /admin/login');
        exit;
    }

    /**
     * Render view
     */
    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        require_once VIEWS_PATH . '/layouts/base.php';
    }
}


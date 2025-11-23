<?php
/**
 * Home Controller
 * Handles home page, about, contact, and sitemap
 */

require_once PHP_PATH . '/models/TourModel.php';
require_once PHP_PATH . '/utils/Logger.php';

class HomeController {
    private $tourModel;
    private $logger;

    public function __construct() {
        $this->tourModel = new TourModel();
        $this->logger = new Logger();
    }

    /**
     * Home page
     */
    public function index() {
        $tours = $this->tourModel->getAll();
        $featuredTours = array_slice($tours, 0, 6); // First 6 tours as featured
        
        $data = [
            'title' => 'Direction Wise Tourism - Luxury Tours & VIP Travel Experiences in Dubai & Abu Dhabi',
            'description' => 'Experience luxury tours and VIP travel in Dubai and Abu Dhabi with Direction Wise Tourism. Expert guides, premium services, and unforgettable experiences.',
            'featuredTours' => $featuredTours,
            'allTours' => $tours
        ];
        
        $this->render('home', $data);
    }

    /**
     * About page
     */
    public function about() {
        $data = [
            'title' => 'About Us - Direction Wise Tourism',
            'description' => 'Learn about Direction Wise Tourism, our mission, vision, and our experienced founder Niranjan Singh Shekhawat.'
        ];
        
        $this->render('about', $data);
    }

    /**
     * Contact page
     */
    public function contact() {
        $data = [
            'title' => 'Contact Us - Direction Wise Tourism',
            'description' => 'Get in touch with Direction Wise Tourism. We\'re here to help plan your perfect Dubai and Abu Dhabi experience.'
        ];
        
        $this->render('contact', $data);
    }

    /**
     * Handle contact form submission
     */
    public function contactSubmit() {
        header('Content-Type: application/json');
        
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $message = $_POST['message'] ?? '';
        
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Name is required';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }
        if (empty($message)) {
            $errors[] = 'Message is required';
        }
        
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }
        
        // Log contact form submission
        $this->logger->info('Contact form submitted', [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ]);
        
        // In production, send email here
        echo json_encode(['success' => true, 'message' => 'Thank you for your message. We will get back to you soon.']);
    }

    /**
     * Generate sitemap.xml
     */
    public function sitemap() {
        header('Content-Type: application/xml');
        
        $tours = $this->tourModel->getAll();
        $baseUrl = BASE_URL;
        
        $urls = [
            ['loc' => $baseUrl . '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/contact', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/tours', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ];
        
        foreach ($tours as $tour) {
            $urls[] = [
                'loc' => $baseUrl . '/tour/' . ($tour['slug'] ?? $tour['id']),
                'priority' => '0.8',
                'changefreq' => 'monthly'
            ];
        }
        
        echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        
        foreach ($urls as $url) {
            echo '  <url>' . PHP_EOL;
            echo '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . PHP_EOL;
            echo '    <priority>' . $url['priority'] . '</priority>' . PHP_EOL;
            echo '    <changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
            echo '  </url>' . PHP_EOL;
        }
        
        echo '</urlset>';
    }

    /**
     * Render view
     */
    private function render($view, $data = []) {
        $data['view'] = $view;
        $data['currentPage'] = $view === 'home' ? 'home' : ($view === 'about' ? 'about' : ($view === 'contact' ? 'contact' : 'home'));
        extract($data);
        require_once VIEWS_PATH . '/layouts/base.php';
    }
}


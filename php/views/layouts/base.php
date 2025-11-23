<?php
/**
 * Base Layout Template
 * Main layout wrapper for all pages
 */

// Helper function for LocalBusiness schema
if (!function_exists('getLocalBusinessSchema')) {
    function getLocalBusinessSchema() {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'TravelAgency',
            'name' => 'Direction Wise Tourism LLC',
            'description' => 'Luxury Tours & VIP Travel Experiences in Dubai & Abu Dhabi',
            'url' => BASE_URL,
            'telephone' => '+971528492942',
            'email' => 'info@directionwisetourism.com',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '509, MAKEYA SHARAFI Building, Sharaf DG Metro Station',
                'addressLocality' => 'Bur Dubai',
                'addressCountry' => 'AE'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '25.276987',
                'longitude' => '55.296249'
            ],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens' => '09:00',
                'closes' => '18:00'
            ]
        ];
        
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
}

// Ensure variables are set
$title = $title ?? 'Direction Wise Tourism';
$description = $description ?? 'Luxury Tours & VIP Travel Experiences in Dubai & Abu Dhabi';
$currentPage = $currentPage ?? 'home';

// Get current URL for canonical
$canonical = BASE_URL . $_SERVER['REQUEST_URI'];
if (strpos($canonical, '?') !== false) {
    $canonical = substr($canonical, 0, strpos($canonical, '?'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Primary Meta Tags -->
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta name="title" content="<?php echo htmlspecialchars($title); ?>">
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <meta name="keywords" content="Dubai tours, Abu Dhabi tours, desert safari, luxury travel, UAE tourism, tour guide">
    <meta name="author" content="Direction Wise Tourism">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="og:image" content="<?php echo BASE_URL; ?>/assets/images/og-image.jpg">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo htmlspecialchars($canonical); ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="twitter:image" content="<?php echo BASE_URL; ?>/assets/images/og-image.jpg">
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/main.css">
    
    <!-- JSON-LD Structured Data -->
    <?php
    // LocalBusiness schema (can be overridden in individual pages)
    if (!isset($skipDefaultSchema)) {
        echo getLocalBusinessSchema();
    }
    ?>
</head>
<body>
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    <!-- Header -->
    <header class="header" role="banner">
        <div class="container">
            <nav class="nav" role="navigation" aria-label="Main navigation">
                <div class="nav-brand">
                    <a href="/" class="logo" aria-label="Direction Wise Tourism Home">
                        <span class="logo-text">Direction Wise Tourism</span>
                    </a>
                </div>
                
                <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="nav-menu">
                    <span class="nav-toggle-icon"></span>
                </button>
                
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="/" class="<?php echo $currentPage === 'home' ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="/tours" class="<?php echo $currentPage === 'tours' ? 'active' : ''; ?>">Tours</a></li>
                    <li><a href="/about" class="<?php echo $currentPage === 'about' ? 'active' : ''; ?>">About</a></li>
                    <li><a href="/contact" class="<?php echo $currentPage === 'contact' ? 'active' : ''; ?>">Contact</a></li>
                    <li><a href="/contact#booking" class="btn btn-primary">Book Now</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <!-- Main Content -->
    <main id="main-content" role="main">
        <?php
        // Include the specific view
        $viewFile = VIEWS_PATH . '/' . ($view ?? 'home') . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo '<div class="container"><p>View not found.</p></div>';
        }
        ?>
    </main>
    
    <!-- Footer -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Direction Wise Tourism</h3>
                    <p>Luxury Tours & VIP Travel Experiences in Dubai & Abu Dhabi</p>
                    <p class="footer-tagline">Your trusted partner for unforgettable journeys in the UAE.</p>
                </div>
                
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="/">Home</a></li>
                        <li><a href="/tours">Tours</a></li>
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Contact</h4>
                    <ul class="footer-contact">
                        <li>
                            <strong>Phone:</strong>
                            <a href="tel:+971528492942">+971 52 849 2942</a>
                        </li>
                        <li>
                            <strong>Email:</strong>
                            <a href="mailto:info@directionwisetourism.com">info@directionwisetourism.com</a>
                        </li>
                        <li>
                            <strong>Office:</strong>
                            <address>
                                509, MAKEYA SHARAFI Building<br>
                                Sharaf DG Metro Station<br>
                                Bur Dubai, UAE
                            </address>
                        </li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Follow Us</h4>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook" class="social-link">Facebook</a>
                        <a href="#" aria-label="Instagram" class="social-link">Instagram</a>
                        <a href="#" aria-label="Twitter" class="social-link">Twitter</a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Direction Wise Tourism LLC. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="/assets/js/utils.js" defer></script>
    <script src="/assets/js/lazy-load.js" defer></script>
    <script src="/assets/js/forms.js" defer></script>
    <script src="/assets/js/main.js" defer></script>
    
    <!-- Additional page-specific scripts -->
    <?php if (isset($additionalScripts)): ?>
        <?php foreach ($additionalScripts as $script): ?>
            <script src="<?php echo htmlspecialchars($script); ?>" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>


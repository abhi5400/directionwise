<?php
/**
 * Static Site Generator for GitHub Pages
 * Converts PHP templates to static HTML files
 */

require_once __DIR__ . '/../php/config.php';
require_once __DIR__ . '/../php/models/TourModel.php';

// Output directory for static site
$outputDir = __DIR__ . '/../gh-pages';
$assetsDir = $outputDir . '/assets';

// Create output directories
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}
if (!is_dir($assetsDir)) {
    mkdir($assetsDir, 0755, true);
}

// Copy assets
function copyDirectory($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst, 0755, true);
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            if (is_dir($src . '/' . $file)) {
                copyDirectory($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

echo "Generating static site...\n";

// Copy assets
echo "Copying assets...\n";
$assetsSource = __DIR__ . '/../assets';
if (is_dir($assetsSource)) {
    copyDirectory($assetsSource, $assetsDir);
}

// Load tours data
$tourModel = new TourModel();
$tours = $tourModel->getAll();

// Base URL for GitHub Pages (update this with your actual GitHub Pages URL)
$baseUrl = 'https://abhi5400.github.io/directionwise';

// Function to render a view to HTML
function renderView($viewName, $data = [], $baseUrl = '') {
    ob_start();
    
    // Set up variables for the view
    extract($data);
    $view = $viewName;
    $currentPage = $viewName === 'home' ? 'home' : ($viewName === 'about' ? 'about' : ($viewName === 'contact' ? 'contact' : 'tours'));
    
    // Update paths for static site
    define('VIEWS_PATH', __DIR__ . '/../php/views');
    define('PHP_PATH', __DIR__ . '/../php');
    define('BASE_URL', $baseUrl);
    define('APP_URL', $baseUrl);
    
    // Include base layout
    include VIEWS_PATH . '/layouts/base.php';
    
    $html = ob_get_clean();
    
    // Fix asset paths (remove leading slash for relative paths)
    $html = str_replace('href="/assets/', 'href="assets/', $html);
    $html = str_replace('src="/assets/', 'src="assets/', $html);
    $html = str_replace('url(/assets/', 'url(assets/', $html);
    
    // Fix internal links
    $html = str_replace('href="/"', 'href="index.html"', $html);
    $html = str_replace('href="/home"', 'href="index.html"', $html);
    $html = str_replace('href="/about"', 'href="about.html"', $html);
    $html = str_replace('href="/contact"', 'href="contact.html"', $html);
    $html = str_replace('href="/tours"', 'href="tours.html"', $html);
    
    // Fix API endpoints (these won't work on GitHub Pages)
    // Option 1: Use Formspree (free service for form submissions)
    // Replace YOUR_FORMSPREE_ID with your Formspree form ID after signing up at https://formspree.io
    $formspreeId = getenv('FORMSPREE_ID') ?: 'YOUR_FORMSPREE_ID';
    
    // Booking form - use Formspree or mailto
    if ($formspreeId !== 'YOUR_FORMSPREE_ID') {
        $html = preg_replace('/action="\/api\/book"/', 'action="https://formspree.io/f/' . $formspreeId . '" method="POST"', $html);
        $html = preg_replace('/<input type="hidden" name="[^"]*" value="[^"]*">/', '', $html); // Remove CSRF tokens
    } else {
        // Fallback to mailto if Formspree not configured
        $html = preg_replace('/action="\/api\/book"/', 'action="mailto:info@directionwisetourism.com?subject=Tour Booking Request" method="get"', $html);
    }
    
    // Contact form - use Formspree or mailto
    if ($formspreeId !== 'YOUR_FORMSPREE_ID') {
        $html = preg_replace('/action="\/contact"/', 'action="https://formspree.io/f/' . $formspreeId . '" method="POST"', $html);
    } else {
        $html = preg_replace('/action="\/contact"/', 'action="mailto:info@directionwisetourism.com?subject=Contact Form" method="get"', $html);
    }
    
    return $html;
}

// Generate home page
echo "Generating home page...\n";
$featuredTours = array_slice($tours, 0, 6);
$homeData = [
    'title' => 'Direction Wise Tourism - Luxury Tours & VIP Travel Experiences in Dubai & Abu Dhabi',
    'description' => 'Experience luxury tours and VIP travel in Dubai and Abu Dhabi with Direction Wise Tourism. Expert guides, premium services, and unforgettable experiences.',
    'featuredTours' => $featuredTours,
    'allTours' => $tours
];
$homeHtml = renderView('home', $homeData, $baseUrl);
file_put_contents($outputDir . '/index.html', $homeHtml);

// Generate about page
echo "Generating about page...\n";
$aboutData = [
    'title' => 'About Us - Direction Wise Tourism',
    'description' => 'Learn about Direction Wise Tourism, our mission, vision, and our experienced founder Niranjan Singh Shekhawat.'
];
$aboutHtml = renderView('about', $aboutData, $baseUrl);
file_put_contents($outputDir . '/about.html', $aboutHtml);

// Generate contact page
echo "Generating contact page...\n";
$contactData = [
    'title' => 'Contact Us - Direction Wise Tourism',
    'description' => 'Get in touch with Direction Wise Tourism. We\'re here to help plan your perfect Dubai and Abu Dhabi experience.'
];
$contactHtml = renderView('contact', $contactData, $baseUrl);
file_put_contents($outputDir . '/contact.html', $contactHtml);

// Generate tours listing page
echo "Generating tours listing page...\n";
$toursData = [
    'title' => 'Our Tours - Direction Wise Tourism',
    'description' => 'Explore our collection of luxury tours and experiences in Dubai and Abu Dhabi.',
    'tours' => $tours
];
$toursHtml = renderView('tours', $toursData, $baseUrl);
file_put_contents($outputDir . '/tours.html', $toursHtml);

// Generate individual tour pages
echo "Generating tour detail pages...\n";
if (!is_dir($outputDir . '/tour')) {
    mkdir($outputDir . '/tour', 0755, true);
}

foreach ($tours as $tour) {
    $allTours = $tours;
    $relatedTours = array_filter($allTours, function($t) use ($tour) {
        return $t['id'] != $tour['id'] && 
               isset($tour['tags']) && 
               isset($t['tags']) && 
               !empty(array_intersect($tour['tags'], $t['tags']));
    });
    $relatedTours = array_slice($relatedTours, 0, 3);
    
    $tourData = [
        'title' => $tour['title'] . ' - Direction Wise Tourism',
        'description' => $tour['excerpt'] ?? $tour['title'],
        'tour' => $tour,
        'relatedTours' => $relatedTours
    ];
    
    $tourHtml = renderView('tour-detail', $tourData, $baseUrl);
    
    // Fix tour links in the generated HTML
    $tourSlug = $tour['slug'] ?? 'tour-' . $tour['id'];
    $tourHtml = preg_replace('/href="\/tour\/([^"]+)"/', 'href="tour/$1.html"', $tourHtml);
    
    $filename = $tourSlug . '.html';
    file_put_contents($outputDir . '/tour/' . $filename, $tourHtml);
    echo "  Generated: tour/$filename\n";
}

// Generate sitemap.xml
echo "Generating sitemap.xml...\n";
$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
$sitemap .= '  <url><loc>' . $baseUrl . '/</loc><priority>1.0</priority><changefreq>weekly</changefreq></url>' . "\n";
$sitemap .= '  <url><loc>' . $baseUrl . '/about.html</loc><priority>0.8</priority><changefreq>monthly</changefreq></url>' . "\n";
$sitemap .= '  <url><loc>' . $baseUrl . '/contact.html</loc><priority>0.8</priority><changefreq>monthly</changefreq></url>' . "\n";
$sitemap .= '  <url><loc>' . $baseUrl . '/tours.html</loc><priority>0.9</priority><changefreq>weekly</changefreq></url>' . "\n";

foreach ($tours as $tour) {
    $tourSlug = $tour['slug'] ?? 'tour-' . $tour['id'];
    $sitemap .= '  <url><loc>' . $baseUrl . '/tour/' . $tourSlug . '.html</loc><priority>0.8</priority><changefreq>monthly</changefreq></url>' . "\n";
}

$sitemap .= '</urlset>';
file_put_contents($outputDir . '/sitemap.xml', $sitemap);

// Copy robots.txt
echo "Copying robots.txt...\n";
if (file_exists(__DIR__ . '/../robots.txt')) {
    copy(__DIR__ . '/../robots.txt', $outputDir . '/robots.txt');
}

// Remove README.md if it exists (GitHub Pages will serve it instead of index.html)
if (file_exists($outputDir . '/README.md')) {
    unlink($outputDir . '/README.md');
    echo "Removed README.md from gh-pages (to prevent GitHub Pages from serving it)\n";
}

// Create .nojekyll file (tells GitHub Pages not to process with Jekyll)
file_put_contents($outputDir . '/.nojekyll', '');

echo "\n✅ Static site generated successfully!\n";
echo "📁 Output directory: $outputDir\n";
echo "\n⚠️  IMPORTANT: Update the base URL in this script before deploying!\n";
echo "   Edit scripts/generate-static-site.php and change:\n";
echo "   \$baseUrl = 'https://YOUR_USERNAME.github.io/directionwise';\n";
echo "\n📝 Next steps:\n";
echo "   1. Review the generated files in the 'gh-pages' directory\n";
echo "   2. Update the base URL in this script if needed\n";
echo "   3. Commit and push to GitHub\n";
echo "   4. Enable GitHub Pages in your repository settings\n";


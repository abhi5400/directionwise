<?php
/**
 * Tour Controller
 * Handles tour listing and detail pages
 */

require_once PHP_PATH . '/models/TourModel.php';

class TourController {
    private $tourModel;

    public function __construct() {
        $this->tourModel = new TourModel();
    }

    /**
     * Tours listing page
     */
    public function index() {
        $tours = $this->tourModel->getAll();
        
        // Filter by tag if provided
        $tag = $_GET['tag'] ?? null;
        if ($tag) {
            $tours = array_filter($tours, function($tour) use ($tag) {
                return isset($tour['tags']) && in_array($tag, $tour['tags']);
            });
        }
        
        $data = [
            'title' => 'Our Tours - Direction Wise Tourism',
            'description' => 'Explore our range of luxury tours in Dubai and Abu Dhabi. City tours, desert safaris, adventure activities, and customized itineraries.',
            'tours' => $tours,
            'activeTag' => $tag
        ];
        
        $this->render('tours', $data);
    }

    /**
     * Tour detail page
     */
    public function show($id) {
        // Try to get by ID first, then by slug
        $tour = $this->tourModel->getById($id);
        if (!$tour) {
            $tour = $this->tourModel->getBySlug($id);
        }
        
        if (!$tour) {
            http_response_code(404);
            require_once PHP_PATH . '/controllers/ErrorController.php';
            $errorController = new ErrorController();
            $errorController->notFound();
            return;
        }
        
        // Get related tours
        $allTours = $this->tourModel->getAll();
        $relatedTours = array_filter($allTours, function($t) use ($tour) {
            return $t['id'] != $tour['id'] && 
                   isset($tour['tags']) && 
                   isset($t['tags']) && 
                   !empty(array_intersect($tour['tags'], $t['tags']));
        });
        $relatedTours = array_slice($relatedTours, 0, 3);
        
        $data = [
            'title' => $tour['title'] . ' - Direction Wise Tourism',
            'description' => $tour['excerpt'] ?? $tour['title'],
            'tour' => $tour,
            'relatedTours' => $relatedTours
        ];
        
        $this->render('tour-detail', $data);
    }

    /**
     * Render view
     */
    private function render($view, $data = []) {
        $data['view'] = $view;
        $data['currentPage'] = 'tours';
        extract($data);
        require_once VIEWS_PATH . '/layouts/base.php';
    }
}


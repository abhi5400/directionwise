<?php
/**
 * Error Controller
 * Handles error pages (404, 500, etc.)
 */

class ErrorController {
    /**
     * 404 Not Found
     */
    public function notFound() {
        http_response_code(404);
        $data = [
            'title' => 'Page Not Found - Direction Wise Tourism',
            'description' => 'The page you are looking for could not be found.'
        ];
        $this->render('404', $data);
    }

    /**
     * 500 Internal Server Error
     */
    public function serverError() {
        http_response_code(500);
        $data = [
            'title' => 'Server Error - Direction Wise Tourism',
            'description' => 'An internal server error occurred. Please try again later.'
        ];
        $this->render('500', $data);
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


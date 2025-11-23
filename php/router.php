<?php
/**
 * Simple Router
 * Handles URL routing and dispatches to appropriate controllers
 */

require_once __DIR__ . '/config.php';

class Router {
    private $routes = [];
    private $basePath = '';

    public function __construct($basePath = '') {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Add a route
     */
    public function add($method, $path, $handler) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->basePath . $path,
            'handler' => $handler
        ];
    }

    /**
     * Get current request path
     */
    private function getCurrentPath() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = str_replace($this->basePath, '', $path);
        return $path ?: '/';
    }

    /**
     * Match route pattern
     */
    private function matchRoute($routePath, $requestPath) {
        // Convert route pattern to regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $requestPath, $matches)) {
            array_shift($matches);
            return $matches;
        }
        
        return false;
    }

    /**
     * Dispatch request
     */
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $this->getCurrentPath();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method && $route['method'] !== 'ANY') {
                continue;
            }

            $params = $this->matchRoute($route['path'], $path);
            if ($params !== false) {
                $handler = $route['handler'];
                
                if (is_callable($handler)) {
                    return call_user_func_array($handler, $params);
                } elseif (is_string($handler) && strpos($handler, '@') !== false) {
                    list($controller, $method) = explode('@', $handler);
                    $controllerFile = PHP_PATH . '/controllers/' . $controller . '.php';
                    
                    if (file_exists($controllerFile)) {
                        require_once $controllerFile;
                        $controllerInstance = new $controller();
                        if (method_exists($controllerInstance, $method)) {
                            return call_user_func_array([$controllerInstance, $method], $params);
                        }
                    }
                }
            }
        }

        // 404 Not Found
        http_response_code(404);
        require_once PHP_PATH . '/controllers/ErrorController.php';
        $errorController = new ErrorController();
        $errorController->notFound();
        return;
    }
}

// Initialize router
$router = new Router();

// Define routes
$router->add('GET', '/', 'HomeController@index');
$router->add('GET', '/home', 'HomeController@index');
$router->add('GET', '/tours', 'TourController@index');
$router->add('GET', '/tour/{id}', 'TourController@show');
$router->add('GET', '/about', 'HomeController@about');
$router->add('GET', '/contact', 'HomeController@contact');
$router->add('POST', '/contact', 'HomeController@contactSubmit');
$router->add('POST', '/api/book', 'ApiController@book');
$router->add('GET', '/admin/login', 'AdminController@login');
$router->add('POST', '/admin/login', 'AdminController@login');
$router->add('GET', '/admin/logout', 'AdminController@logout');
$router->add('GET', '/admin', 'AdminController@index');
$router->add('GET', '/admin/tours', 'AdminController@tours');
$router->add('POST', '/admin/tours', 'AdminController@saveTour');
$router->add('GET', '/sitemap.xml', 'HomeController@sitemap');

// Dispatch
$router->dispatch();


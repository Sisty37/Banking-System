<?php
/**
 * Router Class
 * 
 * Handles URL routing to appropriate controllers and methods
 */
class Router {
    private $currentRoute;
    private $params = [];
    private $routes = [];
    private $basePath;

    public function __construct() {
        // Load routes from config file
        $this->routes = require_once __DIR__ . '/../config/routes.php';
        
        // Get the base path from APP_URL
        $parsedUrl = parse_url(APP_URL);
        $this->basePath = isset($parsedUrl['path']) ? rtrim($parsedUrl['path'], '/') : '';
    }

    /**
     * Dispatch the request to the appropriate controller/method
     */
    public function dispatch() {
        // Get the URL
        $url = $this->getUrl();
        
        // Set default route if URL is empty
        if (empty($url)) {
            $url = '/';
        }
        
        // Check if route exists
        if (isset($this->routes[$url])) {
            $this->currentRoute = $this->routes[$url];
            
            // Split into controller and method
            list($controller, $method) = explode('/', $this->currentRoute);
            
            // Check if controller exists
            if (file_exists(__DIR__ . "/../controllers/{$controller}.php")) {
                // Include controller
                require_once __DIR__ . "/../controllers/{$controller}.php";
                
                // Instantiate controller
                $controllerInstance = new $controller();
                
                // Check if method exists
                if (method_exists($controllerInstance, $method)) {
                    // Call method with parameters
                    call_user_func_array([$controllerInstance, $method], $this->params);
                } else {
                    // Method does not exist
                    $this->handleError(404, "Method {$method} not found in controller {$controller}");
                }
            } else {
                // Controller not found
                $this->handleError(404, "Controller {$controller} not found");
            }
        } else {
            // Try to find a matching route pattern if direct match not found
            $matched = false;
            
            // Iterate through routes to find pattern matches
            foreach ($this->routes as $pattern => $handler) {
                // Skip the exact matches as we already checked them
                if ($pattern === $url) {
                    continue;
                }
                
                // Convert route pattern to regex
                $regexPattern = $this->convertRouteToRegex($pattern);
                
                if (preg_match($regexPattern, $url, $matches)) {
                    $this->currentRoute = $handler;
                    
                    // Remove the first match (full match)
                    array_shift($matches);
                    
                    // Set parameters
                    $this->params = $matches;
                    
                    // Split into controller and method
                    list($controller, $method) = explode('/', $handler);
                    
                    // Check if controller exists
                    if (file_exists(__DIR__ . "/../controllers/{$controller}.php")) {
                        // Include controller
                        require_once __DIR__ . "/../controllers/{$controller}.php";
                        
                        // Instantiate controller
                        $controllerInstance = new $controller();
                        
                        // Check if method exists
                        if (method_exists($controllerInstance, $method)) {
                            // Call method with parameters
                            call_user_func_array([$controllerInstance, $method], $this->params);
                            $matched = true;
                            break;
                        }
                    }
                }
            }
            
            // If no route matched, show 404
            if (!$matched) {
                // Route not found
                $this->handleError(404, "Route {$url} not found");
            }
        }
    }
    
    /**
     * Convert a route pattern to a regular expression
     * 
     * @param string $route
     * @return string
     */
    private function convertRouteToRegex($route) {
        // Escape forward slashes
        $route = str_replace('/', '\/', $route);
        
        // Convert parameters like :id to capture groups
        $route = preg_replace('/\:([a-zA-Z0-9_]+)/', '([^\/]+)', $route);
        
        // Add start and end markers
        return '/^' . $route . '$/';
    }
    
    /**
     * Get the URL from the server
     * 
     * @return string
     */
    private function getUrl() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = rtrim($_SERVER['REQUEST_URI'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            
            // Remove query string if present
            if (strpos($url, '?') !== false) {
                $url = substr($url, 0, strpos($url, '?'));
            }
            
            // Remove base path from URL if it exists
            if (!empty($this->basePath) && strpos($url, $this->basePath) === 0) {
                $url = substr($url, strlen($this->basePath));
            }
            
            // If URL is empty after removing base path, return '/'
            return $url ?: '/';
        }
        
        return '/';
    }
    
    /**
     * Handle errors by loading error views
     * 
     * @param int $code Error code
     * @param string $message Error message
     */
    private function handleError($code, $message) {
        http_response_code($code);
        
        // Include ErrorController if it exists
        if (file_exists(__DIR__ . "/../controllers/ErrorController.php")) {
            require_once __DIR__ . "/../controllers/ErrorController.php";
            $errorController = new ErrorController();
            
            switch ($code) {
                case 404:
                    $errorController->notFound($message);
                    break;
                case 403:
                    $errorController->forbidden($message);
                    break;
                default:
                    $errorController->serverError($message);
            }
        } else {
            // Fallback error display
            echo "Error {$code}: {$message}";
        }
        
        exit();
    }
} 
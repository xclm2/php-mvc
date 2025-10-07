<?php
declare(strict_types=1);

namespace App\Framework;

use Exception;

/**
 * Router Class
 * 
 * Handles HTTP routing and static file serving for the application.
 * Supports GET, POST, PUT, and DELETE HTTP methods and manages route matching
 * with corresponding controller actions.
 */
abstract class Router
{
    /**
     * @var string Directory path for static files
     */
    private const PUBLIC_PATH = '/public';

    /**
     * @var array Stores registered routes with their HTTP methods and controllers
     */
    protected array $_routes = [];

    /**
     * Registers a new route with the specified HTTP method
     *
     * @param string $path       The URL path to match
     * @param string $controller The controller in format 'ControllerClass@methodName'
     * @param string $method     The HTTP method (GET, POST, PUT, DELETE)
     * @throws Exception If HTTP method is not supported
     */
    public function add(string $path, string $controller, string $method = 'GET')
    {
        // Convert method to uppercase for consistency
        $method = strtoupper($method);
        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            throw new Exception("Unsupported HTTP method: {$method}");
        }

        $path = rtrim($path, '/');
        $this->_routes[$method][$path] = [
            'controller' => $controller, 
            'method' => $method
        ];
    }

    /**
     * Registers a GET route
     *
     * @param string $path       The URL path to match
     * @param string $controller The controller in format 'ControllerClass@methodName'
     */
    public function get(string $path, string $controller)
    {
        $this->add($path, $controller, 'GET');
    }

    /**
     * Registers a POST route
     *
     * @param string $path       The URL path to match
     * @param string $controller The controller in format 'ControllerClass@methodName'
     */
    public function post(string $path, string $controller)
    {
        $this->add($path, $controller, 'POST');
    }

    /**
     * Matches the current request path to registered routes
     * Also handles static file serving from public directory
     *
     * @param string $path    The current request path
     * @param mixed  $request Optional request object to pass to controllers
     */
    abstract public function match ($path, $request = null);

    /**
     * Extracts the controller class and method from the route definition
     *
     * @param string $controller The controller in format 'ControllerClass@methodName'
     * @return array An array containing the controller instance and method name
     * @throws Exception If the controller or method does not exist
     */
    protected function _extractControllerMethod($controller)
    {
        $parts = explode('@', $controller);
        
        if (count($parts) !== 2) {
            throw new Exception("Invalid route controller format.");
        }

        $class = $parts[0];
        $method = $parts[1];
        $controller = new $class();

        if (! method_exists($controller, $method)) {
            throw new Exception("Method not exist in {$class}.");
        }

        return [$controller, $method];
    }

    /**
     * Reads and serves static files from the public directory
     *
     * @param string $path The requested file path
     */
    protected function _readStyles($path)
    {
        if (str_starts_with($path, self::PUBLIC_PATH)) {
            $file = __ROOT__ . $path;
            if (file_exists($file) && is_readable($file)) {
                
                header("Content-Type: {$this->_getMimeType($file)}");
                readfile($file);
                exit;
            } else {
                http_response_code(404);
                echo "404 Not Found: Resource {$path} not found.";
                exit;
            }
        }
    }

    /**
     * Determines the MIME type of a file based on its extension
     *
     * @param string $file The file path
     * @return string The MIME type of the file
     */
    private function _getMimeType($file)
    {
        $mimeType = mime_content_type($file);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if ($ext === 'css') {
            $mimeType = 'text/css';
        } elseif ($ext === 'js' || $ext === 'jsx') {
            $mimeType = 'application/javascript';
        } elseif ($ext === 'png') {
            $mimeType = 'image/png';
        } elseif ($ext === 'jpg' || $ext === 'jpeg') {
            $mimeType = 'image/jpeg';
        } elseif ($ext === 'gif') {
            $mimeType = 'image/gif';
        }

        return $mimeType;
    }
}